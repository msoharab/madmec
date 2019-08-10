<?php
$userBusiness = isset($this->idHolders["tamboola"]["user"]["Business"]) ? (array) $this->idHolders["tamboola"]["user"]["Business"] : false;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Business Details
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Users</li>
            <li class="active">Business Details</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#add" data-toggle="tab"><strong>Add Details</strong></a></li>
                        <li><a href="#list" data-toggle="tab"><strong>List Details</strong></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="add">
                            <?php
                            require_once 'user_business_form.php';
                            ?>
                        </div>
                        <div class="tab-pane" id="list">
                            <?php
                            require_once 'user_business_list.php';
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var this_js_script = $("script[src$='User.js']");
        if (this_js_script) {
            var flag = this_js_script.attr('data-autoloader');
            if (flag === 'true') {
                LogMessages('I am In User business');
                var para = getJSONIds({
                    autoloader: true,
                    action: 'getIdHolders',
                    url: URL + 'User/getIdHolders',
                    type: 'POST',
                    dataType: 'JSON'
                }).tamboola.user;
                var obj = new userController();
                obj.__constructor(para);
                obj.__AddBusinessUser();
            }
            else {
                LogMessages('I am Out User business');
            }
        }
    });
</script>
