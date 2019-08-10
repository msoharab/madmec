<?php
//session_start();
class download {
    protected $data=array();
    public function downloadPatientHistory($data) {
        $this->data=$data;
        $pdf=new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',12);
        $pdf->SetTextColor(0,0,0);
        $pdf->Cell(120,5,"Patient History Report",0, 0,'C');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetFont('Arial','B',8);
        $pdf->SetTextColor(0,0,0);
        $pdf->Cell(20,4,"Patient Name",0, 0,'C');
        $pdf->Cell(30,4,  $this->data['name'],0, 0,'C');
        $pdf->Cell(20,4,'',0, 0,'C');
        $pdf->Cell(20,4,"Gender",0, 0,'');
        $pdf->Cell(30,4,$this->data['sex'],0, 0,'C');
        $pdf->Ln();
        $pdf->Cell(20,4,"Blood Group",0, 0,'');
        $pdf->Cell(30,4,$this->data['bgroup'],0, 0,'C');
        $pdf->Cell(20,4,'',0, 0,'C');
        $pdf->Cell(20,4,"Age",0, 0,'');
        $pdf->Cell(30,4,$this->data['age'],0, 0,'C');
        $pdf->Ln();
        $pdf->Cell(20,4,"Email Id",0, 0,'');
        $pdf->Cell(30,4,$this->data['email_id'],0, 0,'C');
        $pdf->Cell(20,4,'',0, 0,'C');
        $pdf->Cell(20,4,"Mobile Number",0, 0,'C');
        $pdf->Cell(30,4,$this->data['cell_number'],0, 0,'C');
        $pdf->Ln();$pdf->Ln();
        $pdf->Cell(30,4,"Assesments",0, 0,'');
        $pdf->Ln();
        $pdf->SetFont('Arial','B',6);
        $sno=1;
        $dates=  explode(',~~9743~~', $this->data['passesment_descb_date']); 
        $currassesment=  explode(',~~9743~~', $this->data['passesment_descb_curass']);
        $remarks=  explode(',~~9743~~', $this->data['passesment_descb_rem']);
        /* Prescription */
        $tabname =  explode(',~~9743~~', $this->data['prescription_descb_tnam']);
        $mrn =  explode(',~~9743~~', $this->data['prescription_descb_mrn']);
        $afn  =  explode(',~~9743~~', $this->data['prescription_descb_afn']);
        $evn =  explode(',~~9743~~', $this->data['prescription_descb_evn']);
        $frq =  explode(',~~9743~~', $this->data['prescription_descb_frq']);
        $dos =  explode(',~~9743~~', $this->data['prescription_descb_dos']);
        
        for($i=0;$i<sizeof($dates)-1;$i++)
        {
          $pdf->Ln();
          $pdf->Cell(100,4,$sno." . DATE : ".$dates[$i],0, 0,'C');
          $pdf->Ln();  
          $pdf->Cell(20,4,"Assesment : ",0, 0,'');
          $pdf->Cell(100,4,ltrim($currassesment[$i],','),0, 0,'');
          $pdf->Ln();  
          $pdf->Cell(20,4,"Remark : ",0, 0,'');
          $pdf->Cell(100,4,ltrim($remarks[$i],','),0, 0,'');
          $pdf->Ln();  
          $tabletnames=  explode('~~9916282628~~', $tabname[$i]);
          $morning=  explode('~~9916282628~~', $mrn[$i]);
          $afternoon=  explode('~~9916282628~~', $afn[$i]);
          $evening=  explode('~~9916282628~~', $evn[$i]);
          $frequency=  explode('~~9916282628~~', $frq[$i]);
          $dosage=  explode('~~9916282628~~', $dos[$i]);
          $pdf->Cell(20,4,"Prescription : ",0, 0,'');
          for($j=0;$j<sizeof($tabletnames)-1;$j++)
          {
            $insidedata=ltrim($tabletnames[$j],",").' ( '.$_SESSION['status'][ltrim($morning[$j],",")].' Breakfast - '.$_SESSION['status'][ltrim($afternoon[$j],",")].' Lunch - '.$_SESSION['status'][ltrim($evening[$j],",")].' Dinner, '.$frequency[$j].' Days ,'.' Dosage - '.$dosage[$j].' )';
            $pdf->Cell(100,4,$insidedata,0, 0,'');
            $pdf->Ln();
            $pdf->Cell(20,4,"",0, 0);
          }
          $sno++;
        }
        $_SESSION['ext']='.pdf';
        $_SESSION['filename']='pateinthistoy'.$_SESSION['userdata']['id'].$_SESSION['ext'];
        $_SESSION['path']=PATIENTHISTORY.$_SESSION['filename'];
        // $filename=PATIENTHISTORY.'pateinthistoy'.$_SESSION['userdata']['id'].'.pdf';
        $pdf->Output($_SESSION['path'],'f');
        
    }
}
