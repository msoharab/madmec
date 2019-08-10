<?php
$custAdd = isset($this->idHolders["tamboola"]["customers"]["AddCustomers"]) ? (array) $this->idHolders["tamboola"]["customers"]["AddCustomers"] : false;
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Customers
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>">
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li class="active">Customers</li>
        </ol>
    </section>
    <!-- Main content -->
    <div class="content">
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="tab-content">
                        <form class="form-horizontal"
                              action=""
                              id="<?php echo $custAdd["form"]; ?>"
                              name="<?php echo $custAdd["form"]; ?>"
                              method="post">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><strong>Add Customer</strong></h3>
                                </div>
                                <div class="box-body" id="userbox">
                                    <div class="col-sm-12" id="<?php echo $custAdd["clone"][0]; ?>">
                                        <div class="form-group">
                                            <label for="inputgymName" class="col-sm-1 control-label">Name</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control"
                                                       id="<?php echo $custAdd["fields"][0]; ?>"
                                                       name="<?php echo $custAdd["fields"][0]; ?>"
                                                       data-rules='{"required": true}'
                                                       data-messages='{"required": "Enter Name"}'
                                                       placeholder="Name">
                                            </div>
                                            <label for="inputgymtype" class="col-sm-1 control-label">Gender</label>
                                            <div class="col-sm-5">
                                                <select class="form-control"
                                                        id="<?php echo $custAdd["fields"][1]; ?>"
                                                        name="<?php echo $custAdd["fields"][1]; ?>"
                                                        data-rules='{"required": true}'
                                                        data-messages='{"required": "Select Gender"}'>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="inputphone" class="col-sm-1 control-label">Cell Number</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control"
                                                       id="<?php echo $custAdd["fields"][2]; ?>"
                                                       name="<?php echo $custAdd["fields"][2]; ?>"
                                                       maxlength="10"
                                                       data-rules='{"required": true,"maxlength": "15"}'
                                                       data-messages='{"required": "Enter Cell Number","maxlength": "Length Should be maximum 15 numbers"}'
                                                       placeholder="Cell Number" />
                                            </div>
                                            <label for="inputregfee" class="col-sm-1 control-label">Email Id </label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control"
                                                       id="<?php echo $custAdd["fields"][3]; ?>"
                                                       name="<?php echo $custAdd["fields"][3]; ?>"
                                                       data-rules='{"required": true}'
                                                       data-messages='{"required": "Enter Email Id"}'
                                                       placeholder="Email Id" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="inputgymName" class="col-sm-1 control-label">Company</label>
                                            <div class="col-sm-5">
                                                <input type="text"
                                                       class="form-control"
                                                       id="<?php echo $custAdd["fields"][4]; ?>"
                                                       name="<?php echo $custAdd["fields"][4]; ?>"
                                                       data-rules='{"required": true}'
                                                       data-messages='{"required": "Enter Company"}'
                                                       placeholder="Company">
                                            </div>
                                            <label for="inputgymtype" class="col-sm-1 control-label">Occupation</label>
                                            <div class="col-sm-5">
                                                <select class="form-control"
                                                        id="<?php echo $custAdd["fields"][5]; ?>"
                                                        name="<?php echo $custAdd["fields"][5]; ?>"
                                                        data-rules='{"required": false}'
                                                        data-messages='{"required": "Enter Occupation"}'>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box collapsed-box">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><strong>Registration</strong></h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-box-tool" id="id" name="" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                    </div><!-- /.box-tools -->
                                </div><!-- /.box-header -->
                                <div class="box-body" id="addbox">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="inputusertype" class="col-sm-1 control-label">Registration Fee</label>
                                            <div class="col-sm-5">
                                                <input type="text"
                                                       class="form-control <?php echo $custAdd["fields"][6]; ?>"
                                                       id="<?php echo $custAdd["fields"][6]; ?>"
                                                       name="<?php echo $custAdd["fields"][6]; ?>"
                                                       data-rules='{"required": false}'
                                                       data-messages='{"required": "Enter Registration Fee"}'
                                                       placeholder="Registration Fee">
                                            </div>
                                            <label for="inputusertype" class="col-sm-1 control-label">Amount</label>
                                            <div class="col-sm-5">
                                                <input type="text"
                                                       class="form-control <?php echo $custAdd["fields"][7]; ?>"
                                                       id="<?php echo $custAdd["fields"][7]; ?>"
                                                       name="<?php echo $custAdd["fields"][7]; ?>"
                                                       data-rules='{"required": true}'
                                                       data-messages='{"required": "Enter Amount"}'
                                                       placeholder="Amount">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="inputsertax" class="col-sm-1 control-label">Date Of Joining</label>
                                            <div class="col-sm-5">
                                                <input type="text"
                                                       class="form-control"
                                                       id="<?php echo $custAdd["fields"][8]; ?>"
                                                       name="<?php echo $custAdd["fields"][8]; ?>"
                                                       data-rules='{"required": true}'
                                                       data-messages='{"required": "Enter Date Of Join"}'
                                                       placeholder="Date Of Joining">
                                            </div>
                                            <label for="inputgymName" class="col-sm-1 control-label">Referred By</label>
                                            <div class="col-sm-5">
                                                <input type="text"
                                                       class="form-control"
                                                       id="<?php echo $custAdd["fields"][9]; ?>"
                                                       name="<?php echo $custAdd["fields"][9]; ?>"
                                                       data-rules='{"required": false}'
                                                       data-messages='{"required": "Enter Referred By"}'
                                                       placeholder="Referred By">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box collapsed-box">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><strong>Emergency</strong></h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-box-tool" id="id" name="" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                    </div><!-- /.box-tools -->
                                </div><!-- /.box-header -->
                                <div class="box-body" id="addbox">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="inputregfee" class="col-sm-1 control-label">Emergency Name</label>
                                            <div class="col-sm-5">
                                                <input type="text"
                                                       class="form-control"
                                                       id="<?php echo $custAdd["fields"][10]; ?>"
                                                       name="<?php echo $custAdd["fields"][10]; ?>"
                                                       data-rules='{"required": true}'
                                                       data-messages='{"required": "Enter Emergency Name"}'
                                                       placeholder="Emergency Name" />
                                            </div>
                                            <label for="inputsertax" class="col-sm-1 control-label">Emergency Number</label>
                                            <div class="col-sm-5">
                                                <input type="text"
                                                       class="form-control"
                                                       id="<?php echo $custAdd["fields"][11]; ?>"
                                                       name="<?php echo $custAdd["fields"][11]; ?>"
                                                       data-rules='{"required": true,"maxlength": "15"}'
                                                       data-messages='{"required": "Enter Emergency Number","maxlength": "Length Should be maximum 15 numbers"}'
                                                       placeholder="Emergency Number">
                                            </div>
                                        </div>
                                    </div>
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
                                                       id="<?php echo $custAdd["fields"][12]; ?>"
                                                       name="<?php echo $custAdd["fields"][12]; ?>"
                                                       data-rules='{"required": true}'
                                                       data-messages='{"required": "Enter Country Name"}'
                                                       placeholder="Country" type="text">
                                            </div>
                                            <label for="inputstate" class="col-sm-1 control-label">State / Province</label>
                                            <div class="col-sm-5">
                                                <input class="form-control"
                                                       name="<?php echo $custAdd["fields"][13]; ?>"
                                                       id="<?php echo $custAdd["fields"][13]; ?>"
                                                       data-rules='{"required": true}'
                                                       data-messages='{"required": "Enter State Name"}'
                                                       type="text" placeholder="State/Province">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="inputdistrict" class="col-sm-1 control-label">District / Department</label>
                                            <div class="col-sm-5">
                                                <input class="form-control"
                                                       name="<?php echo $custAdd["fields"][14]; ?>"
                                                       id="<?php echo $custAdd["fields"][14]; ?>"
                                                       data-rules='{"required": true}'
                                                       data-messages='{"required": "Enter District"}'
                                                       placeholder="District/Department"  type="text">
                                            </div>
                                            <label for="inputcity" class="col-sm-1 control-label">City/Town</label>
                                            <div class="col-sm-5">
                                                <input class="form-control"
                                                       name="<?php echo $custAdd["fields"][15]; ?>"
                                                       id="<?php echo $custAdd["fields"][15]; ?>"
                                                       data-rules='{"required": true}'
                                                       data-messages='{"required": "Enter City"}'
                                                       type="text" placeholder="City/Town" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="inputStree" class="col-sm-1 control-label">Street/Locality</label>
                                            <div class="col-sm-5">
                                                <input class="form-control"
                                                       name="<?php echo $custAdd["fields"][16]; ?>"
                                                       id="<?php echo $custAdd["fields"][16]; ?>"
                                                       data-rules='{"required": true}'
                                                       data-messages='{"required": "Enter Address"}'
                                                       placeholder="Street/Locality" type="text" value="http://" >
                                            </div>
                                            <label for="inputaddressline" class="col-sm-1 control-label">Address Line</label>
                                            <div class="col-sm-5">
                                                <input class="form-control"
                                                       name="<?php echo $custAdd["fields"][17]; ?>"
                                                       id="<?php echo $custAdd["fields"][17]; ?>"
                                                       data-rules='{"required": true}'
                                                       data-messages='{"required": "Enter Zip Code"}'
                                                       placeholder="Address Line" type="text" value="http://">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="inputZipcode" class="col-sm-1 control-label">Zip code</label>
                                            <div class="col-sm-11">
                                                <input class="form-control"
                                                       name="<?php echo $custAdd["fields"][18]; ?>"
                                                       id="<?php echo $custAdd["fields"][18]; ?>"
                                                       data-rules='{"required": true,"minlength": "6"}'
                                                       data-messages='{"required": "Enter Owner Name","minlength": "Length Should be minimum 6 numbers"}'
                                                       placeholder="Zip code" type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- dob -->
                            <div class="form-group">
                                <div class="col-sm-offset-5 col-sm-10">
                                    <button type="submit"
                                            class="btn btn-primary"
                                            id="<?php echo $custAdd["fields"][19]; ?>"
                                            name="<?php echo $custAdd["fields"][19]; ?>"
                                            data-rules='{}'
                                            data-messages='{}'>Add Customer</button>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            var this_js_script = $("script[src$='Customers.js']");
            if (this_js_script) {
                var flag = this_js_script.attr('data-autoloader');
                if (flag === 'true') {
                    LogMessages('I am In Customers');
                    var para = getJSONIds({
                        autoloader: true,
                        action: 'getIdHolders',
                        url: URL + 'Customers/getIdHolders',
                        type: 'POST',
                        dataType: 'JSON'
                    }).tamboola.customers;
                    var obj = new customersController();
                    obj.__constructor(para);
                    obj.__AddCustomers();
                }
                else {
                    LogMessages('I am Out Gym');
                }
            }
        });
    </script>
