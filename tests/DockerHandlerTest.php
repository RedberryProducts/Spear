<?php

namespace Redberry\Spear\Tests;

use Exception;
use Redberry\Spear\Facades\Docker;
use Tests\TestCase;

class DockerHandlerTest extends TestCase
{
	public function test_docker_facade_working_with_all_methods_and_pulled_image(): void
	{
		exec('docker pull node:14');

		$result = Docker::use('node:14')
			->workDir('/app')
			->mountDir(getcwd() . '/tests/mocks', '/app')
			->shell('node fake.js');

		$this->assertEquals($result->getResultCode(), 0);
		$this->assertEquals($result->getOutput(), "I'm server!");
	}

	public function test_docker_facade_working_with_only_use_and_pulled_image(): void
	{
		exec('docker pull node:14');

		$result = Docker::use('node:14')
			->shell('echo hello world!');

		$this->assertEquals($result->getResultCode(), 0);
		$this->assertEquals($result->getOutput(), 'hello world!');
	}

	public function test_docker_facade_working_with_only_use_and_mountdir(): void
	{
		exec('docker pull node:14');

		$result = Docker::use('node:14')
			->mountDir('/home/project', '/app')
			->shell('echo hello world!');

		$this->assertEquals($result->getResultCode(), 0);
		$this->assertEquals($result->getOutput(), 'hello world!');
	}

	public function test_docker_facade_working_with_only_use_and_workdir(): void
	{
		exec('docker pull node:14');

		$result = Docker::use('node:14')
			->workDir('/app')
			->shell('echo hello world!');

		$this->assertEquals($result->getResultCode(), 0);
		$this->assertEquals($result->getOutput(), 'hello world!');
	}

	public function test_docker_facade_working_with_not_pulled_image(): void
	{
		exec("docker rmi --force $(docker images | grep 'node') >/dev/null 2>&1");
		$this->expectException(Exception::class);
		Docker::use('node:14')
			->workDir('/app')
			->mountDir(getcwd() . '/tests/mocks', '/app')
			->shell('node fake.js');
	}

	public function test_docker_facade_working_with_wrong_path(): void
	{
		exec('docker pull node:14');

		$result = Docker::use('node:14')
			->workDir('/app')
			->mountDir(getcwd() . '/fake/mocks', '/app')
			->shell('node fake.js bash >/dev/null 2>&1');

		$this->assertNotEquals($result->getResultCode(), 0);
		$this->assertEquals($result->getOutput(), null);
	}

	public function test_docker_facade_working_with_wrong_workDir(): void
	{
		exec('docker pull node:14');

		$result = Docker::use('node:14')
			->workDir('/home')
			->mountDir(getcwd() . '/tests/mocks', '/app')
			->shell('node fake.js bash >/dev/null 2>&1');

		$this->assertNotEquals($result->getResultCode(), 0);
		$this->assertEquals($result->getOutput(), null);
	}

	public function test_docker_facade_working_without_workdir_in_mountDir(): void
	{
		exec('docker pull node:14');

		$result = Docker::use('node:14')
			->workDir('/app')
			->mountDir(getcwd() . '/tests/mocks')
			->shell('node fake.js');

		$this->assertEquals($result->getResultCode(), 0);
		$this->assertEquals($result->getOutput(), "I'm server!");
	}
}
