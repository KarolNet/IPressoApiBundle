<?php

namespace KarolNet\IPressoApiBundle\Tests;

use KarolNet\IPressoApiBundle\IPressoIntegration\IPressoApi;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7;

class IPressoApiTest extends \PHPUnit_Framework_TestCase
{
    /** @var \GuzzleHttp\ClientInterface */
    private $guzzleClient;

    /** @var  \KarolNet\IPressoApiBundle\IPressoIntegration\IPressoApiInterface */
    private $iPressoApi;

    public function testSuccessAuthenticate()
    {
        $this->thereIsSuccessFullIPressoApiResponse();
        $this->thenIcanAuthenticate();
    }

    /**
     * @expectedException \Exception
     */
    public function testFailedAuthenticate()
    {
        $this->thereIsBadIPressoApiResponse();
        $this->thenIcantAuthenticate();
    }

    /** {@inheritdoc} */
    protected function setUp()
    {
        parent::setUp();
    }

    /** {@inheritdoc} */
    protected function tearDown()
    {
        $this->guzzleClient = null;
        $this->iPressoApi = null;
        parent::tearDown();
    }

    private function thenIcanAuthenticate()
    {
        $iPressoApi = new IPressoApi('foobar', 'login', 'pass', 'http://localhost', $this->guzzleClient);
        $token = $iPressoApi->accessToken();
        $this->assertEquals($token, 'access-token');
    }

    private function thenIcantAuthenticate()
    {
        $iPressoApi = new IPressoApi('foobar', 'login', 'pass', 'http://localhost', $this->guzzleClient);
        $iPressoApi->accessToken();
    }

    private function thereIsSuccessFullIPressoApiResponse()
    {
        $body = ['code'=> 200, 'data' => 'access-token', 'message' => 'OK'];
        $response = $this->mockResponse(200, json_encode($body));
        $handler = HandlerStack::create($response);
        $this->guzzleClient = new Client(['handler' => $handler]);
    }

    private function thereIsBadIPressoApiResponse()
    {
        $body = ['code'=> 200, 'message' => 'NOT_OK'];
        $response = $this->mockResponse(200, json_encode($body));
        $handler = HandlerStack::create($response);
        $this->guzzleClient = new Client(['handler' => $handler]);
    }

    private function mockResponse($status, $body = null)
    {
        $stream = Psr7\stream_for($body);

        return new MockHandler([
            new Response($status, ['json' => ['foo' => 'bar']], $stream)
        ]);
    }
}