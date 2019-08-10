<?php
$prd = isset($this->idHolders["shop"]["stock"]["EditProduct"]) ? (array) $this->idHolders["shop"]["stock"]["EditProduct"] : false;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Product
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->config["EGPCSURL"] . $this->config["CTRL_19"]; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"> Edit Product </li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal"
                      action=""
                      id="<?php echo $prd["form"]; ?>"
                      name="<?php echo $prd["form"]; ?>"
                      method="post">
                    <div class="box">
                        <div class="box-header with-border">
                            <section class="content-header">
                                <h1>
                                    Product Details
                                </h1>
                            </section>
                        </div>
                        <div class="box-body">
                            <input type="hidden"
                                   name="<?php echo $prd["fields"][4]; ?>"
                                   id="<?php echo $prd["fields"][4]; ?>"
                                   data-rules='{}'
                                   data-messages='{}'
                                   value="<?php echo base64_encode($this->getuserDet["data"]["id"]); ?>" />
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="inputbusiness" class="col-sm-1 control-label">Product Name</label>
                                    <div class="col-sm-11">
                                        <input class="form-control"
                                               id="<?php echo $prd["fields"][0]; ?>"
                                               name="<?php echo $prd["fields"][0]; ?>"
                                               value="<?php echo trim($this->getuserDet["data"]["name"]); ?>"
                                               data-rules='{"required": true,"minlength": "3"}'
                                               data-messages='{"required": "Enter Prduct Name","minlength": "Length Should be minimum 3 numbers"}'
                                               placeholder="Product Name" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="inputbusinessdate" class="col-sm-1 control-label">Product Rate</label>
                                    <div class="col-sm-5">
                                        <input class="form-control"
                                               id="<?php echo $prd["fields"][1]; ?>"
                                               name="<?php echo $prd["fields"][1]; ?>"
                                               value="<?php echo trim($this->getuserDet["data"]["cost"]); ?>"
                                               data-rules='{"required": true}'
                                               data-messages='{"required": "Enter Product Rate"}'
                                               placeholder="Rate" type="number">
                                    </div>
                                    <label for="inputbusinessdate" class="col-sm-1 control-label">Weight/Units</label>
                                    <div class="col-sm-5">
                                        <select class="form-control"
                                                id="<?php echo $prd["fields"][2]; ?>"
                                                name="<?php echo $prd["fields"][2]; ?>"
                                                data-rules='{"required": true}'
                                                data-messages='{"required": "Select Weight"}'>
                                                    <?php
                                                    if (trim($this->getuserDet["data"]["weight"]) == "Per Kg") {
                                                        echo '<option selected="selected">Per Kg</option>
                                                        <option>Per Unit</option>';
                                                    } else {
                                                        echo '<option>Per Kg</option>
                                                        <option selected="selected">Per Unit</option>';
                                                    }
                                                    ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 form-group">
                                <div class="text-center">
                                    <button type="submit"
                                            id="<?php echo $prd["fields"][3]; ?>"
                                            name="<?php echo $prd["fields"][3]; ?>"
                                            data-rules='{}'
                                            data-messages='{}'
                                            class="btn btn-danger">Update Product</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div><!-- /.row -->
        </div>
    </section>
</div>
<script>$(document).ready(function () {
        var this_js_script = $("script[src$='Stock.js']");
        if (this_js_script) {
            var flag = this_js_script.attr('data-autoloader');
            if (flag === 'true') {
                LogMessages('I am In Stock');
                var para = getJSONIds({
                    autoloader: true,
                    action: 'getIdHolders',
                    url: EGPCSURL + 'Stock/getIdHolders',
                    type: 'POST',
                    dataType: 'JSON'
                }).shop.stock;
                var obj = new stockController();
                obj.__constructor(para);
                obj.__ProductEdit();
            }
            else {
                LogMessages('I am Out Stock');
            }
        }
    });
</script>