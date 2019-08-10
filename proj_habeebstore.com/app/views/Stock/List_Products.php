<?php
$List = isset($this->idHolders["shop"]["stock"]["ListProducts"]) ? (array) $this->idHolders["shop"]["stock"]["ListProducts"] : false;
?>
<!--<div class="content">-->
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        List Details
        <small></small>
    </h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body table-responsive">
                    <table id="<?php echo $List["fields"][0]; ?>" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product Name</th>
                                <th>Product Rate</th>
                                <th>Weight/Unit</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody id="<?php echo $List["fields"][1]; ?>">
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->
<script>
$(document).ready(function () {
	var this_js_script = $("script[src$='Stock.js']");
	if (this_js_script) {
		var flag = this_js_script.attr('data-autoloader');
		if (flag === 'true') {
			LogMessages('I am In Stock');
			var para = getJSONIds({
				autoloader: true,
				action: 'getIdHolders',
				url: EGPCSURL + 'Stock/getIdHolders',
				type: 'POST',
				dataType: 'JSON'
			}).shop.stock;
			var obj = new stockController();
			obj.__constructor(para);
			obj.__AddProduct();
		}
		else {
			LogMessages('I am Out Stock');
		}
	}
});
</script>