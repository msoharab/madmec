<?php
class Manage {

    protected $parameters = array();
    private $order = array("\r\n", "\n", "\r", "\t");
    private $replace = '';

    function __construct($para = false) {
        $this->parameters = $para;
    }

    function listpack_type() {
        $result = false;
        $i = 0;
        $query = 'SELECT ut.`id` AS type_id,
		       ut.`package_name` AS type_name
		FROM `package_name` as ut,
		     `status` as st
		WHERE ut.`status`= st.`id` AND
		      st.`statu_name`="Show" AND st.`status`=1
		ORDER BY(ut.`package_name`);';
        $result = executeQuery($query);
        echo '<option value="NULL">Select Package Type</option>';
        while ($row = mysql_fetch_assoc($result)) {
            echo '<option value=' . $row["type_id"] . ' >' . ucwords($row["type_name"]) . '</option>';
        }
    }

    function addPackage($type, $num, $prize) {
        $result = false;
        $query = 'SELECT `id`
		  FROM `packages`
		  WHERE `package_type_id`= "' . $type . '" AND `number_of_sessions` = "' . $num . '" AND `cost`= "' . $prize . '"  ';
        $res = executeQuery($query);
        if (mysql_num_rows($res) > 0) {
            echo "duplicate";
            exit(0);
        }

        $qur = 'SELECT `id` FROM `status` WHERE `statu_name`="Show" AND `status`=1';
        $res = executeQuery($qur);
        $row = mysql_fetch_assoc($res);
        $query = 'INSERT INTO `packages` (`id`, `package_type_id`, `number_of_sessions`, `cost`, `status`) VALUES (NULL, ' . $type . ',' . $num . ',' . $prize . ',' . $row["id"] . ');';
        $result = executeQuery($query);
        if ($result) {
            echo "success";
        } else {
            echo "unsuccess";
        }
    }

    function packname_wise() {
        $moptype = NULL;
        $jsonmoptype = NULL;
        $num = 0;
        $query = 'SELECT ut.`id` AS type_id,
		               ut.`package_name` AS type_name
		        FROM `package_name` as ut,
		             `status` as st
		        WHERE ut.`status`= st.`id` AND
		              st.`statu_name`="Show" AND st.`status`=1';
        $res = executeQuery($query);
        if (mysql_num_rows($res) > 0) {
            while ($row = mysql_fetch_assoc($res)) {
                $moptype[] = $row;
            }
        }
        if (is_array($moptype))
            $num = sizeof($moptype);
        if ($num) {
            for ($i = 0; $i < $num; $i++) {
                $jsonmoptype[] = array(
                    "html" => $moptype[$i]["type_name"],
                    "name" => $moptype[$i]["type_name"],
                    "id" => $moptype[$i]["type_id"]
                );
            }
        }
        return $jsonmoptype;
    }

    function packagesdata($id, $tabid) {
        $listusers = NULL;
        $query = 'SELECT
		GROUP_CONCAT(g.`p_id`,"☻☻♥♥☻☻") AS p_id,
		GROUP_CONCAT(g.`num`,"☻☻♥♥☻☻") AS num,
		GROUP_CONCAT(g.`prize`,"☻☻♥♥☻☻") AS prize,
		GROUP_CONCAT(g.`p_name`,"☻☻♥♥☻☻") AS p_name,
		g.`type_id`
		FROM(
		  SELECT
			cft.`id` AS type_id,
			cft.`package_name` AS p_name,
			p.`id` AS p_id,
			p.`number_of_sessions` AS num,
			p.`cost` AS prize
		  FROM `packages` As p
		  LEFT  JOIN  `package_name` AS cft ON cft.`id` = p.`package_type_id` AND cft.`status` =(SELECT id FROM `status` WHERE statu_name = "Show" and status=1)
		  WHERE cft.`id` = p.`package_type_id` AND p.`status` =(SELECT id FROM `status` WHERE statu_name = "Show" and status=1)
		) as g
		WHERE g.`type_id` = ' . $id . '';
        $res = executeQuery($query);
        if (mysql_num_rows($res)) {
            $i = 0;
            while ($row = mysql_fetch_assoc($res)) {
                $listusers[$i]['p_id'] = $row['p_id'];
                $listusers[$i]['p_name'] = $row['p_name'];
                $listusers[$i]['num'] = $row['num'];
                $listusers[$i]['prize'] = $row['prize'];
                $listusers[$i]['type_id'] = $row['type_id'];
                $i++;
            }
        }
        $att = new manage();
        $att->Displaypackage($listusers, $tabid);
    }

