<?php

namespace App\Controller;

use App\Form\UserType;
use App\Repository\DirectionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Repository\UserRepository;

/**
 * @Route("/users")
 */
class UsersController extends AbstractController
{
    /**
 * @Route("/", name="app_users")
 */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('users/index.html.twig', [
            'users' => $userRepository->findAll(),//исправить!!!!!!!
        ]);
    }
    /**
     * @Route("/{id}", name="app_user_show", methods={"GET"})
     */
    public function show(User $user, DirectionRepository $directionRepository): Response
    {
        $directions = $directionRepository->findByUser($user);
        return $this->render('users/show.html.twig', [
            'directions' => $directions,
            'user' => $user,
        ]);
    }


    /**
     * @Route("/new/user", name="app_user_new", methods={"GET", "POST"})
     */
    public function new(Request $request, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles([]);
            $userRepository->add($user);
            return $this->redirectToRoute('app_users', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('users/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_user_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Auditorium $auditorium, AuditoriumRepository $auditoriumRepository): Response
    {
        $form = $this->createForm(AuditoriumType::class, $auditorium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $auditoriumRepository->add($auditorium);
            return $this->redirectToRoute('app_auditorium_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('auditorium/edit.html.twig', [
            'auditorium' => $auditorium,
            'form' => $form,
        ]);
    }
}
