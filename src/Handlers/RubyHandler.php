<?php

namespace Redberry\Spear\Handlers;

use Redberry\Spear\Interfaces\Data;
use Redberry\Spear\Interfaces\Handler;

class RubyHandler extends BaseHandler implements Handler
{
	/**
	 * Prepare docker image, code to execute, input and then run the script.
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
