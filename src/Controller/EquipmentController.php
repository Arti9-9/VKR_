<?php

namespace App\Controller;

use App\Entity\Curriculum;
use App\Entity\Direction;
use App\Entity\Discipline;
use App\Entity\Equipment;
use App\Entity\Auditorium;
use App\Form\EquipmentType;
use App\Repository\AuditoriumRepository;
use App\Repository\EquipmentRepository;
use App\Repository\AttributeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/equipment")
 */
class EquipmentController extends AbstractController
{
    /**
     * @Route("/", name="app_equipment_index", methods={"GET"})
     */
    public function index(AuditoriumRepository $auditoriumRepository): Response
    {
        return $this->render('equipment/index.html.twig', [
            'auditoriums' => $auditoriumRepository->findAll(),
        ]);
    }

    /**
     * @Route("/auditorium/{auditorium}/new", name="app_equipment_new", methods={"GET", "POST"})
     */
    public function new(Request $request, Auditorium $auditorium, EquipmentRepository $equipmentRepository): Response
    {
        $equipment = new Equipment();
        $equipment->setAuditorium($auditorium);
        $form = $this->createForm(EquipmentType::class, $equipment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $equipmentRepository->add($equipment);
            return $this->redirectToRoute('app_auditorium_show', ['id' => $auditorium->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('equipment/new.html.twig', [
            'equipment' => $equipment,
            'form' => $form,
            'auditorium' => $auditorium,
        ]);
    }

    /**
     * @Route("/{direction}/{curriculum}/auditorium_{auditorium}/new", name="app_equipment_new_user", methods={"GET", "POST"})
     */
    public function newByUser(Request   $request, Auditorium $auditorium, EquipmentRepository $equipmentRepository,
                              Direction $direction, Curriculum $curriculum): Response
    {
        $equipment = new Equipment();
        $equipment->setAuditorium($auditorium);
        $form = $this->createForm(EquipmentType::class, $equipment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $equipment->setOwner($this->getUser());
            $equipmentRepository->add($equipment);
            return $this->redirectToRoute('app_reference_table', [
                'direction' => $direction->getId(),
                'curriculum' => $curriculum->getId()],
                Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('equipment/new.html.twig', [
            'equipment' => $equipment,
            'form' => $form,
            'auditorium' => $auditorium,
        ]);
    }

    /**
     * @Route("/{id}", name="app_equipment_show", methods={"GET"})
     */
    public function show(Equipment $equipment, AttributeRepository $attributeRepository): Response
    {
        $attributes = $attributeRepository->findByEquipment($equipment);
        return $this->render('equipment/show.html.twig', [
            'equipment' => $equipment,
            'attributes' => $attributes,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_equipment_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Equipment $equipment, EquipmentRepository $equipmentRepository): Response
    {
        $form = $this->createForm(EquipmentType::class, $equipment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $equipmentRepository->add($equipment);
            return $this->redirectToRoute('app_equipment_show', ['id' => $equipment->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('equipment/edit.html.twig', [
            'equipment' => $equipment,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_equipment_delete", methods={"POST"})
     */
    public function delete(Request $request, Equipment $equipment, EquipmentRepository $equipmentRepository): Response
    {
        $auditoriumId = $equipment->getAuditorium()->getId();
        if ($this->isCsrfTokenValid('delete' . $equipment->getId(), $request->request->get('_token'))) {
            $equipmentRepository->remove($equipment);
        }

        return $this->redirectToRoute('app_auditorium_show', ['id' => $auditoriumId], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{equipment}/{direction}/{curriculum}", name="app_equipment_delete_user", methods={"POST"})
     */
    public function deleteByUser(Request $request, Equipment $equipment, EquipmentRepository $equipmentRepository, Direction $direction, Curriculum $curriculum): Response
    {
        if ($this->isCsrfTokenValid('delete' . $equipment->getId(), $request->request->get('_token'))) {
            $equipmentRepository->remove($equipment);
        }
        return $this->redirectToRoute('app_reference_table', [
            'direction' => $direction->getId(),
            'curriculum' => $curriculum->getId()],
            Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/file_selection/upload", name="app_upload_equipment", methods={"GET"})
     */
    public function EquipmentUpload(): Response
    {

        return $this->render('equipment/upload.html.twig', [
        ]);
    }
}
