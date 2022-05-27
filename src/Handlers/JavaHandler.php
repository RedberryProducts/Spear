<?php

namespace Redberry\Spear\Handlers;

use Redberry\Spear\Interfaces\Data;
use Redberry\Spear\Interfaces\Handler;

class JavaHandler extends BaseHandler implements Handler
{
	/**
	 * Prepare docker image, code to execute, input and then run the script.
	 */
	public function __invoke(string $code = '', string $input = ''): Data
	{
		$this->setImage('openjdk:11');
		$this->setCode($code);
		$this->setInput($input);
		$this->setFileToComplile('Main.java');
		$this->setCompiledFile('Main');
		$this->setCompliler('javac');
		$this->setExecutor('java');

		return $this->compileAndRun();
	}
}
