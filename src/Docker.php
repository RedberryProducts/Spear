<?php

namespace Redberry\Spear;

use Exception;
use Redberry\Spear\DataStructures\Data as OutputData;
use Redberry\Spear\Interfaces\Data;

class Docker
{
	/**
	 * Docker image, with which the
	 * docker container should be executed.
	 */
	protected string $image;

	/**
	 * Shell command to run the container command.
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
	 * Set shell command to run bash command.
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
	 * Method for use docker images.
	 */
	public function use($image): self
	{
		$this->setImage($image);
		return $this;
	}

	/**
	 * Method use shell command for bash.
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
	 * Method for coping file into the docker working directory.
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
	 * Creates new docker, run it and returns formatted docker.
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
	 * Format and normalize return data from docker.
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
	 * Run prepared command in the docker container.
	 *
	 * @throws Exception
	 */
	private function runInDocker(string $image, array &$output = [], int &$resultCode = 0): void
	{
		$checkImageResultCode = null;
		exec('docker inspect -f --type=image ' . $this->image . ' >/dev/null 2>&1', $_, $checkImageResultCode);
		if ($checkImageResultCode !== 0)
		{
			throw new Exception("Image $this->image does not exist locally, please pull the image before using it.");
		}

		$workDir = $this->workDirectory ? '-w ' . $this->workDirectory : null;
		$mountDir = $this->mountDirectory ? '-v ' . $this->mountDirectory : null;

		exec("docker run $workDir $mountDir $image bash -c '$this->shellCommand'", $output, $resultCode);
	}
}
