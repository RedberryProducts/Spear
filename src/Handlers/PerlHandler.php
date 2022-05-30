<?php

namespace Redberry\Spear\Handlers;

use Redberry\Spear\Interfaces\Data;
use Redberry\Spear\Interfaces\Handler;

class PerlHandler extends BaseHandler implements Handler
{
	/**
	 * Prepare docker image, code to execute, input and then run the script.
	 */
	public function __invoke(string $code = '', string $input = ''): Data
	{
		$this->setImage('perl:5.34');
		$this->setCode($code);
		$this->setInput($input);
		$this->setInterpreter('perl');
		$this->setFileToInterpret('main.pl');

		return $this->interpret();
	}
}
