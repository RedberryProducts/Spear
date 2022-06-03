<?php

namespace Redberry\Spear\Tests;

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

	public function test_ruby_code_is_working_without_input(): void
	{
		$data = Spear::ruby()->execute($this->rightCodeWithoutInput);
		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('Hello World!', $data->getOutput());
	}

	public function test_ruby_code_has_syntax_errors(): void
	{
		$data = Spear::ruby()->execute($this->wrongCodeWithoutInput);
		$this->assertNotEquals(0, $data->getResultCode());
	}

	public function test_ruby_code_works_fine_with_input(): void
	{
		$data = Spear::ruby()->execute($this->rightCodeWithInput, '500');

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('10000', $data->getOutput());
	}
}
