<?php

namespace Redberry\Spear\DataStructures;

use Redberry\Spear\Interfaces\Data as ContractsData;

class Data implements ContractsData
{
	private int $resultCode;

	private string|null $error;

	private string|null $output;

	public function __construct()
	{
		$this->resultCode = 0;
		$this->error = null;
		$this->output = null;
	}

	public function setResultCode(int $code): void
	{
		$this->resultCode = $code;
	}

	public function setErrorMessage(string $error): void
	{
		$this->error = trim($error);
	}

	public function setOutput(string $output): void
	{
		$this->output = trim($output);
	}

	public function getResultCode(): int
	{
		return $this->resultCode;
	}

	public function getErrorMessage(): string|null
	{
		return $this->error;
	}

	public function getOutput(): string|null
	{
		return $this->output;
	}

	public function toArray(): array
	{
		return [
			'result_code'   => $this->getResultCode(),
			'error_message' => $this->getErrorMessage(),
			'output'        => $this->getOutput(),
		];
	}
}
