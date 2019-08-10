<?php

define('GSERVER', 'smtp.gmail.com'); // smtp.gmail.com
define('GUSER', 'you@yourgmail.com');
define('GPWD', 'password');
define('SMTPUSER', 'you@yoursmtp.com');
define('SMTPPWD', 'password');
define('SMTPSERVER', 'smtp.yoursmtp.com');


include('regconnect.php');

function sendMail() {
    $Name = isset($_POST['username']) ? $_POST['username'] : false;
    $Cell_no = isset($_POST['cellnum']) ? $_POST['cellnum'] : false;
    $Email = isset($_POST['Email']) ? $_POST['Email'] : false;
    $Address = isset($_POST['address']) ? $_POST['address'] : false;
    $Password = isset($_POST['password']) ? $_POST['password'] : false;
    $errors = array();
    $query = "INSERT INTO users(Name,Password,Cell_no, Email, Address)VALUES('$Name', '$Password','$Cell_no', '$Email', '$Address');";
    mysql_query($query);
    $subject = " Registered Sucessfully! ";
    $body = '$Password' . $Password;
    $headers = 'From:info@infinizy.in' . "\r\n";
    $headers .= 'Reply-To: info@infinizy.in' . "\r\n";
    echo mail($Email, $subject, $body, $headers);
}

function fmail($Email, $subject, $body, $headers) {
    global $error;
    $qry = mysql_query("SELECT `Email` FROM `users` WHERE Id=(SELECT max(Id) FROM users);");
    while ($row = mysql_fetch_assoc($qry)) {
        $Email = $row['Email'];
        $to = $Email;

        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->Username = 'sam.munaf007@gmail.com';
        $mail->Password = 'munaf007';
        /*
          if ($is_gmail) {

          } else {
          $mail->Host = 'ten.localmm.com';
          $mail->Port = 25;
          $mail->Username = 'cms2@madmec.com';
          $mail->Password = 'splasher777';
          }
         */
        $mail->From = $headers;
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AddAddress($to);
        if (!$mail->Send()) {
            $error = 'Mail error: ' . $mail->ErrorInfo;
            return false;
        } else {
            $error = 'Message sent!';
            return true;
        }
    }
}

function submitlogin() {
    $Email = isset($_POST['Email']) ? $_POST['Email'] : false;
    $Password = isset($_POST['Password']) ? $_POST['Password'] : false;
    $result = mysql_query('SELECT * FROM `users` WHERE Email = "' . $Email . '" and Password ="' . $Password . '"');

    $row = mysql_fetch_array($result);

    if ($row["Email"] == $Email && $row["Password"] == $Password) {
        $userdata = array(
            "USER_ID" => $row["Id"],
            "EMAIL" => $row["Email"],
            "PASSWORD" => $row["Password"],
        );
        $_SESSION['USER_LOGIN_DATA'] = $userdata;
        echo "success";
    } else {
        echo"error.";
    }
}

function sendsms() {
    $query = "SELECT * FROM sms WHERE User_Id='" . mysql_real_escape_string($_SESSION['USER_LOGIN_DATA']['USER_ID']) . "';";
    $result = mysql_query($query);
    if ((int) (mysql_num_rows($result)) >= 5) {
        echo "completed";
        exit(0);
    } else {
        $phone = isset($_POST['number']) ? $_POST['number'] : 0;
        $text = isset($_POST['message']) ? $_POST['message'] : "Test Messagse";
        $restPara = array(
            "user" => 'infidemo',
            "pass" => 'iinfydemo0123',
            "sender" => 'infdmo',
            "phone" => $phone,
            "text" => isset($_POST['message']) ? $_POST['message'] : "Test Messagse",
            "smstype" => 'normal',
            "Priority" => 'dnd'
        );
        $url = "http://sms.infinizy.in/api/sendmsg.php?user=infidemo&pass=iinfydemo0123&sender=infdmo&phone=" . $phone . " No&text=" . $text . " SMS&priority=dnd&stype=normal";
//        $url = 'http://sms.infinizy.in/api/sendmsg.php?' . http_build_query($restPara);
        $response2 = file_get_contents($url);
        if ($response2) {
            $query2 = "INSERT INTO `sms`(`Id`, `User_Id`, `Message`, `to`, `sent`) VALUES "
                    . "(NULL,"
                    . "'" . mysql_real_escape_string($_SESSION['USER_LOGIN_DATA']['USER_ID']) . "',"
                    . "'" . mysql_real_escape_string($_POST['message']) . "',"
                    . "'" . mysql_real_escape_string($_POST['message']) . "',now()"
                    . ");";
            mysql_query($query2);
            echo "success";
        } else {
            echo "error";
        }
    }
}

function contact() {
    $Name = isset($_POST['name']) ? $_POST['name'] : false;
    $Email = isset($_POST['email']) ? $_POST['email'] : false;
    $Cell_no = isset($_POST['cell_no']) ? $_POST['cell_no'] : false;
    $Company_Name = isset($_POST['company_name']) ? $_POST['company_name'] : false;
    $Message = isset($_POST['message']) ? $_POST['message'] : false;
    $qy = "INSERT INTO contact(Name, Email,Cell_no,Company_Name, Message)VALUES('$Name','$Email','$Cell_no', '$Company_Name', '$Message');";
    echo mysql_query($qy);
}

function main() {
    $parameters = array(
        "action" => isset($_POST['action']) ? $_POST['action'] : false,
    );
    switch ($parameters['action']) {
        case 'register' :
            sendMail();
            break;
        case 'login' :
            submitlogin();
            break;
        case 'sms' :
            sendsms();
            break;
        case 'contact':
            contact();
            break;
    }
}

if (isset($_POST['autoloader']) && $_POST['autoloader'] == 'true') {
    main();
    unset($_POST);
}
?>