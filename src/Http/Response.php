<?php


namespace Letexto\Http;


use Psr\Http\Message\ResponseInterface;

class Response
{
    protected ResponseInterface $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function getContent()
    {
        return (string) $this->response->getBody();
    }

    public function toArray()
    {
        return json_decode($this->getContent(), true);
    }

    public function toObject()
    {
        return json_decode($this->getContent());
    }
}