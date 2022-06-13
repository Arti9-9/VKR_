<?php

namespace App\Controller;

use App\Entity\Curriculum;
use App\Entity\Direction;
use App\Entity\Discipline;
use App\Repository\EquipmentRepository;
use App\Repository\RequirementsRepository;
use App\Repository\ScheduleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

class PDFController extends AbstractController
{
    /**
     * @Route("/reportPDF/{direction}/{curriculum}", name="app_pdf_report", methods={"GET"})
     */
    public function report(Direction $direction, Curriculum $curriculum, ScheduleRepository $scheduleRepository, EquipmentRepository $equipmentRepository, RequirementsRepository $requirementsRepository): Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'arial');
// Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
// Retrieve the HTML generated in our twig file

        $disciplines = $curriculum->getDisciplines();
        //аудитории в которых проводятся занятия по дисциплинам данного направления
        $auditoriums = array();
        $equipments = array();
        //массив аудиторий и соответсвий требованиям для дисциплины
        $checking = array();
        $c = array();
        foreach ($disciplines as $discipline) {

            //находим все строки в расписании по направлению для определенной дисциплины
            $schedule = $scheduleRepository->findByGroupByDiscipline($direction->getNameGroup(), $discipline);
            //если не нашлось аудитории в расписании
            if (count($schedule)==0) {
                $auditoriums[$discipline->getName()][] = null;
            } else {
                //заполнение аудиторий для дисциплины
                foreach ($schedule as $key => $row) {

                    //отслеживаем пользовательские изменения и прорускаем только изменения текущего пользователя
                    if ($row->getOwner()) {
                        if ($row->getOwner() == $this->getUser()) {
                            $auditoriums[$discipline->getName()][$key]['auditorium'] = $row->getAuditorium();
                            $auditoriums[$discipline->getName()][$key]['schedule'] = $row->getId();//добавляем айди строки расписания к аудитории если она добавлена пользователем,чтобы в дальнейшем ее можно было удалить
                            $auditoriums[$discipline->getName()][$key]['description'] = $row->getDescription();

                        }
                    } else {
                        $auditoriums[$discipline->getName()][$key]['auditorium'] = $row->getAuditorium();
                        $auditoriums[$discipline->getName()][$key]['schedule'] = null;
                        $auditoriums[$discipline->getName()][$key]['description'] = $row->getDescription();
                    }
                }

                //алгоритм проверки на повторения
                $keys = array(); // Массив ключей, которые уже встречались
                foreach ($auditoriums[$discipline->getName()] as $k => $val) {
                    if (array_key_exists($val['auditorium']->getId(), $keys)) {
                        unset($auditoriums[$discipline->getName()][$k]);
                    } else {
                        $keys[$val['auditorium']->getId()] = 1;
                    }
                }
                $nameEquipments = array();
                //заполнения массива оборудования
                foreach ($auditoriums[$discipline->getName()] as $auditorium) {
                    //нужно для того чтобы не ломался твиг
                    $equipments[$auditorium['auditorium']->getNumber()] = null;
                    //auditorium[0] - обьект аудитории, auditorium[1] - проверка на то не добавил ли ее пользователь
                    foreach ($equipmentRepository->findByAuditorium($auditorium['auditorium']) as $equipment) {
                        //отслеживаем пользовательские изменения и прорускаем только изменения текущего пользователя

                        if ($equipment->getOwner()) {
                            //если изменения принадлежат данному пользователю
                            if ($equipment->getOwner() == $this->getUser()) {
                                $nameEquipments[] = $equipment->getName();
                                $equipments[$auditorium['auditorium']->getNumber()][$equipment->getCategory()][] = $equipment;
                            }
                        } //если изменений нет
                        else {
                            $nameEquipments[] = $equipment->getName();
                            $equipments[$auditorium['auditorium']->getNumber()][$equipment->getCategory()][] = $equipment;
                        }

                    }

                }
            }
        }
        $html = $this->renderView('pdf/reportPDF.html.twig', [
            'direction' => $direction,
            'curriculum' => $curriculum,
            'disciplines' => $disciplines,
            'auditoriums' => $auditoriums,
            'equipments' => $equipments,
        ]);

// Load HTML to Dompdf
        $dompdf->loadHtml($html,'UTF-8');
// (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'landscape');
// Render the HTML as PDF
        $dompdf->render();
// Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
        return $this->render('pdf/reportPDF.html.twig', [
            'direction' => $direction,
            'curriculum' => $curriculum,
            'disciplines' => $disciplines,
            'auditoriums' => $auditoriums,
            'equipments' => $equipments,
            'checking' => $checking,
        ]);
    }

}