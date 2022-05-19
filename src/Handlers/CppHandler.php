<?php

namespace Redberry\Spear\Handlers;

use Redberry\Spear\Interfaces\Data;
use Redberry\Spear\Interfaces\Handler;

class CppHandler extends BaseHandler implements Handler
{
	/**
	 * After setting details runs compilation and starts CPP.
	 */
	public function __invoke(string $code = '', string $input = ''): Data
	{
		$this->setImage('giunashvili/cpp');
		$this->setCode($code);
		$this->setInput($input);
		$this->setCompiledFile('a.out');
		$this->setCompliler('g++ -x c++');

		return $this->compileAndRun();
	}
}
