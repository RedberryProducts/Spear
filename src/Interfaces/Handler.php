<?php

namespace Redberry\Spear\Interfaces;

interface Handler
{
	/**
	 * Set execution properties and execute the script.
	 */
	public function __invoke(string $code, string $input = '', string $version = ''): Data;
}
