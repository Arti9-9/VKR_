<?php

namespace App\Controller;

use App\Entity\Curriculum;
use App\Entity\Discipline;
use App\Repository\CurriculumRepository;
use App\Repository\DirectionRepository;
use App\Repository\DisciplineRepository;
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
     * @Route("/handleUploadShedule", name="handleUploadShedule")
     */
    public function handleUploadSchedule(Request $request, DisciplineRepository $disciplineRepository, CurriculumRepository $curriculumRepository, DirectionRepository $directionRepository)
    {
        $dbconn = pg_connect('dbname=mto');
        // Это безопасно с тех пор как $_POST преобразуется автоматически
        $res = pg_insert($dbconn, 'post_log', );
        if ($res) {
            echo "Данные из POST успешно внесены в журнал\n";
        } else {
            echo "Пользователь прислал неверные данные\n";
        }
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
        $fileFolder = __DIR__ . '/../../public/uploads/';

        $filePathName = md5(uniqid('', true)) . $file->getClientOriginalName();
        try {
            $file->move($fileFolder, $filePathName);
        } catch (FileException $e) {
            dd($e);
        }
        $spreadsheet = IOFactory::load($fileFolder . $filePathName);
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
        foreach ($disciplins as $disciplineName){
            if($disciplineRepository->findByName($disciplineName)){
                $discipline = $disciplineRepository->findByName($disciplineName)[0];
                $discipline->addCurriculum($curriculum);
                $disciplineRepository->add($discipline);
            }
            else{
                $discipline = new Discipline();
                $discipline->addCurriculum($curriculum);
                $discipline->setName($disciplineName);
                $disciplineRepository->add($discipline);
            }
        }
        return $this->render('curriculum/index.html.twig',[
            'curricula' => $curriculumRepository->findAll(),
        ]);
    }
}
