<?php
define("MODULE_1", "config.php");
define("MODULE_2", "database.php");
require_once(MODULE_1);
require_once(CONFIG_ROOT . MODULE_1);
require_once(CONFIG_ROOT . MODULE_2);
include_once(DOC_ROOT . INC . 'header.php');
?>
<div class="page-container">
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="offcanvas" data-target=".sidebar-nav">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="javascript:void(0);" id="homepage">Driver / Rider Tracker</a>
        </div>	
        <div style="color: white;padding: 15px 50px 5px 50px;float: right;font-size: 16px;"> <?php echo date("d / M / Y"); ?> <a href="javascript:void(0);" id="signout" class="btn btn-danger square-btn-adjust">Logout</a> </div>
    </nav>
    <div class="container-fluid" id="mainOutput">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#TrackUser_menu" data-toggle="tab" id="TrackUser">Track User</a></li>
            <li><a href="#AddUserTracker_menu" data-toggle="tab" id="AddUserTracker">Add User</a></li>
        </ul>
        <div class="row">
            <div class="col-lg-12">&nbsp;</div>
            <div class="col-lg-12">
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="TrackUser_menu">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-lg-8">
                                    <div style="width:100%;height:550px;" id="map-panel">
                                        <input class="form-control" id="pac-input" class="controls" type="text" placeholder="Search Box">
                                        <div id="map-canvas">Loading Google map ......</div>
                                    </div>
                                </div><!--/col-->
                                <div class="col-lg-4">
                                    <div id="content-pane" class="well" style="overflow-y: scroll;overflow-x: none;">
                                        <h3>Result</h3>
                                        <hr />
                                        <div id="inputs">
                                            <!--
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
                                            <p>
                                            <h4 ><strong>Save Locations.</strong></h4>
                                            <button class="btn btn-primary" id="saveLocations" >Save</button>
                                            </p>
                                            -->
                                            <p>
                                            <h4 ><strong>Scan Movements.</strong></h4>
                                            <button class="btn btn-primary" id="moveLocations" >Scan</button>
                                            </p>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h4><strong>Active User.</strong></h4>

                                                </div>
                                                <div class="col-lg-12" id="listusers">
                                                    Loading......
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--/col-->
                            </div><!--/row-->
                        </div>
                    </div>
                    <div class="tab-pane fade" id="AddUserTracker_menu">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#AddUser_menu" data-toggle="tab" id="AddUser">Add</a></li>
                            <li><a href="#ListUser_menu" data-toggle="tab" id="ListUser">List</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="AddUser_menu">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><h5>Add Rider / Driver</h5></div>
                                    <div class="panel-body">
                                        <form id="genbillform" name="genbillform" action="">
                                            <div class="form-group">
                                                <label>Reged.no (Ex. KA01B1234) </label>
                                                <input type="text" class="form-control" id="regdno" name="regdno" maxlength="100" />
                                                <p class="form-group text-danger" id="regdnoerr"> </p>
                                            </div>
                                            <div class="form-group">
                                                <label>Driver Name </label>
                                                <input type="text" class="form-control"  id="drivername" name="drivername" maxlength="100" />
                                                <p class="form-group text-danger" id="drivernameerr"></p>
                                            </div>
                                            <div class="form-group">
                                                <label>Driver Email </label>
                                                <input class="form-control"  id="driveremail" name="driveremail" maxlength="100" />
                                                <p class="form-group text-danger" id="driveremailerr"></p>
                                            </div>
                                            <div class="form-group">
                                                <label>Mobile Number </label>
                                                <input class="form-control"  id="drivermobile" name="drivermobile">
                                                <p class="form-group text-danger" id="drivermobileerr"></p>
                                            </div>
                                            <div class="form-group">
                                                <label>User Type </label>
                                                <select class="form-control"  id="usertype" name="usertype">
                                                    <option value="3" selected="selected">Driver</option>
                                                    <option value="4">Rider</option>
                                                </select>
                                                <p class="form-group text-danger" id="drivertypeerr"></p>
                                            </div>
                                            <div class="form-group">&nbsp;</div>
                                            <div class="form-group">
                                                <button type="button" class="btn btn-primary" name="formreferesh" id="formreferesh">Refresh</button>
                                                <button type="button" class="btn btn-primary" name="saveform" id="saveform">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>	
                            <div class="tab-pane fade" id="ListUser_menu">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><h5>List Rider / Driver</h5></div>
                                    <div class="panel-body">
                                        Loading.........<i class="fa fa-spinner fa-fw fa-spin"></i>
                                    </div>
                                </div>	
                            </div>	
                        </div>	
                    </div>
                </div>
            </div>
            <div class="col-lg-12">&nbsp;</div>
        </div>
    </div><!--/.container-->
</div><!--/.page-container-->
<?php
include_once(DOC_ROOT . INC . 'footer.php');
?>

