<?php
	define("MODULE_0","config.php");
	require_once (MODULE_0);
    require_once(DOC_ROOT.INC.'header.php');
?>
<nav class="navbar navbar-inverse navbar-static-top" role="navigation" id="nav-top">
	<div class="navbar-header">
		<a class="navbar-brand" href="<?php echo URL; ?>"><?php echo SOFT_NAME; ?></a>
	</div>
</nav>
<div class="row">
	<div class="col-lg-8 col-md-offset-2">
		<h1 class="page-header text-default"><i class="fa fa-lock fa-x2 fa-fw"></i>&nbsp;Error</h1>
	</div>
	<div class="col-lg-8 col-md-offset-2">
		<div class="panel panel-danger">
			<div class="panel-heading">
				<h1 class="panel-title">Unknown Error Has Occured</h1>
			</div>
			<div class="panel-body">
				<strong>Sorry for the inconvinence !!! Click here to Troubleshoot the problem <a class="btn btn-danger btn-md" href="<?php echo URL; ?>">Troubleshoot</a></strong>
			</div>
		</div>
	</div>
</div>
<?php
   require_once(DOC_ROOT.INC.'footer.php');
?>