<?php

namespace Redberry\Spear\Handlers;

use Redberry\Spear\Interfaces\Data;
use Redberry\Spear\Interfaces\Handler;

class RustHandler extends BaseHandler implements Handler
{
	/**
	 * Prepare docker image, code to execute, input and then run the script.
	 */
	public function __invoke(string $code, string $input = ''): Data
	{
		$this->setImage('rust:1.57');
		$this->setCode($code);
		$this->setInput($input);
		$this->setCompliler('rustc');
		$this->setCompiledFile('program');

		return $this->compileAndRun();
	}
}
