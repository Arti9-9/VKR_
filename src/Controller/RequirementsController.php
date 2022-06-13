<?php

namespace App\Controller;

use App\Entity\AtributesForRequirement;
use App\Entity\Auditorium;
use App\Entity\Curriculum;
use App\Entity\Discipline;
use App\Entity\Requirements;
use App\Form\AtributeForRequirementType;
use App\Form\RequirementsType;
use App\Repository\AtributesForRequirementRepository;
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
    public function index( DirectionRepository $directionRepository, RequirementsRepository $requirementsRepository): Response
    {
        $directions = $directionRepository->findByUser($this->getUser());
        $requirements =array();
        foreach ($directions as $direction) {
            foreach ($direction->getCurriculum() as $curriculum) {
                $requirements[$direction->getName()][$curriculum->getName()] = $requirementsRepository->findByCurriculum($curriculum);
            }
        }
        return $this->render('requirements/index.html.twig', [
            'data' => $requirements,
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
     * @Route("/requirements{requirements}/new_atributes", name="app_requirement_new_attributes", methods={"GET", "POST"})
     */
    public function newAttributes(Request $request, Requirements $requirements, AtributesForRequirementRepository $repository): Response
    {
        $attribute = new AtributesForRequirement();
        $form = $this->createForm(AtributeForRequirementType::class, $attribute);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $attribute->setRequipment($requirements);
            $repository->add($attribute);
            return $this->redirectToRoute('app_requirements_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('requirements/newAttribute.html.twig', [
            'requirements' => $requirements,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_requirements_show", methods={"GET"})
     */
    public function show(Requirements $requirement, AtributesForRequirementRepository $repository): Response
    {
        $attributes = $repository->findByRequirements($requirement);
        return $this->render('requirements/show.html.twig', [
            'requirement' => $requirement,
            'attributes' => $attributes,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_requirements_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Requirements $requirement, RequirementsRepository  $requirementsRepository): Response
    {
        $form = $this->createForm(RequirementsType::class, $requirement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $requirementsRepository->add($requirement);

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
