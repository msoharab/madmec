<?php
define("MODULE_0", "config.php");
require_once (MODULE_0);
require_once(CONFIG_ROOT . MODULE_0);
require_once(CONFIG_ROOT . MODULE_1);
$parameters = array(
    "autoloader" => isset($_POST["autoloader"]) ? $_POST["autoloader"] : false,
    "action" => isset($_POST["action"]) ? $_POST["action"] : false,
);
unset($_POST);
function main($parameters) {
    $link = MySQLconnect(DBHOST, DBUSER, DBPASS);
    if (get_resource_type($link) == 'mysql link') {
        if (($db_select = selectDB(DBNAME_ZERO, $link)) == 1) {
            switch ($parameters["action"]) {
                case "fetctlistofgyms":
                    echo json_encode(fetchListOfGyms());
                    break;
            }
        }
    }
    if (get_resource_type($link) == 'mysql link')
        mysql_close($link);
    exit(0);
}
function fetchListOfGyms() {
    $fetchdata=array();
    $data='';
    $order = array("\r\n", "\n", "\r", "\t");
    $replace = "";
    $query = 'SELECT gp.`gym_name`,
            gp.`cell_code`,
            gp.`cell_number`,
            gp.`email`,
            gp.`addressline`,
            gp.`town`,
            gp.`city`,
            gp.`district`,
            gp.`province`,
            gp.`zipcode`,
            b.`gymcellcode` AS gymcellcodes,
            b.`gymcellnumber` AS gymcellnumbers,
            c.`gymemail` AS gymemails,
            CASE WHEN d.`gympackagename`  IS NULL OR d.`gympackagename`=""
            THEN "NoPackages"
            ELSE
            d.`gympackagename`
            END AS gympackagenames,
            d.`gympackagetype` AS gympackagetypes,
            d.`gymsession` AS gymsessions,
            d.`gympackagecost` AS gympackagecosts,
            CASE WHEN e.`gymoffername` IS NULL OR e.`gymoffername`=""
            THEN
            "NoOffers"
            ELSE
            e.`gymoffername`
            END AS gymoffernames,
            e.`gympoffercost` AS gympoffercosts,
            e.`gymofferdays` AS gymofferdayss,
            e.`gymofferdescription` AS gymofferdescriptions,
            e.`gymofferfacilityname` AS gymofferfacilitynames,
            e.`gymofferdurationname` AS gymofferdurationnames
            FROM `gym_profile` gp
            LEFT JOIN(
            SELECT GROUP_CONCAT(gcn.`cell_code`) AS gymcellcode,
            GROUP_CONCAT(gcn.`cell_number`) AS gymcellnumber,
            gcn.`user_pk` AS gymid
            FROM `gym_cell_numbers` gcn
            WHERE gcn.`status`=17
            GROUP BY gcn.`user_pk`
            ORDER BY gcn.`user_pk`
            ) AS b ON b.`gymid`=gp.`id`
            LEFT JOIN(
            SELECT GROUP_CONCAT(ge.`email`) AS gymemail,
            ge.`user_pk` AS gymid
            FROM `gym_email_ids` ge
            WHERE ge.`status`=17
            GROUP BY ge.`user_pk`
            ORDER BY ge.`user_pk`
            ) AS c ON c.`gymid`=gp.`id`
            LEFT JOIN(
            SELECT
            GROUP_CONCAT(pck.`packagename`) AS gympackagename,
            GROUP_CONCAT(pck.`number_of_sessions`) AS gymsession,
            GROUP_CONCAT(pck.`cost`) AS gympackagecost,
            GROUP_CONCAT(pckname.`package_name`) AS gympackagetype,
            pck.`gym_id` AS gymid
            FROM `packages` pck
            LEFT JOIN `package_name` pckname
            ON pck.`package_type_id`=pckname.`id`
            WHERE pck.`status`=4 AND pckname.`status`=4
            GROUP BY pck.`gym_id`
            ORDER BY pck.`gym_id`
            ) AS d ON d.`gymid`=gp.`id`
            LEFT JOIN(
            SELECT
            GROUP_CONCAT(ofr.`name`) AS gymoffername,
            GROUP_CONCAT(ofr.`cost`) AS gympoffercost,
            GROUP_CONCAT(ofr.`num_of_days`) AS gymofferdays,
            GROUP_CONCAT(ofr.`description`) AS gymofferdescription,
            GROUP_CONCAT(fcty.`name`) AS gymofferfacilityname,
            GROUP_CONCAT(offrdur.`duration`) AS gymofferdurationname,
            ofr.`gym_id` AS gymid
            FROM `offers` ofr
            LEFT JOIN `facility` fcty
            ON fcty.`id`=ofr.`facility_id`
            LEFT JOIN `offerduration` offrdur
            ON offrdur.`id`=ofr.`duration_id`
            WHERE ofr.`status`=4 AND fcty.`status`=4
            GROUP BY ofr.`gym_id`
            ORDER BY ofr.`gym_id`
            ) AS e ON e.`gymid`=gp.`id`
            WHERE gp.`status`=4';
	$result=  executeQuery($query);
	if(mysql_num_rows($result)){
	    while($row=  mysql_fetch_assoc($result)){
		$fetchdata[]=$row;
	    }
	    $k=0;
	    for($i=0;$i<sizeof($fetchdata);$i++){
		/* Gym cell numbers */
		$gymcnums = '';
		$tempcellnums =  explode(",", $fetchdata[$i]['gymcellnumbers']);
		$tempcellcodes =  explode(",", $fetchdata[$i]['gymcellcodes']);
		if(is_array($tempcellnums)){
		    for($j=1;$j<sizeof($tempcellnums);$j++){
			$gymcnums .=$tempcellcodes[$j].' - ' .$tempcellnums[$j].' <br/>';
		    }
		}
		/* Gym email ids */
		$gymemails = '';
		$tempemails=  explode(",", $fetchdata[$i]['gymemails']);
		if(is_array($tempemails)){
		    for($j=1;$j<sizeof($tempemails);$j++) {
			$gymemails .= $tempemails[$j].' <br/>';
		    }
		}
		/* Gym offers */
		$offers = '';
		$tempofrnames=explode(',',$fetchdata[$i]['gymoffernames']);
		$tempofrduration=explode(',',$fetchdata[$i]['gymofferdurationnames']);
		$tempofrfacility=explode(',',$fetchdata[$i]['gymofferfacilitynames']);
		$tempofrdescb=explode(',',$fetchdata[$i]['gymofferdescriptions']);
		$tempofrcost=explode(',',$fetchdata[$i]['gympoffercosts']);
		if(is_array($tempofrnames)){
		    for($j=0;$j<sizeof($tempofrnames);$j++){
			if($tempofrnames[0] =="NoOffers"){
			   $offers .='<strong> No Offers </strong>';
			   break;
			}
			$offers .='<div class="col-lg-4"><div class="panel panel-info"><div class="panel-heading"><strong> Offer Name </strong> : '.$tempofrnames[$j].'</div><div class="panel-body"><strong> Duration </strong> : '.$tempofrduration[$j].'<br/><strong> Facility </strong> : '.$tempofrfacility[$j].'<br/><strong> Description </strong> : '.$tempofrdescb[$j].'<br/><strong> Cost </strong> : <i class="fa fa-rupee"></i>'.$tempofrcost[$j].'<br/></div></div></div>';
		    }
		}
		/* Gym packages */
		$packages = '';
		$temppacknames=explode(',',$fetchdata[$i]['gympackagenames']);
		$temppacktypes=explode(',',$fetchdata[$i]['gympackagetypes']);
		$temppacksession=explode(',',$fetchdata[$i]['gymsessions']);
		$temppackcost=explode(',',$fetchdata[$i]['gympackagecosts']);
		if(is_array($temppacknames)){
		    for($j=0;$j<sizeof($temppacknames);$j++){
			if($temppacknames[0] =="NoPackages"){
			   $packages .=' <strong>No Packages </strong>';
			   break;
			}
			$packages .='<div class="col-lg-4"><div class="panel panel-info"><div class="panel-heading"><strong> Package Name </strong> : '.$temppacknames[$j].'</div><div class="panel-body"><strong> Package Type </strong> : '.$temppacktypes[$j].'<br/><strong> Sessions </strong> : '.$temppacksession[$j].' days<br/><strong> Cost </strong> : <i class="fa fa-rupee"></i>'.$temppackcost[$j].'<br/></div></div></div>';
		    }
		}
		++$k;
		$data .='<tr><td>'.$k.'</td><td>'
			. ' <div class="panel panel-default">
				<div class="panel-heading">
					<strong>GYM Name </strong>: '.$fetchdata[$i]['gym_name'].'
				</div>
				<div class="panel-body"> 
				    <ul class="nav nav-pills">
					<li class="active"><a href="#bi-pills_'.$k.'" data-toggle="tab">Basic Info</a></li>
					<li><a href="#profile-pills_'.$k.'" data-toggle="tab">Offers</a></li>
					<li><a href="#messages-pills_'.$k.'" data-toggle="tab">Packages</a></li>
				    </ul>
				    <!-- Tab panes -->
				    <div class="tab-content">
					<div class="tab-pane fade in active" id="bi-pills_'.$k.'">
					    <h4>Basic Info</h4>
					    <p>
						<dl class="dl-horizontal">
							<dt>GYM Name : </dt><dd>'.$fetchdata[$i]['gym_name'].'</dd>
							<dt>Address : </dt><dd>'.$fetchdata[$i]['addressline'].',&nbsp;
								'.$fetchdata[$i]['town'].',&nbsp;
								'.$fetchdata[$i]['city'].',&nbsp;
								'.$fetchdata[$i]['district'].',&nbsp;
								'.$fetchdata[$i]['province'].'.&nbsp;
							</dd>
							<dt>Zipcode : </dt><dd>'.$fetchdata[$i]['zipcode'].'</dd>
							<dt>Owner Mobile : </dt><dd> '.$fetchdata[$i]['cell_code'].' - '.$fetchdata[$i]['cell_number'].'</dd>
							<dt>Email : </dt><dd>'.$fetchdata[$i]['email'].'<br/>'.$gymemails.'</dd>
							<dt>Club / Gym Mobile  : </dt><dd>'.$gymcnums.'</dd>
						</dl>
					    </p>
					</div>
					<div class="tab-pane fade" id="profile-pills_'.$k.'">
					    <h4>Offers</h4>
					    <p>'.$offers.'</p>
					</div>
					<div class="tab-pane fade" id="messages-pills_'.$k.'">
					    <h4>Packages</h4>
					    <p>'.$packages.'</p>
					</div>
				    </div>
				</div>
				<!-- /.panel-body -->
			    </div>
			    <!-- /.panel -->
			</div></td></tr>';
	    }
	    $jsondata=array(
		"status" => "success",
		"data" => str_replace($order, $replace, $data)
	    );
	    return $jsondata;
    }
    else{
        $jsondata=array(
		"status" => "failure",
		"data" => NULL
	);
	return $jsondata;
    }
}
if (isset($parameters['autoloader']) && $parameters['autoloader'] == 'true') {
    global $parameters;
    main($parameters);
}
?>