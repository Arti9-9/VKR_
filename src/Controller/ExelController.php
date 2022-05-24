<?php

namespace App\Controller;

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
    public function index(Request  $request): Response
    {
        $file = $request->files->get('file'); // get the file from the sent request
        $fileFolder =  'app/public/uploads/';  //choose the folder in which the uploaded file will be stored
    dd($file);
        $filePathName = md5(uniqid('', true)) . $file->getClientOriginalName();
        //apply md5 function to generate an unique identifier for the file and concat it with the file extension
        try {
            $file->move($fileFolder, $filePathName);
        } catch (FileException $e) {
            dd($e);
        }
        $spreadsheet = IOFactory::load($fileFolder . $filePathName); // Here we are able to read from the excel file
        $spreadsheet->getActiveSheet()->removeColumn('A');
        $spreadsheet->getActiveSheet()->removeColumn('A');
        for($i =1; $i<1022; $i++)
        {
            $spreadsheet->getActiveSheet()->removeColumn('B');
        }
        for($i =1; $i<10; $i++)
        {
            $spreadsheet->getActiveSheet()->removeRow(1); // I added this to be able to remove the first  10 file line
        }
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true); // here, the read data is turned into an array
        dd($sheetData);
        return $this->render('exel/index.html.twig', [
            'controller_name' => 'ExelController',
        ]);
    }
}
