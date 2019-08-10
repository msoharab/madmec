<?php
$enqList = isset($this->idHolders["tamboola"]["enquiry"]["EnquiryList"]) ? (array) $this->idHolders["tamboola"]["enquiry"]["EnquiryList"] : false;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Enquiry
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $this->config["URL"] . $this->config["CTRL_19"]; ?>">
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
            <li class="active">Enquiry</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><strong>Enquiry List</strong></h3>
                    </div>
                    <div class="box-body table-responsive">
                        <table id="<?php echo $enqList["fields"][0]; ?>" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Customer Name</th>
                                    <th>Cell Number</th>
                                    <th>Email</th>
                                    <th>Referred</th>
                                    <th>Trainer</th>
                                    <th>Joining Probability</th>
                                    <th>Comments</th>
                                    <th>Date</th>
                                    <th>Fitness Goals</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody id="<?php echo $enqList["fields"][1]; ?>">
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var this_js_script = $("script[src$='Enquiry.js']");
        if (this_js_script) {
            var flag = this_js_script.attr('data-autoloader');
            if (flag === 'true') {
                LogMessages('I am In Gym');
                var para = getJSONIds({
                    autoloader: true,
                    action: 'getIdHolders',
                    url: URL + 'Enquiry/getIdHolders',
                    type: 'POST',
                    dataType: 'JSON'
                }).tamboola.enquiry;
                var obj = new enquiryController();
                obj.__constructor(para);
                obj.__ListEnq();
            }
            else {
                LogMessages('I am Out Gym');
            }
        }
    });
</script>
