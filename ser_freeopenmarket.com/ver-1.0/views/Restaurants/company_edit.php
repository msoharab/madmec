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
                <a href="#info" data-toggle="tab">
                    <i class="fa fa-info"></i>
                    Business Info
                    <span class="label label-primary pull-right">&nbsp;</span>
                </a>
            </li>
            <li>
                <a href="#bank" data-toggle="tab">
                    <i class="fa fa-bank"></i>
                    Bank Details
                    <span class="label label-primary pull-right">&nbsp;</span>
                </a>
            </li>
            <li>
                <a href="#services" data-toggle="tab">
                    <i class="fa fa-table">
                    </i>Services<span class="label label-primary pull-right">&nbsp;</span></a>
            </li>
            <li>
                <a href="#operatorsM" data-toggle="tab">
                    <i class="fa fa-tablet">
                    </i>Manage Operators<span class="label label-primary pull-right">&nbsp;</span></a>
            </li>
            <li>
                <a href="#operatorsL" data-toggle="tab">
                    <i class="fa fa-tablet">
                    </i>List Operators<span class="label label-primary pull-right">&nbsp;</span></a>
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
        obj.__CompanyEdit();
        obj.__Company();
    });
</script>