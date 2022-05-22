<?php

namespace Redberry\Spear\Handlers;

use Redberry\Spear\Interfaces\Data;
use Redberry\Spear\Interfaces\Handler;

class PHPHandler extends BaseHandler implements Handler
{
	/**
	 * Prepare docker image, code to execute, input and then run the script.
	 */
	public function __invoke(string $code, string $input = ''): Data
	{
		$this->setImage('giunashvili/php');
		$this->setCode($code);
		$this->setInput($input);
		$this->setInterpreter('php');

		return $this->interpret();
	}
}
