<?php

namespace Giunashvili\Spear\Handlers;

use Giunashvili\Spear\Contracts\Data;
use Giunashvili\Spear\Contracts\Handler;
use Giunashvili\Spear\Handlers\BaseHandler;

class CppHandler extends BaseHandler implements Handler
{
	public function __invoke(string $code = '', string $input = ''): Data
	{
		$this->setImage('giunashvili/cpp');
		$this->setCode($code);
		$this->setInput($input);
		$this->setCompliler('g++ -x c++');
		
		return $this->compileAndRun();
	}
}
