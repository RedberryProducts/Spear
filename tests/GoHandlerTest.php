<?php

namespace Redberry\Spear\Tests;

use Exception;
use Redberry\Spear\Facades\Spear;
use Tests\TestCase;

class GoHandlerTest extends TestCase
{
	private $rightCodeWithoutInput = <<<END
        package main

        import "fmt"
        
        func main() {
            fmt.Println("Hello, World!")
        }
    END;

	private string $wrongCodeWithoutInput = <<<END
        package main

        import "fmt"
        
        func main() {
            fmt.Println"Hello, World!")
        }
    END;

	private string $rightCodeWithInput = <<<END
    package main
        
    import "fmt"

    func main() {
        var input int
        fmt.Scanln(&input)
        fmt.Print(input + 100)
    }

    END;

	public function test_go_lang_default_version_code_is_working_without_input(): void
	{
		exec('docker pull golang:1.18');

		$data = Spear::go()->execute($this->rightCodeWithoutInput);
		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('Hello, World!', $data->getOutput());
	}

	public function test_go_lang_default_version_code_works_fine_with_input(): void
	{
		exec('docker pull golang:1.18');

		$data = Spear::go()->execute($this->rightCodeWithInput, 100);

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals(200, $data->getOutput());
	}

	public function test_go_1_version_code_works_fine_with_input(): void
	{
		exec('docker pull golang:1');

		$data = Spear::go('1')->execute($this->rightCodeWithInput, 100);

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals(200, $data->getOutput());
	}

	public function test_go_1_17_version_code_works_fine_with_input(): void
	{
		exec('docker pull golang:1.17');

		$data = Spear::go('1.17')->execute($this->rightCodeWithInput, 100);

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals(200, $data->getOutput());
	}

	public function test_go_1_18_version_code_works_fine_with_input(): void
	{
		exec('docker pull golang:1.18');

		$data = Spear::go('1.18')->execute($this->rightCodeWithInput, 100);

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals(200, $data->getOutput());
	}

	public function test_go_lang_with_incorrect_version(): void
	{
		$this->expectException(Exception::class);
		Spear::node('3')->execute($this->rightCodeWithInput);
	}

	public function test_go_lang_default_version_code_has_syntax_errors(): void
	{
		exec('docker pull golang:1.18');

		$data = Spear::go()->execute($this->wrongCodeWithoutInput);

		$this->assertNotEquals(0, $data->getResultCode());
	}

	public function test_go_lang_1_code_has_syntax_errors(): void
	{
		exec('docker pull golang:1');

		$data = Spear::go('1')->execute($this->wrongCodeWithoutInput);

		$this->assertNotEquals(0, $data->getResultCode());
	}

	public function test_go_lang_1_17_code_has_syntax_errors(): void
	{
		exec('docker pull golang:1.17');

		$data = Spear::go('1.17')->execute($this->wrongCodeWithoutInput);

		$this->assertNotEquals(0, $data->getResultCode());
	}

	public function test_go_lang_1_18_code_has_syntax_errors(): void
	{
		exec('docker pull golang:1.18');

		$data = Spear::go('1.18')->execute($this->wrongCodeWithoutInput);

		$this->assertNotEquals(0, $data->getResultCode());
	}

	public function test_go_lang_default_version_image_when_not_pulled()
	{
		exec("docker rmi --force $(docker images | grep 'golang') >/dev/null 2>&1");
		$this->expectException(Exception::class);
		Spear::go()->execute($this->rightCodeWithoutInput);
	}

	public function test_go_lang_1_image_when_not_pulled()
	{
		exec("docker rmi --force $(docker images | grep 'golang') >/dev/null 2>&1");
		$this->expectException(Exception::class);
		Spear::go('1')->execute($this->rightCodeWithoutInput);
	}

	public function test_go_lang_1_17_image_when_not_pulled()
	{
		exec("docker rmi --force $(docker images | grep 'golang') >/dev/null 2>&1");
		$this->expectException(Exception::class);
		Spear::go('1.17')->execute($this->rightCodeWithoutInput);
	}

	public function test_go_lang_1_18_image_when_not_pulled()
	{
		exec("docker rmi --force $(docker images | grep 'golang') >/dev/null 2>&1");
		$this->expectException(Exception::class);
		Spear::go('1.18')->execute($this->rightCodeWithoutInput);
	}
}
