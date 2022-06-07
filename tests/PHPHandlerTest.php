<?php

namespace Redberry\Spear\Tests;

use Exception;
use Redberry\Spear\Facades\Spear;
use Tests\TestCase;

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
        $data = + readline();
        echo $data / 2;
    END;

	public function test_php_code_is_working_without_input(): void
	{
		$data = Spear::php()->execute($this->rightCodeWithoutInput);
		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('hello world!', $data->getOutput());
	}

	public function test_php_8_code_is_working_without_input(): void
	{
		$data = Spear::php('8')->execute($this->rightCodeWithoutInput);
		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('hello world!', $data->getOutput());
	}

	public function test_php_with_incorrect_version(): void
	{
		$this->expectException(Exception::class);
		Spear::node('10')->execute($this->wrongCodeWithoutInput);
	}

	public function test_php_code_has_syntax_errors(): void
	{
		$data = Spear::php()->execute($this->wrongCodeWithoutInput);

		$this->assertNotEquals(0, $data->getResultCode());
	}

	public function test_php_8_code_has_syntax_errors(): void
	{
		$data = Spear::php('8')->execute($this->wrongCodeWithoutInput);

		$this->assertNotEquals(0, $data->getResultCode());
	}

	public function test_php_code_works_fine_with_input(): void
	{
		$data = Spear::php()->execute($this->rightCodeWithInput, '500');

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('250', $data->getOutput());
	}
}
