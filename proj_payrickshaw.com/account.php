<?php

class account {

    protected $parameters = array();

    function __construct($para = false) {
        $this->parameters = $para;
    }

    public function addpayment() {
        $flag = false;
        $query = 'INSERT INTO `payment_history`(`id`,`driverid`,`amount`,`date`,`remark`,`status_id`)VALUES(null,'
                . '"' . mysql_real_escape_string($this->parameters['driverid']) . '",'
                . '"' . mysql_real_escape_string($this->parameters['amount']) . '",now(),'
                . '"' . mysql_real_escape_string($this->parameters['remark']) . '",4'
                . ')';
        $result = executeQuery($query);
        if ($result) {
            $query = 'UPDATE `payment_due` SET `remainingamount`=`remainingamount`-"' . mysql_real_escape_string($this->parameters['amount']) . '" ,'
                    . ' `lastpaid`=now(),`amountpaid`="' . mysql_real_escape_string($this->parameters['amount']) . '"'
                    . ' WHERE `driver_id`="' . mysql_real_escape_string($this->parameters['driverid']) . '"';
            $res = executeQuery($query);
            if ($res) {
                $flag = true;
                return $flag;
            } else {
                $flag = false;
                return $flag;
            }
        }
    }

    public function fetchPaymentHistory($driverid) {
        $payhisdata = array();
        $data = '';
        $query = 'SELECT * FROM `payment_history` WHERE `driverid`="' . mysql_real_escape_string($driverid) . '"  '
                . 'ORDER BY `date`  DESC ';
        $result = executeQuery($query);
        if (mysql_num_rows($result)) {
            while ($row = mysql_fetch_assoc($result)) {
                $payhisdata[] = $row;
                $sno = 1;
            }
            for ($i = 0; $i < sizeof($payhisdata); $i++) {
                $data .='<tr><td>' . $sno++ . '</td><td>' . $payhisdata[$i]['amount'] . '</td><td>' . $payhisdata[$i]['date'] . '</td><td>' . $payhisdata[$i]['remark'] . '</td>';
            }
            $jsondata = array(
                "status" => "success",
                "data" => $data
            );
            return $jsondata;
        } else {
            $jsondata = array(
                "status" => "failure",
            );
            return $jsondata;
        }
    }

}
