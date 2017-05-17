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

            return $this->redirectToRoute('index');
        }

        return $this->render('passenger/new.html.twig', array(
            'passenger' => $passenger,
            'form' => $form->createView(),
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

        return $this->redirectToRoute('index');
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
