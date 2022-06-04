<?php

namespace App\Controller;

use App\Entity\Discipline;
use App\Repository\AuditoriumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/discipline")
 */
class DisciplineController extends AbstractController
{

    public function index(): Response
    {
        return $this->render('discipline/index.html.twig', [
            'controller_name' => 'DisciplineController',
        ]);
    }
    /**
     * @Route("/{id}", name="app_disciplin_show", methods={"GET"})
     */
    public function show(Discipline $discipline, AuditoriumRepository $auditoriumRepository): Response
    {

        return $this->render('discipline/show.html.twig', [
            'discipline' => $discipline,
        ]);
    }
}
