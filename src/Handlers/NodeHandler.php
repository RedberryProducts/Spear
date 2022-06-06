<?php

namespace Redberry\Spear\Handlers;

use Redberry\Spear\Interfaces\Data;
use Redberry\Spear\Interfaces\Handler;

class NodeHandler extends BaseHandler implements Handler
{
	/**
	 * Prepare docker image, code to execute, input and then run the script.
	 */
	public function __invoke(string $code = '', string $input = '', string $version = ''): Data
	{
		$this->setImage("node:$version");
		$this->setCode($code);
		$this->setInput($input);
		$this->setInterpreter('node');

		return $this->interpret();
	}
}
