<?php

namespace Giunashvili\Spear\Handlers;

use Giunashvili\Spear\Interfaces\Data;
use Giunashvili\Spear\Interfaces\Handler;

class RubyHandler extends BaseHandler implements Handler
{
	public function __invoke(string $code, string $input = ''): Data
	{
		$this->setImage('ruby:3.1');
		$this->setCode($code);
		$this->setInput($input);
		$this->setInterpreter('ruby');

		return $this->interpret();
	}
}
