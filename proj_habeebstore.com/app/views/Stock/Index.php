<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Product Details
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->config["EGPCSURL"] . $this->config["CTRL_19"]; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Stock</li>
            <li class="active">Product Details</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#list" data-toggle="tab"><strong>List Details</strong></a></li>
                        <li><a href="#add" data-toggle="tab"><strong>Add Details</strong></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane" id="add">
                            <?php
                            require_once 'Add_Product.php';
                            ?>
                        </div>
                        <div class="tab-pane active" id="list">
                            <?php
                            require_once 'List_Products.php';
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
