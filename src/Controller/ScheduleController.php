<?php

namespace App\Controller;

use App\Repository\DirectionRepository;
use App\Repository\ScheduleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ScheduleController extends AbstractController
{
    /**
     * @Route("/schedule/upload", name="app_schedule")
     */
    public function upload(): Response
    {

        return $this->render('schedule/upload.html.twig', [
        ]);
    }

    /**
     * @Route("/schedule", name="app_schedule_index", methods={"GET"})
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
}
