<?php
$gymAdd = isset($this->idHolders["tamboola"]["home"]["EditGym"]) ? (array) $this->idHolders["tamboola"]["home"]["EditGym"] : false;
?>
<div class="content-wrapper">
    <div class="content">
        <section class="content-header">
            <h1>
                Gym
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>">
                        <i class="fa fa-dashboard"></i> Dashboard
                    </a>
                </li>
                <li class="active">Gym</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <form class="form-horizontal"
                          action=""
                          id="<?php echo $gymAdd["form"]; ?>"
                          name="<?php echo $gymAdd["form"]; ?>"
                          novalidate="novalidate"
                          enctype="multipart/form-data"
                          method="post">
                        <div class="content">
                            <!-- Main content -->
                            <section class="content">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="box">
                                            <div class="box-header with-border">
                                                <h3 class="box-title"><strong>Add gym</strong></h3>
                                            </div>
                                            <div class="box-body" id="userbox">
                                                <input type="hidden"
                                                       name="<?php echo $gymAdd["fields"][16]; ?>"
                                                       id="<?php echo $gymAdd["fields"][16]; ?>"
                                                       data-rules='{}'
                                                       data-messages='{}'
                                                       value="<?php echo base64_encode($this->GymDets["data"]["gymid"]); ?>" />
                                                <div class="col-sm-12">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="inputgymtype" class="col-sm-1 control-label">Gym Type</label>
                                                            <div class="col-sm-5">
                                                                <select class="form-control"
                                                                        id="<?php echo $gymAdd["fields"][0]; ?>"
                                                                        name="<?php echo $gymAdd["fields"][0]; ?>"
                                                                        data-rules='{"required": true}'
                                                                        data-messages='{"required": "Select Gym Type"}'>
                                                                    <option>main</option>
                                                                    <option>branch</option>
                                                                </select>
                                                            </div>
                                                            <label for="inputgymName" class="col-sm-1 control-label">Gym Name</label>
                                                            <div class="col-sm-5">
                                                                <input type="text"
                                                                       class="form-control"
                                                                       id="<?php echo $gymAdd["fields"][1]; ?>"
                                                                       name="<?php echo $gymAdd["fields"][1]; ?>"
                                                                       value="<?php echo trim($this->GymDets["data"]["gymname"]); ?>"
                                                                       data-rules='{"required": true,"minlength": "4"}'
                                                                       data-messages='{"required": "Enter Gym Name","minlength": "Length Should be 4 characters"}'
                                                                       placeholder="Gym Name"
                                                                       maxlength="100"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="inputregfee" class="col-sm-1 control-label">Registration Fee </label>
                                                            <div class="col-sm-5">
                                                                <input type="number"
                                                                       class="form-control"
                                                                       id="<?php echo $gymAdd["fields"][2]; ?>"
                                                                       name="<?php echo $gymAdd["fields"][2]; ?>"
                                                                       value="<?php echo trim($this->GymDets["data"]["gymregfee"]); ?>"
                                                                       data-rules='{"required": true,"minlength": "1"}'
                                                                       data-messages='{"required": "Enter Registration Fee","minlength": "Length Should be 1 characters"}'
                                                                       placeholder="Registration Fee "
                                                                       value="500"
                                                                       maxlength="25"/>
                                                            </div>
                                                            <label for="inputsertax" class="col-sm-1 control-label">Service Tax</label>
                                                            <div class="col-sm-5">
                                                                <input type="number"
                                                                       class="form-control"
                                                                       id="<?php echo $gymAdd["fields"][3]; ?>"
                                                                       name="<?php echo $gymAdd["fields"][3]; ?>"
                                                                       value="<?php echo trim($this->GymDets["data"]["service_tax"]); ?>"
                                                                       data-rules='{"required": true,"minlength":"3"}'
                                                                       data-messages='{"required": "Enter Service Tax","minlength": "Length Should be 3 characters"}'
                                                                       placeholder="Service Tax"
                                                                       value="0.15"
                                                                       maxlength="10"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="inputphone" class="col-sm-1 control-label">Telephone Number </label>
                                                            <div class="col-sm-2">
                                                                <input type="text"
                                                                       class="form-control"
                                                                       id="<?php echo $gymAdd["fields"][4]; ?>"
                                                                       name="<?php echo $gymAdd["fields"][4]; ?>"
                                                                       value="<?php echo trim($this->GymDets["data"]["postal_code"]); ?>"
                                                                       data-rules='{}'
                                                                       data-messages='{}'
                                                                       value="080">
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <input type="number"
                                                                       class="form-control"
                                                                       id="<?php echo $gymAdd["fields"][5]; ?>"
                                                                       name="<?php echo $gymAdd["fields"][5]; ?>"
                                                                       value="<?php echo trim($this->GymDets["data"]["telephone"]); ?>"
                                                                       data-rules='{}'
                                                                       data-messages='{}'
                                                                       placeholder="Telephone Number">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.row -->
                                <div class="box collapsed-box">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><strong>Gym Logo, Header Logo</strong></h3>
                                        <div class="box-tools pull-right">
                                            <button class="btn btn-box-tool" id="id" name="" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                        </div><!-- /.box-tools -->
                                    </div>
                                    <div class="box-body">
                                        <div class="col-lg-12">
                                            <div class="col-lg-5">
                                                <div class="panel panel-info">
                                                    <div class="panel-heading"><strong>Gym Logo</strong></div>
                                                    <div class="panel-body">
                                                        <input type="file"
                                                               name="<?php echo $gymAdd["logoImg"]; ?>"
                                                               id="<?php echo $gymAdd["logoImg"]; ?>"
                                                               value="<?php echo trim($this->GymDets["data"]["short_logo"]); ?>" />
                                                    </div>
                                                    <div class="panel-footer text-warning"><i class="fa fa-warning fa-2x"></i>&nbsp;We accept jpeg, png, jpg images less than 5MB</div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">&nbsp;</div>
                                            <div class="col-lg-5">
                                                <div class="panel panel-info">
                                                    <div class="panel-heading"><strong>Receipt Header Logo</strong></div>
                                                    <div class="panel-body">
                                                        <input type="file"
                                                               name="<?php echo $gymAdd["headerImg"]; ?>"
                                                               id="<?php echo $gymAdd["headerImg"]; ?>"
                                                               value="<?php echo trim($this->GymDets["data"]["header_logo"]); ?>" />
                                                    </div>
                                                    <div class="panel-footer text-warning"><i class="fa fa-warning fa-2x"></i>&nbsp;We accept jpeg, png, jpg images less than 5MB</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box collapsed-box">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><strong>Internal / External View of Fitness Center</strong></h3>
                                        <div class="box-tools pull-right">
                                            <button class="btn btn-box-tool" id="id" name="" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                        </div><!-- /.box-tools -->
                                    </div>
                                    <div class="box-body">
                                        <div class="col-lg-12 center">
                                            <div class="panel panel-info">
                                                <div class="panel-heading"><strong>Fitness Center</strong></div>
                                                <div class="panel-body">
                                                    <input type="file"
                                                           name="<?php echo $gymAdd["inView"]; ?>"
                                                           id="<?php echo $gymAdd["inView"]; ?>"
                                                           value="<?php echo trim($this->GymDets["data"]["photo"]); ?>"/>
                                                </div>
                                                <div class="panel-footer text-warning"><i class="fa fa-warning fa-2x"></i>&nbsp;We accept jpeg, png, jpg images less than 5MB</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box collapsed-box">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><strong>Email IDs,Cell Numbers</strong></h3>
                                        <div class="box-tools pull-right">
                                            <button class="btn btn-box-tool" id="id" name="" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                        </div><!-- /.box-tools -->
                                    </div>
                                    <div class="box-body" id="addbox">
                                        <!--<div class="box-tools pull-left col-sm-offset-4">
                                            <button type="button" class="btn btn-box-tool" id="<?php echo $gymAdd["cloneplusbut"][0]; ?>" name="<?php echo $gymAdd["cloneplusbut"][0]; ?>" data-widget="add"><i class="fa fa-plus"></i></button>
                                        </div>
                                        <div class="box-tools pull-left col-sm-offset-0">
                                            <button type="button" class="btn btn-box-tool" id="<?php echo $gymAdd["cloneminusbut"][0]; ?>" name="<?php echo $gymAdd["cloneminusbut"][0]; ?>" data-widget="minus"><i class="fa fa-minus"></i></button>
                                        </div>-->
                                        <?php
                                        $emails = explode(",", $this->GymDets["data"]["gymemail"]);
                                        if (count($emails) > 0):
                                            for ($i = 0; $i < count($emails) && isset($emails[$i]) && $this->validateEmail($emails[$i]); $i++) {
                                                ?>
                                                <div class="col-sm-12" id="<?php echo $gymAdd["clone"][0] . '' . $i; ?>">
                                                    <div class="form-group">
                                                        <label for="inputemail" class="col-sm-1 control-label">Email IDs</label>
                                                        <div class="col-sm-5">
                                                            <input type="email"
                                                                   class="form-control <?php echo $gymAdd["reqparam"][0]; ?>"
                                                                   id="<?php echo $gymAdd["reqparam"][0] . '' . $i; ?>"
                                                                   name="<?php echo $gymAdd["reqparam"][0] . '' . $i; ?>"
                                                                   value="<?php echo trim($emails[$i]); ?>"
                                                                   data-rules='{"required": true,"minlength": "6"}'
                                                                   data-messages='{"required": "Enter Email IDs","minlength": "Length Should be 6 characters"}'
                                                                   placeholder="Email ID"
                                                                   maxlength="100"/>
                                                        </div>
                                                    </div>
                                                    <div class="divider">&nbsp;</div>
                                                </div>
                                                <?php
                                            }
                                        else:
                                            ?>
                                            <div class="col-sm-12" id="<?php echo $gymAdd["clone"][0]; ?>">
                                                <div class="form-group">
                                                    <label for="inputemail" class="col-sm-1 control-label">Email IDs</label>
                                                    <div class="col-sm-5">
                                                        <input type="email"
                                                               class="form-control <?php echo $gymAdd["reqparam"][0]; ?>"
                                                               id="<?php echo $gymAdd["reqparam"][0]; ?>"
                                                               name="<?php echo $gymAdd["reqparam"][0]; ?>"
                                                               value="<?php echo trim($this->GymDets["data"]["email"]); ?>"
                                                               data-rules='{"required": true,"minlength": "6"}'
                                                               data-messages='{"required": "Enter Email IDs","minlength": "Length Should be 6 characters"}'
                                                               placeholder="Email ID"
                                                               maxlength="100"/>
                                                    </div>
                                                </div>
                                                <div class="divider">&nbsp;</div>
                                            </div>
                                        <?php endif;
                                        ?>
                                        <!--
                                        <div class="box-tools pull-left col-sm-offset-5">
                                            <button type="button" class="btn btn-box-tool" id="<?php echo $gymAdd["cloneplusbut"][1]; ?>" name="<?php echo $gymAdd["cloneplusbut"][1]; ?>" data-widget="add"><i class="fa fa-plus"></i></button>
                                        </div>
                                        <div class="box-tools pull-left col-sm-offset-0">
                                            <button type="button" class="btn btn-box-tool" id="<?php echo $gymAdd["cloneminusbut"][1]; ?>" name="<?php echo $gymAdd["cloneminusbut"][1]; ?>" data-widget="minus"><i class="fa fa-minus"></i></button>
                                        </div>-->
                                        <?php
                                        $gymcell = explode(",", $this->GymDets["data"]["gymcell"]);
                                        if (count($gymcell) > 0):
                                            for ($i = 0; $i < count($gymcell) && isset($gymcell[$i]); $i++) {
                                                $cellarray = explode("-",$gymcell[$i]);
                                                ?>
                                                <div class="col-sm-12" id="<?php echo $gymAdd["clone"][1]. '' . $i; ?>">
                                                    <div class="form-group">
                                                        <label for="inputcellno" class="col-sm-1 control-label">Cell Numbers</label>
                                                        <div class="col-sm-2">
                                                            <input type="number"
                                                                   class="form-control <?php echo $gymAdd["resparam"][0]; ?>"
                                                                   id="<?php echo $gymAdd["resparam"][0]. '' . $i; ?>"
                                                                   name="<?php echo $gymAdd["resparam"][0]. '' . $i; ?>"
                                                                   value="<?php echo trim($cellarray[0]); ?>"
                                                                   data-rules='{"required": true,"maxlength":"2"}'
                                                                   data-messages='{"required": "Enter Cell Code","maxlength":"Maximum 2 numbers allowed"}'
                                                                   value="91"
                                                                   maxlength="2"/>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <input type="number"
                                                                   class="form-control <?php echo $gymAdd["resparam"][1]; ?>"
                                                                   id="<?php echo $gymAdd["resparam"][1]. '' . $i; ?>"
                                                                   name="<?php echo $gymAdd["resparam"][1]. '' . $i; ?>"
                                                                   value="<?php echo trim($cellarray[1]); ?>"
                                                                   data-rules='{"required": true,"minlength":"10"}'
                                                                   data-messages='{"required": "Enter Cell Numbers","minlength":"Maximum 10 numbers allowed"}'
                                                                   placeholder="Cell Number"
                                                                   maxlength="12" />
                                                        </div>
                                                    </div>
                                                    <div class="divider">&nbsp;</div>
                                                </div>
                                            <?php
                                            }
                                        else:
                                            ?>
                                            <div class="col-sm-12" id="<?php echo $gymAdd["clone"][1]; ?>">
                                                <div class="form-group">
                                                    <label for="inputcellno" class="col-sm-1 control-label">Cell Numbers</label>
                                                    <div class="col-sm-2">
                                                        <input type="number"
                                                               class="form-control <?php echo $gymAdd["resparam"][0]; ?>"
                                                               id="<?php echo $gymAdd["resparam"][0]; ?>"
                                                               name="<?php echo $gymAdd["resparam"][0]; ?>"
                                                               value="<?php echo trim($this->GymDets["data"]["cell_code"]); ?>"
                                                               data-rules='{"required": true,"maxlength":"2"}'
                                                               data-messages='{"required": "Enter Cell Code","maxlength":"Maximum 2 numbers allowed"}'
                                                               value="91"
                                                               maxlength="2"/>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <input type="number"
                                                               class="form-control <?php echo $gymAdd["resparam"][1]; ?>"
                                                               id="<?php echo $gymAdd["resparam"][1]; ?>"
                                                               name="<?php echo $gymAdd["resparam"][1]; ?>"
                                                               value="<?php echo trim($this->GymDets["data"]["cell_number"]); ?>"
                                                               data-rules='{"required": true,"minlength":"10"}'
                                                               data-messages='{"required": "Enter Cell Numbers","minlength":"Maximum 10 numbers allowed"}'
                                                               placeholder="Cell Number"
                                                               maxlength="12" />
                                                    </div>
                                                </div>
                                                <div class="divider">&nbsp;</div>
                                            </div>
                                        <?php
                                        endif;
                                        ?>
                                    </div>
                                </div>
                                <div class="box collapsed-box">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><strong>Address</strong></h3>
                                        <div class="box-tools pull-right">
                                            <button class="btn btn-box-tool" id="id" name="" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                        </div><!-- /.box-tools -->
                                    </div><!-- /.box-header -->
                                    <div class="box-body" id="addbox">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="inputcountry" class="col-sm-1 control-label">Country</label>
                                                <div class="col-sm-5">
                                                    <input class="form-control"
                                                           id="<?php echo $gymAdd["fields"][6]; ?>"
                                                           name="<?php echo $gymAdd["fields"][6]; ?>"
                                                           value="<?php echo trim($this->GymDets["data"]["country"]); ?>"
                                                           data-rules='{"required": true,"minlength": "4"}'
                                                           data-messages='{"required": "Enter Country","minlength": "Length Should be 4 characters"}'
                                                           placeholder="Country" type="text" maxlength="100" />
                                                </div>
                                                <label for="inputstate" class="col-sm-1 control-label">State/<br />Province</label>
                                                <div class="col-sm-5">
                                                    <input class="form-control"
                                                           name="<?php echo $gymAdd["fields"][7]; ?>"
                                                           id="<?php echo $gymAdd["fields"][7]; ?>"
                                                           value="<?php echo trim($this->GymDets["data"]["province"]); ?>"
                                                           type="text"
                                                           data-rules='{"required": true,"minlength": "4"}'
                                                           data-messages='{"required": "Enter State/Province","minlength": "Length Should be 4 characters"}'
                                                           placeholder="State/Province" maxlength="150" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="inputdistrict" class="col-sm-1 control-label">District/<br />Department</label>
                                                <div class="col-sm-5">
                                                    <input class="form-control"
                                                           placeholder="District/Department"
                                                           name="<?php echo $gymAdd["fields"][8]; ?>"
                                                           id="<?php echo $gymAdd["fields"][8]; ?>"
                                                           value="<?php echo trim($this->GymDets["data"]["district"]); ?>"
                                                           data-rules='{"required": true,"minlength": "4"}'
                                                           data-messages='{"required": "Enter District/Department","minlength": "Length Should be 4 characters"}'
                                                           type="text" maxlength="100" />
                                                </div>
                                                <label for="inputcity" class="col-sm-1 control-label">City/<br />Town</label>
                                                <div class="col-sm-5">
                                                    <input class="form-control"
                                                           placeholder="City/Town"
                                                           name="<?php echo $gymAdd["fields"][9]; ?>"
                                                           id="<?php echo $gymAdd["fields"][9]; ?>"
                                                           value="<?php echo trim($this->GymDets["data"]["city"]); ?>"
                                                           data-rules='{"required": true,"minlength": "4"}'
                                                           data-messages='{"required": "Enter City/Town","minlength": "Length Should be 4 characters"}'
                                                           type="text" maxlength="100" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="inputstreet" class="col-sm-1 control-label">Street/<br />Locality</label>
                                                <div class="col-sm-5">
                                                    <input class="form-control"
                                                           placeholder="Street/Locality"
                                                           name="<?php echo $gymAdd["fields"][10]; ?>"
                                                           id="<?php echo $gymAdd["fields"][10]; ?>"
                                                           value="<?php echo trim($this->GymDets["data"]["town"]); ?>"
                                                           data-rules='{}'
                                                           data-messages='{}'
                                                           type="text" maxlength="100" />
                                                </div>
                                                <label for="inputAddress" class="col-sm-1 control-label">Address Line</label>
                                                <div class="col-sm-5">
                                                    <input class="form-control"
                                                           placeholder="Address Line"
                                                           type="text"
                                                           name="<?php echo $gymAdd["fields"][11]; ?>"
                                                           id="<?php echo $gymAdd["fields"][11]; ?>"
                                                           value="<?php echo trim($this->GymDets["data"]["addressline"]); ?>"
                                                           data-rules='{}'
                                                           data-messages='{}' maxlength="200" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="inputzipcode" class="col-sm-1 control-label">Zip code</label>
                                                <div class="col-sm-5">
                                                    <input class="form-control"
                                                           placeholder="Zipcode"
                                                           name="<?php echo $gymAdd["fields"][12]; ?>"
                                                           id="<?php echo $gymAdd["fields"][12]; ?>"
                                                           value="<?php echo trim($this->GymDets["data"]["zipcode"]); ?>"
                                                           data-rules='{}'
                                                           data-messages='{}'
                                                           type="text" >
                                                </div>
                                                <label for="inputwebsite" class="col-sm-1 control-label">Website</label>
                                                <div class="col-sm-5">
                                                    <input class="form-control"
                                                           type="url"
                                                           placeholder="Personal Website"
                                                           name="<?php echo $gymAdd["fields"][13]; ?>"
                                                           id="<?php echo $gymAdd["fields"][13]; ?>"
                                                           value="<?php echo trim($this->GymDets["data"]["website"]); ?>"
                                                           data-rules='{}'
                                                           data-messages='{}'
                                                           />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="inputgoogle" class="col-sm-1 control-label">Google Map URL</label>
                                                <div class="col-sm-11">
                                                    <input class="form-control"
                                                           data-rules='{}'
                                                           data-messages='{}'
                                                           placeholder="Google Map URL"
                                                           name="<?php echo $gymAdd["fields"][14]; ?>"
                                                           id="<?php echo $gymAdd["fields"][14]; ?>"
                                                           value="<?php echo trim($this->GymDets["data"]["gmaphtml"]); ?>"
                                                           type="url" />
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.box-body -->
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-5 col-sm-10">
                                        <button type="submit"
                                                class="btn btn-primary"
                                                id="<?php echo $gymAdd["fields"][15]; ?>"
                                                name="<?php echo $gymAdd["fields"][15]; ?>"
                                                data-rules='{}'
                                                data-messages='{}'>Add Gym</button>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </form>                
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div>
</div>
<script data-autoloader="false" type="text/javascript" src="<?php echo $this->config["URL"] . $this->config["VIEWS"] . $this->config["ASSSET_REG"] . $this->config["CONTROLLERS"]; ?>Gym.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var para = getJSONIds({
            autoloader: true,
            action: 'getIdHolders',
            url: URL + 'Home/getIdHolders',
            type: 'POST',
            dataType: 'JSON'
        }).tamboola;
        var obj = new homeController();
        obj.__constructor(para);
        obj.__EditGym();
    });
</script>
