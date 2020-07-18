<?php
/** Initializing */
$bug = false;
$appName = config_item('site_name');

/** Include PHPExcel */
load_file( array( 'PHPExcel' => 'libraries/spreadsheet/Classes' ) );

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

/** create a new object */
$clientData = $bookingClass->clientData($session->clientId);
$exportsObj = load_class('exports', 'controllers');

/** Get the event guid */
if(confirm_url_id(1, "event")) {
    
    /** get the event guid */
    $event_guid = (isset($_GET["event_guid"])) ? xss_clean($_GET["event_guid"]) : null;

    /** bug found */
    if(empty($event_guid)) {
        $bug = true;
    }

    // create parameters
    $parameters = (object) [
        "event_guid" => $event_guid,
        "clientId" => $session->clientId,
        "remote" => false,
        "tree" => "list,detail"
    ];

    /** Create a new object of the classs */
    $eventObj = load_class('insight', 'controllers');
    
    // check if the event already exist using the name, date and start time
    $eventData = $eventObj->generateInsight($parameters);

    // count the number of rows found
    if(empty($eventData)) {
        $bug = true;
        
    }

    /** if not bug */
    if(!$bug) {

        // get the first key of the array data
        $eventData = $eventData["data"][0];
        
        // Set document properties
        $headTag = (Object)[
            "title" => $eventData["detail"]->event_title,
            "subject" => $eventData["detail"]->event_title,
            "description" => $eventData["detail"]->description,
            "account_name" => $clientData->name
        ];
        $exportsObj->excelHeader($objPHPExcel, $headTag);

        // labels for the actual data
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A6', 'ID')->getStyle('A6')->applyFromArray($exportsObj->styleArray);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B6', 'HALL NAME')->getStyle('B6')->applyFromArray($exportsObj->styleArray);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C6', 'FULLNAME')->getStyle('C6')->applyFromArray($exportsObj->styleArray);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D6', 'CONTACT')->getStyle('D6')->applyFromArray($exportsObj->styleArray);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E6', 'ADDRESS')->getStyle('E6')->applyFromArray($exportsObj->styleArray);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F6', 'SEAT NUMBER')->getStyle('F6')->applyFromArray($exportsObj->styleArray);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G6', 'DATE BOOKED')->getStyle('G6')->applyFromArray($exportsObj->styleArray);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H6', 'STATUS')->getStyle('H6')->applyFromArray($exportsObj->styleArray);
        
        // auto fit all the columns
        foreach(range('A','H') as $columnID) {
            $objPHPExcel->getActiveSheet(0)->getColumnDimension($columnID)->setAutoSize(true);
        }
        
        // get the results
        $i = 0;

        // Initialise the Excel row number
        $rowCount = 8;

        // using while loop to fetch results
        foreach($eventData["booking_list"] as $result) {
            $i++;
            
            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $i); 
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $result->hall_name);
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $result->fullname);
            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $result->contact);
            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $result->address);
            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $result->seat_name);
            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $result->created_on);
            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $result->status ? "Confirmed" : "Booked");
            
            // Increment the Excel row counter
            $rowCount++; 
        }
        $file_name = "assets/event_booking__".date("Y_m_d").".xlsx";


        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle($headTag->title);

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$file_name.'"');
        header('Cache-Control: max-age=0');

        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

}
?>