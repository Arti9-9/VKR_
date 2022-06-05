<?php

namespace App\Controller;

use App\Entity\Curriculum;
use App\Entity\Direction;
use App\Entity\Discipline;
use App\Repository\CurriculumRepository;
use App\Repository\DirectionRepository;
use App\Repository\DisciplineRepository;
use App\Repository\ScheduleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reference")
 */
class ReferenceController extends AbstractController
{
    /**
     * @Route("/", name="app_reference")
     */
    public function index(DirectionRepository $directionRepository, CurriculumRepository $curriculumRepository): Response
    {
        $directions = $directionRepository->findByUser($this->getUser());
        $curriculums = array();
        foreach ($directions as $direction) {
            $curriculums[$direction->getName()] = $curriculumRepository->findByDirection($direction);
        }
        return $this->render('reference/index.html.twig', [
            'directions' => $directions,
            'curriculums' => $curriculums,
        ]);
    }

    /**
     * @Route("/table/{direction}/{curriculum}", name="app_reference_table")
     */
    public function table(DirectionRepository $directionRepository, Direction $direction, Curriculum $curriculum,
                          ScheduleRepository  $scheduleRepository, DisciplineRepository $disciplineRepository): Response
    {
        //расписание по направлению

        //дисциплины
        $disciplines = $curriculum->getDisciplines();

        //аудитории в которых проводятся занятия по дисциплинам данного направления
        $auditoriums = array();
        foreach ($disciplines as $discipline) {
            //находим все строки в расписании по направлению для определенной дисциплины
            $schedule = $scheduleRepository->findByGroupByDiscipline($direction->getNameGroup(), $discipline);
            if ($schedule == null) {
                $auditoriums[$discipline->getName()][] = null;
            } else {
                //заполниим аудитории для дисциплины
                foreach ($schedule as $row) {
                    $auditoriums[$discipline->getName()][] = $row->getAuditorium();
                }
                $auditoriums[$discipline->getName()] = array_unique($auditoriums[$discipline->getName()]);
            }
        }
        return $this->render('reference/table.html.twig', [
            'directions' => $direction,
            'disciplines' => $disciplines,
            'auditoriums' => $auditoriums,
        ]);
    }
}
