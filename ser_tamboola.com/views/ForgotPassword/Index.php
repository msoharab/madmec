<?php
$index = isset($this->idHolders["tamboola"]["index"]) ? (array) $this->idHolders["tamboola"]["index"] : false;
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Forgot Password
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Forgot Password</li>
        </ol>
    </section>
    <section class="content">
        <?php
        require_once 'ForgotPassword.php';
        ?>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->