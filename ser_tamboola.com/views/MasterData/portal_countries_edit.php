<?php
$EditCountry = isset($this->idHolders["recharge"]["masterdata"]["EditCountries"]) ? (array) $this->idHolders["recharge"]["masterdata"]["EditCountries"] : false;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Countries
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Edit Countries</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit</h3>
                    </div><!-- /.box-header -->
                    <form class="form-horizontal"
                          action=""
                          id="<?php echo $EditCountry["form"]; ?>"
                          name="<?php echo $EditCountry["form"]; ?>"
                          method="post">
                        <div class="content">
                            <section class="content">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="box">
                                            <div class="box-body">
                                                <input type="hidden"
                                                       name="<?php echo $EditCountry["fields"][11]; ?>"
                                                       id="<?php echo $EditCountry["fields"][11]; ?>"
                                                       data-rules='{}'
                                                       data-messages='{}'
                                                       value="<?php echo base64_encode($this->getuserDet["data"]["portal_countries_id"]); ?>" />
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Continent</label>
                                                        <div class="col-sm-9">
                                                            <select class="form-control"
                                                                    id="<?php echo $EditCountry["fields"][0]; ?>"
                                                                    name="<?php echo $EditCountry["fields"][0]; ?>"
                                                                    value="<?php echo trim($this->getuserDet["data"]["portal_continents_continent_name"]); ?>"
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
                                                                   id="<?php echo $EditCountry["fields"][1]; ?>"
                                                                   name="<?php echo $EditCountry["fields"][1]; ?>"
                                                                   value="<?php echo trim($this->getuserDet["data"]["portal_countries_Country"]); ?>"
                                                                   data-rules='{"required": true,"minlength": "3"}'
                                                                   data-messages='{"required": "Enter Country Name","minlength": "Length Should be minimum 3 numbers"}'
                                                                   placeholder="Country Name" type="text" pattern="^[A-Za-z ]{4,100}$">
                                                        </div>
                                                        <label for="inputbusinessdate" class="col-sm-1 control-label">Country Capital</label>
                                                        <div class="col-sm-5">
                                                            <input class="form-control"
                                                                   id="<?php echo $EditCountry["fields"][2]; ?>"
                                                                   name="<?php echo $EditCountry["fields"][2]; ?>"
                                                                   value="<?php echo trim($this->getuserDet["data"]["portal_countries_Capital"]); ?>"
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
                                                                   id="<?php echo $EditCountry["fields"][3]; ?>"
                                                                   name="<?php echo $EditCountry["fields"][3]; ?>"
                                                                   value="<?php echo trim($this->getuserDet["data"]["portal_countries_ISO"]); ?>"
                                                                   data-rules='{"required": true,"minlength": "2"}'
                                                                   data-messages='{"required": "Enter Country ISO","minlength": "Length Should be minimum 2 numbers"}'
                                                                   placeholder="Country ISO" type="text" pattern="^[A-Za-z]{2,2}$" maxlength="2">
                                                        </div>
                                                        <label for="inputowner" class="col-sm-1 control-label">Country ISO3</label>
                                                        <div class="col-sm-3">
                                                            <input class="form-control"
                                                                   id="<?php echo $EditCountry["fields"][4]; ?>"
                                                                   name="<?php echo $EditCountry["fields"][4]; ?>"
                                                                   value="<?php echo trim($this->getuserDet["data"]["portal_countries_ISO3"]); ?>"
                                                                   data-rules='{"required": true,"minlength": "2"}'
                                                                   data-messages='{"required": "Enter Country ISO3","minlength": "Length Should be minimum 2 numbers"}'
                                                                   placeholder="Country ISO3" type="text" maxlength="2">
                                                        </div>
                                                        <label for="inputowner" class="col-sm-1 control-label">Country ISO Numeric</label>
                                                        <div class="col-sm-3">
                                                            <input class="form-control"
                                                                   id="<?php echo $EditCountry["fields"][5]; ?>"
                                                                   name="<?php echo $EditCountry["fields"][5]; ?>"
                                                                   value="<?php echo trim($this->getuserDet["data"]["portal_countries_ISO-Numeric"]); ?>"
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
                                                                   id="<?php echo $EditCountry["fields"][6]; ?>"
                                                                   name="<?php echo $EditCountry["fields"][6]; ?>"
                                                                   value="<?php echo trim($this->getuserDet["data"]["portal_countries_tld"]); ?>"
                                                                   data-rules='{"required": true,"minlength": "2"}'
                                                                   data-messages='{"required": "Enter Country TLD","minlength": "Length Should be minimum 2 numbers"}'
                                                                   placeholder="Country TLD" type="text">
                                                        </div>
                                                        <label for="inputowner" class="col-sm-1 control-label">Country FIPS</label>
                                                        <div class="col-sm-3">
                                                            <input class="form-control"
                                                                   id="<?php echo $EditCountry["fields"][7]; ?>"
                                                                   name="<?php echo $EditCountry["fields"][7]; ?>"
                                                                   value="<?php echo trim($this->getuserDet["data"]["portal_countries_fips"]); ?>"
                                                                   data-rules='{"required": true,"minlength": "2"}'
                                                                   data-messages='{"required": "Enter Country FIPS","minlength": "Length Should be minimum 2 numbers"}'
                                                                   placeholder="Country FIPS" type="text">
                                                        </div>
                                                        <label for="inputowner" class="col-sm-1 control-label">Country Cell Code</label>
                                                        <div class="col-sm-3">
                                                            <input class="form-control"
                                                                   id="<?php echo $EditCountry["fields"][8]; ?>"
                                                                   name="<?php echo $EditCountry["fields"][8]; ?>"
                                                                   value="<?php echo trim($this->getuserDet["data"]["portal_countries_Phone"]); ?>"
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
                                                                   id="<?php echo $EditCountry["fields"][9]; ?>"
                                                                   name="<?php echo $EditCountry["fields"][9]; ?>"
                                                                   value="<?php echo trim($this->getuserDet["data"]["portal_countries_CurrencyName"]); ?>"
                                                                   data-rules='{"required": true,"minlength": "2"}'
                                                                   data-messages='{"required": "Enter Currency Name","minlength": "Length Should be minimum 2 numbers"}'
                                                                   placeholder="Currency Name" type="text" pattern="^[A-Za-z ]{3,100}$">
                                                        </div>
                                                        <label for="inputowner" class="col-sm-1 control-label">Currency Code</label>
                                                        <div class="col-sm-5">
                                                            <input class="form-control"
                                                                   id="<?php echo $EditCountry["fields"][10]; ?>"
                                                                   name="<?php echo $EditCountry["fields"][10]; ?>"
                                                                   value="<?php echo trim($this->getuserDet["data"]["portal_countries_CurrencyCode"]); ?>"
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
                                                        id="<?php echo $EditCountry["fields"][12]; ?>"
                                                        name="<?php echo $EditCountry["fields"][12]; ?>"
                                                        data-rules='{}'
                                                        data-messages='{}'>Update Details</button>
                                            </div>
                                        </div>
                                    </div>
                            </section>
                        </div><!-- /.tab-pane -->
                    </form>
                </div>
            </div>
            <!-- /. box -->
        </div>
    </section>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var para = getJSONIds({
            autoloader: true,
            action: 'getIdHolders',
            url: URL + 'MasterData/getIdHolders',
            type: 'POST',
            dataType: 'JSON'
        }).tamboola.masterdata;
        var obj = new masterdataController();
        obj.__constructor(para);
        obj.__CountriesEdit();
    });
</script>
