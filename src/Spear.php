<?php

namespace Redberry\Spear;

use Exception;
use Redberry\Spear\Handlers\CppHandler;
use Redberry\Spear\Handlers\CSharpHandler;
use Redberry\Spear\Handlers\GoHandler;
use Redberry\Spear\Handlers\JavaHandler;
use Redberry\Spear\Handlers\PerlHandler;
use Redberry\Spear\Handlers\PHPHandler;
use Redberry\Spear\Handlers\PythonHandler;
use Redberry\Spear\Handlers\RubyHandler;
use Redberry\Spear\Handlers\RustHandler;
use Redberry\Spear\Interfaces\Data;
use Redberry\Spear\Handlers\NodeHandler;
use Redberry\Spear\Interfaces\Handler;

class Spear
{
	/**
	 * Select default handler.
	 */
	private Handler $selectedHandler;

	/**
	 * Returns execute code if it is callable otherwise throw error.
	 *
	 * @throws Exception
	 */
	public function execute(string $code, string $input = ''): Data
	{
		$handler = $this->getHandler();

		if (!is_callable($handler))
		{
			throw new Exception('Invalid handler provided!');
		}
		return $handler($code, $input);
	}

	/**
	 * Set programming language handler.
	 */
	public function handler(Handler $handler): self
	{
		$this->selectedHandler = $handler;
		return $this;
	}

	/**
	 * Get selected programming language handler.
	 */
	private function getHandler(): Handler
	{
		return $this->selectedHandler;
	}

	/**
	 * Use node handler.
	 *
	 * @throws Exception
	 */
	public function node(string $version = '14'): self
	{
		$handler = new NodeHandler($version);
		$this->handler($handler);
		return $this;
	}

	/**
	 * Use php handler.
	 */
	public function php(string $version = '8'): self
	{
		$handler = new PHPHandler($version);
		$this->handler($handler);
		return $this;
	}

	/**
	 * Use cpp handler.
	 */
	public function cpp(string $version = '14'): self
	{
		$handler = new CppHandler($version);
		$this->handler($handler);
		return $this;
	}

	/**
	 * Use python handler.
	 */
	public function python(string $version = '3.10'): self
	{
		$handler = new PythonHandler($version);
		$this->handler($handler);
		return $this;
	}

	/**
	 * Use ruby handler.
	 */
	public function ruby(string $version = '3'): self
	{
		$handler = new RubyHandler($version);
		$this->handler($handler);
		return $this;
	}

	/**
	 * Use rust handler.
	 */
	public function rust(string $version = '1'): self
	{
		$handler = new RustHandler($version);
		$this->handler($handler);
		return $this;
	}

	/**
	 * Use c# handler.
	 */
	public function cSharp(string $version = '6.12'): self
	{
		$handler = new CSharpHandler($version);
		$this->handler($handler);
		return $this;
	}

	/**
	 * Use go handler.
	 */
	public function go(string $version = '1.18'): self
	{
		$handler = new GoHandler($version);
		$this->handler($handler);
		return $this;
	}

	/**
	 * Use java handler.
	 */
	public function java(string $version = '11'): self
	{
		$handler = new JavaHandler($version);
		$this->handler($handler);
		return $this;
	}

	/**
	 * Use perl handler.
	 */
	public function perl(string $version = '5.34'): self
	{
		$handler = new PerlHandler($version);
		$this->handler($handler);
		return $this;
	}
}
