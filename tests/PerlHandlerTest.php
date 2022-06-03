<?php

namespace Redberry\Spear\Tests;

use Redberry\Spear\Facades\Spear;
use Orchestra\Testbench\TestCase;

class PerlHandlerTest extends TestCase
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

	private string $rightCodeWithoutInput = <<<END
        print("Hello, World!\n");
    END;

	private string $wrongCodeWithoutInput = <<<END
        printHello, World!\n");
    END;

	private string $rightCodeWithInput = <<<'END'
        $number = <>;
        chomp($number);
        print($number + 100,"\n");
    END;

	public function test_perl_code_is_working_without_input(): void
	{
		$data = Spear::perl()->execute($this->rightCodeWithoutInput);

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('Hello, World!', $data->getOutput());
	}

	public function test_perl_code_has_syntax_errors(): void
	{
		$data = Spear::perl()->execute($this->wrongCodeWithoutInput);

		$this->assertNotEquals(0, $data->getResultCode());
	}

	public function test_perl_code_works_fine_with_input(): void
	{
		$data = Spear::perl()->execute($this->rightCodeWithInput, 75);

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('175', $data->getOutput());
	}
}
