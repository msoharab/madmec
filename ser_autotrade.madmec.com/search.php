<?php

define("MODULE_0", "config.php");
require_once (MODULE_0);
$parameters = array(
    "action" => (isset($_POST["action"]) ) ? $_POST["action"] : false,
    "autoloader" => (isset($_POST["autoloader"])) ? $_POST["autoloader"] : false,
    "SearchType" => (isset($_POST["ser"]["SearchType"]) && $_POST["ser"]["SearchType"] == "true") ? true : false,
    "UserName" => (isset($_POST["ser"]["UserName"]) && $_POST["ser"]["UserName"] == "true") ? true : false,
    "Products" => (isset($_POST["ser"]["Products"]) && $_POST["ser"]["Products"] == "true") ? true : false,
    "ViewAllUser" => (isset($_POST["ser"]["ViewAllUser"]) && $_POST["ser"]["ViewAllUser"] == "true") ? true : false,
    "Due" => (isset($_POST["ser"]["Due"]) && $_POST["ser"]["Due"] == "true") ? true : false,
    "All" => (isset($_POST["ser"]["All"]) && $_POST["ser"]["All"] == "true") ? true : false
);
unset($_POST);

function main() {
    global $parameters;
    $link = MySQLconnect(DBHOST, DBUSER, DBPASS);
    if (get_resource_type($link) == 'mysql link') {
        if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
            if (!ValidateAdmin()) {
                session_destroy();
                echo "logout";
            } else {
                switch ($parameters["action"]) {
                    case "LoadSearchHTML":
                        LoadSearchHTML($parameters);
                        break;
                }
            }
        }
    }
    if (get_resource_type($link) == 'mysql link')
        mysql_close($link);
    exit(0);
}

