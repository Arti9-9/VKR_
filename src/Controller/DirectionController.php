<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DirectionController extends AbstractController
{
    /**
     * @Route("/direction", name="app_direction")
     */
    public function index(): Response
    {
        return $this->render('direction/index.html.twig', [
            'controller_name' => 'DirectionController',
        ]);
    }
}
