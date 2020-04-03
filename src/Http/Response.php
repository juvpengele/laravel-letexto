<?php


namespace Letexto\Http;


class Response
{
    protected string $content = "";

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function toArray()
    {
        return json_decode($this->content, true);
    }

    public function toObject()
    {
        return json_decode($this->content);
    }
}