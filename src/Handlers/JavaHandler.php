<?php

namespace Redberry\Spear\Handlers;

use Redberry\Spear\Interfaces\Data;
use Redberry\Spear\Interfaces\Handler;

class JavaHandler extends BaseHandler implements Handler
{
	public function __invoke(string $code = '', string $input = ''): Data
	{
		$this->setImage('openjdk:11');
		$this->setCode($code);
		$this->setInput($input);
		$this->setInterpreter('java');
		$this->setFileToInterpret('program.java');

		return $this->interpret();
	}
}
