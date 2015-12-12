<?php

namespace KarolNet\IPressoApiBundle\Service;

use GuzzleHttp\Client;

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

    public function __construct($apiCustomerKey, $login, $password, $host)
    {
        $this->apiCustomerKey = $apiCustomerKey;
        $this->login = $login;
        $this->password = $password;
        $this->host = $host;
    }

    public function authenticate()
    {
        $client = new Client();
        $res = $client->request('GET', $this->host . '/' .$this->apiCustomerKey, [
            'auth' => [$this->login, $this->password]
        ]);

        return $res->getStatusCode();
    }
}