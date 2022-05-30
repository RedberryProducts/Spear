<?php

namespace Redberry\Spear\Tests;

use Redberry\Spear\Spear;
use PHPUnit\Framework\TestCase;

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
		$spear = new Spear;
		$spear->handler(Spear::PERL);
		$data = $spear->execute($this->rightCodeWithoutInput);

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('Hello, World!', $data->getOutput());
	}

	public function test_perl_code_has_syntax_errors(): void
	{
		$spear = new Spear;
		$spear->handler(Spear::PERL);
		$data = $spear->execute($this->wrongCodeWithoutInput);

		$this->assertNotEquals(0, $data->getResultCode());
	}

	public function test_perl_code_works_fine_with_input(): void
	{
		$spear = new Spear;
		$spear->handler(Spear::PERL);
		$data = $spear->execute($this->rightCodeWithInput, 75);

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('175', $data->getOutput());
	}
}
