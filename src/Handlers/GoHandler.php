<?php

namespace Giunashvili\Spear\Handlers;

use Giunashvili\Spear\Interfaces\Data;
use Giunashvili\Spear\Interfaces\Handler;

class GoHandler extends BaseHandler implements Handler
{
	public function __invoke(string $code = '', string $input = ''): Data
	{
		$this->setImage('golang:1.18.2');
		$this->setCode($code);
		$this->setInput($input);
		$this->setInterpreter('go run');
		$this->setFileToInterpret('main.go');

		return $this->interpret();
	}
}
