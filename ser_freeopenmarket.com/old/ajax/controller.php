<?php
class controller {
            protected $parameters = array();
                function __construct($parameters = false) {
                    $this->parameters = $parameters;
		}
                public function addNEWS() {
                    $details=array(
                                 "heading" => isset($_POST["details"]["heading"]) ? $_POST["details"]["heading"] : false, 
                                 "descb" => isset($_POST["details"]["descb"]) ? $_POST["details"]["descb"] : false,  
                                ); 
                    $imagepath=  isset($_SESSION['imagepath']) ? $_SESSION['imagepath'] : false;
                    $query='INSERT INTO `news`(`id`,`heading`,`desc`,`imgurl`,`user_pk`,`status_id`)VALUES(null,'
                            . '"'.  mysql_real_escape_string($this->parameters['heading']).'",'
                            . '"'.  mysql_real_escape_string($this->parameters['descb']).'",'
                            . '"'.  mysql_real_escape_string($imagepath).'",3'
                            . ',4)';
                    $result=  executeQuery($query);
                    unset($_SESSION['imagepath']);
                    return $result;
                    
                }
                public function fetchNEWS() {
                    $newsdata=array();
                    $data='';
                    $query='SELECT * FROM news WHERE status_id=4 ORDER BY id DESC  LIMIT 0,100 ;';
                    $result=  executeQuery($query);
                    if(mysql_num_rows($result))
                    {
                        while ($row = mysql_fetch_assoc($result)) {
                          $newsdata[]=$row;  
                        }
                        for($i=0;$i<sizeof($newsdata);$i++)
                        {
                            $data .='<div class="panel panel-warning">
                                <div class="panel-heading">
                                    '.$newsdata[$i]["heading"].'
                                </div>
                                <div class="panel-body">
                                   <div id="news1">
                                       <img src="'.URL.'ajax/'.$newsdata[$i]["imgurl"].'" alt="" height="20" class="img-responsive"/>
                                            <p>
                                               '.$newsdata[$i]["desc"].'
                                            </p>
                                   </div>
                                </div>
                                <div class="panel-footer">
                                    '.$newsdata[$i]["time"].'
                                </div>
                            </div>';
                        }
                        $jsondata=array(
                            "status" => "success",
                            "data" => $data
                        );
                        return $jsondata;
                    }
                    else {
                        $jsondata=array(
                            "status" => "failure",
                            "data" => NULL
                        );
                        return $jsondata;
                    }
                    
                }
                
                public function addBusiness() {
                    $imagepath=  isset($_SESSION['imagepathbuss']) ? $_SESSION['imagepathbuss'] : false;
                    $query='INSERT INTO `business`(`id`,`user_pk`,`photopath`,`title`,`mobile`,`email`,`address`,`describtion`,`status_id`)VALUES(null,4,'
                            . '"'.  mysql_real_escape_string($imagepath).'",'
                            . '"'.  mysql_real_escape_string($this->parameters['businame']).'",'
                            . '"'.  mysql_real_escape_string($this->parameters['mobile']).'",'
                            . '"'.  mysql_real_escape_string($this->parameters['email']).'",'
                            . '"'.  mysql_real_escape_string($this->parameters['addr']).'",'
                             . '"'.  mysql_real_escape_string($this->parameters['descb']).'",'
                            . '4)';
                    $result=  executeQuery($query);
                    unset($_SESSION['imagepathbuss']);
                    return $result;
                }
                
                
    public function fetchBusiness() {
        $bussidata=array();
        $data='';
        $query='SELECT * FROM business WHERE status_id=4 ORDER BY id DESC  LIMIT 0,100 ';
        $result=  executeQuery($query);
        if(mysql_num_rows($result))
        {
            while ($row = mysql_fetch_assoc($result)) {
                $bussidata[]=$row;
            }
            for($i=0;$i<sizeof($bussidata);$i++)
            {
                $data .=' <div class="panel panel-warning">
                                <div class="panel-heading">
                                    Business
                                </div>
                                <div class="panel-body">
                                   <div id="news1">
                                       <img src="'.URL.'ajax/'.$bussidata[$i]["photopath"].'" alt="" height="100" class="img-responsive"/>
                                            <h3>'.$bussidata[$i]["title"].'</h3>
                                            <p>
                                                '.$bussidata[$i]["describtion"].'<br/><br/>
                                                    Address  :  '.$bussidata[$i]["address"].'<br/>
                                                    Phone Number  : '.$bussidata[$i]["mobile"].'    <br/>
                                                     Email        :  '.$bussidata[$i]["email"].'    <br/>   
                                                    
                                            </p>
                                   </div>
                                </div>
                            </div>';
            }
            $jsondata=array(
                "status"  => "success",
                "data"  => $data
            );
            return $jsondata;
        }
        else
        {
            $jsondata=array(
                "status"  => "failure",
                "data"  => NULL
            );
            return $jsondata;
        }
    }
}
