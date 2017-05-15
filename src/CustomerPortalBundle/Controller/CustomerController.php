<?php

namespace CustomerPortalBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use CustomerPortalBundle\Entity\Customer;
use Symfony\Component\HttpFoundation\Response;

class CustomerController extends Controller
{
    /**
     * @Route("/", name="mainpage")
     */
     public function showAction()
     {
      $repository = $this->getDoctrine()
          ->getRepository('CustomerPortalBundle:Customer');
      $customer = $repository->findOneByName('Ontro Ltd.');

      if (!$customer) {
        throw $this->createNotFoundException(
          'No customer found for name Ontro Ltd.'
        );
      }
      return $this->render('customer/index.html.twig', array(
        'name' => $customer->getName(),
        'address' => $customer->getAddress(),
        'city' => $customer->getCity(),
        'country' => $customer->getCountry(),
      ));

     }

    /**
     * @Route("/create", name="createpage")
     */
     public function createAction()
     {
          $customer = new Customer();
          $customer->setName('Ontro Ltd.');
          $customer->setAddress('2 Chitty Street');
          $customer->setCity('London');
          $customer->setCountry('United Kingdom');

          $em = $this->getDoctrine()->getManager();

          $em->persist($customer);

          $em->flush();

          return new Response('Saved new customer with name '.$customer->getName());
     }
}
