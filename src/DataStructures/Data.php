<?php

namespace Redberry\Spear\DataStructures;

use Redberry\Spear\Interfaces\Data as ContractsData;

class Data implements ContractsData
{
	/**
	 * Result code after returned from script execution in the docker.
	 */
	private int $resultCode;

	/**
	 * Error that happened during code execution in the docker container.
	 */
	private string|null $error;

	/**
	 * Return output from docker container after code execution.
	 */
	private string|null $output;

	/**
	 * Set default values for execution results.
	 */
	public function __construct()
	{
		$this->resultCode = 0;
		$this->error = null;
		$this->output = null;
	}

	/**
	 * Set result code for code execution.
	 */
	public function setResultCode(int $code): void
	{
		$this->resultCode = $code;
	}

	/**
	 * Set error message when something went wrong.
	 */
	public function setErrorMessage(string $error): void
	{
		$this->error = trim($error);
	}

	/**
	 * Set script output message after code execution in the docker container.
	 */
	public function setOutput(string $output): void
	{
		$this->output = trim($output);
	}

	/**
	 * Get result code from script execution in the docker container.
	 */
	public function getResultCode(): int
	{
		return $this->resultCode;
	}

	/**
	 * Get error massage.
	 */
	public function getErrorMessage(): string|null
	{
		return $this->error;
	}

	/**
	 * Get output from the script execution in the docker container.
	 */
	public function getOutput(): string|null
	{
		return $this->output;
	}

	/**
	 * Returns array with all details.
	 */
	public function toArray(): array
	{
		return [
			'result_code'   => $this->getResultCode(),
			'error_message' => $this->getErrorMessage(),
			'output'        => $this->getOutput(),
		];
	}
}
