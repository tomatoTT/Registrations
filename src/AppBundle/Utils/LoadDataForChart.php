<?php
namespace AppBundle\Utils;

class LoadDataForChart {

    static public function getDataForChart($em, $select, $from, $engagement) {
        $conditions = self::getInput();
        $regYearMin = $conditions['regYearMin'];
        $regYearMax = $conditions['regYearMax'];
        $regMonthMin = $conditions['regMonthMin'];
        $regMonthMax = $conditions['regMonthMax'];        
        if ($regYearMin === $regYearMax) {
            $qb = $em->createQueryBuilder();
            $q = $qb->select($select)
                    ->from($from, 'r')
                    ->where(
                            $qb->expr()->andX(
                                    $qb->expr()->eq('r.regYear', $regYearMin),
                                    $qb->expr()->between('r.regMonth', $regMonthMin, $regMonthMax)
                                    )
                    );
            self::countyEngagement($conditions, $engagement, $qb);
            self::countyNumCheck($conditions, $qb);             
            $result = $q->getQuery()->getResult();                 
        } else {
            $qb1 = $em->createQueryBuilder();
            $q1 = $qb1->select($select)
                    ->from($from, 'r')
                    ->where(
                            $qb1->expr()->andX(
                                    $qb1->expr()->eq('r.regYear', $regYearMin),
                                    $qb1->expr()->gte('r.regMonth', $regMonthMin)
                                    )
                    );
            self::countyEngagement($conditions, $engagement, $qb1);
            self::countyNumCheck($conditions, $qb1);             
            $resultMin = $q1->getQuery()->getResult();
            $qb2 = $em->createQueryBuilder();
            $q2 = $qb2->select($select)
                    ->from($from, 'r')
                    ->where(
                            $qb2->expr()->andX(
                                    $qb2->expr()->eq('r.regYear', $regYearMax),
                                    $qb2->expr()->lte('r.regMonth', $regMonthMax)
                                    )
                    );
            self::countyEngagement($conditions, $engagement, $qb2);
            self::countyNumCheck($conditions, $qb2);
            $resultMax = $q2->getQuery()->getResult();
            if ($regYearMax - $regYearMin > 1) {
                $qb3 = $em->createQueryBuilder();
                $q3 = $qb3->select($select)
                        ->from($from, 'r')
                        ->where(
                                $qb3->expr()->andX(
                                        $qb3->expr()->between('r.regYear', $regYearMin+1, $regYearMax-1)
                                        )
                        );
                self::countyEngagement($conditions, $engagement, $qb3);
                self::countyNumCheck($conditions, $qb3);
                $resultMid = $q3->getQuery()->getResult(); 
            } else {
                $resultMid = [];
            }
            $result = array_merge($resultMin, $resultMid, $resultMax);
        }
        return $result;
    }
    
    static public function getInput() {
        $postSize = \sizeof($_POST);
        $filters = array(
            "regYearMin" => array('filter' => FILTER_SANITIZE_NUMBER_INT),
            "regYearMax" => array('filter' => FILTER_SANITIZE_NUMBER_INT),
            "regMonthMin" => array('filter' => FILTER_SANITIZE_NUMBER_INT),
            "regMonthMax" => array('filter' => FILTER_SANITIZE_NUMBER_INT),
            "make" => array('filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            "county" => array('filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS)
        );
        if ($postSize > 6) {
            for ($i = 6; $i<$postSize; $i++) {
                $filters["county".($i-6)] = array('filter' => FILTER_SANITIZE_STRING);
            }
        }
        $myPost = filter_input_array(INPUT_POST, $filters);
        $conditions = [
            "regYearMin" => $myPost['regYearMin'],
            "regMonthMin" => $myPost['regMonthMin'],
            "regYearMax" => $myPost['regYearMax'],
            "regMonthMax" => $myPost['regMonthMax'],
            "make" => $myPost['make'],
            "county" => $myPost['county']
        ];
        if ($postSize > 6) {
            for ($i=6; $i<$postSize; $i++) {
                $conditions["county".($i-6)] = $myPost["county" . ($i-6)];
            }
        }
        return $conditions;
    }
    
    static private function countyNumCheck($conditions, $qb) {
        if (\sizeof($conditions) > 6) {
            $orStatements = $qb->expr()->orX();
            for ($i=6; $i<\sizeof($conditions); $i++) {
                $orStatements->add(
                $qb->expr()->eq('r.countyName', $qb->expr()->literal($conditions["county".($i-6)]))
                );
            }
            $qb->andWhere($orStatements);
        }
        return $qb;
    }
    
    static private function countyEngagement($conditions, $engagement, $qb) {
        if ($engagement) {
            $eqStatement = $qb->expr()->andX(
                    $qb->expr()->eq('r.countyName', $qb->expr()->literal($conditions["county"]))
                    );
            $qb->andWhere($eqStatement);            
        }
        return $qb;
    }
}
