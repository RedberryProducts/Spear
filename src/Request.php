<?php

namespace Redberry\Spear;

use CurlHandle;
use Exception;

class Request
{
	/**
	 * TCP or unix socket that will
	 * Be used as a docker server.
	 */
	private string $socket;

	/**
	 * Docker Engine API version.
	 */
	private string $version;

	/**
	 * cURL resource that will be used for
	 * Sending request to the docker server.
	 */
	private CurlHandle $curlHandle;

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

		$this->createCURL();
	}

	/**
	 * Create cURL resource.
	 */
	private function createCURL()
	{
		$this->curlHandle = curl_init();
		curl_setopt($this->curlHandle, CURLOPT_UNIX_SOCKET_PATH, $this->socket);
		curl_setopt($this->curlHandle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->curlHandle, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
	}

	/**
	 * Set cURL url.
	 */
	private function setCurlUrl(string $uri): void
	{
		$url = $this->buildURL($uri);
		curl_setopt($this->curlHandle, CURLOPT_URL, $url);
	}

	/**
	 * Set request body and ultimately make the request
	 * Method as Post.
	 */
	private function setRequestBody($data): void
	{
		if (gettype($data) === 'array')
		{
			curl_setopt(
				$this->curlHandle,
				CURLOPT_POSTFIELDS,
				json_encode($data),
			);
		}
	}

	/**
	 * Make curl request to Docker server.
	 */
	private function makeRequest()
	{
		$data = curl_exec($this->curlHandle);
		$data = preg_replace('#\\x1b[[][^A-Za-z]*[A-Za-z]#', '', $data);
		$data = trim($data);

		$decodedData = json_decode($data);

		if (is_null($decodedData))
		{
			return (object) [
				'data' => $data,
			];
		}

		return json_decode($data);
	}

	/**
	 * Make get request to the Docker server.
	 */
	public function get(string $uri): array|object|string
	{
		$this->createCURL();
		$this->setCurlUrl($uri);
		return $this->makeRequest();
	}

	/**
	 * Make post request to the Docker server.
	 */
	public function post(string $uri, $body = []): array|object|string
	{
		$this->createCURL();
		$url = $this->buildURL($uri);
		$this->setCurlUrl($url);
		$this->setRequestBody($body);
		return $this->makeRequest();
	}

	/**
	 * Make delete request to the Docker server.
	 */
	public function delete(string $uri, $body = null): array|object|string
	{
		$this->createCURL();
		$url = $this->buildURL($uri);
		$this->setCurlUrl($url);
		$this->setRequestBody($body);
		curl_setopt($this->curlHandle, CURLOPT_CUSTOMREQUEST, 'DELETE');
		return $this->makeRequest();
	}

	/**
	 * Build url with Docker Engine API version and
	 * Provided uri.
	 */
	private function buildURL($uri)
	{
		return 'http:/' . $this->version . $uri;
	}
}
