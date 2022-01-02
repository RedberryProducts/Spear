<?php

namespace Giunashvili\Spear\Contracts;

interface Data
{
	public function setResultCode(int $code): void;

	public function setErrorMessage(string $error): void;

	public function setOutput(string $output): void;

	public function getResultCode(): int;

	public function getErrorMessage(): string|null;

	public function getOutput(): string|null;

	public function toArray(): array;
}
