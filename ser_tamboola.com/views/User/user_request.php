<?php
$userReq = isset($this->idHolders["tamboola"]["user"]["Request"]) ? (array) $this->idHolders["tamboola"]["user"]["Request"] : false;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            New Registrations
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"> New Registrations </li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li><a href="#new" data-toggle="tab" id="<?php echo $userReq["but1"]; ?>">New Registration Request</a></li>
                        <li><a href="#accepted" data-toggle="tab" id="<?php echo $userReq["but2"]; ?>">Accepted Request</a></li>
                        <li><a href="#rejected" data-toggle="tab" id="<?php echo $userReq["but3"]; ?>">Rejected Request</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="new">
                            <?php
                            require_once 'user_request_new.php';
                            ?>
                        </div><!-- /.tab-pane -->
                        <div class="tab-pane" id="accepted">
                            <?php
                            require_once 'user_request_accepted.php';
                            ?>
                        </div><!-- /.tab-pane -->
                        <div class="tab-pane" id="rejected">
                            <?php
                            require_once 'user_request_rejected.php';
                            ?>
                        </div><!-- /.tab-pane -->
                    </div><!-- /.nav-tabs-custom -->
                </div><!-- /.col -->
            </div><!-- /.row -->
    </section><!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script type="text/javascript">
    $(document).ready(function () {
        var this_js_script = $("script[src$='User.js']");
        if (this_js_script) {
            var flag = this_js_script.attr('data-autoloader');
            if (flag === 'true') {
                LogMessages('I am In User Personal');
                var para = getJSONIds({
                    autoloader: true,
                    action: 'getIdHolders',
                    url: URL + 'User/getIdHolders',
                    type: 'POST',
                    dataType: 'JSON'
                }).tamboola.user;
                var obj = new userController();
                obj.__constructor(para);
                obj.__ListUserRequests();
            }
            else {
                LogMessages('I am Out User Personal');
            }
        }
    });
</script>