function LoadSearchHTML($parameters) {
    $searchJson = array(
        "menuDiv" => '',
        "htmlDiv" => ''
    );
    $usernames = array(
        "user_names_html" => '',
        "user_types_html" => '',
    );
    $products = array(
        "user_products_html" => '',
    );
    $menuDiv = '';
    $htmlDiv = '';
    /* User Info */
    $query = 'SELECT (SELECT GROUP_CONCAT(DISTINCT(`user_name`)) FROM `user_profile` ORDER BY `user_name` ASC) AS  `user_names`,
					(SELECT GROUP_CONCAT(DISTINCT(`user_type`),\'☻☻☻\') FROM `user_type` ORDER BY `user_type` ASC) AS `user_types`,
					(SELECT GROUP_CONCAT(DISTINCT(`cell_number`),\'☻☻☻\')FROM `cell_numbers` ORDER BY `cell_number` ASC) AS `user_nums`,
					(SELECT GROUP_CONCAT(DISTINCT(`due_amount`),\'☻☻☻\')FROM `due` ORDER BY `due_amount` ASC) AS `user_dues`';
    /* Products */
    $query1 = 'SELECT (SELECT GROUP_CONCAT(DISTINCT(`name`)) FROM `product` ORDER BY `name` ASC) AS `user_products`';
    $res = executeQuery($query);
    if (mysql_num_rows($res)) {
        $row = mysql_fetch_assoc($res);
        $usernames["user_names"] = explode(",", $row['user_names']);
        $usernames["user_types"] = explode("☻☻☻", $row['user_types']);
        $usernames["user_nums"] = explode("☻☻☻,", $row['user_nums']);
        $usernames["user_dues"] = explode("☻☻☻,", $row['user_dues']);
    }
    $res1 = executeQuery($query1);
    if (mysql_num_rows($res1)) {
        $row = mysql_fetch_assoc($res1);
        $products["user_products"] = explode(",", $row['user_products']);
    }
    if ($parameters["UserName"]) {
        $auto_name = json_encode($usernames["user_names"]);
        $auto_num = json_encode($usernames["user_nums"]);
        $auto_due = json_encode($usernames["user_dues"]);
        returnUserOptions($usernames);
        $menuDiv .= '<li><a href="javascript:void(0);" class="srch_type">UserName</a></li>';
        //$htmlDiv .='"'. $auto_num.'"';
        $htmlDiv .= '<div id="UserName_ser" class="row ser_crit text-primary">
							<div class="col-lg-12"><strong>UserInfo</strong></div>
							<div class="col-lg-12">
							<div class="col-lg-3">
								<input class="form-control" type="text"  placeholder="User Name" id="user_opt"/>
							</div>
							<div class="col-lg-3">
								<input class="form-control" type="text"  placeholder="Cell Number" id="cell_opt"/>
							</div>
							<div class="col-md-3">
								<select id="type_opt" class="form-control">
										' . $usernames["user_types_html"] . '
								</select>
							</div>							
							<div class="col-xs-2">
									<button id="UserName_ser_but" class="btn btn-primary" type="button"">
										<i class="fa fa-search"></i>
									</button>
								</div>
							</div>					
						</div>
						<script>
							 $(function() {
							   $("#user_opt").autocomplete({
								source:' . $auto_name . '
							   });
							  });
						</script>';
    }
    if ($parameters["Products"]) {
        $auto_products = json_encode($products["user_products"]);
        returnProductOptions($products);
        $menuDiv .= '<li><a href="javascript:void(0);" class="srch_type">Products</a></li>';
        $htmlDiv .= '<div id="Products_ser" class="row ser_crit text-primary">
						<div class="col-lg-12"><strong>Product</strong></div>
							<div class="col-lg-12">
								<div class="col-md-3">
									<input class="form-control" type="text"  placeholder="Product Name" id="pname"/>
								</div>
								 <script>
								 $(function() {
	                               $("#pname").autocomplete({
	                               source:' . $auto_products . '
	                               });
	                              });
                               </script>
								<div class="col-xs-2">
									<button class="btn btn-primary" type="button" id="Products_ser_but">
										<i class="fa fa-search"></i>
									</button>
								</div>
							</div>
							</div>';
    }
    if ($parameters["ViewAllUser"]) {
        $menuDiv .= '<li><a href="javascript:void(0);" class="srch_type" >ViewAllUser</a></li>';
        $htmlDiv .= '<div id="ViewAllUser_ser" class="row ser_crit text-primary">

							<div class="col-lg-12">
								<button class="btn btn-lg btn-primary btn-block" type="button" id="ViewAllUser_ser_but">
										View All User
								</button>
							</div>
						</div>';
    }
    if ($parameters["Due"]) {
        $menuDiv .= '<li><a href="javascript:void(0);" class="srch_type">Due</a></li>';
        $htmlDiv .= '<div id="Due_ser" class="row ser_crit text-primary">
							<div class="col-lg-12"><strong>Due Amount</strong></div>
							<div class="col-lg-12">
								<div class="col-md-3">
									<input class="form-control" type="text"  placeholder="Due Amount From" id="dueamt1"/>
								</div>
								<div class="col-md-3">
									<input class="form-control" type="text"  placeholder="Due Amount To" id="dueamt2"/>
								</div>
								<div class="col-md-3">
									<input class="form-control" type="text"  placeholder="Due date" id="ddate" readonly="readonly"/>
								</div>
								<div class="col-xs-2">
									<button class="btn btn-primary" type="button" id="Due_ser_but">
										<i class="fa fa-search"></i>
									</button>
								</div>
							</div>
						</div>';
    }
    if ($parameters["All"]) {
        $auto_name = json_encode($usernames["user_names"]);
        returnUserOptions($usernames);
        $menuDiv .= '<li><a href="javascript:void(0);" class="srch_type">All</a></li>';
        $htmlDiv .= '<div id="All_ser" class="row ser_crit text-primary">
							
							<div class="row" id="UserName_ser_all">
								<div class="col-lg-12">&nbsp;&nbsp;&nbsp;<strong>UserInfo</strong></div>
								<div class="col-lg-12">
									<div class="col-lg-3">
										<input class="form-control" type="text"  placeholder="User Name" id="auser_opt"/>
									</div>
									<div class="col-lg-3">
										<input class="form-control" type="text"  placeholder="Cell Number" id="acell_opt"/>
									</div>
									<div class="col-md-3">
										<select id="atype_opt" class="form-control">
												' . $usernames["user_types_html"] . '
										</select>
									</div>			
								</div>											
							</div>
							
							<div class="row" id="Products_ser_all">
								<div class="col-lg-12">&nbsp;&nbsp;&nbsp;<strong>Product</strong></div>
									<div class="col-lg-12">
										<div class="col-md-3">
											<input class="form-control" type="text"  placeholder="Product Name" id="apname"/>
										</div>
									</div>
							</div>
							
							<div class="row" id="Due_ser_all">
								<div class="col-lg-12">&nbsp;&nbsp;&nbsp;<strong>Due Amount</strong></div>
								<div class="col-lg-12">
									<div class="col-md-3">
										<input class="form-control" type="text"  placeholder="Due Amount From" id="adueamt1"/>
									</div>
									<div class="col-md-3">
										<input class="form-control" type="text"  placeholder="Due Amount To" id="adueamt2"/>
									</div>
									<div class="col-md-3">
										<input class="form-control" type="text"  placeholder="Due date" id="addate" readonly="readonly"/>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-lg-12">&nbsp;</div>
								<div class="col-lg-12">
									<div class="col-xs-2">
										<button class="btn btn-primary" type="button" id="All_ser_but">
											<i class="fa fa-search"></i>
										</button>
									</div>
								</div>
							</div>
					</div>
					<script>
							 $(function() {
                               $("#auser_opt").autocomplete({
								source:' . $auto_name . '
                               });
                               $("#apname").autocomplete({
	                            source:' . $auto_products . '
	                           });
                              });
                    </script>';
    }

    $searchJson["menuDiv"] = '<ul class="nav navbar-top-links navbar-right">
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">
					SEARCH <i class="fa fa-search"></i>&nbsp;<i class="fa fa-caret-down"></i>
				</a>
				<ul class="dropdown-menu" id="search_type">
					' . $menuDiv . '
							
					<li><a href="javascript:void(0);" class="srch_type">Hide</a></li>
				</ul>
			</li>
		</ul>';
    $searchJson["htmlDiv"] = $htmlDiv;
    echo json_encode($searchJson);
}

function returnUserOptions(& $usernames) {
    $i = sizeof($usernames["user_names"]) - 1;


    if ($i) {
        $user_name = $usernames["user_names"];
        for ($i = 0; $i < sizeof($user_name) && isset($user_name[$i]) && $user_name[$i] != ''; $i++) {
            $user_name[$i] = trim($user_name[$i], ",");
        }
    }
    $i = sizeof($usernames["user_types"]) - 1;

    $usernames["user_types_html"] = '<option value="All" selected="selected">User Type</option>';
    if ($i) {
        $user_type = $usernames["user_types"];
        for ($i = 0; $i < sizeof($user_type) && isset($user_type[$i]) && $user_type[$i] != ''; $i++) {
            $user_type[$i] = trim($user_type[$i], ",");
            $usernames["user_types_html"] .= (string) '<option value="' . $user_type[$i] . '">' . $user_type[$i] . '</option>';
        }
    }
    //if($i){
    //$user_num = $usernames["user_nums"];
    //for($i=0;$i<sizeof($user_num) && isset($user_num[$i]) && $user_num[$i] != '';$i++){
    //$user_num[$i] = trim($user_num[$i],",");
    //$usernames["user_types_html"] .= (string) '<option value="'.$user_num[$i].'">'.$user_num[$i].'</option>';
    //}
    //}
    //if($i){
    //$user_due = $usernames["user_dues"];
    //for($i=0;$i<sizeof($user_due) && isset($user_due[$i]) && $user_due[$i] != '';$i++){
    //$user_due[$i] = trim($user_due[$i],",");
    //$usernames["user_types_html"] .= (string) '<option value="'.$user_due[$i].'">'.$user_due[$i].'</option>';
    //}
    //}
}

function returnProductOptions(& $products) {
    $i = sizeof($products["user_products"]) - 1;
    if ($i) {
        $product_name = $products["user_products"];
        for ($i = 0; $i < sizeof($product_name) && isset($product_name[$i]) && $product_name[$i] != ''; $i++) {
            $product_name[$i] = trim($product_name[$i], ",");
        }
    }
}

if (isset($parameters['autoloader']) && $parameters['autoloader'] == 'true')
    main();
?>
