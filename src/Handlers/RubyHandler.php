<?php

namespace Redberry\Spear\Handlers;

use Redberry\Spear\Interfaces\Data;
use Redberry\Spear\Interfaces\Handler;

class RubyHandler extends BaseHandler implements Handler
{
	/**
	 * After setting details runs compilation and starts Ruby.
	 */
	public function __invoke(string $code, string $input = ''): Data
	{
		$this->setImage('ruby:3.1');
		$this->setCode($code);
		$this->setInput($input);
		$this->setInterpreter('ruby');

		return $this->interpret();
	}
}
