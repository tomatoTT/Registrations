<?php
namespace AppBundle\Utils;

class LoadDataForChart {

    static public function getDataForChart($em) {
        $conditions = self::getInput();
        /**$regYearMin = $conditions['regYearMin'];
        $regYearMax = $conditions['regYearMax'];
        $regMonthMin = $conditions['regMonthMin'];
        $regMonthMax = $conditions['regMonthMax'];
        
        if ($regYearMin === $regYearMax) {
                $qb = $em->createQueryBuilder();
                $q = $qb->select('r.make, r.regYear, r.regMonth, r.units')
                        ->from('AppBundle:MainChartDataMSPowiat', 'r')
                        ->where(
                                $qb->expr()->andX(
                                        $qb->expr()->eq('r.regYear', $regYearMin),
                                        $qb->expr()->between('r.regMonth', $regMonthMin, $regMonthMax)
                                        )
                        );
                if (\sizeof($conditions) > 5) {
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
                if (\sizeof($conditions) > 5) {
                    $orStatements = $qb1->expr()->orX();
                    foreach ($conditions as $condition) {
                        $orStatements->add(
                            $qb1->expr()->eq('r.countyName', $qb1->expr()->literal($condition))
                        );
                    }
                    $qb1->andWhere($orStatements);
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
                if (\sizeof($conditions) > 5) {
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
                    if (\sizeof($conditions) > 5) {
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
        return $result;*/
        return $conditions;
    }
    
    static private function getInput() {
        $postSize = \sizeof($_POST);
        $filters = array(
                "regYearMin" => array('filter' => FILTER_SANITIZE_NUMBER_INT),
                "regYearMax" => array('filter' => FILTER_SANITIZE_NUMBER_INT),
                "regMonthMin" => array('filter' => FILTER_SANITIZE_NUMBER_INT),
                "regMonthMax" => array('filter' => FILTER_SANITIZE_NUMBER_INT),
                "make" => array('filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS)
            );
        if ($postSize > 5) {
            for ($i = 5; $i<$postSize; $i++) {
                $filters["county".($i-5)] = array('filter' => FILTER_SANITIZE_STRING);
            }
        }
        $myPost = filter_input_array(INPUT_POST, $filters);
        $conditions = [
            "regYearMin" => $myPost['regYearMin'],
            "regMonthMin" => $myPost['regMonthMin'],
            "regYearMax" => $myPost['regYearMax'],
            "regMonthMax" => $myPost['regMonthMax'],
            "make" => $myPost['make']
        ];
        if ($postSize > 5) {
            for ($i = 5; $i<$postSize; $i++) {
                $conditions["county".($i-5)] = $myPost["county" . ($i-5)];
            }
        }
        return $conditions;
    }
    
    private function test() {
        return "alamalkoat";
    }

}
