<?php

namespace Redberry\Spear\Handlers;

use Redberry\Spear\Interfaces\Data;
use Redberry\Spear\Interfaces\Handler;

class PythonHandler extends BaseHandler implements Handler
{
	public function __invoke(string $code, string $input = ''): Data
	{
		$this->setImage('python:3.10');
		$this->setCode($code);
		$this->setInput($input);
		$this->setInterpreter('python3');

		return $this->interpret();
	}
}
