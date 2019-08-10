<?php
	function main()
	{
		if(isset($_POST['sender']) && isset($_POST['cellno']))
		{
			$email = validateEmail($_POST['sender']);
			$cellno = $_POST['cellno'];
			if($email)
			{
				require 'PHPMailer-master/PHPMailerAutoload.php';
				$mail = new PHPMailer;
				$mail->SMTPDebug = 0;
				$mail->isSMTP();
				// $mail->isMail();
				$mail->SMTPAuth = true;
				$mail->Port       = 587;
				$mail->Host = '208.91.199.224';
				// $mail->Host = 'smtp.absoluteairsolution.com';
				$mail->Username = 'sales@standardbiz.in';
				$mail->Password = '9986780277_biz';
				// $mail->SMTPSecure = 'ssl';
				$mail->From = 'sales@standardbiz.in';
				$mail->FromName = 'Website hit';
				$mail->addAddress('sales@standardbiz.in', 'Me');
				$mail->isHTML(true);
				$mail->Subject = 'Requesting to call back';
				$mail->Body    = "Email id :-".$email."\r\n"."Contact number :-".$cellno."\r\n";
				$mail->AltBody = "Email id :-".$email."\r\n"."Contact number :-".$cellno."\r\n";
				if(!$mail->send()) 
				{
				   echo 'Mailer Error: ' . $mail->ErrorInfo;
				   exit(0);
				}
				echo 'We will contact you shortly';
			}
		}
		else
			echo 'Enter correct information press F5 to refresh the page';
		exit(0);
	}
	/* Validate email id */
	function validateEmail($email)
	{
		if(preg_match('%^[A-Z_a-z0-9-]+(\.[A-Z_a-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9]{2,4})*(\.[A-Za-z]{2,4})%',stripslashes(trim($email))))
			return $email; 
		else
			return NULL; 
	}	
	main();
?>