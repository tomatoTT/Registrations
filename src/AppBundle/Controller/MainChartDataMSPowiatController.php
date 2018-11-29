<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class MainChartDataMSPowiatController extends Controller
{
    /**
     * @Route("/calculate")
     */
    public function calculataAction()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                'SELECT m.make, m.regYear, m.regMonth, m.units FROM AppBundle:MainChartData m'
                );
        $mainChartData = $query->getResult();
    }
}
