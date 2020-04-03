<?php


namespace Tests;


use Letexto\Http\Requests\HttpRequest;
use Orchestra\Testbench\TestCase;

class HttpRequestTest extends TestCase
{

    /** @test */
    public function it_can_format_url_params()
    {
        $httpRequest = new HttpRequest();
        $httpRequest->filterBy(["name" => "juvenal", "age" => "30"]);

        $this->assertEquals("name=juvenal&age=30", $httpRequest->getFormattedQueryParams());
    }

    /** @test */
    public function it_can_build_url()
    {
        $httpRequest = new HttpRequest();
        $httpRequest->filterBy(["name" => "juvenal", "age" => "30"]);

        $this->assertEquals("?name=juvenal&age=30", $httpRequest->getUri());
    }

}