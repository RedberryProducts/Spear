<?php

namespace Redberry\Spear\Handlers;

use Exception;
use Redberry\Spear\Interfaces\Data;
use Redberry\Spear\Interfaces\Handler;

class PythonHandler extends BaseHandler implements Handler
{
	/**
	 * Selected python version.
	 */
	private string $version;

	/**
	 * Available python versions list.
	 */
	public static array $versions = [
		'3.7'      => 'python:3.7',
		'3.8'      => 'python:3.8',
		'3.9'      => 'python:3.9',
		'3.10'     => 'python:3.10',
		'3.11-rc'  => 'python:3.11-rc',
	];

	/**
	 * @throws Exception
	 */
	public function __construct(string $version)
	{
		parent::__construct();

		if (!isset(self::$versions[$version]))
		{
			throw new Exception('Please, provide correct version.');
		}

		$this->version = self::$versions[$version];
	}

	/**
	 * Prepare docker image, code to execute, input and then run the script.
	 */
	public function __invoke(string $code, string $input = ''): Data
	{
		$this->setImage($this->version);
		$this->setCode($code);
		$this->setInput($input);
		$this->setInterpreter('python3');

		return $this->interpret();
	}
}
