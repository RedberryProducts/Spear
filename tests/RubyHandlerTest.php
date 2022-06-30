<?php

namespace Redberry\Spear\Tests;

use Exception;
use Redberry\Spear\Facades\Spear;
use Tests\TestCase;

class RubyHandlerTest extends TestCase
{
	private string $rightCodeWithoutInput = <<<END
        puts "Hello World!"
    END;

	private string $wrongCodeWithoutInput = <<<END
        puts'hello world!');
    END;

	private string $rightCodeWithInput = <<<'END'
        x = ARGF.read
        puts x.to_i * 20
    END;

	public function test_ruby_default_version_code_is_working_without_input(): void
	{
		exec('docker pull ruby:3');

		$data = Spear::ruby()->execute($this->rightCodeWithoutInput);
		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('Hello World!', $data->getOutput());
	}

	public function test_ruby_2_code_is_working(): void
	{
		exec('docker pull ruby:2');

		$data = Spear::ruby('2')->execute($this->rightCodeWithoutInput);
		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('Hello World!', $data->getOutput());
	}

	public function test_ruby_3_code_is_working(): void
	{
		exec('docker pull ruby:3');

		$data = Spear::ruby('3')->execute($this->rightCodeWithoutInput);
		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('Hello World!', $data->getOutput());
	}

	public function test_ruby_3_1_code_is_working(): void
	{
		exec('docker pull ruby:3.1');

		$data = Spear::ruby('3.1')->execute($this->rightCodeWithoutInput);
		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('Hello World!', $data->getOutput());
	}

	public function test_ruby_3_2_rc_code_is_working(): void
	{
		exec('docker pull ruby:3.2-rc');

		$data = Spear::ruby('3.2-rc')->execute($this->rightCodeWithoutInput);
		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('Hello World!', $data->getOutput());
	}

	public function test_ruby_default_version_code_has_syntax_errors(): void
	{
		exec('docker pull ruby:3');

		$data = Spear::ruby()->execute($this->wrongCodeWithoutInput);
		$this->assertNotEquals(0, $data->getResultCode());
	}

	public function test_ruby_2_code_has_syntax_errors(): void
	{
		exec('docker pull ruby:2');

		$data = Spear::ruby('2')->execute($this->wrongCodeWithoutInput);
		$this->assertNotEquals(0, $data->getResultCode());
	}

	public function test_ruby_3_code_has_syntax_errors(): void
	{
		exec('docker pull ruby:3');

		$data = Spear::ruby('3')->execute($this->wrongCodeWithoutInput);
		$this->assertNotEquals(0, $data->getResultCode());
	}

	public function test_ruby_3_1_code_has_syntax_errors(): void
	{
		exec('docker pull ruby:3.1');

		$data = Spear::ruby('3.1')->execute($this->wrongCodeWithoutInput);
		$this->assertNotEquals(0, $data->getResultCode());
	}

	public function test_ruby_3_2_rc_code_has_syntax_errors(): void
	{
		exec('docker pull ruby:3.2-rc');

		$data = Spear::ruby('3.2-rc')->execute($this->wrongCodeWithoutInput);
		$this->assertNotEquals(0, $data->getResultCode());
	}

	public function test_ruby_with_incorrect_version(): void
	{
		$this->expectException(Exception::class);
		Spear::node('4')->execute($this->wrongCodeWithoutInput);
	}

	public function test_ruby_code_works_fine_with_input(): void
	{
		exec('docker pull ruby:3');

		$data = Spear::ruby()->execute($this->rightCodeWithInput, '500');

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('10000', $data->getOutput());
	}

	public function test_when_ruby_default_version_image_not_pulled()
	{
		exec("docker rmi --force $(docker images | grep 'ruby') >/dev/null 2>&1");
		$this->expectException(Exception::class);
		Spear::ruby()->execute($this->rightCodeWithoutInput);
	}

	public function test_when_ruby_2_image_not_pulled()
	{
		exec("docker rmi --force $(docker images | grep 'ruby') >/dev/null 2>&1");
		$this->expectException(Exception::class);
		Spear::ruby('2')->execute($this->rightCodeWithoutInput);
	}

	public function test_when_ruby_3_image_not_pulled()
	{
		exec("docker rmi --force $(docker images | grep 'ruby') >/dev/null 2>&1");
		$this->expectException(Exception::class);
		Spear::ruby('3')->execute($this->rightCodeWithoutInput);
	}

	public function test_when_ruby_3_1_image_not_pulled()
	{
		exec("docker rmi --force $(docker images | grep 'ruby') >/dev/null 2>&1");
		$this->expectException(Exception::class);
		Spear::ruby('3.1')->execute($this->rightCodeWithoutInput);
	}

	public function test_when_ruby_3_2_rc_image_not_pulled()
	{
		exec("docker rmi --force $(docker images | grep 'ruby') >/dev/null 2>&1");
		$this->expectException(Exception::class);
		Spear::ruby('3.2-rc')->execute($this->rightCodeWithoutInput);
	}
}
