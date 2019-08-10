<?php
define("MODULE_0", "config.php");
require_once (MODULE_0);
?>
<!DOCTYPE html>
<html>
<head>
<title>Habeeb Enterprises a Ecommerce Online Shopping</title>
<!-- for-mobile-apps -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta property="og:title" content="Vide" />
<meta name="keywords" content="Habeeb Enterprises Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //for-mobile-apps -->
<link href="<?php echo URL ?>assets/css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- Custom Theme files -->
<link href="<?php echo URL ?>assets/css/style.css" rel='stylesheet' type='text/css' />
<!-- js -->
   <script src="<?php echo URL ?>assets/js/jquery-1.11.1.min.js"></script>
<!-- //js -->
<!-- start-smoth-scrolling -->
<script type="text/javascript" src="<?php echo URL ?>assets/js/move-top.js"></script>
<script type="text/javascript" src="<?php echo URL ?>assets/js/easing.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(".scroll").click(function(event){		
			event.preventDefault();
			$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
		});
	});
	setTimeout(function(){
	   window.location.href = '<?php echo URL ;?>mysql.php';
	}, 5000);
</script>
<link href="<?php echo URL ?>assets/css/font-awesome.css" rel="stylesheet"> 
</head>
<body>
<div class="header">
	<div class="container">
		<div class="logo">
			<h1 ><a href="index.php"><b>T<br>H<br>E</b>Habeeb Enterprises<span>The Best Supermarket</span></a></h1>
		</div>
		<div class="head-t">
			<?php 
				require_once('header_menu.php');
			?>
		</div>
	</div>			
</div>
<!---->
<div class="content-top">
	<div class="container">
		<div class="col-md-12">
			<center><h3>Welcome to Habeeb Enterprises - MySQL Setup</h3></center>
		</div>
	</div>
</div>
<div class="content-mid">
	<div class="container">
		<div class="col-md-12">
			&nbsp;
		</div>
		<div class="col-md-12">
				<?php
					$mysqli = new mysqli("127.0.0.1", "root", "");
					if (mysqli_connect_errno()) :
					?>
						<a href="<?php echo URL;?>mysql.php?db=1" class="btn btn-block btn-success"><i class="fa fa-arrow-up" aria-hidden="true"></i>MySQL Start</a>
					<?php
					else:
					?>
						<a href="<?php echo URL;?>mysql.php?db=0" class="btn btn-block btn-danger"><i class="fa fa-arrow-down" aria-hidden="true"></i>MySQL Stop</a>
					<?php
					endif;
				?>
		</div>
	</div>
</div>

<script>window.jQuery || document.write('<script src="<?php echo URL ?>assets/js/vendor/jquery-1.11.1.min.js"><\/script>')</script>
<script src="<?php echo URL ?>assets/js/jquery.vide.min.js"></script>
<div class="footer">
	<div class="container">
		<div class="clearfix"></div>
			<div class="footer-bottom">
				<h2 ><a href="index.php"><b>T<br>H<br>E</b>Habeeb Enterprises<span>The Best Supermarket</span></a></h2>
				<p class="fo-para">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris</p>
				<div class=" address">
					<div class="col-md-4 fo-grid1">
							<p><i class="fa fa-home" aria-hidden="true"></i>12K Street , 45 Building Road Canada.</p>
					</div>
					<div class="col-md-4 fo-grid1">
							<p><i class="fa fa-phone" aria-hidden="true"></i>+1234 758 839 , +1273 748 730</p>	
					</div>
					<div class="col-md-4 fo-grid1">
						<p><a href="mailto:info@example.com"><i class="fa fa-envelope-o" aria-hidden="true"></i>info@example1.com</a></p>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		<div class="copy-right">
			<p> &copy; 2016 Habeeb Enterprises. All Rights Reserved | Design by  <a href="#"> W3layouts</a></p>
		</div>
	</div>
</div>
<!-- //footer-->
<!-- smooth scrolling -->
<script type="text/javascript">
	$(document).ready(function() {
	/*
		var defaults = {
		containerID: 'toTop', // fading element id
		containerHoverID: 'toTopHover', // fading element hover id
		scrollSpeed: 1200,
		easingType: 'linear' 
		};
	*/								
	$().UItoTop({ easingType: 'easeOutQuart' });
	});
</script>
<a href="#" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
<!-- //smooth scrolling -->
<!-- for bootstrap working -->
<script src="<?php echo URL ?>assets/js/bootstrap.js"></script>
</body>
</html>
<?php
$mysql_root = str_replace("\\", "/", MYSQL_ROOT);
$temp_dir = str_replace("\\", "/", TMPDIR);
$bin_path = MYSQL_ROOT ."bin\\";
$mysql_start = MYSQL_ROOT."bin\\mysqld --defaults-file=".$bin_path."my.ini --standalone --console";
$mysql_stop = MYSQL_ROOT."bin\\mysqladmin -u root shutdown";
$myini = <<<HEREE
# Example MySQL config file for small systems.\r\n
#
# This is for a system with little memory (<= 64M) where MySQL is only used
# from time to time and it's important that the mysqld daemon
# doesn't use much resources.
#
# You can copy this file to
# {$mysql_root}bin/my.cnf to set global options,
# mysql-data-dir/my.cnf to set server-specific options (in this
# installation this directory is {$mysql_root}data) or
# ~/.my.cnf to set user-specific options.
#
# In this file, you can use all long options that a program supports.
# If you want to know which options a program supports, run the program
# with the "--help" option.

# The following options will be passed to all MySQL clients
[client] 
# password       = your_password 
port            = 3306 
socket          = "{$mysql_root}mysql.sock"

