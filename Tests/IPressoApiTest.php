<?php

namespace KarolNet\IPressoApiBundle\Tests;

use KarolNet\IPressoApiBundle\IPressoIntegration\IPressoApi;

class IPressoApiTest extends \PHPUnit_Framework_TestCase
{
    public function testAuthenticate()
    {
        $apiCustomerKey = 'a';
        $login = 'b';
        $password = 'c';
        $host = 'http://localhost';

        $iPressoApi = new IPressoApi($apiCustomerKey, $login, $password, $host);

//        $iPressoApi->authenticate();
    }
}