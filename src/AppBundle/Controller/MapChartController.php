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
            $qb = $em->createQueryBuilder();
            $q = $qb->select('r')
                    ->from('AppBundle:RegTot', 'r')
                    ->where(
                            $qb->expr()->andX(
                                    $qb->expr()->between('r.regYear', 2017, 2018),
                                    $qb->expr()->eq('r.make', $qb->expr()->literal("JCB"))
                                    )
                    )
                    ->getQuery();
            $result = $q->getResult();
            
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
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
            $q = $qb->select('r.make, r.regYear, r.regMonth, r.units, r.tERYT')
                    ->from('AppBundle:RegTot', 'r')
                    ->where(
                            $qb->expr()->andX(
                                    $qb->expr()->between('r.regYear', 2017, 2018),
                                    $qb->expr()->eq('r.make', $qb->expr()->literal("JCB"))
                                    )
                    )
                    ->getQuery();
        $result = $q->getResult();
        /**$sourceMap = array();
            foreach ($result as $value) {
                $sourceMap[] = $value->getRegYear();
            }*/
        var_dump($result);
        return $this->render('@App/MapChart/show_map.html.twig', array(
            // ...
        ));
    }

}
