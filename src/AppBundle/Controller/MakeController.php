<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Make;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Make controller.
 *
 * @Route("make")
 */
class MakeController extends Controller
{
    /**
     * Lists all make entities.
     *
     * @Route("/", name="make_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $makes = $em->getRepository('AppBundle:Make')->findAll();

        return $this->render('make/index.html.twig', array(
            'makes' => $makes,
        ));
    }

    /**
     * Creates a new make entity.
     *
     * @Route("/new", name="make_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $make = new Make();
        $form = $this->createForm('AppBundle\Form\MakeType', $make);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($make);
            $em->flush();

            return $this->redirectToRoute('make_show', array('id' => $make->getId()));
        }

        return $this->render('make/new.html.twig', array(
            'make' => $make,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a make entity.
     *
     * @Route("/{id}", name="make_show")
     * @Method("GET")
     */
    public function showAction(Make $make)
    {
        $deleteForm = $this->createDeleteForm($make);

        return $this->render('make/show.html.twig', array(
            'make' => $make,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing make entity.
     *
     * @Route("/{id}/edit", name="make_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Make $make)
    {
        $deleteForm = $this->createDeleteForm($make);
        $editForm = $this->createForm('AppBundle\Form\MakeType', $make);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('make_edit', array('id' => $make->getId()));
        }

        return $this->render('make/edit.html.twig', array(
            'make' => $make,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a make entity.
     *
     * @Route("/{id}", name="make_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Make $make)
    {
        $form = $this->createDeleteForm($make);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($make);
            $em->flush();
        }

        return $this->redirectToRoute('make_index');
    }

    /**
     * Creates a form to delete a make entity.
     *
     * @param Make $make The make entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Make $make)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('make_delete', array('id' => $make->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
