<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $this->title; ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <script src="<?php echo $this->config["URL"] . $this->config["VIEWS"]. $this->config["ASSSET_PIC"]; ?>config.js" type="text/javascript"></script>
        <script src="<?php echo $this->config["URL"] . $this->config["VIEWS"]; ?>assets/plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo $this->config["URL"] ; ?>">pic3pic</a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="#">Popular</a></li>
                        <li><a href="#">New</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Section <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another</a></li>
                                <li><a href="#">Somethi</a></li>
                                <li><a href="#">Somethi</a></li>
                                <li><a href="#">Somethi</a></li>
                                <li><a href="#">Somethi</a></li>
                                <li><a href="#">Somethi</a></li>
                                <li><a href="#">Somethi</a></li>
                                <li><a href="#">Somethi</a></li>
                                <li><a href="#">Somethi</a></li>
                                <li><a href="#">Somethi</a></li>
                                <li><a href="#">Somethi</a></li>
                                <li><a href="#">Somethi</a></li>
                                <li><a href="#">Somethi</a></li>
                                <li><a href="#">Somethi</a></li>
                            </ul>
                        </li>
                        <li class="border-left-black border-right-black concept">
                            <a href="javascript:void();"><input id='watch-me' type="checkbox" name="test" value="a" checked><label>&nbsp; World</label></a>
                        </li>
                        <li class="concept">
                            <a href="javascript:void();"><input type="checkbox" name="test" value="b"><label>&nbsp; Country</label></a>
                        </li>
                        <li id='show-me' class="concept">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Select Country <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another</a></li>
                                <li><a href="#">Somethi</a></li>
                                <li><a href="#">Somethi</a></li>
                                <li><a href="#">Somethi</a></li>
                                <li><a href="#">Somethi</a></li>
                                <li><a href="#">Somethi</a></li>
                                <li><a href="#">Somethi</a></li>
                                <li><a href="#">Somethi</a></li>
                                <li><a href="#">Somethi</a></li>
                                <li><a href="#">Somethi</a></li>
                                <li><a href="#">Somethi</a></li>
                                <li><a href="#">Somethi</a></li>
                                <li><a href="#">Somethi</a></li>
                                <li><a href="#">Somethi</a></li>
                            </ul>
                        </li>
                        <li id='show-me' class=" border-right-black concept">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Select Language <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another</a></li>
                                <li><a href="#">Somethi</a></li>
                                <li><a href="#">Somethi</a></li>
                                <li><a href="#">Somethi</a></li>
                                <li><a href="#">Somethi</a></li>
                                <li><a href="#">Somethi</a></li>
                                <li><a href="#">Somethi</a></li>
                                <li><a href="#">Somethi</a></li>
                                <li><a href="#">Somethi</a></li>
                                <li><a href="#">Somethi</a></li>
                                <li><a href="#">Somethi</a></li>
                                <li><a href="#">Somethi</a></li>
                                <li><a href="#">Somethi</a></li>
                                <li><a href="#">Somethi</a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <?php if (isset($_SESSION["USERDATA"]["loggedin"]) && $_SESSION["USERDATA"]["loggedin"] == 1): ?>
                            <li class="gap-right sm-pad-top">
                                <button type="button" onClick="window.location.href = '<?php echo $this->config["URL"] . 'Logout'; ?>';" class="btn btn-danger sm-height"><i class="fa fa-sign-in"> Logout</i></button></li>
                        <?php else: ?>
                            <li class="gap-right sm-pad-top">
                                <button type="button" data-toggle="modal" data-target="#login" data-whatever="@mdo" class="btn btn-success sm-height" id="loginBut"><i class="fa fa-sign-in"> Login</i></button></li>
                            <li class="gap-right sm-pad-top">
                                <button type="button" data-toggle="modal" data-target="#register" data-whatever="@mdo" class="btn btn-primary sm-height" id="registerBut"><i class="fa fa-pencil-square-o"> Register</i></button></li>
                        <?php endif; ?>
                        <li class="gap-right sm-pad-top">
                            <button type="button" class="btn btn-info sm-height" id="helpBut"><i class="fa fa-info-circle"> Help</button></i></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav><!-- end of nav-->