<?php
$Prodt = isset($this->idHolders["shop"]["sales"]["ProductKg"]) ? (array) $this->idHolders["shop"]["sales"]["ProductKg"] : false;
$Produt = isset($this->idHolders["shop"]["sales"]["ProductUnit"]) ? (array) $this->idHolders["shop"]["sales"]["ProductUnit"] : false;
?>
<div class="content">
    <section class="content-header">
        <h1>
            Sale Details
            <small></small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
<!--                            <h3 class="box-title"><strong>Business Details</strong></h3>-->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="col-sm-12">
                            <h3 class="box-title"><strong>Products In Kg</strong></h3>
                            <form class="form-horizontal"
                                  action=""
                                  id="<?php echo $Prodt["form"]; ?>"
                                  name="<?php echo $Prodt["form"]; ?>"
                                  method="post">
                                <div class="form-group">
                                    <label for="inputbusiness" class="col-sm-2 control-label">Product Name</label>
                                    <div class="col-sm-8">
                                        <select class="form-control"
                                                id="<?php echo $Prodt["fields"][0]; ?>"
                                                name="<?php echo $Prodt["fields"][0]; ?>"
                                                data-rules='{"required": true}'
                                                data-messages='{"required": "Select Product"}'
                                                placeholder="Product Name" type="text">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputbusinessdate" class="col-sm-1 control-label">KG</label>
                                    <div class="col-sm-5">
                                        <input class="form-control"
                                               id="<?php echo $Prodt["fields"][1]; ?>"
                                               name="<?php echo $Prodt["fields"][1]; ?>"
                                               data-rules='{"required": true}'
                                               data-messages='{"required": "Enter Quantity"}'
                                               placeholder="Kg" value="0" type="number">
                                    </div>
                                    <label for="inputbusinessdate" class="col-sm-2 control-label">Grams</label>
                                    <div class="col-sm-4">
                                        <input class="form-control"
                                               id="<?php echo $Prodt["fields"][2]; ?>"
                                               name="<?php echo $Prodt["fields"][2]; ?>"
                                               data-rules='{"required": true,"maxlength": "3"}'
                                               data-messages='{"required": "Enter Quantity","maxlength": "Length Should be minimum 3 Characters"}'
                                               placeholder="Grams" value="0" type="number">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-2">
                                        <button type="submit"
                                                class="btn btn-primary"
                                                id="<?php echo $Prodt["fields"][3]; ?>"
                                                name="<?php echo $Prodt["fields"][3]; ?>"
                                                data-rules='{}'
                                                data-messages='{}'><strong>Done</strong></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-12">
                            <h3 class="box-title"><strong>Products In Unit</strong></h3>
                            <form class="form-horizontal"
                                  action=""
                                  id="<?php echo $Produt["form"]; ?>"
                                  name="<?php echo $Produt["form"]; ?>"
                                  method="post">
                                <div class="form-group">
                                    <label for="inputbusiness" class="col-sm-2 control-label">Product Name</label>
                                    <div class="col-sm-8">
                                        <select class="form-control"
                                                id="<?php echo $Produt["fields"][0]; ?>"
                                                name="<?php echo $Produt["fields"][0]; ?>"
                                                data-rules='{"required": true}'
                                                data-messages='{"required": "Select Product"}'
                                                placeholder="Product Name" type="text">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputbusinessdate" class="col-sm-2 control-label">Quantity</label>
                                    <div class="col-sm-8">
                                        <input class="form-control"
                                               id="<?php echo $Produt["fields"][1]; ?>"
                                               name="<?php echo $Produt["fields"][1]; ?>"
                                               data-rules='{"required": true}'
                                               data-messages='{"required": "Enter Product Rate"}'
                                               placeholder="Quantity" value="0" type="number">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-2">
                                        <button type="submit"
                                                class="btn btn-primary"
                                                id="<?php echo $Produt["fields"][2]; ?>"
                                                name="<?php echo $Produt["fields"][2]; ?>"
                                                data-rules='{}'
                                                data-messages='{}'><strong>Done</strong></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.box-body -->
                </div>
            </div>
        </div>
    </section>
</div>
