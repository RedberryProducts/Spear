<?php

namespace Redberry\Spear;

use Exception;
use Redberry\Spear\DataStructures\Data as OutputData;
use Redberry\Spear\Interfaces\Data;

class Docker
{
	protected string $image;

	protected string $shellCommand;

	private function setImage(string $image = ''): void
	{
		$this->image = $image;
	}

	private function setShell(string $shell = ''): void
	{
		$this->shellCommand = $shell;
	}

	public function use($image): self
	{
		$this->setImage($image);
		return $this;
	}

	/**
	 * @throws Exception
	 */
	public function shell($shell = ''): Data
	{
		$this->setShell($shell);
		return $this->compileAndRun();
	}

	/**
	 * @throws Exception
	 */
	private function compileAndRun(): Data
	{
		$output = [];
		$resultCode = 0;

		$this->runInDocker($this->image, $output, $resultCode);

		return $this->formatOutput($output, $resultCode);
	}

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

		exec("docker run $image bash -c '$this->shellCommand'", $output, $resultCode);
	}
}
