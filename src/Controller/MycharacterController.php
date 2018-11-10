<?php

namespace App\Controller;

use App\Entity\Mycharacter;
use App\Form\MycharacterType;
use App\Repository\MycharacterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mycharacter")
 */
class MycharacterController extends AbstractController
{
    /**
     * @Route("/", name="mycharacter_index", methods="GET")
     */
    public function index(MycharacterRepository $mycharacterRepository): Response
    {
        return $this->render('mycharacter/index.html.twig', ['mycharacters' => $mycharacterRepository->findAll()]);
    }

    /**
     * @Route("/new", name="mycharacter_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $mycharacter = new Mycharacter();
        $form = $this->createForm(MycharacterType::class, $mycharacter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mycharacter);
            $em->flush();

            return $this->redirectToRoute('mycharacter_index');
        }

        return $this->render('mycharacter/new.html.twig', [
            'mycharacter' => $mycharacter,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="mycharacter_show", methods="GET")
     */
    public function show(Mycharacter $mycharacter): Response
    {
        return $this->render('mycharacter/show.html.twig', ['mycharacter' => $mycharacter]);
    }

    /**
     * @Route("/{id}/edit", name="mycharacter_edit", methods="GET|POST")
     */
    public function edit(Request $request, Mycharacter $mycharacter): Response
    {
        $form = $this->createForm(MycharacterType::class, $mycharacter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mycharacter_index', ['id' => $mycharacter->getId()]);
        }

        return $this->render('mycharacter/edit.html.twig', [
            'mycharacter' => $mycharacter,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="mycharacter_delete", methods="DELETE")
     */
    public function delete(Request $request, Mycharacter $mycharacter): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mycharacter->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mycharacter);
            $em->flush();
        }

        return $this->redirectToRoute('mycharacter_index');
    }
}
