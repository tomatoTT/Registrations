<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Utils\LoadDataForChart;

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
    public function loadDataAction(Request $request) {
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            $em = $this->getDoctrine()->getManager();
            $select = 'r.make, r.units, r.countyName';
            $from = 'AppBundle:MainChartDataMSPowiat';
            $countyEngagement = false;
            $result = LoadDataForChart::getDataForChart($em, $select, $from, $countyEngagement);
            $make = LoadDataForChart::getInput()['make'];
            $queryColor = $em->createQuery(
                    'SELECT c.make, c.color FROM AppBundle:Make c');
            $colorArray = $queryColor->getResult();
            $color = $colorArray[\array_search($make, \array_column($colorArray, 'make'))]['color'];
            $tivList = [];
            $makeList = [];
            foreach ($result as $resultSingle) {
                $countyKey = array_search($resultSingle["countyName"], array_column($tivList, "county"));
                if (is_numeric($countyKey)) {
                    $tivList[$countyKey]["tiv"] += $resultSingle["units"];                                        
                } else {
                    $tivList[] = [
                        "county" => $resultSingle["countyName"],
                        "tiv" => $resultSingle["units"]
                    ];
                }
                if ($resultSingle["make"] === $make) {
                    $makeKey = array_search($resultSingle["countyName"], array_column($makeList, "county"));
                    if (is_numeric($makeKey)) {
                        $makeList[$makeKey]["units"] += $resultSingle["units"];
                    } else {
                        $makeList[] = [
                            "make" => $make,
                            "county" => $resultSingle["countyName"],
                            "units" => $resultSingle["units"]
                        ];
                    }
                }                
            }
            $sourceMap = [];
            foreach ($makeList as $makeListSingle) {
                $sourceMap[] = [
                    "make" => $make,
                    "units" => $makeListSingle["units"],
                    "tiv" => $tivList[array_search($makeListSingle["county"], array_column($tivList, "county"))]["tiv"],
                    "county" => $makeListSingle["county"],
                    "color" => $color
                ];
            }           
            $jsonData = $sourceMap;
            return new JsonResponse($jsonData);
        } else {
            return new Response('<html><body>nie ma jsona</body></html>');
        }
    }
    
    /**
     * @Route("/showMapMS")
     */
    public function showMapMSAction() {           
        return $this->render('@App/MapChart/show_map_MS.html.twig', array(
            // ...
        ));
    }
    
    /**
     * Load source for map chart top make county
     * 
     * @Route("/loadDataTopMake")
     */
    public function loadDataTopMakeAction(Request $request) {
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            $em = $this->getDoctrine()->getManager();
            $select = 'r.make, r.regYear, r.regMonth, r.units, r.countyName';
            $from = 'AppBundle:MainChartDataMSPowiat';
            $countyEngagement = false;
            $result = LoadDataForChart::getDataForChart($em, $select, $from, $countyEngagement);
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
            for ($i=1; $i<count($result); $i++) {
                for ($j=0; $j<count($sourceMap); $j++) {
                    if ($sourceMap[$j]['make'] === $result[$i]['make'] &&
                        $sourceMap[$j]['county'] === $result[$i]['countyName']) {
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
            foreach ($unique as $valueCounty) {
                $temp = array();
                $countyKeys = array_keys(array_column($sourceMap, "county"), $valueCounty);
                $i = $valueCounty;
                foreach ($countyKeys as $countyKey) {
                    $temp[] = [
                        $sourceMap[$countyKey]["make"],
                        $sourceMap[$countyKey]["units"],
                        $sourceMap[$countyKey]["color"]
                    ];
                }
                $topCounty = max(array_column($temp, "1"));
                $max = array_keys(array_column($temp, "1"), $topCounty);
                if (count($max)>1) {
                    $subCountySourceMap = array();
                    $j = "a";
                    foreach ($max as $valueMax) {                    
                        $subCountySourceMap[$j] = [
                            "make" => $temp[$valueMax][0],
                            "color" => $temp[$valueMax][2]
                        ];
                        $j++;
                    }
                    $countySourceMap[$i] = $subCountySourceMap;
                } else {
                    $countySourceMap[$i] = [
                            "make" => $temp[0][0],
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
    public function showMapTopAction()
    {
        return $this->render('@App/MapChart/show_map_top.html.twig', array(
            // ...
        ));
    }
    
    /**
     * Load source for map chart tiv
     * 
     * @Route("/loadDataTiv")
     */
    public function loadDataTivAction(Request $request) {
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            $em = $this->getDoctrine()->getManager();
            $select = 'r.regYear, r.regMonth, r.units, r.countyName';
            $from = 'AppBundle:MainChartDataMSPowiat';
            $countyEngagement = false;
            $result = LoadDataForChart::getDataForChart($em, $select, $from, $countyEngagement);
            $sourceMap[0] = [
                "county" => $result[0]["countyName"],
                "tiv" => $result[0]["units"]
            ];
            for ($i=1; $i<count($result); $i++) {
                $countyKey = array_search($result[$i]["countyName"], array_column($sourceMap, "county"));
                if ($countyKey) {
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
    public function showMapTivAction() {
        return $this->render('@App/MapChart/show_map_tiv.html.twig', array(
            // ...
        ));
    }
    
    /**
     * @Route("/slideRangeSource")
     */
    public function slideRangeSourceAction(Request $request) {
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
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
            $jsonData = [
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
     * @Route("/makeListSource")
     */
    public function makeListSourceAction(Request $request) {
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery(
                    'SELECT DISTINCT r.make FROM AppBundle:MainChartDataMSPowiat r'
                    );
            $makeList = $query->getResult();
            $make = array_column($makeList, "make");
            $jsonData = $make;            
            return new JsonResponse($jsonData);            
        } else {
            return new Response('<html><body>nie ma jsona</body></html>');
        }
    }
    
    /**
     * @Route("/loadCountyList")
     */
    public function loadCountyListAction(Request $request) {
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery(
                    'SELECT c.countyName FROM AppBundle:TerytPow c'
                    );
            $countyList = $query->getResult();
            $jsonData = $countyList;            
            return new JsonResponse($jsonData);
        } else {
            return new Response('<html><body>nie ma jsona</body></html>');
        }
    }
    
    /**
     * @Route("/loadCountyDetails")
     */
    public function loadCountyDetailsAction(Request $request) {
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            $em = $this->getDoctrine()->getManager();
            $select = 'r.make, r.regYear, r.regMonth, r.units, r.countyName';
            $from = 'AppBundle:MainChartDataMSPowiat';
            $countyEngagement = true;
            $result = LoadDataForChart::getDataForChart($em, $select, $from, $countyEngagement);
            if (empty($result)) {
                return new JsonResponse($result);
            } else {
                $tiv = 0;
                foreach ($result as $resultSingle) {
                    $tiv += $resultSingle["units"]; 
                }
                $sourceMap[0] = [
                    "make" => $result[0]['make'],
                    "units" => $result[0]['units'],
                    "tiv" => $tiv,
                    "county" => $result[0]["countyName"]
                ];
                for ($i=1; $i<count($result); $i++) {                    
                    for ($j=0; $j<count($sourceMap); $j++) {
                        if ($sourceMap[$j]['make'] === $result[$i]['make']) {
                            $sourceMap[$j]['units'] += $result[$i]['units'];
                            goto a;
                        }
                    }
                    $sourceMap[] = [
                        "make" => $result[$i]['make'],
                        "units" => $result[$i]['units'],
                        "tiv" => $tiv,
                        "county" => $result[$i]["countyName"]
                    ];
                    a:                
                }            
                $jsonData = $sourceMap;
                return new JsonResponse($jsonData);
            }
        } else {
            return new Response('<html><body>nie ma jsona</body></html>');
        }
    }
    
    /**
     * @Route("/testy")
     */
    public function testyAction() {

    }
}