<?php
$AppCount = isset($this->idHolders["recharge"]["masterdata"]["ListCountries"]) ? (array) $this->idHolders["recharge"]["masterdata"]["ListCountries"] : false;
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Application
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Application</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Folders</h3>
                        <div class="box-tools">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <ul class="nav nav-pills nav-stacked">
                            <li class="active">
                                <a href="#count" data-toggle="tab">
                                    <i class="fa fa-map"></i>
                                    Countries
                                    <span class="label label-primary pull-right">&nbsp;</span>
                                </a>
                            </li>
                            <li>
                                <a href="#curr" data-toggle="tab">
                                    <i class="fa fa-money"></i>
                                    Currencies
                                    <span class="label label-primary pull-right">&nbsp;</span>
                                </a>
                            </li>
                            <li>
                                <a href="#busity" data-toggle="tab">
                                    <i class="fa fa-cc-amex"></i>
                                    Business Type
                                    <span class="label label-primary pull-right">&nbsp;</span>
                                </a>
                            </li>
                            <li>
                                <a href="#mop" data-toggle="tab">
                                    <i class="fa fa-paypal"></i>
                                    Mode Of Payment
                                    <span class="label label-primary pull-right">&nbsp;</span>
                                </a>
                            </li>
                            <li>
                                <a href="#mos" data-toggle="tab">
                                    <i class="fa fa-server"></i>
                                    Mode Of Service
                                    <span class="label label-primary pull-right">&nbsp;</span>
                                </a>
                            </li>
                            <li>
                                <a href="#proto" data-toggle="tab">
                                    <i class="fa fa-product-hunt"></i>
                                    Protocols
                                    <span class="label label-primary pull-right">&nbsp;</span>
                                </a>
                            </li>
                            <li>
                                <a href="#rest" data-toggle="tab">
                                    <i class="fa fa-rmb"></i>
                                    Rest Parameters
                                    <span class="label label-primary pull-right">&nbsp;</span>
                                </a>
                            </li>
                            <li>
                                <a href="#idProof" data-toggle="tab">
                                    <i class="fa fa-info"></i>
                                    ID Proof
                                    <span class="label label-primary pull-right">&nbsp;</span>
                                </a>
                            </li>
                            <li>
                                <a href="#traff" data-toggle="tab">
                                    <i class="fa fa-try"></i>
                                    Traffic
                                    <span class="label label-primary pull-right">&nbsp;</span>
                                </a>
                            </li>
                        </ul>
                    </div><!-- /.box-body -->
                </div><!-- /. box -->
            </div><!-- /.col -->
            <div class="col-md-9">
                <div class="tab-content">
                    <div class="active tab-pane" id="count">
                        <h3>
                            Countries
                        </h3>
                        <?php
                        require_once 'portal_countries.php';
                        ?>
                    </div>
                    <!-- /.tab-content -->
                    <div class="tab-pane" id="curr">
                        <h3>
                            Currencies
                        </h3>
                        <?php
                        require_once 'portal_currencies.php';
                        ?>
                    </div>
                    <div class="tab-pane" id="busity">
                        <h3>
                            Business Type
                        </h3>
                        <?php
                        require_once 'portal_business_type.php';
                        ?>
                    </div>
                    <div class="tab-pane" id="mop">
                        <h3>
                            Mode Of Payment
                        </h3>
                        <?php
                        require_once 'portal_mode_of_payment.php';
                        ?>
                    </div>
                    <div class="tab-pane" id="mos">
                        <h3>
                            Mode Of Service
                        </h3>
                        <?php
                        require_once 'portal_mode_of_service.php';
                        ?>
                    </div>
                    <div class="tab-pane" id="proto">
                        <h3>
                            Protocols
                        </h3>
                        <?php
                        require_once 'portal_protocols.php';
                        ?>
                    </div>
                    <div class="tab-pane" id="rest">
                        <h3>
                            Rest Parameters
                        </h3>
                        <?php
                        require_once 'rest_parameters.php';
                        ?>
                    </div>
                    <div class="tab-pane" id="idProof">
                        <h3>
                            ID Proof
                        </h3>
                        <?php
                        require_once 'user_proof.php';
                        ?>
                    </div>
                    <div class="tab-pane" id="traff">
                        <h3>
                            Traffic
                        </h3>
                        <?php
                        require_once 'portal_traffic.php';
                        ?>
                    </div>
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div>
<!--<script type="text/javascript">
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
        obj.__Application();
    });
</script>-->