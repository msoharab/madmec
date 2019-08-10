<?php
//  +------------------------------------------------------------------------+
//  | template.header.php                                                    |
//  +------------------------------------------------------------------------+
if (isset($header) == false)
	exit();
?>
<!doctype html>
<?php echo $header['head']; ?>
<body style="overflow-x: hidden;">
<div id="tooltip"></div>
<div id="preloader"></div>
<div id="wrapper_container">
<div class="wrapper">
<!-- <div id="menu_container"> -->
<div id="menu_container">
<header class="main-header">
<nav class="navbar navbar-static-top">
<div class="container">
<div class="navbar-header">
<a href="" class="navbar-brand"><b>Thyagraj</b></a>
<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
<i class="fa fa-bars"></i>
</button>
</div>
<!-- Collect the nav links, forms, and other content for toggling -->
<div class="collapse navbar-collapse pull-left" id="navbar-collapse">
<?php
echo $header['menu'];
?>
</div><!-- <a href="http://www.netjukebox.nl/" class="netjukebox"></a> /.navbar-collapse -->
</div><!-- /.container-fluid -->
</nav>
</header>
<?php
//echo $header['submenu'];
?>
</div>
<!-- </div> end menu_container -->
<div id="content_container" class="content-wrapper">
<div class="row">
<div class="col-lg-10 col-lg-offset-1 table-responsive">
<?php
echo $header['no_javascript'];
echo $header['navigator'];