# Here follows entries for some specific programs 

# The MySQL server
[mysqld]
port= 3306
socket = "{$mysql_root}mysql.sock"
basedir = "{$mysql_root}" 
tmpdir = "{$temp_dir}" 
datadir = "{$mysql_root}data"
pid_file = "mysql.pid"
skip-external-locking
key_buffer = 16M
max_allowed_packet = 1M
table_cache = 64
sort_buffer_size = 512K
net_buffer_length = 8K
read_buffer_size = 256K
read_rnd_buffer_size = 512K
myisam_sort_buffer_size = 8M
log_error = "mysql_error.log"
 
#bind-address="127.0.0.1" 

# Where do all the plugins live
plugin_dir = "{$mysql_root}data/lib/plugin/" 

# Don't listen on a TCP/IP port at all. This can be a security enhancement,
# if all processes that need to connect to mysqld run on the same host.
# All interaction with mysqld must be made via Unix sockets or named pipes.
# Note that using this option without enabling named pipes on Windows
# (via the "enable-named-pipe" option) will render mysqld useless!
# 
# commented in by lampp security
#skip-networking
skip-federated

# Replication Master Server (default)
# binary logging is required for replication
# log-bin deactivated by default since XAMPP 1.4.11
#log-bin=mysql-bin

# required unique id between 1 and 2^32 - 1
# defaults to 1 if master-host is not set
# but will not function as a master if omitted
server-id	= 1

# Replication Slave (comment out master section to use this)
#
# To configure this host as a replication slave, you can choose between
# two methods :
#
# 1) Use the CHANGE MASTER TO command (fully described in our manual) -
#    the syntax is:
#
#    CHANGE MASTER TO MASTER_HOST=<host>, MASTER_PORT=<port>,
#    MASTER_USER=<user>, MASTER_PASSWORD=<password> ;
#
#    where you replace <host>, <user>, <password> by quoted strings and
#    <port> by the master's port number (3306 by default).
#
#    Example:
#
#    CHANGE MASTER TO MASTER_HOST='125.564.12.1', MASTER_PORT=3306,
#    MASTER_USER='joe', MASTER_PASSWORD='secret';
#
# OR
#
# 2) Set the variables below. However, in case you choose this method, then
#    start replication for the first time (even unsuccessfully, for example
#    if you mistyped the password in master-password and the slave fails to
#    connect), the slave will create a master.info file, and any later
#    change in this file to the variables' values below will be ignored and
#    overridden by the content of the master.info file, unless you shutdown
#    the slave server, delete master.info and restart the slaver server.
#    For that reason, you may want to leave the lines below untouched
#    (commented) and instead use CHANGE MASTER TO (see above)
#
# required unique id between 2 and 2^32 - 1
# (and different from the master)
# defaults to 2 if master-host is set
# but will not function as a slave if omitted
#server-id       = 2
#
# The replication master for this slave - required
#master-host     =   <hostname>
#
# The username the slave will use for authentication when connecting
# to the master - required
#master-user     =   <username>
#
# The password the slave will authenticate with when connecting to
# the master - required
#master-password =   <password>
#
# The port the master is listening on.
# optional - defaults to 3306
#master-port     =  <port>
#
# binary logging - not required for slaves, but recommended
#log-bin=mysql-bin


# Point the following paths to different dedicated disks
#tmpdir = "D:/WEB/habeebshop.com/xampp/tmp"
#log-update = /path-to-dedicated-directory/hostname

# Uncomment the following if you are using BDB tables
#bdb_cache_size = 4M
#bdb_max_lock = 10000

# Comment the following if you are using InnoDB tables
#skip-innodb
innodb_data_home_dir = "{$mysql_root}data"
innodb_data_file_path = ibdata1:10M:autoextend
innodb_log_group_home_dir = "{$mysql_root}data"
#innodb_log_arch_dir = "{$mysql_root}data"
## You can set .._buffer_pool_size up to 50 - 80 %
## of RAM but beware of setting memory usage too high
innodb_buffer_pool_size = 16M
innodb_additional_mem_pool_size = 2M
## Set .._log_file_size to 25 % of buffer pool size
innodb_log_file_size = 5M
innodb_log_buffer_size = 8M
innodb_flush_log_at_trx_commit = 1
innodb_lock_wait_timeout = 50

## UTF 8 Settings
#init-connect=\'SET NAMES utf8\'
#collation_server=utf8_unicode_ci
#character_set_server=utf8
#skip-character-set-client-handshake
#character_sets-dir="{$mysql_root}share/charsets"

[mysqldump]
quick
max_allowed_packet = 16M

[mysql]
no-auto-rehash
# Remove the next comment character if you are not familiar with SQL
#safe-updates

[isamchk]
key_buffer = 20M
sort_buffer_size = 20M
read_buffer = 2M
write_buffer = 2M

[myisamchk]
key_buffer = 20M
sort_buffer_size = 20M
read_buffer = 2M
write_buffer = 2M

[mysqlhotcopy]
interactive-timeout
  
HEREE;
$myini_file = $bin_path .'my.ini';
if(!file_exists($myini_file)){
	echo file_put_contents($myini_file, $myini) .$myini_file . '- File created <hr />';	
}
else{
	echo $myini_file .'- File Exist <hr />';	
}
if(isset($_GET["db"])){
	if($_GET["db"] == "1"){
		echo shell_exec ( $mysql_start );
	}
	if($_GET["db"] == "0"){
		echo shell_exec ( $mysql_stop );
	}
	echo '<script>
		window.location.href = "'.URL.'mysql.php";
	</script>';
}
exit(0);
?>