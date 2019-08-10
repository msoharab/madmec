<?php
class controller {
            protected $parameters = array();
                function __construct($parameters = false) {
                    $this->parameters = $parameters;
		}
              
                public function addNEWS() {
                    $useridd=isset($_SESSION['USERDATA']['user_pk']) ? $_SESSION['USERDATA']['user_pk'] : false;
                    $details=array(
                                 "heading" => isset($_POST["details"]["heading"]) ? $_POST["details"]["heading"] : false, 
                                 "descb" => isset($_POST["details"]["descb"]) ? $_POST["details"]["descb"] : false,  
                                ); 
                    $imagepath=  isset($_SESSION['imagepath']) ? $_SESSION['imagepath'] : false;
                    $query='INSERT INTO `news`(`id`,`heading`,`desc`,`imgurl`,`user_pk`,`status_id`)VALUES(null,'
                            . '"'.  mysql_real_escape_string($this->parameters['heading']).'",'
                            . '"'.  mysql_real_escape_string($this->parameters['descb']).'",'
                            . '"'.  mysql_real_escape_string($imagepath).'",'  
                            . '"'.  mysql_real_escape_string($useridd).'",'
                            . '4)';
                    $result=  executeQuery($query);
                    unset($_SESSION['imagepath']);
                    return $result;
                    
                }
                public function fetchNEWS() {
                    $newsdata=array();
                    $newsid=array();
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
                            $newsid[$i]=$newsdata[$i]['id'];
                            $data .='<div class="panel panel-primary">
                                <div class="panel-heading">
                                    '.$newsdata[$i]["heading"].'
                                        
                                         <button type="button" sytle="float:right;"  id="delnews_'.$newsdata[$i]["id"].'" class="delete"><i class="fa fa-rocket fa-2x text-right"></i></button>
                                           
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
                        $data .= "<script>
                            if(localStorage.getItem('user') != 'admin')
                            {
                                $('.delete').hide();
                            }
                                </script>";
                        $jsondata=array(
                            "status" => "success",
                            "data" => $data,
                            "newsid" => $newsid
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
                    $useridd=isset($_SESSION['USERDATA']['user_pk']) ? $_SESSION['USERDATA']['user_pk'] : false;
                    $imagepath=  isset($_SESSION['imagepathbuss']) ? $_SESSION['imagepathbuss'] : false;
                    $query='INSERT INTO `business`(`id`,`user_pk`,`photopath`,`title`,`mobile`,`email`,`address`,`describtion`,`status_id`)VALUES(null,'
                            . '"'.  mysql_real_escape_string($useridd).'",'
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
        $bussid=array();
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
                $bussid[$i]=$bussidata[$i]["id"];
                $data .=' <div class="panel panel-primary">
                                <div class="panel-heading">
                                   <strong>'.$bussidata[$i]["title"].'</strong>
                                       <button type="button" sytle="float:right;"  id="delbuzz_'.$bussidata[$i]["id"].'" class="delete"><i class="fa fa-rocket fa-2x text-right"></i></button>
                                </div> 
                                <div class="panel-body">
                                   <div id="news1">
                                       <img src="'.URL.'ajax/'.$bussidata[$i]["photopath"].'" alt="" height="100" class="img-responsive"/>
                                           <br/>
                                            <p class="text-default"><b>
                                                '.$bussidata[$i]["describtion"].'<br/><br/>
                                                    Address  :  '.$bussidata[$i]["address"].'<br/>
                                                     <a href="tel:'.$bussidata[$i]["mobile"].'"><i class="fa fa-mobile fa-4x"></i> </a>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                     <a href="mailto:'.$bussidata[$i]["email"].'"><i class="fa fa-envelope fa-4x"></i> </a>   
                                            </p>
                                   </div>
                                </div>
                            </div>';
            }
            $data .= "<script>
                            if(localStorage.getItem('user') != 'admin')
                            {
                                $('.delete').hide();
                            }
                                </script>";
            $jsondata=array(
                "status"  => "success",
                "data"  => $data,
                "buzzids"  => $bussid,
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
    
    public function verifyUser() {
      $query='SELECT * 
              FROM `user_profile` WHERE
               `user_name`="'.  mysql_real_escape_string($this->parameters["username"]).'" 
            AND `password`="'.  mysql_real_escape_string($this->parameters["password"]).'" AND `status_id`=1;';
      $result=  executeQuery($query);
      if(mysql_num_rows($result))
      {
          $row=  mysql_fetch_assoc($result);
          $jsondata=array(
          "status" => "success",
          "usertype" => $row['user_type_id'], 
          "user_pk" => $row['id']   ,
          "owner_name" => $row['owner_name']   
              );
         $_SESSION['USERDATA']=$jsondata;
         return $jsondata;
      }
      else
      {
         $row=  mysql_fetch_assoc($result);
          $jsondata=array(
          "status" => "failure",
          "usertype" => NULL, 
          "user_pk" => NULL   ,
          "owner_name" => NULL  
              );
         return $jsondata; 
      }
    }
      
      public function signup() {
        $query='INSERT INTO `user_profile`(`id`,`user_name`,`owner_name`,`cell_number`,`password`,`status_id`,`user_type_id`)VALUES(null,'
                . '"'.  mysql_real_escape_string($this->parameters['regemail']).'",'
                 . '"'.  mysql_real_escape_string($this->parameters['name']).'",'
                 . '"'.  mysql_real_escape_string($this->parameters['regemobile']).'",'
                 . '"'.  mysql_real_escape_string($this->parameters['regcpass']).'",'
                . '1,1)';
        $result=executeQuery($query);
        return $result;
      }
      
      public function checkEmail($email) {
          $query='SELECT * FROM `user_profile` WHERE `user_name`="'.  mysql_real_escape_string($email).'" ;';
          $result=  executeQuery($query);
          return mysql_num_rows($result);
      } 
      
      public function addSPON($url) {
          $imggurl=  isset($_SESSION['imagepathspon']) ? $_SESSION['imagepathspon'] : false;
          $query='INSERT INTO `sponserous`(`id`,`imgurl`,`url`,`status_id`)VALUES(null,'
                  . '"'.  mysql_real_escape_string($imggurl).'",'
                  . '"'.  mysql_real_escape_string($url).'",'
                  . '4)';
          $result=  executeQuery($query);
          return $result;
      }
      
      public function fetchSpons() {
         $spondata=array();
         $sponids=array();
         $data='';
         $query='SELECT * FROM `sponserous` WHERE `status_id`=4 ORDER BY id DESC;';
         $result=  executeQuery($query);
         if(mysql_num_rows($result))
         {
             while ($row = mysql_fetch_assoc($result)) {
               $spondata[]=$row;  
             }
             for($i=0;$i<sizeof($spondata);$i++)
             {
                 $sponids[$i]=$spondata[$i]["id"];
                 $data .='<button type="button" sytle="float:right;"  id="delsponz_'.$spondata[$i]["id"].'" class="delete"><i class="fa fa-rocket fa-2x text-right"></i></button>
                        <a href="'.$spondata[$i]['url'].'" target="_blank">
                        <img src="'.URL.'ajax/'.$spondata[$i]['imgurl'].'" alt="" class="img-responsive"/>
                        </a><hr /><br/>';
             }
             $data .= "<script>
                            if(localStorage.getItem('user') != 'admin')
                            {
                                $('.delete').hide();
                            }
                                </script>";
             $jsondata=array(
                 "status"  => "success",
                 "data"  => $data,
                 "sponids" => $sponids
             );
             return $jsondata;
         }
            else {
                $jsondata=array(
                 "status"  => "failure",
                 "data"  => NULL
             );
             return $jsondata;
            }
      }
      public function deleteBuzzPost($bid) {
        $query="UPDATE `business` SET `status_id`=6 WHERE `id`='".mysql_real_escape_string($bid)."';"  ;
        $result=  executeQuery($query);
        return $result;
      }  
      public function deleteNEWSPost($bid) {
        $query="UPDATE `news` SET `status_id`=6 WHERE `id`='".mysql_real_escape_string($bid)."';"  ;
        $result=  executeQuery($query);
        return $result;
      }
      public function deleteSponzPost($bid) {
        $query="UPDATE `sponserous` SET `status_id`=6 WHERE `id`='".mysql_real_escape_string($bid)."';"  ;
        $result=  executeQuery($query);
        return $result;
      } 
}
