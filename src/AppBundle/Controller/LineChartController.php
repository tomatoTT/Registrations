<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

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
        $em = $this->getDoctrine()->getManager();
        $postSize = \sizeof($_POST);
        $filters = array(
                "regYearMin" => array('filter' => FILTER_SANITIZE_NUMBER_INT),
                "regYearMax" => array('filter' => FILTER_SANITIZE_NUMBER_INT),
                "regMonthMin" => array('filter' => FILTER_SANITIZE_NUMBER_INT),
                "regMonthMax" => array('filter' => FILTER_SANITIZE_NUMBER_INT)
            );
        if ($postSize > 4) {
            for ($i = 4; $i<$postSize; $i++) {
                $filters["county".($i-4)] = array('filter' => FILTER_SANITIZE_STRING);
            }
        }
        $myPost = filter_input_array(INPUT_POST, $filters);
        $regYearMin = $myPost['regYearMin'];
        $regMonthMin = $myPost['regMonthMin'];
        $regYearMax = $myPost['regYearMax'];
        $regMonthMax = $myPost['regMonthMax'];
        $conditions = [];
        if ($postSize > 4) {
            for ($i = 4; $i<$postSize; $i++) {
                $conditions[] = $myPost["county" . ($i-4)];
            }
        }
        if ($regYearMin === $regYearMax)
        {
            $qb = $em->createQueryBuilder();
            $q = $qb->select('r.make, r.regYear, r.regMonth, r.units')
                    ->from('AppBundle:MainChartDataMSPowiat', 'r')
                    ->where(
                            $qb->expr()->andX(
                                    $qb->expr()->eq('r.regYear', $regYearMin),
                                    $qb->expr()->between('r.regMonth', $regMonthMin, $regMonthMax)
                                    )
                    );
            if (\sizeof($conditions) > 0) {
                $orStatements = $qb->expr()->orX();
                foreach ($conditions as $condition) {
                    $orStatements->add(
                        $qb->expr()->eq('r.countyName', $qb->expr()->literal($condition))
                    );
                }
                $qb->andWhere($orStatements);
            }
            $result = $q->getQuery()->getResult();                 
        } else {
            $qb1 = $em->createQueryBuilder();
            $q1 = $qb1->select('r.make, r.regYear, r.regMonth, r.units')
                    ->from('AppBundle:MainChartDataMSPowiat', 'r')
                    ->where(
                            $qb1->expr()->andX(
                                    $qb1->expr()->eq('r.regYear', $regYearMin),
                                    $qb1->expr()->gte('r.regMonth', $regMonthMin)
                                    )
                    );
            if (\sizeof($conditions) > 0) {
                $orStatements = $qb1->expr()->orX();
                foreach ($conditions as $condition) {
                    $orStatements->add(
                        $qb1->expr()->eq('r.countyName', $qb1->expr()->literal($condition))
                    );
                }
                $qb->andWhere($orStatements);
            }
            $resultMin = $q1->getQuery()->getResult();
            $qb2 = $em->createQueryBuilder();
            $q2 = $qb2->select('r.make, r.regYear, r.regMonth, r.units')
                    ->from('AppBundle:MainChartDataMSPowiat', 'r')
                    ->where(
                            $qb2->expr()->andX(
                                    $qb2->expr()->eq('r.regYear', $regYearMax),
                                    $qb2->expr()->lte('r.regMonth', $regMonthMax)
                                    )
                    );
            if (\sizeof($conditions) > 0) {
                $orStatements = $qb2->expr()->orX();
                foreach ($conditions as $condition) {
                    $orStatements->add(
                        $qb2->expr()->eq('r.countyName', $qb2->expr()->literal($condition))
                    );
                }
                $qb2->andWhere($orStatements);
            }
            $resultMax = $q2->getQuery()->getResult();
            if ($regYearMax - $regYearMin > 1)
            {
                $qb3 = $em->createQueryBuilder();
                $q3 = $qb3->select('r.make, r.regYear, r.regMonth, r.units')
                        ->from('AppBundle:MainChartDataMSPowiat', 'r')
                        ->where(
                                $qb3->expr()->andX(
                                        $qb3->expr()->between('r.regYear', $regYearMin+1, $regYearMax-1)
                                        )
                        );
                if (\sizeof($conditions) > 0) {
                    $orStatements = $qb3->expr()->orX();
                    foreach ($conditions as $condition) {
                        $orStatements->add(
                            $qb3->expr()->eq('r.countyName', $qb3->expr()->literal($condition))
                        );
                    }
                    $qb3->andWhere($orStatements);
                }
                $resultMid = $q3->getQuery()->getResult(); 
            } else {
                $resultMid = [];
            }
            $result = array_merge($resultMin, $resultMid, $resultMax);
        }
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
    public function testAction() {
        $em = $this->getDoctrine()->getManager();
        $regYearMin = 2007;
        $regMonthMin = 1;
        $regYearMax = 2009;
        $regMonthMax = 12;
        $conditions = [];
        if ($regYearMin === $regYearMax)
        {
            $qb = $em->createQueryBuilder();
            $q = $qb->select('r.make, r.regYear, r.regMonth, r.units')
                    ->from('AppBundle:MainChartDataMSPowiat', 'r')
                    ->where(
                            $qb->expr()->andX(
                                    $qb->expr()->eq('r.regYear', $regYearMin),
                                    $qb->expr()->between('r.regMonth', $regMonthMin, $regMonthMax)
                                    )
                    );
            if (\sizeof($conditions) > 0) {
                $orStatements = $qb->expr()->orX();
                foreach ($conditions as $condition) {
                    $orStatements->add(
                        $qb->expr()->eq('r.countyName', $qb->expr()->literal($condition))
                    );
                }
                $qb->andWhere($orStatements);
            }
            $result = $q->getQuery()->getResult();                 
        } else {
            $qb1 = $em->createQueryBuilder();
            $q1 = $qb1->select('r.make, r.regYear, r.regMonth, r.units')
                    ->from('AppBundle:MainChartDataMSPowiat', 'r')
                    ->where(
                            $qb1->expr()->andX(
                                    $qb1->expr()->eq('r.regYear', $regYearMin),
                                    $qb1->expr()->gte('r.regMonth', $regMonthMin)
                                    )
                    );
            if (\sizeof($conditions) > 0) {
                $orStatements = $qb1->expr()->orX();
                foreach ($conditions as $condition) {
                    $orStatements->add(
                        $qb1->expr()->eq('r.countyName', $qb1->expr()->literal($condition))
                    );
                }
                $qb->andWhere($orStatements);
            }
            $resultMin = $q1->getQuery()->getResult();
            $qb2 = $em->createQueryBuilder();
            $q2 = $qb2->select('r.make, r.regYear, r.regMonth, r.units')
                    ->from('AppBundle:MainChartDataMSPowiat', 'r')
                    ->where(
                            $qb2->expr()->andX(
                                    $qb2->expr()->eq('r.regYear', $regYearMax),
                                    $qb2->expr()->lte('r.regMonth', $regMonthMax)
                                    )
                    );
            if (\sizeof($conditions) > 0) {
                $orStatements = $qb2->expr()->orX();
                foreach ($conditions as $condition) {
                    $orStatements->add(
                        $qb2->expr()->eq('r.countyName', $qb2->expr()->literal($condition))
                    );
                }
                $qb2->andWhere($orStatements);
            }
            $resultMax = $q2->getQuery()->getResult();
            if ($regYearMax - $regYearMin > 1)
            {
                $qb3 = $em->createQueryBuilder();
                $q3 = $qb3->select('r.make, r.regYear, r.regMonth, r.units')
                        ->from('AppBundle:MainChartDataMSPowiat', 'r')
                        ->where(
                                $qb3->expr()->andX(
                                        $qb3->expr()->between('r.regYear', $regYearMin+1, $regYearMax-1)
                                        )
                        );
                if (\sizeof($conditions) > 0) {
                    $orStatements = $qb3->expr()->orX();
                    foreach ($conditions as $condition) {
                        $orStatements->add(
                            $qb3->expr()->eq('r.countyName', $qb3->expr()->literal($condition))
                        );
                    }
                    $qb3->andWhere($orStatements);
                }
                $resultMid = $q3->getQuery()->getResult(); 
            } else {
                $resultMid = [];
            }
            $result = array_merge($resultMin, $resultMid, $resultMax);
        }
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
    }

}
