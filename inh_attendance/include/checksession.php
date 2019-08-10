<?php session_start();
if( !$_SESSION["ulogin"])
// if( !session_is_registered("ulogin"))
{
		header("Location:login.php?invalid=2");
}
if( !$_SESSION["utype"])
// if( !session_is_registered("utype"))
{
		header("Location:login.php?invalid=2");
}
?>
