<?php

namespace Giunashvili\Spear\Interfaces;

interface Handler
{
	public function __invoke(string $code, string $input = ''): Data;
}
