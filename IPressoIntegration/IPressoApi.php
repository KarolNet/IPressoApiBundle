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
        $uri = $this->host . 'api/2/auth/' . $this->apiCustomerKey;
        $response = $this->client->request('GET', $uri, [
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
    public function addContact(IPressoContactInterface $contact, $accessToken)
    {
        $uri = $this->host . '/api/2/contact/';

        try {
            $response = $this->client->request('POST', $uri, [
                    RequestOptions::HEADERS => $this->getHeaders($accessToken),
                    RequestOptions::FORM_PARAMS => $this->getContactData($contact)
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
    public function updateContact($contactId, IPressoContactInterface $contact, $accessToken)
    {
        $uri = $this->host . '/api/2/contact/' . $contactId;

        try {
            $response = $this->client->request('POST', $uri, [
                    RequestOptions::HEADERS => $this->getHeaders($accessToken),
                    RequestOptions::FORM_PARAMS => $this->getContactData($contact)
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
    public function fetchContact($contactId, $accessToken)
    {
        $uri = $this->host . '/api/2/contact/' . $contactId;

        try {
            $response = $this->client->request('GET', $uri, [
                    RequestOptions::HEADERS => $this->getHeaders($accessToken)
                ]
            );
        } catch (RequestException $e) {;
            return null;
        }

        return json_decode($response->getBody()->getContents(), TRUE);
    }

    /**
     * {@inheritdoc}
     */
    public function deleteContact($contactId, $accessToken)
    {
        $uri = $this->host . '/api/2/contact/' . $contactId;

        try {
            $response = $this->client->request('DELETE', $uri, [
                    RequestOptions::HEADERS => $this->getHeaders($accessToken)
                ]
            );
        } catch (RequestException $e) {;
            return null;
        }

        return json_decode($response->getBody()->getContents(), TRUE);
    }

    private function getContactData(IPressoContactInterface $contact)
    {
        $contactData = [];
        $contactData['contact'][] = (array) $contact;

        return $contactData;
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