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
        $em = $this->getDoctrine()->getManager();
        
        $query = $em->createQuery(
                'SELECT r.make, r.regYear, r.regMonth, r.units FROM AppBundle:Registrations r'
                );
        $registrationsRaw = $query->getResult();
        
        $maiChartData[0] = $registrationsRaw[0];

        for ($i=1; $i< count($registrationsRaw); $i++ ) {

            $maiChartDataCount = count($maiChartData);
            for ($j=0; $j<$maiChartDataCount; $j++) {

                if ($maiChartData[$j]['make'] === $registrationsRaw[$i]['make'] && 
                        $maiChartData[$j]['regYear'] === $registrationsRaw[$i]['regYear'] && 
                        $maiChartData[$j]['regMonth'] === $registrationsRaw[$i]['regMonth']) {
                    
                    $maiChartData[$j]['units'] += $registrationsRaw[$i]['units'];
                    goto a;
                }
            }
            $maiChartData[] = $registrationsRaw[$i];
            a:
        }
        
    }

}
