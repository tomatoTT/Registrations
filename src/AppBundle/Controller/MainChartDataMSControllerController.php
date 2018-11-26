<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\MainChartDataMS;

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

        $tiv[0] = [
            'regYear' => $mainChartData[0]['regYear'],
            'regMonth' => $mainChartData[0]['regMonth'],
            'units' => $mainChartData[0]['units']
                ];     
        for ($i=1; $i< count($mainChartData); $i++) {


            for ($j=0; $j<count($tiv); $j++) 
                {
                if ($tiv[$j]['regYear'] === $mainChartData[$i]['regYear'] && 
                    $tiv[$j]['regMonth'] === $mainChartData[$i]['regMonth']) 
                {
                    $tiv[$j]['units'] += $mainChartData[$i]['units'];
                    goto a;
                    
                }
            }
            $tiv[] = [
                'regYear' => $mainChartData[$i]['regYear'],
                'regMonth' => $mainChartData[$i]['regMonth'],
                'units' => $mainChartData[$i]['units']
                    ];
            a:
        }
        
        foreach ($mainChartData as $mainChartDataSingle) 
        {
            $keys = array_keys(array_column($tiv, 'regYear'), $mainChartDataSingle['regYear']);

            for ($i=$keys[0]; $i<count($keys)+12; $i++) 
            {

                if ($mainChartDataSingle['regMonth'] === $tiv[$i]['regMonth'])
                {
                    $marketShare = $mainChartDataSingle['units'] / $tiv[$i]['units'];
                    $tivSet = $tiv[$i]['units'];
                    break;
                }
            }
            
            $newMainChartDataMS = new MainChartDataMS();
            $newMainChartDataMS->setMake($mainChartDataSingle['make']);
            $newMainChartDataMS->setRegYear($mainChartDataSingle['regYear']);
            $newMainChartDataMS->setRegMonth($mainChartDataSingle['regMonth']);
            $newMainChartDataMS->setUnits($mainChartDataSingle['units']);
            $newMainChartDataMS->setTIV($tivSet);
            $newMainChartDataMS->setMS($marketShare);
            
            $em->persist($newMainChartDataMS);            
        }
        $em->flush();
        return $this->render('@App/MainChartDataMS/calculate.html.twig', array(
            // ...
        ));
    }
    
    /**
     * @Route("/checkDouble")
     */
    public function checkDoubleAction()
    {
        $em = $this->getDoctrine()->getManager();
        $query1 = $em->createQuery(
                'SELECT m.make, m.regYear, m.regMonth, m.units FROM AppBundle:MainChartData m'
                );
        $mainChartData = $query1->getResult();
        
        if (empty($mainChartData)) {
            return new Response('<html><body>Załaduj dane</body></html>');
        }
        
        $query2 = $em->createQuery(
                'SELECT m.make, m.regYear, m.regMonth, m.units FROM AppBundle:MainChartDataMS m'
                );
        $mainChartDataMS = $query2->getResult();
        
        if (empty($mainChartDataMS)) {
            return new Response($this->redirect('/main_chart_MS/calculate'));
        }

        foreach ($mainChartData as $mainChartDataSingle) {
            if (array_search($mainChartDataSingle, $mainChartDataMS)) {
                return new Response('<html><body>Znaleziono podwójne wiersze</body></html>');
            }
        }
        return new Response($this->redirect('/main_chart_MS/calculate'));
    }

}
