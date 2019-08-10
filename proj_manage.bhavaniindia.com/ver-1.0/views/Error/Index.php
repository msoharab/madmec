<?php
$index = isset($this->idHolders["ricepark"]["index"]) ? (array) $this->idHolders["ricepark"]["index"] : false;
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Error
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_9"]; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Error</li>
        </ol>
    </section>
    <section class="content">
        This is an error.
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
