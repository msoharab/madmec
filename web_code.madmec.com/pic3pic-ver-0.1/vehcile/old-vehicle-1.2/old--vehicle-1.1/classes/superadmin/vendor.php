<?php

class vendor {
   protected $parameters = array();

    function __construct($para = false) {
        $this->parameters = $para;
    }

    //Add Corporate Details
    public function addCorporate() {
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $query1 = 'INSERT INTO  `photo` (`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`cropimage` )  VALUES(
								NULL,NULL,NULL,NULL,NULL,NULL);';
        if (executeQuery($query1)) {
            $photo_pk = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
            $query = "INSERT INTO `user_profile`(`id`, `user_name`,`representative_name`,`vendor_id`,`representative_mobile`, `email_id`, `photo_id`,  `password`, `passwordreset`, `authenticatkey`, `user_type_id`, `createdby`, `status`, `date_of_join`,  `cell_number`, `postal_code`, `telephone`, `addressline`, `town`, `city`, `district`, `province`, `country`,  `zipcode`, `website`)
                VALUES (NULL,
                '" . mysql_real_escape_string($this->parameters['name']) . "',
                '" . mysql_real_escape_string($this->parameters['repname']) . "',
                '" . mysql_real_escape_string($this->parameters['corporatetype']) . "',
                '" . mysql_real_escape_string($this->parameters['repmobile']) . "',
                '" . mysql_real_escape_string($this->parameters['email']) . "',
                '" . mysql_real_escape_string($photo_pk) . "',
                '" . mysql_real_escape_string(generateRandomString()) . "',
                '" . mysql_real_escape_string(md5(generateRandomString())) . "',NULL,2,
                '" . mysql_real_escape_string($_SESSION["USER_LOGIN_DATA"]["USER_ID"]) . "',4,now(),
                '" . mysql_real_escape_string($this->parameters['mobile']) . "',
                '" . mysql_real_escape_string($this->parameters['stdcode']) . "',
                '" . mysql_real_escape_string($this->parameters['landline']) . "',
                '" . mysql_real_escape_string($this->parameters['addrs']) . "',
                '" . mysql_real_escape_string($this->parameters['st_loc']) . "',
                '" . mysql_real_escape_string($this->parameters['city_town']) . "',
                '" . mysql_real_escape_string($this->parameters['district']) . "',
                '" . mysql_real_escape_string($this->parameters['province']) . "',
                '" . mysql_real_escape_string($this->parameters['country']) . "',
                '" . mysql_real_escape_string($this->parameters['zipcode']) . "',
                '" . mysql_real_escape_string($this->parameters['website']) . "');";
            executeQuery($query);
            $user_pk = mysql_insert_id();
            $directory_customer = createdirectories(substr(md5(microtime()), 0, 6) . '_customer_' . $user_pk);
            executeQuery('UPDATE `user_profile` SET `directory` = \'' . $directory_customer . '\' WHERE `id`=\'' . mysql_real_escape_string($user_pk) . '\';');
            executeQuery("COMMIT;");
            return true;
        }
    }

    //Fetching Corporate Type
    public function fetchCorporateType() {
        $fetchdata1 = array();
        $data1 = '';
        $fetchdata2 = array();
        $data2 = '';
        $query1 = 'SELECT * FROM `vendor_type` WHERE `status`=4';
        $result1 = executeQuery($query1);
        if (mysql_num_rows($result1)) {

            while ($row1 = mysql_fetch_assoc($result1)) {
                $fetchdata1[] = $row1;
            }
            for ($i = 0; $i < sizeof($fetchdata1); $i++) {
                $data1 .='<option value="' . $fetchdata1[$i]['id'] . '">' . $fetchdata1[$i]['corporate_type'] . '</option>';
            }
        }
        $jsondata = array(
            "data1" => $data1,
        );
        return $jsondata;
    }

      //Fetch List of Corporate Donors
    public function fetchListOfCorporateDonor() {
        $fetchdata=array();
        $data='';
        $alldata=array();
        $donorids=array();
        $query='SELECT *,
                up.id AS donorid,
                cty.id AS corpid
                FROM `user_profile` up
                LEFT JOIN `vendor_type` cty
                ON cty.`id`=up.`vendor_id`
                WHERE up.`status`=4 AND up.`user_type_id`=2';
        $result=  executeQuery($query);
        if(mysql_num_rows($result))
        {
            while($row= mysql_fetch_assoc($result))
            {
                $fetchdata[]=$row;
            }
            for($i=0;$i<sizeof($fetchdata);$i++)
            {
                $data .='<tr><td>'.($i+1).'</td><td>'.$fetchdata[$i]['user_name'].'</td><td>'.$fetchdata[$i]['corporate_type'].'</td><td>'.$fetchdata[$i]['cell_number'].'</td><td>'.$fetchdata[$i]['email_id'].'</td>'
                        . '<td>'.$fetchdata[$i]['postal_code'].' - '.$fetchdata[$i]['telephone'].'</td><td>'.$fetchdata[$i]['representative_name'].'</td>'
                        . '<td><button type="button" class="btn btn-info" id="donordet_'.$fetchdata[$i]['donorid'].'"  title="Details"><i class="fa fa-reorder fa-1x"></i></button>&nbsp;'
                        . '<button type="button" class="btn btn-danger"  data-toggle="modal" data-target="#myModal_flag' . $i . '" title="Delete"><i class="fa fa-trash fa-1x"></i></button>'
                        . '<div class="modal fade" id="myModal_flag' . $i . '" tabindex="-1" role="dialog" aria-labelledby="myUSRLISTDELModal_' . $i . '" aria-hidden="true" style="display: none;">
							<div class="modal-dialog">
								<div class="modal-content" style="color:#000;">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h4 class="modal-title" id="myUSRDELModalLabel_' . $i . '">Are you really want to delete</h4>
									</div>
									<div class="modal-body" id="myUSRDEL_' . $i . '">
										Do you really want to delete {' . $fetchdata[$i]['user_name'] . '} <br />
										Press OK to delete ??
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="donordel_'.$fetchdata[$i]['donorid'].'">Ok</button>
										<button type="button" class="btn btn-success" data-dismiss="modal" id="deletelltDELCancel_' . $i . '">Cancel</button>
									</div>
								</div>
							</div>
						</div>'
                        . '</td>'
                        . '</tr>';
                $donorids[$i]=$fetchdata[$i]['donorid'];
                $alldata[$i]=$fetchdata[$i];
            }
            $jsondata=array(
                "status" => "success",
                "data" => $data,
                "donorids" => $donorids,
                "alldata" => $alldata,
            );
            return $jsondata;
        }
        else
        {
            $jsondata=array(
                "status" => "failure",
                "data" => NULL
            );
            return $jsondata;
        }
    }

     /*  Checking UserName */
     public function CheckEmail() {
        if(isset($this->parameters['donorid']))
        {
        $query="SELECT * FROM `user_profile` WHERE `email_id`='".  mysql_real_escape_string($this->parameters['email'])."' AND `id` !='".  mysql_real_escape_string($this->parameters['donorid'])."';";
        $reslut=  executeQuery($query);
        return mysql_num_rows($reslut);
        }
        $query="SELECT * FROM `user_profile` WHERE `email_id`='".  mysql_real_escape_string($this->parameters['email'])."';";
        $reslut=  executeQuery($query);
        return mysql_num_rows($reslut);
    }

    /* Updating Corporate Details */
    public function updateDonorDetails() {
        if($this->parameters['request'] == "personal")
        {
      $query='UPDATE `user_profile` SET `user_name`="'.  mysql_real_escape_string($this->parameters['name']).'",'
              . '`email_id`="'.  mysql_real_escape_string($this->parameters['email']).'",
      `cell_number`="'.  mysql_real_escape_string($this->parameters['mobile']).'",
          `corporate_id`="'.  mysql_real_escape_string($this->parameters['corporatetype']).'",
              `representative_name`="'.  mysql_real_escape_string($this->parameters['repname']).'",
                  `representative_mobile`="'.  mysql_real_escape_string($this->parameters['repmobile']).'",
                `postal_code`="'.  mysql_real_escape_string($this->parameters['stdcode']).'",
             `telephone`="'.  mysql_real_escape_string($this->parameters['landline']).'" WHERE `id`="'.  mysql_real_escape_string($this->parameters['donorid']).'";';
      return executeQuery($query);
        }
        else if($this->parameters['request'] == "commu")
        {
           $query='UPDATE `user_profile` SET `addressline`="'.  mysql_real_escape_string($this->parameters['addrs']).'",'
              . '`city`="'.  mysql_real_escape_string($this->parameters['city_town']).'",
      `town`="'.  mysql_real_escape_string($this->parameters['st_loc']).'",
          `district`="'.  mysql_real_escape_string($this->parameters['district']).'",
              `province`="'.  mysql_real_escape_string($this->parameters['province']).'",
                  `country`="'.  mysql_real_escape_string($this->parameters['country']).'",
                `zipcode`="'.  mysql_real_escape_string($this->parameters['zipcode']).'",
             `website`="'.  mysql_real_escape_string($this->parameters['website']).'" WHERE `id`="'.  mysql_real_escape_string($this->parameters['donorid']).'";';
      return executeQuery($query);
        }
        else
        {

        }
    }

    /*  Delete Coporate  */
    public function deleteDonor() {
        $query='UPDATE `user_profile` SET `status`=6 WHERE `id`='.  mysql_real_escape_string($this->parameters['donorid']).';';
        return executeQuery($query);
    }
}
