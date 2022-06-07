<?php

namespace Redberry\Spear\Handlers;

use Exception;
use Redberry\Spear\Interfaces\Data;
use Redberry\Spear\Interfaces\Handler;

class NodeHandler extends BaseHandler implements Handler
{
	/**
	 * Selected node version.
	 */
	private string $version;

	/**
	 * Available node versions list.
	 */
	private array $versions = [
		'14' => 'node:14',
		'16' => 'node:16',
		'17' => 'node:17',
		'18' => 'node:18',
	];

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
		$this->setInterpreter('node');

		return $this->interpret();
	}
}
