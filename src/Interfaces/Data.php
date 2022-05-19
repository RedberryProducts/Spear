<?php

namespace Redberry\Spear\Interfaces;

interface Data
{
	/**
	 * setResultCode must be used in class.
	 */
	public function setResultCode(int $code): void;

	/**
	 * setErrorMessage must be used in class.
	 */
	public function setErrorMessage(string $error): void;

	/**
	 * setOutput must be used in class.
	 */
	public function setOutput(string $output): void;

	/**
	 * getResultCode must be used in class.
	 */
	public function getResultCode(): int;

	/**
	 * getErrorMessage must be used in class.
	 */
	public function getErrorMessage(): string|null;

	/**
	 * getOutput must be used in class.
	 */
	public function getOutput(): string|null;

	/**
	 * toArray must be used in class.
	 */
	public function toArray(): array;
}
