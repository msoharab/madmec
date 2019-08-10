<?php
$AddOffers = isset($this->idHolders["tamboola"]["manage"]["EditOffers"]) ? (array) $this->idHolders["tamboola"]["manage"]["EditOffers"] : false;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Offers
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
                        <li class="active"><a href="#add" data-toggle="tab">Edit Offer</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="add">
                            <div class="content">
                                <form class="form-horizontal"
                                      action=""
                                      id="<?php echo $AddOffers["form"]; ?>"
                                      name="<?php echo $AddOffers["form"]; ?>"
                                      method="post">
                                    <div class="content">
                                        <section class="content">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="box">
                                                        <div class="box-header with-border">
                                                            <h3 class="box-title with-border"><strong>Add Offer</strong></h3>
                                                        </div>
                                                        <div class="box-body" id="userbox">
                                                            <div class="col-sm-12">
                                                                <input type="hidden"
                                                                       class="form-control"
                                                                       id="<?php echo $AddOffers["fields"][7]; ?>"
                                                                       name="<?php echo $AddOffers["fields"][7]; ?>"
                                                                       data-rules='{}'
                                                                       data-messages='{}'
                                                                       value="<?php echo $this->ManageDets["data"]["offid"]; ?>" />
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <label for="inputphone" class="col-sm-1 control-label">Name Of The Offer</label>
                                                                        <div class="col-sm-5">
                                                                            <input type="text"
                                                                                   class="form-control"
                                                                                   id="<?php echo $AddOffers["fields"][0]; ?>"
                                                                                   name="<?php echo $AddOffers["fields"][0]; ?>"
                                                                                   data-rules='{"required": true}'
                                                                                   data-messages='{"required": "Enter Offer Name"}'
                                                                                   value="<?php echo $this->ManageDets["data"]["offname"]; ?>" />
                                                                        </div>
                                                                        <label for="inputgymtype" class="col-sm-1 control-label">Duration</label>
                                                                        <div class="col-sm-5">
                                                                            <select class="form-control"
                                                                                    id="<?php echo $AddOffers["fields"][1]; ?>"
                                                                                    name="<?php echo $AddOffers["fields"][1]; ?>"
                                                                                    data-rules='{"required": true}'
                                                                                    data-messages='{"required": "Select Duration"}'
                                                                                    value="<?php echo $this->ManageDets["data"]["offdura"]; ?>">
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12">
                                                                    <div class="form-group">
                                                                        <label for="inputphone" class="col-sm-1 control-label">Minimum Members</label>
                                                                        <div class="col-sm-5">
                                                                            <select class="form-control"
                                                                                    id="<?php echo $AddOffers["fields"][2]; ?>"
                                                                                    name="<?php echo $AddOffers["fields"][2]; ?>"
                                                                                    data-rules='{"required": true}'
                                                                                    data-messages='{"required": "Select Value"}'
                                                                                    value="<?php echo $this->ManageDets["data"]["offmem"]; ?>">
                                                                            </select>
                                                                        </div>
                                                                        <label for="inputgymtype" class="col-sm-1 control-label">Facility Type</label>
                                                                        <div class="col-sm-5">
                                                                            <select class="form-control"
                                                                                    id="<?php echo $AddOffers["fields"][3]; ?>"
                                                                                    name="<?php echo $AddOffers["fields"][3]; ?>"
                                                                                    data-rules='{"required": true}'
                                                                                    data-messages='{"required": "Select Facility Name"}'
                                                                                    value="<?php echo $this->ManageDets["data"]["offfaci"]; ?>">
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="box collapsed-box">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title"><strong>Price / Description Of The Offer</strong></h3>
                                                    <div class="box-tools pull-right">
                                                        <button class="btn btn-box-tool" id="id" name="" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                                    </div><!-- /.box-tools -->
                                                </div><!-- /.box-header -->
                                                <div class="box-body" id="addbox">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="inputgymName" class="col-sm-2 control-label">Price Of The Offer</label>
                                                            <div class="col-sm-8">
                                                                <input type="text"
                                                                       class="form-control"
                                                                       id="<?php echo $AddOffers["fields"][4]; ?>"
                                                                       name="<?php echo $AddOffers["fields"][4]; ?>"
                                                                       data-rules='{"required": true}'
                                                                       data-messages='{"required": "Enter Price"}'
                                                                       required="required"
                                                                       maxlength="10"
                                                                       value="<?php echo $this->ManageDets["data"]["offcost"]; ?>" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="inputsertax" class="col-sm-2 control-label">Description</label>
                                                            <div class="col-sm-8">
                                                                <textarea class="form-control"
                                                                          id="<?php echo $AddOffers["fields"][5]; ?>"
                                                                          name="<?php echo $AddOffers["fields"][5]; ?>"
                                                                          data-rules='{"required": true}'
                                                                          data-messages='{"required": "Enter Description"}'
                                                                          rows="5"
                                                                          placeholder="Description"><?php echo $this->ManageDets["data"]["offdesc"]; ?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-offset-6 col-sm-11">
                                                    <button type="submit"
                                                            class="btn btn-primary"
                                                            id="<?php echo $AddOffers["fields"][6]; ?>"
                                                            name="<?php echo $AddOffers["fields"][6]; ?>"
                                                            data-rules='{}'
                                                            data-messages='{}'>Save Details</button>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </form>
                            </div>
                        </div><!-- /.tab-content -->
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
                obj.__EditOfferEvents();
            }
            else {
                LogMessages('I am Out Manage');
            }
        }
    });

</script><!-- Main content -->