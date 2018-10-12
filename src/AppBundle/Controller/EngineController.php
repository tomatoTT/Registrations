<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Engine;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Engine controller.
 *
 * @Route("engine")
 */
class EngineController extends Controller
{
    /**
     * Lists all engine entities.
     *
     * @Route("/", name="engine_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $engines = $em->getRepository('AppBundle:Engine')->findAll();

        return $this->render('engine/index.html.twig', array(
            'engines' => $engines,
        ));
    }

    /**
     * Creates a new engine entity.
     *
     * @Route("/new", name="engine_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $engine = new Engine();
        $form = $this->createForm('AppBundle\Form\EngineType', $engine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($engine);
            $em->flush();

            return $this->redirectToRoute('engine_show', array('id' => $engine->getId()));
        }

        return $this->render('engine/new.html.twig', array(
            'engine' => $engine,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a engine entity.
     *
     * @Route("/{id}", name="engine_show")
     * @Method("GET")
     */
    public function showAction(Engine $engine)
    {
        $deleteForm = $this->createDeleteForm($engine);

        return $this->render('engine/show.html.twig', array(
            'engine' => $engine,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing engine entity.
     *
     * @Route("/{id}/edit", name="engine_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Engine $engine)
    {
        $deleteForm = $this->createDeleteForm($engine);
        $editForm = $this->createForm('AppBundle\Form\EngineType', $engine);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('engine_edit', array('id' => $engine->getId()));
        }

        return $this->render('engine/edit.html.twig', array(
            'engine' => $engine,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a engine entity.
     *
     * @Route("/{id}", name="engine_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Engine $engine)
    {
        $form = $this->createDeleteForm($engine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($engine);
            $em->flush();
        }

        return $this->redirectToRoute('engine_index');
    }

    /**
     * Creates a form to delete a engine entity.
     *
     * @param Engine $engine The engine entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Engine $engine)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('engine_delete', array('id' => $engine->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
