<?php
/**
 * Created by PhpStorm.
 * User: Yilsen
 * Date: 03/07/2018
 * Time: 23:12
 */

namespace AppBundle\Services;


use Liuggio\ExcelBundle\Factory;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class VolunteersLoadService
{
    private $volunteerManager;
    private $phpExcel;

    public function __construct(VolunteerManager $volunteerManager, Factory $phpExcel)
    {
        $this->volunteerManager = $volunteerManager;
        $this->phpExcel = $phpExcel;
    }

    public function volunteersLoadFromExcel(UploadedFile $fileData)
    {
        try {
            $phpExcelObject = $this->phpExcel->createPHPExcelObject($fileData->getPath());

            while ($phpExcelObject->getSheet()->getRowIterator()->valid()) {
                $row = $phpExcelObject->getSheet()->getRowIterator()->current();
                foreach ($row->getCellIterator() as $value) {
                    var_dump ($value);
                    /*
                     * $nombre = $value
                     * $apellidos = $value
                     */
                }
//        $this->volunteerManager->createVolunteer($nombre, $apellidos, $dni, $direccion);
                $phpExcelObject->getSheet()->getRowIterator()->next();
            }
        } catch (\Exception $e) {
            throw $e;
        }

    }
}