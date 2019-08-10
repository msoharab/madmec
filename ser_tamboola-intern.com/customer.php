<?php
class customer{
	protected $parameters = array();
	function __construct($para	=	false){
		$this->parameters=$para;	
	}	 
	function LoadForm($num){
		   $i=0;
		/*	echo '<div class="row output-panels" id="ctrlGMemberForm">
				<h1 class="page-header text-primary">
						<img class="img-circle" src="" border="0" width="30" height="30"/>&nbsp;Add Group
				</h1>
				<div class="col-lg-12" id="ctGMemberForm">
					<div class="row">
		       <div id="loader" class="col-lg-12">
			      <div class="panel panel-primary">
				     <div class="panel-heading">
				      	<h4>Number of members in a group</h4>
				     </div>
				  <div class="panel-body">
					<form role="form" id="generateform" name="addgroupform" method="POST">
						<fieldset>
							<div class="row">
								<div class="col-lg-12">
									<label>Add '.$num.' members in Group</label>
									<span>
										
									</span>
									<p class="help-block"></p>
								</div>
								<div class="col-lg-12">&nbsp;</div>
								<div class="col-lg-12">
									<input type="button" class="btn btn-lg btn-success btn-block" value="Save" id="generateFormbtn'.$i.'"/>
								</div>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>
				</div>                 ';							

		/* echo '<script>	
			$(document).ready(function(){
			
			var gymdynamic = {
				nav		: 	".gymLink",
				outdiv	:	"#printrs",
			};
			var obj=new load_dashboard();
			obj.selectGYM(gymdynamic);

		});
	</script>';
  
	 }
    */
    
     echo '<div class="row output-panels" id="ctrlCGroupAdd">
			 	<h1 class="page-header text-primary">
			 			<img class="img-circle" src=" " border="0" width="30" height="30"/>&nbsp;Add Group
			 	</h1>
			 	<div class="col-lg-12" id="ctCGroupAdd">
			 		<div class="row">
		        <div id="loader" class="col-lg-12">
			       <div class="panel panel-primary">
				      <div class="panel-heading">
				       	<h4>Number of members in a group</h4>
				      </div>
				   <div class="panel-body">
				 	<form role="form" id="addgroupform" name="addgroupform" method="POST">
				 		<fieldset>
				 			<div class="row">
				 				<div class="col-lg-12">
				 					<label>Number of members :</label>
				 					<span>
				 						<input type="text" class="form-control" id="num_mem" placeholder="Number of members" />
				 					</span>
				 					<p class="help-block"></p>
				 				</div>
				 				<div class="col-lg-12">&nbsp;</div>
				 				<div class="col-lg-12">
				 					<input type="button" class="btn btn-lg btn-success btn-block" value="Go" id="addGroupForm"/>
				 				</div>
				 			</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>
				</div>
			</div>';	
	}
	
}
?>
