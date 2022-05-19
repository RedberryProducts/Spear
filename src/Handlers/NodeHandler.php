<?php

namespace Redberry\Spear\Handlers;

use Redberry\Spear\Interfaces\Data;
use Redberry\Spear\Interfaces\Handler;

class NodeHandler extends BaseHandler implements Handler
{
	public function __invoke(string $code = '', string $input = ''): Data
	{
		$this->setImage('node:14');
		$this->setCode($code);
		$this->setInput($input);
		$this->setInterpreter('node');

		return $this->interpret();
	}
}
