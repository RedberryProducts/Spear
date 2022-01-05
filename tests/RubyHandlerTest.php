<?php

namespace Giunashvili\Spear\Tests;

use Giunashvili\Spear\Spear;
use PHPUnit\Framework\TestCase;

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
		$spear = new Spear;
		$spear->handler(Spear::RUBY_3);
		$data = $spear->execute($this->rightCodeWithoutInput);
		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('Hello World!', $data->getOutput());
	}

	public function test_ruby_code_has_syntax_errors(): void
	{
		$spear = new Spear;
		$spear->handler(Spear::RUBY_3);
		$data = $spear->execute($this->wrongCodeWithoutInput);
		$this->assertNotEquals(0, $data->getResultCode());
	}

	public function test_ruby_code_works_fine_with_input(): void
	{
		$spear = new Spear;
		$spear->handler(Spear::RUBY_3);
		$data = $spear->execute($this->rightCodeWithInput, '500');

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('10000', $data->getOutput());
	}
}
