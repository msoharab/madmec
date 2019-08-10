<?php
$index = isset($this->idHolders["onlinefood"]["index"]) ? (array) $this->idHolders["onlinefood"]["index"] : false;
$register = isset($this->idHolders["pic3pic"]["index"]["register"]) ? (array) $this->idHolders["pic3pic"]["index"]["register"] : false;
$facebook = isset($this->idHolders["pic3pic"]["index"]["facebook"]) ? (array) $this->idHolders["pic3pic"]["index"]["facebook"] : false;
$googleplus = isset($this->idHolders["pic3pic"]["index"]["googleplus"]) ? (array) $this->idHolders["pic3pic"]["index"]["googleplus"] : false;
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
