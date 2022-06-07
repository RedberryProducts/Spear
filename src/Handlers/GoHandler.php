<?php

namespace Redberry\Spear\Handlers;

use Exception;
use Redberry\Spear\Interfaces\Data;
use Redberry\Spear\Interfaces\Handler;

class GoHandler extends BaseHandler implements Handler
{
	/**
	 * Available go versions list.
	 */
	private array $versions = [
		'1'    => 'golang:1',
		'1.17' => 'golang:1.17',
		'1.18' => 'golang:1.18',
	];

	/**
	 * Selected go version.
	 */
	private string $version;

	/**
	 * @throws Exception
	 */
	public function __construct(string $version)
	{
		parent::__construct();

		if (!isset($this->versions[$version]))
		{
			throw new Exception('Please, provide correct version.');
		}

		$this->version = $this->versions[$version];
	}

	/**
	 * Prepare docker image, code to execute, input and then run the script.
	 */
	public function __invoke(string $code = '', string $input = ''): Data
	{
		$this->setImage($this->version);
		$this->setCode($code);
		$this->setInput($input);
		$this->setInterpreter('go run');
		$this->setFileToInterpret('main.go');

		return $this->interpret();
	}
}
