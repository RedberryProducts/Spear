<?php

namespace Giunashvili\Spear\Tests\Languages;

use Giunashvili\Spear\Spear;
use PHPUnit\Framework\TestCase;

class PHPHandlerTest extends TestCase
{
    private string $rightCodeWithoutInput = <<<END
        <?php 
        echo "hello world!";
    END;

    private string $wrongCodeWithoutInput = <<<END
        <?php
        var_dum'hello world!');
    END;

    private string $rightCodeWithInput = <<<'END'
        <?php

        $file = fopen('php://stdin', 'r');
        $data = +trim(fgets($file));

        echo $data / 2;
    END;

    public function test_php_code_is_working_without_input(): void
    {
        $spear = new Spear('php:8.1');
        $data = $spear->execute($this->rightCodeWithoutInput);
        $this->assertEquals(0, $data->getResultCode());
        $this->assertEquals('hello world!', $data->getOutput());
    }

    public function test_php_code_has_syntax_errors(): void
    {
        $spear = new Spear('php:8.1');
        $data = $spear->execute($this->wrongCodeWithoutInput);

        $this->assertNotEquals(0, $data->getResultCode());
    }

    public function test_php_code_works_fine_with_input(): void
    {
        $spear = new Spear('php:8.1');
        $data = $spear->execute($this->rightCodeWithInput, '500');
        
        $this->assertEquals(0, $data->getResultCode());
        $this->assertEquals('250', $data->getOutput());
    }
}