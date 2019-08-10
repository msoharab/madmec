<?php ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Gateway
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_0"]; ?>">
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li class="active">Gateway</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <?php
        require_once 'recharge_business.php';
        ?>
    </section><!-- /.content -->
</div>
<!-- /.content-wrapper -->
