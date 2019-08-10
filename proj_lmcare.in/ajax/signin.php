<?php
class signin
{
    protected $parameters = array();
                function __construct($parameters = false) {
                    $this->parameters = $parameters;
		}
                public function userveify()
                {
                  $status_id='';
                  $_SESSION['status']=array();
                  $_SESSION['userdata']=array();
                  $query='SELECT `id`,`name`,`user_type_id` ,status_id,'
                          . 'CASE WHEN (`photo` is null OR `photo`="" )'
                          . 'THEN "'.USERLOGO.'" '
                          . 'ELSE `photo` END as photo '
                          . 'from `user_profie` '
                          . 'WHERE `username`="'.mysql_real_escape_string($this->parameters["username"]).'" AND `password`="'.  mysql_real_escape_string($this->parameters["password"]).'"'
                          . ';';
                  $result=  executeQuery($query);
//                  echo $query;
                  $num=  mysql_num_rows($result);
                    if($num>0){
                    $row=  mysql_fetch_assoc($result);
                    $status_id=$row['status_id'];
                    $query1='SELECT `from_pk` FROM `relations` WHERE `to_pk`='.trim($row['id']);
                    $result1=  executeQuery($query1);
                    $row1=  mysql_fetch_assoc($result1);
                    $status=array();
                    $statusdata=array(
                        "0" =>'N/A'
                    );
                    
                    $query2='SELECT * FROM `status`;';
                    $result2=  executeQuery($query2);
                    while($row2=  mysql_fetch_assoc($result2))
                    {
                      $status[]=$row2;  
                    }
                    for($i=0;$i<sizeof($status);$i++)
                    {
                        $statusdata[$status[$i]["id"]] = $status[$i]["status_name"];
                    }
                    $_SESSION['status']=$statusdata;
                    $_SESSION['userdata']=array(
                        "name" => $row['name'],
                        "id" => $row['id'],
                        "user_type" => $row['user_type_id'],
                        "photo" => $row['photo'],
                        "doctor_id" => $row1['from_pk'],
                        
                    );  
                    ?>
                    <?php
                    }  
                    $jsonmess=array(
                        "aunth" => $num,
                        "status_id" => $status_id,
                        "userdata" => $_SESSION['userdata'],
                        "status" =>$_SESSION['status'],
                    );
                    return $jsonmess;
                }
    }

?>

