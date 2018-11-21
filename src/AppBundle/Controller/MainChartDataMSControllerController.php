<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Main Chart controller
 * 
 * @Route("main_chart_MS")
 */
class MainChartDataMSControllerController extends Controller
{
    /**
     * @Route("/calculate")
     */
    public function calculateAction()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                'SELECT m.make, m.regYear, m.regMonth, m.units FROM AppBundle:MainChartData m'
                );
        $mainChartData = $query->getResult();
        
        $minYear = min(array_column($mainChartData, 'regYear'));
        $maxYear = max(array_column($mainChartData, 'regYear'));
        var_dump($minYear);        
        var_dump($maxYear);
        return $this->render('@App/MainChartDataMS/calculate.html.twig', array(
            // ...
        ));
    }

}
