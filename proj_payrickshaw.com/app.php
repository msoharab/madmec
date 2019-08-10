<?php
	define("MODULE_1","config.php");
	define("MODULE_2","database.php");
	require_once(MODULE_1);
	require_once(CONFIG_ROOT.MODULE_1);
	require_once(CONFIG_ROOT.MODULE_2);
	include_once(DOC_ROOT.INC.'header.php');
?>
<div class="page-container">
	<?php include_once(DOC_ROOT.INC.'/top_nav.php');?>
    <div class="container-fluid">
        <div id="billgenmodule">
      <div class="row row-offcanvas row-offcanvas-left" >
        <!--sidebar-->
        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">

                <div class="panel panel-default" id="left-panel">
                  <div class="panel-heading"><h5>Generate Receipt</h5></div>
                    <div class="panel-body" >
                      <div class="list-group">
							<form id="genbillform">

								<div class="form_div" id="form1">
									<strong>Driver  Details</strong>
									<hr />
									<div class="form-group">
										<label>Regd.no (Ex. KA01B1234) </label>
                                                                                <input class="form-control" id="regdno" name="regdno">
                                                                                <p class="form-group text-danger" id="regdnoerr"> </p>
									</div>
									<div class="form-group">
										 <label>Driver Name </label>
										<input class="form-control"  id="drivername" name="drivername">
                                                                                <p class="form-group text-danger" id="drivernameerr"></p>
									</div>
									<div class="form-group">
										 <label>Mobile Number </label>
										<input class="form-control"  id="drivermobile" name="drivermobile">
                                                                                <p class="form-group text-danger" id="drivermobileerr"></p>
									</div>
									<div class="form-group">
										<button type="button"  class="btn btn-primary" id="formreferesh">Refresh</button>
										<button type="button" id="next1"  class="btn btn-primary" >Next</button>
									</div>
								</div><!-- form-1 -->
								<div class="form_div" id="form2" style="display:none;">
									<strong>Passenger  Details</strong>
									<hr />
									<div class="form-group">
										 <label>Mobile Number </label>
										<input class="form-control"  id="passengermobile" name="passengermobile">
                                                                                <p class="form-group text-danger" id="passengermobileerr"></p>
									</div>
									<div class="form-group">
										 <label>Passenger Name </label>
										<input class="form-control"  id="passengername" name="passengername">
                                                                                <p class="form-group text-danger" id="passengernameerr"></p>
									</div>
									<div class="form-group">
										 <label>Permanent Address </label>
                                                                                 <textarea class="form-control"  id="passngeraddress" name="passngeraddress"></textarea>
                                                                                 <p class="form-group text-danger" id="passngeraddresserr"></p>
									</div>
									<div class="form-group">
										<button type="button"  class="btn btn-primary" onclick="goto_form1();">Previous</button>
                                                                                <button type="button"  class="btn btn-primary" id="next2">Next</button>
									</div>
								</div><!-- form-1 -->
								<div class="form_div" id="form3" style="display:none;">
									<strong>Receipt</strong>
									<hr />
									<div class="form-group">
										 <label>Source </label>
										<!-- <textarea  class="form-control" id="source" name="source" rows="8" cols="12" readonly>MadMec, #42,5th cross,opposite to Mahaveer Wilton, 22nd Main Road, Vinayaka Nagar, J P Nagar Phase 5, J. P. Nagar, Bengaluru, Karnataka 560078</textarea> -->
										<textarea  class="form-control" id="source" name="source" rows="5"  readonly>Hi Tech Prepaid Auto Rickshaw Station, Bengaluru, Karnataka 560078</textarea>
									</div>
									<div class="form-group">
										 <label>Destination </label>
										<textarea  class="form-control" id="destination" name="destination"  rows="5"  readonly></textarea>
									</div>
									<div class="form-group">
										 <label>Distance </label>
                                                                                 <input class="form-control"  id="distance" value="2 km" name="distance" readonly="">
									</div>
									<div class="form-group">
										 <label>Amount</label>
                                                                                 <input class="form-control"  id="amount" value="25" name="amount" readonly="">
									</div>
									<div class="form-group">
										<button type="button"  class="btn btn-primary" onclick="goto_form2();">Previous</button>
										<button type="button" id="genButt" class="btn btn-primary" onlcik="finish();">Finish</button>
									</div>
								</div><!-- form-1 -->
							</form>
                      </div>
                    </div><!--/panel-body-->
                </div>
	</div><!--/sidebar-->

        <!--/main-->
        <div class="col-xs-12 col-sm-9" data-spy="scroll" data-target="#sidebar-nav">
          <div class="row">
           	<div class="col-lg-8">
				<div style="width:100%;height:550px;" id="map-panel">
					<input class="form-control" id="pac-input" class="controls" type="text" placeholder="Search Box">
					<div id="map-canvas">Loading Google map ......</div>
				</div>
			</div><!--/col-->
			<div class="col-lg-4">
				<div id="content-pane" class="well">
					<h3>Result</h3>
					<hr />
					<div id="inputs">
						<p>
						   <h4><strong>Marker status:</strong></h4>
							<div id="markerStatus"><i>Click and drag the marker.</i></div>
						</p>
						<p>
							<h4><strong>Current position:</strong></h4>
							<div id="info"></div>
						</p>
						<p>
							<h4><strong>Closest matching address:</strong></h4>
							<div id="address"></div>
						</p>
					</div>
					<div id="outputDiv"></div>
                    <div id="billdisplay"></div>
				</div>
			</div><!--/col-->
          </div><!--/row-->
        </div><!--/.col-xs-12-->
      </div><!--/.row-->
        </div>
        <div id="accountmoduledis">
            <div class="row"><div class="col-lg-12">&nbsp;</div></div>
