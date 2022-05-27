<?php

namespace App\Controller;

use App\Entity\Direction;
use App\Entity\User;
use App\Form\DirectionType;
use App\Form\DirectionUserType;
use App\Repository\DirectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/direction")
 */
class DirectionController extends AbstractController
{
    /**
     * @Route("/", name="app_direction_index", methods={"GET"})
     */
    public function index(DirectionRepository $directionRepository): Response
    {
        return $this->render('direction/index.html.twig', [
            'directions' => $directionRepository->findAll(),
        ]);
    }
    /**
     * @Route("/{user}", name="app_direction_user_index", methods={"GET"})
     */
    public function indexUser(DirectionRepository $directionRepository): Response
    {

        return $this->render('direction/indexUser.html.twig', [
            'directions' => $directionRepository->findByUser($this->getUser()),
        ]);
    }
    /**
     * @Route("/new/{user}", name="app_direction_user_new", methods={"GET", "POST"})
     */
    public function newbyuser(Request $request, DirectionRepository $directionRepository, User $user): Response
    {
        $direction = new Direction();
        $direction->setResponsible($user);
        $form = $this->createForm(DirectionUserType::class, $direction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $directionRepository->add($direction);
            return $this->redirectToRoute('app_user_show', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('direction/newByUser.html.twig', [
            'direction' => $direction,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/new", name="app_direction_new", methods={"GET", "POST"})
     */
    public function new(Request $request, DirectionRepository $directionRepository): Response
    {
        $direction = new Direction();
        $form = $this->createForm(DirectionType::class, $direction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $directionRepository->add($direction);
            return $this->redirectToRoute('app_direction_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('direction/new.html.twig', [
            'direction' => $direction,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/show/{id}", name="app_direction_show", methods={"GET"})
     */
    public function show(Direction $direction): Response
    {
        return $this->render('direction/show.html.twig', [
            'direction' => $direction,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_direction_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Direction $direction, DirectionRepository $directionRepository): Response
    {
        $form = $this->createForm(DirectionType::class, $direction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $directionRepository->add($direction);

            return $this->redirectToRoute('app_direction_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('direction/edit.html.twig', [
            'direction' => $direction,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/delete", name="app_direction_delete", methods={"POST"})
     */
    public function delete(Request $request, Direction $direction, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $direction->getId(), $request->request->get('_token'))) {
            $entityManager->remove($direction);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_direction_index', [], Response::HTTP_SEE_OTHER);
    }
}
