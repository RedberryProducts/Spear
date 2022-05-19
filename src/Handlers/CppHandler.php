<?php

namespace Redberry\Spear\Handlers;

use Redberry\Spear\Interfaces\Data;
use Redberry\Spear\Interfaces\Handler;

class CppHandler extends BaseHandler implements Handler
{
	/**
	 * Prepare docker image, code to execute, input and then run the script.
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
