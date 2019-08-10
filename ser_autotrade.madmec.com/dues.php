<?php

class dues {

    protected $parameters = array();

    function __construct($parameters = false) {
        $this->parameters = $parameters;
    }

    public function fetchDues() {
        $jsopndata = array(
            "status" => "failure"
        );
        $query = "SELECT *
                FROM user_profile up
                  WHERE up.ot_amt > 0";
        $result = executeQuery($query);
        if (mysql_num_rows($result)) {
            $fetchdata = array();
            while ($row = mysql_fetch_assoc($result)) {
                $fetchdata[] = $row;
            }

            $objPHPExcel = new PHPExcel();
            $headers = array('font' => array('bold' => true, 'color' => array('rgb' => '000000'), 'size' => 10, 'name' => 'Arial'), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER),);
            $sheet = $objPHPExcel->getActiveSheet();
            $rows = 1;
            $objPHPExcel->getProperties()->setCreator("MADMEC")
                    ->setLastModifiedBy("MADMEC")
                    ->setTitle("Due List")
                    ->setSubject("Due List")
                    ->setDescription("Due List")
                    ->setKeywords("MadMec")
                    ->setCategory("Due List");
            /* Set active sheet */
            $objPHPExcel->setActiveSheetIndex(0);
            /* Set page size */
            $objPHPExcel->getActiveSheet()
                    ->getPageSetup()
                    ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
            $objPHPExcel->getActiveSheet()
                    ->getPageSetup()
                    ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
            /* Add a header */
            $objPHPExcel->getActiveSheet()
                    ->getHeaderFooter()
                    ->setOddHeader('&C&H Due List');
            /* Add a footer */
            $objPHPExcel->getActiveSheet()
                    ->getHeaderFooter()
                    ->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');
            $objPHPExcel->getActiveSheet()->setShowGridlines(true);
            /*
              Set printing area
              $objPHPExcel->getActiveSheet()->getPageSetup()->setPrintArea('A1:H1');
             */
            /*
              Set printing break
              $objPHPExcel->getActiveSheet()->setBreak( 'A47' , PHPExcel_Worksheet::BREAK_ROW );
             */
            /* Add titles  of the columns */
            $objPHPExcel->getActiveSheet()
                    ->setCellValueByColumnAndRow(0, 1, 'No')
                    ->setCellValueByColumnAndRow(1, 1, 'Customer Name')
                    ->setCellValueByColumnAndRow(2, 1, 'Email Id')
                    ->setCellValueByColumnAndRow(3, 1, 'Cell Number')
                    ->setCellValueByColumnAndRow(4, 1, 'Telephone')
                    ->setCellValueByColumnAndRow(5, 1, 'Due Amount');

            /* header bold */
            $sheet->getStyle($rows)->applyFromArray($headers);
            /* Setting a column’s width */
            foreach (range('A', 'O') as $columnID) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                        ->setAutoSize(true);
            }
            /* 4.6.12.	Center a page horizontally/vertically */
            $objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
            /* 4.6.33.	Group/outline a row */
            $objPHPExcel->getActiveSheet()->getRowDimension('1')->setOutlineLevel(2);
            for ($i = 1; $i <= sizeof($fetchdata); $i++) {
                $objPHPExcel->getActiveSheet()
                        ->setCellValueByColumnAndRow(0, ($i + 1), $i)
                        ->setCellValueByColumnAndRow(1, ($i + 1), $fetchdata[$i]['user_name'])
                        ->setCellValueByColumnAndRow(2, ($i + 1), $fetchdata[$i]['email'])
                        ->setCellValueByColumnAndRow(3, ($i + 1), $fetchdata[$i]['cell_number'])
                        ->setCellValueByColumnAndRow(4, ($i + 1), $fetchdata[$i]['telephone'])
                        ->setCellValueByColumnAndRow(5, ($i + 1), $fetchdata[$i]['ot_amt']);
            }
            /*
              Export it to browser
              header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
              header('Content-Disposition: attachment;filename="myfile.xlsx"');
              header('Cache-Control: max-age=0');
              $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
              $objWriter->save('php://output');
             */
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            // $objWriter->save(str_replace('.php', '.xlsx','./Gym'. __FILE__));
            $callStartTime = microtime(true);
            $filename = "DueList" . '_' . $objPHPExcel->getProperties()->getTitle() . '_' . date('j-M-Y') . '_' . $callStartTime . '.xlsx';
            $objWriter->save(DOC_ROOT . DOWNLOADS . $filename);
            unset($objWriter);
            unset($objPHPExcel);
            $filenamee = '<center><h3>Click on below link to download</h3><h4><a target="_blank" href="' . URL . DOWNLOADS . $filename . '">' . $filename . '</a></h4></center>';
            $jsondata = array(
                "status" => "success",
                "filename" => $filenamee
            );
        }
        return $jsondata;
    }

}
