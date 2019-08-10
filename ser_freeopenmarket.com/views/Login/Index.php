<?php
$index = isset($this->idHolders["onlinefood"]["index"]) ? (array) $this->idHolders["onlinefood"]["index"] : false;
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Login
        </h1>
        <ol class="breadcrumb">
            <li class="active">Login</li>
        </ol>
    </section>
    <section class="content">
        <?php
        require_once 'Login.php';
        ?>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
