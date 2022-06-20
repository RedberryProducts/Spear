<?php

namespace Redberry\Spear\Tests;

use Tests\TestCase;

class FetchImagesCommandTest extends TestCase
{
	public function test_fetch_node_images_with_artisan_command(): void
	{
		$command = $this->artisan('spear:pull node');

		$command->doesntExpectOutput(" This image doesn't exist: node ");
	}

	public function test_fetch_cpp_images_with_artisan_command(): void
	{
		$command = $this->artisan('spear:pull cpp');

		$command->doesntExpectOutput(" This image doesn't exist: cpp ");
	}

	public function test_fetch_csharp_images_with_artisan_command(): void
	{
		$command = $this->artisan('spear:pull csharp');

		$command->doesntExpectOutput(" This image doesn't exist: csharp ");
	}

	public function test_fetch_go_images_with_artisan_command(): void
	{
		$command = $this->artisan('spear:pull go');

		$command->doesntExpectOutput(" This image doesn't exist: go ");
	}

	public function test_fetch_java_images_with_artisan_command(): void
	{
		$command = $this->artisan('spear:pull java');

		$command->doesntExpectOutput(" This image doesn't exist: java ");
	}

	public function test_fetch_perl_images_with_artisan_command(): void
	{
		$command = $this->artisan('spear:pull perl');

		$command->doesntExpectOutput(" This image doesn't exist: perl ");
	}

	public function test_fetch_php_images_with_artisan_command(): void
	{
		$command = $this->artisan('spear:pull php');

		$command->doesntExpectOutput(" This image doesn't exist: php ");
	}

	public function test_fetch_python_images_with_artisan_command(): void
	{
		$command = $this->artisan('spear:pull python');

		$command->doesntExpectOutput(" This image doesn't exist: python ");
	}

	public function test_fetch_ruby_images_with_artisan_command(): void
	{
		$command = $this->artisan('spear:pull ruby');

		$command->doesntExpectOutput(" This image doesn't exist: ruby ");
	}

	public function test_fetch_rust_images_with_artisan_command(): void
	{
		$command = $this->artisan('spear:pull rust');

		$command->doesntExpectOutput(" This image doesn't exist: rust ");
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
