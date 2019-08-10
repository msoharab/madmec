<?php
$header = isset($this->idHolders["pic3pic"]["header"]) ? (array) $this->idHolders["pic3pic"]["header"] : false;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $this->title; ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' 
              name='viewport'>
        <script src="<?php echo $this->config["URL"] . 
                $this->config["VIEWS"] . 
                $this->config["ASSSET_PLG"].
                $this->config["PLG_16"]; ?>jQuery-2.1.4.min.js" 
        type="text/javascript"></script>
        <script src="<?php echo $this->config["URL"] . 
                $this->config["VIEWS"] . 
                $this->config["ASSSET_PIC"]; ?>config.js" 
        type="text/javascript"></script>

    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <nav class="navbar navbar-default">
                    <div class="navbar-header">
                        <button type="button" 
                                class="navbar-toggle collapsed" 
                                data-toggle="collapse" 
                                data-target="#bs-example-navbar-collapse-1" 
                                aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" 
                           href="<?php echo $this->config["URL"] . $this->config["CTRL_7"]; ?>">pic3pic</a>
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li class="border-left-black border-right-black concept">
                                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_8"]; ?>">
                                    Popular
                                </a>
                            </li>
                            <li class="border-right-black concept">
                                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_9"]; ?>">
                                    New
                                </a>
                            </li>
                            <li class="border-right-black concept" 
                                style="cursor:pointer;">                
                                <a id="<?php echo $this->idHolders["pic3pic"]["header"]["filter"]["list"]["parentBut"]; ?>" 
                                   name="<?php echo $this->idHolders["pic3pic"]["header"]["filter"]["list"]["parentBut"]; ?>" 
                                   data-toggle="modal" 
                                   data-target="#<?php echo $this->idHolders["pic3pic"]["header"]["filter"]["list"]["parentDiv"]; ?>" 
                                   data-whatever="@mdo">
                                    Filter <i class="fa fa-filter fa-fw"></i>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <?php if (isset($_SESSION["USERDATA"]["loggedin"]) && $_SESSION["USERDATA"]["loggedin"] == 1): ?>
                                <li class="gap-right sm-pad-top">
                                    <button type="button" id="logoutPic3pic"
                                            class="btn btn-danger sm-height">
                                        <i class="fa fa-sign-in"> 
                                            Logout
                                        </i>
                                    </button>
                                </li>
                            <?php else: ?>
                                <li class="gap-right sm-pad-top">
                                    <button type="button" 
                                            data-toggle="modal" 
                                            data-target="#<?php echo $header["login"]["target"]; ?>" 
                                            data-whatever="@mdo" 
                                            class="btn btn-success sm-height" 
                                            id="<?php echo $header["login"]["but"]; ?>">
                                        <i class="fa fa-sign-in"> 
                                            Login
                                        </i>
                                    </button>
                                </li>
                                <li class="gap-right sm-pad-top">
                                    <button type="button" 
                                            data-toggle="modal" 
                                            data-target="#<?php echo $header["register"]["target"]; ?>" 
                                            data-whatever="@mdo" 
                                            class="btn btn-primary sm-height" 
                                            id="<?php echo $header["register"]["but"]; ?>">
                                        <i class="fa fa-pencil-square-o"> 
                                            Register
                                        </i>
                                    </button>
                                </li>
                            <?php endif; ?>
                            <li class="gap-right sm-pad-top">
                                <button type="button" 
                                        onClick="window.location.href = '<?php echo $header["about"]["url"]; ?>';" 
                                        class="btn btn-info sm-height" 
                                        id="<?php echo $header["about"]["but"]; ?>">
                                    <i class="fa fa-info-circle"> About</i>
                                </button>
                            </li>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </nav>
            </div><!-- /.container-fluid -->
        </nav><!-- end of nav-->
        <?php
        require_once 'postFilter.php';
        ?>
        <div class="row"><div class="col-lg-12">&nbsp;</div></div>