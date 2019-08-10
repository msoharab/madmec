<?php
$index = isset($this->idHolders["shop"]["index"]) ? (array) $this->idHolders["shop"]["index"] : false;
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
    </section>
</div>
