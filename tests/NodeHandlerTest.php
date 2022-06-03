<?php

namespace Redberry\Spear\Tests;

use Redberry\Spear\Facades\Spear;
use Tests\TestCase;

class NodeHandlerTest extends TestCase
{
	private string $rightCodeWithoutInput = <<<END
        console.log('hello world!');
    END;

	private string $wrongCodeWithoutInput = <<<END
        console.log'hello world!');
    END;

	private string $rightCodeWithInput = <<<END
        let data = '';

        const solve = () => {
            const num = +data;
            console.log(num * 2);
        }

        process.stdin.on('data', c => data+=c);
        process.stdin.on('end', solve);
    END;

	public function test_node_code_is_working_without_input(): void
	{
		$data = Spear::node()->execute($this->rightCodeWithoutInput);

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('hello world!', $data->getOutput());
	}

	public function test_node_code_has_syntax_errors(): void
	{
		$data = Spear::node()->execute($this->wrongCodeWithoutInput);

		$this->assertEquals(1, $data->getResultCode());
	}

	public function test_node_code_works_fine_with_input(): void
	{
		$data = Spear::node()->execute($this->rightCodeWithInput, '123');

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('246', $data->getOutput());
	}
}
