<?php

class materialorder {

    protected $parameters = array();

    function __construct($parameters = false) {
        $this->parameters = $parameters;
    }

    public function creatmeterialOrder() {
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        /* Item */
        $query = 'INSERT INTO  `material_order` (`order_id`,
						`ven_id`,
						`fdoo`,
						`edod`
						 )  VALUES(
					NULL,
					\'' . mysql_real_escape_string($this->parameters["vid"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["doo"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["edod"]) . '\'
					);';
        if (executeQuery($query)) {
            $query = 'INSERT INTO  `mo_descb` (`id`,`order_id`,
					`item_type_id`,
					`quantity`,
					`doo`,
                                        `fquantity`
					 )  VALUES(
					NULL,
					LAST_INSERT_ID(),
					\'' . mysql_real_escape_string($this->parameters["iid"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["qty"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["doo"]) . '\',
                                        \'' . mysql_real_escape_string($this->parameters["qty"]) . '\'
					);';
            if (executeQuery($query)) {
                executeQuery("COMMIT");
            }
        }
    }

    public function additemtoexistingorder() {
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        if (($this->parameters['mo_descb_id']) != "") {
            $query = 'UPDATE mo_descb SET quantity=' . mysql_real_escape_string($this->parameters['qty']) . ','
                    . 'fquantity=' . mysql_real_escape_string($this->parameters['qty']) . '
                                      WHERE id=' . mysql_real_escape_string($this->parameters['mo_descb_id']);
            if (executeQuery($query)) {
                executeQuery("COMMIT");
            }
        } else {
            echo $this->parameters;
            $query = 'INSERT INTO  `mo_descb` (`id`,`order_id`,
								`item_type_id`,
								`quantity`,
								`doo`,
                                                                `fquantity`
								 )  VALUES(
							NULL,
                            \'' . mysql_real_escape_string($this->parameters["oid"]) . '\',
							\'' . mysql_real_escape_string($this->parameters["iid"]) . '\',
							\'' . mysql_real_escape_string($this->parameters["qty"]) . '\',
							now(),
                                                        \'' . mysql_real_escape_string($this->parameters["qty"]) . '\'
							);';
            if (executeQuery($query)) {
                executeQuery("COMMIT");
            }
        }
    }

    /* fetching Material ordered details */

    public function fetchmaterialordereddetails() {
        $allqty = array();
        $mo_order_ids = array();
        $orderids = array();
        $jsonptype = array();
        $itemnames = array();
        $qtys = array();
        $togletitle = array();
        $toggledata = '';
        $html = array();
        $mo_ids = array();
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $query = 'SELECT
                                            mo.`order_id`,
                                            mo.`fdoo`,
                                            usr.`user_name` AS venname,
                                            GROUP_CONCAT(mods.`quantity`)AS qty,
                                            GROUP_CONCAT(mods.`id`)AS mo_id,
                                            GROUP_CONCAT(ityyp.`type`) AS itemname,
                                            COUNT(mods.`quantity`) AS no_qty
                                            FROM `material_order` AS mo
                                            LEFT JOIN `mo_descb` AS mods     ON mo.`order_id`= mods.`order_id` AND mods.`status_id` = 4
                                            LEFT JOIN `user_profile` AS usr  ON mo.`ven_id`= usr.`id` AND usr.`user_type_id` = 3
                                            LEFT JOIN `item_type` AS ityyp   ON mods.`item_type_id`= ityyp.`id`
                                            WHERE mo.`status_id`=4
                                            AND usr.`user_type_id` = 3
                                            AND mo.`location` IS NOT NULL
                                            AND mods.`quantity` != 0
                                            GROUP BY (mo.`order_id`)
                                            ORDER BY(mo.`order_id`) DESC;';
        $res = executeQuery($query);
        if (mysql_num_rows($res) > 0) {
            while ($row = mysql_fetch_assoc($res)) {
                $orderids[] = $row;
            }
            if (is_array($orderids))
                $num = sizeof($orderids);
            if ($num) {
                $k = 1;
                $j = 1;
                for ($i = 0; $i < $num; $i++) {
                    $html[] = '<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title">
                                     <a data-toggle="collapse" data-parent="#view_materialordered" href="#collapse' . $i . '" class="collapsed">{' . $j . '}--{' . $orderids[$i]["order_id"] . '}--{' . $orderids[$i]["venname"] . '}--{' . $orderids[$i]["fdoo"] . '}</a>
                                     </h4>
                                    </div>'
                    ;
                    $qtys["quantity" . $i] = $orderids[$i]["qty"];
                    $itemnames["itemnam" . $i] = $orderids[$i]["itemname"];
                    $mo_ids["moid" . $i] = $orderids[$i]["mo_id"];
                    ++$j;
                }
                for ($x = 0; $x < sizeof($qtys); $x++) {
                    $toggledata = '';
                    $k = 1;
                    $subitemnames = array();
                    $subqtys = array();
                    $submodids = array();
                    $subitemnames = explode(',', $itemnames["itemnam" . $x]);
                    $subqtys = explode(',', $qtys["quantity" . $x]);
                    $submodids = explode(',', $mo_ids['moid' . $x]);
                    for ($y = 0; $y < sizeof($subitemnames); $y++) {
                        $toggledata .= ' <tr><th>' . $k . '</th><th>' . $subitemnames[$y] . '</th><th>' . $subqtys[$y] . '</th><th><input type="number"  name="stockin_' . $submodids[$y] . '" id="stockin_' . $submodids[$y] . '" min="1" max="' . $subqtys[$y] . '" required=""/></th><th><button class="btn btn-success  btn-md" name="' . $submodids[$y] . '" id="update_moitem_' . $submodids[$y] . '"><i class="fa fa-edit fa-fw fa-x2"></i> Update</button>&nbsp</th></tr>';
                        ++$k;
                        $mo_order_ids[] = $submodids[$y];
                        $allqty[] = $subqtys[$y];
                    }
                    $togletitle[] = '<div id="collapse' . $x . '" class="panel-collapse collapse" style="height: 0px;">
                                    <div class="panel-body"><table class="table table-striped table-bordered table-hover" id="mo_list' . $x . '"><thead><tr><th class="text-right">#</th><th>Item Name</th><th>Quantity</th><th>Stock In</th><th>Option</th></tr></thead><tbody>' . $toggledata .
                            '</tbody></table></div></div></div>';
                }
            }
            $jsonptype = array(
                "status" => "success",
                "html" => $html,
                "tgtitle" => $togletitle,
                "mo_orders_id" => $mo_order_ids,
                "moupdate" => "#update_moitem_",
                "stockin" => "#stockin_",
                "allqty" => $allqty
            );
            return $jsonptype;
        } else {

            $jsonptype = array(
                "html" => NULL,
                "status" => "failure",
            );
            return $jsonptype;
        }
    }

    public function fetchitemsupplieddetails() {
        $orderedqty = array();
        $dos = array();
        $mo_order_ids = array();
        $orderids = array();
        $jsonptype = array();
        $itemnames = array();
        $qtys = array();
        $togletitle = array();
        $toggledata = '';
        $html = array();
        $mo_ids = array();
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $query = 'SELECT
                                        mods.order_id AS orderedid,
                                        GROUP_CONCAT(mos.quantity) AS noofrecqty,
                                        mo.fdoo AS doo,
                                        GROUP_CONCAT(mods.fquantity) AS orderedqty,
                                        SUM(mos.quantity) AS totalqty,
                                        GROUP_CONCAT(mos.dos) AS dos,
                                        GROUP_CONCAT(mos.mo_descb_id) AS itemnumm,
                                        GROUP_CONCAT(itype.type) AS typename,
                                        GROUP_CONCAT(mods.item_type_id) AS itemnum,
                                        userp.user_name AS vendorname
                                        FROM mo_supplied mos,mo_descb mods,item_type itype,material_order mo,user_profile userp
                                        WHERE mos.mo_descb_id=mods.id AND mods.item_type_id=itype.id
                                        AND mo.ven_id=userp.id AND mo.order_id=mods.order_id
                                        GROUP BY mods.order_id
                                        ORDER BY mods.order_id DESC;';
        $res = executeQuery($query);
        if (mysql_num_rows($res) > 0) {
            while ($row = mysql_fetch_assoc($res)) {
                $orderids[] = $row;
            }
        }
        if (is_array($orderids))
            $num = sizeof($orderids);
        if ($num) {
            $j = 1;
            for ($i = 0; $i < $num; $i++) {
                $html[] = '<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title">
                                     <a data-toggle="collapse" data-parent="#view_itemsupplied" href="#iscollapse' . $i . '" class="collapsed">{' . $j . '}--{' . $orderids[$i]["orderedid"] . '}--{' . $orderids[$i]["vendorname"] . '}--{' . $orderids[$i]["doo"] . '}</a>
                                     </h4>
                                    </div>'
                ;
                $qtys["quantity" . $i] = $orderids[$i]["noofrecqty"];
                $itemnames["itemnam" . $i] = $orderids[$i]["typename"];
                $dos["dos" . $i] = $orderids[$i]["dos"];
                $orderedqty["orderedqtyy" . $i] = $orderids[$i]["orderedqty"];
                ++$j;
            }
            for ($x = 0; $x < sizeof($qtys); $x++) {
                $toggledata = '';
                $k = 1;
                $subitemnames = array();
                $subqtys = array();
                $subdos = array();
                $suborderedqty = array();
                $subitemnames = explode(',', $itemnames["itemnam" . $x]);
                $subqtys = explode(',', $qtys["quantity" . $x]);
                $subdos = explode(',', $dos["dos" . $x]);
                $suborderedqty = explode(',', $orderedqty["orderedqtyy" . $x]);
                for ($y = 0; $y < sizeof($subitemnames); $y++) {
                    $toggledata .= ' <tr><th>' . $k . '</th><th>' . $subitemnames[$y] . '</th><th>' . $suborderedqty[$y] . '</th><th>' . $subqtys[$y] . '</th><th>' . $subdos[$y] . '</th></tr>';
                    ++$k;
                }
                $togletitle[] = '<div id="iscollapse' . $x . '" class="panel-collapse collapse" style="height: 0px;">
                                    <div class="panel-body"><table class="table table-striped table-bordered table-hover" id="mo_list_supplied' . $x . '"><thead><tr><th class="text-right">#</th><th>Item Name</th><th>Item Ordered</th><th>Item Supplied</th><th>Date of Supplied</th></tr></thead><tbody>' . $toggledata .
                        '</tbody></table></div></div></div>';
            }
        }
        $jsonptype = array(
            "html" => $html,
            "tgtitle" => $togletitle,
        );
        return $jsonptype;
    }

    /* fetching vendor ordered details */

    public function fetchvendorOrderedDeails($oid) {
        $qtn_id = array();
        $ptype = array();
        $html = array();
        $itemid = array();
        $jsonmo = array("html" => '', "item_id" => 0, "order_id" => 0);
        // $jsonmo = array();
        $qty = 0;
        $query = 'SELECT
						m.`id` AS mo_id,
						m.`quantity` AS quan,
						m.`doo` AS dod,
						i.`type` AS itemname
					FROM item_type i,mo_descb m
					WHERE (i.`id`=m.`item_type_id` AND m.`status_id`=4)
					AND m.`order_id`=' . $oid;
        $res = executeQuery($query);
        if (mysql_num_rows($res) > 0) {
            while ($row = mysql_fetch_assoc($res)) {
                $ptype[] = $row;
            }
        }
        if (is_array($ptype))
            $num = sizeof($ptype);
        if ($num) {
            $j = 0;
            for ($i = 0; $i < $num; $i++) {
                $html[] = '<tr id="itemmo_row_' . $oid . '_' . $ptype[$i]["mo_id"] . '"><th>' . ++$j . '</th><th>' . $ptype[$i]["itemname"] . '</th><th class="text-right">' . $ptype[$i]["quan"] . '</th><th class="text-center">' . $ptype[$i]["dod"] . '</th><th>
								<button class="btn btn-warning  btn-md" type="button" name="' . $ptype[$i]["mo_id"] . '" id="edit_moitem_' . $ptype[$i]["mo_id"] . '"><i class="fa fa-edit fa-fw fa-x2"></i> Edit</button>&nbsp;
								<button class="btn btn-danger  btn-md"  type="button"name="' . $ptype[$i]["mo_id"] . '" id="delete_moitem_' . $ptype[$i]["mo_id"] . '" data-toggle="modal" data-target="#myModal_' . $ptype[$i]["mo_id"] . '"><i class="fa fa-trash fa-fw fa-x2"></i> Delete</button>&nbsp;
								<div class="modal fade" id="myModal_' . $ptype[$i]["mo_id"] . '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_' . $ptype[$i]["mo_id"] . '" aria-hidden="true" style="display: none;">
								<div class="modal-dialog">
								<div class="modal-content" style="color:#000;">
								<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h4 class="modal-title" id="myModalLabel_' . $ptype[$i]["mo_id"] . '">Delete Item entry</h4>
								</div>
								<div class="modal-body">
								Do You really want to delete the Item entry ?? press <strong>OK</strong> to delete
								</div>
								<div class="modal-footer">
								<button type="button" class="btn btn-danger" data-dismiss="modal" name=".modal-backdrop" id="deleteOk_' . $ptype[$i]["mo_id"] . '">Ok</button>
								<button type="button" class="btn btn-success" data-dismiss="modal" id="deleteCancel_' . $ptype[$i]["mo_id"] . '">Cancel</button>
								</div>
								</div>
								</div>
								</div>
						</th></tr>';
                $itemid[] = $ptype[$i]["mo_id"];
                $qty += $ptype[$i]["quan"];
                $qtn_id[] = $ptype[$i]["quan"];
            }
            $jsonmo = array("header_html" => '<thead><tr><th class="text-right">#</th><th>Item Name</th><th>Quantity</th><th>Date of order</th><th>Option</th></tr></thead>',
                "html" => $html,
                "footer_html" => '<tr><th colspan="2">&nbsp;</th><th class="text-right">' . $qty . '</th><th colspan="2">&nbsp;</th</tr>',
                "generate" => '<tr><th class="text-center" colspan="5"><button type="button" id="mopdfgen" class="btn btn-md btn-primary"><i class="fa fa-file-pdf-o fa-fw fa-2x"></i>&nbsp;PDF</button>&nbsp;
                                                                                    </th></tr>',
                "item_id" => $itemid,
                "order_id" => $oid,
                "tot_items" => $qty,
                "quantity" => $qtn_id,
                "itemrow" => '#itemmo_row_',
                "es" => '#edit_moitem_',
                "ds" => '#delete_moitem_',
                "alert" => '#myModal_',
                "deleteOk" => '#deleteOk_',
                "deleteCancel" => '#deleteCancel_');
        }
        return $jsonmo;
    }

    public function delete_mo_descb_entry($moid) {
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        /* Item */
        $query = 'UPDATE  `mo_descb` SET `status_id`="6" WHERE `id`= "' . mysql_real_escape_string($moid) . '";';
        if (executeQuery($query)) {
            executeQuery("COMMIT");
            $flag = true;
        }
        return $flag;
    }

    public function GeneratePDFMO($moid) {
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $genpdf = new generatePDF();
        $pdffiel = $genpdf->generateMO($moid);
        $query = 'UPDATE  `material_order` SET `location`="matreall' . $moid . '" WHERE `order_id`= "' . mysql_real_escape_string($moid) . '";';
        if (executeQuery($query)) {
            executeQuery("COMMIT");
            $flag = true;
        }
        return $pdffiel;
    }

    function updatestockin() {
        $query = 'INSERT INTO  `mo_supplied` (`id`,`mo_descb_id`,
					`dos`,
					`quantity`,
					`status_id`
					 )  VALUES(
					NULL,
                                      \'' . mysql_real_escape_string($this->parameters["moid"]) . '\',
                                        now(),
					\'' . mysql_real_escape_string($this->parameters["qtyin"]) . '\',
					4
					);';
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        if (executeQuery($query)) {
            $query = 'UPDATE mo_descb SET quantity = quantity-' . mysql_real_escape_string($this->parameters['qtyin']) . '
                                      WHERE id=' . mysql_real_escape_string($this->parameters['moid']);

            if (executeQuery($query)) {
                executeQuery("COMMIT");
            }
        }
    }

