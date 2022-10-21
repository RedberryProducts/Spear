<?php

namespace Redberry\Spear\Tests;

use Exception;
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

	public function test_node_default_version_code_is_working_without_input(): void
	{
		exec('docker pull node:14');

		$data = Spear::node()->execute($this->rightCodeWithoutInput);

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('hello world!', $data->getOutput());
	}

	public function test_node_14_code_is_working(): void
	{
		exec('docker pull node:14');

		$data = Spear::node('14')->execute($this->rightCodeWithoutInput);

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('hello world!', $data->getOutput());
	}

	public function test_node_16_code_is_working(): void
	{
		exec('docker pull node:16');

		$data = Spear::node('16')->execute($this->rightCodeWithoutInput);

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('hello world!', $data->getOutput());
	}

	public function test_node_17_code_is_working(): void
	{
		exec('docker pull node:17');

		$data = Spear::node('17')->execute($this->rightCodeWithoutInput);

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('hello world!', $data->getOutput());
	}

	public function test_node_18_code_is_working(): void
	{
		exec('docker pull node:18');

		$data = Spear::node('18')->execute($this->rightCodeWithoutInput);

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('hello world!', $data->getOutput());
	}

	public function test_node_with_incorrect_code_is_working(): void
	{
		$this->expectException(Exception::class);
		Spear::node('21')->execute($this->wrongCodeWithoutInput);
	}

	public function test_node_default_version_code_has_syntax_errors(): void
	{
		exec('docker pull node:14');

		$data = Spear::node()->execute($this->wrongCodeWithoutInput);

		$this->assertEquals(1, $data->getResultCode());
	}

	public function test_node_14_code_has_syntax_errors(): void
	{
		exec('docker pull node:14');

		$data = Spear::node('14')->execute($this->wrongCodeWithoutInput);

		$this->assertEquals(1, $data->getResultCode());
	}

	public function test_node_16_code_has_syntax_errors(): void
	{
		exec('docker pull node:16');

		$data = Spear::node('16')->execute($this->wrongCodeWithoutInput);

		$this->assertEquals(1, $data->getResultCode());
	}

	public function test_node_17_code_has_syntax_errors(): void
	{
		exec('docker pull node:17');

		$data = Spear::node('17')->execute($this->wrongCodeWithoutInput);

		$this->assertEquals(1, $data->getResultCode());
	}

	public function test_node_18_code_has_syntax_errors(): void
	{
		exec('docker pull node:18');

		$data = Spear::node('18')->execute($this->wrongCodeWithoutInput);

		$this->assertEquals(1, $data->getResultCode());
	}

	public function test_node_code_works_fine_with_input(): void
	{
		exec('docker pull node:14');

		$data = Spear::node()->execute($this->rightCodeWithInput, '123');

		$this->assertEquals(0, $data->getResultCode());
		$this->assertEquals('246', $data->getOutput());
	}

	public function test_when_node_default_version_image_not_pulled()
	{
		exec("docker rmi --force $(docker images | grep 'node') >/dev/null 2>&1");
		$this->expectException(Exception::class);
		Spear::node()->execute($this->rightCodeWithoutInput);
	}

	public function test_when_node_14_image_not_pulled()
	{
		exec("docker rmi --force $(docker images | grep 'node') >/dev/null 2>&1");
		$this->expectException(Exception::class);
		Spear::node('14')->execute($this->rightCodeWithoutInput);
	}

	public function test_when_node_16_image_not_pulled()
	{
		exec("docker rmi --force $(docker images | grep 'node') >/dev/null 2>&1");
		$this->expectException(Exception::class);
		Spear::node('16')->execute($this->rightCodeWithoutInput);
	}

	public function test_when_node_17_image_not_pulled()
	{
		exec("docker rmi --force $(docker images | grep 'node') >/dev/null 2>&1");
		$this->expectException(Exception::class);
		Spear::node('17')->execute($this->rightCodeWithoutInput);
	}

	public function test_when_node_18_image_not_pulled()
	{
		exec("docker rmi --force $(docker images | grep 'node') >/dev/null 2>&1");
		$this->expectException(Exception::class);
		Spear::node('18')->execute($this->rightCodeWithoutInput);
	}
}
