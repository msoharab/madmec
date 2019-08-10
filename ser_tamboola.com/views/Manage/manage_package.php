<?php
$AddPackages = isset($this->idHolders["tamboola"]["manage"]["AddPackages"]) ? (array) $this->idHolders["tamboola"]["manage"]["AddPackages"] : false;
$PersPackages = isset($this->idHolders["tamboola"]["manage"]["ListPackages"]["PersonalPack"]) ? (array) $this->idHolders["tamboola"]["manage"]["ListPackages"]["PersonalPack"] : false;
$NutriPackages = isset($this->idHolders["tamboola"]["manage"]["ListPackages"]["NutritionPack"]) ? (array) $this->idHolders["tamboola"]["manage"]["ListPackages"]["NutritionPack"] : false;
$FitPackages = isset($this->idHolders["tamboola"]["manage"]["ListPackages"]["FitnessPack"]) ? (array) $this->idHolders["tamboola"]["manage"]["ListPackages"]["FitnessPack"] : false;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo ucfirst($this->GymDets["gymname"]); ?> - Packages
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"> Packages </li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#add" data-toggle="tab">Add Package</a></li>
                        <li><a href="#list" data-toggle="tab">List Package</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="add">
                            <?php
                            require_once 'manage_add_package.php';
                            ?>
                        </div><!-- /.tab-content -->
                        <div class="tab-pane" id="list">
                            <?php
                            require_once 'manage_list_package.php';
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
        var this_js_script = $("script[src$='Manage.js']");
        if (this_js_script) {
            var flag = this_js_script.attr('data-autoloader');
            if (flag === 'true') {
                LogMessages('I am In Manage');
                var para = getJSONIds({
                    autoloader: true,
                    action: 'getIdHolders',
                    url: URL + 'Manage/getIdHolders',
                    type: 'POST',
                    dataType: 'JSON'
                }).tamboola.manage;
                var obj = new manageController();
                obj.__constructor(para);
                obj.__AddPackage();
            }
            else {
                LogMessages('I am Out Manage');
            }
        }
    });
</script>