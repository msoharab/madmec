<?php
 session_start();
// if( !session_is_registered("ulogin"))
if( !$_SESSION["ulogin"])
{
		header("Location:login.php?invalid=2");
}
?>