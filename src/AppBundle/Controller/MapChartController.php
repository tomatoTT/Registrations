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
            
            /**$regYearMin = $myPost['regYearMin'];
            $regMonthMin = $myPost['regMonthMin'];
            $regYearMax = $myPost['regYearMax'];
            $regMonthMax = $myPost['regMonthMax'];            
            $make = $myPost['make'];*/
        $make = "JCB";
        $regYearMin = 2017;
        $regMonthMin = 2;
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
            var_dump($result);
            return $this->render('@App/MapChart/show_map.html.twig', array(
            // ...
            ));
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
        var_dump($result);
        
        return $this->render('@App/MapChart/show_map.html.twig', array(
            // ...
        ));

            
            /**$result = $em->getRepository('AppBundle:RegTot')->findBy(array('regYear' => $regYear, 'make' => 'NEWHOLLAND'));*/
            
            $sourceMap = array();
            foreach ($result as $value) {
                $sourceMap[] = $value->getModel();
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
    
}
