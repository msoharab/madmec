<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Operator / Operator type List
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_0"]; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Operator / Operator type List</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#oprlist" data-toggle="tab">Operator</a></li>
                        <li><a href="#oprtylist" data-toggle="tab">Operator Type</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="oprlist">
                            <?php
                            require_once 'list_operators.php';
                            ?>
                        </div><!-- /.tab-content -->
                        <div class="tab-pane" id="oprtylist">
                            <?php
                            require_once 'list_operator_type.php';
                            ?>
                        </div>
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
        obj.__ListOpt();
    });
</script>