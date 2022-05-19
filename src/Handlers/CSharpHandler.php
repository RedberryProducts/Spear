<?php

namespace Redberry\Spear\Handlers;

use Redberry\Spear\Interfaces\Data;
use Redberry\Spear\Interfaces\Handler;

class CSharpHandler extends BaseHandler implements Handler
{
	/**
	 * After setting details runs compilation and starts C#.
	 */
	public function __invoke(string $code = '', string $input = ''): Data
	{
		$this->setImage('mono:6.12.0');
		$this->setCode($code);
		$this->setInput($input);
		$this->setCompiledFile('program.exe');
		$this->setCompliler('mcs');
		$this->setExecutor('mono');

		return $this->compileAndRun();
	}
}