<div class="row output-panels" id="pFollowups">
    <ul class="nav nav-tabs" id="followupmenu">
        <li class="active"><a href="#payment_menu" data-toggle="tab" id="payment_menubut">Payments</a> </li>
        <li><a href="#payment_history_menu" data-toggle="tab" id="payment_history_menubut">Payment History </a> </li>
    </ul>
     <div class="row">
    <div class="tab-content">

        <div class="tab-pane fade in active" id="payment_menu">
            <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h4>Payments</h4>
                        </div>
                        <div class="panel-body">
                         <form id="addpaymentform">
                        <div class="col-lg-12 col-sm-12">
                           <div class="col-lg-4">
                            <div class="col-lg-12">
                            <strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Regd no </strong>
                            </div>
                            <div class="col-lg-12">
                            <input type="text" class="form-control" name="paymentregdno" id="paymentregdno" maxlength="100" required=""/>
                            <p class="help-block" id="paymentregdno_msg">Enter / Select</p>
                            </div>
                            </div>
                            <div class="col-lg-4">
                            <div class="col-lg-12">
                            <strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Mobile Number </strong>
                            </div>
                            <div class="col-lg-12">
                            <input type="text" class="form-control" name="paymentdrivermobile" id="paymentdrivermobile" maxlength="100" required=""/>
                            <p class="help-block" id="paymentdrivermobile_msg">Enter / Select</p>
                            </div>
                            </div>
                            <div class="col-lg-4">
                            <div class="col-lg-12">
                            <strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Name </strong>
                            </div>
                            <div class="col-lg-12">
                            <input type="text" class="form-control" name="paymentdrivername" id="paymentdrivername" maxlength="100" required=""/>
                           <p class="help-block" id="paymentdrivername_msg">Enter / Select</p>
                            </div>
                            </div>
                        </div>
                            <div class="col-lg-12 col-sm-12">&nbsp;</div>
                           <div class="col-lg-12 col-sm-12">
                           <div class="col-lg-4">
                            <div class="col-lg-12">
                            <strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Amount Paid </strong>
                            </div>
                            <div class="col-lg-12">
                                <input type="text" class="form-control" name="paymentamountpaid" readonly="" id="paymentamountpaid" maxlength="100" required=""/>
                            <p class="help-block" id="paymentamountpaid_msg">Enter / Select</p>
                            </div>
                            </div>
                            <div class="col-lg-4">
                            <div class="col-lg-12">
                            <strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Paid Date </strong>
                            </div>
                            <div class="col-lg-12">
                            <input type="text" class="form-control" name="paymentpaiddate" readonly="" id="paymentpaiddate" maxlength="100" required=""/>
                            <p class="help-block" id="paymentpaiddate_msg">Enter / Select</p>
                            </div>
                            </div>
                            <div class="col-lg-4">
                            <div class="col-lg-12">
                            <strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Due Amount </strong>
                            </div>
                            <div class="col-lg-12">
                            <input type="text" class="form-control" name="paymentdueamount" readonly="" id="paymentdueamount" maxlength="100" required=""/>
                            <p class="help-block" id="paymentdueamount_msg">Enter / Select</p>
                            </div>
                            </div>
                        </div>
                             <div class="col-lg-12 col-sm-12">&nbsp;</div>
                        <div class="col-lg-12 col-sm-12">
                            <div class="col-lg-4">
                            <div class="col-lg-12">
                            <strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Amount Pay </strong>
                            </div>
                            <div class="col-lg-12">
                            <input type="number" class="form-control" name="paymentamountpay" id="paymentamountpay" maxlength="100" required="" value="0"/>
                            <p class="help-block" id="paymentamountpay_msg">Enter / Select</p>
                            </div>
                            </div>
                            <div class="col-lg-8">
                            <div class="col-lg-12">
                            <strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Remark</strong>
                            </div>
                            <div class="col-lg-12">
                            <textarea type="text" class="form-control" name="paymentremark" id="paymentremark"  required=""></textarea>
                            <p class="help-block" id="paymentremark_msg">Enter / Select</p>
                            </div>
                            </div>
                        </div>
                              <div class="col-lg-12 col-sm-12">&nbsp;</div>
                              <div class="col-lg-12 col-sm-12">
                                  <button class="btn btn-lg btn-primary btn-block" type="button" name="paymentbutt" id="paymentbutt" >PAY</button>
                              </div>
                         </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="payment_history_menu">
            <div class="row">
            <div class="col-lg-12 col-sm-1">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h4>Payment History</h4>
                        </div>
                        <div class="panel-body">
                         <form id="addpaymentform">
                        <div class="col-lg-12 col-sm-12">
                           <div class="col-lg-4">
                            <div class="col-lg-12">
                            <strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Regd no </strong>
                            </div>
                            <div class="col-lg-12">
                            <input type="text" class="form-control" name="paymenthisregdno" id="paymenthisregdno" maxlength="100" required=""/>
                            <p class="help-block" id="paymenthisregdno_msg">Enter / Select</p>
                            </div>
                            </div>
                            <div class="col-lg-4">
                            <div class="col-lg-12">
                            <strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Mobile Number </strong>
                            </div>
                            <div class="col-lg-12">
                            <input type="text" class="form-control" name="paymenthisdrivermobile" id="paymenthisdrivermobile" maxlength="100" required="" readonly="readonly"/>
                            <p class="help-block" id="paymenthisdrivermobile_msg">Enter / Select</p>
                            </div>
                            </div>
                            <div class="col-lg-4">
                            <div class="col-lg-12">
                            <strong><span class="text-danger"><i class="fa fa-star fa-fw"></i></span> Name </strong>
                            </div>
                            <div class="col-lg-12">
                            <input type="text" class="form-control" name="paymenthisdrivername" id="paymenthisdrivername" maxlength="100" required="" readonly="readonly"/>
                           <p class="help-block" id="paymenthisdrivername_msg">Enter / Select</p>
                            </div>
                            </div>
                        </div>
                             <div class="col-lg-12">&nbsp;</div>
                             <div class="col-lg-12">
                                 <div id="displaypaymenthistory">

                                 </div>
                             </div>
                         </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
     </div>
</div>
        </div>
	</div><!--/.container-->
</div><!--/.page-container-->
<?php
	include_once(DOC_ROOT.INC.'footer.php');
?>

