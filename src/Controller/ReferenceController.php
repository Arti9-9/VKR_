<?php

namespace App\Controller;

use App\Entity\Curriculum;
use App\Entity\Direction;
use App\Entity\Discipline;
use App\Repository\CurriculumRepository;
use App\Repository\DirectionRepository;
use App\Repository\DisciplineRepository;
use App\Repository\EquipmentRepository;
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
    public function table( Direction $direction, Curriculum $curriculum,
                          ScheduleRepository  $scheduleRepository, EquipmentRepository $equipmentRepository): Response
    {
        //дисциплины
        $disciplines = $curriculum->getDisciplines();

        //аудитории в которых проводятся занятия по дисциплинам данного направления
        $auditoriums = array();
        $equipments = array();
        foreach ($disciplines as $discipline) {
            //находим все строки в расписании по направлению для определенной дисциплины
            $schedule = $scheduleRepository->findByGroupByDiscipline($direction->getNameGroup(), $discipline);
            //если не нашлось аудитории в расписании
            if ($schedule == null) {
                $auditoriums[$discipline->getName()][] = null;
            } else {
                //заполнение аудиторий для дисциплины
                foreach ($schedule as $key => $row) {
                    //отслеживаем пользовательские изменения и прорускаем только изменения текущего пользователя
                    if ($row->getOwner()) {
                        if ($row->getOwner() == $this->getUser()) {
                            $auditoriums[$discipline->getName()][$key][] = $row->getAuditorium();
                            $auditoriums[$discipline->getName()][$key][] = $row->getId();//добавляем айди строки расписания к аудитории если она добавлена пользователем,
                            //чтобы в дальнейшем ее можно было удалить
                        }
                    } else {
                        $auditoriums[$discipline->getName()][$key][] = $row->getAuditorium();
                        $auditoriums[$discipline->getName()][$key][] = null;
                    }
                }
                //алгоритм проверки на повторения
                $keys=array(); // Массив ключей, которые уже встречались
                foreach($auditoriums[$discipline->getName()] as $k=>$val) {
                    if(array_key_exists($val['0']->getId(),$keys)) {
                        unset($auditoriums[$discipline->getName()][$k]);
                    } else {
                        $keys[$val['0']->getId()]=1;
                    }
                }

                //заполнения массива оборудования
                foreach ($auditoriums[$discipline->getName()] as $auditorium) {
                    //нужно для того чтобы не ломался твиг
                    $equipments[$auditorium[0]->getNumber()] = null;
                    //auditorium[0] - обьект аудитории, auditorium[1] - проверка на то не добавил ли ее пользователь
                    foreach ($equipmentRepository->findByAuditorium($auditorium[0]) as $equipment) {
                        //отслеживаем пользовательские изменения и прорускаем только изменения текущего пользователя
                        if ($equipment->getOwner()) {
                            //если изменения принадлежат данному пользователю
                            if ($equipment->getOwner() == $this->getUser()) {
                                $equipments[$auditorium[0]->getNumber()][$equipment->getCategory()][] = $equipment;
                            }
                        } //если изменений нет
                        else {
                            $equipments[$auditorium[0]->getNumber()][$equipment->getCategory()][] = $equipment;
                        }

                    }
                }
            }
        }
        return $this->render('reference/table.html.twig', [
            'direction' => $direction,
            'curriculum' => $curriculum,
            'disciplines' => $disciplines,
            'auditoriums' => $auditoriums,
            'equipments' => $equipments,
        ]);
    }
}
