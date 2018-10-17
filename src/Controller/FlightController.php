<?php

namespace App\Controller;

use App\Entity\Flight;
use App\Enums\Payments;
use App\Form\FlightType;
use App\Repository\FlightRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/flight")
 */
class FlightController extends AbstractController
{
    /**
     * @Route("/", name="flight_index", methods="GET")
     */
    public function index(FlightRepository $flightRepository): Response
    {
        return $this->render('flight/index.html.twig', [
            'flights' => $flightRepository->findAll(),
            'paymentsLabel' => Payments::PAYMENTS_LABELS,
        ]);
    }

    /**
     * @Route("/new", name="flight_new", methods="GET|POST")
     */
    function new (Request $request): Response {
        $flight = new Flight();
        $form = $this->createForm(FlightType::class, $flight);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $flight->setTeacher($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($flight);
            $em->flush();

            $this->addFlash(
                'success',
                "Le vol a bien été enregistré ! <strong>Bravo</strong> !"
            );

            return $this->redirectToRoute('account_flights');
        }

        return $this->render('flight/new.html.twig', [
            'flight' => $flight,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="flight_show", methods="GET")
     */
    public function show(Flight $flight): Response
    {
        return $this->render('flight/show.html.twig', ['flight' => $flight]);
    }

    /**
     * @Route("/{id}/edit", name="flight_edit", methods="GET|POST")
     */
    public function edit(Request $request, Flight $flight): Response
    {
        $form = $this->createForm(FlightType::class, $flight);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('flight_edit', ['id' => $flight->getId()]);
        }

        return $this->render('flight/edit.html.twig', [
            'flight' => $flight,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="flight_delete", methods="DELETE")
     */
    public function delete(Request $request, Flight $flight): Response
    {
        if ($this->isCsrfTokenValid('delete' . $flight->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($flight);
            $em->flush();
        }

        return $this->redirectToRoute('flight_index');
    }
}
