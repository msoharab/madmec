<?php
//$userPersonal = isset($this->idHolders["tamboola"]["user"]["Personal"]) ? (array) $this->idHolders["tamboola"]["user"]["Personal"] : false;
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
                        <li><a href="#list" data-toggle="tab">List Offer</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="add">
                            <?php
                            require_once 'manage_add_offer.php';
                            ?>
                        </div><!-- /.tab-content -->
                        <div class="tab-pane" id="list">
                            <?php
                            require_once 'manage_list_offer.php';
                            ?>
                        </div>
                    </div><!-- /.nav-tabs-custom -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>
    </section>
</div>