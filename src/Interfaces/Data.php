<?php

namespace Redberry\Spear\Interfaces;

interface Data
{
	/**
	 * Set result code from code execution into docker container.
	 */
	public function setResultCode(int $code): void;

	/**
	 * Set error message returned from code execution into docker container.
	 */
	public function setErrorMessage(string $error): void;

	/**
	 * Set output returned from code execution into docker container.
	 */
	public function setOutput(string $output): void;

	/**
	 * Get result code from code execution into docker container.
	 */
	public function getResultCode(): int;

	/**
	 * Get error message returned from code execution into docker container.
	 */
	public function getErrorMessage(): string|null;

	/**
	 * Get output from code execution into docker container.
	 */
	public function getOutput(): string|null;

	/**
	 * Return output, result code, and error message
	 */
	public function toArray(): array;
}
