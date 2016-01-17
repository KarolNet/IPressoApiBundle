<?php

namespace KarolNet\IPressoApiBundle\IPressoIntegration;

use GuzzleHttp\ClientInterface;
use KarolNet\Contact\IPressoContactInterface;

class IPressoApi implements IPressoApiInterface
{
    /** @var  string */
    private $apiCustomerKey;

    /** @var  string */
    private $login;

    /** @var  string */
    private $password;

    /** @var  string */
    private $host;

    /** @var  ClientInterface */
    private $client;

    public function __construct($apiCustomerKey, $login, $password, $host, ClientInterface $client)
    {
        $this->apiCustomerKey = $apiCustomerKey;
        $this->login = $login;
        $this->password = $password;
        $this->host = $host;
        $this->client = $client;
    }

    public function accessToken()
    {
        $headers = ['ACCEPT: text/json', 'USER_AGENT: iPresso'];

        $res = $this->client->request('GET', $this->host . '/api/2/auth/' .$this->apiCustomerKey, [
            'auth' => [$this->login, $this->password],
            'headers' => $headers
        ]);

        $content =  $res->getBody()->getContents();

        $contentArray = json_decode($content, true);

        if ($contentArray['code'] == 200 && $contentArray['message'] == 'OK') {
            return $contentArray['data'];
        }

        throw new \Exception($contentArray['message']);
    }

    /**
     * {@inheritdoc}
     */
    public function findContact($email, $token)
    {
        // TODO: Implement findContact() method.
    }

    /**
     * {@inheritdoc}
     */
    public function addContact(IPressoContactInterface $contact, $accessToken)
    {
        // TODO: Implement findContact() method.
    }

    /**
     * {@inheritdoc}
     */
    public function updateContact($contactId, IPressoContactInterface $contact, $token)
    {
        // TODO: Implement findContact() method.
    }
}