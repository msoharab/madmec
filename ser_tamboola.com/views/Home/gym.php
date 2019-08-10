<?php
$gym = isset($this->idHolders["tamboola"]["home"]) ? (array) $this->idHolders["tamboola"]["home"] : false;
?>
<div class="content-wrapper">
    <div class="content">
        <section class="content-header">
            <h1>
                Gym
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>">
                        <i class="fa fa-dashboard"></i> Dashboard
                    </a>
                </li>
                <li class="active">Gym</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#add" data-toggle="tab">Add Gym</a></li>
                            <li><a href="#list" data-toggle="tab" id="<?php echo $gym["ListGym"]["btnDiv"]; ?>">List Gym</a></li>
                            <li><a href="#assign" data-toggle="tab" id="<?php echo $gym["AssignGym"]["btnDiv"];  ?>">Assign Gym</a></li>
                            <li><a href="#subs" data-toggle="tab" id="<?php echo $gym["Request"]["btnDiv"];  ?>">Gym Request</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="active tab-pane" id="add">
                                <?php
                                require_once 'gymAdd.php';
                                ?>
                            </div>
                            <div class="tab-pane" id="assign">
                                <?php
                                require_once 'assginGym.php';
                                ?>
                            </div>
                            <div class="tab-pane" id="subs">
                                <?php
                                require_once 'gymRequest.php';
                                ?>
                            </div><!-- /.tab-pane -->
                            <div class="tab-pane" id="list">
                                <?php
                                require_once 'listGym.php';
                                ?>
                            </div><!-- /.tab-pane -->
                        </div><!-- /.tab-content -->
                    </div><!-- /.nav-tabs-custom -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div>
</div>
<script data-autoloader="false" type="text/javascript" src="<?php echo $this->config["URL"] . $this->config["VIEWS"] . $this->config["ASSSET_REG"] . $this->config["CONTROLLERS"]; ?>Gym.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var para = getJSONIds({
            autoloader: true,
            action: 'getIdHolders',
            url: URL + 'Home/getIdHolders',
            type: 'POST',
            dataType: 'JSON'
        }).tamboola;
        var obj = new homeController();
        obj.__constructor(para);
        obj.__AddGym();
    });
</script>
