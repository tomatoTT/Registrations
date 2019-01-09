<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Make;

/**
 * Map Chart controller
 * 
 * @Route("mapChart")
 */
class MapChartController extends Controller
{
    /**
     * Load source for map chart make MS
     * 
     * @Route("/loadDataMS")
     */
    public function loadDataAction(Request $request)
    {
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1)
        {
            $em = $this->getDoctrine()->getManager();
            $filters = array(
                "make" => array('filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                "regYearMin" => array('filter' => FILTER_SANITIZE_NUMBER_INT),
                "regYearMax" => array('filter' => FILTER_SANITIZE_NUMBER_INT),
                "regMonthMin" => array('filter' => FILTER_SANITIZE_NUMBER_INT),
                "regMonthMax" => array('filter' => FILTER_SANITIZE_NUMBER_INT)
            );
            $myPost = filter_input_array(INPUT_POST, $filters);            
            $make = $myPost['make'];
            $regYearMin = $myPost['regYearMin'];
            $regMonthMin = $myPost['regMonthMin'];
            $regYearMax = $myPost['regYearMax'];
            $regMonthMax = $myPost['regMonthMax'];    

            if ($regYearMin === $regYearMax)
            {
                $qb = $em->createQueryBuilder();
                $q = $qb->select('r.make, r.regYear, r.regMonth, r.units, r.countyName, r.tIV')
                        ->from('AppBundle:MainChartDataMSPowiat', 'r')
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
            $q1 = $qb1->select('r.make, r.regYear, r.regMonth, r.units, r.countyName, r.tIV')
                    ->from('AppBundle:MainChartDataMSPowiat', 'r')
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
            $q2 = $qb2->select('r.make, r.regYear, r.regMonth, r.units, r.countyName, r.tIV')
                    ->from('AppBundle:MainChartDataMSPowiat', 'r')
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
            $sourceMap[0] = [
                "make" => $result[0]['make'],
                "units" => $result[0]['units'],
                "tiv" => $result[0]["tIV"],
                "county" => $result[0]["countyName"],
                "color" => $color
            ];
            for ($i=1; $i<count($result); $i++)
            {
                for ($j=0; $j<count($sourceMap); $j++)
                {
                    if ($sourceMap[$j]['make'] === $result[$i]['make'] &&
                        $sourceMap[$j]['county'] === $result[$i]['countyName'])
                    {
                        $sourceMap[$j]['units'] += $result[$i]['units'];
                        $sourceMap[$j]['tiv'] += $result[$i]['tIV'];
                        goto a;
                    }
                }
                $sourceMap[] = [
                    "make" => $result[$i]['make'],
                    "units" => $result[$i]['units'],
                    "tiv" => $result[$i]["tIV"],
                    "county" => $result[$i]["countyName"],
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
        return $this->render('@App/MapChart/show_map.html.twig', array(
            // ...
        ));
    }
    
    /**
     * Load source for map chart top make county
     * 
     * @Route("/loadDataTopMake")
     */
    public function loadDataTopMakeAction(Request $request)
    {
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1)
        {
            $em = $this->getDoctrine()->getManager();
            $filters = array(
                "regYearMin" => array('filter' => FILTER_SANITIZE_NUMBER_INT),
                "regYearMax" => array('filter' => FILTER_SANITIZE_NUMBER_INT),
                "regMonthMin" => array('filter' => FILTER_SANITIZE_NUMBER_INT),
                "regMonthMax" => array('filter' => FILTER_SANITIZE_NUMBER_INT)
            );
            $myPost = filter_input_array(INPUT_POST, $filters);
            $regYearMin = $myPost['regYearMin'];
            $regMonthMin = $myPost['regMonthMin'];
            $regYearMax = $myPost['regYearMax'];
            $regMonthMax = $myPost['regMonthMax'];
            
            if ($regYearMin === $regYearMax)
            {
                $qb = $em->createQueryBuilder();
                $q = $qb->select('r.make, r.regYear, r.regMonth, r.units, r.countyName')
                        ->from('AppBundle:MainChartDataMSPowiat', 'r')
                        ->where(
                                $qb->expr()->andX(
                                        $qb->expr()->eq('r.regYear', $regYearMin),
                                        $qb->expr()->between('r.regMonth', $regMonthMin, $regMonthMax)
                                        )
                        )
                        ->getQuery();
                $result = $q->getResult();
                goto b;
            }
            $qb1 = $em->createQueryBuilder();
            $q1 = $qb1->select('r.make, r.regYear, r.regMonth, r.units, r.countyName')
                    ->from('AppBundle:MainChartDataMSPowiat', 'r')
                    ->where(
                            $qb1->expr()->andX(
                                    $qb1->expr()->eq('r.regYear', $regYearMin),
                                    $qb1->expr()->gte('r.regMonth', $regMonthMin)
                                    )
                    )
                    ->getQuery();
            $resultMin = $q1->getResult();

            $qb2 = $em->createQueryBuilder();
            $q2 = $qb2->select('r.make, r.regYear, r.regMonth, r.units, r.countyName')
                    ->from('AppBundle:MainChartDataMSPowiat', 'r')
                    ->where(
                            $qb2->expr()->andX(
                                    $qb2->expr()->eq('r.regYear', $regYearMax),
                                    $qb2->expr()->lte('r.regMonth', $regMonthMax)
                                    )
                    )
                    ->getQuery();
            $resultMax = $q2->getResult();            
            $result = array_merge($resultMin, $resultMax);
            b:
            $queryColor = $em->createQuery(
                    'SELECT c.make, c.color FROM AppBundle:Make c');
            $colorArray = $queryColor->getResult();
            $sourceMap[0] = [
                "make" => $result[0]['make'],
                "units" => $result[0]['units'],
                "county" => $result[0]["countyName"],
                "color" => $colorArray[array_search($result[0]["make"],
                        array_column($colorArray, 'make'))]['color']
            ];
            for ($i=1; $i<count($result); $i++)
            {
                for ($j=0; $j<count($sourceMap); $j++)
                {
                    if ($sourceMap[$j]['make'] === $result[$i]['make'] &&
                        $sourceMap[$j]['county'] === $result[$i]['countyName'])
                    {
                        $sourceMap[$j]['units'] += $result[$i]['units'];
                        goto a;
                    }
                }
                $sourceMap[] = [
                    "make" => $result[$i]['make'],
                    "units" => $result[$i]['units'],
                    "county" => $result[$i]["countyName"],
                    "color" => $colorArray[array_search($result[$i]["make"],
                        array_column($colorArray, 'make'))]['color']
                ];
                a:                
            }
            $countySourceMap = array();
            $unique = array_unique(array_column($sourceMap, "county"));
            $i = "";
            foreach ($unique as $valueCounty)
            {
                $temp = array();
                $countyKeys = array_keys(array_column($sourceMap, "county"), $valueCounty);
                $i = $valueCounty;
                foreach ($countyKeys as $countyKey)
                {
                    $temp[] = [
                        $sourceMap[$countyKey]["make"],
                        $sourceMap[$countyKey]["units"],
                        $sourceMap[$countyKey]["color"]
                    ];
                }
                $topCounty = max(array_column($temp, "1"));
                $max = array_keys(array_column($temp, "1"), $topCounty);
                if (count($max)>1)
                {
                    $subCountySourceMap = array();
                    $j = "a";
                    foreach ($max as $valueMax)
                    {                    
                        $subCountySourceMap[$j] = [
                            "make" => $temp[$valueMax][0],
                            "county" => $valueCounty,
                            "color" => $temp[$valueMax][2]
                        ];
                        $j++;
                    }
                    $countySourceMap[$i] = $subCountySourceMap;
                } else {
                    $countySourceMap[$i] = [
                            "make" => $temp[0][0],
                            "county" => $valueCounty,
                            "color" => $temp[0][2]
                        ];
                }
            }            
            $jsonData = $countySourceMap;
            return new JsonResponse($jsonData);
        } else {
            return new Response('<html><body>nie ma jsona</body></html>');
        }        
    }
    
    /**
     * @Route("/showMapTop")
     */
    public function loadMapTopAction()
    {

        return $this->render('@App/MapChart/load_map_top.html.twig', array(
            // ...
        ));
    }
    
    /**
     * Load source for map chart tiv
     * 
     * @Route("/loadDataTiv")
     */
    public function loadDataTivAction(Request $request)
    {
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1)
        {
            $em = $this->getDoctrine()->getManager();
            $filters = array(
                "regYearMin" => array('filter' => FILTER_SANITIZE_NUMBER_INT),
                "regYearMax" => array('filter' => FILTER_SANITIZE_NUMBER_INT),
                "regMonthMin" => array('filter' => FILTER_SANITIZE_NUMBER_INT),
                "regMonthMax" => array('filter' => FILTER_SANITIZE_NUMBER_INT)
            );
            $myPost = filter_input_array(INPUT_POST, $filters);
            $regYearMin = $myPost['regYearMin'];
            $regMonthMin = $myPost['regMonthMin'];
            $regYearMax = $myPost['regYearMax'];
            $regMonthMax = $myPost['regMonthMax'];
            if ($regYearMin === $regYearMax)
            {
                $qb = $em->createQueryBuilder();
                $q = $qb->select('r.regYear, r.regMonth, r.units, r.countyName')
                        ->from('AppBundle:MainChartDataMSPowiat', 'r')
                        ->where(
                                $qb->expr()->andX(
                                        $qb->expr()->eq('r.regYear', $regYearMin),
                                        $qb->expr()->between('r.regMonth', $regMonthMin, $regMonthMax)
                                        )
                        )
                        ->getQuery();
                $result = $q->getResult();
                goto b;
            }
            $qb1 = $em->createQueryBuilder();
            $q1 = $qb1->select('r.regYear, r.regMonth, r.units, r.countyName')
                    ->from('AppBundle:MainChartDataMSPowiat', 'r')
                    ->where(
                            $qb1->expr()->andX(
                                    $qb1->expr()->eq('r.regYear', $regYearMin),
                                    $qb1->expr()->gte('r.regMonth', $regMonthMin)
                                    )
                    )
                    ->getQuery();
            $resultMin = $q1->getResult();

            $qb2 = $em->createQueryBuilder();
            $q2 = $qb2->select('r.regYear, r.regMonth, r.units, r.countyName')
                    ->from('AppBundle:MainChartDataMSPowiat', 'r')
                    ->where(
                            $qb2->expr()->andX(
                                    $qb2->expr()->eq('r.regYear', $regYearMax),
                                    $qb2->expr()->lte('r.regMonth', $regMonthMax)
                                    )
                    )
                    ->getQuery();
            $resultMax = $q2->getResult();            
            $result = array_merge($resultMin, $resultMax);
            b:
            $sourceMap[0] = [
                "county" => $result[0]["countyName"],
                "tiv" => $result[0]["units"]
            ];
            for ($i=1; $i<count($result); $i++)
            {
                $countyKey = array_search($result[$i]["countyName"], array_column($sourceMap, "county"));
                if ($countyKey)
                {
                    $sourceMap[$countyKey]["tiv"] += $result[$i]["units"];
                } else {
                    $sourceMap[] = [
                        "county" => $result[$i]["countyName"],
                        "tiv" => $result[$i]["units"]
                    ];
                }
            }
            $jsonData = $sourceMap;            
            return new JsonResponse($jsonData);
        } else {
            return new Response('<html><body>nie ma jsona</body></html>');
        }
    }
    
    /**
     * @Route("/showMapTiv")
     */
    public function loadMapTivAction()
    {

        return $this->render('@App/MapChart/load_map_tiv.html.twig', array(
            // ...
        ));
    }
    
    /**
     * @Route("/formInputMap")
     */
    public function formInputAction()
    {        
        return $this->render('@App/MapChart/input_map.html.twig', array(
            // ...
        ));
    }
    
    /**
     * @Route("/slideRangeSource")
     */
    public function slideRangeSourceAction(Request $request)
    {
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1)
        {
           $em = $this->getDoctrine()->getManager();
            $qb = $em->createQueryBuilder();
            $qRegYearMax = $qb->select('MAX(r.regYear) AS max_regYear')
                    ->from('AppBundle:MainChartDataMSPowiat', 'r')
                    ->getQuery();
            $maxRegYear = $qRegYearMax->getResult()[0]['max_regYear'];            
            $qb1 = $em->createQueryBuilder();
            $qRegMonthMax = $qb1->select('r.regYear, MAX(r.regMonth) AS max_regMonth')
                    ->from('AppBundle:MainChartDataMSPowiat', 'r')
                    ->where($qb1->expr()->eq('r.regYear', $maxRegYear))
                    ->getQuery();
            $maxRegMonth = $qRegMonthMax->getResult()[0]['max_regMonth'];
            $qb2 = $em->createQueryBuilder();
            $qRegYearMin = $qb2->select('MIN(r.regYear) AS min_regYear')
                    ->from('AppBundle:MainChartDataMSPowiat', 'r')
                    ->getQuery();
            $minRegYear = $qRegYearMin->getResult()[0]['min_regYear'];            
            $qb3 = $em->createQueryBuilder();
            $qRegMonthMin = $qb3->select('r.regYear, MIN(r.regMonth) AS min_regMonth')
                    ->from('AppBundle:MainChartDataMSPowiat', 'r')
                    ->where($qb3->expr()->eq('r.regYear', $minRegYear))
                    ->getQuery();
            $minRegMonth = $qRegMonthMin->getResult()[0]['min_regMonth'];
            
            $jsonData = 
            [
                'yearMin' => $minRegYear,
                'monthMin' => $minRegMonth,
                'yearMax' => $maxRegYear,
                'monthMax' => $maxRegMonth
            ];
            return new JsonResponse($jsonData);
            
        } else {
            return new Response('<html><body>nie ma jsona</body></html>');
        }
    }
    /**
     * @Route("/slideRangeSourceTest")
     */
    public function slideRangeSourceTestAction()
    {
        
            $em = $this->getDoctrine()->getManager();
            $qb = $em->createQueryBuilder();
            $qRegYearMax = $qb->select('MAX(r.regYear) AS max_regYear')
                    ->from('AppBundle:MainChartDataMSPowiat', 'r')
                    ->getQuery();
            $maxRegYear = $qRegYearMax->getResult()[0]['max_regYear'];            
            $qb1 = $em->createQueryBuilder();
            $qRegMonthMax = $qb1->select('r.regYear, MAX(r.regMonth) AS max_regMonth')
                    ->from('AppBundle:MainChartDataMSPowiat', 'r')
                    ->where($qb1->expr()->eq('r.regYear', $maxRegYear))
                    ->getQuery();
            $maxRegMonth = $qRegMonthMax->getResult()[0]['max_regMonth'];
            $qb2 = $em->createQueryBuilder();
            $qRegYearMin = $qb2->select('MIN(r.regYear) AS min_regYear')
                    ->from('AppBundle:MainChartDataMSPowiat', 'r')
                    ->getQuery();
            $minRegYear = $qRegYearMin->getResult()[0]['min_regYear'];            
            $qb3 = $em->createQueryBuilder();
            $qRegMonthMin = $qb3->select('r.regYear, MIN(r.regMonth) AS min_regMonth')
                    ->from('AppBundle:MainChartDataMSPowiat', 'r')
                    ->where($qb3->expr()->eq('r.regYear', $minRegYear))
                    ->getQuery();
            $minRegMonth = $qRegMonthMin->getResult()[0]['min_regMonth'];
            var_dump($minRegYear);
            var_dump($minRegMonth);
            var_dump($maxRegYear);
            var_dump($maxRegMonth);
            
        
    }
    
}
