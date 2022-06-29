<?php

namespace Redberry\Spear\Tests;

use Tests\TestCase;

class DockerImagesListCommandTest extends TestCase
{
	public function test_check_docker_image_list_with_artisan_command(): void
	{
		$command = $this->artisan('spear:list');

		$command->assertSuccessful();
	}
}
