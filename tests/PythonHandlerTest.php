<?php

namespace Redberry\Spear\Tests;

use Redberry\Spear\Facades\Spear;
use Orchestra\Testbench\TestCase;

class PythonHandlerTest extends TestCase
{
	/**
	 * Get package providers.
	 *
	 * @param \Illuminate\Foundation\Application $app
	 *
	 * @return array
	 */
	protected function getPackageProviders($app)
	{
		return [
			'Redberry\Spear\ServiceProvider',
		];
	}

	private string $rightCodeWithoutInput = 'print("hello world!")';

	private string $wrongCodeWithoutInput = 'prit"hello world!")';

	private string $rightCodeWithInput = "num = int(input())\nprint(num*2)";

	public function test_python_code_is_working_without_input(): void
	{
		$data = Spear::python()->execute($this->rightCodeWithoutInput);

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('hello world!', $data->getOutput());
	}

	public function test_python_code_has_syntax_errors(): void
	{
		$data = Spear::python()->execute($this->wrongCodeWithoutInput);

		$this->assertNotEquals(0, $data->getResultCode());
	}

	public function test_python_code_works_fine_with_input(): void
	{
		$data = Spear::python()->execute($this->rightCodeWithInput, '500');

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('1000', $data->getOutput());
	}
}