    function fetchmaterialordered() {
        $ptype = array();
        $jsonptype = array();
        $query = 'SELECT
				m.`order_id` as orderid,
				m.`fdoo` as dod,
				u.`user_name` as username
				FROM `user_profile` u,`material_order` m
				WHERE u.`id`=m.`ven_id`
				AND m.`location` IS NULL
				AND m.`status_id` = 4;';
        $res = executeQuery($query);
        if (mysql_num_rows($res) > 0) {
            while ($row = mysql_fetch_assoc($res)) {
                $ptype[] = $row;
            }
        }
        if (is_array($ptype))
            $num = sizeof($ptype);
        if ($num) {
            for ($i = 0; $i < $num; $i++) {
                $jsonptype[] = array(
                    "html" => '<option  value="' . $ptype[$i]["orderid"] . '" >' . $ptype[$i]["username"] . '--' . $ptype[$i]["dod"] . '</option>'
                );
            }
        }
        return $jsonptype;
    }

    /* Fetching items for material  order */

    function fetchOrderItems() {
        $ptype = array();
        $jsonptype = array();
        $query = 'SELECT * FROM `item_type` WHERE `status_id` = 4;';
        $res = executeQuery($query);
        if (mysql_num_rows($res) > 0) {
            while ($row = mysql_fetch_assoc($res)) {
                $ptype[] = $row;
            }
        }
        if (is_array($ptype))
            $num = sizeof($ptype);
        if ($num) {
            for ($i = 0; $i < $num; $i++) {
                $jsonptype[] = array(
                    "html" => '<option  value="' . $ptype[$i]["id"] . '" >' . $ptype[$i]["type"] . ' - ' . $ptype[$i]["min_criteria"] . ' - [' . date('d-M-Y', strtotime($ptype[$i]["add_item_date"])) . ']</option>',
                    "ptype" => $ptype[$i]["type"],
                    "crit" => $ptype[$i]["min_criteria"],
                    "date" => $ptype[$i]["add_item_date"],
                    "id" => $ptype[$i]["id"]
                );
            }
        }
        return $jsonptype;
    }

    /* End Fetching items for material order */
    /* Fetching vendor for Materail order */

    function fetchVendors() {
        $ptype = array();
        $jsonptype = array();
        $query = 'SELECT * FROM `user_profile` WHERE `user_type_id` = 3 AND `status_id` NOT IN  ("5","6","7");';
        $res = executeQuery($query);
        if (mysql_num_rows($res) > 0) {
            while ($row = mysql_fetch_assoc($res)) {
                $ptype[] = $row;
            }
        }
        if (is_array($ptype))
            $num = sizeof($ptype);
        if ($num) {
            for ($i = 0; $i < $num; $i++) {
                $jsonptype[] = array(
                    "html" => '<option  value="' . $ptype[$i]["id"] . '" >' . $ptype[$i]["user_name"] . '</option>'
                );
            }
        }
        return $jsonptype;
    }

}

?>