<?php

namespace Giunashvili\Spear\Contracts;

interface Handler
{
	public function __invoke(string $code, string $input = ''): Data;
}
