<?php
$AppCount = isset($this->idHolders["recharge"]["masterdata"]["ListCountries"]) ? (array) $this->idHolders["recharge"]["masterdata"]["ListCountries"] : false;
$AddCount1 = isset($this->idHolders["recharge"]["masterdata"]["AddCountries"]) ? (array) $this->idHolders["recharge"]["masterdata"]["AddCountries"] : false;
/*
  portal_countries_portal_continents_id
  portal_countries_Country //UNIQUE
  portal_countries_Capital
  portal_countries_ISO //UNIQUE
  portal_countries_ISO3 //UNIQUE
  portal_countries_ISO-Numeric //UNIQUE
  portal_countries_tld //UNIQUE
  portal_countries_fips //UNIQUE
  portal_countries_Phone
  portal_countries_CurrencyCode //UNIQUE
  portal_countries_CurrencyName
 */
?>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#listcountry" data-toggle="tab">List</a></li>
        <!--<li><a href="#addcountry" data-toggle="tab">Add</a></li>-->
    </ul>
    <div class="tab-content">
        <div class="tab-pane" id="addcountry">
            <!-- /.nav-tabs-custom -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"> Add Country</h3>
                </div><!-- /.box-header -->
                <form class="form-horizontal"
                      action=""
                      id="<?php echo $AddCount1["form"]; ?>"
                      name="<?php echo $AddCount1["form"]; ?>"
                      method="post">
                    <div class="content">
                        <section class="content">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box">
                                        <div class="box-body">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Continent</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control"
                                                                id="<?php echo $AddCount1["fields"][0]; ?>"
                                                                name="<?php echo $AddCount1["fields"][0]; ?>"
                                                                data-rules='{"required": true}'
                                                                data-messages='{"required": "Select Continent"}'>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="inputbusiness" class="col-sm-1 control-label">Country Name</label>
                                                    <div class="col-sm-5">
                                                        <input class="form-control"
                                                               id="<?php echo $AddCount1["fields"][1]; ?>"
                                                               name="<?php echo $AddCount1["fields"][1]; ?>"
                                                               data-rules='{"required": true,"minlength": "3"}'
                                                               data-messages='{"required": "Enter Country Name","minlength": "Length Should be minimum 3 numbers"}'
                                                               placeholder="Country Name" type="text" pattern="^[A-Za-z ]{4,100}$">
                                                    </div>
                                                    <label for="inputbusinessdate" class="col-sm-1 control-label">Country Capital</label>
                                                    <div class="col-sm-5">
                                                        <input class="form-control"
                                                               id="<?php echo $AddCount1["fields"][2]; ?>"
                                                               name="<?php echo $AddCount1["fields"][2]; ?>"
                                                               data-rules='{"required": true}'
                                                               data-messages='{"required": "Enter Country Capital"}'
                                                               placeholder="Country Capital" type="text" pattern="^[A-Za-z ]{3,100}$">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="inputowner" class="col-sm-1 control-label">Country ISO</label>
                                                    <div class="col-sm-3">
                                                        <input class="form-control"
                                                               id="<?php echo $AddCount1["fields"][3]; ?>"
                                                               name="<?php echo $AddCount1["fields"][3]; ?>"
                                                               data-rules='{"required": true,"minlength": "2"}'
                                                               data-messages='{"required": "Enter Country ISO","minlength": "Length Should be minimum 2 numbers"}'
                                                               placeholder="Country ISO" type="text" pattern="^[A-Za-z]{2,2}$" maxlength="2">
                                                    </div>
                                                    <label for="inputowner" class="col-sm-1 control-label">Country ISO3</label>
                                                    <div class="col-sm-3">
                                                        <input class="form-control"
                                                               id="<?php echo $AddCount1["fields"][4]; ?>"
                                                               name="<?php echo $AddCount1["fields"][4]; ?>"
                                                               data-rules='{"required": true,"minlength": "2"}'
                                                               data-messages='{"required": "Enter Country ISO3","minlength": "Length Should be minimum 2 numbers"}'
                                                               placeholder="Country ISO3" type="text" pattern="^[A-Za-z]{3,3}$" maxlength="3">
                                                    </div>
                                                    <label for="inputowner" class="col-sm-1 control-label">Country ISO Numeric</label>
                                                    <div class="col-sm-3">
                                                        <input class="form-control"
                                                               id="<?php echo $AddCount1["fields"][5]; ?>"
                                                               name="<?php echo $AddCount1["fields"][5]; ?>"
                                                               data-rules='{"required": true,"minlength": "2"}'
                                                               data-messages='{"required": "Enter Country ISO Numeric","minlength": "Length Should be minimum 2 numbers"}'
                                                               placeholder="Country ISO Numeric" type="text">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="inputowner" class="col-sm-1 control-label">Country TLD</label>
                                                    <div class="col-sm-3">
                                                        <input class="form-control"
                                                               id="<?php echo $AddCount1["fields"][6]; ?>"
                                                               name="<?php echo $AddCount1["fields"][6]; ?>"
                                                               data-rules='{"required": true,"minlength": "2"}'
                                                               data-messages='{"required": "Enter Country TLD","minlength": "Length Should be minimum 2 numbers"}'
                                                               placeholder="Country TLD" type="text">
                                                    </div>
                                                    <label for="inputowner" class="col-sm-1 control-label">Country FIPS</label>
                                                    <div class="col-sm-3">
                                                        <input class="form-control"
                                                               id="<?php echo $AddCount1["fields"][7]; ?>"
                                                               name="<?php echo $AddCount1["fields"][7]; ?>"
                                                               data-rules='{"required": true,"minlength": "2"}'
                                                               data-messages='{"required": "Enter Country FIPS","minlength": "Length Should be minimum 2 numbers"}'
                                                               placeholder="Country FIPS" type="text">
                                                    </div>
                                                    <label for="inputowner" class="col-sm-1 control-label">Country Cell Code</label>
                                                    <div class="col-sm-3">
                                                        <input class="form-control"
                                                               id="<?php echo $AddCount1["fields"][8]; ?>"
                                                               name="<?php echo $AddCount1["fields"][8]; ?>"
                                                               data-rules='{"required": true,"minlength": "2"}'
                                                               data-messages='{"required": "Enter Country Cell Code","minlength": "Length Should be minimum 3 numbers"}'
                                                               placeholder="Country Cell Code" type="text" pattern="^[0-9\+\-]{3,5}$">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="inputowner" class="col-sm-1 control-label">Currency Name</label>
                                                    <div class="col-sm-5">
                                                        <input class="form-control"
                                                               id="<?php echo $AddCount1["fields"][9]; ?>"
                                                               name="<?php echo $AddCount1["fields"][9]; ?>"
                                                               data-rules='{"required": true,"minlength": "2"}'
                                                               data-messages='{"required": "Enter Currency Name","minlength": "Length Should be minimum 2 numbers"}'
                                                               placeholder="Currency Name" type="text" pattern="^[A-Za-z ]{3,100}$">
                                                    </div>
                                                    <label for="inputowner" class="col-sm-1 control-label">Currency Code</label>
                                                    <div class="col-sm-5">
                                                        <input class="form-control"
                                                               id="<?php echo $AddCount1["fields"][10]; ?>"
                                                               name="<?php echo $AddCount1["fields"][10]; ?>"
                                                               data-rules='{"required": true,"minlength": "2"}'
                                                               data-messages='{"required": "Enter Currency Code","minlength": "Length Should be minimum 2 numbers"}'
                                                               placeholder="Currency Code" type="text" pattern="^[A-Za-z]{2,4}$">
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- /.box-body -->
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-5 col-sm-10">
                                            <button type="submit"
                                                    class="btn btn-danger"
                                                    id="<?php echo $AddCount1["fields"][12]; ?>"
                                                    name="<?php echo $AddCount1["fields"][12]; ?>"
                                                    data-rules='{}'
                                                    data-messages='{}'>Submit Details</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div><!-- /.tab-pane -->
                </form>
            </div>
            <!-- /. box -->
        </div>
        <div class="active tab-pane" id="listcountry">
            <div class="content">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        List Countries
                    </h1>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-body table-responsive">
                                    <table id="<?php echo $AppCount["fields"][0]; ?>" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Country Name</th>
                                                <th>Country Capital</th>
                                                <th>Country Fips</th>
                                                <th>Continent</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody id="<?php echo $AppCount["fields"][1]; ?>">
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </section><!-- /.content -->
            </div>
        </div>
    </div><!-- /.nav-tabs-custom -->
</div>
