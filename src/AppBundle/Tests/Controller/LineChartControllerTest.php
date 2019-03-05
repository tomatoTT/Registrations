<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LineChartControllerTest extends WebTestCase
{
    public function testLoaddata()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/loadData');
    }

}
