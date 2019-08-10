<?php 
$List = isset($this->idHolders["shop"]["dashbord"]["SaleList"]) ? (array) $this->idHolders["shop"]["dashbord"]["SaleList"] : false;
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
        </h1>
        <ol class="breadcrumb">
            <li class="active">Dashboard</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-12">
							<table id="<?php echo $List["fields"][0]; ?>" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>#</th>
										<th>Reference</th>
										<th>Total Items</th>
										<th>Total Amount</th>
										<th>Date</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th colspan="2" style="text-align:right">Today's Bills = </th>
										<th colspan="3" style="text-align:right"></th>
									</tr>
								</tfoot>
								<tbody>
								</tbody>
							</table>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.box-footer -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper --><!-- /.content-wrapper -->