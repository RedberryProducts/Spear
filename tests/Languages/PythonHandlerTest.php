<?php

namespace Giunashvili\Spear\Tests\Languages;

use Giunashvili\Spear\Spear;
use PHPUnit\Framework\TestCase;

class PythonHandlerTest extends TestCase
{
	private string $rightCodeWithoutInput = 'print("hello world!")';

	private string $wrongCodeWithoutInput = 'prit"hello world!")';

	private string $rightCodeWithInput = "num = int(input())\nprint(num*2)";

	public function test_python_code_is_working_without_input(): void
	{
		$spear = new Spear;
		$spear->handler(Spear::PYTHON_3);
		$data = $spear->execute($this->rightCodeWithoutInput);

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('hello world!', $data->getOutput());
	}

	public function test_python_code_has_syntax_errors(): void
	{
		$spear = new Spear;
		$spear->handler(Spear::PYTHON_3);
		$data = $spear->execute($this->wrongCodeWithoutInput);

		$this->assertNotEquals(0, $data->getResultCode());
	}

	public function test_python_code_works_fine_with_input(): void
	{
		$spear = new Spear;
		$spear->handler(Spear::PYTHON_3);
		$data = $spear->execute($this->rightCodeWithInput, '500');

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('1000', $data->getOutput());
	}
}
