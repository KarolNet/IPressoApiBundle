<?php

namespace KarolNet\IPressoApiBundle\IPressoIntegration;

use GuzzleHttp\ClientInterface;
use KarolNet\IPressoApiBundle\Contact\IPressoContactInterface;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Exception\RequestException;

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
        $response = $this->client->request('GET', $this->host . 'api/2/auth/' . $this->apiCustomerKey, [
            RequestOptions::AUTH => [$this->login, $this->password],
            RequestOptions::HEADERS => $this->getHeaders()
        ]);

        $contentArray = json_decode($response->getBody()->getContents(), TRUE);

        if ($contentArray['code'] == 200 && $contentArray['message'] == 'OK') {
            return $contentArray['data'];
        }

        throw new \Exception($contentArray['message']);
    }

    /**
     * {@inheritdoc}
     */
    public function findContact($email, $accessToken)
    {
        $url = $this->host . '/api/2/contact/search';
        try {
            $response = $this->client->request('POST', $url, [
                RequestOptions::HEADERS => $this->getHeaders($accessToken),
                RequestOptions::FORM_PARAMS  => [
                    'contact' => [
                        'email' => $email
                    ]
                ]
            ]);
        } catch (RequestException $e) {
            return null;
        }

        return json_decode($response->getBody()->getContents(), TRUE);
    }

    /**
     * {@inheritdoc}
     */
    public function addContact(\ArrayAccess $contact, $accessToken)
    {
        $uri = $this->host . '/api/2/contact/';

        $contactData = [];
        $contactData['contact'][] = (array) $contact;

        try {
            $response = $this->client->request('POST', $uri, [
                    RequestOptions::HEADERS => $this->getHeaders($accessToken),
                    RequestOptions::FORM_PARAMS => $contactData
                ]
            );
        } catch(RequestException $e) {
            return null;
        }

        return json_decode($response->getBody()->getContents(), TRUE);
    }

    /**
     * {@inheritdoc}
     */
    public function updateContact($contactId, IPressoContactInterface $contact, $token)
    {
        // TODO: Implement findContact() method.
    }

    private function getHeaders($accessToken = null)
    {
        $headers = [
            'ACCEPT' => 'text/json',
            'USER_AGENT' => 'iPresso',
            'IPRESSO_TOKEN' => $accessToken
        ];

        if ($accessToken) {
            $headers['IPRESSO_TOKEN'] =  $accessToken;
        }

        return $headers;
    }
}