<?php
	define("MODULE_0","config.php");
	require_once (MODULE_0);
	require_once(CONFIG_ROOT.MODULE_0);
	if(isset($_POST['submit']) && $_POST['submit'] == 'submit'){
		if(isset($_POST['fromemail']) && 
		   isset($_POST['tagetemailid']) && 
		   isset($_POST['message']) && 
		   isset($_POST['subject']) && 
		   !empty($_POST['fromemail'])&& 
		   !empty($_POST['tagetemailid'])&& 
		   !empty($_POST['message']) && 
		   !empty($_POST['subject']))
		{
			$tagetemailid = urldecode($_POST['tagetemailid']);
			$mailParameters = array(
				"server" 		=> mt_rand(0,2),
				"name" 			=> explode("@",$tagetemailid)[0],
				"target_host" 	=> explode("@",$tagetemailid)[1],
				"to" 			=> $tagetemailid,
				"title" 		=> "MadMec",
				"subject" 		=> 'MadMec :: '.urldecode($_POST['subject']),
				"message" 		=> urldecode($_POST['message']),
				"message_type" 	=> "Promotional."
			);
			$MailConfig = Alert($mailParameters);
			if($MailConfig["status"]){
				echo '<strong style="color:#009900;">Mail sent to :- '.$tagetemailid.'</strong>';
			}
			else{
				echo '<strong style="color:#FF0000;">Mail rejected :- '.$tagetemailid.'</strong>';
			}
			unset($_POST['fromemail']);
			unset($_POST['tagetemailid']);
			unset($_POST['message']);
			unset($_POST['subject']);		
		}
	}
?>