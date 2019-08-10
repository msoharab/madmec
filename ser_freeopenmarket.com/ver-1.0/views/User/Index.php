<?php
/* Personal info */
$userPro = isset($this->idHolders["onlinefood"]["user"]["Personal"]["AddUser"]) ? (array) $this->idHolders["onlinefood"]["user"]["Personal"]["AddUser"] : false;
$userList = isset($this->idHolders["onlinefood"]["user"]["Personal"]["ListUser"]) ? (array) $this->idHolders["onlinefood"]["user"]["Personal"]["ListUser"] : false;
$userEdit = isset($this->idHolders["onlinefood"]["user"]["EditUser"]) ? (array) $this->idHolders["onlinefood"]["user"]["EditUser"] : false;

/* Business info */
$userBusi = isset($this->idHolders["onlinefood"]["user"]["Business"]["AddBusiness"]) ? (array) $this->idHolders["onlinefood"]["user"]["Business"]["AddBusiness"] : false;
$userBusiList = isset($this->idHolders["onlinefood"]["user"]["Business"]["ListBusiness"]) ? (array) $this->idHolders["onlinefood"]["user"]["Business"]["ListBusiness"] : false;
?>