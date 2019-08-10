<?php
class Post_Model extends BaseModel {

    public $UserId;

    function __construct() {
        parent::__construct();
        $this->UserId = (integer) isset($_SESSION["USERDATA"]["logindata"]["id"]) ?
                $_SESSION["USERDATA"]["logindata"]["id"] :
                0;
    }
    public function listWallPost() {
        $_SESSION["ListNewPost"] = NULL;
        $stm = $this->db->prepare('/*Post Start*/
                SELECT
                    /*COUNT(t1.`id`) AS post_ct,*/
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
                    t11.*,
                    up.`posterpic`,
                    up.`posterid`,
                    up.`postername`,
                    up.`posteremail`,
                    up.`postercell`
                FROM `post` AS t1
                /* Post Countries */
                LEFT JOIN (
                    SELECT
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS pcont_id, t1.`post_id`, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS pcont_time,
                        GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS pcont_contid, GROUP_CONCAT(t2.`Country` SEPARATOR "♥☻☻♥") AS pcont_contname
                    FROM `post_countries` 	AS t1
                    LEFT JOIN `pic3pic_countries`	AS t2 ON t2.`id` = t1.`country_id`
                    WHERE t1.`status_id` = 4
                    AND t2.`status_id` = 4
                    GROUP BY(t1.`post_id`)
                    ORDER BY(t1.`post_id`)
                ) AS t2 ON t2.`post_id` = t1.`id`
                /*Post User*/
                INNER JOIN (
                    SELECT 
                        ad.`id` AS posterid,
                        ad.`user_name` AS postername,
                        ad.`email` AS posteremail,
                        ad.`cell_number` AS postercell,
                        CASE WHEN ad.`icon` IS NULL OR ad.`icon`  = "" OR ph1.`ver3` IS NULL OR ph1.`ver3` = ""
                        THEN "' . $this->config["DEFAULT_USER_ICON_IMG"] . '"
                        ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver3`)
                        END AS posterpic
                    FROM `user_profile` AS ad
                    LEFT JOIN `photo` AS ph1 ON ad.`icon` = ph1.`id` 
                    WHERE ad.`status_id` = 4
                ) AS up ON up.`posterid` = t1.`user_id` 
                /*Post Report*/
                LEFT JOIN (
                    SELECT
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS pr_id, t1.`post_id`, GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS pr_uid, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS pr_time,
                        GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS pr_repid, GROUP_CONCAT(t2.`report_name`  SEPARATOR "♥☻☻♥") AS pr_repname,
                        GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻☻♥") AS pr_uname
                    FROM `post_report` 			AS t1
                    LEFT JOIN `report`			AS t2 ON t2.`id` = t1.`report_id`
                    LEFT JOIN `user_profile`	AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 4
                    AND t2.`status_id` = 4
                    AND up.`status_id` = 4
                    GROUP BY(t1.`post_id`)
                    ORDER BY(t1.`post_id`)
                ) AS t3 ON t3.`post_id` = t1.`id`
                /*Post Preferences*/
                LEFT JOIN (
                    SELECT
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS pp_id, t1.`post_id`, GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS pp_uid, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS pp_time,
                        GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS pp_preid, GROUP_CONCAT(t2.`preferences` SEPARATOR "♥☻☻♥") AS pp_pref,
                        GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻☻♥") AS pp_uname
                    FROM `post_preferences` 	AS t1
                    LEFT JOIN `preferences`		AS t2 ON t2.`id` = t1.`preferences_id`
                    LEFT JOIN `user_profile`	AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 4
                    AND t2.`status_id` = 4
                    AND up.`status_id` = 4
                    GROUP BY(t1.`post_id`)
                    ORDER BY(t1.`post_id`)
                ) AS t4 ON t4.`post_id` = t1.`id`
                /*Post Likes*/
                LEFT JOIN (
                    SELECT 
                        COUNT(t1.`id`) AS lk_p_ct,
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS lk_p_id, t1.`post_id`, GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS lk_p_uid, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS lk_p_time,
                        GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻☻♥") AS lk_p_uname
                    FROM `post_likes` 			AS t1
                    LEFT JOIN `user_profile` 	AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 36
                    AND up.`status_id` = 4
                    GROUP BY(t1.`post_id`)
                    ORDER BY(t1.`post_id`)
                ) AS t5 ON t5.`post_id` = t1.`id`
                /*Post Comments*/
                LEFT JOIN (
                SELECT
                    t1.`post_id`,
                    COUNT(t1.`id`) AS pc_ct,
                    GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS pc_id, 
                    GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻☻♥") AS pc_uid, 
                    GROUP_CONCAT(TRIM(t1.`comment`) SEPARATOR "♥☻☻♥") AS comments, 
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
                    GROUP_CONCAT(t4.`reply` SEPARATOR "♥☻☻♥") AS reply, 
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
                    GROUP_CONCAT(t4.`lk_replyer_id` SEPARATOR "♥☻☻♥") AS lk_replyer_id, 
                    GROUP_CONCAT(t4.`lk_replytime` SEPARATOR "♥☻☻♥") AS lk_replytime, 
                    GROUP_CONCAT(t4.`lk_replyer_name` SEPARATOR "♥☻☻♥") AS lk_replyer_name, 
                    
                    GROUP_CONCAT(t4.`pcr_phid` SEPARATOR "♥☻☻♥") AS pcr_phid, 
                    GROUP_CONCAT(t4.`pcr_ph` SEPARATOR "♥☻☻♥") AS pcr_ph, 
                    GROUP_CONCAT(t4.`pcr_pv1` SEPARATOR "♥☻☻♥") AS pcr_pv1, 
                    GROUP_CONCAT(t4.`pcr_pv2` SEPARATOR "♥☻☻♥") AS pcr_pv2, 
                    GROUP_CONCAT(t4.`pcr_pv3` SEPARATOR "♥☻☻♥") AS pcr_pv3,  
                    GROUP_CONCAT(t4.`pcr_pv4` SEPARATOR "♥☻☻♥") AS pcr_pv4,  
                    GROUP_CONCAT(t4.`pcr_pv5` SEPARATOR "♥☻☻♥") AS pcr_pv5, 
                    
                    GROUP_CONCAT(t4.`replyererid` SEPARATOR "♥☻☻♥") AS replyererid,
                    GROUP_CONCAT(t4.`replyername` SEPARATOR "♥☻☻♥") AS replyername,
                    GROUP_CONCAT(t4.`replyeremail` SEPARATOR "♥☻☻♥") AS replyeremail,
                    GROUP_CONCAT(t4.`replyercell` SEPARATOR "♥☻☻♥") AS replyercell,
                    GROUP_CONCAT(t4.`replyerpic` SEPARATOR "♥☻☻♥") AS replyerpic,
                    GROUP_CONCAT(up.`commentererid` SEPARATOR "♥☻☻♥") AS  commentererid,
                    GROUP_CONCAT(up.`commentername` SEPARATOR "♥☻☻♥") AS  commentername,
                    GROUP_CONCAT(up.`commenteremail` SEPARATOR "♥☻☻♥") AS  commenteremail,
                    GROUP_CONCAT(up.`commentercell` SEPARATOR "♥☻☻♥") AS  commentercell,
                    GROUP_CONCAT(up.`commenterpic` SEPARATOR "♥☻☻♥") AS  commenterpic
                FROM `post_comments` 					AS t1
                /*Post Comments User*/
                INNER JOIN (
                    SELECT 
                        ad.`id` AS commentererid,
                        ad.`user_name` AS commentername,
                        ad.`email` AS commenteremail,
                        ad.`cell_number` AS commentercell,
                        CASE WHEN ad.`icon` IS NULL OR ad.`icon`  = "" OR ph1.`ver3` IS NULL OR ph1.`ver3` = ""
                        THEN "' . $this->config["DEFAULT_USER_ICON_IMG"] . '"
                        ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver3`)
                        END AS commenterpic
                    FROM `user_profile` AS ad
                    LEFT JOIN `photo` AS ph1 ON ad.`icon` = ph1.`id`
                    WHERE ad.`status_id` = 4
                    AND ad.`status_id` = 4
                ) AS up ON up.`commentererid` = t1.`user_id`
                /*Post Comments Preferences*/
                LEFT JOIN (
                    SELECT
                            GROUP_CONCAT(t1.`id` SEPARATOR "♥☻♥") AS pcp_id,
                            t1.`post_comments_id`,
                            GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻♥") AS pcp_uid,
                            GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻♥") AS pcp_time,
                            GROUP_CONCAT(t2.`id` SEPARATOR "♥☻♥") AS pcp_preid,
                            GROUP_CONCAT(t2.`preferences` SEPARATOR "♥☻♥") AS pcp_pref,
                            GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻♥") AS pcp_uname
                    FROM `post_comments_preferences` 	AS t1
                    LEFT JOIN `preferences`				AS t2 ON t2.`id` = t1.`preferences_id`
                    LEFT JOIN `user_profile`			AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 4
                    AND t2.`status_id` = 4
                    AND up.`status_id` = 4
                    GROUP BY(t1.`post_comments_id`)
                    ORDER BY(t1.`post_comments_id`)
                )AS t2 ON t2.`post_comments_id` = t1.`id`
                /*Post Comments Likes*/
                LEFT JOIN (
                    SELECT
                        COUNT(t1.`id`) AS lk_pc_ct,
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻♥") AS lk_pc_id, 
                        GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻♥") AS pc_time,
                        t1.`post_comments_id`, 
                        GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻♥") AS lk_pc_uid, 
                        GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻♥") AS lk_pc_time,
                        GROUP_CONCAT(up.`user_name` SEPARATOR "♥☻♥") AS lk_pc_uname
                    FROM `post_comments_likes` 	AS t1
                    LEFT JOIN `user_profile` 	AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 36
                    AND up.`status_id` = 4
                    GROUP BY(t1.`post_comments_id`)
                    ORDER BY(t1.`post_comments_id`)
                ) AS t3 ON t3.`post_comments_id` = t1.`id`
                /*Post Comments Reply*/
                LEFT JOIN (
                    SELECT
                        COUNT(t1.`id`) AS pcr_ct,
                        GROUP_CONCAT(t1.`id` SEPARATOR "♥☻♥") AS pcr_id, 
                        t1.`post_comments_id` AS pcr_pc_id, 
                        GROUP_CONCAT(t1.`user_id` SEPARATOR "♥☻♥") AS pcr_uid, 
                        GROUP_CONCAT(TRIM(t1.`reply`) SEPARATOR "♥☻♥") AS reply, 
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
                        GROUP_CONCAT(t3.`lk_replyer_id` SEPARATOR "♥☻♥") AS lk_replyer_id,
                        GROUP_CONCAT(t3.`lk_replytime` SEPARATOR "♥☻♥") AS lk_replytime,
                        GROUP_CONCAT(t3.`lk_replyer_name` SEPARATOR "♥☻♥") AS lk_replyer_name,
                        GROUP_CONCAT(t3.`lk_rep_ct` SEPARATOR "♥☻♥") AS lk_rep_ct,
                        
                        GROUP_CONCAT(up.`replyererid` SEPARATOR "♥☻♥") AS replyererid,
                        GROUP_CONCAT(up.`replyername` SEPARATOR "♥☻♥") AS replyername,
                        GROUP_CONCAT(up.`replyeremail` SEPARATOR "♥☻♥") AS replyeremail,
                        GROUP_CONCAT(up.`replyercell` SEPARATOR "♥☻♥") AS replyercell,
                        GROUP_CONCAT(up.`replyerpic` SEPARATOR "♥☻♥") AS replyerpic
                    FROM `post_comments_reply` 						AS t1
                    /*Post Comments Reply User*/
                    INNER JOIN (
                        SELECT 
                            ad.`id` AS replyererid,
                            ad.`user_name` AS replyername,
                            ad.`email` AS replyeremail,
                            ad.`cell_number` AS replyercell,
                            CASE WHEN ad.`icon` IS NULL OR ad.`icon`  = "" OR ph1.`ver3` IS NULL OR ph1.`ver3` = ""
                            THEN "' . $this->config["DEFAULT_USER_ICON_IMG"] . '"
                            ELSE CONCAT("' . $this->config["URL"] . '",ph1.`ver3`)
                            END AS replyerpic
                        FROM `user_profile` AS ad
                        LEFT JOIN `photo` AS ph1 ON ad.`icon` = ph1.`id`
                        WHERE ad.`status_id` = 4
                    )AS up ON up.`replyererid` = t1.`user_id`
                    /*Post Comments Reply Preferences*/
                    LEFT JOIN (
                        SELECT
                            GROUP_CONCAT(t1.`id` SEPARATOR "♥♥") AS pcrp_id, 
                            t1.`post_comments_reply_id`, 
                            GROUP_CONCAT(t1.`user_id` SEPARATOR "♥♥") AS pcrp_uid, 
                            GROUP_CONCAT(t1.`created_at` SEPARATOR "♥♥") AS pcrp_time, 
                            GROUP_CONCAT(t2.`id` SEPARATOR "♥♥") AS pcrp_preid, 
                            GROUP_CONCAT(t2.`preferences` SEPARATOR "♥♥") AS pcrp_pref, 
                            GROUP_CONCAT(up.`user_name` SEPARATOR "♥♥") AS pcrp_uname
                        FROM `post_comments_reply_preferences` 	AS t1
                        LEFT JOIN `preferences`					AS t2 ON t2.`id` = t1.`preferences_id`
                        LEFT JOIN `user_profile`				AS up ON up.`id` = t1.`user_id`
                        WHERE t1.`status_id` = 4
                        AND t2.`status_id` = 4
                        AND up.`status_id` = 4
                        GROUP BY(t1.`post_comments_reply_id`)
                        ORDER BY(t1.`post_comments_reply_id`)
                    ) AS t2 ON t2.`post_comments_reply_id` = t1.`id`
                    /*Post Comments Reply Likes*/
                    LEFT JOIN (
                            SELECT
                                GROUP_CONCAT(t1.`id` SEPARATOR "♥♥") AS lk_rep_id, 
                                COUNT(t1.`id`) AS lk_rep_ct,
                                t1.`post_comments_reply_id`, 
                                GROUP_CONCAT(t1.`user_id` SEPARATOR "♥♥") AS lk_replyer_id, 
                                GROUP_CONCAT(t1.`created_at` SEPARATOR "♥♥") AS lk_replytime, 
                                GROUP_CONCAT(up.`user_name` SEPARATOR "♥♥") AS lk_replyer_name
                        FROM `post_comments_reply_likes` AS t1
                       LEFT JOIN `user_profile` 		AS up ON up.`id` = t1.`user_id`
                       WHERE t1.`status_id` = 36
                       AND up.`status_id` = 4
                       GROUP BY(t1.`post_comments_reply_id`)
                       ORDER BY(t1.`post_comments_reply_id`)
                    ) AS t3 ON t3.`post_comments_reply_id` = t1.`id`
                    WHERE t1.`status_id` = 4
                    GROUP BY(t1.`post_comments_id`)
                    ORDER BY(t1.`post_comments_id`)
                ) AS t4 ON t4.`pcr_pc_id` = t1.`id`
                WHERE t1.`status_id` = 4
                GROUP BY(t1.`post_id`)
                ORDER BY(t1.`post_id`)
                ) AS t6 ON t6.`post_id` = t1.`id`
                /*Post Languages*/
                LEFT JOIN (
                        SELECT
                                GROUP_CONCAT(t1.`id` SEPARATOR "♥☻☻♥") AS plng_id, t1.`post_id`, GROUP_CONCAT(t1.`created_at` SEPARATOR "♥☻☻♥") AS plng_time,
                                GROUP_CONCAT(t2.`id` SEPARATOR "♥☻☻♥") AS plng_lngid, GROUP_CONCAT(t2.`Language Name` SEPARATOR "♥☻☻♥") AS plng_lngname
                        FROM `post_languages` 	AS t1
                        LEFT JOIN `pic3pic_languages`	AS t2 ON t2.`id` = t1.`languages_id`
                        WHERE t1.`status_id` = 4
                        AND t2.`status_id` = 4
                        GROUP BY(t1.`post_id`)
                        ORDER BY(t1.`post_id`)
                ) AS t7 ON t7.`post_id` = t1.`id`
                /*Post Sections*/
                LEFT JOIN (
                        SELECT
                            t1.`id` AS ps_id, 
                            t1.`post_id`,
                            t1.`created_at` AS ps_time,
                            t2.`id` AS ps_secid,
                            TRIM(t2.`section_name`) AS pr_secname
                        FROM `post_section` 	AS t1
                        LEFT JOIN `sections`	AS t2 ON t2.`id` = t1.`section_id`
                        WHERE t1.`status_id` = 4
                        AND t2.`status_id` = 4
                ) AS t8 ON t8.`post_id` = t1.`id`
                /*Post Photo*/
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
                /* Post Channel */
                LEFT JOIN (
                    SELECT
                        t1.`id` AS chwaid,
                        t1.`channel_id` AS chwacid,
                        t1.`user_id` AS chwauid,
                        t1.`post_id` AS chwapost_id,
                        t1.`created_at` AS chwatime,
                        t2.`channel_name`,
                        t2.`channel_description`,
                        t2.`channel_location`,
                        t2.`channel_language`,
                        t2.`channel_icon`,
                        t2.`channel_background`,
                        t2.`channel_created_at`,
                        t2.`channel_updated_at`,
                        t2.`channel_website`
                    FROM `channel_wall` AS t1
                    LEFT JOIN `channel`	AS t2 ON t2.`id` = t1.`channel_id`
                    LEFT JOIN `user_profile` AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 4
                    AND t2.`status_id` = 4
                    AND up.`status_id` = 4
                ) AS t10 ON t10.`chwapost_id` = t1.`id`
                LEFT JOIN (
                    SELECT
                        t1.`id` AS chsubid,
                        t1.`channel_id` AS chsubcid,
                        t1.`user_id` AS chsubuid,
                        t1.`created_at` AS chsubtime
                    FROM `channel_subscribe` AS t1
                    LEFT JOIN `channel`	AS t2 ON t2.`id` = t1.`channel_id`
                    LEFT JOIN `user_profile` AS up ON up.`id` = t1.`user_id`
                    WHERE t1.`status_id` = 4
                    AND up.`status_id` = 4
                    AND t1.`user_id` = "' . mysql_real_escape_string($this->UserId) . '"
                ) AS t11 ON t11.`chsubcid` = t10.`chwacid`
                WHERE t1.`status_id` = 4
                ORDER BY(t1.`id`) DESC
                /*Post Ends*/');
        $res = $stm->execute();
        $newRes = array();
        $delimiters = array("♥☻☻♥", "♥☻♥");
        $delimiters1 = array("♥☻☻♥", "♥☻♥", "♥♥");
        if ($res) {
            $result = $stm->fetchAll();
            for ($i = 0; $i < $stm->rowCount() && isset($result[$i]["id"]) && $result[$i]["id"] != NULL; $i++) {
                array_push($newRes, array(
                    "posts" => array(
                        //"post_ct" => (integer) $result[$i]["post_ct"],
                        "id" => (integer) $result[$i]["id"],
                        "title" => $result[$i]["title"],
                        "photo_id" => (integer) $result[$i]["photo_id"],
                        "section_id" => (integer) $result[$i]["section_id"],
                        "user_id" => (integer) $result[$i]["user_id"],
                        "created_at" => $result[$i]["created_at"],
                        "posterid" => (integer) $result[$i]["posterid"],
                        "postername" => $result[$i]["postername"],
                        "posteremail" => $result[$i]["posteremail"],
                        "postercell" => $result[$i]["postercell"],
                        "posterpic" => $result[$i]["posterpic"],
                        "p_pic_flag" => $result[$i]["p_pic_flag"],
                        "lk_p_ct" => (integer) $result[$i]["lk_p_ct"],
                        "pc_ct" => (integer) $result[$i]["pc_ct"],
                        "chwaid" => (integer) $result[$i]["chwaid"],
                        "chwauid" => (integer) $result[$i]["chwauid"],
                        "chwacid" => (integer) $result[$i]["chwacid"],
                        "chwapost_id" => (integer) $result[$i]["chwapost_id"],
                        "chwatime" => $result[$i]["chwatime"],
                        "chsubid" => isset($result[$i]["chsubid"]) ? (integer) $result[$i]["chsubid"] : 0,
                        "chsubcid" => isset($result[$i]["chsubcid"]) ? (integer) $result[$i]["chsubcid"] : 0,
                        "chsubuid" => isset($result[$i]["chsubuid"]) ? (integer) $result[$i]["chsubuid"] : 0,
                        "chsubtime" => isset($result[$i]["chsubtime"]) ? $result[$i]["chsubtime"] : '',
                        "channel_name" => $result[$i]["channel_name"],
                        "photo" => array(
                            "p_phid" => $result[$i]['p_phid'],
                            "p_ph" => $result[$i]['p_ph'],
                            "p_pv1" => $result[$i]['p_pv1'],
                            "p_pv2" => $result[$i]['p_pv2'],
                            "p_pv3" => $result[$i]['p_pv3'],
                            "p_pv4" => $result[$i]['p_pv4'],
                            "p_pv5" => $result[$i]['p_pv5'],
                        ),
                        "post_location" => array(
                            "post_location" => $result[$i]["post_location"],
                            "pcont_id" => explode("♥☻☻♥", $result[$i]['pcont_id']),
                            "pcont_time" => explode("♥☻☻♥", $result[$i]['pcont_time']),
                            "pcont_contid" => explode("♥☻☻♥", $result[$i]['pcont_contid']),
                            "pcont_contname" => explode("♥☻☻♥", $result[$i]['pcont_contname']),
                        ),
                        "report" => array(
                            "pr_uname" => explode("♥☻☻♥", $result[$i]['pr_uname']),
                            "pr_id" => explode("♥☻☻♥", $result[$i]['pr_id']),
                            "pr_uid" => explode("♥☻☻♥", $result[$i]['pr_uid']),
                            "pr_time" => explode("♥☻☻♥", $result[$i]['pr_time']),
                            "pr_repid" => explode("♥☻☻♥", $result[$i]['pr_repid']),
                            "pr_repname" => explode("♥☻☻♥", $result[$i]['pr_repname']),
                        ),
                        "preference" => array(
                            "pp_uname" => explode("♥☻☻♥", $result[$i]['pp_uname']),
                            "pp_id" => explode("♥☻☻♥", $result[$i]['pp_id']),
                            "pp_uid" => explode("♥☻☻♥", $result[$i]['pp_uid']),
                            "pp_time" => explode("♥☻☻♥", $result[$i]['pp_time']),
                            "pp_preid" => explode("♥☻☻♥", $result[$i]['pp_preid']),
                            "pp_pref" => explode("♥☻☻♥", $result[$i]['pp_pref']),
                        ),
                        "likes" => array(
                            "lk_p_uname" => explode("♥☻☻♥", $result[$i]['lk_p_uname']),
                            "lk_p_id" => explode("♥☻☻♥", $result[$i]['lk_p_id']),
                            "lk_p_uid" => explode("♥☻☻♥", $result[$i]['lk_p_uid']),
                            "lk_p_time" => explode("♥☻☻♥", $result[$i]['lk_p_time']),
                        ),
                        "sections" => array(
                            "ps_id" => $result[$i]['ps_id'],
                            "ps_time" => $result[$i]['ps_time'],
                            "ps_secid" => $result[$i]['ps_secid'],
                            "pr_secname" => $result[$i]['pr_secname'],
                        ),
                        "languages" => array(
                            "plng_id" => explode("♥☻☻♥", $result[$i]['plng_id']),
                            "plng_time" => explode("♥☻☻♥", $result[$i]['plng_time']),
                            "plng_lngid" => explode("♥☻☻♥", $result[$i]['plng_lngid']),
                            "plng_lngname" => explode("♥☻☻♥", $result[$i]['plng_lngname']),
                        ),
                        "comments" => array(
                            "pc_id" => explode("♥☻☻♥", $result[$i]['pc_id']),
                            "pc_uid" => explode("♥☻☻♥", $result[$i]['pc_uid']),
                            "commentererid" => explode("♥☻☻♥", $result[$i]['commentererid']),
                            "commentername" => explode("♥☻☻♥", $result[$i]['commentername']),
                            "commenteremail" => explode("♥☻☻♥", $result[$i]['commenteremail']),
                            "commentercell" => explode("♥☻☻♥", $result[$i]['commentercell']),
                            "commenterpic" => explode("♥☻☻♥", $result[$i]['commenterpic']),
                            "comments" => explode("♥☻☻♥", $result[$i]['comments']),
                            "pc_phid" => explode("♥☻☻♥", $result[$i]['pc_phid']),
                            "pc_ph" => explode("♥☻☻♥", $result[$i]['pc_ph']),
                            "pc_pv1" => explode("♥☻☻♥", $result[$i]['pc_pv1']),
                            "pc_pv2" => explode("♥☻☻♥", $result[$i]['pc_pv2']),
                            "pc_pv3" => explode("♥☻☻♥", $result[$i]['pc_pv3']),
                            "pc_pv4" => explode("♥☻☻♥", $result[$i]['pc_pv4']),
                            "pc_pv5" => explode("♥☻☻♥", $result[$i]['pc_pv5']),
                            "pc_pic_flag" => explode("♥☻☻♥", $result[$i]['pc_pic_flag']),
                            "pc_time" => explode("♥☻☻♥", $result[$i]['pc_time']),
                            "pcp_id" => $this->multiExplode($delimiters, $result[$i]['pcp_id']),
                            "pcp_uid" => $this->multiExplode($delimiters, $result[$i]['pcp_uid']),
                            "pcp_time" => $this->multiExplode($delimiters, $result[$i]['pcp_time']),
                            "pcp_preid" => $this->multiExplode($delimiters, $result[$i]['pcp_preid']),
                            "pcp_pref" => $this->multiExplode($delimiters, $result[$i]['pcp_pref']),
                            "pcp_uname" => $this->multiExplode($delimiters, $result[$i]['pcp_uname']),
                            "lk_pc_ct" => explode("♥☻☻♥", $result[$i]['lk_pc_ct']),
                            "lk_pc_id" => $this->multiExplode($delimiters, $result[$i]['lk_pc_id']),
                            "lk_pc_uid" => $this->multiExplode($delimiters, $result[$i]['lk_pc_uid']),
                            "lk_pc_time" => $this->multiExplode($delimiters, $result[$i]['lk_pc_time']),
                            "lk_pc_uname" => $this->multiExplode($delimiters, $result[$i]['lk_pc_uname']),
                            "replys" => array(
                                "pcr_ct" => explode("♥☻☻♥", $result[$i]['pcr_ct']),
                                "pcr_id" => $this->multiExplode($delimiters, $result[$i]['pcr_id']),
                                "pcr_uid" => $this->multiExplode($delimiters, $result[$i]['pcr_uid']),
                                "reply" => $this->multiExplode($delimiters, $result[$i]['reply']),
                                "replyererid" => $this->multiExplode($delimiters, $result[$i]['replyererid']),
                                "replyername" => $this->multiExplode($delimiters, $result[$i]['replyername']),
                                "replyeremail" => $this->multiExplode($delimiters, $result[$i]['replyeremail']),
                                "replyercell" => $this->multiExplode($delimiters, $result[$i]['replyercell']),
                                "replyerpic" => $this->multiExplode($delimiters, $result[$i]['replyerpic']),
                                "pcr_time" => $this->multiExplode($delimiters, $result[$i]['pcr_time']),
                                "pcr_pic_flag" => $this->multiExplode($delimiters, $result[$i]['pcr_pic_flag']),
                                "pcr_phid" => $this->multiExplode($delimiters, $result[$i]['pcr_phid']),
                                "pcr_ph" => $this->multiExplode($delimiters, $result[$i]['pcr_ph']),
                                "pcr_pv1" => $this->multiExplode($delimiters, $result[$i]['pcr_pv1']),
                                "pcr_pv2" => $this->multiExplode($delimiters, $result[$i]['pcr_pv2']),
                                "pcr_pv3" => $this->multiExplode($delimiters, $result[$i]['pcr_pv3']),
                                "pcr_pv4" => $this->multiExplode($delimiters, $result[$i]['pcr_pv4']),
                                "pcr_pv5" => $this->multiExplode($delimiters, $result[$i]['pcr_pv5']),
                                "lk_rep_ct" => $this->multiExplode($delimiters, $result[$i]['lk_rep_ct']),
                                "pcrp_id" => $this->multiExplode($delimiters1, $result[$i]['pcrp_id']),
                                "pcrp_uid" => $this->multiExplode($delimiters1, $result[$i]['pcrp_uid']),
                                "pcrp_time" => $this->multiExplode($delimiters1, $result[$i]['pcrp_time']),
                                "pcrp_preid" => $this->multiExplode($delimiters1, $result[$i]['pcrp_preid']),
                                "pcrp_pref" => $this->multiExplode($delimiters1, $result[$i]['pcrp_pref']),
                                "pcrp_uname" => $this->multiExplode($delimiters1, $result[$i]['pcrp_uname']),
                                "lk_rep_id" => $this->multiExplode($delimiters1, $result[$i]['lk_rep_id']),
                                "lk_replyer_id" => $this->multiExplode($delimiters1, $result[$i]['lk_replyer_id']),
                                "lk_replytime" => $this->multiExplode($delimiters1, $result[$i]['lk_replytime']),
                                "lk_replyer_name" => $this->multiExplode($delimiters1, $result[$i]['lk_replyer_name']),
                            ),
                        ),
                    )
                ));
            }
            $data["count"] = $stm->rowCount();
            $data["status"] = "success";
        }
        if (count($newRes) > 0) {
            $_SESSION["ListNewPost"] = $newRes;
            //echo print_r($newRes[2]);
        }
        return $newRes;
    }
    public function likePost($param = false) {
        $jsondata = array(
            "count" => $this->LikePostCount($param),
            "post_id" => 0,
            "stat" => 36,
            "status" => 'error',
        );
        $res1 = '';
        $query = 'SELECT `id` FROM `post_likes` WHERE `status_id` = :stat AND `user_id` = :uid AND `post_id` = :postid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => $jsondata["stat"],
            ":postid" => mysql_real_escape_string($param),
            ":uid" => mysql_real_escape_string($this->UserId),
        ));
        $count = $stm->rowCount();
        if ($count === 0) {
            $query = 'SELECT `id` FROM `post_likes` WHERE `status_id` = :stat AND `user_id` = :uid AND `post_id` = :postid;';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":stat" => 37,
                ":postid" => mysql_real_escape_string($param),
                ":uid" => mysql_real_escape_string($this->UserId),
            ));
            $count = $stm->rowCount();
            if ($count > 0) {
                $this->db->beginTransaction();
                $query1 = 'UPDATE `post_likes` SET `status_id` = :stat, `created_at`:= :doc WHERE `post_id` = :postid AND `user_id` = :uid;';
                $stm = $this->db->prepare($query1);
                $res1 = $stm->execute(array(
                    ":stat" => $jsondata["stat"],
                    ":doc" => date("Y-m-d H:i:s"),
                    ":postid" => mysql_real_escape_string($param),
                    ":uid" => mysql_real_escape_string($this->UserId),
                ));
            } else {
                $this->db->beginTransaction();
                $query1 = 'INSERT INTO  `post_likes` (`id`,`post_id`,`user_id`,`created_at`,`status_id`) VALUES(:id,:postid,:uid,:doc,:stat);';
                $stm = $this->db->prepare($query1);
                $res1 = $stm->execute(array(
                    ":id" => NULL,
                    ":postid" => mysql_real_escape_string($param),
                    ":uid" => mysql_real_escape_string($this->UserId),
                    ":doc" => date("Y-m-d H:i:s"),
                    ":stat" => $jsondata["stat"],
                ));
            }
            if ($res1) {
                $this->db->commit();
                $jsondata["status"] = "success";
                $jsondata["count"] = $this->LikePostCount($param);
                $jsondata["post_id"] = $param;
            } else
                $this->db->rollBack();
        }
        return $jsondata;
    }
    public function disLikePost($param = false) {
        $jsondata = array(
            "count" => $this->LikePostCount($param),
            "post_id" => 0,
            "stat" => 37,
            "status" => 'error',
        );
        $res1 = '';
        $query = 'SELECT `id` FROM `post_likes` WHERE `status_id` = :stat AND `user_id` = :uid AND `post_id` = :postid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => $jsondata["stat"],
            ":postid" => mysql_real_escape_string($param),
            ":uid" => mysql_real_escape_string($this->UserId),
        ));
        $count = $stm->rowCount();
        if ($count === 0) {
            $query = 'SELECT `id` FROM `post_likes` WHERE `status_id` = :stat AND `user_id` = :uid AND `post_id` = :postid;';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":stat" => 36,
                ":postid" => mysql_real_escape_string($param),
                ":uid" => mysql_real_escape_string($this->UserId),
            ));
            $count = $stm->rowCount();
            if ($count > 0) {
                $this->db->beginTransaction();
                $query1 = 'UPDATE `post_likes` SET `status_id`  = :stat, `created_at`:= :doc WHERE `post_id` = :postid AND `user_id` = :uid;';
                $stm = $this->db->prepare($query1);
                $res1 = $stm->execute(array(
                    ":stat" => $jsondata["stat"],
                    ":doc" => date("Y-m-d H:i:s"),
                    ":postid" => mysql_real_escape_string($param),
                    ":uid" => mysql_real_escape_string($this->UserId),
                ));
            } else {
                $this->db->beginTransaction();
                $query1 = 'INSERT INTO  `post_likes` (`id`,`post_id`,`user_id`,`created_at`,`status_id`) VALUES(:id,:postid,:uid,:doc,:stat);';
                $stm = $this->db->prepare($query1);
                $res1 = $stm->execute(array(
                    ":id" => NULL,
                    ":postid" => mysql_real_escape_string($param),
                    ":uid" => mysql_real_escape_string($this->UserId),
                    ":doc" => date("Y-m-d H:i:s"),
                    ":stat" => $jsondata["stat"],
                ));
            }
            if ($res1) {
                $this->db->commit();
                $jsondata["status"] = "success";
                $jsondata["count"] = $this->LikePostCount($param);
                $jsondata["post_id"] = $param;
            } else
                $this->db->rollBack();
        }
        return $jsondata;
    }
    public function changePostPreferences($param = false) {
        $jsondata = array(
            "count" => 0,
            "post_id" => 0,
            "stat" => $this->postBaseData["para"]["prefID"],
            "status" => 'error',
        );
        $res1 = '';
        $query = 'SELECT `id` FROM `post` WHERE `status_id` = :stat AND `user_id` = :uid AND `id` = :postid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => $jsondata["stat"],
            ":uid" => mysql_real_escape_string($this->UserId),
            ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
        ));
        $count = $stm->rowCount();
        if ($count > 0) {
            $this->db->beginTransaction();
            $query1 = 'UPDATE `post` SET `status_id` = :stat WHERE `id` = :postid AND `user_id` = :uid;';
            $stm = $this->db->prepare($query1);
            $res1 = $stm->execute(array(
                ":stat" => $jsondata["stat"],
                ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
                ":uid" => mysql_real_escape_string($this->UserId),
            ));
        } else {
            $query = 'SELECT `id` FROM `post` WHERE `status_id` = :stat AND `user_id` != :uid AND `id` = :postid;';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":stat" => 4,
                ":uid" => mysql_real_escape_string($this->UserId),
                ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
            ));
            $count = $stm->rowCount();
            if ($count > 0) {
                $query = 'SELECT `id` FROM `post_preferences` WHERE `preferences_id` = :prefId AND `user_id` = :uid AND `post_id` = :postid;';
                $stm = $this->db->prepare($query);
                $res = $stm->execute(array(
                    ":prefId" => $jsondata["stat"],
                    ":uid" => mysql_real_escape_string($this->UserId),
                    ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
                ));
                $count = $stm->rowCount();
                if ($count == 0) {
                    $this->db->beginTransaction();
                    $query1 = 'INSERT INTO  `post_preferences` (`id`,`post_id`,`user_id`,`preferences_id`,`created_at`,`status_id`) VALUES(:id,:postid,:uid,:prefId,:doc,:stat);';
                    $stm = $this->db->prepare($query1);
                    $res1 = $stm->execute(array(
                        ":id" => NULL,
                        ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
                        ":uid" => mysql_real_escape_string($this->UserId),
                        ":prefId" => mysql_real_escape_string($this->postBaseData["para"]["prefID"]),
                        ":doc" => date("Y-m-d H:i:s"),
                        ":stat" => 4,
                    ));
                } else {
                    $this->db->beginTransaction();
                    $query1 = 'UPDATE `post_preferences` SET `preferences_id` = :prefId WHERE `post_id` = :postid AND `user_id` = :uid;';
                    $stm = $this->db->prepare($query1);
                    $res1 = $stm->execute(array(
                        ":prefId" => mysql_real_escape_string($this->postBaseData["para"]["prefID"]),
                        ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
                        ":uid" => mysql_real_escape_string($this->UserId),
                    ));
                }
            }
        }
        if ($res1) {
            $this->db->commit();
            $jsondata["status"] = "success";
            $jsondata["count"] = 0;
            $jsondata["post_id"] = $this->postBaseData["para"]["postID"];
        } else
            $this->db->rollBack();
        return $jsondata;
    }
    public function reportPost($param = false) {
        $jsondata = array(
            "count" => 0,
            "post_id" => 0,
            "stat" => $this->postBaseData["para"]["reportID"],
            "status" => 'error',
        );
        $res1 = '';
        $query = 'SELECT `id` FROM `post_report` WHERE `report_id` = :prefId AND `user_id` = :uid AND `post_id` = :postid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":prefId" => $jsondata["stat"],
            ":uid" => mysql_real_escape_string($this->UserId),
            ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
        ));
        $count = $stm->rowCount();
        if ($count == 0) {
            $this->db->beginTransaction();
            $query1 = 'INSERT INTO  `post_report` (`id`,`post_id`,`user_id`,`report_id`,`created_at`,`status_id`) VALUES(:id,:postid,:uid,:prefId,:doc,:stat);';
            $stm = $this->db->prepare($query1);
            $res1 = $stm->execute(array(
                ":id" => NULL,
                ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
                ":uid" => mysql_real_escape_string($this->UserId),
                ":prefId" => mysql_real_escape_string($this->postBaseData["para"]["reportID"]),
                ":doc" => date("Y-m-d H:i:s"),
                ":stat" => 4,
            ));
        } else {
            $this->db->beginTransaction();
            $query1 = 'UPDATE `post_report` SET `report_id` = :prefId WHERE `post_id` = :postid AND `user_id` = :uid;';
            $stm = $this->db->prepare($query1);
            $res1 = $stm->execute(array(
                ":prefId" => mysql_real_escape_string($this->postBaseData["para"]["reportID"]),
                ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
                ":uid" => mysql_real_escape_string($this->UserId),
            ));
        }
        if ($res1) {
            $this->db->commit();
            $jsondata["status"] = "success";
            $jsondata["count"] = 0;
            $jsondata["post_id"] = $this->postBaseData["para"]["postID"];
        } else
            $this->db->rollBack();
        return $jsondata;
    }
    public function subscribeChannel($param = false) {
        $jsondata = array(
            "count" => 0,
            "post_id" => 0,
            "stat" => 37,
            "status" => 'error',
        );
        return $jsondata;
    }
    public function addComment($param = false) {
        $jsondata = array(
            "count" => 0,
            "post_id" => 0,
            "stat" => 4,
            "status" => 'error',
        );
        if ($this->postBaseData["postID"] > 0) {
            $res1 = '';
            $background = NULL;
            $this->db->beginTransaction();
            if (isset($_SESSION['Individual_POST_PATH']) && is_array($_SESSION['Individual_POST_PATH'])) {
                $photo = (array) $_SESSION['Individual_POST_PATH']['respnse'];
                if ($photo["status"] === "success") {
                    $query1 = 'INSERT INTO  `photo` (`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`ver4`,`ver5`)  VALUES(:id,:orgpic,:ver1,:ver2,:ver3,:ver4,:ver5);';
                    $stm = $this->db->prepare($query1);
                    $res1 = $stm->execute(array(
                        ":id" => NULL,
                        ":orgpic" => $photo['original_pic'],
                        ":ver1" => $photo['version_1'],
                        ":ver2" => $photo['version_2'],
                        ":ver3" => $photo['version_3'],
                        ":ver4" => $photo['version_4'],
                        ":ver5" => $photo['version_5']
                    ));
                    $background = $this->db->lastInsertId();
                    unset($_SESSION['Individual_POST_PATH']);
                }
            }
            $query1 = 'INSERT INTO  `post_comments` (`id`,`post_id`,`user_id`,`comment`,`created_at`,`photo_id`,`status_id`) VALUES(:id,:postid,:uid,:cmt,:doc,:photo,:stat);';
            $stm = $this->db->prepare($query1);
            $res1 = $stm->execute(array(
                ":id" => NULL,
                ":postid" => mysql_real_escape_string($this->postBaseData["postID"]),
                ":uid" => mysql_real_escape_string($this->UserId),
                ":cmt" => mysql_real_escape_string(urldecode($this->postBaseData["comment"])),
                ":doc" => date("Y-m-d H:i:s"),
                ":photo" => mysql_real_escape_string($background),
                ":stat" => $jsondata["stat"],
            ));
            if ($res1)
                $this->db->commit();
            else
                $this->db->rollBack();
            if ($res1) {
                $jsondata["status"] = "success";
                $jsondata["count"] = $this->PostCommentCount($this->postBaseData["postID"]);
                $jsondata["post_id"] = $this->postBaseData["postID"];
            }
        }
        return $jsondata;
    }
    public function likePostComment($param = false) {
        $jsondata = array(
            "count" => $this->LikePostCommentCount($param),
            "post_id" => 0,
            "stat" => 36,
            "status" => 'error',
        );
        $res1 = '';
        $query = 'SELECT `id` FROM `post_comments_likes` WHERE `status_id` = :stat AND `user_id` = :uid AND `post_comments_id` = :postid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => $jsondata["stat"],
            ":postid" => mysql_real_escape_string($param),
            ":uid" => mysql_real_escape_string($this->UserId),
        ));
        $count = $stm->rowCount();
        if ($count === 0) {
            $query = 'SELECT `id` FROM `post_comments_likes` WHERE `status_id` = :stat AND `user_id` = :uid AND `post_comments_id` = :postid;';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":stat" => 37,
                ":postid" => mysql_real_escape_string($param),
                ":uid" => mysql_real_escape_string($this->UserId),
            ));
            $count = $stm->rowCount();
            if ($count > 0) {
                $this->db->beginTransaction();
                $query1 = 'UPDATE `post_comments_likes` SET `status_id` = :stat, `created_at`:= :doc WHERE `post_comments_id` = :postid AND `user_id` = :uid;';
                $stm = $this->db->prepare($query1);
                $res1 = $stm->execute(array(
                    ":stat" => $jsondata["stat"],
                    ":doc" => date("Y-m-d H:i:s"),
                    ":postid" => mysql_real_escape_string($param),
                    ":uid" => mysql_real_escape_string($this->UserId),
                ));
            } else {
                $this->db->beginTransaction();
                $query1 = 'INSERT INTO  `post_comments_likes` (`id`,`post_comments_id`,`user_id`,`created_at`,`status_id`) VALUES(:id,:postid,:uid,:doc,:stat);';
                $stm = $this->db->prepare($query1);
                $res1 = $stm->execute(array(
                    ":id" => NULL,
                    ":postid" => mysql_real_escape_string($param),
                    ":uid" => mysql_real_escape_string($this->UserId),
                    ":doc" => date("Y-m-d H:i:s"),
                    ":stat" => $jsondata["stat"],
                ));
            }
            if ($res1) {
                $jsondata["status"] = "success";
                $jsondata["count"] = $this->LikePostCommentCount($param);
                $jsondata["post_id"] = $param;
                $this->db->commit();
            } else
                $this->db->rollBack();
        }
        return $jsondata;
    }
    public function disLikePostComment($param = false) {
        $jsondata = array(
            "count" => 0,
            "post_id" => 0,
            "stat" => 37,
            "status" => 'error',
        );
        $res1 = '';
        $query = 'SELECT `id` FROM `post_comments_likes` WHERE `status_id` = :stat AND `user_id` = :uid AND `post_comments_id` = :postid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => $jsondata["stat"],
            ":postid" => mysql_real_escape_string($param),
            ":uid" => mysql_real_escape_string($this->UserId),
        ));
        $count = $stm->rowCount();
        if ($count === 0) {
            $query = 'SELECT `id` FROM `post_comments_likes` WHERE `status_id` = :stat AND `user_id` = :uid AND `post_comments_id` = :postid;';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":stat" => 36,
                ":postid" => mysql_real_escape_string($param),
                ":uid" => mysql_real_escape_string($this->UserId),
            ));
            $count = $stm->rowCount();
            if ($count > 0) {
                $this->db->beginTransaction();
                $query1 = 'UPDATE `post_comments_likes` SET `status_id`  = :stat, `created_at`:= :doc WHERE `post_comments_id` = :postid AND `user_id` = :uid;';
                $stm = $this->db->prepare($query1);
                $res1 = $stm->execute(array(
                    ":stat" => $jsondata["stat"],
                    ":doc" => date("Y-m-d H:i:s"),
                    ":postid" => mysql_real_escape_string($param),
                    ":uid" => mysql_real_escape_string($this->UserId),
                ));
            } else {
                $this->db->beginTransaction();
                $query1 = 'INSERT INTO  `post_comments_likes` (`id`,`post_comments_id`,`user_id`,`created_at`,`status_id`) VALUES(:id,:postid,:uid,:doc,:stat);';
                $stm = $this->db->prepare($query1);
                $res1 = $stm->execute(array(
                    ":id" => NULL,
                    ":postid" => mysql_real_escape_string($param),
                    ":uid" => mysql_real_escape_string($this->UserId),
                    ":doc" => date("Y-m-d H:i:s"),
                    ":stat" => $jsondata["stat"],
                ));
            }
            if ($res1) {
                $jsondata["status"] = "success";
                $jsondata["count"] = $this->LikePostCommentCount($param);
                $jsondata["post_id"] = $param;
                $this->db->commit();
            } else
                $this->db->rollBack();
        }
        return $jsondata;
    }
    public function changePostCommentPreferences($param = false) {
        $jsondata = array(
            "count" => 0,
            "post_id" => 0,
            "stat" => $this->postBaseData["para"]["prefID"],
            "status" => 'error',
        );
        $res1 = '';
        $query = 'SELECT `id` FROM `post_comments` WHERE `status_id` = :stat AND `user_id` = :uid AND `id` = :postid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => $jsondata["stat"],
            ":uid" => mysql_real_escape_string($this->UserId),
            ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
        ));
        $count = $stm->rowCount();
        if ($count > 0) {
            $this->db->beginTransaction();
            $query1 = 'UPDATE `post_comments` SET `status_id` = :stat WHERE `id` = :postid AND `user_id` = :uid;';
            $stm = $this->db->prepare($query1);
            $res1 = $stm->execute(array(
                ":stat" => $jsondata["stat"],
                ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
                ":uid" => mysql_real_escape_string($this->UserId),
            ));
        } else {
            $query = 'SELECT `id` FROM `post_comments` WHERE `status_id` = :stat AND `user_id` != :uid AND `id` = :postid;';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":stat" => 4,
                ":uid" => mysql_real_escape_string($this->UserId),
                ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
            ));
            $count = $stm->rowCount();
            if ($count > 0) {
                $query = 'SELECT `id` FROM `post_comments_preferences` WHERE `preferences_id` = :prefId AND `user_id` = :uid AND `post_comments_id` = :postid;';
                $stm = $this->db->prepare($query);
                $res = $stm->execute(array(
                    ":prefId" => $jsondata["stat"],
                    ":uid" => mysql_real_escape_string($this->UserId),
                    ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
                ));
                $count = $stm->rowCount();
                if ($count == 0) {
                    $this->db->beginTransaction();
                    $query1 = 'INSERT INTO  `post_comments_preferences` (`id`,`post_comments_id`,`user_id`,`preferences_id`,`created_at`,`status_id`) VALUES(:id,:postid,:uid,:prefId,:doc,:stat);';
                    $stm = $this->db->prepare($query1);
                    $res1 = $stm->execute(array(
                        ":id" => NULL,
                        ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
                        ":uid" => mysql_real_escape_string($this->UserId),
                        ":prefId" => mysql_real_escape_string($this->postBaseData["para"]["prefID"]),
                        ":doc" => date("Y-m-d H:i:s"),
                        ":stat" => 4,
                    ));
                } else {
                    $this->db->beginTransaction();
                    $query1 = 'UPDATE `post_comments_preferences` SET `preferences_id` = :prefId WHERE `post_comments_id` = :postid AND `user_id` = :uid;';
                    $stm = $this->db->prepare($query1);
                    $res1 = $stm->execute(array(
                        ":prefId" => mysql_real_escape_string($this->postBaseData["para"]["prefID"]),
                        ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
                        ":uid" => mysql_real_escape_string($this->UserId),
                    ));
                }
            }
        }
        if ($res1) {
            $this->db->commit();
            $jsondata["status"] = "success";
            $jsondata["count"] = 0;
            $jsondata["post_id"] = $this->postBaseData["para"]["postID"];
        } else
            $this->db->rollBack();
        return $jsondata;
    }
    public function addCommentReply($param = false) {
        $jsondata = array(
            "count" => 0,
            "post_id" => 0,
            "stat" => 4,
            "status" => 'error',
        );
        if ($this->postBaseData["postComID"] > 0) {
            $res1 = '';
            $background = NULL;
            $this->db->beginTransaction();
            if (isset($_SESSION['Individual_POST_PATH']) && is_array($_SESSION['Individual_POST_PATH'])) {
                $photo = (array) $_SESSION['Individual_POST_PATH']['respnse'];
                if ($photo["status"] === "success") {
                    $query1 = 'INSERT INTO  `photo` (`id`,`original_pic`,`ver1`,`ver2`,`ver3`,`ver4`,`ver5`)  VALUES(:id,:orgpic,:ver1,:ver2,:ver3,:ver4,:ver5);';
                    $stm = $this->db->prepare($query1);
                    $res1 = $stm->execute(array(
                        ":id" => NULL,
                        ":orgpic" => $photo['original_pic'],
                        ":ver1" => $photo['version_1'],
                        ":ver2" => $photo['version_2'],
                        ":ver3" => $photo['version_3'],
                        ":ver4" => $photo['version_4'],
                        ":ver5" => $photo['version_5']
                    ));
                    $background = $this->db->lastInsertId();
                    unset($_SESSION['Individual_POST_PATH']);
                }
            }
            $query1 = 'INSERT INTO  `post_comments_reply` (`id`,`post_comments_id`,`user_id`,`reply`,`created_at`,`photo_id`,`status_id`) VALUES(:id,:postid,:uid,:reply,:doc,:photo,:stat);';
            $stm = $this->db->prepare($query1);
            $res1 = $stm->execute(array(
                ":id" => NULL,
                ":postid" => mysql_real_escape_string($this->postBaseData["postComID"]),
                ":uid" => mysql_real_escape_string($this->UserId),
                ":reply" => mysql_real_escape_string(urldecode($this->postBaseData["reply"])),
                ":doc" => date("Y-m-d H:i:s"),
                ":photo" => mysql_real_escape_string($background),
                ":stat" => $jsondata["stat"],
            ));
            if ($res1)
                $this->db->commit();
            else
                $this->db->rollBack();
            if ($res1) {
                $jsondata["status"] = "success";
                $jsondata["count"] = $this->PostCommentReplyCount($this->postBaseData["postComID"]);
                $jsondata["post_id"] = $this->postBaseData["postComID"];
            }
        }
        return $jsondata;
    }
    public function likePostCommentReply($param = false) {
        $jsondata = array(
            "count" => $this->LikePostCommentReplyCount($param),
            "post_id" => 0,
            "stat" => 36,
            "status" => 'error',
        );
        $res1 = '';
        $query = 'SELECT `id` FROM `post_comments_reply_likes` WHERE `status_id` = :stat AND `user_id` = :uid AND `post_comments_reply_id` = :postid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => $jsondata["stat"],
            ":postid" => mysql_real_escape_string($param),
            ":uid" => mysql_real_escape_string($this->UserId),
        ));
        $count = $stm->rowCount();
        if ($count === 0) {
            $query = 'SELECT `id` FROM `post_comments_reply_likes` WHERE `status_id` = :stat AND `user_id` = :uid AND `post_comments_reply_id` = :postid;';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":stat" => 37,
                ":postid" => mysql_real_escape_string($param),
                ":uid" => mysql_real_escape_string($this->UserId),
            ));
            $count = $stm->rowCount();
            if ($count > 0) {
                $this->db->beginTransaction();
                $query1 = 'UPDATE `post_comments_reply_likes` SET `status_id` = :stat, `created_at`:= :doc WHERE `post_comments_reply_id` = :postid AND `user_id` = :uid;';
                $stm = $this->db->prepare($query1);
                $res1 = $stm->execute(array(
                    ":stat" => $jsondata["stat"],
                    ":doc" => date("Y-m-d H:i:s"),
                    ":postid" => mysql_real_escape_string($param),
                    ":uid" => mysql_real_escape_string($this->UserId),
                ));
            } else {
                $this->db->beginTransaction();
                $query1 = 'INSERT INTO  `post_comments_reply_likes` (`id`,`post_comments_reply_id`,`user_id`,`created_at`,`status_id`) VALUES(:id,:postid,:uid,:doc,:stat);';
                $stm = $this->db->prepare($query1);
                $res1 = $stm->execute(array(
                    ":id" => NULL,
                    ":postid" => mysql_real_escape_string($param),
                    ":uid" => mysql_real_escape_string($this->UserId),
                    ":doc" => date("Y-m-d H:i:s"),
                    ":stat" => $jsondata["stat"],
                ));
            }
            if ($res1) {
                $jsondata["status"] = "success";
                $jsondata["count"] = $this->LikePostCommentReplyCount($param);
                $jsondata["post_id"] = $param;
                $this->db->commit();
            } else
                $this->db->rollBack();
        }
        return $jsondata;
    }
    public function disLikePostCommentReply($param = false) {
        $jsondata = array(
            "count" => 0,
            "post_id" => 0,
            "stat" => 37,
            "status" => 'error',
        );
        $res1 = '';
        $query = 'SELECT `id` FROM `post_comments_reply_likes` WHERE `status_id` = :stat AND `user_id` = :uid AND `post_comments_reply_id` = :postid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => $jsondata["stat"],
            ":postid" => mysql_real_escape_string($param),
            ":uid" => mysql_real_escape_string($this->UserId),
        ));
        $count = $stm->rowCount();
        if ($count === 0) {
            $query = 'SELECT `id` FROM `post_comments_reply_likes` WHERE `status_id` = :stat AND `user_id` = :uid AND `post_comments_reply_id` = :postid;';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":stat" => 36,
                ":postid" => mysql_real_escape_string($param),
                ":uid" => mysql_real_escape_string($this->UserId),
            ));
            $count = $stm->rowCount();
            if ($count > 0) {
                $this->db->beginTransaction();
                $query1 = 'UPDATE `post_comments_reply_likes` SET `status_id`  = :stat, `created_at`:= :doc WHERE `post_comments_reply_id` = :postid AND `user_id` = :uid;';
                $stm = $this->db->prepare($query1);
                $res1 = $stm->execute(array(
                    ":stat" => $jsondata["stat"],
                    ":doc" => date("Y-m-d H:i:s"),
                    ":postid" => mysql_real_escape_string($param),
                    ":uid" => mysql_real_escape_string($this->UserId),
                ));
            } else {
                $this->db->beginTransaction();
                $query1 = 'INSERT INTO  `post_comments_reply_likes` (`id`,`post_comments_reply_id`,`user_id`,`created_at`,`status_id`) VALUES(:id,:postid,:uid,:doc,:stat);';
                $stm = $this->db->prepare($query1);
                $res1 = $stm->execute(array(
                    ":id" => NULL,
                    ":postid" => mysql_real_escape_string($param),
                    ":uid" => mysql_real_escape_string($this->UserId),
                    ":doc" => date("Y-m-d H:i:s"),
                    ":stat" => $jsondata["stat"],
                ));
            }
            if ($res1) {
                $jsondata["status"] = "success";
                $jsondata["count"] = $this->LikePostCommentReplyCount($param);
                $jsondata["post_id"] = $param;
                $this->db->commit();
            } else
                $this->db->rollBack();
        }
        return $jsondata;
    }
    public function changePostCommentReplyPreferences($param = false) {
        $jsondata = array(
            "count" => 0,
            "post_id" => 0,
            "stat" => $this->postBaseData["para"]["prefID"],
            "status" => 'error',
        );
        $res1 = '';
        $query = 'SELECT `id` FROM `post_comments_reply` WHERE `status_id` = :stat AND `user_id` = :uid AND `id` = :postid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => $jsondata["stat"],
            ":uid" => mysql_real_escape_string($this->UserId),
            ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
        ));
        $count = $stm->rowCount();
        if ($count > 0) {
            $this->db->beginTransaction();
            $query1 = 'UPDATE `post_comments_reply` SET `status_id` = :stat WHERE `id` = :postid AND `user_id` = :uid;';
            $stm = $this->db->prepare($query1);
            $res1 = $stm->execute(array(
                ":stat" => $jsondata["stat"],
                ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
                ":uid" => mysql_real_escape_string($this->UserId),
            ));
        } else {
            $query = 'SELECT `id` FROM `post_comments_reply` WHERE `status_id` = :stat AND `user_id` != :uid AND `id` = :postid;';
            $stm = $this->db->prepare($query);
            $res = $stm->execute(array(
                ":stat" => 4,
                ":uid" => mysql_real_escape_string($this->UserId),
                ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
            ));
            $count = $stm->rowCount();
            if ($count > 0) {
                $query = 'SELECT `id` FROM `post_comments_reply_preferences` WHERE `preferences_id` = :prefId AND `user_id` = :uid AND `post_comments_reply_id` = :postid;';
                $stm = $this->db->prepare($query);
                $res = $stm->execute(array(
                    ":prefId" => $jsondata["stat"],
                    ":uid" => mysql_real_escape_string($this->UserId),
                    ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
                ));
                $count = $stm->rowCount();
                if ($count == 0) {
                    $this->db->beginTransaction();
                    $query1 = 'INSERT INTO  `post_comments_reply_preferences` (`id`,`post_comments_reply_id`,`user_id`,`preferences_id`,`created_at`,`status_id`) VALUES(:id,:postid,:uid,:prefId,:doc,:stat);';
                    $stm = $this->db->prepare($query1);
                    $res1 = $stm->execute(array(
                        ":id" => NULL,
                        ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
                        ":uid" => mysql_real_escape_string($this->UserId),
                        ":prefId" => mysql_real_escape_string($this->postBaseData["para"]["prefID"]),
                        ":doc" => date("Y-m-d H:i:s"),
                        ":stat" => 4,
                    ));
                } else {
                    $this->db->beginTransaction();
                    $query1 = 'UPDATE `post_comments_reply_preferences` SET `preferences_id` = :prefId WHERE `post_comments_reply_id` = :postid AND `user_id` = :uid;';
                    $stm = $this->db->prepare($query1);
                    $res1 = $stm->execute(array(
                        ":prefId" => mysql_real_escape_string($this->postBaseData["para"]["prefID"]),
                        ":postid" => mysql_real_escape_string($this->postBaseData["para"]["postID"]),
                        ":uid" => mysql_real_escape_string($this->UserId),
                    ));
                }
            }
        }
        if ($res1) {
            $this->db->commit();
            $jsondata["status"] = "success";
            $jsondata["count"] = 0;
            $jsondata["post_id"] = $this->postBaseData["para"]["postID"];
        } else
            $this->db->rollBack();
        return $jsondata;
    }
    public function LikePostCount($param = false) {
        $query = 'SELECT `id` FROM `post_likes` WHERE `status_id` = :stat AND `post_id` = :postid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => 36,
            ":postid" => mysql_real_escape_string($param),
        ));
        return $stm->rowCount();
    }
    public function LikePostCommentCount($param = false) {
        $query = 'SELECT `id` FROM `post_comments_likes` WHERE `status_id` = :stat AND `post_comments_id` = :postid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => 36,
            ":postid" => mysql_real_escape_string($param),
        ));
        return $stm->rowCount();
    }
    public function LikePostCommentReplyCount($param = false) {
        $query = 'SELECT `id` FROM `post_comments_reply_likes` WHERE `status_id` = :stat AND `post_comments_reply_id` = :postid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => 36,
            ":postid" => mysql_real_escape_string($param),
        ));
        return $stm->rowCount();
    }
    public function PostCommentCount($param = false) {
        $query = 'SELECT `id` FROM `post_comments` WHERE `status_id` = :stat AND `post_id` = :postid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => 4,
            ":postid" => mysql_real_escape_string($param),
        ));
        return $stm->rowCount();
    }
    public function PostCommentReplyCount($param = false) {
        $query = 'SELECT `id` FROM `post_comments_reply` WHERE `status_id` = :stat AND `post_comments_id` = :postid;';
        $stm = $this->db->prepare($query);
        $res = $stm->execute(array(
            ":stat" => 4,
            ":postid" => mysql_real_escape_string($param),
        ));
        return $stm->rowCount();
    }
}
?>