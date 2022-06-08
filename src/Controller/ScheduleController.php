<?php

namespace App\Controller;

use App\Entity\Curriculum;
use App\Entity\Direction;
use App\Entity\Discipline;
use App\Entity\Schedule;
use App\Form\ScheduleType;
use App\Repository\AuditoriumRepository;
use App\Repository\DirectionRepository;
use App\Repository\ScheduleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/schedule")
 */
class ScheduleController extends AbstractController
{
    /**
     * @Route("/upload", name="app_schedule")
     */
    public function upload(): Response
    {

        return $this->render('schedule/upload.html.twig', [
        ]);
    }

    /**
     * @Route("/", name="app_schedule_index", methods={"GET"})
     */
    public function index(ScheduleRepository $scheduleRepository, DirectionRepository $directionRepository): Response
    {
        //если пользователь админ, то выведем все расписание
        if ($this->getUser()->getRoles() == ['ROLE_ADMIN']) {
            $schedule = $scheduleRepository->findOrderBy();
        } //если обычный пользователь то выведем тольно расписание по его направлениям
        else {
            $directions = $directionRepository->findByUser($this->getUser());
            $schedules = array();
            //если полььзователь отвечает за несколько направлений
            foreach ($directions as $direction) {
                $schedules[] = $scheduleRepository->findByGroup($direction->getNameGroup());
            }
        }
        //создаем массив имен
        $groupsName = array();
        if ($this->getUser()->getRoles() == ['ROLE_ADMIN']) {
            foreach ($schedule as $row) {
                $scheduleGroups[$row->getGroupName()][] = $row;
                $groupsName[] = $row->getGroupName();
            }
        } else {
            foreach ($schedules as $schedule) {
                foreach ($schedule as $row) {
                    $scheduleGroups[$row->getGroupName()][] = $row;
                    $groupsName[] = $row->getGroupName();
                }
            }
        }
        $groupsName = array_unique($groupsName);
        return $this->render('schedule/index.html.twig', [
            'schedule' => $scheduleGroups,
            'groupsName' => $groupsName,
        ]);
    }

    /**
     * @Route("/new/{direction}/{curriculum}/{discipline}", name="app_schedule_new", methods={"GET", "POST"})
     */
    public function new(Request $request, Discipline $discipline, Curriculum $curriculum, Direction $direction, ScheduleRepository $scheduleRepository,
    AuditoriumRepository $auditoriumRepository): Response
    {
        $schedule = new Schedule();
        $auditoriums=$auditoriumRepository->findAll();
        $form = $this->createForm(ScheduleType::class, $schedule);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $schedule->setOwner($this->getUser());
            $schedule->setDiscipline($discipline);
            $schedule->setGroupName($direction->getNameGroup() . '- правки пользователя');
            $scheduleRepository->add($schedule);
            return $this->redirectToRoute('app_reference_table', [
                    'direction' => $direction->getId(),
                    'curriculum' => $curriculum->getId()]
                , Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('schedule/newScheduleRow.html.twig', [
            'direction' => $direction,
            'curriculum' => $curriculum,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{schedule}/{direction}/{curriculum}", name="app_schedule_delete_user", methods={"POST"})
     */
    public function deleteByUser(Request $request, Schedule $schedule, ScheduleRepository $scheduleRepository, Direction $direction, Curriculum $curriculum): Response
    {
        if ($this->isCsrfTokenValid('delete' . $schedule->getId(), $request->request->get('_token'))) {
            $scheduleRepository->remove($schedule);
        }
        return $this->redirectToRoute('app_reference_table', [
            'direction' => $direction->getId(),
            'curriculum' => $curriculum->getId()],
            Response::HTTP_SEE_OTHER);
    }
}
