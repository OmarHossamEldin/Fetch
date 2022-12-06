<?php

namespace Reneknox\Fetch;

class HttpRequest
{
    private $curl;

    private array $headers;

    private string $baseUrl;

    public function __construct(string $baseUrl)
    {
        $this->curl = curl_init();
        $this->baseUrl = $baseUrl;
    }

    public function set_url(string $url): void
    {
        $this->baseUrl .= $url;
        curl_setopt($this->curl, CURLOPT_URL, $this->baseUrl);
    }

    public function set_headers(array $headers): void
    {
        $this->headers = $headers;
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->headers);
    }

    public function get($data = []): array
    {
        curl_setopt($this->curl, CURLOPT_HTTPGET, true);
        return $this->send_request($data);
    }

    public function post($data = []): array
    {
        curl_setopt($this->curl, CURLOPT_POST, true);
        return $this->send_request($data);
    }


    public function patch($data = []): array
    {
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
        return $this->send_request($data);
    }

    public function put($data = []): array
    {
        curl_setopt($this->curl, CURLOPT_PUT, true);
        return $this->send_request($data);
    }

    public function delete($data = []): array
    {
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
        return $this->send_request($data);
    }

    private function send_request($data): array
    {
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);

        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        $body = curl_exec($this->curl);
        curl_close($this->curl);

        return [
            'body' => $this->parsing_body($body),
            'statusCode' => curl_getinfo($this->curl,  CURLINFO_RESPONSE_CODE)
        ];
    }

    private function parsing_body(?string $response)
    {
        return isset($this->headers['Content-Type']) && $this->headers['Content-Type'] === 'application/xml' ?
            $response : json_decode($response, true);
    }
}
