<?php
$header = isset($this->idHolders["nookleads"]["index"]["header"]) ? (array) $this->idHolders["nookleads"]["index"]["header"] : false;
$login = isset($this->idHolders["nookleads"]["index"]["login"]) ? (array) $this->idHolders["nookleads"]["index"]["login"] : false;
$register = isset($this->idHolders["nookleads"]["index"]["register"]) ? (array) $this->idHolders["nookleads"]["index"]["register"] : false;
$about = isset($this->idHolders["nookleads"]["index"]["about"]) ? (array) $this->idHolders["nookleads"]["index"]["about"] : false;
$facebook = isset($this->idHolders["nookleads"]["index"]["facebook"]) ? (array) $this->idHolders["nookleads"]["index"]["facebook"] : false;
$googleplus = isset($this->idHolders["nookleads"]["index"]["googleplus"]) ? (array) $this->idHolders["nookleads"]["index"]["googleplus"] : false;
$guidelines = isset($this->idHolders["nookleads"]["index"]["guidelines"]) ? (array) $this->idHolders["nookleads"]["index"]["guidelines"] : false;
$privacy = isset($this->idHolders["nookleads"]["index"]["privacy"]) ? (array) $this->idHolders["nookleads"]["index"]["privacy"] : false;
$terms = isset($this->idHolders["nookleads"]["index"]["terms"]) ? (array) $this->idHolders["nookleads"]["index"]["terms"] : false;
$rules = isset($this->idHolders["nookleads"]["index"]["rules"]) ? (array) $this->idHolders["nookleads"]["index"]["rules"] : false;
$unique = isset($this->idHolders["nookleads"]["index"]["unique"]) ? (array) $this->idHolders["nookleads"]["index"]["unique"] : false;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $this->title; ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'
              name='viewport'>
        <script src="<?php
echo $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET_PLG"] .
 $this->config["PLG_16"];
?>jQuery-2.1.4.min.js"
        type="text/javascript"></script>
        <script src="<?php
echo $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET_PIC"];
?>config.js"
        type="text/javascript"></script>
        <script data-autoloader="false" type="text/javascript" src="<?php
echo $this->config["URL"] .
 $this->config["VIEWS"] .
 $this->config["ASSSET_PIC"] .
 $this->config["CONTROLLERS"];
?>Header.js"></script>
    </head>
    <body class="wysihtml5-supported skin-red-light sidebar-collapse">
        <div class="wrapper">
            <header class="main-header">
                <nav class="navbar navbar-static-top">
                    <div class="container">
                        <div class="navbar-header">
                            <a href="<?php echo $this->config["URL"]; ?>" class="navbar-brand"><b>nOOk</b>Leads</a>
                            <button aria-expanded="false" type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                                <i class="fa fa-bars"></i>
                            </button>
                        </div>
                        <div style="height: 1px;" aria-expanded="false" class="navbar-collapse pull-left collapse" id="navbar-collapse">
                            <ul class="nav navbar-nav">
                                <li><a href="<?php echo $facebook["url"] ?>">Login / Register Facebook</a></li>
                                <li><a href="<?php echo $googleplus["url"] ?>">Login / Register Google+</a></li>
                                <li><a href="<?php echo $rules["url"] ?>" >Rules</a></li>
                                <li><a href="<?php echo $guidelines["url"] ?>" >Guidelines</a></li>
                                <li class="dropdown">
                                    <a aria-expanded="false" href="#" class="dropdown-toggle" data-toggle="dropdown">More <span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="<?php echo $privacy["url"] ?>" >Privacy</a></li>
                                        <li class="divider"></li>
                                        <li><a href="<?php echo $unique["url"] ?>" >Loyalty</a></li>
                                        <li class="divider"></li>
                                        <li><a href="<?php echo $terms["url"] ?>" >Terms</a></li>
                                        <li class="divider"></li>
                                        <li><a href="<?php echo $about["url"]; ?>">About</a></li>
                                    </ul>
                                </li>                                
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>
            <?php
            //require_once 'leadFilterIndex.php';
            ?>
            <!--<div class="row"><div class="col-lg-12 center"> Welcome to nOOkLeads.com - get Your business Up And Running!!@!!</div></div>-->