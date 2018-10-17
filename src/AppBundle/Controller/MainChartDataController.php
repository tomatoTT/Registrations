<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Main Chart controller
 * 
 * @Route("main_chart")
 */
class MainChartDataController extends Controller
{
    /**
     * @Route("/calculate")
     */
    public function calculateAction()
    {
        return $this->render('AppBundle:MainChartData:calculate.html.twig', array(
            // ...
        ));
    }

}
