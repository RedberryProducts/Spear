<?php

namespace Redberry\Spear\Tests;

use Exception;
use Redberry\Spear\Facades\Spear;
use Tests\TestCase;

class PythonHandlerTest extends TestCase
{
	private string $rightCodeWithoutInput = 'print("hello world!")';

	private string $wrongCodeWithoutInput = 'prit"hello world!")';

	private string $rightCodeWithInput = "num = int(input())\nprint(num*2)";

	public function test_python_default_version_code_is_working_without_input(): void
	{
		$data = Spear::python()->execute($this->rightCodeWithoutInput);

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('hello world!', $data->getOutput());
	}

	public function test_python_3_7_code_is_working(): void
	{
		$data = Spear::python('3.7')->execute($this->rightCodeWithoutInput);

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('hello world!', $data->getOutput());
	}

	public function test_python_3_8_code_is_working(): void
	{
		$data = Spear::python('3.8')->execute($this->rightCodeWithoutInput);

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('hello world!', $data->getOutput());
	}

	public function test_python_3_9_code_is_working(): void
	{
		$data = Spear::python('3.9')->execute($this->rightCodeWithoutInput);

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('hello world!', $data->getOutput());
	}

	public function test_python_3_10_code_is_working(): void
	{
		$data = Spear::python('3.10')->execute($this->rightCodeWithoutInput);

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('hello world!', $data->getOutput());
	}

	public function test_python_3_11_rc_code_is_working(): void
	{
		$data = Spear::python('3.11-rc')->execute($this->rightCodeWithoutInput);

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('hello world!', $data->getOutput());
	}

	public function test_python_default_version_code_has_syntax_errors(): void
	{
		$data = Spear::python()->execute($this->wrongCodeWithoutInput);

		$this->assertNotEquals(0, $data->getResultCode());
	}

	public function test_python_3_7_code_has_syntax_errors(): void
	{
		$data = Spear::python('3.7')->execute($this->wrongCodeWithoutInput);

		$this->assertNotEquals(0, $data->getResultCode());
	}

	public function test_python_3_8_code_has_syntax_errors(): void
	{
		$data = Spear::python('3.8')->execute($this->wrongCodeWithoutInput);

		$this->assertNotEquals(0, $data->getResultCode());
	}

	public function test_python_3_9_code_has_syntax_errors(): void
	{
		$data = Spear::python('3.9')->execute($this->wrongCodeWithoutInput);

		$this->assertNotEquals(0, $data->getResultCode());
	}

	public function test_python_3_10_code_has_syntax_errors(): void
	{
		$data = Spear::python('3.10')->execute($this->wrongCodeWithoutInput);

		$this->assertNotEquals(0, $data->getResultCode());
	}

	public function test_python_3_11_rc_code_has_syntax_errors(): void
	{
		$data = Spear::python('3.11-rc')->execute($this->wrongCodeWithoutInput);

		$this->assertNotEquals(0, $data->getResultCode());
	}

	public function test_python_with_incorrect_version(): void
	{
		$this->expectException(Exception::class);
		Spear::node('3.12')->execute($this->wrongCodeWithoutInput);
	}

	public function test_python_code_works_fine_with_input(): void
	{
		$data = Spear::python()->execute($this->rightCodeWithInput, '500');

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('1000', $data->getOutput());
	}
}
