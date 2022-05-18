<?php

namespace Giunashvili\Spear\Tests;

use Giunashvili\Spear\Spear;
use PHPUnit\Framework\TestCase;

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

	public function test_go_lang_code_is_working_without_input(): void
	{
		$spear = new Spear;
		$spear->handler(Spear::GO_LANG);

		$data = $spear->execute($this->rightCodeWithoutInput);
		dump($data->getOutput());
		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('Hello, World!', $data->getOutput());
	}

	public function test_go_lang_code_has_syntax_errors(): void
	{
		$spear = new Spear;
		$spear->handler(Spear::GO_LANG);

		$data = $spear->execute($this->wrongCodeWithoutInput);

		$this->assertNotEquals(0, $data->getResultCode());
	}
}
