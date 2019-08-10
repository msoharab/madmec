<div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">Folders</h3>
        <div class="box-tools">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <div class="box-body no-padding">
        <ul class="nav nav-pills nav-stacked">
            <li>
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
                <a href="#idProof" data-toggle="tab">
                    <i class="fa fa-try"></i>
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
        obj.__ApplicationEdit();
        obj.__Application();
    });
</script>