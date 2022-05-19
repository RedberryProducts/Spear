<?php

namespace Redberry\Spear\Tests;

use Redberry\Spear\Spear;
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

	private string $rightCodeWithInput = <<<END
    package main
        
    import "fmt"

    func main() {
        var input int
        fmt.Scanln(&input)
        fmt.Print(input + 100)
    }

    END;

	public function test_go_lang_code_is_working_without_input(): void
	{
		$spear = new Spear;
		$spear->handler(Spear::GO_LANG);

		$data = $spear->execute($this->rightCodeWithoutInput);
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

	public function test_go_lang_code_works_fine_with_input(): void
	{
		$spear = new Spear;
		$spear->handler(Spear::GO_LANG);
		$data = $spear->execute($this->rightCodeWithInput, 100);

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals(200, $data->getOutput());
	}
}
