<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Map Chart controller
 * 
 * @Route("mapChart")
 */
class MapChartController extends Controller
{
    /**
     * @Route("/loadData")
     */
    public function loadDataAction(Request $request)
    {
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1)
        {
            $em = $this->getDoctrine()->getManager();            
            $myPost = filter_input_array(INPUT_POST);
            
            $make = $myPost['make'];
            $regYearMin = $myPost['regYearMin'];
            $regMonthMin = $myPost['regMonthMin'];
            $regYearMax = $myPost['regYearMax'];
            $regMonthMax = $myPost['regMonthMax'];    

            if ($regYearMin === $regYearMax)
            {
                $qb = $em->createQueryBuilder();
                $q = $qb->select('r.make, r.regYear, r.regMonth, r.units, r.tERYT')
                        ->from('AppBundle:RegTot', 'r')
                        ->where(
                                $qb->expr()->andX(
                                        $qb->expr()->eq('r.regYear', $regYearMin),
                                        $qb->expr()->between('r.regMonth', $regMonthMin, $regMonthMax),
                                        $qb->expr()->eq('r.make', $qb->expr()->literal($make))
                                        )
                        )
                        ->getQuery();
                $result = $q->getResult();
                goto b;
            }
            $qb1 = $em->createQueryBuilder();
            $q1 = $qb1->select('r.make, r.regYear, r.regMonth, r.units, r.tERYT')
                    ->from('AppBundle:RegTot', 'r')
                    ->where(
                            $qb1->expr()->andX(
                                    $qb1->expr()->eq('r.regYear', $regYearMin),
                                    $qb1->expr()->gte('r.regMonth', $regMonthMin),
                                    $qb1->expr()->eq('r.make', $qb1->expr()->literal($make))
                                    )
                    )
                    ->getQuery();
            $resultMin = $q1->getResult();

            $qb2 = $em->createQueryBuilder();
            $q2 = $qb2->select('r.make, r.regYear, r.regMonth, r.units, r.tERYT')
                    ->from('AppBundle:RegTot', 'r')
                    ->where(
                            $qb2->expr()->andX(
                                    $qb2->expr()->eq('r.regYear', $regYearMax),
                                    $qb2->expr()->lte('r.regMonth', $regMonthMax),
                                    $qb2->expr()->eq('r.make', $qb2->expr()->literal($make))
                                    )
                    )
                    ->getQuery();
            $resultMax = $q2->getResult();            
            $result = array_merge($resultMin, $resultMax);
            b:
            $queryColor = $em->createQuery(
                    'SELECT c.make, c.color FROM AppBundle:Make c');
            $colorArray = $queryColor->getResult();
            $color = $colorArray[array_search($result[0]["make"], array_column($colorArray, 'make'))]['color'];
            $query = $em->createQuery(
                'SELECT t.teryt, t.powiat FROM AppBundle:TerytPow t'
                );
            $terytPow = $query->getResult();           
            $powiatKey = array_search($result[0]["tERYT"], array_column($terytPow, 'teryt'));
            $tiv = array_sum(array_column($result,'units'));
            $sourceMap[0] = [
                "make" => $result[0]['make'],
                "units" => $result[0]['units'],
                "tiv" => $tiv,
                "county" => $terytPow[$powiatKey]['powiat'],
                "teryt" => $result[0]['tERYT'],
                "color" => $color
            ];
            for ($i=1; $i<count($result); $i++)
            {
                for ($j=0; $j<count($sourceMap); $j++)
                {
                    if ($sourceMap[$j]['make'] === $result[$i]['make'] &&
                        $sourceMap[$j]['county'] === array_search(
                                $result[$i]["tERYT"], array_column($terytPow, 'teryt')))
                    {
                        $sourceMap[$j]['units'] += $result[$i]['units'];                        
                        goto a;
                    }
                }
                $sourceMap[] = [
                    "make" => $result[$i]['make'],
                    "units" => $result[$i]['units'],
                    "tiv" => $tiv,
                    "county" => $terytPow[array_search(
                            $result[$i]["tERYT"], array_column($terytPow, 'teryt'))]['powiat'],
                    "teryt" => $result[$i]['tERYT'],
                    "color" => $color
                ];
                a:                
            }            
            $jsonData = $sourceMap;

            return new JsonResponse($jsonData);
        } else {
            return new Response('<html><body>nie ma jsona</body></html>');
        }
    }
    
    /**
     * @Route("/showMap")
     */
    public function showMapAction()
    {   
        $em = $this->getDoctrine()->getManager();
            
            $myPost = filter_input_array(INPUT_POST);
            
            $make = "JCB";
            $regYearMin = 2017;
            $regMonthMin = 3;
            $regYearMax = 2018;
            $regMonthMax = 11;    

            if ($regYearMin === $regYearMax)
            {
                $qb = $em->createQueryBuilder();
                $q = $qb->select('r.make, r.regYear, r.regMonth, r.units, r.tERYT')
                        ->from('AppBundle:RegTot', 'r')
                        ->where(
                                $qb->expr()->andX(
                                        $qb->expr()->eq('r.regYear', $regYearMin),
                                        $qb->expr()->between('r.regMonth', $regMonthMin, $regMonthMax),
                                        $qb->expr()->eq('r.make', $qb->expr()->literal($make))
                                        )
                        )
                        ->getQuery();
                $result = $q->getResult();
                goto b;
            }
            $qb1 = $em->createQueryBuilder();
            $q1 = $qb1->select('r.make, r.regYear, r.regMonth, r.units, r.tERYT')
                    ->from('AppBundle:RegTot', 'r')
                    ->where(
                            $qb1->expr()->andX(
                                    $qb1->expr()->eq('r.regYear', $regYearMin),
                                    $qb1->expr()->gte('r.regMonth', $regMonthMin),
                                    $qb1->expr()->eq('r.make', $qb1->expr()->literal($make))
                                    )
                    )
                    ->getQuery();
            $resultMin = $q1->getResult();

            $qb2 = $em->createQueryBuilder();
            $q2 = $qb2->select('r.make, r.regYear, r.regMonth, r.units, r.tERYT')
                    ->from('AppBundle:RegTot', 'r')
                    ->where(
                            $qb2->expr()->andX(
                                    $qb2->expr()->eq('r.regYear', $regYearMax),
                                    $qb2->expr()->lte('r.regMonth', $regMonthMax),
                                    $qb2->expr()->eq('r.make', $qb2->expr()->literal($make))
                                    )
                    )
                    ->getQuery();
            $resultMax = $q2->getResult();            
            $result = array_merge($resultMin, $resultMax);
            b:
            $queryColor = $em->createQuery(
                    'SELECT c.make, c.color FROM AppBundle:Make c');
            $colorArray = $queryColor->getResult();
            $color = $colorArray[array_search($result[0]["make"], array_column($colorArray, 'make'))]['color'];
            var_dump($color);
            $query = $em->createQuery(
                'SELECT t.teryt, t.powiat FROM AppBundle:TerytPow t'
                );
            $terytPow = $query->getResult();           
            $powiatKey = array_search($result[0]["tERYT"], array_column($terytPow, 'teryt'));
            $tiv = array_sum(array_column($result,'units'));
            $sourceMap[0] = [
                "make" => $result[0]['make'],
                "units" => $result[0]['units'],
                "tiv" => $tiv,
                "county" => $terytPow[$powiatKey]['powiat'],
                "teryt" => $result[0]['tERYT']
            ];
            for ($i=1; $i<count($result); $i++)
            {
                for ($j=0; $j<count($sourceMap); $j++)
                {
                    if ($sourceMap[$j]['make'] === $result[$i]['make'] &&
                        $sourceMap[$j]['county'] === array_search(
                                $result[$i]["tERYT"], array_column($terytPow, 'teryt')))
                    {
                        $sourceMap[$j]['units'] += $result[$i]['units'];                        
                        goto a;
                    }
                }
                $sourceMap[] = [
                    "make" => $result[$i]['make'],
                    "units" => $result[$i]['units'],
                    "tiv" => $tiv,
                    "county" => $terytPow[array_search(
                            $result[$i]["tERYT"], array_column($terytPow, 'teryt'))]['powiat'],
                    "teryt" => $result[$i]['tERYT']
                ];
                a:                
            }
        
        return $this->render('@App/MapChart/show_map.html.twig', array(
            // ...
        ));
    }
    
}
