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
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                'SELECT m.make, m.regYear, m.regMonth, m.units FROM AppBundle:main_chart_data m'
                );
        return $this->render('AppBundle:MainChartDataMSController:calculate.html.twig', array(
            // ...
        ));
    }

}
