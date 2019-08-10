<div class="content-wrapper">
    <section class="content-header">
        <h1>
           Gateway Operator
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_0"]; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Gateway Operator</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#act1" data-toggle="tab">Operator</a></li>
                        <li><a href="#act2" data-toggle="tab">Operator Type</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="act1">
                            <?php
                            require_once 'operator.php';
                            ?>
                        </div>
                        <div class="tab-pane" id="act2">
                            <?php
                            require_once 'operator_type.php';
                            ?>
                        </div><!-- /.tab-content -->
                    </div><!-- /.nav-tabs-custom -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script type="text/javascript">
    $(document).ready(function () {
        var para = getJSONIds({
            autoloader: true,
            action: 'getIdHolders',
            url: URL + 'Gateway/getIdHolders',
            type: 'POST',
            dataType: 'JSON'
        }).onlinefood.gateway;
        var obj = new gatewayController();
        obj.__constructor(para);
        obj.__AddOpt();
    });
</script>