<?php
$header = isset($this->idHolders["ricepark"]["index"]["header"]) ? (array) $this->idHolders["ricepark"]["index"]["header"] : false;
$login = isset($this->idHolders["ricepark"]["index"]["login"]) ? (array) $this->idHolders["ricepark"]["index"]["login"] : false;
$register = isset($this->idHolders["ricepark"]["index"]["register"]) ? (array) $this->idHolders["ricepark"]["index"]["register"] : false;
$about = isset($this->idHolders["ricepark"]["index"]["about"]) ? (array) $this->idHolders["ricepark"]["index"]["about"] : false;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $this->title; ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <script data-autoloader="false" type="text/javascript" src="<?php echo $this->config["URL"] . $this->config["VIEWS"] . $this->config["ASSSET_REG"]; ?>config.js"></script>
        <script data-autoloader="false" type="text/javascript" src="<?php echo $this->config["URL"] . $this->config["VIEWS"] . $this->config["ASSSET_PLG"] . $this->config["PLG_16"]; ?>jQuery-1.7.1.min.js"></script>
    </head>
    <body>