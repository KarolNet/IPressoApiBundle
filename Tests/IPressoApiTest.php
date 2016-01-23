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

    public function testItCanFindContactSuccessfully()
    {
        $this->thereIsClientExistResponse();
        $this->thenFundedClients();
    }

    public function testItReturnNullIfContactDoesNotExist()
    {
        $this->thereIsClientNonExistResponse();
        $this->thenClientNotFound();
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
        $this->assertEquals($token, 'cfa9eb3af4f7f8b7c39a3213213431fdsff8e571');
    }

    private function thenIcantAuthenticate()
    {
        $iPressoApi = new IPressoApi('foobar', 'login', 'pass', 'http://localhost', $this->guzzleClient);
        $iPressoApi->accessToken();
    }

    private function thereIsSuccessFullIPressoApiResponse()
    {
        $response = $this->mockResponse(200, '{"code":200,"data":"cfa9eb3af4f7f8b7c39a3213213431fdsff8e571","message":"OK"}');
        $handler = HandlerStack::create($response);
        $this->guzzleClient = new Client(['handler' => $handler]);
    }

    private function thereIsClientExistResponse()
    {
        $response = $this->mockResponse(200, '{"code":200,"data":{"contact":["26413"]},"message":"OK"}');
        $handler = HandlerStack::create($response);
        $this->guzzleClient = new Client(['handler' => $handler]);
    }

    private function thereIsClientNonExistResponse()
    {
        $response = $this->mockResponse(404, '{"code":404,"data":{"contact":[]},"message":"Not Found","errorCode":3}');
        $handler = HandlerStack::create($response);
        $this->guzzleClient = new Client(['handler' => $handler]);
    }

    private function thenClientNotFound()
    {
        $iPressoApi = new IPressoApi('foobar', 'login', 'pass', 'http://localhost', $this->guzzleClient);
        $this->assertNull($iPressoApi->findContact('not-existing@contact.pl', 'ssss'));
    }

    private function thenFundedClients()
    {
        $iPressoApi = new IPressoApi('foobar', 'login', 'pass', 'http://localhost', $this->guzzleClient);
        $iPressoApi->findContact('test@user.pl', 'aaaaaa');
    }

    private function thereIsBadIPressoApiResponse()
    {
        $response = $this->mockResponse(401, '{"code":401,"message":"Unauthorized: Wrong customer token"}');
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