<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Product Sale Details
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
                    <div class="tab-content1">
                        <div class="tab-pane active" id="add">
                            <div class="col-sm-5">
                                <?php
                                require_once 'Product_Sale.php';
                                ?>
                            </div>
                            <div class="col-sm-7" style="padding-top: 16px">
                                <?php
                                require_once 'Product_SaleList.php';
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
