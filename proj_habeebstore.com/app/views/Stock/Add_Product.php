<?php
$Prodt = isset($this->idHolders["shop"]["stock"]["AddProduct"]) ? (array) $this->idHolders["shop"]["stock"]["AddProduct"] : false;
?>
<form class="form-horizontal"
      action=""
      id="<?php echo $Prodt["form"]; ?>"
      name="<?php echo $Prodt["form"]; ?>"
      method="post">
    <div class="content">
        <section class="content-header">
            <h1>
                Add Product Details
                <small></small>
            </h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <!--<h3 class="box-title"><strong>Business Details</strong></h3>-->
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="inputbusiness" class="col-sm-1 control-label">Product Name</label>
                                    <div class="col-sm-11">
                                        <input class="form-control"
                                               id="<?php echo $Prodt["fields"][0]; ?>"
                                               name="<?php echo $Prodt["fields"][0]; ?>"
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
                                               id="<?php echo $Prodt["fields"][1]; ?>"
                                               name="<?php echo $Prodt["fields"][1]; ?>"
                                               data-rules='{"required": true}'
                                               data-messages='{"required": "Enter Product Rate"}'
                                               placeholder="Rate" type="number">
                                    </div>
                                    <label for="inputbusinessdate" class="col-sm-1 control-label">Weight/Units</label>
                                    <div class="col-sm-5">
                                        <select class="form-control"
                                                id="<?php echo $Prodt["fields"][2]; ?>"
                                                name="<?php echo $Prodt["fields"][2]; ?>"
                                                data-rules='{"required": true}'
                                                data-messages='{"required": "Select User"}'>
                                            <option>Per Kg</option>
                                            <option>Per Unit</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-5 col-sm-10">
                            <button type="submit"
                                    class="btn btn-primary"
                                    id="<?php echo $Prodt["fields"][3]; ?>"
                                    name="<?php echo $Prodt["fields"][3]; ?>"
                                    data-rules='{}'
                                    data-messages='{}'><strong>Submit Details</strong></button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</form>
