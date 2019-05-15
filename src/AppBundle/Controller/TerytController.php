<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Map Chart controller
 * 
 * @Route("teryt")
 */
class TerytController extends Controller
{
    /**
     * @Route("/getProvince")
     */
    public function getProvinceAction(Request $request) {
         if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
             $em = $this->getDoctrine()->getManager();
             $qb = $em->createQueryBuilder();
             $q = $qb->select('t.nazwa, t.woj')
                    ->from('AppBundle:Teryt', 't')
                    ->where(
                            $qb->expr()->andX(
                                    $qb->expr()->isNull('t.pow'),
                                    $qb->expr()->isNull('t.gmi'),
                                    $qb->expr()->isNull('t.rodz') 
                            )
                    );
             $result = $q->getQuery()->getResult();
             return new JsonResponse($result);
         } else {
            return $this->render('@App/Teryt/region_picker.html.twig', array(
            // ...
        ));
        }
    }

    /**
     * @Route("/getCounty")
     */
    public function getCountyAction(Request $request) {
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            if (!empty($_POST)) {
                $postSize = \sizeof($_POST);
            } else {
                $postSize = 0;
            }
            
            if ($postSize > 0) {
                
                for ($i = 0; $i<$postSize; $i++) {
                    $filters["province".$i] = array('filter' => FILTER_SANITIZE_NUMBER_INT);
                }
            }
            $myPost = filter_input_array(INPUT_POST, $filters);
            $em = $this->getDoctrine()->getManager();
            $qb = $em->createQueryBuilder();
            $q = $qb->select('t.nazwa, t.pow')
                    ->from('AppBundle:Teryt', 't')
                    ->where(
                            $qb->expr()->andX(
                                    $qb->expr()->isNotNull('t.pow'),
                                    $qb->expr()->isNull('t.gmi'),
                                    $qb->expr()->isNull('t.rodz') 
                            )
                    );
            if ($postSize > 0) {
                $orStatements = $qb->expr()->orX();
                for ($i=0; $i<$postSize; $i++) {
                    $orStatements->add(
                          $qb->expr()->eq('t.woj', $qb->expr()->literal($myPost['province'.$i]))  
                    );
                }
                $qb->andWhere($orStatements);
            }            
            $result = $q->getQuery()->getResult();
            return new JsonResponse($result);
         } else {
            return new Response('<html><body>nie ma jsona</body></html>');
        }

    }

    /**
     * @Route("/getCommunity")
     */
    public function getCommunityAction(Request $request)
    {
        return $this->render('AppBundle:Teryt:get_community.html.twig', array(
            // ...
        ));
    }
    
    /**
     * @Route("/regionPicker")
     */
    public function regionPickerAction() {
        return $this->render('@App/Teryt/region_picker.html.twig', array(
            // ...
        ));
    }

}
