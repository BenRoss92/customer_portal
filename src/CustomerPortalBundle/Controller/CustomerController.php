<?php

namespace CustomerPortalBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
       $session = $request->getSession();
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
         $em = $this->getDoctrine()->getManager();
         $em->persist($customer);
         $em->flush();

         return $this->redirectToRoute('index');
       }

       return $this->render('customer/sessions/new.html.twig', array(
         'form' => $form->createView(),
       ));
     }

    /**
     * @Route("/", name="index")
     */
     public function indexAction(Request $request)
     {
      $session = $request->getSession();

      if ($session->isStarted() === false) {
        return $this->redirectToRoute('new_session');
      }

      $customer_name = $session->get('customer_name');
      $repository = $this->getDoctrine()
          ->getRepository('CustomerPortalBundle:Customer');
      $customer = $repository->findOneByName($customer_name);

      if (!$customer) {
        throw $this->createNotFoundException(
          'No customer found for name'.$customer_name
        );
      }
      
      return $this->render('customer/index.html.twig', array(
        'name' => $customer->getName(),
        'address' => $customer->getAddress(),
        'city' => $customer->getCity(),
        'country' => $customer->getCountry(),
      ));
     }
}