    function Displaypackage($listusers, $tabId) {
        $users = array();
        $total = sizeof($listusers);
        $users[0]["type_id"] = $listusers[0]['type_id'];
        if ($total) {
            for ($i = 0; $i < $total; $i++) {
                $users[$i]["p_id"] = explode("☻☻♥♥☻☻", $listusers[$i]["p_id"]);
                $users[$i]["p_name"] = explode("☻☻♥♥☻☻", $listusers[$i]["p_name"]);
                $users[$i]["num"] = explode("☻☻♥♥☻☻", $listusers[$i]["num"]);
                $users[$i]["prize"] = explode("☻☻♥♥☻☻", $listusers[$i]["prize"]);
            }
        } else {
            $users = NULL;
        }

        $num_posts = sizeof($users);

        echo str_replace($this->order,$this->replace, '<table class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0" id="offertable">
	       <thead>
	       <tr>
		    <th>#</th>
		    <th style="display: none;">id</th>
				<th>No</th>
				<th>Package Name</th>
				<th>No Of Sessions</th>
				<th>Prize</th>
				<th>Delete</th>
		</tr></thead>');
        $name = '';
        $num = $prize = 0;
        for ($i = 0; $i < $num_posts; $i++) {
            for ($k = 1; $k < sizeof($users[$i]["p_id"]); $k++) {
                $name = ltrim($users[$i]["p_name"][$k - 1], ',');
                $p_id = ltrim($users[$i]["p_id"][$k - 1], ',');
                $num = ltrim($users[$i]["num"][$k - 1], ',');
                $prize = ltrim($users[$i]["prize"][$k - 1], ',');

                echo str_replace($this->order,$this->replace,'<tr>
		              <td class="details-control"></td>
		              <td style="display: none;">' . $p_id . '</td>
		              <td>' . $k . '</td>
		              <td>' . $name . '</td>
		              <td>' . $num . '</td>
		              <td>' . $prize . '</td>
		               <td class="text-center"><button type="button" class="btn btn-md" id="listDELcust_' . $k . '" title="Delete" data-toggle="modal" data-target="#myUSRLISTDELModal_' . $k . '"><i class="fa fa-trash-o fa-fw"></i></button></td>
		            </tr>');
                echo str_replace($this->order,$this->replace, '<div class="modal fade" id="myUSRLISTDELModal_' . $k . '" tabindex="-1" role="dialog" aria-labelledby="myUSRLISTDELModal_' . $k . '" aria-hidden="true" style="display: none;">
					<div class="modal-dialog">
						<div class="modal-content" style="color:#000;">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h4 class="modal-title" id="myUSRDELModalLabel_' . $k . '">Are you really want to delete</h4>
							</div>
							<div class="modal-body" id="myUSRDEL_' . $k . '">
								Do you really want to delete {' . $name . '} <br />
								Press OK to delete ??
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="deletelltDELOk_' . $k . '">Ok</button>
								<button type="button" class="btn btn-success" data-dismiss="modal" id="deletelltDELCancel_' . $k . '">Cancel</button>
							</div>
						</div>
					</div>
				</div>');
                echo str_replace($this->order,$this->replace, '<script>
					$(document).ready(function(){
					var att = {
						p_id	:	"' . $p_id . '",
						tabId	:	"' . $tabId . '",
						index	:	' . $k . ',
						p_name	:	"' . $name . '",
						num		:	' . $num . ',
						prize	:	' . $prize . ',
						detBtn	:	"#deletelltDELOk_' . $k . '"
					};
					var obj = new controlManageTen();
					obj.packagetable(att);
				});
			  </script>');
            }
        }
        echo str_replace($this->order,$this->replace, '</table>
        <script>
		$(document).ready(function(){
		var att = {
			tableid	:	"#offertable",
			tabId	:	"' . $tabId . '"
		};
		var obj = new controlManageTen();
		obj.packagetable(att);
	});
	</script>');
    }

    function list_offer($data, $tid) {
        $listofferdata = NULL;
        $query = "SELECT
		GROUP_CONCAT(g.`id`,'☻☻♥♥☻☻') AS o_id,
		GROUP_CONCAT(g.`name`,'☻☻♥♥☻☻') AS o_name,
		GROUP_CONCAT(g.`num`,'☻☻♥♥☻☻') AS o_num,
		GROUP_CONCAT(g.`cost`,'☻☻♥♥☻☻') AS prize,
		GROUP_CONCAT(g.`o_desc`,'☻☻♥♥☻☻') AS o_desc,
		GROUP_CONCAT(g.`mem`,'☻☻♥♥☻☻') AS o_mem,
		GROUP_CONCAT(g.`status`,'☻☻♥♥☻☻') AS status,
		g.`facility_id`
		FROM(
		  SELECT
			of.`facility_id` AS facility_id,
			of.`id` AS id,
			of.`name` AS name,
			of.`num_of_days` AS num,
			of.`description` AS o_desc,
			of.`cost` AS cost,
			of.`min_members` AS mem,
			of.`status` AS status
			FROM `offers` As of
			WHERE of.`status` NOT IN (SELECT `id` FROM `status` WHERE (`statu_name` = 'Left' OR
												`statu_name` = 'Hide' OR
												`statu_name` = 'Delete' OR
												`statu_name` = 'Fired' OR
												`statu_name` = 'Inactive'))
			ORDER BY(of.`num_of_days`)
		) as g
		WHERE g.`facility_id` = '" . $data . "'
		ORDER BY(g.`name`)
		";
        $res = executeQuery($query);
        if (mysql_num_rows($res)) {
            $i = 0;
            while ($row = mysql_fetch_assoc($res)) {
                $listofferdata[$i]['id'] = $row['o_id'];
                $listofferdata[$i]['name'] = $row['o_name'];
                $listofferdata[$i]['num'] = $row['o_num'];
                $listofferdata[$i]['mem'] = $row['o_mem'];
                $listofferdata[$i]['prize'] = $row['prize'];
                $listofferdata[$i]['o_desc'] = $row['o_desc'];
                $listofferdata[$i]['status'] = $row['status'];
                $listofferdata[0]['facility_id'] = $row['facility_id'];
                $i++;
            }
        }
        $_SESSION["managelistoffer"] = $listofferdata;
        //DisplayList($listusers);
        $att = new manage();
        $att->DisplayofferList($tid);
    }

    function DisplayofferList($tid){
        $users = array();
        $listofferdata = $_SESSION["managelistoffer"];
        $users[0]["facility_id"] = $listofferdata[0]['facility_id'];
        $total = sizeof($listofferdata);
        if ($total) {
            for ($i = 0; $i < $total; $i++) {
                $users[$i]["id"] = explode("☻☻♥♥☻☻", $listofferdata[$i]['id']);
                $users[$i]["name"] = explode("☻☻♥♥☻☻", $listofferdata[$i]['name']);
                $users[$i]["num"] = explode("☻☻♥♥☻☻", $listofferdata[$i]['num']);
                $users[$i]["mem"] = explode("☻☻♥♥☻☻", $listofferdata[$i]['mem']);
                $users[$i]["prize"] = explode("☻☻♥♥☻☻", $listofferdata[$i]['prize']);
                $users[$i]["status"] = explode("☻☻♥♥☻☻", $listofferdata[$i]['status']);
                $users[$i]["o_desc"] = explode("☻☻♥♥☻☻", $listofferdata[$i]['o_desc']);
            }
        } else {
            $users = NULL;
        }
        $num_posts = sizeof($users);
        echo str_replace($this->order,$this->replace, '<table class="table table-striped table-bordered table-hover dataTable" cellpadding="0" cellspacing="0" id="packtable">
	  	       <thead>
	  	       <tr>
	  	            <th>No</th>
					<th>Name</th>
					<th>No Of Sessions</th>
					<th>Prize</th>
					<th>Min Member</th>
					<th>Description</th>
					<th>Edit</th>
					<th>Delete</th>
					<th>Flag</th>
	  	        </tr></thead>');
        $name = $o_desc = '';
        $num = $prize = $mem = 0;
        $fid = $users[0]["facility_id"];
        for ($i = 0; $i < $num_posts; $i++) {
            for ($k = 1; $k < sizeof($users[$i]["status"]); $k++) {
                $name = isset($users[$i]["name"][$k - 1]) ? ltrim($users[$i]["name"][$k - 1], ',') : '';
                $o_id = isset($users[$i]["id"][$k - 1]) ? ltrim($users[$i]["id"][$k - 1], ',') : '';
                $num = isset($users[$i]["num"][$k - 1]) ? ltrim($users[$i]["num"][$k - 1], ',') : '';
                $mem = isset($users[$i]["mem"][$k - 1]) ? ltrim($users[$i]["mem"][$k - 1], ',') : '';
                $o_desc = isset($users[$i]["o_desc"][$k - 1]) ? ltrim($users[$i]["o_desc"][$k - 1], ',') : '';
                if (!isset($o_desc)) {
                    $o_desc = '<strong>Not Provide</strong>';
                }
                $prize = isset($users[$i]["prize"][$k - 1]) ? ltrim($users[$i]["prize"][$k - 1], ',') : '';
                $status = isset($users[$i]["status"][$k - 1]) ? ltrim($users[$i]["status"][$k - 1], ',') : '';

                echo str_replace($this->order,$this->replace,  '<tr>
		              <td>' . $k . '</td>
		              <td>' . $name . '</td>
		              <td>' . $num . '</td>
		              <td>' . $prize . '</td>
		              <td>' . $mem . '</td>
		              <td>' . $o_desc . '</td>
		              <td class="text-center"><button type="button" id="lof_but_edit_' . $k . '" title="Edit" ><i class="fa fa-edit fa-fw"></i></button></td>
					  <td class="text-center"><button type="button" class="btn btn-md" id="lof_but_trash_' . $k . '" title="Delete" data-toggle="modal" data-target="#myUSRDELModal_' . $k . '"><i class="fa fa-trash-o fa-fw"></i></button></td>');
                if (($status) != 7) {
                    echo str_replace($this->order,$this->replace, '<td class="text-center"><button type="button" class="btn btn-success btn-md" id="lof_but_flag_' . $k . '" title="Flag" data-toggle="modal" data-target="#myModal_flag' . $k . '"><i class="fa fa-flag-o fa-fw"></i>Flag</button></td>');
                } else if (($status) == 7) {
                    echo str_replace($this->order,$this->replace, '<td class="text-center"><button class="btn btn-danger btn-md" id="lof_but_unflag_' . $k . '" data-toggle="modal" data-target="#myModal_unflag' . $k . '"><i class="fa fa-flag-o fa-fw"></i>Unflag</button></td>');
                }
                echo str_replace($this->order,$this->replace, '</tr></tr>
						<div class="modal fade" id="myUSRDELModal_' . $k . '" tabindex="-1" role="dialog" aria-labelledby="myUSRDELModalLabel_' . $k . '" aria-hidden="true" style="display: none;">
							<div class="modal-dialog">
								<div class="modal-content" style="color:#000;">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h4 class="modal-title" id="myUSRDELModalLabel_' . $k . '">Are you really want to delete</h4>
									</div>
									<div class="modal-body" id="myUSRDEL_' . $k . '">
										Do you really want to delete {' . $name . '} <br />
										Press OK to delete ??
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="deletelofDELOk_' . $k . '">Ok</button>
										<button type="button" class="btn btn-success" data-dismiss="modal" id="deletelofDELCancel_' . $k . '">Cancel</button>
									</div>
								</div>
							</div>
						</div>
						<div class="modal fade" id="myModal_flag' . $k . '" tabindex="-1" role="dialog" aria-labelledby="myModal_flag_Label_' . $k . '" aria-hidden="true" style="display: none;">
							<div class="modal-dialog">
								<div class="modal-content" style="color:#000;">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h4 class="modal-title" id="myModal_flag_Label_' . $k . '">Flag User entry</h4>
									</div>
									<div class="modal-body">
										Do You really want to flag the User {' . $name . '} entry ?? press <strong>OK</strong> to flag
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="flaglofOk_' . $k . '">Ok</button>
										<button type="button" class="btn btn-success" data-dismiss="modal" id="flaglofCancel_' . $k . '">Cancel</button>
									</div>
								</div>
							</div>
						</div>
						<div class="modal fade" id="myModal_unflag' . $k . '" tabindex="-1" role="dialog" aria-labelledby="myModal_unflag_Label_' . $k . '" aria-hidden="true" style="display: none;">
							<div class="modal-dialog">
								<div class="modal-content" style="color:#000;">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h4 class="modal-title" id="myModal_unflag_Label_' . $k . '">UnFlag User entry</h4>
									</div>
									<div class="modal-body">
										Do You really want to UnFlag the User {' . $name . '} entry ?? press <strong>OK</strong> to UnFlag
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="unflaglofOk_' . $k . '">Ok</button>
										<button type="button" class="btn btn-success" data-dismiss="modal" id="unflaglofCancel_' . $k . '">Cancel</button>
									</div>
								</div>
							</div>
						</div>');
                echo str_replace($this->order,$this->replace, '<script>
					$(document).ready(function(){
					var att = {
						id			:	"' . $o_id . '",
						index		:	' . $k . ',
						name		:	"' . $name . '",
						num			:	' . $num . ',
						prize		:	' . $prize . ',
						mem			:	' . $mem . ',
						o_desc		:	"' . $o_desc . '",
						editBtn 	:	"#lof_but_edit_' . $k . '",
						delBtn 		:	"#lof_but_trash_' . $k . '",
						delOkBtn 	:	"#deletelofDELOk_' . $k . '",
						flagBtn 	:	"#lof_but_flag_' . $k . '",
						flagokBtn	:	"#flaglofOk_' . $k . '",
						unflagBtn	:	"#lof_but_unflag_' . $k . '",
						unflagokBtn :	"#unflaglofOk_' . $k . '",
						offeditpack	:	"#offermEditpack_' . $k . '",
						facility	:	' . $fid . ',
						tabId		:	"' . $tid . '",

					};
					var obj = new controlManageSix();
					obj.listoffertable(att);
				});
			  </script>');
            }
        }
        echo str_replace($this->order,$this->replace, '</table><script>
			$(document).ready(function(){
			var att = {
				tableid	:	"#packtable",
			};
			var obj = new controlManageSix();
			obj.listoffertable(att);
		});
	  </script>');
    }

    function offerDel($id) {
        $result = false;
        $query = 'UPDATE `offers` SET status = (SELECT id FROM `status` WHERE statu_name="Hide" and status=1) WHERE id=' . $id . '';
        $result = executeQuery($query);
        if ($result)
            echo 'success';
    }

    function offerFlag($id) {
        $result = false;
        $query = 'UPDATE `offers` SET status = (SELECT id FROM `status` WHERE statu_name="Flag" and status=1) WHERE id=' . $id . '';
        $result = executeQuery($query);
        if ($result)
            echo 'success';
    }

    function offerunFlag($id) {
        $result = false;
        $query = 'UPDATE `offers` SET status = (SELECT id FROM `status` WHERE statu_name="Show" and status=1) WHERE id=' . $id . '';
        $result = executeQuery($query);
        if ($result)
            echo 'success';
    }

    function offerEditData($id, $tid) {
        $data = '';
        $result = false;
        $query = 'SELECT of.* ,
	                 fact.`name` AS factName,
	                 fact.`id` AS factId
	          FROM offers AS of
	          LEFT JOIN `facility` AS fact ON fact.`id` = of.`facility_id`
	          WHERE of.`id`=' . $id . '';
        $result = executeQuery($query);
        if ($row = mysql_fetch_assoc($result)) {
			
			$breaks = array("<br />","<br>","<br/>");  
            $row["description"] = str_ireplace($breaks, "\r\n", $row["description"]);
			
            $data .='<div class="row">
				 <div class="col-lg-12">
				    <div class="panel panel-default">
						<div class="panel-heading">
							<strong>' . $row["factName"] . ' offer Edit</strong>
						</div>
						<div class="panel-body">
							<form id="offeredit_form">
								<fieldset>
                                                <div class="row">
						      <div class="col-lg-4">
								<div class="col-lg-12">
									<strong><span class="text-danger"></span> Name  :<i class="fa fa-caret-down fa-fw"></i></strong>
								</div>
								<div class="col-lg-12">
									  <input type="text" name="of_ename" id="of_ename" value="' . $row["name"] . '" class="form-control" placeholder="individual" />
							          <p class="help-block" id="valid_enm">Press<b> Tab </b>or go button to move to next field.</p>
								</div>
								<div class="col-lg-12">&nbsp;</div>
							</div>

							<div class="col-lg-4">
								<div class="col-lg-12">
									<strong><span class="text-danger"></span> Duration  :<i class="fa fa-caret-down fa-fw"></i></strong>
								</div>
								<div class="col-lg-12" id="of_eduration">
									<select class="form-control" id="cust_duration">
										<option>Select Duration</option>
									</select>
									<p class="help-block" id="valid_duration">&nbsp;</p>
								</div>
								<div class="col-lg-12">&nbsp;</div>
							</div>
							<!-- sex -->
							<div class="col-lg-4">
								<div class="col-lg-12">
									<strong><span class="text-danger"></span> Number Of Days  :<i class="fa fa-caret-down fa-fw"></i></strong>
								</div>
								<div class="col-lg-12">
									<input type="text" name="of_no_edays" id="of_no_edays" value="' . $row["num_of_days"] . '" class="form-control" placeholder="30" readonly="readonly"/>
									<p class="help-block" id="valid_num">&nbsp;</p>
								</div>
								<div class="col-lg-12">&nbsp;</div>
							</div>
					</div>
					<div class="row">
						      <div class="col-lg-4">
								<div class="col-lg-12">
									<strong><span class="text-danger"></span> Facility Type  :<i class="fa fa-caret-down fa-fw"></i></strong>
								</div>
								<div class="col-lg-12" id="of_facility_parent">
									<select class="form-control">
										<option>Select Facility</option>
									</select>
									<p class="help-block" id="valid_efact">&nbsp;</p>
								</div>
								<div class="col-lg-12">&nbsp;</div>
							</div>

							<div class="col-lg-4">
								<div class="col-lg-12">
									<strong><span class="text-danger"></span> Prizing  :<i class="fa fa-caret-down fa-fw"></i></strong>
								</div>
								<div class="col-lg-12">
									<input type="text" name="of_eprize" id="of_eprize" value="' . $row["cost"] . '" class="form-control" placeholder="1000" />
									<p class="help-block" id="valid_price">&nbsp;</p>
								</div>
								<div class="col-lg-12">&nbsp;</div>
							</div>
							<!-- sex -->
							<div class="col-lg-4">
								<div class="col-lg-12">
									<strong><span class="text-danger"></span> Minimum Member  :<i class="fa fa-caret-down fa-fw"></i></strong>
								</div>
								<div class="col-lg-12">
									<select name="of_emember" id="of_emember" class="form-control">';
            if ((int) $row["min_members"] == 1) {
                $data .='<option value="1" selected>1</option>
										<option value="2">2</option>
										<option value="3">3</option>';
            } else if ((int) $row["min_members"] == 2) {
                $data .='<option value="1" >1</option>
										<option value="2" selected>2</option>
										<option value="3">3</option>';
            } else {
                $data .='<option value="1" >1</option>
										<option value="2" >2</option>
										<option value="3" selected>3</option>';
            }
            $data .='</select>
									<p class="help-block" id="valid_emember">&nbsp;</p>
								</div>
								<div class="col-lg-12">&nbsp;</div>
							</div>
					</div>
                     <div class="row text-primary">
						<div class="col-lg-12">
							<div id="offer_eadd">
								<div class="row" id="offer_eadd">
								      <div class="col-md-12">
							            <label><span id="no_days_emsg" style="display:none; color:#FF0000; font-size:25px;">*</span> Description :</label>
	 				        	      </div>
	 				        	</div>
	 					  </div>
	 					</div>
	                 <div class="form-group">
							<div class="col-md-12">
								<span><textarea placeholder="Details about the offer" value="" name="of_edes" id="of_edes" rows="5" class="form-control" >' . $row["description"] . '</textarea></span>
								<p class="help-block">Press<b> Tab </b>or go button to move to next field.</p>
							</div>
					</div>
				      <div class="col-md-12">
						<div class="col-md-2"><button type="button" class="btn btn-success col-md-12" id="offeresave"><label><h5>Save</h5></label></button></div>
                        <div class="col-md-2"><button type="button" class="btn btn-success col-md-12" id="offerecancel"><label><h5>Cancel</h5></label></button></div>
                      </div>
				</div>
                     </fieldset>
                    </form>
						</div>
					</div>
				 </div>
			   </div>';
            echo str_replace($this->order,$this->replace, $data);
            echo str_replace($this->order,$this->replace, '<script>
					$(document).ready(function(){
					var att = {
						form		:	"#offeredit_form",
						name		:	"#of_ename",
						prize		:	"#of_eprize",
						numofday	:	"#of_no_edays",
						descr		:	"#of_edes",
						mem			:	"#of_emember",
						faceid		:	"' . $row["facility_id"] . '",
						duration	:	"#of_eduration",
						durVal		:	"'.$row["duration_id"].'",
						validduration:	"#valid_duration",
						facility	:	"#of_facility_parent",
						offersave	:	"#offeresave",
						offercancel	:	"#offerecancel",
						validDur	:	"#valid_duration",
						validFact	:	"#valid_fact",
						referpage	:	"#ListOffer",
						editId		:	"' . $id . '",
						tabId		:	"' . $tid . '",

					};
					var obj = new controlManageSix();
					obj.offereditData(att);

				});	
			  </script>'); 	
			}   
	}
    function updateLtDataOffer($data){
	  $result=false;	  
	  $query='UPDATE `offers` SET `name` = \''.$data["name"].'\', `duration_id` = '.$data["duration"].', `num_of_days` = '.$data["nod"].', `facility_id` = '.$data["facility"].', `description` = \''.$data["descr"].'\', `cost` = '.$data["prize"].', `min_members` = '.$data["mem"].' WHERE `id` = '.$data["offerId"].'';
	  $result=executeQuery($query);
	   if($result){
		 echo 'success';
	    }	
	}
    public function deleteLTPackage($pid,$tid){
	   $result=false;	  
	  $query='UPDATE `packages` SET status = (SELECT id FROM `status` WHERE statu_name="Hide" and status=1) WHERE id='.$pid.'';
	  $result=executeQuery($query);
      if($result)	  
	     echo 'success';	
	}
    function packageUpdates(){
	  $result=false;
	  $query='SELECT `id` FROM `packages` 
			WHERE `package_type_id` ="'.$this->parameters["pmid"].'"
			AND  `number_of_sessions` = "'.$this->parameters["nums"].'"
			AND `cost` ="'.$this->parameters["prz"].'"';
	  $res=executeQuery($query);
      if($res){	  
	     if(mysql_num_rows($res)>0){
			echo 'duplicate';
		 }
		 else{
			$query='UPDATE `packages` SET `package_type_id` ="'.$this->parameters["pmid"].'" , `number_of_sessions` = "'.$this->parameters["nums"].'" , `cost` ="'.$this->parameters["prz"].'"  WHERE `id` = '.$this->parameters["id"].';';
			$result=executeQuery($query);
			if($result)	  
			echo 'success';
		 }
	  }
   }
}
?>
