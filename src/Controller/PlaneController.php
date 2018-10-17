<?php

namespace App\Controller;

use App\Entity\Plane;
use App\Form\PlaneType;
use App\Repository\PlaneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/plane")
 */
class PlaneController extends AbstractController
{
    /**
     * @Route("/", name="plane_index", methods="GET")
     */
    public function index(PlaneRepository $planeRepository): Response
    {
        return $this->render('plane/index.html.twig', ['planes' => $planeRepository->findAll()]);
    }

    /**
     * @Route("/new", name="plane_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $plane = new Plane();
        $form = $this->createForm(PlaneType::class, $plane);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($plane);
            $em->flush();

            return $this->redirectToRoute('plane_index');
        }

        return $this->render('plane/new.html.twig', [
            'plane' => $plane,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="plane_show", methods="GET")
     */
    public function show(Plane $plane): Response
    {
        return $this->render('plane/show.html.twig', ['plane' => $plane]);
    }

    /**
     * @Route("/{id}/edit", name="plane_edit", methods="GET|POST")
     */
    public function edit(Request $request, Plane $plane): Response
    {
        $form = $this->createForm(PlaneType::class, $plane);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('plane_edit', ['id' => $plane->getId()]);
        }

        return $this->render('plane/edit.html.twig', [
            'plane' => $plane,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="plane_delete", methods="DELETE")
     */
    public function delete(Request $request, Plane $plane): Response
    {
        if ($this->isCsrfTokenValid('delete'.$plane->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($plane);
            $em->flush();
        }

        return $this->redirectToRoute('plane_index');
    }
}
