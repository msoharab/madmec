<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//$this->previous_week = strtotime("-1 week +1 day");
//
//$this->start_week = strtotime("last sunday midnight", $this->previous_week);
//$this->end_week = strtotime("next saturday", $this->start_week);
//$this->start_week = date("Y-m-d h:i:s", $this->start_week);
//$this->end_week = date("Y-m-d h:i:s", $this->end_week);
//echo $this->start_week . ' = last week start date <hr />';
//echo $this->end_week . ' = last week end date <hr />';


date_default_timezone_set('Asia/Kolkata');
$previous_week = strtotime("-3 week +1 day");
$start_week = strtotime("last sunday midnight", $previous_week);
$end_week = strtotime("next saturday", $start_week);
$start_week1 = strtotime(date("Y-m-d h:i:s", $start_week));
$end_week1 = strtotime(date("Y-m-d h:i:s", $end_week));
$start_week = date("'l jS \of F Y h:i:s A'", $start_week);
$end_week = date("'l jS \of F Y h:i:s A'", $end_week);
echo $start_week . ' = last week start date <hr />';
echo $end_week . ' = last week end date <hr />';
echo $start_week1 . ' = last week start seconds <hr />';
echo $end_week1 . ' = last week end seconds <hr />';
