<?php

namespace Redberry\Spear\Tests;

use Exception;
use Redberry\Spear\Facades\Spear;
use Tests\TestCase;

class CSharpHandlerTest extends TestCase
{
	private string $rightCode = <<<END
        using System;

        class Program
        {
            static void Main() {
                string greeting;
                greeting = Console.ReadLine();
                Console.Write(greeting);
            }
        }
    END;

	private string $erroredCode = <<<END
        using System;

        class Program
        {
            static void Main() {
        
                Console.Write(Hello");
            }
        }
    END;

	public function test_csharp_default_version_code_is_working(): void
	{
		exec('docker pull mono:6.12');

		$data = Spear::cSharp()->execute($this->rightCode, 'hey');
		$this->assertEquals('hey', $data->getOutput());
		$this->assertEquals(0, $data->getResultCode());
	}

	public function test_csharp_6_code_is_working(): void
	{
		exec('docker pull mono:6');

		$data = Spear::cSharp('6')->execute($this->rightCode, 'hey');
		$this->assertEquals('hey', $data->getOutput());
		$this->assertEquals(0, $data->getResultCode());
	}

	public function test_csharp_6_10_code_is_working(): void
	{
		exec('docker pull mono:6.10');

		$data = Spear::cSharp('6.10')->execute($this->rightCode, 'hey');
		$this->assertEquals('hey', $data->getOutput());
		$this->assertEquals(0, $data->getResultCode());
	}

	public function test_csharp_6_12_code_is_working(): void
	{
		exec('docker pull mono:6.12');

		$data = Spear::cSharp('6.12')->execute($this->rightCode, 'hey');
		$this->assertEquals('hey', $data->getOutput());
		$this->assertEquals(0, $data->getResultCode());
	}

	public function test_csharp_default_version_code_has_syntax_errors(): void
	{
		exec('docker pull mono:6.12');

		$data = Spear::cSharp()->execute($this->erroredCode);
		$this->assertNotEquals(0, $data->getResultCode());
	}

	public function test_csharp_6_code_has_syntax_errors(): void
	{
		exec('docker pull mono:6');

		$data = Spear::cSharp('6')->execute($this->erroredCode);
		$this->assertNotEquals(0, $data->getResultCode());
	}

	public function test_csharp_6_10_code_has_syntax_errors(): void
	{
		exec('docker pull mono:6.10');

		$data = Spear::cSharp('6.10')->execute($this->erroredCode);
		$this->assertNotEquals(0, $data->getResultCode());
	}

	public function test_csharp_6_12_code_has_syntax_errors(): void
	{
		exec('docker pull mono:6.12');

		$data = Spear::cSharp('6.12')->execute($this->erroredCode);
		$this->assertNotEquals(0, $data->getResultCode());
	}

	public function test_csharp_code_has_syntax_errors(): void
	{
		exec('docker pull mono:6.12');

		$data = Spear::cSharp()->execute($this->erroredCode);
		$this->assertNotEquals(0, $data->getResultCode());
	}

	public function test_csharp_default_version_image_when_not_pulled()
	{
		exec("docker rmi --force $(docker images | grep 'mono') >/dev/null 2>&1");
		$this->expectException(Exception::class);
		Spear::cSharp()->execute($this->rightCode, 'hey');
	}

	public function test_csharp_6_image_when_not_pulled()
	{
		exec("docker rmi --force $(docker images | grep 'mono') >/dev/null 2>&1");
		$this->expectException(Exception::class);
		Spear::cSharp('6')->execute($this->rightCode, 'hey');
	}

	public function test_csharp_6_10_image_when_not_pulled()
	{
		exec("docker rmi --force $(docker images | grep 'mono') >/dev/null 2>&1");
		$this->expectException(Exception::class);
		Spear::cSharp('6.10')->execute($this->rightCode, 'hey');
	}

	public function test_csharp_6_12_image_when_not_pulled()
	{
		exec("docker rmi --force $(docker images | grep 'mono') >/dev/null 2>&1");
		$this->expectException(Exception::class);
		Spear::cSharp('6.12')->execute($this->rightCode, 'hey');
	}

	public function test_csharp_with_incorrect_version(): void
	{
		$this->expectException(Exception::class);
		Spear::node('9')->execute($this->rightCode);
	}
}
