<?php

namespace CustomerPortalBundle\Controller;

use CustomerPortalBundle\Entity\Passenger;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Passenger controller.
 *
 * @Route("passenger")
 */
class PassengerController extends Controller
{
    /**
     * Lists all passenger entities.
     *
     * @Route("/", name="passenger_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $passengers = $em->getRepository('CustomerPortalBundle:Passenger')->findAll();

        return $this->render('passenger/index.html.twig', array(
            'passengers' => $passengers,
        ));
    }

    /**
     * Creates a new passenger entity.
     *
     * @Route("/new", name="passenger_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $passenger = new Passenger();
        $form = $this->createForm('CustomerPortalBundle\Form\PassengerType', $passenger);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($passenger);
            $em->flush();

            return $this->redirectToRoute('passenger_show', array('id' => $passenger->getId()));
        }

        return $this->render('passenger/new.html.twig', array(
            'passenger' => $passenger,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a passenger entity.
     *
     * @Route("/{id}", name="passenger_show")
     * @Method("GET")
     */
    public function showAction(Passenger $passenger)
    {
        $deleteForm = $this->createDeleteForm($passenger);

        return $this->render('passenger/show.html.twig', array(
            'passenger' => $passenger,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing passenger entity.
     *
     * @Route("/{id}/edit", name="passenger_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Passenger $passenger)
    {
        $deleteForm = $this->createDeleteForm($passenger);
        $editForm = $this->createForm('CustomerPortalBundle\Form\PassengerType', $passenger);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('passenger_edit', array('id' => $passenger->getId()));
        }

        return $this->render('passenger/edit.html.twig', array(
            'passenger' => $passenger,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a passenger entity.
     *
     * @Route("/{id}", name="passenger_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Passenger $passenger)
    {
        $form = $this->createDeleteForm($passenger);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($passenger);
            $em->flush();
        }

        return $this->redirectToRoute('passenger_index');
    }

    /**
     * Creates a form to delete a passenger entity.
     *
     * @param Passenger $passenger The passenger entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Passenger $passenger)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('passenger_delete', array('id' => $passenger->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
