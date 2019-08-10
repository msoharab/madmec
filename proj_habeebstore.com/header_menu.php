<ul class="card">
	<li><a href="<?php echo URL;?>" ><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>
	<li><a href="#" id="mysql"><i class="fa fa-gears" aria-hidden="true"></i>MySQL</a></li>
	<li><a href="#" id="database"><i class="fa fa-database" aria-hidden="true"></i>DataBase</a></li>
	<li><a href="#" id="phpMyAdmin"><i class="fa fa-database" aria-hidden="true"></i>phpMyAdmin</a></li>
	<li><a href="<?php echo APP_URL;?>" ><i class="fa fa-dashboard" aria-hidden="true"></i>Manage Store</a></li>
</ul>	
<script type="text/javascript">
	$(document).ready(function($) {
		$("#mysql").click(function(event){	
			event.preventDefault();
			var pass  = window.prompt("Enter Password");
			if(pass==="superadmindb"){
				window.location.href = '<?php echo URL ;?>mysql.php';
			}else{
				alert("Error the password ☻♥☻");
				return;
			}
		});
		$("#database").click(function(event){		
			event.preventDefault();
			var pass  = window.prompt("Enter Password");
			if(pass==="superadmindb"){
				window.location.href = '<?php echo URL ;?>database.php';
			}else{
				alert("Error the password ☻♥☻");
				return;
			}
		});
		$("#phpMyAdmin").click(function(event){		
			event.preventDefault();
			var pass  = window.prompt("Enter Password");
			if(pass==="superadmindb"){
				window.location.href = '<?php echo phpMyAdmin_URL;?>';
			}else{
				alert("Error the password ☻♥☻");
				return;
			}
		});
	});
</script>

