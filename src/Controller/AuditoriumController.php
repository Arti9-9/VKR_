<?php

namespace App\Controller;

use App\Entity\Auditorium;
use App\Form\AuditoriumType;
use App\Repository\AuditoriumRepository;
use App\Repository\EquipmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/auditorium")
 */
class AuditoriumController extends AbstractController
{
    /**
     * @Route("/", name="app_auditorium_index", methods={"GET"})
     */
    public function index(AuditoriumRepository $auditoriumRepository): Response
    {
        return $this->render('auditorium/index.html.twig', [
            'auditoria' => $auditoriumRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_auditorium_new", methods={"GET", "POST"})
     */
    public function new(Request $request, AuditoriumRepository $auditoriumRepository): Response
    {
        $auditorium = new Auditorium();
        $form = $this->createForm(AuditoriumType::class, $auditorium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $auditoriumRepository->add($auditorium);
            return $this->redirectToRoute('app_auditorium_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('auditorium/new.html.twig', [
            'auditorium' => $auditorium,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_auditorium_show", methods={"GET"})
     */
    public function show(Auditorium $auditorium, EquipmentRepository $equipmentRepository): Response
    {
        $technicalMeans = $equipmentRepository->findByAuditoriumCategory($auditorium, 'Технические средства');
        $softwares = $equipmentRepository->findByAuditoriumCategory($auditorium, 'ПО');
        return $this->render('auditorium/show.html.twig', [
            'auditorium' => $auditorium,
            'techicalMeans' => $technicalMeans,
            'softwares' => $softwares,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_auditorium_edit", methods={"GET", "POST"})
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

    /**
     * @Route("/{id}", name="app_auditorium_delete", methods={"POST"})
     */
    public function delete(Request $request, Auditorium $auditorium, AuditoriumRepository $auditoriumRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $auditorium->getId(), $request->request->get('_token'))) {
            $auditoriumRepository->remove($auditorium);

        }
        return $this->redirectToRoute('app_auditorium_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/file_selection/upload", name="app_upload_auditorium", methods={"GET"})
     */
    public function AuditoriumUpload(): Response
    {

        return $this->render('auditorium/upload.html.twig', [
        ]);
    }
}
