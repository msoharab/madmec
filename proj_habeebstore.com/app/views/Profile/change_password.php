<?php
$Prof = isset($this->idHolders["shop"]["profile"]["ChangePassword"]) ? (array) $this->idHolders["shop"]["profile"]["ChangePassword"] : false;
$Profemail = isset($this->idHolders["shop"]["profile"]["ChangeEmail"]) ? (array) $this->idHolders["shop"]["profile"]["ChangeEmail"] : false;
$Profcell = isset($this->idHolders["shop"]["profile"]["ChangeCell"]) ? (array) $this->idHolders["shop"]["profile"]["ChangeCell"] : false;
$Profpic = isset($this->idHolders["shop"]["profile"]["ChangePic"]) ? (array) $this->idHolders["shop"]["profile"]["ChangePic"] : false;
?>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#addutype" data-toggle="tab">Password</a></li>
        <!--<li><a href="#addEmail" data-toggle="tab">Email Id</a></li>
        <li><a href="#addCell" data-toggle="tab">Cell Number</a></li>
        <li><a href="#addProfile" data-toggle="tab">Profile Picture</a></li>-->
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="addutype">
            <div class="box">
                <form class="form-horizontal"
                      action=""
                      id="<?php echo $Prof["form"]; ?>"
                      name="<?php echo $Prof["form"]; ?>"
                      method="post">
                    <section class="">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box">
                                    <div class="box-body">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="oldpassword" class="col-sm-1 control-label">Old Password</label>
                                                <div class="col-sm-11">
                                                    <input type="password"
                                                           class="form-control"
                                                           id="<?php echo $Prof["fields"][0]; ?>"
                                                           name="<?php echo $Prof["fields"][0]; ?>"
                                                           data-rules='{"required": true,"minlength": "6"}'
                                                           data-messages='{"required": "Enter Old Password","minlength": "Length Should be minimum 6 Characters"}'
                                                           placeholder="Old Password" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="newpassword" class="col-sm-1 control-label">New Password</label>
                                                <div class="col-sm-5">
                                                    <input type="password"
                                                           class="form-control"
                                                           id="<?php echo $Prof["fields"][1]; ?>"
                                                           name="<?php echo $Prof["fields"][1]; ?>"
                                                           data-rules='{"required": true,"minlength": "6"}'
                                                           data-messages='{"required": "Enter New Password","minlength": "Length Should be minimum 6 Characters"}'
                                                           placeholder="New Password" />
                                                </div>
                                                <label for="confirmpassword" class="col-sm-1 control-label">Confirm Password</label>
                                                <div class="col-sm-5">
                                                    <input type="password"
                                                           class="form-control"
                                                           id="<?php echo $Prof["fields"][2]; ?>"
                                                           name="<?php echo $Prof["fields"][2]; ?>"
                                                           data-rules='{"required": true,"minlength": "6","equalTo": "#<?php echo $Prof["fields"][1]; ?>"}'
                                                           data-messages='{"required": "confirm password","minlength": "Length Should be minimum 6 Characters","equalTo":"Enter same password"}'
                                                           placeholder="Confirm Password" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="col-sm-offset-5 col-sm-10">
                                                    <button type="button"
                                                            class="btn btn-danger"
                                                            id="<?php echo $Prof["fields"][3]; ?>"
                                                            name="<?php echo $Prof["fields"][3]; ?>"
                                                            data-rules='{}'
                                                            data-messages='{}'>Change Password</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </form>
            </div>
        </div>
        <div class="tab-pane" id="addEmail">
            <div class="box">
                <form class="form-horizontal"
                      action=""
                      id="<?php echo $Profemail["form"]; ?>"
                      name="<?php echo $Profemail["form"]; ?>"
                      method="post">
                    <section class="">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box">
                                    <div class="box-body">
                                        <div class="col-sm-12">
                                            <div class="box-tools pull-right col-sm-offset-0">
                                                <button type="button" class="btn btn-box-tool" id="<?php echo $gymAdd["cloneplusbut"][0]; ?>" name="<?php echo $gymAdd["cloneplusbut"][0]; ?>" data-widget="add"><i class="fa fa-plus"></i></button>
                                            </div><!-- /.box-tools -->
                                            <div class="box-tools pull-right col-sm-offset-0">
                                                <button type="button" class="btn btn-box-tool" id="<?php echo $gymAdd["cloneminusbut"][0]; ?>" name="<?php echo $gymAdd["cloneminusbut"][0]; ?>" data-widget="minus"><i class="fa fa-minus"></i></button>
                                            </div><!-- /.box-tools -->
                                            <div class="col-sm-12" id="<?php echo $gymAdd["clone"][0]; ?>">
                                                <div class="form-group">
                                                    <label for="inputemail" class="col-sm-1 control-label">Email IDs</label>
                                                    <div class="col-sm-11">
                                                        <input type="email"
                                                               class="form-control <?php echo $gymAdd["reqparam"][0]; ?>"
                                                               id="<?php echo $gymAdd["reqparam"][0]; ?>"
                                                               name="<?php echo $gymAdd["reqparam"][0]; ?>"
                                                               data-rules='{"required": true,"email": true}'
                                                               data-messages='{"required": "Enter Email ID","email": "Enter Email ID"}'
                                                               placeholder="Email ID"
                                                               pattern="^[A-Z_a-z0-9-]+(\.[A-Z_a-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9]{2,4})*(\.[A-Za-z]{2,4})$"
                                                               maxlength="100" required />
                                                    </div>
                                                </div>
                                                <div class="divider">&nbsp;</div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="col-sm-offset-5 col-sm-10">
                                                    <button type="submit"
                                                            class="btn btn-danger"
                                                            id="<?php echo $Profemail["fields"][0]; ?>"
                                                            name="<?php echo $Profemail["fields"][0]; ?>"
                                                            data-rules='{}'
                                                            data-messages='{}'>Change Email</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </form>
            </div>
        </div>
        <div class="tab-pane" id="addCell">
            <div class="box">
                <form class="form-horizontal"
                      action=""
                      id="<?php echo $Profcell["form"]; ?>"
                      name="<?php echo $Profcell["form"]; ?>"
                      method="post">
                    <section class="">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box">
                                    <div class="box-body">
                                        <div class="col-sm-12">
                                            <div class="box-tools pull-right col-sm-offset-0">
                                                <button type="button" class="btn btn-box-tool" id="<?php echo $Profcell["cloneplusbut"][1]; ?>" name="<?php echo $gymAdd["cloneplusbut"][1]; ?>" data-widget="add"><i class="fa fa-plus"></i></button>
                                            </div><!-- /.box-tools -->
                                            <div class="box-tools pull-right col-sm-offset-0">
                                                <button type="button" class="btn btn-box-tool" id="<?php echo $Profcell["cloneminusbut"][1]; ?>" name="<?php echo $gymAdd["cloneminusbut"][1]; ?>" data-widget="minus"><i class="fa fa-minus"></i></button>
                                            </div><!-- /.box-tools -->
                                            <div class="col-sm-12" id="<?php echo $Profcell["clone"][1]; ?>">
                                                <div class="form-group">
                                                    <label for="inputcellno" class="col-sm-2 control-label">Cell Numbers</label>
                                                    <div class="col-sm-2">
                                                        <input type="number"
                                                               class="form-control <?php echo $Profcell["resparam"][0]; ?>"
                                                               id="<?php echo $Profcell["resparam"][0]; ?>"
                                                               name="<?php echo $Profcell["resparam"][0]; ?>"
                                                               data-rules='{"required": true,"maxlength":"2"}'
                                                               data-messages='{"required": "Enter Cell Code","maxlength":"Maximum 2 numbers allowed"}'
                                                               value="91"
                                                               pattern="[0-9]{2,2}$"
                                                               maxlength="2" required />
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <input type="number"
                                                               class="form-control <?php echo $Profcell["resparam"][1]; ?>"
                                                               id="<?php echo $Profcell["resparam"][1]; ?>"
                                                               name="<?php echo $Profcell["resparam"][1]; ?>"
                                                               data-rules='{"required": true,"minlength":"10"}'
                                                               data-messages='{"required": "Enter Cell Numbers","minlength":"Maximum 10 numbers allowed"}'
                                                               placeholder="9999999999"
                                                               pattern="[0-9]{7,12}$"
                                                               maxlength="10" required />
                                                    </div>
                                                </div>
                                                <div class="divider">&nbsp;</div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="col-sm-offset-5 col-sm-10">
                                                    <button type="submit"
                                                            class="btn btn-danger"
                                                            id="<?php echo $Profcell["fields"][0]; ?>"
                                                            name="<?php echo $Profcell["fields"][0]; ?>"
                                                            data-rules='{}'
                                                            data-messages='{}'>Change Cell Number</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </form>
            </div>
        </div>
        <div class="tab-pane" id="addProfile">
            <div class="box">
                <form class="form-horizontal"
                      action=""
                      id="<?php echo $Profpic["form"]; ?>"
                      name="<?php echo $Profpic["form"]; ?>"
                      method="post">
                    <section class="">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box">
                                    <div class="box-body">
                                        <div class="col-sm-12">
                                            <div class="col-lg-12 center">
                                                <div class="panel panel-info">
                                                    <div class="panel-heading"><strong>Profile Picture</strong></div>
                                                    <div class="panel-body">
                                                        <input type="file"
                                                               name="<?php echo $Profpic["inView"]; ?>"
                                                               id="<?php echo $Profpic["inView"]; ?>" />
                                                    </div>
                                                    <div class="panel-footer text-warning"><i class="fa fa-warning fa-2x"></i>&nbsp;We accept jpeg, png, jpg images less than 5MB</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <div class="col-sm-offset-5 col-sm-10">
                                                    <button type="submit"
                                                            class="btn btn-danger"
                                                            id="<?php echo $Profpic["fields"][0]; ?>"
                                                            name="<?php echo $Profpic["fields"][0]; ?>"
                                                            data-rules='{}'
                                                            data-messages='{}'>Change Picture</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </form>
            </div>
        </div>
    </div>
</div>