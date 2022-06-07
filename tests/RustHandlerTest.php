<?php

namespace Redberry\Spear\Tests;

use Exception;
use Redberry\Spear\Facades\Spear;
use Tests\TestCase;

class RustHandlerTest extends TestCase
{
	private string $rightCodeWithoutInput = <<<END
        fn main() { 
            println!("Hello World!"); 
        }
    END;

	private string $wrongCodeWithoutInput = <<<END
        fn main() { 
            println("Hello World!"); 
        }
    END;

	private string $rightCodeWithInput = <<<'END'
        fn main() {
            let mut line = String::new();
            std::io::stdin().read_line(&mut line).unwrap();
            println!("{}", line);
        }
    END;

	public function test_rust_default_version_code_is_working_without_input(): void
	{
		$data = Spear::rust()->execute($this->rightCodeWithoutInput);

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('Hello World!', $data->getOutput());
	}

	public function test_rust_1_code_is_working_without_input(): void
	{
		$data = Spear::rust('1')->execute($this->rightCodeWithoutInput);

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('Hello World!', $data->getOutput());
	}

	public function test_rust_default_version_code_has_syntax_errors(): void
	{
		$data = Spear::rust()->execute($this->wrongCodeWithoutInput);

		$this->assertNotEquals(0, $data->getResultCode());
	}

	public function test_rust_1_code_has_syntax_errors(): void
	{
		$data = Spear::rust('1')->execute($this->wrongCodeWithoutInput);

		$this->assertNotEquals(0, $data->getResultCode());
	}

	public function test_php_with_incorrect_version(): void
	{
		$this->expectException(Exception::class);
		Spear::node('3')->execute($this->rightCodeWithoutInput);
	}

	public function test_rust_code_works_fine_with_input(): void
	{
		$data = Spear::rust()->execute($this->rightCodeWithInput, '1500');

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('1500', $data->getOutput());
	}
}
