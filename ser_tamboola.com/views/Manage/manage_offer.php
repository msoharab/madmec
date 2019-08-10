<?php
$AddOffers = isset($this->idHolders["tamboola"]["manage"]["AddOffers"]) ? (array) $this->idHolders["tamboola"]["manage"]["AddOffers"] : false;
$ListOffers1 = isset($this->idHolders["tamboola"]["manage"]["ListOffers1"]) ? (array) $this->idHolders["tamboola"]["manage"]["ListOffers1"] : false;
$ListOffers2 = isset($this->idHolders["tamboola"]["manage"]["ListOffers2"]) ? (array) $this->idHolders["tamboola"]["manage"]["ListOffers2"] : false;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo ucfirst($this->GymDets["gymname"]); ?> - Offers
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"> Offers </li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#add" data-toggle="tab">Add Offer</a></li>
                        <li><a href="#list1" data-toggle="tab" id="<?php echo $ListOffers1["btnDiv"]; ?>">Edit / Deactivate offer</a></li>
                        <li><a href="#list2" data-toggle="tab" id="<?php echo $ListOffers2["btnDiv"]; ?>">Edit / Activate offer</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="add">
                            <?php
                            require_once 'manage_add_offer.php';
                            ?>
                        </div><!-- /.tab-content -->
                        <div class="tab-pane" id="list1">
                            <?php
                            //var_dump($this->idHolders["tamboola"]["manage"]);
                            $ListOffers = isset($this->idHolders["tamboola"]["manage"]["ListOffers1"]) ? (array) $this->idHolders["tamboola"]["manage"]["ListOffers1"] : false;
                            require 'manage_list_offer.php';
                            ?>
                        </div>
                        <div class="tab-pane" id="list2">
                            <?php
                            $ListOffers = isset($this->idHolders["tamboola"]["manage"]["ListOffers2"]) ? (array) $this->idHolders["tamboola"]["manage"]["ListOffers2"] : false;
                            require 'manage_list_offer.php';
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
                obj.__AddOffer();
            }
            else {
                LogMessages('I am Out Manage');
            }
        }
    });
</script>