<?php

namespace Redberry\Spear\Handlers;

use Redberry\Spear\Interfaces\Data;
use Redberry\Spear\Interfaces\Handler;

class RustHandler extends BaseHandler implements Handler
{
	/**
	 * After setting details runs compilation and starts Rust.
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
