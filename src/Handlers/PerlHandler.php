<?php

namespace Redberry\Spear\Handlers;

use Exception;
use Redberry\Spear\Interfaces\Data;
use Redberry\Spear\Interfaces\Handler;

class PerlHandler extends BaseHandler implements Handler
{
	/**
	 * Selected perl version.
	 */
	private string $version;

	/**
	 * Available perl versions list.
	 */
	public static array $versions = [
		'5'    => 'perl:5',
		'5.34' => 'perl:5.34',
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
		$this->setInterpreter('perl');
		$this->setFileToInterpret('main.pl');

		return $this->interpret();
	}
}
