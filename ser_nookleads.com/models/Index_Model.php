<?php
class Index_Model extends BaseModel {
    function __construct() {
        parent::__construct();
    }
    public function filterListLead() {
        $_SESSION["ListNewLead"] = NULL;
        $languages = '""';
        $countries = '""';
        $sections = '""';
        if (isset($this->postBaseData["action"]) 
                && $this->postBaseData["action"] == "filterListLead") {
            if (isset($this->postBaseData["details"]["target"]) 
                    && $this->postBaseData["details"]["target"] === 'Country') {
                if (isset($this->postBaseData["details"]["countries"]) 
                        && is_array($this->postBaseData["details"]["countries"])
                        && count($this->postBaseData["details"]["countries"]) > 0) {
                    $countries = implode(",", array_values($this->postBaseData["details"]["countries"]));
                }
                if (isset($this->postBaseData["details"]["languages"]) 
                        && is_array($this->postBaseData["details"]["languages"])
                        && count($this->postBaseData["details"]["languages"]) > 0) {
                    $languages = implode(",", array_values($this->postBaseData["details"]["languages"]));
                }
            }
            if (isset($this->postBaseData["details"]["sections"]) 
                    && is_array($this->postBaseData["details"]["sections"])
                    && count($this->postBaseData["details"]["sections"]) > 0) {
                $sections = implode(",", array_values($this->postBaseData["details"]["sections"]));
            }
        }
        $stm = $this->db->prepare('/*Lead Start*/
                SELECT
                    /*COUNT(t1.`id`) AS lead_ct,*/
                    t1.*,
                    t1.`id`,
                    t1.`title`,
                    t1.`photo_id`,
                    t1.`section_id`,
                    t1.`user_id`,
                    t1.`created_at`,
                    IF((t1.`photo_id` IS NULL OR t1.`photo_id` = NULL OR t1.`photo_id` = "" OR t1.`photo_id` = 0), NULL , t1.`photo_id`) AS p_pic_flag,
                    t2.*,
                    t3.*,
                    t4.*,
                    t5.*,
                    t6.*,
                    t7.*,
                    t8.*,
                    t9.*,
                    t10.*,
                    up.`leaderpic`,
                    up.`leaderid`,
                    up.`leadername`,
                    up.`leaderemail`,
                    up.`leadercell`
                FROM `lead` AS t1
                /*Lead Countries*/
                LEFT JOIN (
                    SELECT
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS pcont_id, t1.`lead_id`, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS pcont_time,
                        GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS pcont_contid, GROUP_CONCAT(t2.`Country` SEPARATOR "♥☻☻♥") AS pcont_contname
                    FROM `lead_countries` 	AS t1
                    LEFT JOIN `nookleads_countries`	AS t2 ON t2.`id` = t1.`country_id`
                    WHERE t1.`status_id` = 4
                    AND t2.`status_id` = 4
                    OR t2.`id` IN ('.$countries.')
                    GROUP BY(t1.`lead_id`)
                    ORDER BY(t1.`lead_id`)
                ) AS t2 ON t2.`lead_id` = t1.`id`
                /*Lead User*/
                INNER JOIN (
                    SELECT 
                        ad.`id` AS leaderid,
                        ad.`user_name` AS leadername,
                        ad.`email` AS leaderemail,
                        ad.`cell_number` AS leadercell,
                        CASE WHEN ad.`icon` IS NULL OR ad.`icon`  = "" OR ph1.`ver3` IS NULL OR ph1.`ver3` = ""
                        THEN "' . $this->config["DEFAULT_USER_ICON_IMG"] . '"
                        ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver3`)
                        END AS leaderpic
                    FROM `user_profile` AS ad
                    LEFT JOIN `photo` AS ph1 ON ad.`icon` = ph1.`id` 
                    WHERE ad.`status_id` = 4
                ) AS up ON up.`leaderid` = t1.`user_id` 
                /*Lead Report*/
                LEFT JOIN (
                    SELECT
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS pr_id, t1.`lead_id`, GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS pr_uid, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS pr_time,
                        GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS pr_repid, GROUP_CONCAT(t2.`report_name`  SEPARATOR "♥☻☻♥") AS pr_repname,
                        GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻☻♥") AS pr_uname
                    FROM `lead_report` 			AS t1
                    LEFT JOIN `report`			AS t2 ON t2.`id` = t1.`report_id`
                    LEFT JOIN `user_profile`	AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 4
                    AND t2.`status_id` = 4
                    AND up.`status_id` = 4
                    GROUP BY(t1.`lead_id`)
                    ORDER BY(t1.`lead_id`)
                ) AS t3 ON t3.`lead_id` = t1.`id`
                /*Lead Preferences*/
                LEFT JOIN (
                    SELECT
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS pp_id, t1.`lead_id`, GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS pp_uid, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS pp_time,
                        GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS pp_preid, GROUP_CONCAT(t2.`preferences` SEPARATOR "♥☻☻♥") AS pp_pref,
                        GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻☻♥") AS pp_uname
                    FROM `lead_preferences` 	AS t1
                    LEFT JOIN `preferences`		AS t2 ON t2.`id` = t1.`preferences_id`
                    LEFT JOIN `user_profile`	AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 4
                    AND t2.`status_id` = 4
                    AND up.`status_id` = 4
                    GROUP BY(t1.`lead_id`)
                    ORDER BY(t1.`lead_id`)
                ) AS t4 ON t4.`lead_id` = t1.`id`
                /*Lead Approvals*/
                LEFT JOIN (
                    SELECT 
                        COUNT(t1.`id`) AS lk_p_ct,
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS lk_p_id, t1.`lead_id`, GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS lk_p_uid, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS lk_p_time,
                        GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻☻♥") AS lk_p_uname
                    FROM `lead_approvals` 			AS t1
                    LEFT JOIN `user_profile` 	AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 36
                    AND up.`status_id` = 4
                    GROUP BY(t1.`lead_id`)
                    ORDER BY(t1.`lead_id`)
                ) AS t5 ON t5.`lead_id` = t1.`id`
                /*Lead Quotations*/
                LEFT JOIN (
                SELECT
                    t1.`lead_id`,
                    COUNT(t1.`id`) AS pc_ct,
                    GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS pc_id, 
                    GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS pc_uid, 
                    GROUP_CONCAT(t1.`quotation` SEPARATOR "♥☻☻♥") AS quotations, 
                    GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS pc_time,
                    GROUP_CONCAT(IF((t1.`photo_id` IS NULL OR t1.`photo_id` = NULL OR t1.`photo_id` = "" OR t1.`photo_id` = 0), "" , t1.`photo_id`) SEPARATOR "♥☻☻♥") AS pc_pic_flag,
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_phid, 
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
			(SELECT TRIM(`photo`.`original_pic`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_ph, 
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
			(SELECT TRIM(`photo`.`ver1`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_pv1, 
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
			(SELECT TRIM(`photo`.`ver2`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_pv2, 
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
			(SELECT TRIM(`photo`.`ver3`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_pv3, 
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
			(SELECT TRIM(`photo`.`ver4`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_pv4, 
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
			(SELECT TRIM(`photo`.`ver5`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_pv5, 
                    GROUP_CONCAT(t2.`pcp_id` SEPARATOR "♥☻☻♥") AS pcp_id, 
                    GROUP_CONCAT(t2.`pcp_uid` SEPARATOR "♥☻☻♥") AS pcp_uid, 
                    GROUP_CONCAT(t2.`pcp_time` SEPARATOR "♥☻☻♥") AS pcp_time, 
                    GROUP_CONCAT(t2.`pcp_preid` SEPARATOR "♥☻☻♥") AS pcp_preid, 
                    GROUP_CONCAT(t2.`pcp_pref` SEPARATOR "♥☻☻♥") AS pcp_pref, 
                    GROUP_CONCAT(t2.`pcp_uname` SEPARATOR "♥☻☻♥") AS pcp_uname, 
                    GROUP_CONCAT(t3.`lk_pc_id` SEPARATOR "♥☻☻♥") AS lk_pc_id, 
                    GROUP_CONCAT(t3.`lk_pc_uid` SEPARATOR "♥☻☻♥") AS lk_pc_uid, 
                    GROUP_CONCAT(t3.`lk_pc_time` SEPARATOR "♥☻☻♥") AS lk_pc_time, 
                    GROUP_CONCAT(t3.`lk_pc_uname` SEPARATOR "♥☻☻♥") AS lk_pc_uname, 
                    GROUP_CONCAT(t3.`lk_pc_ct` SEPARATOR "♥☻☻♥") AS lk_pc_ct,
                    GROUP_CONCAT(t4.`pcr_id` SEPARATOR "♥☻☻♥") AS pcr_id, 
                    GROUP_CONCAT(t4.`pcr_uid` SEPARATOR "♥☻☻♥") AS pcr_uid, 
                    GROUP_CONCAT(t4.`wo` SEPARATOR "♥☻☻♥") AS wo, 
                    GROUP_CONCAT(t4.`pcr_time` SEPARATOR "♥☻☻♥") AS pcr_time,  
                    GROUP_CONCAT(t4.`pcr_ct` SEPARATOR "♥☻☻♥") AS pcr_ct, 
                    GROUP_CONCAT(t4.`pcrp_id` SEPARATOR "♥☻☻♥") AS pcrp_id, 
                    GROUP_CONCAT(t4.`pcrp_uid` SEPARATOR "♥☻☻♥") AS pcrp_uid, 
                    GROUP_CONCAT(t4.`pcrp_time` SEPARATOR "♥☻☻♥") AS pcrp_time, 
                    GROUP_CONCAT(t4.`pcr_pic_flag` SEPARATOR "♥☻☻♥") AS pcr_pic_flag, 
                    GROUP_CONCAT(t4.`pcrp_preid` SEPARATOR "♥☻☻♥") AS pcrp_preid,  
                    GROUP_CONCAT(t4.`pcrp_pref` SEPARATOR "♥☻☻♥") AS pcrp_pref,  
                    GROUP_CONCAT(t4.`pcrp_uname` SEPARATOR "♥☻☻♥") AS pcrp_uname, 
                    GROUP_CONCAT(t4.`lk_rep_ct` SEPARATOR "♥☻☻♥") AS lk_rep_ct, 
                    GROUP_CONCAT(t4.`lk_rep_id` SEPARATOR "♥☻☻♥") AS lk_rep_id, 
                    GROUP_CONCAT(t4.`lk_woer_id` SEPARATOR "♥☻☻♥") AS lk_woer_id, 
                    GROUP_CONCAT(t4.`lk_wotime` SEPARATOR "♥☻☻♥") AS lk_wotime, 
                    GROUP_CONCAT(t4.`lk_woer_name` SEPARATOR "♥☻☻♥") AS lk_woer_name, 
                    GROUP_CONCAT(t4.`pcr_phid` SEPARATOR "♥☻☻♥") AS pcr_phid, 
                    GROUP_CONCAT(t4.`pcr_ph` SEPARATOR "♥☻☻♥") AS pcr_ph, 
                    GROUP_CONCAT(t4.`pcr_pv1` SEPARATOR "♥☻☻♥") AS pcr_pv1, 
                    GROUP_CONCAT(t4.`pcr_pv2` SEPARATOR "♥☻☻♥") AS pcr_pv2, 
                    GROUP_CONCAT(t4.`pcr_pv3` SEPARATOR "♥☻☻♥") AS pcr_pv3,  
                    GROUP_CONCAT(t4.`pcr_pv4` SEPARATOR "♥☻☻♥") AS pcr_pv4,  
                    GROUP_CONCAT(t4.`pcr_pv5` SEPARATOR "♥☻☻♥") AS pcr_pv5, 
                    GROUP_CONCAT(t4.`woererid` SEPARATOR "♥☻☻♥") AS woererid,
                    GROUP_CONCAT(t4.`woername` SEPARATOR "♥☻☻♥") AS woername,
                    GROUP_CONCAT(t4.`woeremail` SEPARATOR "♥☻☻♥") AS woeremail,
                    GROUP_CONCAT(t4.`woercell` SEPARATOR "♥☻☻♥") AS woercell,
                    GROUP_CONCAT(t4.`woerpic` SEPARATOR "♥☻☻♥") AS woerpic,
                    GROUP_CONCAT(up.`quotationererid` SEPARATOR "♥☻☻♥") AS  quotationererid,
                    GROUP_CONCAT(up.`quotationername` SEPARATOR "♥☻☻♥") AS  quotationername,
                    GROUP_CONCAT(up.`quotationeremail` SEPARATOR "♥☻☻♥") AS  quotationeremail,
                    GROUP_CONCAT(up.`quotationercell` SEPARATOR "♥☻☻♥") AS  quotationercell,
                    GROUP_CONCAT(up.`quotationerpic` SEPARATOR "♥☻☻♥") AS  quotationerpic
                FROM `lead_quotations` 					AS t1
                /*Lead Quotations User*/
                INNER JOIN (
                    SELECT 
                        ad.`id` AS quotationererid,
                        ad.`user_name` AS quotationername,
                        ad.`email` AS quotationeremail,
                        ad.`cell_number` AS quotationercell,
                        CASE WHEN ad.`icon` IS NULL OR ad.`icon`  = "" OR ph1.`ver3` IS NULL OR ph1.`ver3` = ""
                        THEN "' . $this->config["DEFAULT_USER_ICON_IMG"] . '"
                        ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver3`)
                        END AS quotationerpic
                    FROM `user_profile` AS ad
                    LEFT JOIN `photo` AS ph1 ON ad.`icon` = ph1.`id`
                    WHERE ad.`status_id` = 4
                    AND ad.`status_id` = 4
                ) AS up ON up.`quotationererid` = t1.`user_id`
                /*Lead Quotations Preferences*/
                LEFT JOIN (
                    SELECT
                            GROUP_CONCAT(t1.`id` SEPARATOR "♥☻♥") AS pcp_id,
                            t1.`lead_quotations_id`,
                            GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻♥") AS pcp_uid,
                            GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻♥") AS pcp_time,
                            GROUP_CONCAT(t2.`id` SEPARATOR "♥☻♥") AS pcp_preid,
                            GROUP_CONCAT(t2.`preferences` SEPARATOR "♥☻♥") AS pcp_pref,
                            GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻♥") AS pcp_uname
                    FROM `lead_quotations_preferences` 	AS t1
                    LEFT JOIN `preferences`				AS t2 ON t2.`id` = t1.`preferences_id`
                    LEFT JOIN `user_profile`			AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 4
                    AND t2.`status_id` = 4
                    AND up.`status_id` = 4
                    GROUP BY(t1.`lead_quotations_id`)
                    ORDER BY(t1.`lead_quotations_id`)
                )AS t2 ON t2.`lead_quotations_id` = t1.`id`
                /*Lead Quotations Approvals*/
                LEFT JOIN (
                    SELECT
                        COUNT(t1.`id`) AS lk_pc_ct,
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻♥") AS lk_pc_id, 
                        GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻♥") AS pc_time,
                        t1.`lead_quotations_id`, 
                        GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻♥") AS lk_pc_uid, 
                        GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻♥") AS lk_pc_time,
                        GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻♥") AS lk_pc_uname
                    FROM `lead_quotations_approvals` 	AS t1
                    LEFT JOIN `user_profile` 	AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 36
                    AND up.`status_id` = 4
                    GROUP BY(t1.`lead_quotations_id`)
                    ORDER BY(t1.`lead_quotations_id`)
                ) AS t3 ON t3.`lead_quotations_id` = t1.`id`
                /*Lead Quotations Wo*/
                LEFT JOIN (
                    SELECT
                        COUNT(t1.`id`) AS pcr_ct,
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻♥") AS pcr_id, 
                        t1.`lead_quotations_id` AS pcr_pc_id, 
                        GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻♥") AS pcr_uid, 
                        GROUP_CONCAT(t1.`wo` SEPARATOR "♥☻♥") AS wo, 
                        GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻♥") AS pcr_time,
                        GROUP_CONCAT(
                            IF((t1.`photo_id` IS NULL OR t1.`photo_id` = NULL OR t1.`photo_id` = "" OR t1.`photo_id` = 0), "" , t1.`photo_id`) 
                             SEPARATOR "♥☻♥"
                        ) AS pcr_pic_flag,
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_phid, 
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
                            (SELECT TRIM(`photo`.`original_pic`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_ph, 
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
                            (SELECT TRIM(`photo`.`ver1`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_pv1, 
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
                            (SELECT TRIM(`photo`.`ver2`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_pv2, 
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
                            (SELECT TRIM(`photo`.`ver3`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_pv3, 
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
                            (SELECT TRIM(`photo`.`ver4`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_pv4, 
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
                            (SELECT TRIM(`photo`.`ver5`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_pv5, 
                        GROUP_CONCAT(t2.`pcrp_id` SEPARATOR "♥☻♥") AS pcrp_id,
                        GROUP_CONCAT(t2.`pcrp_uid` SEPARATOR "♥☻♥") AS pcrp_uid,
                        GROUP_CONCAT(t2.`pcrp_time` SEPARATOR "♥☻♥") AS pcrp_time,
                        GROUP_CONCAT(t2.`pcrp_preid` SEPARATOR "♥☻♥") AS pcrp_preid,
                        GROUP_CONCAT(t2.`pcrp_pref` SEPARATOR "♥☻♥") AS pcrp_pref,
                        GROUP_CONCAT(t2.`pcrp_uname` SEPARATOR "♥☻♥") AS pcrp_uname,
                        GROUP_CONCAT(t3.`lk_rep_id` SEPARATOR "♥☻♥") AS lk_rep_id,
                        GROUP_CONCAT(t3.`lk_woer_id` SEPARATOR "♥☻♥") AS lk_woer_id,
                        GROUP_CONCAT(t3.`lk_wotime` SEPARATOR "♥☻♥") AS lk_wotime,
                        GROUP_CONCAT(t3.`lk_woer_name` SEPARATOR "♥☻♥") AS lk_woer_name,
                        GROUP_CONCAT(t3.`lk_rep_ct` SEPARATOR "♥☻♥") AS lk_rep_ct,
                        GROUP_CONCAT(up.`woererid` SEPARATOR "♥☻♥") AS woererid,
                        GROUP_CONCAT(up.`woername` SEPARATOR "♥☻♥") AS woername,
                        GROUP_CONCAT(up.`woeremail` SEPARATOR "♥☻♥") AS woeremail,
                        GROUP_CONCAT(up.`woercell` SEPARATOR "♥☻♥") AS woercell,
                        GROUP_CONCAT(up.`woerpic` SEPARATOR "♥☻♥") AS woerpic
                    FROM `lead_quotations_wo` 						AS t1
                    /*Lead Quotations Wo User*/
                    INNER JOIN (
                        SELECT 
                            ad.`id` AS woererid,
                            ad.`user_name` AS woername,
                            ad.`email` AS woeremail,
                            ad.`cell_number` AS woercell,
                            CASE WHEN ad.`icon` IS NULL OR ad.`icon`  = "" OR ph1.`ver3` IS NULL OR ph1.`ver3` = ""
                            THEN "' . $this->config["DEFAULT_USER_ICON_IMG"] . '"
                            ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver3`)
                            END AS woerpic
                        FROM `user_profile` AS ad
                        LEFT JOIN `photo` AS ph1 ON ad.`icon` = ph1.`id`
                        WHERE ad.`status_id` = 4
                    )AS up ON up.`woererid` = t1.`user_id`
                    /*Lead Quotations Wo Preferences*/
                    LEFT JOIN (
                        SELECT
                            GROUP_CONCAT(t1.`id` SEPARATOR "♥♥") AS pcrp_id, 
                            t1.`lead_quotations_wo_id`, 
                            GROUP_CONCAT(t1.`user_id` SEPARATOR "♥♥") AS pcrp_uid, 
                            GROUP_CONCAT(t1.`created_at` SEPARATOR "♥♥") AS pcrp_time, 
                            GROUP_CONCAT(t2.`id` SEPARATOR "♥♥") AS pcrp_preid, 
                            GROUP_CONCAT(t2.`preferences` SEPARATOR "♥♥") AS pcrp_pref, 
                            GROUP_CONCAT(up.`user_name` SEPARATOR "♥♥") AS pcrp_uname
                        FROM `lead_quotations_wo_preferences` 	AS t1
                        LEFT JOIN `preferences`					AS t2 ON t2.`id` = t1.`preferences_id`
                        LEFT JOIN `user_profile`				AS up ON up.`id` = t1.`user_id`
                        WHERE t1.`status_id` = 4
                        AND t2.`status_id` = 4
                        AND up.`status_id` = 4
                        GROUP BY(t1.`lead_quotations_wo_id`)
                        ORDER BY(t1.`lead_quotations_wo_id`)
                    ) AS t2 ON t2.`lead_quotations_wo_id` = t1.`id`
                    /*Lead Quotations Wo Approvals*/
                    LEFT JOIN (
                            SELECT
                                GROUP_CONCAT(t1.`id` SEPARATOR "♥♥") AS lk_rep_id, 
                                COUNT(t1.`id`) AS lk_rep_ct,
                                t1.`lead_quotations_wo_id`, 
                                GROUP_CONCAT(t1.`user_id` SEPARATOR "♥♥") AS lk_woer_id, 
                                GROUP_CONCAT(t1.`created_at` SEPARATOR "♥♥") AS lk_wotime, 
                                GROUP_CONCAT(up.`user_name` SEPARATOR "♥♥") AS lk_woer_name
                        FROM `lead_quotations_wo_approvals` AS t1
                       LEFT JOIN `user_profile` 		AS up ON up.`id` = t1.`user_id`
                       WHERE t1.`status_id` = 36
                       AND up.`status_id` = 4
                       GROUP BY(t1.`lead_quotations_wo_id`)
                       ORDER BY(t1.`lead_quotations_wo_id`)
                    ) AS t3 ON t3.`lead_quotations_wo_id` = t1.`id`
                    WHERE t1.`status_id` = 4
                    GROUP BY(t1.`lead_quotations_id`)
                    ORDER BY(t1.`lead_quotations_id`)
                ) AS t4 ON t4.`pcr_pc_id` = t1.`id`
                WHERE t1.`status_id` = 4
                GROUP BY(t1.`lead_id`)
                ORDER BY(t1.`lead_id`)
                ) AS t6 ON t6.`lead_id` = t1.`id`
                /*Lead Languages*/
                LEFT JOIN (
                        SELECT
                                GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS plng_id, t1.`lead_id`, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS plng_time,
                                GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS plng_lngid, GROUP_CONCAT(t2.`Language Name` SEPARATOR "♥☻☻♥") AS plng_lngname
                        FROM `lead_languages` 	AS t1
                        LEFT JOIN `nookleads_languages`	AS t2 ON t2.`id` = t1.`languages_id`
                        WHERE t1.`status_id` = 4
                        AND t2.`status_id` = 4
                        OR t2.`id` IN ('.$languages.')
                        GROUP BY(t1.`lead_id`)
                        ORDER BY(t1.`lead_id`)
                ) AS t7 ON t7.`lead_id` = t1.`id`
                /*Lead Sections*/
                LEFT JOIN (
                        /*
                        SELECT
                                GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS ps_id, t1.`lead_id`, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS ps_time,
                                GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS ps_secid, GROUP_CONCAT(TRIM(t2.`section_name`) SEPARATOR "♥☻☻♥") AS pr_secname
                        FROM `lead_section` 	AS t1
                        LEFT JOIN `sections_index_lead`	AS t2 ON t2.`id` = t1.`section_id`
                        WHERE t1.`status_id` = 4
                        AND t2.`status_id` = 4
                        GROUP BY(t1.`lead_id`)
                        ORDER BY(t1.`lead_id`) DESC
                        */
                        SELECT
                            t1.`id` AS ps_id, 
                            t1.`lead_id`,
                            t1.`created_at` AS ps_time,
                            t2.`id` AS ps_secid,
                            TRIM(t2.`section_name`) AS pr_secname
                        FROM `lead_section` 	AS t1
                        LEFT JOIN `sections_index_lead`	AS t2 ON t2.`id` = t1.`section_id`
                        WHERE t1.`status_id` = 4
                        AND t2.`status_id` = 4
                        OR t2.`id` IN ('.$sections.')
                ) AS t8 ON t8.`lead_id` = t1.`id`
                /*Lead Photo*/
                LEFT JOIN (
                    SELECT
                        `id` AS p_phid,
                        IF((`original_pic` IS NULL OR `original_pic` = NULL OR `original_pic` = ""),"' . $this->config["DEFAULT_POST_IMG"] . '",TRIM(`original_pic`)) AS p_ph,
                        IF((`ver1` IS NULL OR `ver1` = NULL OR `ver1` = ""),"' . $this->config["DEFAULT_POST_IMG"] . '",TRIM(`ver1`)) AS p_pv1,
                        IF((`ver2` IS NULL OR `ver2` = NULL OR `ver2` = ""),"' . $this->config["DEFAULT_POST_IMG"] . '",TRIM(`ver2`)) AS p_pv2,
                        IF((`ver3` IS NULL OR `ver3` = NULL OR `ver3` = ""),"' . $this->config["DEFAULT_POST_IMG"] . '",TRIM(`ver3`)) AS p_pv3,
                        IF((`ver4` IS NULL OR `ver4` = NULL OR `ver4` = ""),"' . $this->config["DEFAULT_POST_IMG"] . '",TRIM(`ver4`)) AS p_pv4,
                        IF((`ver5` IS NULL OR `ver5` = NULL OR `ver5` = ""),"' . $this->config["DEFAULT_POST_IMG"] . '",TRIM(`ver5`)) AS p_pv5
                    FROM `photo`
                    WHERE `status_id` = 4
                ) AS t9 ON t9.`p_phid` = t1.`photo_id`
                /* Lead Business */
                LEFT JOIN (
                    SELECT
                        t1.`id` AS chwaid,
                        t1.`business_id` AS chwacid,
                        t1.`user_id` AS chwauid,
                        t1.`lead_id` AS chwalead_id,
                        t1.`created_at` AS chwatime,
                        t2.`business_name`,
                        t2.`business_description`,
                        t2.`business_location`,
                        t2.`business_language`,
                        t2.`business_icon`,
                        t2.`business_background`,
                        t2.`business_created_at`,
                        t2.`business_updated_at`,
                        t2.`business_website`
                    FROM `business_deal` AS t1
                    LEFT JOIN `business`	AS t2 ON t2.`id` = t1.`business_id`
                    LEFT JOIN `user_profile` AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 4
                    AND t2.`status_id` = 4
                    AND up.`status_id` = 4
                ) AS t10 ON t10.`chwalead_id` = t1.`id`
                WHERE t1.`status_id` = 4 
                AND (
                    t1.`id` IN (SELECT `lead_id` FROM `lead_countries` WHERE `country_id` IN ('.$countries.') AND `status_id` = 4)
                    OR
                    t1.`id` IN (SELECT `lead_id` FROM `lead_languages` WHERE `languages_id` IN ('.$languages.') AND `status_id` = 4)
                    OR
                    t1.`id` IN (SELECT `lead_id` FROM `lead_section` WHERE `section_id` IN ('.$sections.') AND `status_id` = 4)
                )
                ORDER BY(t1.`id`) DESC
                /*Lead Ends*/');
        $res = $stm->execute();
        //echo $stm->queryString;
        return $this->buildListLeadArray($res, $stm);
    }
    public function listDealLead() {
        $_SESSION["ListNewLead"] = NULL;
        $stm = $this->db->prepare('/*Lead Start*/
                SELECT
                    /*COUNT(t1.`id`) AS lead_ct,*/
                    t1.*,
                    t1.`id`,
                    TRIM(t1.`title`) AS title,
                    t1.`photo_id`,
                    t1.`section_id`,
                    t1.`user_id`,
                    t1.`created_at`,
                    IF((t1.`photo_id` IS NULL OR t1.`photo_id` = NULL OR t1.`photo_id` = "" OR t1.`photo_id` = 0), NULL , t1.`photo_id`) AS p_pic_flag,
                    t2.*,
                    t3.*,
                    t4.*,
                    t5.*,
                    t6.*,
                    t7.*,
                    t8.*,
                    t9.*,
                    t10.*,
                    up.`leaderpic`,
                    up.`leaderid`,
                    up.`leadername`,
                    up.`leaderemail`,
                    up.`leadercell`
                FROM `lead` AS t1
                /*Lead Countries*/
                LEFT JOIN (
                    SELECT
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS pcont_id, t1.`lead_id`, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS pcont_time,
                        GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS pcont_contid, GROUP_CONCAT(t2.`Country` SEPARATOR "♥☻☻♥") AS pcont_contname
                    FROM `lead_countries` 	AS t1
                    LEFT JOIN `nookleads_countries`	AS t2 ON t2.`id` = t1.`country_id`
                    WHERE t1.`status_id` = 4
                    AND t2.`status_id` = 4
                    GROUP BY(t1.`lead_id`)
                    ORDER BY(t1.`lead_id`)
                ) AS t2 ON t2.`lead_id` = t1.`id`
                /*Lead User*/
                INNER JOIN (
                    SELECT 
                        ad.`id` AS leaderid,
                        ad.`user_name` AS leadername,
                        ad.`email` AS leaderemail,
                        ad.`cell_number` AS leadercell,
                        CASE WHEN ad.`icon` IS NULL OR ad.`icon`  = "" OR ph1.`ver3` IS NULL OR ph1.`ver3` = ""
                        THEN "' . $this->config["DEFAULT_USER_ICON_IMG"] . '"
                        ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver3`)
                        END AS leaderpic
                    FROM `user_profile` AS ad
                    LEFT JOIN `photo` AS ph1 ON ad.`icon` = ph1.`id` 
                    WHERE ad.`status_id` = 4
                ) AS up ON up.`leaderid` = t1.`user_id` 
                /*Lead Report*/
                LEFT JOIN (
                    SELECT
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS pr_id, t1.`lead_id`, GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS pr_uid, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS pr_time,
                        GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS pr_repid, GROUP_CONCAT(t2.`report_name`  SEPARATOR "♥☻☻♥") AS pr_repname,
                        GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻☻♥") AS pr_uname
                    FROM `lead_report` 			AS t1
                    LEFT JOIN `report`			AS t2 ON t2.`id` = t1.`report_id`
                    LEFT JOIN `user_profile`	AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 4
                    AND t2.`status_id` = 4
                    AND up.`status_id` = 4
                    GROUP BY(t1.`lead_id`)
                    ORDER BY(t1.`lead_id`)
                ) AS t3 ON t3.`lead_id` = t1.`id`
                /*Lead Preferences*/
                LEFT JOIN (
                    SELECT
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS pp_id, t1.`lead_id`, GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS pp_uid, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS pp_time,
                        GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS pp_preid, GROUP_CONCAT(t2.`preferences` SEPARATOR "♥☻☻♥") AS pp_pref,
                        GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻☻♥") AS pp_uname
                    FROM `lead_preferences` 	AS t1
                    LEFT JOIN `preferences`		AS t2 ON t2.`id` = t1.`preferences_id`
                    LEFT JOIN `user_profile`	AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 4
                    AND t2.`status_id` = 4
                    AND up.`status_id` = 4
                    GROUP BY(t1.`lead_id`)
                    ORDER BY(t1.`lead_id`)
                ) AS t4 ON t4.`lead_id` = t1.`id`
                /*Lead Approvals*/
                LEFT JOIN (
                    SELECT 
                        COUNT(t1.`id`) AS lk_p_ct,
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS lk_p_id, t1.`lead_id`, GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS lk_p_uid, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS lk_p_time,
                        GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻☻♥") AS lk_p_uname
                    FROM `lead_approvals` 			AS t1
                    LEFT JOIN `user_profile` 	AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 36
                    AND up.`status_id` = 4
                    GROUP BY(t1.`lead_id`)
                    ORDER BY(t1.`lead_id`)
                ) AS t5 ON t5.`lead_id` = t1.`id`
                /*Lead Quotations*/
                LEFT JOIN (
                SELECT
                    t1.`lead_id`,
                    COUNT(t1.`id`) AS pc_ct,
                    GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS pc_id, 
                    GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS pc_uid, 
                    GROUP_CONCAT(t1.`quotation` SEPARATOR "♥☻☻♥") AS quotations, 
                    GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS pc_time,
                    GROUP_CONCAT(IF((t1.`photo_id` IS NULL OR t1.`photo_id` = NULL OR t1.`photo_id` = "" OR t1.`photo_id` = 0), "" , t1.`photo_id`) SEPARATOR "♥☻☻♥") AS pc_pic_flag,
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_phid, 
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
			(SELECT TRIM(`photo`.`original_pic`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_ph, 
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
			(SELECT TRIM(`photo`.`ver1`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_pv1, 
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
			(SELECT TRIM(`photo`.`ver2`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_pv2, 
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
			(SELECT TRIM(`photo`.`ver3`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_pv3, 
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
			(SELECT TRIM(`photo`.`ver4`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_pv4, 
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
			(SELECT TRIM(`photo`.`ver5`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_pv5, 
                    GROUP_CONCAT(t2.`pcp_id` SEPARATOR "♥☻☻♥") AS pcp_id, 
                    GROUP_CONCAT(t2.`pcp_uid` SEPARATOR "♥☻☻♥") AS pcp_uid, 
                    GROUP_CONCAT(t2.`pcp_time` SEPARATOR "♥☻☻♥") AS pcp_time, 
                    GROUP_CONCAT(t2.`pcp_preid` SEPARATOR "♥☻☻♥") AS pcp_preid, 
                    GROUP_CONCAT(t2.`pcp_pref` SEPARATOR "♥☻☻♥") AS pcp_pref, 
                    GROUP_CONCAT(t2.`pcp_uname` SEPARATOR "♥☻☻♥") AS pcp_uname, 
                    GROUP_CONCAT(t3.`lk_pc_id` SEPARATOR "♥☻☻♥") AS lk_pc_id, 
                    GROUP_CONCAT(t3.`lk_pc_uid` SEPARATOR "♥☻☻♥") AS lk_pc_uid, 
                    GROUP_CONCAT(t3.`lk_pc_time` SEPARATOR "♥☻☻♥") AS lk_pc_time, 
                    GROUP_CONCAT(t3.`lk_pc_uname` SEPARATOR "♥☻☻♥") AS lk_pc_uname, 
                    GROUP_CONCAT(t3.`lk_pc_ct` SEPARATOR "♥☻☻♥") AS lk_pc_ct,
                    GROUP_CONCAT(t4.`pcr_id` SEPARATOR "♥☻☻♥") AS pcr_id, 
                    GROUP_CONCAT(t4.`pcr_uid` SEPARATOR "♥☻☻♥") AS pcr_uid, 
                    GROUP_CONCAT(t4.`wo` SEPARATOR "♥☻☻♥") AS wo, 
                    GROUP_CONCAT(t4.`pcr_time` SEPARATOR "♥☻☻♥") AS pcr_time,  
                    GROUP_CONCAT(t4.`pcr_ct` SEPARATOR "♥☻☻♥") AS pcr_ct, 
                    GROUP_CONCAT(t4.`pcrp_id` SEPARATOR "♥☻☻♥") AS pcrp_id, 
                    GROUP_CONCAT(t4.`pcrp_uid` SEPARATOR "♥☻☻♥") AS pcrp_uid, 
                    GROUP_CONCAT(t4.`pcrp_time` SEPARATOR "♥☻☻♥") AS pcrp_time, 
                    GROUP_CONCAT(t4.`pcr_pic_flag` SEPARATOR "♥☻☻♥") AS pcr_pic_flag, 
                    GROUP_CONCAT(t4.`pcrp_preid` SEPARATOR "♥☻☻♥") AS pcrp_preid,  
                    GROUP_CONCAT(t4.`pcrp_pref` SEPARATOR "♥☻☻♥") AS pcrp_pref,  
                    GROUP_CONCAT(t4.`pcrp_uname` SEPARATOR "♥☻☻♥") AS pcrp_uname, 
                    GROUP_CONCAT(t4.`lk_rep_ct` SEPARATOR "♥☻☻♥") AS lk_rep_ct, 
                    GROUP_CONCAT(t4.`lk_rep_id` SEPARATOR "♥☻☻♥") AS lk_rep_id, 
                    GROUP_CONCAT(t4.`lk_woer_id` SEPARATOR "♥☻☻♥") AS lk_woer_id, 
                    GROUP_CONCAT(t4.`lk_wotime` SEPARATOR "♥☻☻♥") AS lk_wotime, 
                    GROUP_CONCAT(t4.`lk_woer_name` SEPARATOR "♥☻☻♥") AS lk_woer_name, 
                    GROUP_CONCAT(t4.`pcr_phid` SEPARATOR "♥☻☻♥") AS pcr_phid, 
                    GROUP_CONCAT(t4.`pcr_ph` SEPARATOR "♥☻☻♥") AS pcr_ph, 
                    GROUP_CONCAT(t4.`pcr_pv1` SEPARATOR "♥☻☻♥") AS pcr_pv1, 
                    GROUP_CONCAT(t4.`pcr_pv2` SEPARATOR "♥☻☻♥") AS pcr_pv2, 
                    GROUP_CONCAT(t4.`pcr_pv3` SEPARATOR "♥☻☻♥") AS pcr_pv3,  
                    GROUP_CONCAT(t4.`pcr_pv4` SEPARATOR "♥☻☻♥") AS pcr_pv4,  
                    GROUP_CONCAT(t4.`pcr_pv5` SEPARATOR "♥☻☻♥") AS pcr_pv5, 
                    GROUP_CONCAT(t4.`woererid` SEPARATOR "♥☻☻♥") AS woererid,
                    GROUP_CONCAT(t4.`woername` SEPARATOR "♥☻☻♥") AS woername,
                    GROUP_CONCAT(t4.`woeremail` SEPARATOR "♥☻☻♥") AS woeremail,
                    GROUP_CONCAT(t4.`woercell` SEPARATOR "♥☻☻♥") AS woercell,
                    GROUP_CONCAT(t4.`woerpic` SEPARATOR "♥☻☻♥") AS woerpic,
                    GROUP_CONCAT(up.`quotationererid` SEPARATOR "♥☻☻♥") AS  quotationererid,
                    GROUP_CONCAT(up.`quotationername` SEPARATOR "♥☻☻♥") AS  quotationername,
                    GROUP_CONCAT(up.`quotationeremail` SEPARATOR "♥☻☻♥") AS  quotationeremail,
                    GROUP_CONCAT(up.`quotationercell` SEPARATOR "♥☻☻♥") AS  quotationercell,
                    GROUP_CONCAT(up.`quotationerpic` SEPARATOR "♥☻☻♥") AS  quotationerpic
                FROM `lead_quotations` 					AS t1
                /*Lead Quotations User*/
                INNER JOIN (
                    SELECT 
                        ad.`id` AS quotationererid,
                        ad.`user_name` AS quotationername,
                        ad.`email` AS quotationeremail,
                        ad.`cell_number` AS quotationercell,
                        CASE WHEN ad.`icon` IS NULL OR ad.`icon`  = "" OR ph1.`ver3` IS NULL OR ph1.`ver3` = ""
                        THEN "' . $this->config["DEFAULT_USER_ICON_IMG"] . '"
                        ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver3`)
                        END AS quotationerpic
                    FROM `user_profile` AS ad
                    LEFT JOIN `photo` AS ph1 ON ad.`icon` = ph1.`id`
                    WHERE ad.`status_id` = 4
                    AND ad.`status_id` = 4
                ) AS up ON up.`quotationererid` = t1.`user_id`
                /*Lead Quotations Preferences*/
                LEFT JOIN (
                    SELECT
                            GROUP_CONCAT(t1.`id` SEPARATOR "♥☻♥") AS pcp_id,
                            t1.`lead_quotations_id`,
                            GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻♥") AS pcp_uid,
                            GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻♥") AS pcp_time,
                            GROUP_CONCAT(t2.`id` SEPARATOR "♥☻♥") AS pcp_preid,
                            GROUP_CONCAT(t2.`preferences` SEPARATOR "♥☻♥") AS pcp_pref,
                            GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻♥") AS pcp_uname
                    FROM `lead_quotations_preferences` 	AS t1
                    LEFT JOIN `preferences`				AS t2 ON t2.`id` = t1.`preferences_id`
                    LEFT JOIN `user_profile`			AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 4
                    AND t2.`status_id` = 4
                    AND up.`status_id` = 4
                    GROUP BY(t1.`lead_quotations_id`)
                    ORDER BY(t1.`lead_quotations_id`)
                )AS t2 ON t2.`lead_quotations_id` = t1.`id`
                /*Lead Quotations Approvals*/
                LEFT JOIN (
                    SELECT
                        COUNT(t1.`id`) AS lk_pc_ct,
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻♥") AS lk_pc_id, 
                        GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻♥") AS pc_time,
                        t1.`lead_quotations_id`, 
                        GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻♥") AS lk_pc_uid, 
                        GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻♥") AS lk_pc_time,
                        GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻♥") AS lk_pc_uname
                    FROM `lead_quotations_approvals` 	AS t1
                    LEFT JOIN `user_profile` 	AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 36
                    AND up.`status_id` = 4
                    GROUP BY(t1.`lead_quotations_id`)
                    ORDER BY(t1.`lead_quotations_id`)
                ) AS t3 ON t3.`lead_quotations_id` = t1.`id`
                /*Lead Quotations Wo*/
                LEFT JOIN (
                    SELECT
                        COUNT(t1.`id`) AS pcr_ct,
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻♥") AS pcr_id, 
                        t1.`lead_quotations_id` AS pcr_pc_id, 
                        GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻♥") AS pcr_uid, 
                        GROUP_CONCAT(t1.`wo` SEPARATOR "♥☻♥") AS wo, 
                        GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻♥") AS pcr_time,
                        GROUP_CONCAT(
                            IF((t1.`photo_id` IS NULL OR t1.`photo_id` = NULL OR t1.`photo_id` = "" OR t1.`photo_id` = 0), "" , t1.`photo_id`) 
                             SEPARATOR "♥☻♥"
                        ) AS pcr_pic_flag,
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_phid, 
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
                            (SELECT TRIM(`photo`.`original_pic`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_ph, 
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
                            (SELECT TRIM(`photo`.`ver1`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_pv1, 
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
                            (SELECT TRIM(`photo`.`ver2`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_pv2, 
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
                            (SELECT TRIM(`photo`.`ver3`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_pv3, 
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
                            (SELECT TRIM(`photo`.`ver4`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_pv4, 
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
                            (SELECT TRIM(`photo`.`ver5`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_pv5, 
                        GROUP_CONCAT(t2.`pcrp_id` SEPARATOR "♥☻♥") AS pcrp_id,
                        GROUP_CONCAT(t2.`pcrp_uid` SEPARATOR "♥☻♥") AS pcrp_uid,
                        GROUP_CONCAT(t2.`pcrp_time` SEPARATOR "♥☻♥") AS pcrp_time,
                        GROUP_CONCAT(t2.`pcrp_preid` SEPARATOR "♥☻♥") AS pcrp_preid,
                        GROUP_CONCAT(t2.`pcrp_pref` SEPARATOR "♥☻♥") AS pcrp_pref,
                        GROUP_CONCAT(t2.`pcrp_uname` SEPARATOR "♥☻♥") AS pcrp_uname,
                        GROUP_CONCAT(t3.`lk_rep_id` SEPARATOR "♥☻♥") AS lk_rep_id,
                        GROUP_CONCAT(t3.`lk_woer_id` SEPARATOR "♥☻♥") AS lk_woer_id,
                        GROUP_CONCAT(t3.`lk_wotime` SEPARATOR "♥☻♥") AS lk_wotime,
                        GROUP_CONCAT(t3.`lk_woer_name` SEPARATOR "♥☻♥") AS lk_woer_name,
                        GROUP_CONCAT(t3.`lk_rep_ct` SEPARATOR "♥☻♥") AS lk_rep_ct,
                        GROUP_CONCAT(up.`woererid` SEPARATOR "♥☻♥") AS woererid,
                        GROUP_CONCAT(up.`woername` SEPARATOR "♥☻♥") AS woername,
                        GROUP_CONCAT(up.`woeremail` SEPARATOR "♥☻♥") AS woeremail,
                        GROUP_CONCAT(up.`woercell` SEPARATOR "♥☻♥") AS woercell,
                        GROUP_CONCAT(up.`woerpic` SEPARATOR "♥☻♥") AS woerpic
                    FROM `lead_quotations_wo` 						AS t1
                    /*Lead Quotations Wo User*/
                    INNER JOIN (
                        SELECT 
                            ad.`id` AS woererid,
                            ad.`user_name` AS woername,
                            ad.`email` AS woeremail,
                            ad.`cell_number` AS woercell,
                            CASE WHEN ad.`icon` IS NULL OR ad.`icon`  = "" OR ph1.`ver3` IS NULL OR ph1.`ver3` = ""
                            THEN "' . $this->config["DEFAULT_USER_ICON_IMG"] . '"
                            ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver3`)
                            END AS woerpic
                        FROM `user_profile` AS ad
                        LEFT JOIN `photo` AS ph1 ON ad.`icon` = ph1.`id`
                        WHERE ad.`status_id` = 4
                    )AS up ON up.`woererid` = t1.`user_id`
                    /*Lead Quotations Wo Preferences*/
                    LEFT JOIN (
                        SELECT
                            GROUP_CONCAT(t1.`id` SEPARATOR "♥♥") AS pcrp_id, 
                            t1.`lead_quotations_wo_id`, 
                            GROUP_CONCAT(t1.`user_id` SEPARATOR "♥♥") AS pcrp_uid, 
                            GROUP_CONCAT(t1.`created_at` SEPARATOR "♥♥") AS pcrp_time, 
                            GROUP_CONCAT(t2.`id` SEPARATOR "♥♥") AS pcrp_preid, 
                            GROUP_CONCAT(t2.`preferences` SEPARATOR "♥♥") AS pcrp_pref, 
                            GROUP_CONCAT(up.`user_name` SEPARATOR "♥♥") AS pcrp_uname
                        FROM `lead_quotations_wo_preferences` 	AS t1
                        LEFT JOIN `preferences`					AS t2 ON t2.`id` = t1.`preferences_id`
                        LEFT JOIN `user_profile`				AS up ON up.`id` = t1.`user_id`
                        WHERE t1.`status_id` = 4
                        AND t2.`status_id` = 4
                        AND up.`status_id` = 4
                        GROUP BY(t1.`lead_quotations_wo_id`)
                        ORDER BY(t1.`lead_quotations_wo_id`)
                    ) AS t2 ON t2.`lead_quotations_wo_id` = t1.`id`
                    /*Lead Quotations Wo Approvals*/
                    LEFT JOIN (
                            SELECT
                                GROUP_CONCAT(t1.`id` SEPARATOR "♥♥") AS lk_rep_id, 
                                COUNT(t1.`id`) AS lk_rep_ct,
                                t1.`lead_quotations_wo_id`, 
                                GROUP_CONCAT(t1.`user_id` SEPARATOR "♥♥") AS lk_woer_id, 
                                GROUP_CONCAT(t1.`created_at` SEPARATOR "♥♥") AS lk_wotime, 
                                GROUP_CONCAT(up.`user_name` SEPARATOR "♥♥") AS lk_woer_name
                        FROM `lead_quotations_wo_approvals` AS t1
                       LEFT JOIN `user_profile` 		AS up ON up.`id` = t1.`user_id`
                       WHERE t1.`status_id` = 36
                       AND up.`status_id` = 4
                       GROUP BY(t1.`lead_quotations_wo_id`)
                       ORDER BY(t1.`lead_quotations_wo_id`)
                    ) AS t3 ON t3.`lead_quotations_wo_id` = t1.`id`
                    WHERE t1.`status_id` = 4
                    GROUP BY(t1.`lead_quotations_id`)
                    ORDER BY(t1.`lead_quotations_id`)
                ) AS t4 ON t4.`pcr_pc_id` = t1.`id`
                WHERE t1.`status_id` = 4
                GROUP BY(t1.`lead_id`)
                ORDER BY(t1.`lead_id`)
                ) AS t6 ON t6.`lead_id` = t1.`id`
                /*Lead Languages*/
                LEFT JOIN (
                        SELECT
                                GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS plng_id, t1.`lead_id`, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS plng_time,
                                GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS plng_lngid, GROUP_CONCAT(t2.`Language Name` SEPARATOR "♥☻☻♥") AS plng_lngname
                        FROM `lead_languages` 	AS t1
                        LEFT JOIN `nookleads_languages`	AS t2 ON t2.`id` = t1.`languages_id`
                        WHERE t1.`status_id` = 4
                        AND t2.`status_id` = 4
                        GROUP BY(t1.`lead_id`)
                        ORDER BY(t1.`lead_id`)
                ) AS t7 ON t7.`lead_id` = t1.`id`
                /*Lead Sections*/
                LEFT JOIN (
                        /*
                        SELECT
                                GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS ps_id, t1.`lead_id`, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS ps_time,
                                GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS ps_secid, GROUP_CONCAT(TRIM(t2.`section_name`) SEPARATOR "♥☻☻♥") AS pr_secname
                        FROM `lead_section` 	AS t1
                        LEFT JOIN `sections_index_lead`	AS t2 ON t2.`id` = t1.`section_id`
                        WHERE t1.`status_id` = 4
                        AND t2.`status_id` = 4
                        GROUP BY(t1.`lead_id`)
                        ORDER BY(t1.`lead_id`) DESC
                        */
                        SELECT
                            t1.`id` AS ps_id, 
                            t1.`lead_id`,
                            t1.`created_at` AS ps_time,
                            t2.`id` AS ps_secid,
                            TRIM(t2.`section_name`) AS pr_secname
                        FROM `lead_section` 	AS t1
                        LEFT JOIN `sections_index_lead`	AS t2 ON t2.`id` = t1.`section_id`
                        WHERE t1.`status_id` = 4
                        AND t2.`status_id` = 4
                ) AS t8 ON t8.`lead_id` = t1.`id`
                /*Lead Photo*/
                LEFT JOIN (
                    SELECT
                        `id` AS p_phid,
                        IF((`original_pic` IS NULL OR `original_pic` = NULL OR `original_pic` = ""),"' . $this->config["DEFAULT_POST_IMG"] . '",TRIM(`original_pic`)) AS p_ph,
                        IF((`ver1` IS NULL OR `ver1` = NULL OR `ver1` = ""),"' . $this->config["DEFAULT_POST_IMG"] . '",TRIM(`ver1`)) AS p_pv1,
                        IF((`ver2` IS NULL OR `ver2` = NULL OR `ver2` = ""),"' . $this->config["DEFAULT_POST_IMG"] . '",TRIM(`ver2`)) AS p_pv2,
                        IF((`ver3` IS NULL OR `ver3` = NULL OR `ver3` = ""),"' . $this->config["DEFAULT_POST_IMG"] . '",TRIM(`ver3`)) AS p_pv3,
                        IF((`ver4` IS NULL OR `ver4` = NULL OR `ver4` = ""),"' . $this->config["DEFAULT_POST_IMG"] . '",TRIM(`ver4`)) AS p_pv4,
                        IF((`ver5` IS NULL OR `ver5` = NULL OR `ver5` = ""),"' . $this->config["DEFAULT_POST_IMG"] . '",TRIM(`ver5`)) AS p_pv5
                    FROM `photo`
                    WHERE `status_id` = 4
                ) AS t9 ON t9.`p_phid` = t1.`photo_id`
                /* Lead Business */
                LEFT JOIN (
                    SELECT
                        t1.`id` AS chwaid,
                        t1.`business_id` AS chwacid,
                        t1.`user_id` AS chwauid,
                        t1.`lead_id` AS chwalead_id,
                        t1.`created_at` AS chwatime,
                        t2.`business_name`,
                        t2.`business_description`,
                        t2.`business_location`,
                        t2.`business_language`,
                        t2.`business_icon`,
                        t2.`business_background`,
                        t2.`business_created_at`,
                        t2.`business_updated_at`,
                        t2.`business_website`
                    FROM `business_deal` AS t1
                    LEFT JOIN `business`	AS t2 ON t2.`id` = t1.`business_id`
                    LEFT JOIN `user_profile` AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 4
                    AND t2.`status_id` = 4
                    AND up.`status_id` = 4
                ) AS t10 ON t10.`chwalead_id` = t1.`id`
                WHERE t1.`status_id` = 4
                ORDER BY(t1.`id`) DESC
                /*Lead Ends*/');
        $res = $stm->execute();
        return $this->buildListLeadArray($res, $stm);
    }
    public function Popular() {
        $_SESSION["ListNewLead"] = NULL;
        $stm = $this->db->prepare('/*Lead Start*/
                SELECT
                    /*COUNT(t1.`id`) AS lead_ct,*/
                    t1.*,
                    t1.`id`,
                    t1.`title`,
                    t1.`photo_id`,
                    t1.`section_id`,
                    t1.`user_id`,
                    t1.`created_at`,
                    IF((t1.`photo_id` IS NULL OR t1.`photo_id` = NULL OR t1.`photo_id` = "" OR t1.`photo_id` = 0), NULL , t1.`photo_id`) AS p_pic_flag,
                    t2.*,
                    t3.*,
                    t4.*,
                    t5.*,
                    t6.*,
                    t7.*,
                    t8.*,
                    t9.*,
                    t10.*,
                    up.`leaderpic`,
                    up.`leaderid`,
                    up.`leadername`,
                    up.`leaderemail`,
                    up.`leadercell`
                FROM `lead` AS t1
                /*Lead Countries*/
                LEFT JOIN (
                    SELECT
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS pcont_id, t1.`lead_id`, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS pcont_time,
                        GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS pcont_contid, GROUP_CONCAT(t2.`Country` SEPARATOR "♥☻☻♥") AS pcont_contname
                    FROM `lead_countries` 	AS t1
                    LEFT JOIN `nookleads_countries`	AS t2 ON t2.`id` = t1.`country_id`
                    WHERE t1.`status_id` = 4
                    AND t2.`status_id` = 4
                    GROUP BY(t1.`lead_id`)
                    ORDER BY(t1.`lead_id`)
                ) AS t2 ON t2.`lead_id` = t1.`id`
                /*Lead User*/
                INNER JOIN (
                    SELECT 
                        ad.`id` AS leaderid,
                        ad.`user_name` AS leadername,
                        ad.`email` AS leaderemail,
                        ad.`cell_number` AS leadercell,
                        CASE WHEN ad.`icon` IS NULL OR ad.`icon`  = "" OR ph1.`ver3` IS NULL OR ph1.`ver3` = ""
                        THEN "' . $this->config["DEFAULT_USER_ICON_IMG"] . '"
                        ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver3`)
                        END AS leaderpic
                    FROM `user_profile` AS ad
                    LEFT JOIN `photo` AS ph1 ON ad.`icon` = ph1.`id` 
                    WHERE ad.`status_id` = 4
                ) AS up ON up.`leaderid` = t1.`user_id` 
                /*Lead Report*/
                LEFT JOIN (
                    SELECT
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS pr_id, t1.`lead_id`, GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS pr_uid, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS pr_time,
                        GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS pr_repid, GROUP_CONCAT(t2.`report_name`  SEPARATOR "♥☻☻♥") AS pr_repname,
                        GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻☻♥") AS pr_uname
                    FROM `lead_report` 			AS t1
                    LEFT JOIN `report`			AS t2 ON t2.`id` = t1.`report_id`
                    LEFT JOIN `user_profile`	AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 4
                    AND t2.`status_id` = 4
                    AND up.`status_id` = 4
                    GROUP BY(t1.`lead_id`)
                    ORDER BY(t1.`lead_id`)
                ) AS t3 ON t3.`lead_id` = t1.`id`
                /*Lead Preferences*/
                LEFT JOIN (
                    SELECT
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS pp_id, t1.`lead_id`, GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS pp_uid, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS pp_time,
                        GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS pp_preid, GROUP_CONCAT(t2.`preferences` SEPARATOR "♥☻☻♥") AS pp_pref,
                        GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻☻♥") AS pp_uname
                    FROM `lead_preferences` 	AS t1
                    LEFT JOIN `preferences`		AS t2 ON t2.`id` = t1.`preferences_id`
                    LEFT JOIN `user_profile`	AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 4
                    AND t2.`status_id` = 4
                    AND up.`status_id` = 4
                    GROUP BY(t1.`lead_id`)
                    ORDER BY(t1.`lead_id`)
                ) AS t4 ON t4.`lead_id` = t1.`id`
                /*Lead Approvals*/
                LEFT JOIN (
                    SELECT 
                        COUNT(t1.`id`) AS lk_p_ct,
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS lk_p_id, t1.`lead_id`, GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS lk_p_uid, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS lk_p_time,
                        GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻☻♥") AS lk_p_uname
                    FROM `lead_approvals` 			AS t1
                    LEFT JOIN `user_profile` 	AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 36
                    AND up.`status_id` = 4
                    GROUP BY(t1.`lead_id`)
                    ORDER BY(t1.`lead_id`)
                ) AS t5 ON t5.`lead_id` = t1.`id`
                /*Lead Quotations*/
                LEFT JOIN (
                SELECT
                    t1.`lead_id`,
                    COUNT(t1.`id`) AS pc_ct,
                    GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS pc_id, 
                    GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS pc_uid, 
                    GROUP_CONCAT(t1.`quotation` SEPARATOR "♥☻☻♥") AS quotations, 
                    GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS pc_time,
                    GROUP_CONCAT(IF((t1.`photo_id` IS NULL OR t1.`photo_id` = NULL OR t1.`photo_id` = "" OR t1.`photo_id` = 0), "" , t1.`photo_id`) SEPARATOR "♥☻☻♥") AS pc_pic_flag,
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_phid, 
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
			(SELECT TRIM(`photo`.`original_pic`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_ph, 
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
			(SELECT TRIM(`photo`.`ver1`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_pv1, 
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
			(SELECT TRIM(`photo`.`ver2`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_pv2, 
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
			(SELECT TRIM(`photo`.`ver3`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_pv3, 
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
			(SELECT TRIM(`photo`.`ver4`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_pv4, 
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
			(SELECT TRIM(`photo`.`ver5`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_pv5, 
                    GROUP_CONCAT(t2.`pcp_id` SEPARATOR "♥☻☻♥") AS pcp_id, 
                    GROUP_CONCAT(t2.`pcp_uid` SEPARATOR "♥☻☻♥") AS pcp_uid, 
                    GROUP_CONCAT(t2.`pcp_time` SEPARATOR "♥☻☻♥") AS pcp_time, 
                    GROUP_CONCAT(t2.`pcp_preid` SEPARATOR "♥☻☻♥") AS pcp_preid, 
                    GROUP_CONCAT(t2.`pcp_pref` SEPARATOR "♥☻☻♥") AS pcp_pref, 
                    GROUP_CONCAT(t2.`pcp_uname` SEPARATOR "♥☻☻♥") AS pcp_uname, 
                    GROUP_CONCAT(t3.`lk_pc_id` SEPARATOR "♥☻☻♥") AS lk_pc_id, 
                    GROUP_CONCAT(t3.`lk_pc_uid` SEPARATOR "♥☻☻♥") AS lk_pc_uid, 
                    GROUP_CONCAT(t3.`lk_pc_time` SEPARATOR "♥☻☻♥") AS lk_pc_time, 
                    GROUP_CONCAT(t3.`lk_pc_uname` SEPARATOR "♥☻☻♥") AS lk_pc_uname, 
                    GROUP_CONCAT(t3.`lk_pc_ct` SEPARATOR "♥☻☻♥") AS lk_pc_ct,
                    GROUP_CONCAT(t4.`pcr_id` SEPARATOR "♥☻☻♥") AS pcr_id, 
                    GROUP_CONCAT(t4.`pcr_uid` SEPARATOR "♥☻☻♥") AS pcr_uid, 
                    GROUP_CONCAT(t4.`wo` SEPARATOR "♥☻☻♥") AS wo, 
                    GROUP_CONCAT(t4.`pcr_time` SEPARATOR "♥☻☻♥") AS pcr_time,  
                    GROUP_CONCAT(t4.`pcr_ct` SEPARATOR "♥☻☻♥") AS pcr_ct, 
                    GROUP_CONCAT(t4.`pcrp_id` SEPARATOR "♥☻☻♥") AS pcrp_id, 
                    GROUP_CONCAT(t4.`pcrp_uid` SEPARATOR "♥☻☻♥") AS pcrp_uid, 
                    GROUP_CONCAT(t4.`pcrp_time` SEPARATOR "♥☻☻♥") AS pcrp_time, 
                    GROUP_CONCAT(t4.`pcr_pic_flag` SEPARATOR "♥☻☻♥") AS pcr_pic_flag, 
                    GROUP_CONCAT(t4.`pcrp_preid` SEPARATOR "♥☻☻♥") AS pcrp_preid,  
                    GROUP_CONCAT(t4.`pcrp_pref` SEPARATOR "♥☻☻♥") AS pcrp_pref,  
                    GROUP_CONCAT(t4.`pcrp_uname` SEPARATOR "♥☻☻♥") AS pcrp_uname, 
                    GROUP_CONCAT(t4.`lk_rep_ct` SEPARATOR "♥☻☻♥") AS lk_rep_ct, 
                    GROUP_CONCAT(t4.`lk_rep_id` SEPARATOR "♥☻☻♥") AS lk_rep_id, 
                    GROUP_CONCAT(t4.`lk_woer_id` SEPARATOR "♥☻☻♥") AS lk_woer_id, 
                    GROUP_CONCAT(t4.`lk_wotime` SEPARATOR "♥☻☻♥") AS lk_wotime, 
                    GROUP_CONCAT(t4.`lk_woer_name` SEPARATOR "♥☻☻♥") AS lk_woer_name, 
                    GROUP_CONCAT(t4.`pcr_phid` SEPARATOR "♥☻☻♥") AS pcr_phid, 
                    GROUP_CONCAT(t4.`pcr_ph` SEPARATOR "♥☻☻♥") AS pcr_ph, 
                    GROUP_CONCAT(t4.`pcr_pv1` SEPARATOR "♥☻☻♥") AS pcr_pv1, 
                    GROUP_CONCAT(t4.`pcr_pv2` SEPARATOR "♥☻☻♥") AS pcr_pv2, 
                    GROUP_CONCAT(t4.`pcr_pv3` SEPARATOR "♥☻☻♥") AS pcr_pv3,  
                    GROUP_CONCAT(t4.`pcr_pv4` SEPARATOR "♥☻☻♥") AS pcr_pv4,  
                    GROUP_CONCAT(t4.`pcr_pv5` SEPARATOR "♥☻☻♥") AS pcr_pv5, 
                    GROUP_CONCAT(t4.`woererid` SEPARATOR "♥☻☻♥") AS woererid,
                    GROUP_CONCAT(t4.`woername` SEPARATOR "♥☻☻♥") AS woername,
                    GROUP_CONCAT(t4.`woeremail` SEPARATOR "♥☻☻♥") AS woeremail,
                    GROUP_CONCAT(t4.`woercell` SEPARATOR "♥☻☻♥") AS woercell,
                    GROUP_CONCAT(t4.`woerpic` SEPARATOR "♥☻☻♥") AS woerpic,
                    GROUP_CONCAT(up.`quotationererid` SEPARATOR "♥☻☻♥") AS  quotationererid,
                    GROUP_CONCAT(up.`quotationername` SEPARATOR "♥☻☻♥") AS  quotationername,
                    GROUP_CONCAT(up.`quotationeremail` SEPARATOR "♥☻☻♥") AS  quotationeremail,
                    GROUP_CONCAT(up.`quotationercell` SEPARATOR "♥☻☻♥") AS  quotationercell,
                    GROUP_CONCAT(up.`quotationerpic` SEPARATOR "♥☻☻♥") AS  quotationerpic
                FROM `lead_quotations` 					AS t1
                /*Lead Quotations User*/
                INNER JOIN (
                    SELECT 
                        ad.`id` AS quotationererid,
                        ad.`user_name` AS quotationername,
                        ad.`email` AS quotationeremail,
                        ad.`cell_number` AS quotationercell,
                        CASE WHEN ad.`icon` IS NULL OR ad.`icon`  = "" OR ph1.`ver3` IS NULL OR ph1.`ver3` = ""
                        THEN "' . $this->config["DEFAULT_USER_ICON_IMG"] . '"
                        ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver3`)
                        END AS quotationerpic
                    FROM `user_profile` AS ad
                    LEFT JOIN `photo` AS ph1 ON ad.`icon` = ph1.`id`
                    WHERE ad.`status_id` = 4
                    AND ad.`status_id` = 4
                ) AS up ON up.`quotationererid` = t1.`user_id`
                /*Lead Quotations Preferences*/
                LEFT JOIN (
                    SELECT
                            GROUP_CONCAT(t1.`id` SEPARATOR "♥☻♥") AS pcp_id,
                            t1.`lead_quotations_id`,
                            GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻♥") AS pcp_uid,
                            GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻♥") AS pcp_time,
                            GROUP_CONCAT(t2.`id` SEPARATOR "♥☻♥") AS pcp_preid,
                            GROUP_CONCAT(t2.`preferences` SEPARATOR "♥☻♥") AS pcp_pref,
                            GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻♥") AS pcp_uname
                    FROM `lead_quotations_preferences` 	AS t1
                    LEFT JOIN `preferences`				AS t2 ON t2.`id` = t1.`preferences_id`
                    LEFT JOIN `user_profile`			AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 4
                    AND t2.`status_id` = 4
                    AND up.`status_id` = 4
                    GROUP BY(t1.`lead_quotations_id`)
                    ORDER BY(t1.`lead_quotations_id`)
                )AS t2 ON t2.`lead_quotations_id` = t1.`id`
                /*Lead Quotations Approvals*/
                LEFT JOIN (
                    SELECT
                        COUNT(t1.`id`) AS lk_pc_ct,
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻♥") AS lk_pc_id, 
                        GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻♥") AS pc_time,
                        t1.`lead_quotations_id`, 
                        GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻♥") AS lk_pc_uid, 
                        GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻♥") AS lk_pc_time,
                        GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻♥") AS lk_pc_uname
                    FROM `lead_quotations_approvals` 	AS t1
                    LEFT JOIN `user_profile` 	AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 36
                    AND up.`status_id` = 4
                    GROUP BY(t1.`lead_quotations_id`)
                    ORDER BY(t1.`lead_quotations_id`)
                ) AS t3 ON t3.`lead_quotations_id` = t1.`id`
                /*Lead Quotations Wo*/
                LEFT JOIN (
                    SELECT
                        COUNT(t1.`id`) AS pcr_ct,
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻♥") AS pcr_id, 
                        t1.`lead_quotations_id` AS pcr_pc_id, 
                        GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻♥") AS pcr_uid, 
                        GROUP_CONCAT(t1.`wo` SEPARATOR "♥☻♥") AS wo, 
                        GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻♥") AS pcr_time,
                        GROUP_CONCAT(
                            IF((t1.`photo_id` IS NULL OR t1.`photo_id` = NULL OR t1.`photo_id` = "" OR t1.`photo_id` = 0), "" , t1.`photo_id`) 
                             SEPARATOR "♥☻♥"
                        ) AS pcr_pic_flag,
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_phid, 
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
                            (SELECT TRIM(`photo`.`original_pic`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_ph, 
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
                            (SELECT TRIM(`photo`.`ver1`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_pv1, 
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
                            (SELECT TRIM(`photo`.`ver2`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_pv2, 
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
                            (SELECT TRIM(`photo`.`ver3`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_pv3, 
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
                            (SELECT TRIM(`photo`.`ver4`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_pv4, 
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
                            (SELECT TRIM(`photo`.`ver5`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_pv5, 
                        GROUP_CONCAT(t2.`pcrp_id` SEPARATOR "♥☻♥") AS pcrp_id,
                        GROUP_CONCAT(t2.`pcrp_uid` SEPARATOR "♥☻♥") AS pcrp_uid,
                        GROUP_CONCAT(t2.`pcrp_time` SEPARATOR "♥☻♥") AS pcrp_time,
                        GROUP_CONCAT(t2.`pcrp_preid` SEPARATOR "♥☻♥") AS pcrp_preid,
                        GROUP_CONCAT(t2.`pcrp_pref` SEPARATOR "♥☻♥") AS pcrp_pref,
                        GROUP_CONCAT(t2.`pcrp_uname` SEPARATOR "♥☻♥") AS pcrp_uname,
                        GROUP_CONCAT(t3.`lk_rep_id` SEPARATOR "♥☻♥") AS lk_rep_id,
                        GROUP_CONCAT(t3.`lk_woer_id` SEPARATOR "♥☻♥") AS lk_woer_id,
                        GROUP_CONCAT(t3.`lk_wotime` SEPARATOR "♥☻♥") AS lk_wotime,
                        GROUP_CONCAT(t3.`lk_woer_name` SEPARATOR "♥☻♥") AS lk_woer_name,
                        GROUP_CONCAT(t3.`lk_rep_ct` SEPARATOR "♥☻♥") AS lk_rep_ct,
                        GROUP_CONCAT(up.`woererid` SEPARATOR "♥☻♥") AS woererid,
                        GROUP_CONCAT(up.`woername` SEPARATOR "♥☻♥") AS woername,
                        GROUP_CONCAT(up.`woeremail` SEPARATOR "♥☻♥") AS woeremail,
                        GROUP_CONCAT(up.`woercell` SEPARATOR "♥☻♥") AS woercell,
                        GROUP_CONCAT(up.`woerpic` SEPARATOR "♥☻♥") AS woerpic
                    FROM `lead_quotations_wo` 						AS t1
                    /*Lead Quotations Wo User*/
                    INNER JOIN (
                        SELECT 
                            ad.`id` AS woererid,
                            ad.`user_name` AS woername,
                            ad.`email` AS woeremail,
                            ad.`cell_number` AS woercell,
                            CASE WHEN ad.`icon` IS NULL OR ad.`icon`  = "" OR ph1.`ver3` IS NULL OR ph1.`ver3` = ""
                            THEN "' . $this->config["DEFAULT_USER_ICON_IMG"] . '"
                            ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver3`)
                            END AS woerpic
                        FROM `user_profile` AS ad
                        LEFT JOIN `photo` AS ph1 ON ad.`icon` = ph1.`id`
                        WHERE ad.`status_id` = 4
                    )AS up ON up.`woererid` = t1.`user_id`
                    /*Lead Quotations Wo Preferences*/
                    LEFT JOIN (
                        SELECT
                            GROUP_CONCAT(t1.`id` SEPARATOR "♥♥") AS pcrp_id, 
                            t1.`lead_quotations_wo_id`, 
                            GROUP_CONCAT(t1.`user_id` SEPARATOR "♥♥") AS pcrp_uid, 
                            GROUP_CONCAT(t1.`created_at` SEPARATOR "♥♥") AS pcrp_time, 
                            GROUP_CONCAT(t2.`id` SEPARATOR "♥♥") AS pcrp_preid, 
                            GROUP_CONCAT(t2.`preferences` SEPARATOR "♥♥") AS pcrp_pref, 
                            GROUP_CONCAT(up.`user_name` SEPARATOR "♥♥") AS pcrp_uname
                        FROM `lead_quotations_wo_preferences` 	AS t1
                        LEFT JOIN `preferences`					AS t2 ON t2.`id` = t1.`preferences_id`
                        LEFT JOIN `user_profile`				AS up ON up.`id` = t1.`user_id`
                        WHERE t1.`status_id` = 4
                        AND t2.`status_id` = 4
                        AND up.`status_id` = 4
                        GROUP BY(t1.`lead_quotations_wo_id`)
                        ORDER BY(t1.`lead_quotations_wo_id`)
                    ) AS t2 ON t2.`lead_quotations_wo_id` = t1.`id`
                    /*Lead Quotations Wo Approvals*/
                    LEFT JOIN (
                            SELECT
                                GROUP_CONCAT(t1.`id` SEPARATOR "♥♥") AS lk_rep_id, 
                                COUNT(t1.`id`) AS lk_rep_ct,
                                t1.`lead_quotations_wo_id`, 
                                GROUP_CONCAT(t1.`user_id` SEPARATOR "♥♥") AS lk_woer_id, 
                                GROUP_CONCAT(t1.`created_at` SEPARATOR "♥♥") AS lk_wotime, 
                                GROUP_CONCAT(up.`user_name` SEPARATOR "♥♥") AS lk_woer_name
                        FROM `lead_quotations_wo_approvals` AS t1
                       LEFT JOIN `user_profile` 		AS up ON up.`id` = t1.`user_id`
                       WHERE t1.`status_id` = 36
                       AND up.`status_id` = 4
                       GROUP BY(t1.`lead_quotations_wo_id`)
                       ORDER BY(t1.`lead_quotations_wo_id`)
                    ) AS t3 ON t3.`lead_quotations_wo_id` = t1.`id`
                    WHERE t1.`status_id` = 4
                    GROUP BY(t1.`lead_quotations_id`)
                    ORDER BY(t1.`lead_quotations_id`)
                ) AS t4 ON t4.`pcr_pc_id` = t1.`id`
                WHERE t1.`status_id` = 4
                GROUP BY(t1.`lead_id`)
                ORDER BY(t1.`lead_id`)
                ) AS t6 ON t6.`lead_id` = t1.`id`
                /*Lead Languages*/
                LEFT JOIN (
                        SELECT
                                GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS plng_id, t1.`lead_id`, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS plng_time,
                                GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS plng_lngid, GROUP_CONCAT(t2.`Language Name` SEPARATOR "♥☻☻♥") AS plng_lngname
                        FROM `lead_languages` 	AS t1
                        LEFT JOIN `nookleads_languages`	AS t2 ON t2.`id` = t1.`languages_id`
                        WHERE t1.`status_id` = 4
                        AND t2.`status_id` = 4
                        GROUP BY(t1.`lead_id`)
                        ORDER BY(t1.`lead_id`)
                ) AS t7 ON t7.`lead_id` = t1.`id`
                /*Lead Sections*/
                LEFT JOIN (
                        /*
                        SELECT
                                GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS ps_id, t1.`lead_id`, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS ps_time,
                                GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS ps_secid, GROUP_CONCAT(TRIM(t2.`section_name`) SEPARATOR "♥☻☻♥") AS pr_secname
                        FROM `lead_section` 	AS t1
                        LEFT JOIN `sections_index_lead`	AS t2 ON t2.`id` = t1.`section_id`
                        WHERE t1.`status_id` = 4
                        AND t2.`status_id` = 4
                        GROUP BY(t1.`lead_id`)
                        ORDER BY(t1.`lead_id`) DESC
                        */
                        SELECT
                            t1.`id` AS ps_id, 
                            t1.`lead_id`,
                            t1.`created_at` AS ps_time,
                            t2.`id` AS ps_secid,
                            TRIM(t2.`section_name`) AS pr_secname
                        FROM `lead_section` 	AS t1
                        LEFT JOIN `sections_index_lead`	AS t2 ON t2.`id` = t1.`section_id`
                        WHERE t1.`status_id` = 4
                        AND t2.`status_id` = 4
                ) AS t8 ON t8.`lead_id` = t1.`id`
                /*Lead Photo*/
                LEFT JOIN (
                    SELECT
                        `id` AS p_phid,
                        IF((`original_pic` IS NULL OR `original_pic` = NULL OR `original_pic` = ""),"' . $this->config["DEFAULT_POST_IMG"] . '",TRIM(`original_pic`)) AS p_ph,
                        IF((`ver1` IS NULL OR `ver1` = NULL OR `ver1` = ""),"' . $this->config["DEFAULT_POST_IMG"] . '",TRIM(`ver1`)) AS p_pv1,
                        IF((`ver2` IS NULL OR `ver2` = NULL OR `ver2` = ""),"' . $this->config["DEFAULT_POST_IMG"] . '",TRIM(`ver2`)) AS p_pv2,
                        IF((`ver3` IS NULL OR `ver3` = NULL OR `ver3` = ""),"' . $this->config["DEFAULT_POST_IMG"] . '",TRIM(`ver3`)) AS p_pv3,
                        IF((`ver4` IS NULL OR `ver4` = NULL OR `ver4` = ""),"' . $this->config["DEFAULT_POST_IMG"] . '",TRIM(`ver4`)) AS p_pv4,
                        IF((`ver5` IS NULL OR `ver5` = NULL OR `ver5` = ""),"' . $this->config["DEFAULT_POST_IMG"] . '",TRIM(`ver5`)) AS p_pv5
                    FROM `photo`
                    WHERE `status_id` = 4
                ) AS t9 ON t9.`p_phid` = t1.`photo_id`
                /* Lead Business */
                LEFT JOIN (
                    SELECT
                        t1.`id` AS chwaid,
                        t1.`business_id` AS chwacid,
                        t1.`user_id` AS chwauid,
                        t1.`lead_id` AS chwalead_id,
                        t1.`created_at` AS chwatime,
                        t2.`business_name`,
                        t2.`business_description`,
                        t2.`business_location`,
                        t2.`business_language`,
                        t2.`business_icon`,
                        t2.`business_background`,
                        t2.`business_created_at`,
                        t2.`business_updated_at`,
                        t2.`business_website`
                    FROM `business_deal` AS t1
                    LEFT JOIN `business`	AS t2 ON t2.`id` = t1.`business_id`
                    LEFT JOIN `user_profile` AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 4
                    AND t2.`status_id` = 4
                    AND up.`status_id` = 4
                ) AS t10 ON t10.`chwalead_id` = t1.`id`
                WHERE t1.`status_id` = 4
                ORDER BY(t1.`id`) DESC
                /*Lead Ends*/');
        $res = $stm->execute();
        return $this->buildListLeadArray($res, $stm);
    }
    public function New_() {
        $_SESSION["ListNewLead"] = NULL;
        $stm = $this->db->prepare('/*Lead Start*/
                SELECT
                    /*COUNT(t1.`id`) AS lead_ct,*/
                    t1.*,
                    t1.`id`,
                    t1.`title`,
                    t1.`photo_id`,
                    t1.`section_id`,
                    t1.`user_id`,
                    t1.`created_at`,
                    IF((t1.`photo_id` IS NULL OR t1.`photo_id` = NULL OR t1.`photo_id` = "" OR t1.`photo_id` = 0), NULL , t1.`photo_id`) AS p_pic_flag,
                    t2.*,
                    t3.*,
                    t4.*,
                    t5.*,
                    t6.*,
                    t7.*,
                    t8.*,
                    t9.*,
                    t10.*,
                    up.`leaderpic`,
                    up.`leaderid`,
                    up.`leadername`,
                    up.`leaderemail`,
                    up.`leadercell`
                FROM `lead` AS t1
                /*Lead Countries*/
                LEFT JOIN (
                    SELECT
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS pcont_id, t1.`lead_id`, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS pcont_time,
                        GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS pcont_contid, GROUP_CONCAT(t2.`Country` SEPARATOR "♥☻☻♥") AS pcont_contname
                    FROM `lead_countries` 	AS t1
                    LEFT JOIN `nookleads_countries`	AS t2 ON t2.`id` = t1.`country_id`
                    WHERE t1.`status_id` = 4
                    AND t2.`status_id` = 4
                    GROUP BY(t1.`lead_id`)
                    ORDER BY(t1.`lead_id`)
                ) AS t2 ON t2.`lead_id` = t1.`id`
                /*Lead User*/
                INNER JOIN (
                    SELECT 
                        ad.`id` AS leaderid,
                        ad.`user_name` AS leadername,
                        ad.`email` AS leaderemail,
                        ad.`cell_number` AS leadercell,
                        CASE WHEN ad.`icon` IS NULL OR ad.`icon`  = "" OR ph1.`ver3` IS NULL OR ph1.`ver3` = ""
                        THEN "' . $this->config["DEFAULT_USER_ICON_IMG"] . '"
                        ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver3`)
                        END AS leaderpic
                    FROM `user_profile` AS ad
                    LEFT JOIN `photo` AS ph1 ON ad.`icon` = ph1.`id` 
                    WHERE ad.`status_id` = 4
                ) AS up ON up.`leaderid` = t1.`user_id` 
                /*Lead Report*/
                LEFT JOIN (
                    SELECT
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS pr_id, t1.`lead_id`, GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS pr_uid, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS pr_time,
                        GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS pr_repid, GROUP_CONCAT(t2.`report_name`  SEPARATOR "♥☻☻♥") AS pr_repname,
                        GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻☻♥") AS pr_uname
                    FROM `lead_report` 			AS t1
                    LEFT JOIN `report`			AS t2 ON t2.`id` = t1.`report_id`
                    LEFT JOIN `user_profile`	AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 4
                    AND t2.`status_id` = 4
                    AND up.`status_id` = 4
                    GROUP BY(t1.`lead_id`)
                    ORDER BY(t1.`lead_id`)
                ) AS t3 ON t3.`lead_id` = t1.`id`
                /*Lead Preferences*/
                LEFT JOIN (
                    SELECT
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS pp_id, t1.`lead_id`, GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS pp_uid, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS pp_time,
                        GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS pp_preid, GROUP_CONCAT(t2.`preferences` SEPARATOR "♥☻☻♥") AS pp_pref,
                        GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻☻♥") AS pp_uname
                    FROM `lead_preferences` 	AS t1
                    LEFT JOIN `preferences`		AS t2 ON t2.`id` = t1.`preferences_id`
                    LEFT JOIN `user_profile`	AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 4
                    AND t2.`status_id` = 4
                    AND up.`status_id` = 4
                    GROUP BY(t1.`lead_id`)
                    ORDER BY(t1.`lead_id`)
                ) AS t4 ON t4.`lead_id` = t1.`id`
                /*Lead Approvals*/
                LEFT JOIN (
                    SELECT 
                        COUNT(t1.`id`) AS lk_p_ct,
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS lk_p_id, t1.`lead_id`, GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS lk_p_uid, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS lk_p_time,
                        GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻☻♥") AS lk_p_uname
                    FROM `lead_approvals` 			AS t1
                    LEFT JOIN `user_profile` 	AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 36
                    AND up.`status_id` = 4
                    GROUP BY(t1.`lead_id`)
                    ORDER BY(t1.`lead_id`)
                ) AS t5 ON t5.`lead_id` = t1.`id`
                /*Lead Quotations*/
                LEFT JOIN (
                SELECT
                    t1.`lead_id`,
                    COUNT(t1.`id`) AS pc_ct,
                    GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS pc_id, 
                    GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS pc_uid, 
                    GROUP_CONCAT(t1.`quotation` SEPARATOR "♥☻☻♥") AS quotations, 
                    GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS pc_time,
                    GROUP_CONCAT(IF((t1.`photo_id` IS NULL OR t1.`photo_id` = NULL OR t1.`photo_id` = "" OR t1.`photo_id` = 0), "" , t1.`photo_id`) SEPARATOR "♥☻☻♥") AS pc_pic_flag,
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_phid, 
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
			(SELECT TRIM(`photo`.`original_pic`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_ph, 
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
			(SELECT TRIM(`photo`.`ver1`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_pv1, 
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
			(SELECT TRIM(`photo`.`ver2`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_pv2, 
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
			(SELECT TRIM(`photo`.`ver3`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_pv3, 
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
			(SELECT TRIM(`photo`.`ver4`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_pv4, 
                    GROUP_CONCAT(
                    IF((
			(SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
			OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
			(SELECT TRIM(`photo`.`ver5`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
		    )
                    SEPARATOR "♥☻☻♥") AS pc_pv5, 
                    GROUP_CONCAT(t2.`pcp_id` SEPARATOR "♥☻☻♥") AS pcp_id, 
                    GROUP_CONCAT(t2.`pcp_uid` SEPARATOR "♥☻☻♥") AS pcp_uid, 
                    GROUP_CONCAT(t2.`pcp_time` SEPARATOR "♥☻☻♥") AS pcp_time, 
                    GROUP_CONCAT(t2.`pcp_preid` SEPARATOR "♥☻☻♥") AS pcp_preid, 
                    GROUP_CONCAT(t2.`pcp_pref` SEPARATOR "♥☻☻♥") AS pcp_pref, 
                    GROUP_CONCAT(t2.`pcp_uname` SEPARATOR "♥☻☻♥") AS pcp_uname, 
                    GROUP_CONCAT(t3.`lk_pc_id` SEPARATOR "♥☻☻♥") AS lk_pc_id, 
                    GROUP_CONCAT(t3.`lk_pc_uid` SEPARATOR "♥☻☻♥") AS lk_pc_uid, 
                    GROUP_CONCAT(t3.`lk_pc_time` SEPARATOR "♥☻☻♥") AS lk_pc_time, 
                    GROUP_CONCAT(t3.`lk_pc_uname` SEPARATOR "♥☻☻♥") AS lk_pc_uname, 
                    GROUP_CONCAT(t3.`lk_pc_ct` SEPARATOR "♥☻☻♥") AS lk_pc_ct,
                    GROUP_CONCAT(t4.`pcr_id` SEPARATOR "♥☻☻♥") AS pcr_id, 
                    GROUP_CONCAT(t4.`pcr_uid` SEPARATOR "♥☻☻♥") AS pcr_uid, 
                    GROUP_CONCAT(t4.`wo` SEPARATOR "♥☻☻♥") AS wo, 
                    GROUP_CONCAT(t4.`pcr_time` SEPARATOR "♥☻☻♥") AS pcr_time,  
                    GROUP_CONCAT(t4.`pcr_ct` SEPARATOR "♥☻☻♥") AS pcr_ct, 
                    GROUP_CONCAT(t4.`pcrp_id` SEPARATOR "♥☻☻♥") AS pcrp_id, 
                    GROUP_CONCAT(t4.`pcrp_uid` SEPARATOR "♥☻☻♥") AS pcrp_uid, 
                    GROUP_CONCAT(t4.`pcrp_time` SEPARATOR "♥☻☻♥") AS pcrp_time, 
                    GROUP_CONCAT(t4.`pcr_pic_flag` SEPARATOR "♥☻☻♥") AS pcr_pic_flag, 
                    GROUP_CONCAT(t4.`pcrp_preid` SEPARATOR "♥☻☻♥") AS pcrp_preid,  
                    GROUP_CONCAT(t4.`pcrp_pref` SEPARATOR "♥☻☻♥") AS pcrp_pref,  
                    GROUP_CONCAT(t4.`pcrp_uname` SEPARATOR "♥☻☻♥") AS pcrp_uname, 
                    GROUP_CONCAT(t4.`lk_rep_ct` SEPARATOR "♥☻☻♥") AS lk_rep_ct, 
                    GROUP_CONCAT(t4.`lk_rep_id` SEPARATOR "♥☻☻♥") AS lk_rep_id, 
                    GROUP_CONCAT(t4.`lk_woer_id` SEPARATOR "♥☻☻♥") AS lk_woer_id, 
                    GROUP_CONCAT(t4.`lk_wotime` SEPARATOR "♥☻☻♥") AS lk_wotime, 
                    GROUP_CONCAT(t4.`lk_woer_name` SEPARATOR "♥☻☻♥") AS lk_woer_name, 
                    GROUP_CONCAT(t4.`pcr_phid` SEPARATOR "♥☻☻♥") AS pcr_phid, 
                    GROUP_CONCAT(t4.`pcr_ph` SEPARATOR "♥☻☻♥") AS pcr_ph, 
                    GROUP_CONCAT(t4.`pcr_pv1` SEPARATOR "♥☻☻♥") AS pcr_pv1, 
                    GROUP_CONCAT(t4.`pcr_pv2` SEPARATOR "♥☻☻♥") AS pcr_pv2, 
                    GROUP_CONCAT(t4.`pcr_pv3` SEPARATOR "♥☻☻♥") AS pcr_pv3,  
                    GROUP_CONCAT(t4.`pcr_pv4` SEPARATOR "♥☻☻♥") AS pcr_pv4,  
                    GROUP_CONCAT(t4.`pcr_pv5` SEPARATOR "♥☻☻♥") AS pcr_pv5, 
                    GROUP_CONCAT(t4.`woererid` SEPARATOR "♥☻☻♥") AS woererid,
                    GROUP_CONCAT(t4.`woername` SEPARATOR "♥☻☻♥") AS woername,
                    GROUP_CONCAT(t4.`woeremail` SEPARATOR "♥☻☻♥") AS woeremail,
                    GROUP_CONCAT(t4.`woercell` SEPARATOR "♥☻☻♥") AS woercell,
                    GROUP_CONCAT(t4.`woerpic` SEPARATOR "♥☻☻♥") AS woerpic,
                    GROUP_CONCAT(up.`quotationererid` SEPARATOR "♥☻☻♥") AS  quotationererid,
                    GROUP_CONCAT(up.`quotationername` SEPARATOR "♥☻☻♥") AS  quotationername,
                    GROUP_CONCAT(up.`quotationeremail` SEPARATOR "♥☻☻♥") AS  quotationeremail,
                    GROUP_CONCAT(up.`quotationercell` SEPARATOR "♥☻☻♥") AS  quotationercell,
                    GROUP_CONCAT(up.`quotationerpic` SEPARATOR "♥☻☻♥") AS  quotationerpic
                FROM `lead_quotations` 					AS t1
                /*Lead Quotations User*/
                INNER JOIN (
                    SELECT 
                        ad.`id` AS quotationererid,
                        ad.`user_name` AS quotationername,
                        ad.`email` AS quotationeremail,
                        ad.`cell_number` AS quotationercell,
                        CASE WHEN ad.`icon` IS NULL OR ad.`icon`  = "" OR ph1.`ver3` IS NULL OR ph1.`ver3` = ""
                        THEN "' . $this->config["DEFAULT_USER_ICON_IMG"] . '"
                        ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver3`)
                        END AS quotationerpic
                    FROM `user_profile` AS ad
                    LEFT JOIN `photo` AS ph1 ON ad.`icon` = ph1.`id`
                    WHERE ad.`status_id` = 4
                    AND ad.`status_id` = 4
                ) AS up ON up.`quotationererid` = t1.`user_id`
                /*Lead Quotations Preferences*/
                LEFT JOIN (
                    SELECT
                            GROUP_CONCAT(t1.`id` SEPARATOR "♥☻♥") AS pcp_id,
                            t1.`lead_quotations_id`,
                            GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻♥") AS pcp_uid,
                            GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻♥") AS pcp_time,
                            GROUP_CONCAT(t2.`id` SEPARATOR "♥☻♥") AS pcp_preid,
                            GROUP_CONCAT(t2.`preferences` SEPARATOR "♥☻♥") AS pcp_pref,
                            GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻♥") AS pcp_uname
                    FROM `lead_quotations_preferences` 	AS t1
                    LEFT JOIN `preferences`				AS t2 ON t2.`id` = t1.`preferences_id`
                    LEFT JOIN `user_profile`			AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 4
                    AND t2.`status_id` = 4
                    AND up.`status_id` = 4
                    GROUP BY(t1.`lead_quotations_id`)
                    ORDER BY(t1.`lead_quotations_id`)
                )AS t2 ON t2.`lead_quotations_id` = t1.`id`
                /*Lead Quotations Approvals*/
                LEFT JOIN (
                    SELECT
                        COUNT(t1.`id`) AS lk_pc_ct,
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻♥") AS lk_pc_id, 
                        GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻♥") AS pc_time,
                        t1.`lead_quotations_id`, 
                        GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻♥") AS lk_pc_uid, 
                        GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻♥") AS lk_pc_time,
                        GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻♥") AS lk_pc_uname
                    FROM `lead_quotations_approvals` 	AS t1
                    LEFT JOIN `user_profile` 	AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 36
                    AND up.`status_id` = 4
                    GROUP BY(t1.`lead_quotations_id`)
                    ORDER BY(t1.`lead_quotations_id`)
                ) AS t3 ON t3.`lead_quotations_id` = t1.`id`
                /*Lead Quotations Wo*/
                LEFT JOIN (
                    SELECT
                        COUNT(t1.`id`) AS pcr_ct,
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻♥") AS pcr_id, 
                        t1.`lead_quotations_id` AS pcr_pc_id, 
                        GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻♥") AS pcr_uid, 
                        GROUP_CONCAT(t1.`wo` SEPARATOR "♥☻♥") AS wo, 
                        GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻♥") AS pcr_time,
                        GROUP_CONCAT(
                            IF((t1.`photo_id` IS NULL OR t1.`photo_id` = NULL OR t1.`photo_id` = "" OR t1.`photo_id` = 0), "" , t1.`photo_id`) 
                             SEPARATOR "♥☻♥"
                        ) AS pcr_pic_flag,
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_phid, 
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
                            (SELECT TRIM(`photo`.`original_pic`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_ph, 
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
                            (SELECT TRIM(`photo`.`ver1`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_pv1, 
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
                            (SELECT TRIM(`photo`.`ver2`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_pv2, 
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
                            (SELECT TRIM(`photo`.`ver3`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_pv3, 
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
                            (SELECT TRIM(`photo`.`ver4`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_pv4, 
                        GROUP_CONCAT(
                        IF((
                            (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) IS NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = NULL 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = "" 
                            OR (SELECT `photo`.`id` FROM `photo` WHERE `photo`.`id` = t1.`photo_id`) = 0), "" , 
                            (SELECT TRIM(`photo`.`ver5`) FROM `photo` WHERE `photo`.`id` = t1.`photo_id`)
                        )
                        SEPARATOR "♥☻♥") AS pcr_pv5, 
                        GROUP_CONCAT(t2.`pcrp_id` SEPARATOR "♥☻♥") AS pcrp_id,
                        GROUP_CONCAT(t2.`pcrp_uid` SEPARATOR "♥☻♥") AS pcrp_uid,
                        GROUP_CONCAT(t2.`pcrp_time` SEPARATOR "♥☻♥") AS pcrp_time,
                        GROUP_CONCAT(t2.`pcrp_preid` SEPARATOR "♥☻♥") AS pcrp_preid,
                        GROUP_CONCAT(t2.`pcrp_pref` SEPARATOR "♥☻♥") AS pcrp_pref,
                        GROUP_CONCAT(t2.`pcrp_uname` SEPARATOR "♥☻♥") AS pcrp_uname,
                        GROUP_CONCAT(t3.`lk_rep_id` SEPARATOR "♥☻♥") AS lk_rep_id,
                        GROUP_CONCAT(t3.`lk_woer_id` SEPARATOR "♥☻♥") AS lk_woer_id,
                        GROUP_CONCAT(t3.`lk_wotime` SEPARATOR "♥☻♥") AS lk_wotime,
                        GROUP_CONCAT(t3.`lk_woer_name` SEPARATOR "♥☻♥") AS lk_woer_name,
                        GROUP_CONCAT(t3.`lk_rep_ct` SEPARATOR "♥☻♥") AS lk_rep_ct,
                        GROUP_CONCAT(up.`woererid` SEPARATOR "♥☻♥") AS woererid,
                        GROUP_CONCAT(up.`woername` SEPARATOR "♥☻♥") AS woername,
                        GROUP_CONCAT(up.`woeremail` SEPARATOR "♥☻♥") AS woeremail,
                        GROUP_CONCAT(up.`woercell` SEPARATOR "♥☻♥") AS woercell,
                        GROUP_CONCAT(up.`woerpic` SEPARATOR "♥☻♥") AS woerpic
                    FROM `lead_quotations_wo` 						AS t1
                    /*Lead Quotations Wo User*/
                    INNER JOIN (
                        SELECT 
                            ad.`id` AS woererid,
                            ad.`user_name` AS woername,
                            ad.`email` AS woeremail,
                            ad.`cell_number` AS woercell,
                            CASE WHEN ad.`icon` IS NULL OR ad.`icon`  = "" OR ph1.`ver3` IS NULL OR ph1.`ver3` = ""
                            THEN "' . $this->config["DEFAULT_USER_ICON_IMG"] . '"
                            ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver3`)
                            END AS woerpic
                        FROM `user_profile` AS ad
                        LEFT JOIN `photo` AS ph1 ON ad.`icon` = ph1.`id`
                        WHERE ad.`status_id` = 4
                    )AS up ON up.`woererid` = t1.`user_id`
                    /*Lead Quotations Wo Preferences*/
                    LEFT JOIN (
                        SELECT
                            GROUP_CONCAT(t1.`id` SEPARATOR "♥♥") AS pcrp_id, 
                            t1.`lead_quotations_wo_id`, 
                            GROUP_CONCAT(t1.`user_id` SEPARATOR "♥♥") AS pcrp_uid, 
                            GROUP_CONCAT(t1.`created_at` SEPARATOR "♥♥") AS pcrp_time, 
                            GROUP_CONCAT(t2.`id` SEPARATOR "♥♥") AS pcrp_preid, 
                            GROUP_CONCAT(t2.`preferences` SEPARATOR "♥♥") AS pcrp_pref, 
                            GROUP_CONCAT(up.`user_name` SEPARATOR "♥♥") AS pcrp_uname
                        FROM `lead_quotations_wo_preferences` 	AS t1
                        LEFT JOIN `preferences`					AS t2 ON t2.`id` = t1.`preferences_id`
                        LEFT JOIN `user_profile`				AS up ON up.`id` = t1.`user_id`
                        WHERE t1.`status_id` = 4
                        AND t2.`status_id` = 4
                        AND up.`status_id` = 4
                        GROUP BY(t1.`lead_quotations_wo_id`)
                        ORDER BY(t1.`lead_quotations_wo_id`)
                    ) AS t2 ON t2.`lead_quotations_wo_id` = t1.`id`
                    /*Lead Quotations Wo Approvals*/
                    LEFT JOIN (
                            SELECT
                                GROUP_CONCAT(t1.`id` SEPARATOR "♥♥") AS lk_rep_id, 
                                COUNT(t1.`id`) AS lk_rep_ct,
                                t1.`lead_quotations_wo_id`, 
                                GROUP_CONCAT(t1.`user_id` SEPARATOR "♥♥") AS lk_woer_id, 
                                GROUP_CONCAT(t1.`created_at` SEPARATOR "♥♥") AS lk_wotime, 
                                GROUP_CONCAT(up.`user_name` SEPARATOR "♥♥") AS lk_woer_name
                        FROM `lead_quotations_wo_approvals` AS t1
                       LEFT JOIN `user_profile` 		AS up ON up.`id` = t1.`user_id`
                       WHERE t1.`status_id` = 36
                       AND up.`status_id` = 4
                       GROUP BY(t1.`lead_quotations_wo_id`)
                       ORDER BY(t1.`lead_quotations_wo_id`)
                    ) AS t3 ON t3.`lead_quotations_wo_id` = t1.`id`
                    WHERE t1.`status_id` = 4
                    GROUP BY(t1.`lead_quotations_id`)
                    ORDER BY(t1.`lead_quotations_id`)
                ) AS t4 ON t4.`pcr_pc_id` = t1.`id`
                WHERE t1.`status_id` = 4
                GROUP BY(t1.`lead_id`)
                ORDER BY(t1.`lead_id`)
                ) AS t6 ON t6.`lead_id` = t1.`id`
                /*Lead Languages*/
                LEFT JOIN (
                        SELECT
                                GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS plng_id, t1.`lead_id`, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS plng_time,
                                GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS plng_lngid, GROUP_CONCAT(t2.`Language Name` SEPARATOR "♥☻☻♥") AS plng_lngname
                        FROM `lead_languages` 	AS t1
                        LEFT JOIN `nookleads_languages`	AS t2 ON t2.`id` = t1.`languages_id`
                        WHERE t1.`status_id` = 4
                        AND t2.`status_id` = 4
                        GROUP BY(t1.`lead_id`)
                        ORDER BY(t1.`lead_id`)
                ) AS t7 ON t7.`lead_id` = t1.`id`
                /*Lead Sections*/
                LEFT JOIN (
                        /*
                        SELECT
                                GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS ps_id, t1.`lead_id`, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS ps_time,
                                GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS ps_secid, GROUP_CONCAT(TRIM(t2.`section_name`) SEPARATOR "♥☻☻♥") AS pr_secname
                        FROM `lead_section` 	AS t1
                        LEFT JOIN `sections_index_lead`	AS t2 ON t2.`id` = t1.`section_id`
                        WHERE t1.`status_id` = 4
                        AND t2.`status_id` = 4
                        GROUP BY(t1.`lead_id`)
                        ORDER BY(t1.`lead_id`) DESC
                        */
                        SELECT
                            t1.`id` AS ps_id, 
                            t1.`lead_id`,
                            t1.`created_at` AS ps_time,
                            t2.`id` AS ps_secid,
                            TRIM(t2.`section_name`) AS pr_secname
                        FROM `lead_section` 	AS t1
                        LEFT JOIN `sections_index_lead`	AS t2 ON t2.`id` = t1.`section_id`
                        WHERE t1.`status_id` = 4
                        AND t2.`status_id` = 4
                ) AS t8 ON t8.`lead_id` = t1.`id`
                /*Lead Photo*/
                LEFT JOIN (
                    SELECT
                        `id` AS p_phid,
                        IF((`original_pic` IS NULL OR `original_pic` = NULL OR `original_pic` = ""),"' . $this->config["DEFAULT_POST_IMG"] . '",TRIM(`original_pic`)) AS p_ph,
                        IF((`ver1` IS NULL OR `ver1` = NULL OR `ver1` = ""),"' . $this->config["DEFAULT_POST_IMG"] . '",TRIM(`ver1`)) AS p_pv1,
                        IF((`ver2` IS NULL OR `ver2` = NULL OR `ver2` = ""),"' . $this->config["DEFAULT_POST_IMG"] . '",TRIM(`ver2`)) AS p_pv2,
                        IF((`ver3` IS NULL OR `ver3` = NULL OR `ver3` = ""),"' . $this->config["DEFAULT_POST_IMG"] . '",TRIM(`ver3`)) AS p_pv3,
                        IF((`ver4` IS NULL OR `ver4` = NULL OR `ver4` = ""),"' . $this->config["DEFAULT_POST_IMG"] . '",TRIM(`ver4`)) AS p_pv4,
                        IF((`ver5` IS NULL OR `ver5` = NULL OR `ver5` = ""),"' . $this->config["DEFAULT_POST_IMG"] . '",TRIM(`ver5`)) AS p_pv5
                    FROM `photo`
                    WHERE `status_id` = 4
                ) AS t9 ON t9.`p_phid` = t1.`photo_id`
                /* Lead Business */
                LEFT JOIN (
                    SELECT
                        t1.`id` AS chwaid,
                        t1.`business_id` AS chwacid,
                        t1.`user_id` AS chwauid,
                        t1.`lead_id` AS chwalead_id,
                        t1.`created_at` AS chwatime,
                        t2.`business_name`,
                        t2.`business_description`,
                        t2.`business_location`,
                        t2.`business_language`,
                        t2.`business_icon`,
                        t2.`business_background`,
                        t2.`business_created_at`,
                        t2.`business_updated_at`,
                        t2.`business_website`
                    FROM `business_deal` AS t1
                    LEFT JOIN `business`	AS t2 ON t2.`id` = t1.`business_id`
                    LEFT JOIN `user_profile` AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 4
                    AND t2.`status_id` = 4
                    AND up.`status_id` = 4
                ) AS t10 ON t10.`chwalead_id` = t1.`id`
                WHERE t1.`status_id` = 4
                ORDER BY(t1.`id`) DESC
                /*Lead Ends*/');
        $res = $stm->execute();
        return $this->buildListLeadArray($res, $stm);
    }
}
?>