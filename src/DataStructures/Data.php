<?php

namespace Redberry\Spear\DataStructures;

use Redberry\Spear\Interfaces\Data as ContractsData;

class Data implements ContractsData
{
	/**
	 * Creating props for result code.
	 */
	private int $resultCode;

	/**
	 * Creating props for error.
	 */
	private string|null $error;

	/**
	 * Creating props for output code.
	 */
	private string|null $output;

	/**
	 * Grants to the props default meanings.
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
	 * Set output returns executed code.
	 */
	public function setOutput(string $output): void
	{
		$this->output = trim($output);
	}

	/**
	 * Get resulted code.
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
	 * Get output result.
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
