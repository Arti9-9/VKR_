<?php

namespace App\Controller;

use App\Entity\Curriculum;
use App\Entity\Direction;
use App\Form\CurriculumType;
use App\Repository\CurriculumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/curriculum")
 */
class CurriculumController extends AbstractController
{
    /**
     * @Route("/", name="app_curriculum_index", methods={"GET"})
     */
    public function index(CurriculumRepository $repository): Response
    {
        return $this->render('curriculum/index.html.twig', [
            'curricula' => $repository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{direction}", name="app_curriculum_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CurriculumRepository $curriculumRepository, Direction $direction): Response
    {
        $curriculum = new Curriculum();
        $curriculum->setDirection($direction);

        return $this->render('curriculum/new.html.twig', [
            'curriculum' => $curriculum,
        ]);
    }

    /**
     * @Route("/{id}", name="app_curriculum_show", methods={"GET"})
     */
    public function show(Curriculum $curriculum): Response
    {
        return $this->render('curriculum/show.html.twig', [
            'curriculum' => $curriculum,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_curriculum_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Curriculum $curriculum, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CurriculumType::class, $curriculum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_curriculum_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('curriculum/edit.html.twig', [
            'curriculum' => $curriculum,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_curriculum_delete", methods={"POST"})
     */
    public function delete(Request $request, Curriculum $curriculum, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$curriculum->getId(), $request->request->get('_token'))) {
            $entityManager->remove($curriculum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_curriculum_index', [], Response::HTTP_SEE_OTHER);
    }
}
