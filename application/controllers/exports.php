<?php 

class Exports {

    public $styleArray;
    public $styleArray2;
    public $leftAlign;
    public $rightAlign;
    public $danger;

    private $objPHPExcel;

    public function __construct() {
        
        /** Initialize the variables */
        $this->defaultVariables();

    }

    // create a geral function
    public function excelHeader($objPHPExcel, stdClass $header) {

        global $appName, $session;

        $this->objPHPExcel = $objPHPExcel;

        $this->objPHPExcel->getProperties()->setCreator("{$header->account_name} - {$appName}")
            ->setLastModifiedBy($session->userId)
            ->setTitle($header->title)
            ->setSubject($header->subject ?? null)
            ->setDescription($header->description ?? null)
            ->setKeywords($header->keywords ?? null)
            ->setCategory($header->account_name);

        // Add some data
        $this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('C2:H2');
        $this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2', $appName)->getStyle('C2')->applyFromArray($this->styleArray2);
        $this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('C3:H3');
        $this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', $header->account_name)->getStyle('C3')->applyFromArray($this->styleArray2);
        $this->objPHPExcel->setActiveSheetIndex(0)->mergeCells('C4:H4');
        $this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('C4', $header->title)->getStyle('C4')->applyFromArray($this->styleArray2);

        // GET THE ALIGNMENT OF THE MERGED CELLS
        $this->sheet = $objPHPExcel->getActiveSheet();
        $this->sheet->getStyle("C2:H2")->applyFromArray($this->leftAlign);
        $this->sheet->getStyle("C3:H3")->applyFromArray($this->leftAlign);
        $this->sheet->getStyle("C4:H4")->applyFromArray($this->leftAlign);
        $this->sheet->getStyle("C5:H5")->applyFromArray($this->leftAlign);
        $this->sheet->getStyle("A1")->applyFromArray($this->rightAlign);

        return $this;

    }

    public function defaultVariables() {
        // font styles to be applied
        $this->styleArray = array(
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => '000000'),
                'size'  => 13,
                'name'  => 'calibri',
            )
        );

        $this->styleArray2 = array(
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => 'FF8C00'),
                'size'  => 13,
                'name'  => 'calibri'
            )
        );

        $this->leftAlign = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            )
        );

        $this->rightAlign = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
            )
        );

        $this->danger = array(
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => 'FFFFFF')
            ), 'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'FF0000')
            )
        );

        return $this;
    }

}
?>