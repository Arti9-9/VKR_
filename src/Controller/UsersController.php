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
            'users' => $userRepository->findByUsers('user'),//исправить!!!!!!!
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
     * @Route("/new", name="app_user_new", methods={"GET", "POST"})
     */
    public function new(Request $request, UserRepository $userRepository, User $user): Response
    {
        dd($user);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $user->setRoles(['ROLE_ADMIN']);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user);
            return $this->redirectToRoute('app_home_user', [], Response::HTTP_SEE_OTHER);
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
