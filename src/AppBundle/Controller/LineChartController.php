<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Utils\LoadDataForChart;

/**
 * Line Chart controller
 * 
 * @Route("lineChart")
 */
class LineChartController extends Controller
{
    /**
     * @Route("/loadData")
     */
    public function loadDataAction(Request $request)
    {
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1)
        {
            $em = $this->getDoctrine()->getManager();
            $select = 'r.make, r.regYear, r.regMonth, r.units';
            $result = LoadDataForChart::getDataForChart($em, $select);
            $colorArray = $em->createQuery('SELECT c.make, c.color FROM AppBundle:Make c')->getResult();
            $units[0] = [
                "make" => $result[0]['make'],
                "regYear" => $result[0]['regYear'],
                "regMonth" => $result[0]['regMonth'],
                "units" => $result[0]['units'],
                "tiv" => $result[0]['units'],
                "color" => $colorArray[array_search($result[0]["make"],
                        array_column($colorArray, 'make'))]['color']
            ];
            $tiv[0] = [
                "regYear" => $result[0]['regYear'],
                "regMonth" => $result[0]['regMonth'],
                "tiv" => $result[0]['units']
            ];
            for ($i=1; $i<count($result); $i++) {
                for ($j=0; $j<count($units); $j++) {
                    if ($result[$i]['make'] === $units[$j]['make'] &&
                        $result[$i]['regYear'] === $units[$j]['regYear'] &&
                        $result[$i]['regMonth'] === $units[$j]['regMonth']) {
                        $units[$j]['units'] += $result[$i]['units'];
                        goto a;
                    }
                }
                $units[] = [
                    "make" => $result[$i]['make'],
                    "regYear" => $result[$i]['regYear'],
                    "regMonth" => $result[$i]['regMonth'],
                    "units" => $result[$i]['units'],
                    "tiv" => $result[$i]['units'],
                    "color" => $colorArray[array_search($result[$i]["make"],
                            array_column($colorArray, 'make'))]['color']
                ];
                a:
                for ($k=0; $k<count($tiv); $k++) {
                    if ($result[$i]['regYear'] === $tiv[$k]['regYear'] &&
                        $result[$i]['regMonth'] === $tiv[$k]['regMonth']) {
                        $tiv[$k]['tiv'] += $result[$i]['units'];
                        goto b;
                    }
                }
                $tiv[] = [
                    "regYear" => $result[$i]['regYear'],
                    "regMonth" => $result[$i]['regMonth'],
                    "tiv" => $result[$i]['units']
                ];
                b:
            }
            for ($i=0; $i<count($units); $i++) {
                for ($j=0; $j<count($tiv); $j++) {
                    if ($tiv[$j]['regYear'] === $units[$i]['regYear'] &&
                        $tiv[$j]['regMonth'] === $units[$i]['regMonth']) {
                        $units[$i]['tiv'] = $tiv[$j]['tiv'];
                        break;
                    }
                }
            }
            $jsonData = $units;
            return new JsonResponse($jsonData);
        } else {
            return new Response('<html><body>nie ma jsona</body></html>');
        }
    }
    
    /**
     * @Route("/showLineChart")
     */
    public function showMapMSAction()
    {           
        return $this->render('@App/LineChart/show_line_chart.html.twig', array(
            // ...
        ));
    }
    
    /**
     * @Route("/test")
     */
    public function testAction(Request $request) {
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1)
        {    
            $em = $this->getDoctrine()->getManager();
            
            $select = 'r.make, r.regYear, r.regMonth, r.units';
          $jsonData = LoadDataForChart::getDataForChart($em, $select);

            
            return new JsonResponse($jsonData);
        } else {
            return new Response('<html><body>nie ma jsona</body></html>');
        }
    }
}
