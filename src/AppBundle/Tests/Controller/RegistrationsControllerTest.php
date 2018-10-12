<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationsControllerTest extends WebTestCase
{
    public function testSenddata()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/sendData');
    }

}
