<?php
$UsrProf = isset($this->idHolders["recharge"]["masterdata"]["ListUserProof"]) ? (array) $this->idHolders["recharge"]["masterdata"]["ListUserProof"] : false;
$UsrType = isset($this->idHolders["recharge"]["masterdata"]["ListUserTypes"]) ? (array) $this->idHolders["recharge"]["masterdata"]["ListUserTypes"] : false;
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Users
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Users</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Folders</h3>
                        <div class="box-tools">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <ul class="nav nav-pills nav-stacked">
                            <li class="active">
                                <a href="#utype" data-toggle="tab">
                                    <i class="fa fa-users"></i>
                                    User Types
                                    <span class="label label-primary pull-right">&nbsp;</span>
                                </a>
                            </li>
                        </ul>
                    </div><!-- /.box-body -->
                </div><!-- /. box -->
            </div><!-- /.col -->
            <div class="col-md-9">
                <div class="tab-content">
                    <div class="active tab-pane" id="utype">
                        <h3>
                            User Types
                        </h3>
                        <?php
                        require_once 'user_type.php';
                        ?>
                    </div>
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div>
<!--<script type="text/javascript">
    $(document).ready(function () {
        var para = getJSONIds({
            autoloader: true,
            action: 'getIdHolders',
            url: URL + 'MasterData/getIdHolders',
            type: 'POST',
            dataType: 'JSON'
        }).tamboola.masterdata;
        var obj = new masterdataController();
        obj.__constructor(para);
        obj.__User();
    });
</script>-->