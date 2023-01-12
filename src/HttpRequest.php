<?php

namespace Reneknox\Fetch;

class HttpRequest
{
    private $curl;
    private array $headers;
    private string $baseUrl;

    public function __construct()
    {
        $this->curl = curl_init();
    }

    public function set_base_url(string $baseUrl): self
    {
        $this->baseUrl = $baseUrl;
        return $this;
    }

    public function set_headers(array $headers): self
    {
        $this->headers = $this->parsing_headers($headers);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->headers);
        return $this;
    }

    public function get(string $url): array
    {
        $this->baseUrl .= $url;
        curl_setopt($this->curl, CURLOPT_URL, $this->baseUrl);
        curl_setopt($this->curl, CURLOPT_HTTPGET, true);
        return $this->send_request();
    }

    public function post(string $url, $data = []): array
    {
        $this->baseUrl .= $url;
        curl_setopt($this->curl, CURLOPT_URL, $this->baseUrl);
        curl_setopt($this->curl, CURLOPT_POST, true);
        return $this->send_request($data);
    }


    public function patch(string $url, $data = []): array
    {
        $this->baseUrl .= $url;
        curl_setopt($this->curl, CURLOPT_URL, $this->baseUrl);
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
        return $this->send_request($data);
    }

    public function put(string $url, $data = []): array
    {
        $this->baseUrl .= $url;
        curl_setopt($this->curl, CURLOPT_URL, $this->baseUrl);
        curl_setopt($this->curl, CURLOPT_PUT, true);
        return $this->send_request($data);
    }

    public function delete(string $url, $data = []): array
    {
        $this->baseUrl .= $url;
        curl_setopt($this->curl, CURLOPT_URL, $this->baseUrl);
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
        return $this->send_request($data);
    }

    private function send_request($data = []): array
    {
        if (!empty($data)) {
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
        }

        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        $body = curl_exec($this->curl);
        $statusCode = curl_getinfo($this->curl, CURLINFO_RESPONSE_CODE);
        curl_close($this->curl);

        return [
            'body' => $this->parsing_body($body),
            'statusCode' => $statusCode
        ];
    }

    private function parsing_body(?string $response)
    {
        if(in_array('Content-Type: application/json',$this->headers,true))
        {
           return json_decode($response, true); 
        }
        return $response;
    }

    private function parsing_headers(array $headers): array
    {
        return array_map(fn($header, $key) => "$key: $header", $headers, array_keys($headers));
    }
}
