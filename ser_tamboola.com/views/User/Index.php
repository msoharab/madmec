<?php
/* Personal info */
$userPro = isset($this->idHolders["tamboola"]["user"]["Personal"]["AddUser"]) ? (array) $this->idHolders["tamboola"]["user"]["Personal"]["AddUser"] : false;
$userList = isset($this->idHolders["tamboola"]["user"]["Personal"]["ListUser"]) ? (array) $this->idHolders["tamboola"]["user"]["Personal"]["ListUser"] : false;
$userEdit = isset($this->idHolders["tamboola"]["user"]["EditUser"]) ? (array) $this->idHolders["tamboola"]["user"]["EditUser"] : false;
/* Business info */
$userBusi = isset($this->idHolders["tamboola"]["user"]["Business"]["AddBusiness"]) ? (array) $this->idHolders["tamboola"]["user"]["Business"]["AddBusiness"] : false;
$userBusiList = isset($this->idHolders["tamboola"]["user"]["Business"]["ListBusiness"]) ? (array) $this->idHolders["tamboola"]["user"]["Business"]["ListBusiness"] : false;
?>