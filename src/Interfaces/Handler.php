<?php

namespace Redberry\Spear\Interfaces;

interface Handler
{
	/**
	 * This invoke function must be used in class.
	 */
	public function __invoke(string $code, string $input = ''): Data;
}
