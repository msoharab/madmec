<?php
$rechTechRest = isset($this->idHolders["onlinefood"]["gateway"]["RechargeTechnical"]["Rest"]) ? (array) $this->idHolders["onlinefood"]["gateway"]["RechargeTechnical"]["Rest"] : false;
$rechTechXml = isset($this->idHolders["onlinefood"]["gateway"]["RechargeTechnical"]["Xmlrpc"]) ? (array) $this->idHolders["onlinefood"]["gateway"]["RechargeTechnical"]["Xmlrpc"] : false;
$rechTechSoap = isset($this->idHolders["onlinefood"]["gateway"]["RechargeTechnical"]["Soap"]) ? (array) $this->idHolders["onlinefood"]["gateway"]["RechargeTechnical"]["Soap"] : false;
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Technical
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Recharge Gateway</a></li>
            <li class="active">Technical</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#addrest" data-toggle="tab">REST</a></li>
                        <li><a href="#addxmlrpc" data-toggle="tab">XMLRPC</a></li>
                        <li><a href="#addsoap" data-toggle="tab">SOAP</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="addrest">
                            <!-- Post -->
                            <form class="form-horizontal"
                                  action=""
                                  id="<?php echo $rechTechRest["form"]; ?>"
                                  name="<?php echo $rechTechRest["form"]; ?>"
                                  method="post">
                                <div class="form-group">
                                    <section class="content-header">
                                        <h1>
                                            Rest Protocol
                                        </h1>
                                    </section>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="addxmlrpc">
                            <!-- The timeline -->
                            <form class="form-horizontal"
                                  action=""
                                  id="<?php echo $rechTechXml["form"]; ?>"
                                  name="<?php echo $rechTechXml["form"]; ?>"
                                  method="post">
                                <div class="form-group">
                                    <!-- Content Header (Page header) -->
                                    <section class="content-header">
                                        <h1>
                                            XmlRpc Protocol
                                        </h1>
                                    </section>
                                    <div class="content-header">
                                        <h1>Phase 2</h1>
                                    </div>
                                </div>
                            </form>
                        </div><!-- /.tab-pane -->
                        <div class="tab-pane" id="addsoap">
                            <form class="form-horizontal"
                                  action=""
                                  id="<?php echo $rechTechSoap["form"]; ?>"
                                  name="<?php echo $rechTechSoap["form"]; ?>"
                                  method="post">
                                <div class="form-group">
                                    <!-- Content Header (Page header) -->
                                    <section class="content-header">
                                        <h1>
                                            Soap Protocol
                                        </h1>
                                    </section>
                                    <!-- Main content -->
                                    <div class="content-header">
                                        <h1>Phase 2</h1>
                                    </div>
                                </div>
                            </form>
                        </div><!-- /.tab-pane -->
                    </div><!-- /.tab-content -->
                </div><!-- /.nav-tabs-custom -->
            </div><!-- /.col -->
        </div><!-- /.row -->

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->



