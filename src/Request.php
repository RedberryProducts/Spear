<?php

namespace Redberry\Spear;

use Exception;

class Request
{
	private string $socket;

	private string $version;

	/**
	 * @throws Exception
	 */
	public function __construct($socket = null)
	{
		if (!$socket)
		{
			if (is_null(config('spear')))
			{
				throw new Exception('Please publish the config file by running \'php artisan vendor:publish --tag=spear-config\'');
			}

			$this->socket = config('spear.socket');
		}

		$this->version = 'v1.41';
	}

	public function get(string $uri): array|object
	{
		$url = $this->buildURL($uri);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_UNIX_SOCKET_PATH, $this->socket);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$data = curl_exec($ch);
		return json_decode($data);
	}

    public function post(string $uri, string $image)
    {
        $url = $this->buildURL($uri);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_UNIX_SOCKET_PATH, $this->socket);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json' ));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, ["Image" => $image]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $data = curl_exec($ch);
        return json_decode($data);
    }

	private function buildURL($uri)
	{
		return 'http:/' . $this->version . $uri;
	}
}
