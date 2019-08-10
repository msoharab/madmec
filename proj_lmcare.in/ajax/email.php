<?php
define("MODULE_0","config.php");
require_once (MODULE_0);
if(isset($_POST['action']) && $_POST['action'] == 'send_email'){
    $name = $_POST['name'];
    $address = $_POST['address']; 
    $city = $_POST['city']; 
    $pin = $_POST['pin']; 
    $mobile = $_POST['mobile']; 
    $email = $_POST['email']; 
    $time = $_POST['time']; 
    $cat = $_POST['cat']; 
    $msg = $_POST['msg'];
    $to_name = 'Super Admin';
    $subject="DEMO REQUEST";
    $message = 'Hi SuperAdmin,'.
                '<br />Below are the details of new enquiry for DEMO REQUEST. <br /><br />
                <div id="mydiv" style="box-shadow:0px 0px 2px 2px #999;color:#000 !important;font-size:16px;">
                    <table cellpadding="10" cellspacing="0" border="1">
                        <tr>
                            <td>Name</td>
                            <td>'.$name.'</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>'.$address.'</td>
                        </tr>
                        <tr>
                            <td>City</td>
                            <td>'.$city.'</td>
                        </tr>
                        <tr>
                            <td>Pin</td>
                            <td>'.$pin.'</td>
                        </tr>
                        <tr>
                            <td>Mobile</td>
                            <td>'.$mobile.'</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>'.$email.'</td>
                        </tr>
                        <tr>
                            <td>Time</td>
                            <td>'.$time.'</td>
                        </tr>
                        <tr>
                            <td>Category</td>
                            <td>'.$cat.'</td>
                        </tr>
                        <tr>
                            <td>Message</td>
                            <td>'.$msg.'</td>
                        </tr>
                    </table>
                </div>
            ';
    //email to admin//
    $flag1 = send_email('enquiry@loginics.com',$to_name,$subject,$message);
    //email to sanjiv//
    $flag1 = send_email('sanjiva.bennur@loginics.com',$to_name,$subject,$message);
    if($flag1 || $flag2){
        echo 'Your request has been recieved, Our technical expert will be calling you shortly';
    }
    else{
        echo 'Unexpected ERROR! try again later';
    }
}
function send_email($to_email,$to_name,$subject,$message){
    /* SENDING A EMAIL */

    $flag = false;
    $mail = '';
    set_include_path(get_include_path() .PATH_SEPARATOR .LIB_ROOT);
    require_once(LIB_ROOT.MODULE_ZEND_1);
    require_once(LIB_ROOT.MODULE_ZEND_2);
    $config = array('auth' => 'login',
                            'port' => MAILPORT,
                            'username' => MAILUSER,
                            'password' => MAILPASS);
   
    $transport = new Zend_Mail_Transport_Smtp(MAILHOST, $config);
    if($transport){
            $mail = new Zend_Mail();
            if($mail){
                    $mail->setBodyHtml($message);
                    $mail->setFrom(MAILUSER, "Loginics Pvt Ltd.");
                    $mail->addTo($to_email, $to_name);
                    $mail->setSubject($subject);
                    $flag = true;
            }
    }
    if($flag){
            try{
                    $mail->send($transport);
                    unset($mail);
                    unset($transport);
                    $flag = true;
            }
            catch(exceptoin $e){
                    echo 'Invalid email id :- '.$to_email.'<br />';
                    $flag = false;
            }
    }
    return $flag;
}
?>