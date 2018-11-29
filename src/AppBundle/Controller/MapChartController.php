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
            
            $regYear = $myPost['regYear'];
            
            $result = $em->getRepository('AppBundle:RegTot')->findByRegYear($regYear);
            
            $wynik = array();
            foreach ($result as $value) {
                $wynik[] = $value->getMake();
            }
            
            $jsonData = $wynik;

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
