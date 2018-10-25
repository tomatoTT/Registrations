<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\MainChartData;
use AppBundle\Entity\RegTot;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

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
        
        $mainChartData[0] = $registrationsRaw[0];
        for ($i=1; $i< count($registrationsRaw); $i++ ) {

            $mainChartDataCount = count($mainChartData);
            for ($j=0; $j<$mainChartDataCount; $j++) {

                if ($mainChartData[$j]['make'] === $registrationsRaw[$i]['make'] && 
                    $mainChartData[$j]['regYear'] === $registrationsRaw[$i]['regYear'] && 
                    $mainChartData[$j]['regMonth'] === $registrationsRaw[$i]['regMonth']) 
                {    
                    $mainChartData[$j]['units'] += $registrationsRaw[$i]['units'];
                    goto a;
                }
            }
            $mainChartData[] = $registrationsRaw[$i];
            a:
        }
        
        foreach ($mainChartData as $mainChartDataSingle) {

            $newMainDataChart = new MainChartData();
            $newMainDataChart->setMake($mainChartDataSingle['make']);
            $newMainDataChart->setRegYear($mainChartDataSingle['regYear']);
            $newMainDataChart->setRegMonth($mainChartDataSingle['regMonth']);
            $newMainDataChart->setUnits($mainChartDataSingle['units']);
            
            $em->persist($newMainDataChart);                        
        }
        $em->flush();
        return new Response($this->redirect('/main_chart/sendDataToRegTot'));
        
    }
    /**
     * @Route("/sendDataToRegTot")
     */
    public function sendDataToRegTotAction() 
    {
        $em = $this->getDoctrine()->getManager();        
        $registrationsTot = $em->getRepository('AppBundle:Registrations')->findAll();
        
        foreach ($registrationsTot as $registrationsTotSingle) {
            $newRegTot = new RegTot();
            $newRegTot->setMake($registrationsTotSingle->getMake());
            $newRegTot->setModel($registrationsTotSingle->getModel());
            $newRegTot->setSerie($registrationsTotSingle->getSerie());
            $newRegTot->setRegYear($registrationsTotSingle->getRegYear());
            $newRegTot->setRegMonth($registrationsTotSingle->getRegMonth());
            $newRegTot->setUnits($registrationsTotSingle->getUnits());
            $newRegTot->setREGON($registrationsTotSingle->getREGON());
            $newRegTot->setRegType($registrationsTotSingle->getRegType());
            $newRegTot->setTERYT($registrationsTotSingle->getTERYT());
            
            $em->persist($newRegTot);
        }            
        $em->flush();
            
        return new Response($this->redirect('/registrations/delete_all'));
    }
    
    /**
     * @Route("/sendData")
     */
    public function sendDataAction(Request $request) 
    {
        $mainChartData = $this->getDoctrine()
                ->getRepository('AppBundle:MainChartData')
                ->findAll();
        $colors = $this->getDoctrine()
                ->getRepository('AppBundle:Make')
                ->findAll();

        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1)
        {
            $jsonData = array();
            $idx = 0;
            foreach ($mainChartData as $mainChartDataSingle) {

                foreach ($colors as $color) {
                    if ($color->getMake() === $mainChartDataSingle->getMake()) {
                        $colorMake = $color->getColor();
                    }
                }
                $temp = array(
                    'make' => $mainChartDataSingle->getMake(),
                    'regYear' => $mainChartDataSingle->getRegYear(),
                    'regMonth' => $mainChartDataSingle->getRegMonth(),
                    'units' => $mainChartDataSingle->getUnits(),
                    'color' => $colorMake
                );

                $jsonData[$idx++] = $temp;
            }
            return new JsonResponse($jsonData);
        } else {
            return new Response('<html><body>nie ma jsona</body></html>');
        }
        
    }
}
