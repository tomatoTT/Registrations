<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TerytControllerTest extends WebTestCase
{
    public function testGetprovince()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getProvince');
    }

    public function testGetcounty()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getCounty');
    }

    public function testGetcommunity()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getCommunity');
    }

}
