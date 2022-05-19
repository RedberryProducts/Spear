<?php

namespace Redberry\Spear\Tests;

use Redberry\Spear\Spear;
use PHPUnit\Framework\TestCase;

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

	public function test_rust_code_is_working_without_input(): void
	{
		$spear = new Spear;
		$spear->handler(Spear::RUST_1);
		$data = $spear->execute($this->rightCodeWithoutInput);
		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('Hello World!', $data->getOutput());
	}

	public function test_rust_code_has_syntax_errors(): void
	{
		$spear = new Spear;
		$spear->handler(Spear::RUST_1);
		$data = $spear->execute($this->wrongCodeWithoutInput);
		$this->assertNotEquals(0, $data->getResultCode());
	}

	public function test_rust_code_works_fine_with_input(): void
	{
		$spear = new Spear;
		$spear->handler(Spear::RUST_1);
		$data = $spear->execute($this->rightCodeWithInput, '1500');
		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('1500', $data->getOutput());
	}
}
