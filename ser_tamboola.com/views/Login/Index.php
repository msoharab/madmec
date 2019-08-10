<?php
$index = isset($this->idHolders["tamboola"]["index"]) ? (array) $this->idHolders["tamboola"]["index"] : false;
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Login
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Login</li>
        </ol>
    </section>
    <section class="content">
        <?php
        require_once 'Login.php';
        ?>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->