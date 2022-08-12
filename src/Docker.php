<?php

namespace Redberry\Spear;

use Exception;
use Redberry\Spear\DataStructures\Data as OutputData;
use Redberry\Spear\Interfaces\Data;
use Redberry\Spear\Facades\Request;

class Docker
{
	/**
	 * Docker image, with which the
	 * docker container should be executed.
	 */
	protected string $image;

	/**
	 * Shell command to run in the container shell.
	 */
	protected string $shellCommand;

	/**
	 * Working directory path.
	 */
	protected string $workDirectory = '';

	/**
	 * Mount working directory path.
	 */
	protected string $mountDirectory = '';

	/**
	 * Set docker image to use for container creation.
	 */
	private function setImage(string $image = ''): void
	{
		$this->image = $image;
	}

	/**
	 * Set shell command to run in the container.
	 */
	private function setShell(string $shell = ''): void
	{
		$this->shellCommand = $shell;
	}

	/**
	 * Set working dir path.
	 */
	private function setWorkDir($workDir = '/app'): void
	{
		$this->workDirectory = $workDir;
	}

	/**
	 * Set mount directory to copy into the docker working dir.
	 */
	private function setMountDir($mountDir)
	{
		$this->mountDirectory = $mountDir;
	}

	/**
	 * Set the image to use for the container creation.
	 */
	public function use($image): self
	{
		$this->setImage($image);
		return $this;
	}

	/**
	 * Run shell command in the container.
	 *
	 * @throws Exception
	 */
	public function shell($shell = ''): Data
	{
		$this->setShell($shell);
		return $this->compileAndRun();
	}

	/**
	 * Method for selecting working directory.
	 */
	public function workDir($workDir = '/app'): self
	{
		$this->setWorkDir($workDir);
		return $this;
	}

	/**
	 * The method for the coping folder is the docker working directory.
	 */
	public function mountDir($mountDir, $workDir = ''): self
	{
		if ($workDir === '')
		{
			$mountDir = "$mountDir:$this->workDirectory";
		}
		else
		{
			$mountDir = "$mountDir:$workDir";
		}

		$this->setMountDir($mountDir);
		return $this;
	}

	/**
	 * Create a new docker container, run and return formatted output.
	 *
	 * @throws Exception
	 */
	private function compileAndRun(): Data
	{
		$output = [];
		$resultCode = 0;

		$this->runInDocker($this->image, $output, $resultCode);

		return $this->formatOutput($output, $resultCode);
	}

	/**
	 * Format and normalize return data from the docker container.
	 */
	private function formatOutput(array $output, int $resultCode): Data
	{
		$data = new OutputData();
		$data->setResultCode($resultCode);

		if ($resultCode !== 0)
		{
			$data->setErrorMessage(implode("\n", $output));
		}
		else
		{
			$data->setOutput(implode("\n", $output));
		}

		return $data;
	}

	/**
	 * Determine if the docker image exists locally.
	 */
	public function imageExistsLocally($image): bool
	{
		try
		{
			$image = Request::get("/images/$image/json");
			return (bool)$image->Id;
		}
		catch (Exception $e)
		{
			return false;
		}
	}

	/**
	 * Remove docker image if it exists locally.
	 */
	public function pruneImage($image): void
	{
		if ($this->imageExistsLocally($image))
		{
			Request::delete("/images/$image");
		}
	}

	/**
	 * Remove docker image even if there are containers based on this image.
	 */
	public function pruneImageForcibly($image): void
	{
		if ($this->imageExistsLocally($image))
		{
			Request::delete("/images/$image?force=true");
		}
	}

	/**
	 * Pull docker image if it does not exist locally.
	 */
	public function pull($image): void
	{
		if (!$this->imageExistsLocally($image))
		{
			Request::post("/images/create?fromImage=$image");
		}
	}

	/**
	 * Run prepared command in the docker container.
	 *
	 * @throws Exception
	 */
	private function runInDocker(string $image, array &$output = [], int &$resultCode = 0): void
	{
		$imageLocally = $this->imageExistsLocally($image);
		if (!$imageLocally)
		{
			throw new Exception("Image $image does not exist locally, please pull the image before using it.");
		}

		$workDir = $this->workDirectory ? $this->workDirectory : '/app';
		$mountDir = $this->mountDirectory ? $this->mountDirectory : '/tmp:/tmp';

		$container = Request::post('/containers/create', [
			'Image'      => $image,
			'Cmd'        => [
				'bash',
				'-c',
				$this->shellCommand,
			],
			'WorkingDir' => $workDir,
			'HostConfig' => [
				'Binds' => [
					$mountDir,
				],
			],
			'AttachStdin' => true,
			'Tty'         => true,
		]);
		Request::post("/containers/$container->Id/start");
		$data = Request::post("/containers/$container->Id/wait");
		$output = Request::get("/containers/$container->Id/logs?stdout=true");
		$resultCode = $data->StatusCode;
		$output = gettype($output) === 'string' ? $output = [$output] : $output = [$output->data];
	}
}
