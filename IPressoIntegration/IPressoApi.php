<?php

namespace KarolNet\IPressoApiBundle\IPressoIntegration;

use GuzzleHttp\Client;
use KarolNet\IPressoApiBundle\IPressoApiResponseCode;
use KarolNet\Model\IPressoContactInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class IPressoApi
{
    /** @var  string */
    private $apiCustomerKey;

    /** @var  string */
    private $login;

    /** @var  string */
    private $password;

    /** @var  string */
    private $host;

    /** @var  \GuzzleHttp\Client */
    private $client;

    /** @var SessionInterface */
    private $session;

    public function __construct($apiCustomerKey, $login, $password, $host, SessionInterface $session)
    {
        $this->apiCustomerKey = $apiCustomerKey;
        $this->login = $login;
        $this->password = $password;
        $this->host = $host;
        $this->session = $session;
    }

    public function accessToken()
    {
        $this->client = new Client();

        $headers = ['ACCEPT: text/json', 'USER_AGENT: iPresso'];

        $res = $this->client->request('GET', $this->host . '/api/2/auth/' .$this->apiCustomerKey, [
            'auth' => [$this->login, $this->password],
            'headers' => $headers
        ]);

        $this->session->set('ipresso-access-token', $res->getBody()->getContents());
    }

    public function addContact(IPressoContactInterface $contact)
    {
//        $url = $this->host."/api/2/contact/".$contactId;
//        $token = $this->authenticate();
//        $headers = array();
//        $headers[] = 'ACCEPT: text/json';
//        $headers[] = 'USER_AGENT: iPresso';
//        $headers[] = 'IPRESSO_TOKEN: ' . $token;
//        $putFields['contact'] = $data;
//
//        $curl = curl_init();
//        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
//        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($putFields));
//        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
//        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
//        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
//        curl_setopt($curl, CURLOPT_URL, $url);
//        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//
//        $ret=curl_exec($curl);
//        curl_close($curl);
//
        $this->accessToken();
    }

    public function findContactBy(array $criteria)
    {
        $this->accessToken();
    }

    public function updateContact($externalId, IPressoContactInterface $contact)
    {
        $this->accessToken();
    }
}