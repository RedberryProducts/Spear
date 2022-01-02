<?php

namespace Giunashvili\Spear\Handlers;

use Giunashvili\Spear\Interfaces\Data;
use Giunashvili\Spear\Interfaces\Handler;

class PHPHandler extends BaseHandler implements Handler
{
    public function __invoke(string $code, string $input = ''): Data
    {
        $this->setImage('php:8.1-cli');
		$this->setCode($code);
		$this->setInput($input);
		$this->setInterpreter('php');
		
		return $this->interpret();
    }
}