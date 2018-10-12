<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Registrations controller
 * 
 * @Route("registrations")
 */
class RegistrationsController extends Controller
{
    /**
     * @Route("/sendData")
     */
    public function sendDataAction(Request $request)
    {
        $registrationsData = $this->getDoctrine()
                ->getRepository('AppBundle:Registrations')
                ->findAll();
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            $jsonData = array();
            $idx = 0;
            foreach ($registrationsData as $registrationsDataSingle) {
                $temp = array(
                    'make' => $registrationsDataSingle->getMake(),
                    'regYear' => $registrationsDataSingle->getRegYear(),
                    'regMonth' => $registrationsDataSingle->getRegMonth(),
                    'units' => $registrationsDataSingle->getUnits()
                );
                $jsonData[$idx++] = $temp;
            }
            return new JsonResponse($jsonData);
        } else {
            return new Response('<html><body>nie ma jsona</body></html>');
        }
    }
}