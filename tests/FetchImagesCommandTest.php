<?php

namespace Redberry\Spear\Tests;

use Tests\TestCase;

class FetchImagesCommandTest extends TestCase
{
	public function test_fetch_node_images_with_artisan_command(): void
	{
		$command = $this->artisan('spear:pull node');

		$versions = [
			'14' => 'node:14',
			'16' => 'node:16',
			'17' => 'node:17',
			'18' => 'node:18',
		];

		foreach ($versions as $version)
		{
			$command->expectsOutput($version . ' image has been loaded.');
		}

		$command->assertExitCode(0);
	}

	public function test_fetch_cpp_images_with_artisan_command(): void
	{
		$command = $this->artisan('spear:pull cpp');

		$versions = [
			'14' => 'giunashvili/cpp',
		];

		foreach ($versions as $version)
		{
			$command->expectsOutput($version . ' image has been loaded.');
		}

		$command->assertExitCode(0);
	}

	public function test_fetch_csharp_images_with_artisan_command(): void
	{
		$command = $this->artisan('spear:pull csharp');

		$versions = [
			'6'    => 'mono:6',
			'6.10' => 'mono:6.10',
			'6.12' => 'mono:6.12',
		];

		foreach ($versions as $version)
		{
			$command->expectsOutput($version . ' image has been loaded.');
		}

		$command->assertExitCode(0);
	}

	public function test_fetch_go_images_with_artisan_command(): void
	{
		$command = $this->artisan('spear:pull go');

		$versions = [
			'1'    => 'golang:1',
			'1.17' => 'golang:1.17',
			'1.18' => 'golang:1.18',
		];

		foreach ($versions as $version)
		{
			$command->expectsOutput($version . ' image has been loaded.');
		}

		$command->assertExitCode(0);
	}

	public function test_fetch_java_images_with_artisan_command(): void
	{
		$command = $this->artisan('spear:pull java');

		$versions = [
			'11' => 'openjdk:11',
		];

		foreach ($versions as $version)
		{
			$command->expectsOutput($version . ' image has been loaded.');
		}

		$command->assertExitCode(0);
	}

	public function test_fetch_perl_images_with_artisan_command(): void
	{
		$command = $this->artisan('spear:pull perl');

		$versions = [
			'5'    => 'perl:5',
			'5.34' => 'perl:5.34',
		];

		foreach ($versions as $version)
		{
			$command->expectsOutput($version . ' image has been loaded.');
		}

		$command->assertExitCode(0);
	}

	public function test_fetch_php_images_with_artisan_command(): void
	{
		$command = $this->artisan('spear:pull php');

		$versions = [
			'8' => 'giunashvili/php',
		];

		foreach ($versions as $version)
		{
			$command->expectsOutput($version . ' image has been loaded.');
		}

		$command->assertExitCode(0);
	}

	public function test_fetch_python_images_with_artisan_command(): void
	{
		$command = $this->artisan('spear:pull python');

		$versions = [
			'3.7'      => 'python:3.7',
			'3.8'      => 'python:3.8',
			'3.9'      => 'python:3.9',
			'3.10'     => 'python:3.10',
			'3.11-rc'  => 'python:3.11-rc',
		];

		foreach ($versions as $version)
		{
			$command->expectsOutput($version . ' image has been loaded.');
		}

		$command->assertExitCode(0);
	}

	public function test_fetch_ruby_images_with_artisan_command(): void
	{
		$command = $this->artisan('spear:pull ruby');

		$versions = [
			'2'      => 'ruby:2',
			'3'      => 'ruby:3',
			'3.1'    => 'ruby:3.1',
			'3.2-rc' => 'ruby:3.2-rc',
		];

		foreach ($versions as $version)
		{
			$command->expectsOutput($version . ' image has been loaded.');
		}

		$command->assertExitCode(0);
	}

	public function test_fetch_rust_images_with_artisan_command(): void
	{
		$command = $this->artisan('spear:pull rust');

		$versions = [
			'1' => 'rust:1',
		];

		foreach ($versions as $version)
		{
			$command->expectsOutput($version . ' image has been loaded.');
		}

		$command->assertExitCode(0);
	}

	public function test_fetch_image_with_not_available_language()
	{
		$command = $this->artisan('spear:pull language');

		$command->expectsOutput(" This image doesn't exist: language ");
	}

	public function test_fetch_all_images_with_artisan_command()
	{
		$command = $this->artisan('spear:pull');

		$command->expectsOutput('All images have been successfully loaded.');
		$command->assertExitCode(0);
	}
}
