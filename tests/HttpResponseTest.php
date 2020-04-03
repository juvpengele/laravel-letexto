<?php


namespace Tests;


use Letexto\Http\Response;
use Orchestra\Testbench\TestCase;

class HttpResponseTest extends TestCase
{
    /** @test */
    public function it_can_render_a_content()
    {
        $response = new Response("lorem ipsum");

        $this->assertEquals("lorem ipsum", $response->getContent());
    }

    /**
     * @test
     */
    public function it_can_render_an_array()
    {
        $response = new Response('{"name": "juvenal"}');

        $this->assertIsArray($response->toArray());
    }

    /**
     * @test
     */
    public function it_can_render_an_object()
    {
        $response = new Response('{"name": "juvenal"}');

        $this->assertIsObject($response->toObject());
    }
}