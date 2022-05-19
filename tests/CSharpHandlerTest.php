<?php

namespace Redberry\Spear\Tests;

use Redberry\Spear\Spear;
use PHPUnit\Framework\TestCase;

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

	public function test_csharp_code_is_working(): void
	{
		$spear = new Spear;
		$spear->handler(Spear::C_SHARP);
		$data = $spear->execute($this->rightCode, 'hey');
		$this->assertEquals('hey', $data->getOutput());
		$this->assertEquals(0, $data->getResultCode());
	}

	public function test_csharp_code_has_syntax_errors(): void
	{
		$spear = new Spear;
		$data = $spear->execute($this->erroredCode);
		$this->assertNotEquals(0, $data->getResultCode());
	}
}
