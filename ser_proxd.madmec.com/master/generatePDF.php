<?php
class generatePDF {
    protected $incommingamount=array();
    public function generateMO($moid){
    $modata=array();
    $query='SELECT 
            mo.ven_id as venid,
            up.user_name AS username,
            GROUP_CONCAT(mods.quantity) AS qty,
            GROUP_CONCAT(mods.doo) AS doo,
            GROUP_CONCAT(it.type) AS itemname
            FROM mo_descb `mods`
            LEFT JOIN material_order mo
            ON mo.order_id=mods.order_id
            LEFT JOIN item_type it
            ON it.id=mods.item_type_id
            LEFT JOIN user_profile up
            ON up.id=mo.ven_id
            WHERE mo.order_id='.  mysql_real_escape_string($moid).'
            GROUP BY mods.order_id';
    $result=  executeQuery($query);
    if(mysql_num_rows($result)>0)
    {
        $row=  mysql_fetch_assoc($result);
    }
$pdf=new FPDF();
$pdf->AddPage();
//$pdf->Image('../images/Border4.png', 5, 5, 200, 290);
//$pdf->Image('../images/logo1.jpg', 15, 10, 40, 20);
$pdf->Image('assets/img/logoxlsx.jpg', 15, 10, 100, 20);
$pdf->Cell(100,3,"");
$pdf->Ln();
$pdf->Ln();$pdf->Ln();$pdf->Ln();$pdf->Ln();$pdf->Ln();$pdf->Ln();
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(100,5,"Material Order Details");
$pdf->Ln();
$pdf->Cell(120,5,"DATE ".date('Y-m-d'),'','','R');
$pdf->Ln();
$pdf->SetFont('Arial','B',7);
$pdf->Cell(100,5,"TO,");
$pdf->Ln();
$pdf->Cell(100,5,$row['username']);
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial','B',6);
$pdf->Cell(10,5,'#',1,'');
$pdf->Cell(50,5,'Item Name',1,'');
$pdf->Cell(30,5,'Quantity',1,'');
$pdf->Cell(30,5,'Date of Order',1,'');
$pdf->Ln();
$pdf->SetFont('Arial','',6);
$quantity=  explode(',', $row['qty']);
$doo=  explode(',', $row['doo']);
$itemname=  explode(',', $row['itemname']);
$j=1;
for($i=0;$i<sizeof($quantity);$i++)
{
 $pdf->Cell(10,4,$j++,1,'');  
 $pdf->Cell(50,4,$itemname[$i],1,'');
 $pdf->Cell(30,4,$quantity[$i],1,'');
 $pdf->Cell(30,4,$doo[$i],1,'');
 $pdf->Ln();
}
 					$parameters = array(
						"uid" => $row['venid']
					);
					$dirparameters = array(
						"directory"		=>	NULL,
						"filename"		=>	'MaterialOrder'.date('j-M-Y').'-'.md5(microtime(true)).'.pdf',
						"filedirectory"	=>	NULL,
						"urlpath"		=>	NULL,
						"url"			=>	NULL
					);
					returnDirectoryDoc($dirparameters,$parameters);
 
                    $pdf->Output($dirparameters["filedirectory"], 'f');
					/* documents */
					$query = 'INSERT INTO  `documents` (`id`,
							`file_name`,
							`type_id`,
							`doc_loc`,
							`mime_type`,
							`doc_type`,
							`dou`,
							`status_id`)  VALUES(
						NULL,
						\''.$dirparameters["filename"].'\',
						\''.mysql_real_escape_string($moid).'\',
						\''.$dirparameters["url"].'\',
						\'application/pdf\',
						\'material_order\',
						default,
						default);';
					executeQuery($query);
                                        if(file_exists($dirparameters["filedirectory"])){
                                            return URL.$dirparameters["url"];
                                        }else{
                                        return 'javascript:void(0);';
   }
}
public function generateIncommingAmontBill($param=false) {
    $this->incommingamount=$param;
    $query='SELECT `user_name` from `user_profile` WHERE `id`='.mysql_real_escape_string($this->incommingamount['retailer']);
    $query1='SELECT `mop` from `mode_of_payment` WHERE `id`='.  mysql_real_escape_string($this->incommingamount['mop']);
    $result=  executeQuery($query);
    $result1=  executeQuery($query1);
    $row=  mysql_fetch_assoc($result);
    $row1=  mysql_fetch_assoc($result1);
    $query='INSERT INTO `receipt`(`id`,`user_pk`,`received_cash`,`location`) VALUES(NULL,'
                                        . '"'.$this->incommingamount['retailer'].'","'.$this->incommingamount['amount'].'","")';        
    executeQuery($query);
    $out = mysql_insert_id();

    $pdf=new FPDF();
$pdf->AddPage();
//$pdf->Image('../images/Border4.png', 5, 5, 200, 290);
//$pdf->Image('../images/logo1.jpg', 15, 10, 40, 20);
//$pdf->Image('assets/img/logoxlsx.jpg', 15, 10, 100, 20);
$pdf->Image($_SESSION['BillingDetails']['BILL_LOGO'], 15, 10, 100, 20);
$pdf->Cell(100,3,"");
$pdf->Ln();
$pdf->Ln();$pdf->Ln();$pdf->Ln();$pdf->Ln();$pdf->Ln();$pdf->Ln();
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(100,5,"Cash Reciept",'','','C');
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial','B',7);
$pdf->Cell(40,5,"Receipt no : ".$out,'','','L');
$pdf->Cell(70,5,"DATE : ".date('Y-m-d'),'','','R');
$pdf->Ln();
$pdf->SetFont('Arial','B',8);
$pdf->Cell(30,5,"Recieved From,");
$pdf->Cell(90,5,  trim($row['user_name']));
$pdf->Ln();
$pdf->Cell(20,5,'Amount');
$pdf->Cell(40,5,'Rs. '.$this->incommingamount['amount'].' /-');
$pdf->Cell(30,5,'Mode Of Payment');
$pdf->Cell(30,5,trim($row1['mop']));
$pdf->Ln();
$pdf->Cell(20,5,'Remark');
$pdf->Cell(100,5,  $this->incommingamount['rmk']);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(90,5,"Authorised Signature",'','','R');
$parameters = array(
						"uid" => $this->incommingamount['retailer']
					);
					$dirparameters = array(
						"directory"		=>	NULL,
						"filename"		=>	'IncommingCost'.date('j-M-Y').'-'.md5(microtime(true)).'.pdf',
						"filedirectory"	=>	NULL,
						"urlpath"		=>	NULL,
						"url"			=>	NULL
					);
					returnDirectoryDoc($dirparameters,$parameters);
 
                    $pdf->Output($dirparameters["filedirectory"], 'f');
					/* documents */
					$query = 'INSERT INTO  `documents` (`id`,
							`file_name`,
							`type_id`,
							`doc_loc`,
							`mime_type`,
							`doc_type`,
							`dou`,
							`status_id`)  VALUES(
						NULL,
						\''.$dirparameters["filename"].'\',
						\''.mysql_real_escape_string($this->incommingamount['retailer']).'\',
						\''.$dirparameters["url"].'\',
						\'application/pdf\',
						\'IncommingAmount\',
						default,
						default);';
					executeQuery($query);
                                        if(file_exists($dirparameters["filedirectory"])){
                                            return URL.$dirparameters["url"];
                                        }else{
                                        return 'javascript:void(0);';
   }
}
public function generateProjectIncommingAmontBill($param=false) {
    $this->incommingamount=$param;
    $query='SELECT `user_name` from `user_profile` WHERE `id`='.mysql_real_escape_string($this->incommingamount['clientid']);
    $query1='SELECT `name` from `project` WHERE `id`='.  mysql_real_escape_string($this->incommingamount['projid']);
    $result=  executeQuery($query);
    $result1=  executeQuery($query1);
    $row=  mysql_fetch_assoc($result);
    $row1=  mysql_fetch_assoc($result1);
    $query='INSERT INTO `receipt`(`id`,`user_pk`,`received_cash`,`location`) VALUES(NULL,'
                                        . '"'.$this->incommingamount['clientid'].'","'.$this->incommingamount['amount'].'","")';        
    executeQuery($query);
    $out = mysql_insert_id();
$pdf=new FPDF();
$pdf->AddPage();
//$pdf->Image('../images/Border4.png', 5, 5, 200, 290);
//$pdf->Image('../images/logo1.jpg', 15, 10, 40, 20);
$pdf->Image($_SESSION['BillingDetails']['BILL_LOGO'], 15, 10, 100, 20);
$pdf->Cell(100,3,"");
$pdf->Ln();
$pdf->Ln();$pdf->Ln();$pdf->Ln();$pdf->Ln();$pdf->Ln();$pdf->Ln();
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(100,5,"Cash Reciept",'','','C');
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial','B',7);
$pdf->Cell(40,5,"Receipt no : ".$out,'','','L');
$pdf->Cell(70,5,"DATE : ".date('Y-m-d'),'','','R');
$pdf->Ln();
$pdf->SetFont('Arial','B',8);
$pdf->Cell(25,5,"Recieved From ");
$pdf->Cell(90,5,  trim($row['user_name']));
$pdf->Ln();
$pdf->Cell(25,5,'Project Name');
$pdf->Cell(90,5,trim($row1['name']),'','','L');
$pdf->Ln();
$pdf->SetFont('Arial','B',11);
$pdf->Cell(60,5,'Amount Details');
$pdf->Ln();
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40,5,'Total Amount','1','LR');
$pdf->Cell(40,5,$this->incommingamount['totalamountt'],'1','TLR','R');
$pdf->Ln();
$pdf->Cell(40,5,'Current Due','1','LR');
$pdf->Cell(40,5,$this->incommingamount['cdue'],'1','LR','R');
$pdf->Ln();
$pdf->Cell(40,5,'AmountPaid','1','LR');
$pdf->Cell(40,5,$this->incommingamount['amount'],'1','LR','R');
$pdf->Ln();
$pdf->Cell(40,5,'Balance','1','LR');
$pdf->Cell(40,5,$this->incommingamount['dueamount'],'1','DLR','R');
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(20,5,'Remark');
$pdf->Cell(100,5,  $this->incommingamount['remark']);
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(20,5,'Amount');
$pdf->Cell(30,5,'Rs. '.$this->incommingamount['amount'].' /-','1','','C');
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(90,5,"Authorised Signature",'','','R');
$parameters = array(
						"uid" => $this->incommingamount['clientid']
					);
					$dirparameters = array(
						"directory"		=>	NULL,
						"filename"		=>	'ProjIncommingCost'.date('j-M-Y').'-'.md5(microtime(true)).'.pdf',
						"filedirectory"	=>	NULL,
						"urlpath"		=>	NULL,
						"url"			=>	NULL
					);
					returnDirectoryDoc($dirparameters,$parameters);
 
                    $pdf->Output($dirparameters["filedirectory"], 'f');
					/* documents */
					$query = 'INSERT INTO  `documents` (`id`,
							`file_name`,
							`type_id`,
							`doc_loc`,
							`mime_type`,
							`doc_type`,
							`dou`,
							`status_id`)  VALUES(
						NULL,
						\''.$dirparameters["filename"].'\',
						\''.mysql_real_escape_string($this->incommingamount['clientid']).'\',
						\''.$dirparameters["url"].'\',
						\'application/pdf\',
						\'incoming_proj\',
						default,
						default);';
					executeQuery($query);
                                
				$invno = sprintf("%010s",mysql_result(executeQuery('SELECT COUNT(`id`) FROM `receipt`;'),0)+1);
                                        if(file_exists($dirparameters["filedirectory"])){
                                            return URL.$dirparameters["url"];
                                        }else{
                                        return 'javascript:void(0);';
   }
}
}
