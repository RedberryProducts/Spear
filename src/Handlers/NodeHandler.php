<?php

namespace Giunashvili\Spear\Handlers;

use Giunashvili\Spear\Interfaces\Data;
use Giunashvili\Spear\Interfaces\Handler;

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