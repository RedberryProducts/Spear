<?php

namespace Redberry\Spear\Handlers;

use Exception;
use Redberry\Spear\Facades\Docker;
use Redberry\Spear\Facades\Request;
use Redberry\Spear\Interfaces\Data;
use Redberry\Spear\DataStructures\Data as OutputData;

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
	protected string $compiler;

	/**
	 * The compiled file name.
	 */
	protected string $compiledFile;

	/**
	 * The interpreter program.
	 */
	protected string $interpreter;

	/**
	 * Timeout for the program to run.
	 */
	protected int $timeout = 3;

	/**
	 * Executor with which the compiled file should be executed.
	 */
	protected string $executor;

	/**
	 * The filename which will be used by interpretators.
	 */
	protected string $fileToInterpret;

	/**
	 *  The filename which will be used by compilation.
	 */
	protected string $fileToCompiler;

	/**
	 * Set default properties.
	 */
	public function __construct()
	{
		$this->fileToInterpret = 'program.run';
		$this->fileToCompiler = 'program.run';
	}

	/**
	 * Set docker image to use for container creation.
	 */
	public function setImage(string $image = '')
	{
		$this->image = $image;
	}

	/**
	 * Set file name for interpretation.
	 */
	public function setFileToInterpret(string $fileName)
	{
		$this->fileToInterpret = $fileName;
	}

	/**
	 * Set file name for compilation.
	 */
	public function setFileToComplile(string $filename)
	{
		$this->fileToCompiler = $filename;
	}

	/**
	 * Set code to execute.
	 */
	public function setCode(string $code = '')
	{
		$this->code = $code;
	}

	/**
	 * Set input to execute program.
	 */
	public function setInput(string $input = '')
	{
		$this->input = $input;
	}

	/**
	 * Set compiler execution command.
	 */
	public function setCompliler(string $compiler = '')
	{
		$this->compiler = $compiler;
	}

	/**
	 * Set command to execution compiled script.
	 */
	public function setExecutor(string $executor)
	{
		$this->executor = $executor;
	}

	/**
	 * Set interpreter to execute the script.
	 */
	public function setInterpreter(string $interpreter)
	{
		$this->interpreter = $interpreter;
	}

	/**
	 * Set the file name of the executable program.
	 */
	public function setCompiledFile(string $name): void
	{
		$this->compiledFile = $name;
	}

	/**
	 * Pass the execution data to the docker container and then execute the script.
	 */
	public function interpret()
	{
		$script = $this->prepareScriptForInterpretation();
		$output = [];
		$resultCode = 0;

		$this->runInDocker($script, $output, $resultCode);

		return $this->formatOutput($output, $resultCode);
	}

	/**
	 * when there aren't compilable output compilable result code
	 * creates new docker, run it and returns formatted docker.
	 */
	public function compileAndRun(): Data
	{
		$compilableOutput = [];
		$compilableResultCode = 0;

		if (!$this->compilable($compilableOutput, $compilableResultCode))
		{
			return $this->formatOutput($compilableOutput, $compilableResultCode);
		}

		$script = $this->prepareCompileAndRunScript();
		$output = [];
		$resultCode = 0;

		$this->runInDocker($script, $output, $resultCode);

		return $this->formatOutput($output, $resultCode);
	}

	/**
	 * Format and normalize return data from docker.
	 */
	private function formatOutput(array $output, int $resultCode): Data
	{
		$data = new OutputData();
		$data->setResultCode($resultCode);

		if ($resultCode !== 0)
		{
			$data->setErrorMessage(implode("\n", $output));
		}
		else
		{
			$data->setOutput(implode("\n", $output));
		}

		return $data;
	}

	/**
	 * Determine if code compilation is successful.
	 */
	private function compilable(array &$output = [], int &$resultCode = 0): bool
	{
		$resultCode = 0;
		$this->runInDocker($this->prepareTestForCompilationCommand(), $output, $resultCode);

		return $resultCode === 0;
	}

	/**
	 * Prepare a script to determine if code is compilable.
	 */
	private function prepareTestForCompilationCommand()
	{

		$encodedScript = base64_encode($this->code);

		return <<<END
            echo $encodedScript | base64 -d > $this->fileToCompiler;
            $this->compiler $this->fileToCompiler;
        END;
	}

	/**
	 * Build the script to run compiled code.
	 */
	private function prepareCompileAndRunScript(): string
	{
		$encodedCode = base64_encode($this->code);
		$timeout = $this->timeout . 's';

		$executor = isset($this->executor) ? $this->executor . ' ' : './';
		$executeCommand = $executor . $this->compiledFile;

		if ($this->input !== '')
		{
			$encodedInput = base64_encode($this->input);

			return <<<END
                echo $encodedCode | base64 -d > $this->fileToCompiler;
                $this->compiler $this->fileToCompiler;
                echo $encodedInput | base64 -d | timeout $timeout $executeCommand; 
            END;
		}

		return <<<END
            echo $encodedCode | base64 -d > $this->fileToCompiler;
            $this->compiler $this->fileToCompiler;
            timeout $timeout $executeCommand; 
        END;
	}

	/**
	 * Encode the code and the input to pass it to the docker container as parameters.
	 */
	private function prepareScriptForInterpretation()
	{
		$encodedCode = base64_encode($this->code);

		$timeout = $this->timeout . 's';

		if ($this->input !== '')
		{
			$encodedInput = base64_encode($this->input);
			return <<<END
                echo $encodedCode | base64 -d > $this->fileToInterpret;
                echo $encodedInput | base64 -d | timeout $timeout $this->interpreter $this->fileToInterpret; 
            END;
		}

		return <<<END
            echo $encodedCode | base64 -d > $this->fileToInterpret;
            timeout $timeout $this->interpreter $this->fileToInterpret; 
        END;
	}

	/**
	 * Run prepared command in the docker container.
	 *
	 * @throws Exception
	 */
	private function runInDocker(string $command = '', array &$output = [], int &$resultCode = 0)
	{
		$imageLocally = Docker::imageExistsLocally($this->image);
		if (!$imageLocally)
		{
			throw new Exception("Image $this->image does not exist locally, please pull the image before using it.");
		}

		$container = Request::post('/containers/create', [
			'Image'      => $this->image,
			'Cmd'        => [
				'sh',
				'-c',
				$command,
			],
			'HostConfig' => [
				'Binds' => [
					'/tmp:/tmp',
				],
			],
			'AttachStdin' => true,
			'Tty'         => true,
		]);
		Request::post("/containers/$container->Id/start");
		$data = Request::post("/containers/$container->Id/wait");
		$output = Request::get("/containers/$container->Id/logs?stdout=true");
		$resultCode = $data->StatusCode;
		$output = gettype($output) === 'string' ? $output = [$output] : $output = [$output->data];
	}
}
