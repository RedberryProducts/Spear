<?php

namespace Redberry\Spear\Commands;

use Illuminate\Console\Command;
use Redberry\Spear\Facades\Docker;
use Redberry\Spear\Handlers\CppHandler;
use Redberry\Spear\Handlers\CSharpHandler;
use Redberry\Spear\Handlers\GoHandler;
use Redberry\Spear\Handlers\JavaHandler;
use Redberry\Spear\Handlers\NodeHandler;
use Redberry\Spear\Handlers\PerlHandler;
use Redberry\Spear\Handlers\PHPHandler;
use Redberry\Spear\Handlers\PythonHandler;
use Redberry\Spear\Handlers\RubyHandler;
use Redberry\Spear\Handlers\RustHandler;
use Symfony\Component\Console\Terminal;

class DockerImagesList extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'spear:list';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'List all images';

	/**
	 * The terminal width resolver callback.
	 *
	 * @var \Closure|null
	 */
	protected static $terminalWidthResolver;

	/**
	 * Execute the console command.
	 */
	public function handle()
	{
		$languagesVersions = [
			'node'   => NodeHandler::$versions,
			'cpp'    => CppHandler::$versions,
			'csharp' => CSharpHandler::$versions,
			'go'     => GoHandler::$versions,
			'java'   => JavaHandler::$versions,
			'perl'   => PerlHandler::$versions,
			'php'    => PHPHandler::$versions,
			'python' => PythonHandler::$versions,
			'ruby'   => RubyHandler::$versions,
			'rust'   => RustHandler::$versions,
		];

		foreach ($languagesVersions as $key => $versions)
		{
			$resultCode = $this->checkImagesVersions($versions);

			$terminalWidth = $this->getTerminalWidth();
			$maxLanguage = mb_strlen($key);

			$dots = str_repeat('.', max(
				$terminalWidth - $maxLanguage - 30,
				0
			));

			$result = $resultCode ? ' [<fg=green>Pulled</>]' : ' [<fg=red>Not Pulled</>]';

			$this->line(strtoupper("<options=bold>$key</>") . $dots . $result);
		}
	}

	/**
	 * Get versions of docker images and check them out.
	 */
	private function checkImagesVersions($versions)
	{
		$resultCode = true;

		foreach ($versions as $version)
		{
			$resultCode = Docker::imageExistsLocally($version);
			if (!$resultCode)
			{
				return false;
			}
		}

		return $resultCode;
	}

	/**
	 * Get the terminal width.
	 */
	private function getTerminalWidth()
	{
		return is_null(static::$terminalWidthResolver)
			? (new Terminal)->getWidth()
			: call_user_func(static::$terminalWidthResolver);
	}
}
