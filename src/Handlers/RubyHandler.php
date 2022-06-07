<?php

namespace Redberry\Spear\Handlers;

use Exception;
use Redberry\Spear\Interfaces\Data;
use Redberry\Spear\Interfaces\Handler;

class RubyHandler extends BaseHandler implements Handler
{
	/**
	 * Selected ruby version.
	 */
	private string $version;

	/**
	 * Available ruby versions list.
	 */
	private array $versions = [
		'2'      => 'ruby:2',
		'3'      => 'ruby:3',
		'3.1'    => 'ruby:3.1',
		'3.2-rc' => 'ruby:3.2-rc',
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
	public function __invoke(string $code, string $input = ''): Data
	{
		$this->setImage($this->version);
		$this->setCode($code);
		$this->setInput($input);
		$this->setInterpreter('ruby');

		return $this->interpret();
	}
}
