<?php

namespace App\Controller;

use App\Entity\AtributesForRequirement;
use App\Entity\Requirements;
use App\Form\AtributesForRequirementType;
use App\Repository\AtributesForRequirementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/atributes/for/requirement")
 */
class AtributesForRequirementController extends AbstractController
{

    /**
     * @Route("/{id}/{requirement}/edit", name="app_atributes_for_requirement_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Requirements $requirements, AtributesForRequirement $atributesForRequirement, AtributesForRequirementRepository $repository): Response
    {
        $form = $this->createForm(AtributesForRequirementType::class, $atributesForRequirement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $repository->add($atributesForRequirement);

            return $this->redirectToRoute('app_requirements_show', ['id' => $requirements->getId()], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('atributes_for_requirement/edit.html.twig', [
            'atributes_for_requirement' => $atributesForRequirement,
            'form' => $form,
            'requirement' => $requirements,
        ]);
    }

    /**
     * @Route("/{id}/{requirement}", name="app_atributes_for_requirement_delete", methods={"POST"})
     */
    public function delete(Request $request, Requirements $requirements,AtributesForRequirement $atributesForRequirement, AtributesForRequirementRepository $repository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$atributesForRequirement->getId(), $request->request->get('_token'))) {
            $repository->remove($atributesForRequirement);
        }

        return $this->redirectToRoute('app_requirements_show', ['id' => $requirements->getId()], Response::HTTP_SEE_OTHER);
    }
}
