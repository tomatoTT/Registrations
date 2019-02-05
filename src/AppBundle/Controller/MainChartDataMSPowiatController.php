<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\MainChartDataMSPowiat;
use Symfony\Component\HttpFoundation\Response;

/**
 * Main chart MS County controller
 * 
 * @Route("mainChartMScounty")
 */
class MainChartDataMSPowiatController extends Controller
{
    /**
     * @Route("/calculate")
     */
    public function calculataAction()
    {
        $em = $this->getDoctrine()->getManager();

        $qb1 = $em->createQueryBuilder();
        $q1 = $qb1->select('r.make, r.regYear, r.regMonth, r.units, r.tERYT')
                    ->from('AppBundle:RegTot', 'r')
                    ->where(
                            $qb1->expr()->andX(
                                    $qb1->expr()->eq('r.regYear', "2019"),
                                    $qb1->expr()->between('r.regMonth', "1", "12")
                                    )
                    )
                    ->getQuery();
            $regTot = $q1->getResult();

        $q2 = $em->createQuery(
                'SELECT c.countyCode, c.countyName FROM AppBundle:TerytPow c'
                );
        $terytPow = $q2->getResult();
        $msCounty[0] = [
            "make" => $regTot[0]["make"],
            "regYear" => $regTot[0]["regYear"],
            "regMonth" => $regTot[0]["regMonth"],
            "units" => $regTot[0]["units"],
            "tiv" => $regTot[0]["units"],
            "countyCode" => substr($regTot[0]["tERYT"], 0, -3),
            "countyName" => $terytPow[
                array_search(
                        substr($regTot[0]["tERYT"], 0, -3),
                        array_column($terytPow, "countyCode"))]["countyName"]
        ];

        for ($i=1; $i<count($regTot); $i++)
        {
            $temp = 0;
            $tiv = $regTot[$i]["units"];
            for ($j=0; $j<count($msCounty); $j++)
            {                
                if ($msCounty[$j]["regYear"] === $regTot[$i]["regYear"] &&
                    $msCounty[$j]["regMonth"] === $regTot[$i]["regMonth"] &&
                    $msCounty[$j]["countyCode"] === substr($regTot[$i]["tERYT"], 0, -3))
                {
                    $msCounty[$j]["tiv"] += $regTot[$i]["units"];
                    $tiv = $msCounty[$j]["tiv"];
                    if ($msCounty[$j]["make"] === $regTot[$i]["make"])
                    {
                        $msCounty[$j]["units"] += $regTot[$i]["units"];
                        $temp += 1;                        
                    }                    
                }
            }            
            if ($temp === 0)
            {

                $msCounty[] = [
                    "make" => $regTot[$i]["make"],
                    "regYear" => $regTot[$i]["regYear"],
                    "regMonth" => $regTot[$i]["regMonth"],
                    "units" => $regTot[$i]["units"],
                    "tiv" => $tiv,
                    "countyCode" => substr($regTot[$i]["tERYT"], 0, -3),
                    "countyName" => $terytPow[
                        array_search(
                                substr($regTot[$i]["tERYT"], 0, -3),
                                array_column($terytPow, "countyCode"))]["countyName"]
                ];
            }
        }
        
        foreach ($msCounty as $msCountySingle)
        {
            $newMainChartDataMSPowiat = new MainChartDataMSPowiat();
            $newMainChartDataMSPowiat->setMake($msCountySingle["make"]);
            $newMainChartDataMSPowiat->setRegYear($msCountySingle["regYear"]);
            $newMainChartDataMSPowiat->setRegMonth($msCountySingle["regMonth"]);
            $newMainChartDataMSPowiat->setCountyCode($msCountySingle["countyCode"]);
            $newMainChartDataMSPowiat->setCountyName($msCountySingle["countyName"]);
            $newMainChartDataMSPowiat->setUnits($msCountySingle["units"]);
            $newMainChartDataMSPowiat->setTIV($msCountySingle["tiv"]);
            
            $em->persist($newMainChartDataMSPowiat);
        }
        $em->flush();
        
        return new Response("<h1>DONE</h1>");
    }
}
