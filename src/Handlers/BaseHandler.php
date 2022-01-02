<?php

namespace Giunashvili\Spear\Handlers;

use Giunashvili\Spear\Interfaces\Data;

use Giunashvili\Spear\DataStructures\Data as OutputData;

class BaseHandler
{
    /**
     * Docker image, with which the 
     * code should be executed.
     */
    protected string $image;

    /**
     * The code which should be executed.
     */
    protected string $code;

    /**
     * The input that should be passed 
     * to the program.
     */
    protected string $input;

    /**
     * The compiler program.
     */
    protected string $compiler; // g++ -x c++

    /**
     * The interpreter program.
     */
    protected string $interpreter;

    /**
     * Timeout for the program to run.
     */
    protected int $timeout = 3;
    

    public function setImage(string $image = '')
    {
        $this->image = $image;
    }

    public function setCode(string $code = '')
    {
        $this->code = $code;
    }

    public function setInput(string $input = '')
    {
        $this->input = $input;
    }

    public function setCompliler(string $compiler = '')
    {
        $this->compiler = $compiler;
    }

    public function setInterpreter(string $interpreter)
    {
        $this->interpreter = $interpreter;
    }

    public function interpret()
    {
        $script = $this->prepareScriptForInterpretation();
        $output = [];
        $resultCode = 0;

        $this->runInDocker($script, $output, $resultCode);

        return $this->formatOutput($output, $resultCode);
    }

    public function compileAndRun(): Data
    {
        $compilableOutput = [];
        $compilableResultCode = 0;

        if(!$this->compilable($compilableOutput, $compilableResultCode))
        {
            return $this->formatOutput($compilableOutput, $compilableResultCode);
        }

        $script = $this->prepareCompileAndRunScript();
        $output = [];
        $resultCode = 0;

        $this->runInDocker($script, $output, $resultCode);

        return $this->formatOutput($output, $resultCode);
    }

    private function formatOutput(array $output, int $resultCode): Data
    {
        $data = new OutputData();
        $data->setResultCode($resultCode);
        
        if($resultCode !== 0)
        {
            $data->setErrorMessage(implode("\n", $output));
        }
        else
        {
            $data->setOutput(implode("\n", $output));
        }

        return $data;
    }

    private function compilable(array &$output = [], int &$resultCode = 0): bool
    {
        $resultCode = 0;
        $this->runInDocker($this->prepareTestForCompilationCommand(), $output, $resultCode);
        return $resultCode === 0;
    }

    private function prepareTestForCompilationCommand()
    {
        $encodedScript = base64_encode($this->code);

        return <<<END
            echo $encodedScript | base64 -d > program.run;
            $this->compiler program.run;
        END;
    }

    private function prepareCompileAndRunScript(): string
    {
        $encodedCode = base64_encode($this->code);
        $timeout = $this->timeout . 's';
        
        if ($this->input !== '')
        {
            $encodedInput = base64_encode($this->input);            
            return <<<END
                echo $encodedCode | base64 -d > program.run;
                $this->compiler program.run;
                echo $encodedInput | base64 -d | timeout $timeout ./a.out; 
            END;
        }

        return <<<END
            echo $encodedCode | base64 -d > program.run;
            $this->compiler program.run;
            timeout $timeout ./a.out; 
        END;
    }

    private function prepareScriptForInterpretation()
    {
        $encodedCode = base64_encode($this->code);
        $timeout = $this->timeout . 's';
        
        if ($this->input !== '')
        {
            $encodedInput = base64_encode($this->input);

            return <<<END
                echo $encodedCode | base64 -d > program.run;
                echo $encodedInput | base64 -d | timeout $timeout $this->interpreter program.run; 
            END;
        }

        return <<<END
            echo $encodedCode | base64 -d > program.run;
            timeout $timeout $this->interpreter program.run; 
        END;
    }

    private function runInDocker(string $command = '', array &$output = [], int &$resultCode = 0 )
    {
        $command = base64_encode($command);
        $executableCommand = "echo $command | base64 -di | docker run -i --rm -w /app $this->image sh 2>&1";
        exec($executableCommand, $output, $resultCode);
    }
}