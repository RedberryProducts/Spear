<?php

namespace Redberry\Spear\Handlers;

use Redberry\Spear\Interfaces\Data;
use Redberry\Spear\Interfaces\Handler;

class PythonHandler extends BaseHandler implements Handler
{
	/**
	 * Prepare docker image, code to execute, input and then run the script.
	 */
	public function __invoke(string $code, string $input = ''): Data
	{
		$this->setImage('python:3.10');
		$this->setCode($code);
		$this->setInput($input);
		$this->setInterpreter('python3');

		return $this->interpret();
	}
}
