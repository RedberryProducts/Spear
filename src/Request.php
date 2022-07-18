<?php

class Request 
{
    private string $socket;

    private string $version;

    public function __construct($socket = null)
    {
        if(! $socket) 
        {
            $this->socket = '/var/run/docker.sock';    
        }

        $this->version = 'v1.41';
    }

    public function get(string $uri): array|object
    {
        $url = $this->buildURL($uri);
        
        $data = '';
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_UNIX_SOCKET_PATH, $this->socket);
        // curl_setopt($ch, CURLOPT_BUFFERSIZE, 256);
        // curl_setopt($ch, CURLOPT_TIMEOUT, 1000000);
        curl_setopt($ch, CURLOPT_WRITEFUNCTION, fn($_, $chunck) => $data .= $chunck);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_exec($ch);

        return json_decode($data);
    }

    private function buildURL($uri) 
    {
        return 'http:/' . $this->version . $uri;
    }
}