<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class MainChartDataMSControllerController extends Controller
{
    /**
     * @Route("/calculate")
     */
    public function calculateAction()
    {
        return $this->render('AppBundle:MainChartDataMSController:calculate.html.twig', array(
            // ...
        ));
    }

}
