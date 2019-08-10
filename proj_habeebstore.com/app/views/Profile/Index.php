<?php
$Prof = isset($this->idHolders["shop"]["profile"]["ChangePassword"]) ? (array) $this->idHolders["shop"]["profile"]["ChangePassword"] : false;
$Profpic = isset($this->idHolders["shop"]["profile"]["ChangeProfile"]) ? (array) $this->idHolders["shop"]["profile"]["ChangeProfile"] : false;
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Profile
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->config["EGPCSURL"] . $this->config["CTRL_19"]; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Profile</li>
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
                                    <i class="fa fa-key"></i>
                                    Change Profile
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
                            Change Profile
                        </h3>
                        <?php
                        require_once 'change_password.php';
                        ?>
                    </div>
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div>
