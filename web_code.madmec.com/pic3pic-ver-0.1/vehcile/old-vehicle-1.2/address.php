<?php
	define("MODULE_0","config.php");
	define("MODULE_1","database.php");
	require_once (MODULE_0);
	require_once(CONFIG_ROOT.MODULE_0);
	require_once(CONFIG_ROOT.MODULE_1);
	$parameters = array(
		"autoloader" 	 => isset($_POST["autoloader"]) 				? $_POST["autoloader"] 				: false,
		"action" 	 	 => isset($_POST["action"]) 					? $_POST["action"]					: false,
		"country" 	 	 => isset($_POST["addata"]["country"]) 			? $_POST["addata"]["country"]		: false,
		"countryCode" 	 => isset($_POST["addata"]["countryCode"]) 		? $_POST["addata"]["countryCode"]	: false,
		"province" 	 	 => isset($_POST["addata"]["province"]) 		? $_POST["addata"]["province"]		: false,
		"provinceCode" 	 => isset($_POST["addata"]["provinceCode"]) 	? $_POST["addata"]["provinceCode"]	: false,
		"district" 	 	 => isset($_POST["addata"]["district"]) 		? $_POST["addata"]["district"]		: false,
		"districtCode" 	 => isset($_POST["addata"]["districtCode"]) 	? $_POST["addata"]["districtCode"]	: false,
		"city_town" 	 => isset($_POST["addata"]["city_town"]) 		? $_POST["addata"]["city_town"]		: false,
		"city_townCode"  => isset($_POST["addata"]["city_townCode"]) 	? $_POST["addata"]["city_townCode"]	: false,
		"st_loc" 	 	 => isset($_POST["addata"]["st_loc"]) 			? $_POST["addata"]["st_loc"]		: false,
		"st_locCode" 	 => isset($_POST["addata"]["st_locCode"]) 		? $_POST["addata"]["st_locCode"]	: false,
		"timezone" 	 	 => isset($_POST["addata"]["timezone"]) 		? $_POST["addata"]["timezone"]		: false,
		"countryId" 	 => isset($_POST["addata"]["countryId"]) 		? $_POST["addata"]["countryId"]		: false,
		"provinceId" 	 => isset($_POST["addata"]["provinceId"]) 		? $_POST["addata"]["provinceId"]	: false,
		"districtId" 	 => isset($_POST["addata"]["districtId"]) 		? $_POST["addata"]["districtId"]	: false,
		"city_townId" 	 => isset($_POST["addata"]["city_townId"]) 		? $_POST["addata"]["city_townId"]	: false,
		"st_locId" 	 	 => isset($_POST["addata"]["st_locId"]) 		? $_POST["addata"]["st_locId"]		: false
	);
	unset($_POST);
	function main($parameters){
		$link = MySQLconnect(DBHOST,DBUSER,DBPASS);
		if(get_resource_type($link) == 'mysql link'){
			if(($db_select = selectDB(DBNAME_ZERO,$link)) == 1){
				if(!ValidateAdmin()){
					session_destroy();
					echo "logout";
				}else{
					if(($db_select = selectDB(DBNAME_MAST,$link)) == 1){
						switch($parameters["action"]){
							/*case "getIPData":
								getIPData();
							break;*/
							case "getCountry":
								getCountry();
							break;
							case "getState":
								getState();
							break;
							case "getDistrict":
								getDistrict();
							break;
							case "getCity":
								getCity();
							break;
							case "getLocality":
								getLocality();
							break;
							case "setCountry":
								setCountry($parameters);
							break;
							case "setState":
								setState($parameters);
							break;
							case "setDistrict":
								setDistrict($parameters);
							break;
							case "setCity":
								setCity($parameters);
							break;
							case "setLocality":
								setLocality($parameters);
							break;
						}
					}
				}
			}
		}
		if(get_resource_type($link) == 'mysql link')
			mysql_close($link);
		exit(0);
	}
	/*function getIPData(){
		if(isset($_SESSION["IP_INFO"])){
			echo (json_encode($_SESSION["IP_INFO"]));
		}else{
			setIPInfo();
			echo (json_encode($_SESSION["IP_INFO"]));
		}
	}*/
	/* Function to fetch list of countris FROM madmec_data */
	function getCountry(){
		$country = array();
		$jsoncountry = array();
		$res=executeQuery("SELECT `ISO`,`Country`,`Postal_Code_Regex`,`Phone` FROM `countries` ORDER BY `Country` ASC;");
		$i=1;
		if(mysql_num_rows($res) > 0){
			while($row=mysql_fetch_array($res)){
				$country[$i]['countryCode'] = $row['ISO'];
				$country[$i]['Country'] =  $row['Country'];
				$country[$i]['PCR'] =  $row['Postal_Code_Regex'];
				$country[$i]['Phone'] =  $row['Phone'];
				$jsoncountry[] = array("label" => $country[$i]['Country'], 
										// "label" => $country[$i]['countryCode'] .' - '. $country[$i]['Country'] .' - '. $country[$i]['Phone'], 
									   "value" => $i,
									   "countryCode" => $country[$i]['countryCode'],
									   "Country" => $country[$i]['Country'],
									   "PCR" => $country[$i]['PCR'],
									   "Phone" => $country[$i]['Phone']);
				$i++;
			}
		}
		else
			$country = NULL;
		if($country != NULL){
			$_SESSION['address']['countries'] = $country;
		}
		else{
			$_SESSION['address']['countries'] = NULL;
		}
		echo (json_encode($jsoncountry));
	}
	/* Function to fetch list of states FROM madmec_data */
	function getState(){
		$states = array();
		$jsonstate = array();
		$res=executeQuery("SELECT `asciiname`,`admin1_code`,`latitude`,`longitude`,`timezone` FROM `first_order_administrative_division`
							WHERE `country_code` = '".mysql_real_escape_string($_SESSION['address']['countryCode'])."';");
		if(mysql_num_rows($res) > 0){
			$i=1;
			while($row=mysql_fetch_array($res)){
				if($row["asciiname"] != NULL){
					$states[$i]['provinceCode'] = $row["admin1_code"];
					$states[$i]['province'] = $row["asciiname"];
					$states[$i]['timezone'] = $row["timezone"];
					$states[$i]['latitude'] = $row["latitude"];
					$states[$i]['longitude'] = $row["longitude"];
					$jsonstate[] = array("label" => $states[$i]['province'], 
										// "label" => $states[$i]['provinceCode'] .' - '. $states[$i]['province'] .' - '. $states[$i]['timezone'], 
										   "value" => $i,
										   "provinceCode" => $states[$i]['provinceCode'],
										   "province" => $states[$i]['province'],
										   "lat" => $states[$i]['latitude'],
										   "lon" => $states[$i]['longitude'],
										   "timezone" => $states[$i]['timezone']);
					$i++;
				}
			}
		}
		else
			$states = NULL;
		if($states != NULL){
			$_SESSION['address']['states'] = $states;
		}
		else{ 
			$_SESSION['address']['states'] = NULL;
		}
		echo (json_encode($jsonstate));
	}
	/* Function to fetch list of district FROM madmec_data */
	function getDistrict(){
		$jsondistrict = array();
		$districts = array();
		$res=executeQuery("SELECT `asciiname`,`admin2_code`,`latitude`,`longitude`,`timezone` FROM `second_order_administrative_division`
							WHERE `country_code` = '".mysql_real_escape_string($_SESSION['address']['countryCode'])."'
							AND `admin1_code` = '".mysql_real_escape_string($_SESSION['address']['provinceCode'])."'
							ORDER BY `asciiname` ASC;");
		if(mysql_num_rows($res) > 0){
			$i=1;
			while($row=mysql_fetch_array($res)){
				if($row["asciiname"] != NULL){
					$districts[$i]['districtCode'] = $row["admin2_code"];
					$districts[$i]['district'] = $row["asciiname"];
					$districts[$i]['timezone'] = $row["timezone"];
					$districts[$i]['latitude'] = $row["latitude"];
					$districts[$i]['longitude'] = $row["longitude"];
					$jsondistrict[] = array("label" => $districts[$i]['district'], 
										// "label" => $districts[$i]['districtCode'] .' - '. $districts[$i]['district'] .' - '. $districts[$i]['timezone'], 
										   "value" => $i,
										   "districtCode" => $districts[$i]['districtCode'],
										   "district" => $districts[$i]['district'],
										   "lat" => $districts[$i]['latitude'],
										   "lon" => $districts[$i]['longitude'],
										   "timezone" => $districts[$i]['timezone']);
					$i++;
				}
			}
		}
		else
			$districts = NULL;
		if($districts != NULL){
			$_SESSION['address']['districts'] = $districts;
		}
		else{
			$_SESSION['address']['districts'] = NULL;
		}
		echo (json_encode($jsondistrict));
	}
	/* Function to fetch list of city FROM madmec_data */
	function getCity(){
		$jsoncity = array();
		$cities = array();
		$j=1;
		$res0=executeQuery("SELECT 	DISTINCT(UNIN.`asciiname`) AS asciiname,
									UNIN.`admin3_code`,
									UNIN.`timezone`,
									UNIN.`latitude`,
									UNIN.`longitude`
							FROM(
								SELECT 	DISTINCT(a.`asciiname`),
										a.`admin3_code`,
										a.`latitude`,
										a.`longitude`,
										a.`timezone`,
										a.`country_code`,
										a.`admin1_code` 
								FROM `second_order_administrative_division` AS a
								WHERE a.`country_code` = '".mysql_real_escape_string($_SESSION['address']['countryCode'])."'
								AND a.`admin1_code` = '".mysql_real_escape_string($_SESSION['address']['provinceCode'])."'
							UNION
								SELECT	DISTINCT(b.`asciiname`),
										b.`admin3_code`,
										b.`latitude`,
										b.`longitude`,
										b.`timezone`,
										b.`country_code`,
										b.`admin1_code` 
								FROM `third_order_administrative_division`  AS b
								WHERE b.`country_code` = '".mysql_real_escape_string($_SESSION['address']['countryCode'])."'
								AND b.`admin1_code` = '".mysql_real_escape_string($_SESSION['address']['provinceCode'])."'
							UNION
								SELECT 	DISTINCT(c.`asciiname`),
										c.`admin3_code`,
										c.`latitude`,
										c.`longitude`,
										c.`country_code`,
										c.`timezone`,
										c.`admin1_code` 
								FROM `seat_of_a_first_order_administrative_division`  AS c
								WHERE c.`country_code` = '".mysql_real_escape_string($_SESSION['address']['countryCode'])."'
								AND c.`admin1_code` = '".mysql_real_escape_string($_SESSION['address']['provinceCode'])."'
							UNION
								SELECT 	DISTINCT(d.`asciiname`),
										d.`admin3_code`,
										d.`latitude`,
										d.`longitude`,
										d.`timezone`,
										d.`country_code`,
										d.`admin1_code` 
								FROM `seat_of_a_second_order_administrative_division`   AS d
								WHERE d.`country_code` = '".mysql_real_escape_string($_SESSION['address']['countryCode'])."'
								AND d.`admin1_code` = '".mysql_real_escape_string($_SESSION['address']['provinceCode'])."'
							UNION
								SELECT 	DISTINCT(e.`asciiname`),
										e.`admin3_code`,
										e.`latitude`,
										e.`longitude`,
										e.`timezone`,
										e.`country_code`,
										e.`admin1_code` 
								FROM `seat_of_a_third_order_administrative_division`  AS e
								WHERE e.`country_code` = '".mysql_real_escape_string($_SESSION['address']['countryCode'])."'
								AND e.`admin1_code` = '".mysql_real_escape_string($_SESSION['address']['provinceCode'])."'
							UNION
								SELECT 	DISTINCT(f.`asciiname`),
										f.`admin3_code`,
										f.`latitude`,
										f.`longitude`,
										f.`timezone`,
										f.`country_code`,
										f.`admin1_code` 
								FROM `populated_place` AS f 
								WHERE f.`country_code` = '".mysql_real_escape_string($_SESSION['address']['countryCode'])."'
								AND f.`admin1_code` = '".mysql_real_escape_string($_SESSION['address']['provinceCode'])."'
							) AS UNIN ORDER BY `asciiname` ASC;");
		if(mysql_num_rows($res0)){
			while($row=mysql_fetch_array($res0)){
				if($row["asciiname"] != NULL){
					$cities[$j]['city_townCode'] = $row["admin3_code"];
					$cities[$j]['city_town'] = $row["asciiname"];
					$cities[$j]['timezone'] = $row["timezone"];
					$cities[$j]['latitude'] = $row["latitude"];
					$cities[$j]['longitude'] = $row["longitude"];
					$jsoncity[] = array("label" => $cities[$j]['city_town'], 
										// "label" => $cities[$j]['city_townCode'] .' - '. $cities[$j]['city_town'] .' - '. $cities[$j]['timezone'], 
										   "value" => $j,
										   "city_townCode" => $cities[$j]['city_townCode'],
										   "city_town" => $cities[$j]['city_town'],
										   "lat" => $cities[$j]['latitude'],
										   "lon" => $cities[$j]['longitude'],
										   "timezone" => $cities[$j]['timezone']);
					$j++;
				}
			}
		}
		if($cities != NULL){
			$_SESSION['address']['cities'] = $cities;
		}
		else{
			$_SESSION['address']['cities'] = NULL;
		}
		echo (json_encode($jsoncity));
	}
	/* Function to fetch list of towns FROM madmec_data */
	function getLocality(){
		$jsonstreet = array();
		$streets = array();
		$j = 1;
		$res0=executeQuery("SELECT 	DISTINCT(UNIN.`asciiname`) AS asciiname,
									UNIN.`admin4_code`,
									UNIN.`timezone`,
									UNIN.`latitude`,
									UNIN.`longitude`
							FROM(
								SELECT 	DISTINCT(a.`asciiname`),
										a.`admin4_code`,
										a.`latitude`,
										a.`longitude`,
										a.`timezone`,
										a.`country_code`,
										a.`admin1_code` 
								FROM `third_order_administrative_division` AS a
								WHERE a.`country_code` = '".mysql_real_escape_string($_SESSION['address']['countryCode'])."'
								AND a.`admin1_code` = '".mysql_real_escape_string($_SESSION['address']['provinceCode'])."'
							UNION
								SELECT	DISTINCT(b.`asciiname`),
										b.`admin4_code`,
										b.`latitude`,
										b.`longitude`,
										b.`timezone`,
										b.`country_code`,
										b.`admin1_code` 
								FROM `fourth_order_administrative_division`  AS b
								WHERE b.`country_code` = '".mysql_real_escape_string($_SESSION['address']['countryCode'])."'
								AND b.`admin1_code` = '".mysql_real_escape_string($_SESSION['address']['provinceCode'])."'
							UNION
								SELECT 	DISTINCT(c.`asciiname`),
										c.`admin4_code`,
										c.`latitude`,
										c.`longitude`,
										c.`country_code`,
										c.`timezone`,
										c.`admin1_code` 
								FROM `seat_of_a_first_order_administrative_division`  AS c
								WHERE c.`country_code` = '".mysql_real_escape_string($_SESSION['address']['countryCode'])."'
								AND c.`admin1_code` = '".mysql_real_escape_string($_SESSION['address']['provinceCode'])."'
							UNION
								SELECT 	DISTINCT(d.`asciiname`),
										d.`admin4_code`,
										d.`latitude`,
										d.`longitude`,
										d.`timezone`,
										d.`country_code`,
										d.`admin1_code` 
								FROM `seat_of_a_second_order_administrative_division`   AS d
								WHERE d.`country_code` = '".mysql_real_escape_string($_SESSION['address']['countryCode'])."'
								AND d.`admin1_code` = '".mysql_real_escape_string($_SESSION['address']['provinceCode'])."'
							UNION
								SELECT 	DISTINCT(e.`asciiname`),
										e.`admin4_code`,
										e.`latitude`,
										e.`longitude`,
										e.`timezone`,
										e.`country_code`,
										e.`admin1_code` 
								FROM `seat_of_a_third_order_administrative_division`  AS e
								WHERE e.`country_code` = '".mysql_real_escape_string($_SESSION['address']['countryCode'])."'
								AND e.`admin1_code` = '".mysql_real_escape_string($_SESSION['address']['provinceCode'])."'
							UNION
								SELECT 	DISTINCT(f.`asciiname`),
										f.`admin4_code`,
										f.`latitude`,
										f.`longitude`,
										f.`timezone`,
										f.`country_code`,
										f.`admin1_code` 
								FROM `populated_place` AS f 
								WHERE f.`country_code` = '".mysql_real_escape_string($_SESSION['address']['countryCode'])."'
								AND f.`admin1_code` = '".mysql_real_escape_string($_SESSION['address']['provinceCode'])."'
							) AS UNIN ORDER BY `asciiname` ASC;");
		if(mysql_num_rows($res0)){
			while($row=mysql_fetch_array($res0)){
				if($row["asciiname"] != NULL){
					$streets[$j]['st_locCode'] = $row["admin4_code"];
					$streets[$j]['st_loc'] = $row["asciiname"];
					$streets[$j]['timezone'] = $row["timezone"];
					$streets[$j]['latitude'] = $row["latitude"];
					$streets[$j]['longitude'] = $row["longitude"];
					$jsonstreet[] = array("label" => $streets[$j]['st_loc'], 
										// "label" => $streets[$j]['st_locCode'] .' - '. $streets[$j]['st_loc'] .' - '. $streets[$j]['timezone'], 
										   "value" => $j,
										   "st_locCode" => $streets[$j]['st_locCode'],
										   "st_loc" => $streets[$j]['st_loc'],
										   "lat" => $streets[$j]['latitude'],
										   "lon" => $streets[$j]['longitude'],
										   "timezone" => $streets[$j]['timezone']);
					$j++;
				}
			}
		}
		if($streets != NULL){
			$_SESSION['address']['streets'] = $streets;
		}
		else{
			$_SESSION['address']['streets'] = NULL;
			$html =  '<input type="text" name="town" id="town" class="form-control" value="" placeholder="Street / Locality" />';
		}
		echo (json_encode($jsonstreet));
	}
	/* Function to set the country */
	function setCountry($parameters){
		$countries = $_SESSION['address']['countries'];
		for($i=1;$i<=sizeof($countries);$i++){
			if(strtolower($parameters["country"]) == strtolower($countries[$i]['Country']) &&
				strtolower($parameters["countryCode"]) == strtolower($countries[$i]['countryCode'])){
				$_SESSION['address']['countryCode'] =  $countries[$i]['countryCode'];
				$_SESSION['address']['Country'] = $countries[$i]['Country'];
				$_SESSION['address']['PCR'] = $countries[$i]['PCR'];
				$_SESSION['address']['Phone'] = $countries[$i]['Phone'];
				break;
			}
		}
	}
	/* Function to set the state */
	function setState($parameters){
		$states = $_SESSION['address']['states'];
		for($i=1;$i<=sizeof($states);$i++){
			if(strtolower($parameters["countryCode"]) 	== strtolower($_SESSION['address']['countryCode']) &&
			  strtolower($parameters["province"]) 		== strtolower($states[$i]["province"])){
				$_SESSION['address']['provinceCode'] =  $states[$i]['provinceCode'];
				$_SESSION['address']['province'] = $states[$i]['province'];
				$_SESSION['address']['latitude'] = $states[$i]["latitude"];
				$_SESSION['address']['longitude'] = $states[$i]["longitude"];
				$_SESSION['address']['timezone'] = $states[$i]['timezone'];
				break;
			}
		}
	}
	/* Function to set the district */
	function setDistrict($parameters){
		$districts = $_SESSION['address']['districts'];
		for($i=1;$i<=sizeof($districts);$i++){
			if(strtolower($parameters["countryCode"]) 	== strtolower($_SESSION['address']['countryCode']) &&
			  strtolower($parameters["provinceCode"]) 	== strtolower($_SESSION['address']["provinceCode"]) &&
			  strtolower($parameters["district"]) 	== strtolower($districts[$i]["district"])
			 ){
				$_SESSION['address']['districtCode'] =  $districts[$i]['districtCode'];
				$_SESSION['address']['district'] = $districts[$i]['district'];
				$_SESSION['address']['latitude'] = $districts[$i]["latitude"];
				$_SESSION['address']['longitude'] = $districts[$i]["longitude"];
				$_SESSION['address']['timezone'] = $districts[$i]['timezone'];
				break;
			}
		}
	}
	/* Function to set the city */
	function setCity($parameters){
		$cities = $_SESSION['address']['cities'];
		for($i=1;$i<=sizeof($cities);$i++){
			if(strtolower($parameters["countryCode"]) 	== strtolower($_SESSION['address']['countryCode']) &&
			  strtolower($parameters["provinceCode"]) 	== strtolower($_SESSION['address']["provinceCode"]) &&
			  strtolower($parameters["city_town"]) 	== strtolower($cities[$i]["city_town"])
			 ){
				$_SESSION['address']['city_townCode'] =  $cities[$i]['city_townCode'];
				$_SESSION['address']['city_town'] = $cities[$i]['city_town'];
				$_SESSION['address']['latitude'] = $cities[$i]["latitude"];
				$_SESSION['address']['longitude'] = $cities[$i]["longitude"];
				$_SESSION['address']['timezone'] = $cities[$i]['timezone'];
				break;
			}
		}
	}
	/* Function to set the street / locality */
	function setLocality($parameters){
		$streets = $_SESSION['address']['streets'];
		for($i=1;$i<=sizeof($streets);$i++){
			if(strtolower($parameters["countryCode"]) 	== strtolower($_SESSION['address']['countryCode']) &&
			  strtolower($parameters["provinceCode"]) 	== strtolower($_SESSION['address']["provinceCode"])&&
			  strtolower($parameters["st_loc"]) 	== strtolower($streets[$i]["st_loc"])
			 ){
				$_SESSION['address']['st_locCode'] =  $streets[$i]['st_locCode'];
				$_SESSION['address']['st_loc'] = $streets[$i]['st_loc'];
				$_SESSION['address']['latitude'] = $streets[$i]["latitude"];
				$_SESSION['address']['longitude'] = $streets[$i]["longitude"];
				$_SESSION['address']['timezone'] = $streets[$i]['timezone'];
				break;
			}
		}
	}
	if(isset($parameters["autoloader"]) && $parameters["autoloader"] == 'true'){
		global $parameters;
		main($parameters);
	}
?>
