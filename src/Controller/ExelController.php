<?php

namespace App\Controller;

use App\Entity\Auditorium;
use App\Entity\Curriculum;
use App\Entity\Discipline;
use App\Entity\Schedule;
use App\Repository\AuditoriumRepository;
use App\Repository\CurriculumRepository;
use App\Repository\DirectionRepository;
use App\Repository\DisciplineRepository;
use App\Repository\ScheduleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExelController extends AbstractController
{
    /**
     * @Route("/exel", name="app_exel")
     * @param Request $request
     * @throws Exception
     */


    /**
     * @Route("/testFile", name="testFile")
     */
    public function testFile()
    {
        return $this->render('exel/index.html.twig');
    }

    /**
     * @Route("/handleUploadAuditorium", name="handle_upload_auditorium")
     */
    public function handleUploadAuditorium(Request $request, DisciplineRepository $disciplineRepository, AuditoriumRepository $auditoriumRepository)
    {
        $file = $request->files->get('file');
        $spreadsheet = IOFactory::load($file);
        $spreadsheet->getActiveSheet()->removeRow(1);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true); // here, the read data is turned into an array

        foreach ($sheetData as $row) {
            $auditorium = new Auditorium();
            $auditorium->setNumber($row['A']);
            $auditorium->setCountSeats($row['B']);
            $auditorium->setSquare($row['C']);
            //проверка на то существует ли уже эта аудитория
            if ($auditoriumRepository->findByNumber($row['A'])) {
                $auditoriumRepository->remove($auditoriumRepository->findByNumber($row['A']));
            }
            $auditoriumRepository->add($auditorium);
        }

        return $this->render('auditorium/index.html.twig', [
            'auditoria' => $auditoriumRepository->findAll(),
        ]);
    }

    /**
     * @Route("/handleUploadSchedule", name="handle_upload_schedule")
     */
    public function handleUploadSchedule(Request $request, DisciplineRepository $disciplineRepository, AuditoriumRepository $auditoriumRepository, ScheduleRepository $scheduleRepository)
    {
        $file = $request->files->get('file');
        $spreadsheet = IOFactory::load($file);
        $spreadsheet->getActiveSheet()->removeRow(1);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true); // here, the read data is turned into an array
        foreach ($sheetData as $row) {
            //временно
            if ($row[] = null){
                break;
            }
            $schedule = new Schedule();
            $discipline = $disciplineRepository->findByName($row['A']);
            $auditorium = $auditoriumRepository->findByNumber($row['B']);
            //если в БД есть такая аудитория и дисциплина
            if ($auditorium and $discipline) {
                //проверка нет ли уже такой записи в БД
                if (!$scheduleRepository->findByAuditoriumDisciplineGroup($auditorium[0], $discipline[0], $row['C'])) {
                    $schedule->setAuditorium($auditorium[0]);
                    $schedule->setDiscipline($discipline[0]);
                    $schedule->setGroupName($row['C']);
                    $scheduleRepository->add($schedule);
                }

            }
        }

        return $this->render('schedule/index.html.twig', [
            'schedule' => $scheduleRepository->findOrderBy(),
        ]);
    }

    /**
     * @Route("/handleUpload", name="handleUpload")
     */
    public function handleUpload(Request $request, DisciplineRepository $disciplineRepository, CurriculumRepository $curriculumRepository, DirectionRepository $directionRepository)
    {
        $curriculum = new Curriculum();
        $curriculum->setName($request->request->get('name'));
        $curriculum->setDirection($directionRepository->findById($request->request->get('id'))[0]);
        $curriculum->setDateCreate(new \DateTime());

        $file = $request->files->get('file');
        //добавить если понадобится хранить файлы
        /*$fileFolder = __DIR__ . '/../../public/uploads/';

        $filePathName = md5(uniqid('', true)) . $file->getClientOriginalName();
        try {
            $file->move($fileFolder, $filePathName);
        } catch (FileException $e) {
            dd($e);
        }*/
        $spreadsheet = IOFactory::load($file);
        for ($i = 0; $i < 9; $i++) {
            $spreadsheet->getActiveSheet()->removeRow(1);
        }
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true); // here, the read data is turned into an array
        $disciplins = [];
        foreach ($sheetData as $Row) {

            if ($Row['C'] != null) {
                $disciplins[] = $Row['C'];
            }
        }
        $arrayToDelete = [
            'Элективные дисциплины',
            'Блок 2 Практика',
            '_Учебная практика_',
            '_Производственная практика_',
            'Блок 3 Государственная итоговая аттестация',
            'Элективные дисциплины по физической культуре и спорту (не включаются в объем программы)',
            'Факультативные дисциплины (не включаются в объем программы)',
            'Объем программы',
            'Часть, формируемая участниками образовательных отношений',
            'Обязательные дисциплины'
        ];
        $disciplins = array_unique($disciplins);
        foreach ($arrayToDelete as $del) {
            $key = array_search($del, $disciplins);
            unset($disciplins[$key]);
        }

        $curriculumRepository->add($curriculum);
        foreach ($disciplins as $disciplineName) {
            if ($disciplineRepository->findByName($disciplineName)) {
                $discipline = $disciplineRepository->findByName($disciplineName)[0];
                $discipline->addCurriculum($curriculum);
                $disciplineRepository->add($discipline);
            } else {
                $discipline = new Discipline();
                $discipline->addCurriculum($curriculum);
                $discipline->setName($disciplineName);
                $disciplineRepository->add($discipline);
            }
        }
        return $this->render('curriculum/index.html.twig', [
            'curricula' => $curriculumRepository->findAll(),
        ]);
    }
}
