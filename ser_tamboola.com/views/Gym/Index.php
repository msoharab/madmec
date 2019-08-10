<?php
$gym = isset($this->idHolders["tamboola"]["gym"]) ? (array) $this->idHolders["tamboola"]["gym"] : false;
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
                            <li><a href="#list" data-toggle="tab">List Gym</a></li>
                            <li><a href="#assign" data-toggle="tab">Assign Gym</a></li>
                            <li><a href="#subs" data-toggle="tab">Gym Request</a></li>
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
<script type="text/javascript">
    $(document).ready(function() {
        var this_js_script = $("script[src$='Gym.js']");
        if (this_js_script) {
            var flag = this_js_script.attr('data-autoloader');
            if (flag === 'true') {
                LogMessages('I am In Gym');
                var para = getJSONIds({
                    autoloader: true,
                    action: 'getIdHolders',
                    url: URL + 'Gym/getIdHolders',
                    type: 'POST',
                    dataType: 'JSON'
                }).tamboola.gym;
                var obj = new gymController();
                obj.__constructor(para);
                obj.__AddGym();
            }
            else {
                LogMessages('I am Out Gym');
            }
        }
    });
</script>
