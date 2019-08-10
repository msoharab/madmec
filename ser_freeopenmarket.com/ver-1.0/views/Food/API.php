<?php
$apiPersonal = isset($this->idHolders["onlinefood"]["api"]["ApiPersonal"]) ? (array) $this->idHolders["onlinefood"]["api"]["ApiPersonal"] : false;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Personal Details
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_0"]; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"> Personal Details </li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#add" data-toggle="tab">Add User</a></li>
                        <li><a href="#list" data-toggle="tab">List User</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="add">
                            <?php
                            require_once 'api_personal_form.php';
                            ?>
                        </div><!-- /.tab-content -->
                        <div class="tab-pane" id="list">
                            <?php
                            require_once 'api_personal_list.php';
                            ?>
                        </div>
                    </div><!-- /.nav-tabs-custom -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>
    </section>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var this_js_script = $("script[src$='API.js']");
        if (this_js_script) {
            var flag = this_js_script.attr('data-autoloader');
            if (flag === 'true') {
                LogMessages('I am In User Personal');
                var para = getJSONIds({
                    autoloader: true,
                    action: 'getIdHolders',
                    url: URL + 'API/getIdHolders',
                    type: 'POST',
                    dataType: 'JSON'
                }).onlinefood.api;
                var obj = new APIController();
                obj.__constructor(para);
                obj.__AddUser();
            }
            else {
                LogMessages('I am Out User Personal');
            }
        }
    });

</script>