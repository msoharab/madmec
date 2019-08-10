<?php
$List = isset($this->idHolders["shop"]["sales"]["SaleList"]) ? (array) $this->idHolders["shop"]["sales"]["SaleList"] : false;
?>
<!--<div class="content">-->
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Sale List Details
        <small></small>
    </h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body table-responsive" >
                    <table id="<?php echo $List["fields"][0]; ?>" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Product Name</th>
                                <th>Product Rate</th>
                                <th>Quantity</th>
                                <th>Amount</th>
                                <!--<th>Delete</th>-->
                            </tr>
                        </thead>
						<tfoot>
							<tr>
								<th colspan="2" style="text-align:right">Total:</th>
								<th colspan="3" style="text-align:right"></th>
							</tr>
						</tfoot>
                        <tbody>
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
