<?php

namespace Redberry\Spear\Handlers;

use Redberry\Spear\Interfaces\Data;
use Redberry\Spear\Interfaces\Handler;

class PHPHandler extends BaseHandler implements Handler
{
	/**
	 * After setting details runs compilation and starts PHP.
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
