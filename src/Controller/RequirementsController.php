<?php

namespace App\Controller;

use App\Entity\Auditorium;
use App\Entity\Curriculum;
use App\Entity\Discipline;
use App\Entity\Requirements;
use App\Form\RequirementsType;
use App\Repository\CurriculumRepository;
use App\Repository\DirectionRepository;
use App\Repository\RequirementsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/requirements")
 */
class RequirementsController extends AbstractController
{
    /**
     * @Route("/", name="app_requirements_index", methods={"GET"})
     */
    public function index( $entityManager): Response
    {
        $requirements = $entityManager
            ->getRepository(Requirements::class)
            ->findAll();

        return $this->render('requirements/index.html.twig', [
            'requirements' => $requirements,
        ]);
    }
    /**
     * @Route("/choice_curriculum", name="app_requirements_choice_curriculum", methods={"GET"})
     */
    public function choiceCurriculum( DirectionRepository $directionRepository, CurriculumRepository $curriculumRepository): Response
    {
        $directions = $directionRepository->findByUser($this->getUser());
        $curriculums = array();
        foreach ($directions as $direction) {
            $curriculums[$direction->getName()] = $curriculumRepository->findByDirection($direction);
        }

        return $this->render('requirements/choice_curriculum.html.twig', [
            'directions' => $directions,
            'curriculums' => $curriculums,
        ]);
    }

    /**
     * @Route("/choice_discipline/{curriculum}", name="app_requirements_choice_discipline", methods={"GET"})
     */
    public function choiceDiscipline( Curriculum $curriculum): Response
    {
       return $this->render('requirements/choice_discipline.html.twig', [
            'curriculum' => $curriculum,
        ]);
    }

    /**
     * @Route("/{curriculum}/{discipline}/new", name="app_requirements_new", methods={"GET", "POST"})
     */
    public function new(Request $request, Curriculum $curriculum, Discipline $discipline, RequirementsRepository $requirementsRepository): Response
    {
        $requirement = new Requirements();
        $form = $this->createForm(RequirementsType::class, $requirement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $requirement->setCurriculum($curriculum);
            $requirement->setDiscipline($discipline);
            $requirementsRepository->add($requirement);
            return $this->redirectToRoute('app_requirements_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('requirements/new.html.twig', [
            'requirement' => $requirement,
            'form' => $form,
            'discipline' => $discipline,
            'curriculum' => $curriculum,
        ]);
    }

    /**
     * @Route("/requirements{requirements}/new_atributes", name="app_requirement_new_atributes", methods={"GET", "POST"})
     */
    public function newAtributs(Request $request, Curriculum $curriculum, Discipline $discipline, RequirementsRepository $requirementsRepository): Response
    {
        $requirement = new Requirements();
        $form = $this->createForm(RequirementsType::class, $requirement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $requirement->setCurriculum($curriculum);
            $requirement->setDiscipline($discipline);
            $requirementsRepository->add($requirement);
            return $this->redirectToRoute('app_requirements_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('requirements/new.html.twig', [
            'requirement' => $requirement,
            'form' => $form,
            'discipline' => $discipline,
        ]);
    }

    /**
     * @Route("/{id}", name="app_requirements_show", methods={"GET"})
     */
    public function show(Requirements $requirement): Response
    {
        return $this->render('requirements/show.html.twig', [
            'requirement' => $requirement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_requirements_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Requirements $requirement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RequirementsType::class, $requirement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_requirements_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('requirements/edit.html.twig', [
            'requirement' => $requirement,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_requirements_delete", methods={"POST"})
     */
    public function delete(Request $request, Requirements $requirement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$requirement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($requirement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_requirements_index', [], Response::HTTP_SEE_OTHER);
    }
}
