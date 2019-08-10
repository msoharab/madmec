<?php
/* Personal info */
$apiPers = isset($this->idHolders["onlinefood"]["api"]["ApiPersonal"]["AddUser"]) ? (array) $this->idHolders["onlinefood"]["api"]["ApiPersonal"]["AddUser"] : false;
$apiPersList = isset($this->idHolders["onlinefood"]["api"]["ApiPersonal"]["ListUser"]) ? (array) $this->idHolders["onlinefood"]["api"]["ApiPersonal"]["ListUser"] : false;
$apiPersEdit = isset($this->idHolders["onlinefood"]["api"]["EditUser"]) ? (array) $this->idHolders["onlinefood"]["api"]["EditUser"] : false;

/* Business info */
$apiBusi = isset($this->idHolders["onlinefood"]["api"]["ApiBusiness"]["AddBusiness"]) ? (array) $this->idHolders["onlinefood"]["api"]["ApiBusiness"]["AddBusiness"] : false;
$apiBusiList = isset($this->idHolders["onlinefood"]["api"]["ApiBusiness"]["ListBusiness"]) ? (array) $this->idHolders["onlinefood"]["api"]["ApiBusiness"]["ListBusiness"] : false;
?>

