<?php

namespace Redberry\Spear\Tests;

use Exception;
use Redberry\Spear\Facades\Spear;
use Tests\TestCase;

class PerlHandlerTest extends TestCase
{
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
		exec('docker pull perl:5.34');

		$data = Spear::perl()->execute($this->rightCodeWithoutInput);

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('Hello, World!', $data->getOutput());
	}

	public function test_perl_default_version_code_works_fine_with_input(): void
	{
		exec('docker pull perl:5.34');

		$data = Spear::perl()->execute($this->rightCodeWithInput, 75);

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('175', $data->getOutput());
	}

	public function test_perl_5_code_works_fine_with_input(): void
	{
		exec('docker pull perl:5');

		$data = Spear::perl('5')->execute($this->rightCodeWithInput, 75);

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('175', $data->getOutput());
	}

	public function test_perl_5_34_code_works_fine_with_input(): void
	{
		exec('docker pull perl:5.34');

		$data = Spear::perl('5.34')->execute($this->rightCodeWithInput, 75);

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('175', $data->getOutput());
	}

	public function test_perl_default_version_code_has_syntax_errors(): void
	{
		exec('docker pull perl:5.34');

		$data = Spear::perl()->execute($this->wrongCodeWithoutInput);

		$this->assertNotEquals(0, $data->getResultCode());
	}

	public function test_perl_5_code_has_syntax_errors(): void
	{
		exec('docker pull perl:5');

		$data = Spear::perl('5')->execute($this->wrongCodeWithoutInput);

		$this->assertNotEquals(0, $data->getResultCode());
	}

	public function test_perl_5_34_code_has_syntax_errors(): void
	{
		exec('docker pull perl:5.34');

		$data = Spear::perl('5.34')->execute($this->wrongCodeWithoutInput);

		$this->assertNotEquals(0, $data->getResultCode());
	}

	public function test_perl_with_incorrect_version(): void
	{
		$this->expectException(Exception::class);
		Spear::node('10')->execute($this->rightCodeWithInput);
	}

	public function test_when_perl_default_version_image_not_pulled()
	{
		exec("docker rmi --force $(docker images | grep 'perl') >/dev/null 2>&1");
		$this->expectException(Exception::class);
		Spear::perl()->execute($this->rightCodeWithoutInput);
	}

	public function test_when_perl_5_image_not_pulled()
	{
		exec("docker rmi --force $(docker images | grep 'perl') >/dev/null 2>&1");
		$this->expectException(Exception::class);
		Spear::perl('5')->execute($this->rightCodeWithoutInput);
	}

	public function test_when_perl_5_34_image_not_pulled()
	{
		exec("docker rmi --force $(docker images | grep 'perl') >/dev/null 2>&1");
		$this->expectException(Exception::class);
		Spear::perl('5.34')->execute($this->rightCodeWithoutInput);
	}
}
