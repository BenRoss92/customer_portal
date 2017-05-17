<?php

namespace CustomerPortalBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use CustomerPortalBundle\Entity\Customer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Session\Session;

class CustomerController extends Controller
{
    /**
     * @Route("/sessions/new", name="new_session")
     */
     public function newSessionsAction(Request $request)
     {
       $customer = new Customer();

       $form = $this->createFormBuilder($customer)
          ->add('name', TextType::class)
          ->add('password', PasswordType::class)
          ->add('logIn', SubmitType::class, array('label' => 'Login'))
          ->getForm();

       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {
         $customer = $form->getData();
         $session = $request->getSession();
         $session->set('customer_name', $customer->getName());
         return $this->redirectToRoute('index');
       }

       return $this->render('customer/sessions/new.html.twig', array(
         'form' => $form->createView(),
       ));
     }

    /**
     * @Route("/", name="index")
     * @Method({"GET", "POST"})
     */
     public function indexAction(Request $request)
     {
      $session = $request->getSession();

      if (!$session->has('customer_name')) {
        return $this->redirectToRoute('new_session');
      }

      $customer_repository = $this->getDoctrine()
          ->getRepository('CustomerPortalBundle:Customer');
      $customer = $customer_repository->findOneByName($session->get('customer_name'));

      if (!$customer) {
        throw $this->createNotFoundException(
          'No customer found for name '.$session->get('customer_name')
        );
      }

       $form = $this->createFormBuilder($customer)
          ->add('name', TextType::class)
          ->add('address', TextType::class)
          ->add('city', TextType::class)
          ->add('country', TextType::class)
          ->add('update', SubmitType::class, array('label' => 'Update'))
          ->getForm();

        $form->handleRequest($request);
        $customer = $form->getData();

        if ($form->isSubmitted() && $form->isValid()) {
          $customer = $form->getData();

           $em = $this->getDoctrine()->getManager();
           $em->persist($customer);
           $em->flush();

           return $this->redirectToRoute('index');
          }

        $passengers = $customer->getPassengers();

        $deleteForms = array();

        foreach ($passengers as $passenger) {
          $deleteForms[$passenger->getId()] = $this->createDeleteForm($passenger)->createView();
        }

        return $this->render('customer/index.html.twig', array(
          'passengers' => $passengers,
          'deleteForms' => $deleteForms,
          'form' => $form->createView(),
        ));
       }

     /**
      * Deletes a passenger entity.
      *
      * @Route("/{id}", name="passenger_delete")
      * @Method("DELETE")
      */
     public function deleteAction(Request $request, $passenger)
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
     private function createDeleteForm($passenger)
     {
         return $this->createFormBuilder()
             ->setAction($this->generateUrl('passenger_delete', array('id' => $passenger->getId())))
             ->setMethod('DELETE')
             ->getForm()
         ;
     }

}
