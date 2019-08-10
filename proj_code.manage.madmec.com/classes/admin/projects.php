<?php
class adminProjects {

    protected $parameters = array();

    function __construct($para = false) {
        $this->parameters = $para;
    }

    public function fetchContinents() {
        $query='SELECT
                    con.id,
                    con.continent_name
                  FROM `pic3pic_continents` con
                  WHERE con.status_id = 4';
        $result=  executeQuery($query);
        $data=array();
        $jsondata=array(
            "status" => "failure",
            "data" => NULL);
       if(mysql_num_rows($result))
        {
           $i=0;
            while($row=  mysql_fetch_assoc($result))
            {
                $data [$i]["id"]= $row['id'];
                $data [$i]["cname"]= $row['continent_name'];
                ++$i;
            }
            $jsondata=array(
            "status" => "success",
            "data" => $data
        );
        }
        return $jsondata;

    }

    public function addProject() {
        $query = 'INSERT INTO `pic3pic_countries`(`id`, `continent_id`, `ISO`, `ISO3`, `ISO-Numeric`, `Country`, 
              `tld`, `CurrencyCode`, `Capital`,
             `status_id`) VALUES 
            (NULL,
            "'.  mysql_real_escape_string($this->parameters['selectcont']).'",
             "'.  mysql_real_escape_string($this->parameters['ISO']).'",
            "'.  mysql_real_escape_string($this->parameters['ISO3']).'",
            "'.  mysql_real_escape_string($this->parameters['ISO-Numeric']).'",
            "'.  mysql_real_escape_string($this->parameters['countryname']).'", 
            "'.  mysql_real_escape_string($this->parameters['tld']).'",
            "'.  mysql_real_escape_string($this->parameters['ccode']).'",
            "'.  mysql_real_escape_string($this->parameters['Capital']).'",
                4)';
        return executeQuery($query);
    }

    //Fetch List of Individual Donors
    public function fetchListOfProjects($continet = false) {
        $fetchdata = array();
        $donorids = array();
        $alldata = array();
        $data = '';
        $query = 'SELECT con.*,
                cnt.continent_name
                FROM `pic3pic_countries` con
                  LEFT JOIN `pic3pic_continents` cnt
                    ON cnt.id = con.continent_id
                WHERE con.status_id = 4
                AND cnt.`id` = '.  mysql_real_escape_string($continet).'
                ORDER BY con.Country ASC;';
        $result = executeQuery($query);
        if (mysql_num_rows($result)) {
            while ($row = mysql_fetch_assoc($result)) {
                $fetchdata[] = $row;
            }
            for ($i = 0; $i < sizeof($fetchdata); $i++) {
                $data .='<tr><td>' . ($i + 1) . '</td><td>' . $fetchdata[$i]['id'] . '</td><td>' . $fetchdata[$i]['Country'] . '</td><td>' . $fetchdata[$i]['Capital'] . '</td><td>' . $fetchdata[$i]['ISO'] . '</td><td>' . $fetchdata[$i]['CurrencyCode'] . '</td><td>' . $fetchdata[$i]['continent_name'] . '</td>'
                        . ''
                        . '<td><button type="button" class="btn btn-info" id="donordet_' . $fetchdata[$i]['id'] . '"  title="Details"><i class="fa fa-reorder fa-1x"></i></button>&nbsp;'
                        . '<button type="button" class="btn btn-danger"  data-toggle="modal" data-target="#myModal_flag' . $i . '" title="Delete"><i class="fa fa-trash fa-1x"></i></button>'
                        . '<div class="modal fade" id="myModal_flag' . $i . '" tabindex="-1" role="dialog" aria-labelledby="myUSRLISTDELModal_' . $i . '" aria-hidden="true" style="display: none;">
							<div class="modal-dialog">
								<div class="modal-content" style="color:#000;">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h4 class="modal-title" id="myUSRDELModalLabel_' . $i . '">Are you really want to delete</h4>
									</div>
									<div class="modal-body" id="myUSRDEL_' . $i . '">
										Do you really want to delete {' . $fetchdata[$i]['Country'] . '} <br />
										Press OK to delete ??
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="donordel_' . $fetchdata[$i]['id'] . '">Ok</button>
										<button type="button" class="btn btn-success" data-dismiss="modal" id="deletelltDELCancel_' . $i . '">Cancel</button>
									</div>
								</div>
							</div>
						</div>'
                        . '</td>'
                        . '</tr>';
                $donorids[$i] = $fetchdata[$i]['id'];
                $alldata[$i] = $fetchdata[$i];
            }
            $jsondata = array(
                "status" => "success",
                "data" => $data,
                "donorids" => $donorids,
                "alldata" => $alldata,
            );
            return $jsondata;
        } else {
            $jsondata = array(
                "status" => "failure",
                "data" => NULL
            );
            return $jsondata;
        }
    }

    public function updateProjectDetails() {
        $query = 'UPDATE `pic3pic_countries` SET `continent_id`="' . mysql_real_escape_string($this->parameters['selectcont']) . '",
            `Capital`="' . mysql_real_escape_string($this->parameters['Capital']) . '",
            `ISO`="' . mysql_real_escape_string($this->parameters['ISO']) . '",    
            `ISO3`="' . mysql_real_escape_string($this->parameters['ISO']) . '",   
            `ISO-Numeric`="' . mysql_real_escape_string($this->parameters['ISO-Numeric']) . '",
            `Country`="' . mysql_real_escape_string($this->parameters['countryname']) . '",
            `tld`="' . mysql_real_escape_string($this->parameters['tld']) . '",
            `CurrencyCode`="' . mysql_real_escape_string($this->parameters['ccode']) . '"
                WHERE `id`="' . mysql_real_escape_string($this->parameters['typeid']) . '"';
        return executeQuery($query);
    }

    public function deleteProject() {
        $query = 'UPDATE `pic3pic_countries` SET `status_id`="6" WHERE `id`="' . mysql_real_escape_string($this->parameters['typeid']) . '"';
        return executeQuery($query);
    }

    public function checkProjectName() {
        if (isset($this->parameters['donorid'])) {
            $query = "SELECT * FROM `pic3pic_countries` WHERE `Country`='" . mysql_real_escape_string($this->parameters['proname']) . "' AND `id` !='" . mysql_real_escape_string($this->parameters['donorid']) . "';";
            $reslut = executeQuery($query);
            return mysql_num_rows($reslut);
        }
        $query = "SELECT * FROM `pic3pic_countries` WHERE `Country`='" . mysql_real_escape_string($this->parameters['proname']) . "';";
        $reslut = executeQuery($query);
        return mysql_num_rows($reslut);
    }

}
?>