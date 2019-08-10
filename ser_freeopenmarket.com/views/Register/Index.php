<?php
$index = isset($this->idHolders["onlinefood"]["index"]) ? (array) $this->idHolders["onlinefood"]["index"] : false;
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Register
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_0"]; ?>">
                    <i class="fa fa-dashboard"></i> Home
                </a>
            </li>
            <li class="active">Register</li>
        </ol>
    </section>
    <section class="content">
        <?php
        require_once 'Register.php';
        ?>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->