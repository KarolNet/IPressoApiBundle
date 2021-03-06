<?php

namespace KarolNet\IPressoApiBundle\Tests;

use KarolNet\IPressoApiBundle\Contact\IPressoContact;
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

    public function testUpdateContact()
    {
        $this->thereIsClientUpdateResponse();
        $this->thenClientUpdate();
    }

    public function testFetchContact()
    {
        $this->thereIsContactIdAndIHaveFetchDataForIt();
        $this->thenDataIsFetched();
    }

    public function testDeleteContact()
    {
        $this->thereIsDeleteContactResponse();
        $this->thenContactIsDeleted();
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

    private function thereIsDeleteContactResponse()
    {
        $this->setGuzzleClientResponse(200, '{"code":200,"data":true,"message":"OK"}');
    }

    private function thenContactIsDeleted()
    {
        $iPressoApi = $this->getIPressoApi();
        $this->assertEquals('OK', $iPressoApi->deleteContact('26413', 'token')['message']);
    }

    private function thereIsContactIdAndIHaveFetchDataForIt()
    {
        $this->setGuzzleClientResponse(200, '{"code":200,"data":{"contact":{
                  "idContact":26413,
                  "fname":"Jan",
                  "lname":"Kowalski",
                  "vocative":"Janie",
                  "name":"Janek",
                  "email":"jan.kowalski@email.com",
                  "invalidEmail":"0",
                  "phone":"3223456789",
                  "mobile":"123456789",
                  "postCode":"40-402",
                  "street":"",
                  "buildingNumber":"",
                  "flatNumber":"",
                  "city":"Katowice",
                  "country":"Poland",
                  "www":"http://www.example.pl",
                  "workPosition":"",
                  "company":"",
                  "createDate":"2015-02-26 10:49:40",
                  "modifyTime":"2015-03-05 07:52:42",
                  "leadScoring":"3",
                  "type":false,
                  "sex":4,
                  "shoes_size":false,
                  "agreement":{"2":"Agreement name 1", "4":"Agreement name 2","36":"Agreement name 3"},
                  "contactMonitoringIframe":""}},"message":"OK"}');
    }

    private function thenDataIsFetched()
    {
        $iPressoApi = $this->getIPressoApi();
        $this->assertEquals('26413', $iPressoApi->fetchContact('26413', 'ssss')['data']['contact']['idContact']);
    }

    private function thereIsClientUpdateResponse()
    {
        $this->setGuzzleClientResponse(303, '{"code":303,"data":{"id":26416,"monitoringCode":""},"message":"Not Change - the same contact already exists","errorCode":1 }');
    }

    private function thenClientUpdate()
    {
        $contact = new IPressoContact('aaa', 'b','c', 'd');
        $iPressoApi = $this->getIPressoApi();
        $response = $iPressoApi->updateContact(26416, $contact, 'token');
        $this->assertEquals(303, $response['code']);
    }

    private function thenIcanAuthenticate()
    {
        $iPressoApi = $this->getIPressoApi();
        $token = $iPressoApi->accessToken();
        $this->assertEquals($token, 'cfa9eb3af4f7f8b7c39a3213213431fdsff8e571');
    }

    private function thenIcantAuthenticate()
    {
        $iPressoApi = $this->getIPressoApi();
        $iPressoApi->accessToken();
    }

    private function thereIsSuccessFullIPressoApiResponse()
    {
        $this->setGuzzleClientResponse(200, '{"code":200,"data":"cfa9eb3af4f7f8b7c39a3213213431fdsff8e571","message":"OK"}');
    }

    private function thereIsClientExistResponse()
    {
        $this->setGuzzleClientResponse(200, '{"code":200,"data":{"contact":["26413"]},"message":"OK"}');
    }

    private function thereIsClientNonExistResponse()
    {
        $this->setGuzzleClientResponse(404, '{"code":404,"data":{"contact":[]},"message":"Not Found","errorCode":3}');
    }

    private function thenClientNotFound()
    {
        $iPressoApi = $this->getIPressoApi();
        $this->assertNull($iPressoApi->findContact('not-existing@contact.pl', 'ssss'));
    }

    private function thenFundedClients()
    {
        $iPressoApi = $this->getIPressoApi();
        $iPressoApi->findContact('test@user.pl', 'aaaaaa');
    }

    private function thereIsBadIPressoApiResponse()
    {
        $this->setGuzzleClientResponse(401, '{"code":401,"message":"Unauthorized: Wrong customer token"}');
    }

    private function setGuzzleClientResponse($httpStatus, $jsonString)
    {
        $response = $this->mockResponse($httpStatus, $jsonString);
        $handler = HandlerStack::create($response);
        $this->guzzleClient = new Client(['handler' => $handler]);
    }

    private function getIPressoApi()
    {
        return new IPressoApi('foobar', 'login', 'pass', 'http://localhost', $this->guzzleClient);
    }

    private function mockResponse($status, $body = null)
    {
        $stream = Psr7\stream_for($body);

        return new MockHandler([
            new Response($status, ['json' => ['foo' => 'bar']], $stream)
        ]);
    }
}