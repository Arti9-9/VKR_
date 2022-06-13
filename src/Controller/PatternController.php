<?php

namespace App\Controller;

use App\Entity\Pattern;
use App\Form\PatternType;
use App\Repository\PatternRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/pattern")
 */
class PatternController extends AbstractController
{
    /**
     * @Route("/", name="app_pattern_index", methods={"GET"})
     */
    public function index(PatternRepository $patternRepository): Response
    {

        return $this->render('pattern/index.html.twig', [
            'patterns' => $patternRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_pattern_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PatternRepository $patternRepository): Response
    {
        $pattern = new Pattern();
        $form = $this->createForm(PatternType::class, $pattern);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $patternRepository->add($pattern);

            return $this->redirectToRoute('app_pattern_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pattern/new.html.twig', [
            'pattern' => $pattern,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/{id}/edit", name="app_pattern_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Pattern $pattern, PatternRepository $patternRepository): Response
    {
        $form = $this->createForm(PatternType::class, $pattern);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $patternRepository->add($pattern);

            return $this->redirectToRoute('app_pattern_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pattern/edit.html.twig', [
            'pattern' => $pattern,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_pattern_delete", methods={"POST"})
     */
    public function delete(Request $request, Pattern $pattern, PatternRepository $patternRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pattern->getId(), $request->request->get('_token'))) {
            $patternRepository->remove($pattern);
        }

        return $this->redirectToRoute('app_pattern_index', [], Response::HTTP_SEE_OTHER);
    }
}
