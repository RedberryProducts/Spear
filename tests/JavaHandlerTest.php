<?php

namespace Redberry\Spear\Tests;

use Exception;
use Redberry\Spear\Facades\Spear;
use Tests\TestCase;

class JavaHandlerTest extends TestCase
{
	private $rightCodeWithoutInput = <<<END
        class Main {
            public static void main(String[] args) {
                System.out.println("Hello, World!"); 
            }
        }
    END;

	private string $wrongCodeWithoutInput = <<<END
        class Main {
            public static void main(String[] args) {
                System.out.println"Hello, World!"); 
            }
        }
    END;

	private string $rightCodeWithInput = <<<END
        import java.util.Scanner;
        
        class Main {
            public static void main(String[] args) {
                Scanner myObj = new Scanner(System.in);
                String hello = myObj.nextLine(); 
                System.out.println(hello + ", World!"); 
            }
        }
    END;

	public function test_java_default_version_code_is_working_without_input(): void
	{
		$data = Spear::java()->execute($this->rightCodeWithoutInput);

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('Hello, World!', $data->getOutput());
	}

	public function test_java_default_version_code_has_syntax_errors(): void
	{
		$data = Spear::java()->execute($this->wrongCodeWithoutInput);

		$this->assertNotEquals(0, $data->getResultCode());
	}

	public function test_java_11_code_has_syntax_errors(): void
	{
		$data = Spear::java('11')->execute($this->wrongCodeWithoutInput);

		$this->assertNotEquals(0, $data->getResultCode());
	}

	public function test_java_default_version_code_works_fine_with_input(): void
	{
		$data = Spear::java()->execute($this->rightCodeWithInput, 'Hello');

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('Hello, World!', $data->getOutput());
	}

	public function test_java_11_code_works_fine_with_input(): void
	{
		$data = Spear::java('11')->execute($this->rightCodeWithInput, 'Hello');

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('Hello, World!', $data->getOutput());
	}

	public function test_java_with_incorrect_version(): void
	{
		$this->expectException(Exception::class);
		Spear::node('20')->execute($this->rightCodeWithoutInput);
	}
}
