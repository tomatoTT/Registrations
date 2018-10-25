<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

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
        $colors = $this->getDoctrine()->getRepository('AppBundle:Make')->findAll();

        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            $jsonData = array();
            $idx = 0;
            foreach ($registrationsData as $registrationsDataSingle) {
                
                foreach ($colors as $color) {
                    if ($color->getMake() === $registrationsDataSingle->getMake()) {
                        $colorMake = $color->getColor();
                    }
                }
                $temp = array(
                    'make' => $registrationsDataSingle->getMake(),
                    'regYear' => $registrationsDataSingle->getRegYear(),
                    'regMonth' => $registrationsDataSingle->getRegMonth(),
                    'units' => $registrationsDataSingle->getUnits(),
                    'color' => $colorMake
                );
                $jsonData[$idx++] = $temp;
            }
            return new JsonResponse($jsonData);
        } else {
            return new Response('<html><body>nie ma jsona</body></html>');
        }
    }
    
    /**
     * @Route("/delete_all")
     * @Method("DELETE")
     */
    public function deleteAllAction() {
        
        $em = $this->getDoctrine()->getManager();
        
        $query = $em->createQuery('DELETE AppBundle:Registrations');
        $query->getResult();
        $query->execute();
        
        return new Response($this->redirect('/'));
    }
    
    /**
     * @Route("/checkDouble")
     */
    public function checkDoubleAction()
    {
        $em = $this->getDoctrine()->getManager();
        $query1 = $em->createQuery(
                'SELECT r.make, r.model, r.serie, r.regYear, r.regMonth, r.units, r.rEGON, r.regType, r.tERYT'
                . ' FROM AppBundle:Registrations r'
                );
        $registrations = $query1->getResult();
        
        if (empty($registrations)) {
            return new Response('<html><body>Załaduj dane</body></html>');
        }
        
        $query2 = $em->createQuery(
                'SELECT r.make, r.model, r.serie, r.regYear, r.regMonth, r.units, r.rEGON, r.regType, r.tERYT'
                . ' FROM AppBundle:RegTot r'
                );
        $regTot = $query2->getResult();
        
        if (empty($regTot)) {
            return new Response($this->redirect('/main_chart/calculate'));
        }

        foreach ($registrations as $registrationsSingle) {
            if (array_search($registrationsSingle, $regTot)) {
                return new Response('<html><body>Znaleziono podwójne wiersze</body></html>');
            }
        }
        return new Response($this->redirect('/main_chart/calculate'));
    }
}
