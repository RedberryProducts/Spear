<?php

namespace Redberry\Spear;

use Redberry\Spear\Handlers\GoHandler;
use Redberry\Spear\Handlers\JavaHandler;
use Redberry\Spear\Handlers\PerlHandler;
use Redberry\Spear\Interfaces\Data;
use Redberry\Spear\Handlers\PHPHandler;
use Redberry\Spear\Handlers\CppHandler;
use Redberry\Spear\Handlers\CSharpHandler;
use Redberry\Spear\Handlers\NodeHandler;
use Redberry\Spear\Handlers\PythonHandler;
use Redberry\Spear\Handlers\RubyHandler;
use Redberry\Spear\Handlers\RustHandler;

class Spear
{
	const CPP = 'cpp';

	const NODE_14 = 'node:14';

	const PHP_8 = 'php:8.1';

	const PYTHON_3 = 'python:3.10';

	const RUBY_3 = 'ruby:3';

	const RUST_1 = 'rust:1';

	const C_SHARP = 'csharp';

	const GO_LANG = 'golang:1.18';

	const JAVA = 'openjdk:11';

	const PERL = 'perl:5.34';

	/**
	 * Returns array of variable with relevant class names.
	 */
	private array $handlers = [
		self::CPP      => CppHandler::class,
		self::NODE_14  => NodeHandler::class,
		self::PHP_8    => PHPHandler::class,
		self::PYTHON_3 => PythonHandler::class,
		self::RUBY_3   => RubyHandler::class,
		self::RUST_1   => RustHandler::class,
		self::C_SHARP  => CSharpHandler::class,
		self::GO_LANG  => GoHandler::class,
		self::JAVA     => JavaHandler::class,
		self::PERL     => PerlHandler::class,
	];

	/**
	 * Sets default of language variable.
	 */
	public function __construct(private string $language = self::CPP)
	{
	}

	/**
	 * Returns execute code if it is callable otherwise throw error.
	 */
	public function execute(string $code, string $input = ''): Data
	{
		$handlerClass = $this->getHandler();
		$handler = new $handlerClass;
		if (!is_callable($handler))
		{
			throw new \Exception('Invalid handler provided!');
		}
		return $handler($code, $input);
	}

	/**
	 * Set language variable according to the property value.
	 */
	public function handler(string $language): self
	{
		$this->language = $language;
		return $this;
	}

	/**
	 * Returns entered language.
	 */
	private function getHandler(): string
	{
		return $this->handlers[$this->language];
	}
}
