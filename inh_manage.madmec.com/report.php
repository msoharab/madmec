<?php

class report {

    protected $parameters = array();
    private $order = array("\r\n", "\n", "\r");
    private $replace = ' ';
    private $query_project = '';
    private $array_project = '';

    function __construct($para = false) {
        $this->parameters = $para;
        $this->query_project = 'SELECT
					/* `proj_management` */
					a.`id`,
					a.`req_id`,
					a.`quot_id`,
					a.`po_id`,
					a.`proj_id`,
					a.`client_id`,
					a.`inv_id`,
					a.`ref_no`  AS proj_ref_no,
					a.`status_id` AS proj_status_id,
					/* `requirements` */
					req.`from_pk`,
					req.`to_pk`,
					req.`ethnographer` AS ethnographer_id,
					(SELECT `user_name`
						FROM `user_profile`
						WHERE `id` = req.`ethnographer`
						AND `status_id`  NOT IN (SELECT `id` FROM `status` WHERE (`statu_name` = "Left" OR
																`statu_name` = "Hide" OR
																`statu_name` = "Delete" OR
																`statu_name` = "Fired" OR
																`statu_name` = "Inactive" OR
																`statu_name` = "Flag"))
					) AS ethnographer,
					req.`representative` AS representative_id,
					(SELECT `name`
						FROM `user_name`
						WHERE `id` = req.`representative`
						AND `status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)  /* Representative */
					) AS representative,
					req.`ref_no` AS req_ref_no,
					req.`doethno`,
					req.`status_id` AS req_status_id,
					/* Painting */
					/* Painting `blocks` */
					req.`block_id`,
					req.`block_name`,
					/* Painting `floors` */
					req.`floor_id`,
					req.`floor_name`,
					/* Painting `requi_descp` */
					req.`paint_descp_id`,
					req.`location`,
					req.`length`,
					req.`breadth`,
					req.`area`,
					req.`rate`,
					req.`total`,
					req.`ptotal`,
					/* Production */
					/* Production `requi_descp` */
					req.`prod_descp_id`,
					req.`particular`,
					req.`qty`,
					req.`unit`,
					req.`totsup`,
					req.`totinst`,
					/* Production `requi_descp_details` */
					req.`req_descp_det_id`,
					req.`supply`,
					req.`installation`,
					/* `requirements` `documents` */
					req.`doc_id` AS req_doc_id,
					req.`doc_fn` AS SRS_fn,
					req.`doc_type_id`  AS req_doc_type_id,
					req.`SRS`,
					req.`mime_type` AS req_mime_type,
					req.`doc_type` AS req_doc_type,
					req.`dou` AS req_dou,
					/* `quotation` */
					c.*,
					/* `client_po` */
					d.*,
					/* `project` */
					e.*,
					/* `invoice` */
					f.*,
					/* `client` */
					clnt.*
				FROM `proj_management` AS a
				/* `requirements` `requi_descp` `requi_descp_details` `documents` */
				LEFT JOIN (
					SELECT
						/* `requirements` */
						a.`id` AS req_id,
						a.`from_pk`,
						a.`to_pk`,
						a.`representative`,
						a.`ethnographer`,
						a.`ref_no`,
						a.`doethno`,
						a.`status_id`,
						/* Painting */
						/* Painting `blocks` */
						b.`block_id`,
						b.`block_name`,
						/* Painting `floors` */
						b.`floor_id`,
						b.`floor_name`,
						/* Painting `requi_descp` */
						b.`req_descp_id` AS paint_descp_id,
						b.`location`,
						b.`length`,
						b.`breadth`,
						b.`area`,
						b.`rate`,
						b.`total`,
						ptot.`ptotal`,
						/* Production */
						/* Production `requi_descp` */
						c.`req_descp_id` AS prod_descp_id,
						c.`particular`,
						c.`qty`,
						c.`unit`,
						/* Production `requi_descp_details` */
						c.`req_descp_det_id`,
						c.`supply`,
						c.`installation`,
						prtot.`supply` AS totsup,
						prtot.`installation` AS totinst,
						/* `documents` */
						d.*
					FROM `requirements` AS a
					/* Painting */
					LEFT JOIN (
						SELECT
							/* `requi_descp` */
							a.`requi_id`,
							/* `blocks` */
							b.`block_id`,
							b.`block_name`,
							/* `floors` */
							b.`floor_id`,
							b.`floor_name`,
							/* `requi_descp` */
							b.`req_descp_id`,
							b.`location`,
							b.`length`,
							b.`breadth`,
							b.`area`,
							b.`rate`,
							b.`total`
						FROM `requi_descp` AS a
						LEFT JOIN(
							SELECT
								/* `blocks` */
								b.`requi_id`,
								GROUP_CONCAT(a.`id`,"☻♥♥♥☻") AS block_id,
								GROUP_CONCAT(a.`block_name`,"☻♥♥♥☻") AS block_name,
								GROUP_CONCAT(b.`floor_id`,"☻♥♥♥☻") AS floor_id,
								GROUP_CONCAT(b.`floor_name`,"☻♥♥♥☻") AS floor_name,
								GROUP_CONCAT(b.`req_descp_id`,"☻♥♥♥☻") AS req_descp_id,
								GROUP_CONCAT(b.`location`,"☻♥♥♥☻") AS location,
								GROUP_CONCAT(b.`length`,"☻♥♥♥☻") AS length,
								GROUP_CONCAT(b.`breadth`,"☻♥♥♥☻") AS breadth,
								GROUP_CONCAT(b.`area`,"☻♥♥♥☻") AS area,
								GROUP_CONCAT(b.`rate`,"☻♥♥♥☻") AS rate,
								GROUP_CONCAT(b.`total`,"☻♥♥♥☻") AS total
							FROM  `blocks` AS a
							LEFT JOIN (
								/* `floors` */
								SELECT
									a.`block_id`,
									b.`requi_id`,
									GROUP_CONCAT(a.`id`,"☻♥♥☻") AS `floor_id`,
									GROUP_CONCAT(a.`floor_name`,"☻♥♥☻") AS floor_name,
									GROUP_CONCAT(b.`req_descp_id`,"☻♥♥☻") AS req_descp_id,
									GROUP_CONCAT(b.`location`,"☻♥♥☻") AS location,
									GROUP_CONCAT(b.`length`,"☻♥♥☻") AS length,
									GROUP_CONCAT(b.`breadth`,"☻♥♥☻") AS breadth,
									GROUP_CONCAT(b.`area`,"☻♥♥☻") AS AREA,
									GROUP_CONCAT(b.`rate`,"☻♥♥☻") AS rate,
									GROUP_CONCAT(b.`total`,"☻♥♥☻") AS total
								FROM `floors` AS a
								LEFT JOIN (
									SELECT
										GROUP_CONCAT(`id`,"☻♥☻") AS req_descp_id,
										`requi_id`,
										`block_id`,
										`floor_id`,
										GROUP_CONCAT(`particular`,"☻♥☻") AS location,
										GROUP_CONCAT(`qty`,"☻♥☻") AS qty,
										GROUP_CONCAT((SELECT `unit_name` FROM `units` WHERE `id` = `unit_id`  AND `status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)),"☻♥☻") AS unit,
										GROUP_CONCAT(`length`,"☻♥☻") AS length,
										GROUP_CONCAT(`breadth`,"☻♥☻") AS breadth,
										GROUP_CONCAT(`area`,"☻♥☻") AS area,
										GROUP_CONCAT(`rate`,"☻♥☻") AS rate,
										GROUP_CONCAT(`total`,"☻♥☻") AS total
									FROM `requi_descp`
									WHERE `status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
									AND `floor_id` IS NOT NULL
									AND `block_id` IS NOT NULL
									GROUP BY (`floor_id`)
									ORDER BY (`floor_id`)
								) AS b ON b.`floor_id` = a.`id`
								WHERE a.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
								GROUP BY (a.`block_id`)
								ORDER BY (a.`block_id`)
							) AS b ON b.`block_id` = a.`id`
							WHERE a.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
							GROUP BY (b.`requi_id`)
							ORDER BY (b.`requi_id`)
						) AS b ON b.`requi_id` = a.`requi_id`
						WHERE a.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						AND b.`block_id` IS NOT NULL
						AND b.`floor_id` IS NOT NULL
					) AS b ON b.`requi_id` = a.`id`
					LEFT JOIN (
						SELECT
							GROUP_CONCAT(`id`),
							`requi_id`,
							GROUP_CONCAT(`total`),
							SUM(`total`) AS ptotal
						FROM `requi_descp`
						WHERE `status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						GROUP BY(`requi_id`)
						ORDER BY(`requi_id`)
					) AS ptot ON ptot.`requi_id` = a.`id`
					/* Production */
					LEFT JOIN (
						SELECT
							/* `requi_descp` */
							GROUP_CONCAT(a.`id`,"☻♥♥☻") AS req_descp_id,
							a.`requi_id`,
							GROUP_CONCAT(a.`particular`,"☻♥♥☻") AS particular,
							GROUP_CONCAT(a.`qty`,"☻♥♥☻") AS qty,
							GROUP_CONCAT((SELECT `unit_name` FROM `units` WHERE `id` = a.`unit_id`  AND `status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)),"☻♥♥☻") AS unit,
							/* `requi_descp_details` */
							GROUP_CONCAT(b.`req_descp_det_id`,"☻♥♥☻") AS req_descp_det_id,
							GROUP_CONCAT(b.`supply`,"☻♥♥☻") AS supply,
							GROUP_CONCAT(b.`installation`,"☻♥♥☻") AS installation
						FROM `requi_descp` AS a
						LEFT JOIN (
							/* `requi_descp_details` */
							SELECT
								GROUP_CONCAT(`id`,"☻♥☻") AS req_descp_det_id,
								`requi_descp_id`,
								GROUP_CONCAT(`supply`,"☻♥☻") AS supply,
								GROUP_CONCAT(`installation`,"☻♥☻") AS installation
							FROM `requi_descp_details`
							WHERE `status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
							GROUP BY (`requi_descp_id`)
							ORDER BY (`requi_descp_id`)
						) AS b ON b.`requi_descp_id` = a.`id`
						WHERE a.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						AND a.`qty` > 0
						AND a.`unit_id` > 0
						GROUP BY (a.`requi_id`)
						ORDER BY (a.`requi_id`)
					) AS c ON  c.`requi_id` = a.`id`
					LEFT JOIN (
						SELECT
							a.`requi_id`,
							b.`requi_descp_id`,
							SUM(b.`supply`) AS supply,
							SUM(b.`installation`) AS installation
						FROM `requi_descp` AS a
						LEFT JOIN (
							SELECT
								tmp.`requi_descp_id`,
								tmp.`supply`,
								tmp.`installation`
							FROM (
								SELECT
									`requi_descp_id`,
									`supply`,
									`installation`
								FROM `requi_descp_details`
								WHERE `status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
								ORDER BY (`id`) DESC
							) AS tmp
							GROUP BY (tmp.`requi_descp_id`)
							ORDER BY (tmp.`requi_descp_id`)
						) AS b ON b.`requi_descp_id` = a.`id`
						WHERE `status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						AND b.`requi_descp_id` IS NOT NULL
						GROUP BY(a.`requi_id`)
						ORDER BY(a.`requi_id`)
					) AS prtot ON prtot.`requi_id` = a.`id`
					LEFT JOIN (
						/* `documents` */
						SELECT
							`id` AS doc_id,
							`file_name` AS doc_fn,
							`type_id` AS doc_type_id,
							CASE WHEN (`doc_loc` IS NULL OR `doc_loc` = "")
								 THEN "#"
								 ELSE CONCAT("' . URL . '",`doc_loc`)
							END  AS SRS,
							`mime_type` AS mime_type,
							`doc_type` AS doc_type,
							DATE_FORMAT(`dou`,"%Y-%c-%d") AS dou
						FROM `documents`
						WHERE `status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						AND `doc_type` = "requirements"
					) AS d ON d.`doc_type_id` = a.`id`
					WHERE a.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
					GROUP BY(a.`id`)
					ORDER BY(a.`id`)
				) AS req ON req.`req_id` = a.`req_id`
				/* `quotation` `documents` */
				LEFT JOIN (
					/* `quotation` */
					SELECT
						a.`requi_id` AS qut_requi_id,
						a.`ref_no` AS qut_ref_no,
						a.`id` AS qut_quot_id,
						a.`doi`AS  doi,
						CASE WHEN (a.`addresse` IS NULL OR a.`addresse` = "")
							 THEN "' . ADDRESSE . '"
							 ELSE a.`addresse`
						END AS qut_addresse,
						CASE WHEN (a.`subject` IS NULL OR a.`subject` = "")
							 THEN "' . SUBJECT . '"
							 ELSE a.`subject`
						END AS qut_subject,
						CASE WHEN (a.`descp` IS NULL OR a.`descp` = "")
							 THEN "' . DESCP . '"
							 ELSE a.`descp`
						END AS qut_descp,
						(SELECT `statu_name` FROM `status` WHERE `id` = a.`status`  AND `status` = 1) AS  qut_status,
						a.`ptotal`AS  quot_ptotal,
						a.`totsup`AS  quot_totsup,
						a.`totins`AS  quot_totins,
						a.`vat`AS  quot_vat,
						a.`stc1`AS  quot_stc1,
						a.`stc1_50_1236_2`AS  quot_stc1_50_1236_2,
						a.`stc1_50_1236_1`AS  quot_stc1_50_1236_1,
						a.`stc2`AS  quot_stc2,
						a.`stc2_50_1236_2`AS  quot_stc2_50_1236_2,
						a.`stc2_50_1236_1`AS  quot_stc2_50_1236_1,
						a.`net_total`AS  quot_net_total,
						a.`status_id` AS  qut_status_id,
						/* `documents` */
						b.*
					FROM `quotation` AS a
					LEFT JOIN (
						/* `documents` */
						SELECT
							GROUP_CONCAT(`id`,"☻♥☻") AS doc_quot_id,
							GROUP_CONCAT(`file_name`,"☻♥☻") AS doc_quot_fn,
							`type_id` AS quot_type_id,
							GROUP_CONCAT(`type_id`,"☻♥☻") AS doc_quot_type_id,
							GROUP_CONCAT(CASE WHEN (`doc_loc` IS NULL OR `doc_loc` = "")
								 THEN "#"
								 ELSE CONCAT("' . URL . '",`doc_loc`)
							END	,"☻♥☻") AS doc_quot_QUOT,
							GROUP_CONCAT(`mime_type`,"☻♥☻") AS doc_quot_mime_type,
							GROUP_CONCAT(`doc_type`,"☻♥☻") AS doc_quot_doc_type,
							GROUP_CONCAT(DATE_FORMAT(`dou`,"%Y-%c-%d"),"☻♥☻") AS doc_quot_dou
						FROM `documents`
						WHERE `status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						AND `doc_type` = "quotation"
						GROUP BY(`type_id`)
						ORDER BY(`type_id`)
					) AS b ON b.`quot_type_id` = a.`id`
					WHERE a.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
					ORDER BY (a.`requi_id`)
				) AS c ON c.`qut_ref_no` = a.`ref_no` AND c.`qut_requi_id` = a.`req_id`
				/* `client_po` `documents` */
				LEFT JOIN (
					SELECT
						/* `client_po` */
						a.`id` AS cpor_id,
						a.`requi_id` AS cpor_requi_id,
						a.`quot_id` AS cpor_quot_id,
						a.`ref_no` AS cpor_ref_no,
						a.`cpo_ref_no` AS cpor_cpo_ref_no,
						a.`date` AS cpor_date,
						a.`status_id` AS cpor_status_id,
						/* `documents` */
						b.*
					FROM `client_po` AS a
					LEFT JOIN (
						SELECT
							GROUP_CONCAT(`id`,"☻♥☻")  AS cpor_doc_id,
							GROUP_CONCAT(`file_name`,"☻♥☻") AS CPO_fn,
							`type_id` AS cpor_type_id,
							GROUP_CONCAT(`type_id`,"☻♥☻") AS cpor_doc_type_id,
							GROUP_CONCAT(CASE WHEN (`doc_loc` IS NULL OR `doc_loc` = "")
								 THEN "#"
								 ELSE CONCAT("' . URL . '",`doc_loc`)
							END,"☻♥☻") AS CPO,
							GROUP_CONCAT(`mime_type`,"☻♥☻") AS cpor_doc_mime_type,
							GROUP_CONCAT(`doc_type`,"☻♥☻") AS cpor_doc_type,
							GROUP_CONCAT(DATE_FORMAT(`dou`,"%Y-%c-%d"),"☻♥☻") AS cpor_doc_dou
						FROM `documents`
						WHERE `status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						AND `doc_type` = "client_po"
						GROUP BY(`type_id`)
						ORDER BY(`type_id`)
					) AS b ON b.`cpor_type_id` = a.`id`
					WHERE a.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
				) AS d ON d.`cpor_ref_no` = a.`ref_no` AND d.`cpor_quot_id` = a.`quot_id` AND d.`cpor_requi_id` = a.`req_id`
				/*
					`project` `project_description` `project_status` `project_team_members` `pcc` `pcc_task`
					`pcc_task_descp`  `drawing` `documents` `status` `user_profile`
				*/
				LEFT JOIN (
					SELECT
						/* `project` */
						a.`id` AS prjt_id,
						a.`requi_id` AS prjt_requi_id,
						a.`quot_id` AS prjt_quot_id,
						a.`client_po` AS prjt_client_po,
						a.`ref_no` AS prjt_ref_no,
						a.`name` AS prjt_name,
						(SELECT `user_name`
							FROM `user_profile`
							WHERE `id` = a.`project_md`
							AND `status_id`  NOT IN (SELECT `id` FROM `status` WHERE (`statu_name` = "Left" OR
																`statu_name` = "Hide" OR
																`statu_name` = "Delete" OR
																`statu_name` = "Fired" OR
																`statu_name` = "Inactive" OR
																`statu_name` = "Flag"))
						) AS prjt_md,
						(SELECT `user_name`
							FROM `user_profile`
							WHERE `id` = a.`project_eng`
							AND `status_id`  NOT IN (SELECT `id` FROM `status` WHERE (`statu_name` = "Left" OR
																`statu_name` = "Hide" OR
																`statu_name` = "Delete" OR
																`statu_name` = "Fired" OR
																`statu_name` = "Inactive" OR
																`statu_name` = "Flag"))
						) AS prjt_eng,
						(SELECT `user_name`
							FROM `user_profile`
							WHERE `id` = a.`project_mng`
							AND `status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)  /* Designer */
						) AS prjt_mng,
						(SELECT `user_name`
							FROM `user_profile`
							WHERE `id` = a.`project_hld`
							AND `status_id`  NOT IN (SELECT `id` FROM `status` WHERE (`statu_name` = "Left" OR
																`statu_name` = "Hide" OR
																`statu_name` = "Delete" OR
																`statu_name` = "Fired" OR
																`statu_name` = "Inactive" OR
																`statu_name` = "Flag"))
						) AS prjt_hld,
						DATE_FORMAT(a.`psd`,"%Y-%c-%d") AS prjt_psd,
						DATE_FORMAT(a.`pcd`,"%Y-%c-%d") AS prjt_pcd,
						a.`discussed` AS prjt_discussed,
						a.`progress` AS prjt_progress,
						a.`met_timeline` AS prjt_met_timeline,
						a.`status_id` AS prjt_status_id,
						/* `project_description` */
						b.*
					FROM `project` AS a
					LEFT JOIN (
						SELECT
							/* `project_description` */
							GROUP_CONCAT(a.`id`,"☻♥♥☻") AS prj_des_id,
							a.`proj_id` AS prj_des_proj_id,
							GROUP_CONCAT(
								(SELECT `particular`
									FROM `requi_descp`
									WHERE `id` = a.`task`
									AND `status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)  /* Designer */
								)
							,"☻♥♥☻") AS prj_des_task,
							GROUP_CONCAT(a.`production`,"☻♥♥☻") AS prj_des_production,
							GROUP_CONCAT(
								(SELECT `status`
									FROM `project_status`
									WHERE `id` = a.`status`
									AND `status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
								)
							,"☻♥♥☻") AS prj_des_status,
							GROUP_CONCAT(
								CASE WHEN (a.`feedback` IS NULL OR a.`feedback` = "")
									 THEN ""
									 ELSE a.`feedback`
								END
							,"☻♥♥☻") AS prj_des_feedback,
							GROUP_CONCAT(
								CASE WHEN (a.`obstacles` IS NULL OR a.`obstacles` = "")
									 THEN ""
									 ELSE a.`obstacles`
								END
							,"☻♥♥☻") AS prj_des_obstacles,
							GROUP_CONCAT(a.`status_id`,"☻♥♥☻") AS prj_des_statu_id,
							/* `project_team_members` */
							b.*,
							/* `pcc` */
							c.*,
							/* `PCCCHART` */
							d.*,
							/* `drawing` */
							e.*
						FROM `project_description` AS a
						LEFT JOIN (
							SELECT
								`project_id`,
								`proj_descp_id`,
								GROUP_CONCAT(`id`,"☻♥♥☻") AS team_mem_id,
								GROUP_CONCAT(`team_member`,"☻♥♥☻") AS team_member_id,
								GROUP_CONCAT(
									(SELECT `user_name`
										FROM `user_profile`
										WHERE `id` = `team_member`
										AND `status_id`  NOT IN (SELECT `id` FROM `status` WHERE (`statu_name` = "Left" OR
																	`statu_name` = "Hide" OR
																	`statu_name` = "Delete" OR
																	`statu_name` = "Fired" OR
																	`statu_name` = "Inactive" OR
																	`statu_name` = "Flag"))
									)
								,"☻♥♥☻") AS team_member,
								GROUP_CONCAT(
									(SELECT `status`
										FROM `project_status`
										WHERE `id` = `project_status`
										AND `status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
									)
								,"☻♥♥☻") AS team_mem_status,
								`status_id`
							FROM `project_team_members`
							WHERE `status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
							GROUP BY(`proj_descp_id`)
							ORDER BY(`proj_descp_id`)
						) AS b ON b.`proj_descp_id` = a.`id` AND b.`project_id` = a.`proj_id`
						LEFT JOIN (
							SELECT
								/* `pcc` */
								a.`proj_id` AS pcc_proj_id,
								a.`proj_descp_id` AS pcc_proj_descp_id,
								a.`requi_id` AS pcc_requi_id,
								a.`quot_id` AS pcc_quot_id,
								a.`client_po` AS pcc_client_po,
								GROUP_CONCAT(`id`,"☻♥♥☻") AS pcc_id,
								GROUP_CONCAT(a.`name`,"☻♥♥☻") AS pcc_name,
								GROUP_CONCAT(a.`city`,"☻♥♥☻") AS pcc_city,
								GROUP_CONCAT(a.`code`,"☻♥♥☻") AS pcc_code,
								GROUP_CONCAT(a.`revision`,"☻♥♥☻") AS pcc_revision,
								GROUP_CONCAT(
									DATE_FORMAT(a.`sd_wood`,"%Y-%c-%d")
								,"☻♥♥☻") AS pcc_sd_wood,
								GROUP_CONCAT(
									DATE_FORMAT(a.`sd_metal`,"%Y-%c-%d")
								,"☻♥♥☻") AS pcc_sd_metal,
								GROUP_CONCAT(
									DATE_FORMAT(a.`ed_project`,"%Y-%c-%d")
								,"☻♥♥☻") AS pcc_ed_project,
								GROUP_CONCAT(a.`frame_config`,"☻♥♥☻") AS pcc_frame_config,
								GROUP_CONCAT(a.`wrkstn_height`,"☻♥♥☻") AS pcc_wrkstn_height,
								GROUP_CONCAT(a.`tot_wrkstn`,"☻♥♥☻") AS pcc_tot_wrkstn,
								GROUP_CONCAT(a.`status_id`,"☻♥♥☻") AS pcc_status_id,
								/* `pcc_task` */
								GROUP_CONCAT(b.`pcc_task_descp_id`,"☻♥♥☻") AS pcc_task_descp_id,
								GROUP_CONCAT(b.`pcc_task_descp_mat_descp`,"☻♥♥☻") AS pcc_task_descp_mat_descp,
								GROUP_CONCAT(b.`pcc_task_descp_size`,"☻♥♥☻") AS pcc_task_descp_size,
								GROUP_CONCAT(b.`pcc_task_descp_colour`,"☻♥♥☻") AS pcc_task_descp_colour,
								GROUP_CONCAT(b.`pcc_task_descp_qty`,"☻♥♥☻") AS pcc_task_descp_qty,
								GROUP_CONCAT(b.`pcc_task_descp_remark`,"☻♥♥☻") AS pcc_task_descp_remark
							FROM `pcc` AS a
							LEFT JOIN (
								SELECT
									/* `pcc_task` */
									a.`pcc_id`,
									GROUP_CONCAT(a.`id`,"☻♥☻") AS pcc_task_descp_id,
									GROUP_CONCAT(a.`mat_descp`,"☻♥☻") AS pcc_task_descp_mat_descp,
									GROUP_CONCAT(a.`size`,"☻♥☻") AS pcc_task_descp_size,
									GROUP_CONCAT(a.`colour`,"☻♥☻") AS pcc_task_descp_colour,
									GROUP_CONCAT(a.`qty`,"☻♥☻") AS pcc_task_descp_qty,
									GROUP_CONCAT(a.`remark`,"☻♥☻") AS pcc_task_descp_remark
								FROM `pcc_task` AS a
								WHERE a.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
								GROUP BY(a.`pcc_id`)
								ORDER BY(a.`pcc_id`)
							) AS b ON b.`pcc_id` = a.`id`
							WHERE a.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
							GROUP BY(a.`proj_descp_id`)
							ORDER BY(a.`proj_descp_id`)
						) AS c ON c.`pcc_proj_descp_id` = a.`id` AND c.`pcc_proj_id` = a.`proj_id`
						LEFT JOIN (
							/* `PCC` `documents` */
							SELECT
								GROUP_CONCAT(`id`,"☻♥♥☻") AS pcc_doc_id,
								GROUP_CONCAT(`file_name`,"☻♥♥☻") AS pcc_doc_fn,
								`type_id` AS pcc_type_id,
								GROUP_CONCAT(`type_id`,"☻♥♥☻") AS pcc_doc_type_id,
								GROUP_CONCAT(
									CASE WHEN (`doc_loc` IS NULL OR `doc_loc` = "")
										 THEN "#"
										 ELSE CONCAT("' . URL . '",`doc_loc`)
									END
								,"☻♥♥☻") AS pcc_doc_PCCHART,
								GROUP_CONCAT(`mime_type`,"☻♥♥☻") AS pcc_doc_mime_type,
								GROUP_CONCAT(`doc_type`,"☻♥♥☻") AS pcc_doc_type,
								GROUP_CONCAT(DATE_FORMAT(`dou`,"%Y-%c-%d"),"☻♥♥☻") AS pcc_doc_dou
							FROM `documents`
							WHERE `status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
							AND `doc_type` = "project_description"
							GROUP BY(`type_id`)
							ORDER BY(`type_id`)
						) AS d ON d.`pcc_type_id` = a.`id`
						LEFT JOIN (
							SELECT
								/* `drawing` */
								a.`proj_descp_id` AS draw_proj_descp_id,
								a.`proj_id` AS draw_proj_id,
								a.`id` AS draw_id,
								a.`user_pk` AS draw_designer_id,
								/* Designer */
								(SELECT `user_name`
									FROM `user_profile`
									WHERE `id` = a.`user_pk`
									AND `status_id`  NOT IN (SELECT `id` FROM `status` WHERE (`statu_name` = "Left" OR
															`statu_name` = "Hide" OR
															`statu_name` = "Delete" OR
															`statu_name` = "Fired" OR
															`statu_name` = "Inactive" OR
															`statu_name` = "Flag"))
								) AS draw_designer,
								a.`draw_name` AS draw_name,
								DATE_FORMAT(a.`up_date`,"%Y-%c-%d") AS draw_up_date,
								(SELECT `statu_name` FROM `status` WHERE `id` = a.`status`  AND `status` = 1) AS draw_status,
								/* `documents` */
								b.*
							FROM `drawing` AS a
							LEFT JOIN (
								/* `documents` */
								SELECT
									GROUP_CONCAT(`id`,"☻♥☻") AS draw_doc_id,
									GROUP_CONCAT(`file_name`,"☻♥☻") AS draw_doc_fn,
									`type_id` AS draw_type_id,
									GROUP_CONCAT(`type_id`,"☻♥☻") AS draw_doc_type_id,
									GROUP_CONCAT(
										CASE WHEN (`doc_loc` IS NULL OR `doc_loc` = "")
											 THEN "#"
											 ELSE CONCAT("' . URL . '",`doc_loc`)
										END
									,"☻♥☻") AS draw_doc_DRAWING,
									GROUP_CONCAT(`mime_type`,"☻♥☻") AS draw_doc_mime_type,
									GROUP_CONCAT(`doc_type`,"☻♥☻") AS draw_doc_type,
									GROUP_CONCAT(`dou`,"☻♥☻") AS draw_doc_dou
								FROM `documents`
								WHERE `status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
								AND `doc_type` = "drawing"
								GROUP BY(`type_id`)
								ORDER BY(`type_id`)
							) AS b ON b.`draw_type_id` = a.`id`
							WHERE a.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
							GROUP BY(a.`proj_descp_id`)
							ORDER BY(a.`proj_descp_id`)
						) AS e ON e.`draw_proj_descp_id` = a.`id` AND e.`draw_proj_id` = a.`proj_id`
						WHERE a.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						GROUP BY(a.`proj_id`)
						ORDER BY(a.`proj_id`)
					) AS b ON b.`prj_des_proj_id` = a.`id`
					WHERE a.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
				) AS e ON e.`prjt_id` = a.`proj_id`
				/*
					`invoice` `mode_of_transport` `vehicle`	`documents`
				*/
				LEFT JOIN (
					SELECT
						/* `invoice` */
						a.`id` AS invc_id,
						a.`requi_id` AS invc_requi_id,
						a.`quot_id` AS invc_quot_id,
						a.`client_po` AS invc_client_po,
						a.`proj_id` AS invc_proj_id,
						a.`from_pk` AS invc_from_pk,
						a.`to_pk` AS invc_to_pk,
						a.`ref_no` AS invc_ref_no,
						a.`addresse` AS invc_addresse,
						a.`subject` AS invc_subject,
						a.`descp` AS invc_descp,
						a.`ptotal` AS invc_ptotal,
						a.`totsup` AS invc_totsup,
						a.`totins` AS invc_totins,
						a.`vat` AS invc_vat,
						a.`stc1` AS invc_stc1,
						a.`stc1_50_1236_2` AS invc_stc1_50_1236_2,
						a.`stc1_50_1236_1` AS invc_stc1_50_1236_1,
						a.`stc2` AS invc_stc2,
						a.`stc2_50_1236_2` AS invc_stc2_50_1236_2,
						a.`stc2_50_1236_1` AS invc_stc2_50_1236_1,
						a.`net_total` AS invc_net_total,
						(SELECT `statu_name`
							FROM `status`
							WHERE `id` = a.`status`
							AND `status` = 1
						)  AS invc_status, /* Approved , Disapproved */
						a.`status_id`  AS invc_status_id,
						/* `documents` */
						b.*,
						/* `vehicle` */
						c.`id`  AS invc_veh_id,
						c.`user_to_pk`  AS invc_veh_user_to_pk,
						c.`user_from_pk`  AS invc_veh_user_from_pk,
						(SELECT `user_name`
							FROM `user_profile`
							WHERE `id` = c.`driver`
							AND `status_id`  NOT IN (SELECT `id` FROM `status` WHERE (`statu_name` = "Left" OR
																`statu_name` = "Hide" OR
																`statu_name` = "Delete" OR
																`statu_name` = "Fired" OR
																`statu_name` = "Inactive" OR
																`statu_name` = "Flag"))
						) AS invc_veh_driver,
						c.`vehicle_no`  AS invc_veh_vehicle_no,
						c.`mot`  AS invc_veh_mot,
						c.`empty_weight` AS invc_veh_empty_weight,
						c.`loaded_weight` AS invc_veh_loaded_weight,
						c.`total_weight` AS invc_veh_total_weight,
						c.`advance_amt` AS invc_veh_advance_amt,
						c.`rent` AS invc_veh_rent,
						c.`arrival` AS invc_veh_arrival,
						c.`departure` AS invc_veh_departure,
						c.`status_id` AS invc_veh_status_id
					FROM `invoice` AS a
					LEFT JOIN (
						/* `documents` */
						SELECT
							GROUP_CONCAT(`id`,"☻♥☻") AS invc_doc_id,
							GROUP_CONCAT(`file_name`,"☻♥☻") AS invc_fn,
							`type_id` AS invc_type_id,
							GROUP_CONCAT(`type_id`,"☻♥☻") AS invc_doc_type_id,
							GROUP_CONCAT(
								CASE WHEN (`doc_loc` IS NULL OR `doc_loc` = "")
									 THEN "#"
									 ELSE CONCAT("' . URL . '",`doc_loc`)
								END
							,"☻♥☻") AS invc_doc_INVOICE,
							GROUP_CONCAT(`mime_type`,"☻♥☻") AS invc_doc_mime_type,
							GROUP_CONCAT(`doc_type`,"☻♥☻") AS invc_doc_type,
							GROUP_CONCAT(`dou`,"☻♥☻") AS invc_doc_dou
						FROM `documents`
						WHERE `status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						AND `doc_type` = "invoice"
						GROUP BY(`type_id`)
						ORDER BY(`type_id`)
					) AS b ON b.`invc_type_id` = a.`id`
					LEFT JOIN (
						SELECT
							/* `vehicle` */
							`id`,
							`user_to_pk`,
							`user_from_pk`,
							`driver`,
							`vehicle_no`,
							(SELECT `tr_type`
								FROM `mode_of_transport` WHERE `id` = `mot`
								AND `status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
							) AS mot,
							`empty_weight`,
							`loaded_weight`,
							`total_weight`,
							`advance_amt`,
							`rent`,
							`arrival`,
							`departure`,
							`status_id`
						FROM `vehicle`
						WHERE `status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
					) AS c ON c.`id` = a.`vehicle_id`
					WHERE a.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
				) AS f ON f.`invc_id` = a.`inv_id` AND f.`invc_requi_id` = a.`req_id` AND f.`invc_quot_id` = a.`quot_id` AND f.`invc_client_po` = a.`po_id` AND f.`invc_proj_id` = a.`proj_id`
				LEFT JOIN(
					SELECT
						a.`id` AS usrid,
						a.`user_name`,
						a.`acs_id`,
						a.`directory`,
						a.`password`,
						CASE WHEN (a.`addressline` IS NULL OR a.`addressline` = "" )
							 THEN "Not provided"
							 ELSE a.`addressline`
						END AS addressline,
						CASE WHEN (a.`town` IS NULL OR a.`town` = "" )
							 THEN "Not provided"
							 ELSE a.`town`
						END AS town,
						CASE WHEN (a.`city` IS NULL OR a.`city` = "" )
							 THEN "Not provided"
							 ELSE a.`city`
						END AS city,
						CASE WHEN (a.`district` IS NULL OR a.`district` = "" )
							 THEN "Not provided"
							 ELSE a.`district`
						END AS district,
						CASE WHEN (a.`province` IS NULL OR a.`province` = "" )
							 THEN "Not provided"
							 ELSE a.`province`
						END AS province,
						CASE WHEN (a.`province_code` IS NULL OR a.`province_code` = "" )
							 THEN NULL
							 ELSE a.`province_code`
						END AS province_code,
						CASE WHEN (a.`country` IS NULL OR a.`country` = "" )
							 THEN "Not provided"
							 ELSE a.`country`
						END AS country,
						CASE WHEN (a.`country_code` IS NULL OR a.`country_code` = "" )
							 THEN NULL
							 ELSE a.`country_code`
						END AS country_code,
						CASE WHEN (a.`zipcode` IS NULL OR a.`zipcode` = "" )
							 THEN "Not provided"
							 ELSE a.`zipcode`
						END AS zipcode,
						CASE WHEN (a.`website` IS NULL OR a.`website` = "" )
							 THEN "http://"
							 ELSE a.`website`
						END AS website,
						CASE WHEN (a.`gmaphtml` IS NULL OR a.`gmaphtml` = "" )
							 THEN "http://"
							 ELSE a.`gmaphtml`
						END AS gmaphtml,
						/*
							CONCAT(
								CASE WHEN (a.`postal_code` IS NULL OR a.`postal_code` = "" )
									 THEN "---"
									 ELSE a.`postal_code`
								END,
								CASE WHEN (a.`telephone` IS NULL OR a.`telephone` = "" )
									 THEN "Not provided"
									 ELSE a.`telephone`
								END
							) AS tnumber,
						*/
						CASE WHEN (a.`postal_code` IS NULL OR a.`postal_code` = "" )
							 THEN "---"
							 ELSE a.`postal_code`
						END  AS pcode,
						CASE WHEN (a.`telephone` IS NULL OR a.`telephone` = "" )
							 THEN "Not provided"
							 ELSE a.`telephone`
						END AS tnumber,
						CASE WHEN (ph.`ver2` IS NULL OR ph.`ver2` = "")
							 THEN "' . USER_ANON_IMAGE . '"
							 ELSE CONCAT("' . URL . ASSET_DIR . '",ph.`ver2`)
						END AS usrphoto,
						a.`status_id`,
						b.`email_pk`  AS email_pk,
						b.`email` AS email,
						c.`cnumber_pk` AS cnumber_pk,
						c.`cnumber` AS cnumber,
						d.`bank_pk` AS bank_pk,
						d.`bank_name` AS bank_name,
						d.`ac_no` AS ac_no,
						d.`branch` AS branch,
						d.`branch_code` AS branch_code,
						d.`IFSC` AS IFSC,
						e.`prd_pk` AS prd_pk,
						e.`name` AS prdname,
						e.`prdphoto` AS prdphoto,
						f.`user_type`,
						g.`gender_name`,
						/* Incomming */
						i.`incid`,
						i.`colldate`,
						i.`incamt`,
						i.`incrmk`,
						i.`incmop`,
						i.`incbname`,
						i.`incbacno`,
						i.`incbranch`,
						i.`incifsc`,
						/* Outgoing */
						j.`outid`,
						j.`paydate`,
						j.`outamt`,
						j.`outrmk`,
						j.`outmop`,
						j.`outbname`,
						j.`outbacno`,
						j.`outbranch`,
						j.`outbrcode`,
						j.`outifsc`,
						k.`pan_pk`,
						k.`pan`,
						l.`stc_pk`,
						l.`stc`,
						m.`tin_pk`,
						m.`tin`,
						n.*
					FROM `user_profile` AS a
					LEFT JOIN `photo` AS ph ON a.`photo_id` = ph.`id`
					LEFT JOIN (
						SELECT
							GROUP_CONCAT(em.`id`,"☻☻♥♥☻☻") AS email_pk,
							GROUP_CONCAT(em.`email`,"☻☻♥♥☻☻") AS email,
							em.`user_pk`
						FROM `email_ids` AS em
						WHERE em.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						GROUP BY (em.`user_pk`)
						ORDER BY (em.`user_pk`)
					)  AS b ON a.`id` = b.`user_pk`
					LEFT JOIN (
						SELECT
							GROUP_CONCAT(cn.`id`,"☻☻♥♥☻☻") AS cnumber_pk,
							cn.`user_pk`,
							/* GROUP_CONCAT(CONCAT(cn.`cell_code`,"-",cn.`cell_number`),"☻☻♥♥☻☻") AS cnumber */
							GROUP_CONCAT(cn.`cell_number`,"☻☻♥♥☻☻") AS cnumber
						FROM `cell_numbers` AS cn
						WHERE cn.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						GROUP BY (cn.`user_pk`)
						ORDER BY (cn.`user_pk`)
					) AS c ON a.`id` = c.`user_pk`
					LEFT JOIN (
						SELECT
							GROUP_CONCAT(ba.`id`,"☻☻♥♥☻☻") AS bank_pk,
							ba.`user_pk`,
							GROUP_CONCAT(ba.`bank_name`,"☻☻♥♥☻☻") AS bank_name,
							GROUP_CONCAT(ba.`ac_no`,"☻☻♥♥☻☻") AS ac_no,
							GROUP_CONCAT(
								CASE WHEN (ba.`branch` IS NULL OR ba.`branch` = "" )
									 THEN "Not provided"
									 ELSE ba.`branch`
								END,"☻☻♥♥☻☻"
							) AS branch,
							GROUP_CONCAT(
								CASE WHEN (ba.`branch_code` IS NULL OR ba.`branch_code` = "" )
									 THEN "Not provided"
									 ELSE ba.`branch_code`
								END,"☻☻♥♥☻☻"
							) AS branch_code,
							GROUP_CONCAT(
								CASE WHEN (ba.`IFSC` IS NULL OR ba.`IFSC` = "" )
									 THEN "Not provided"
									 ELSE ba.`IFSC`
								END,"☻☻♥♥☻☻"
							) AS IFSC,
							ba.`status_id`
						FROM `bank_accounts` AS ba
						WHERE ba.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						GROUP BY (ba.`user_pk`)
						ORDER BY (ba.`user_pk`)
					) AS d ON a.`id` = d.`user_pk`
					LEFT JOIN (
						SELECT
							GROUP_CONCAT(prd.`id`,"☻☻♥♥☻☻") AS prd_pk,
							GROUP_CONCAT(prd.`name`,"☻☻♥♥☻☻") AS name,
							/*
								GROUP_CONCAT(
									CASE WHEN (ph.`ver2` IS NULL OR ph.`ver2` = "" )
										 THEN "VEGIE_IMAGE"
										 ELSE CONCAT("URL.ASSET_DIR",ph.`ver2`)
									END,"☻☻♥♥☻☻"
								) AS prdphoto,
							*/
							GROUP_CONCAT("","☻☻♥♥☻☻") AS prdphoto,
							prd.`user_pk`
						FROM `product` AS prd
						LEFT JOIN `photo` AS ph ON prd.`photo_id`  = ph.`id`
						WHERE prd.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						GROUP BY (prd.`user_pk`)
						ORDER BY (prd.`user_pk`)
					) AS e ON a.`id` = e.`user_pk`
					LEFT JOIN (
						SELECT
							utype.`id` AS type_id,
							utype.`user_type`
						FROM `user_type` AS utype
						WHERE utype.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
					) AS f ON a.`user_type_id` = f.`type_id`
					LEFT JOIN `gender` AS g ON a.`gender` = g.`id`
					LEFT JOIN (
						SELECT
							inc.`from_pk`,
							GROUP_CONCAT(inc.`id`,"☻☻♥♥☻☻") AS incid,
							GROUP_CONCAT(DATE_FORMAT(inc.`arrival`,"%Y-%c-%d"),"☻☻♥♥☻☻") AS colldate,
							GROUP_CONCAT(inc.`amount`,"☻☻♥♥☻☻") AS incamt,
							GROUP_CONCAT(inc.`remark`,"☻☻♥♥☻☻") AS incrmk,
							GROUP_CONCAT(m.`mop`,"☻☻♥♥☻☻") AS incmop,
							GROUP_CONCAT(ba.`bank_name`,"☻☻♥♥☻☻") AS incbname,
							GROUP_CONCAT(ba.`ac_no`,"☻☻♥♥☻☻") AS incbacno,
							GROUP_CONCAT(
								CASE WHEN (ba.`branch` IS NULL OR ba.`branch` = "" )
									 THEN "Not provided"
									 ELSE ba.`branch`
								END,"☻☻♥♥☻☻"
							) AS incbranch,
							GROUP_CONCAT(
								CASE WHEN (ba.`branch_code` IS NULL OR ba.`branch_code` = "" )
									 THEN "Not provided"
									 ELSE ba.`branch_code`
								END,"☻☻♥♥☻☻"
							) AS incbrcode,
							GROUP_CONCAT(
								CASE WHEN (ba.`IFSC` IS NULL OR ba.`IFSC` = "" )
									 THEN "Not provided"
									 ELSE ba.`IFSC`
								END,"☻☻♥♥☻☻"
							) AS incifsc
						FROM `incomming` AS inc
						LEFT JOIN `bank_accounts` AS ba ON ba.`id` = inc.`bank_acc_id`
						LEFT JOIN `mode_of_payment` AS m ON m.`id` = inc.`mop`
						WHERE inc.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						GROUP BY (inc.`from_pk`)
						ORDER BY (inc.`from_pk`)
					) AS i ON a.`id` = i.`from_pk`
					LEFT JOIN (
						SELECT
							ou.`to_pk`,
							GROUP_CONCAT(ou.`id`,"☻☻♥♥☻☻") AS outid,
							GROUP_CONCAT(DATE_FORMAT(ou.`departure`,"%Y-%c-%d"),"☻☻♥♥☻☻") AS paydate,
							GROUP_CONCAT(ou.`amount`,"☻☻♥♥☻☻") AS outamt,
							GROUP_CONCAT(ou.`remark`,"☻☻♥♥☻☻") AS outrmk,
							GROUP_CONCAT(m.`mop`,"☻☻♥♥☻☻") AS outmop,
							GROUP_CONCAT(ba.`bank_name`,"☻☻♥♥☻☻") AS outbname,
							GROUP_CONCAT(ba.`ac_no`,"☻☻♥♥☻☻") AS outbacno,
							GROUP_CONCAT(
								CASE WHEN (ba.`branch` IS NULL OR ba.`branch` = "" )
									 THEN "Not provided"
									 ELSE ba.`branch`
								END,"☻☻♥♥☻☻"
							) AS outbranch,
							GROUP_CONCAT(
								CASE WHEN (ba.`branch_code` IS NULL OR ba.`branch_code` = "" )
									 THEN "Not provided"
									 ELSE ba.`branch_code`
								END,"☻☻♥♥☻☻"
							) AS outbrcode,
							GROUP_CONCAT(
								CASE WHEN (ba.`IFSC` IS NULL OR ba.`IFSC` = "" )
									 THEN "Not provided"
									 ELSE ba.`IFSC`
								END,"☻☻♥♥☻☻"
							) AS outifsc
						FROM `outgoing` AS ou
						LEFT JOIN `bank_accounts` AS ba ON ba.`id` = ou.`bank_acc_id`
						LEFT JOIN `mode_of_payment` AS m ON m.`id` = ou.`mop`
						WHERE ou.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						GROUP BY (ou.`to_pk`)
						ORDER BY (ou.`to_pk`)
					) AS j ON a.`id` = j.`to_pk`
					LEFT JOIN (
						SELECT
							GROUP_CONCAT(pan.`id`,"☻☻♥♥☻☻") AS pan_pk,
							GROUP_CONCAT(pan.`pan`,"☻☻♥♥☻☻") AS pan,
							pan.`user_pk`
						FROM `code_pan` AS pan
						WHERE pan.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						GROUP BY (pan.`user_pk`)
						ORDER BY (pan.`user_pk`)
					)  AS k ON a.`id` = k.`user_pk`
					LEFT JOIN (
						SELECT
							GROUP_CONCAT(stc.`id`,"☻☻♥♥☻☻") AS stc_pk,
							GROUP_CONCAT(stc.`stc`,"☻☻♥♥☻☻") AS stc,
							stc.`user_pk`
						FROM `code_stc` AS stc
						WHERE stc.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						GROUP BY (stc.`user_pk`)
						ORDER BY (stc.`user_pk`)
					)  AS l ON a.`id` = l.`user_pk`
					LEFT JOIN (
						SELECT
							GROUP_CONCAT(tin.`id`,"☻☻♥♥☻☻") AS tin_pk,
							GROUP_CONCAT(tin.`tin`,"☻☻♥♥☻☻") AS tin,
							tin.`user_pk`
						FROM `code_tin` AS tin
						WHERE tin.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						GROUP BY (tin.`user_pk`)
						ORDER BY (tin.`user_pk`)
					)  AS m ON a.`id` = m.`user_pk`
					LEFT JOIN (
						SELECT
							IF(COUNT(uname.`id`) > 0,COUNT(uname.`id`),0) AS rep_count,
							GROUP_CONCAT(uname.`id`,"☻♥☻") AS rep_id,
							GROUP_CONCAT(uname.`name`,"☻♥☻") AS rep_name,
							uname.user_pk
						FROM `user_name` AS uname
						WHERE uname.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						GROUP BY (uname.`user_pk`)
						ORDER BY (uname.`user_pk`)
					) AS n ON a.`id` = n.`user_pk`
					WHERE a.`status_id` NOT IN (SELECT `id` FROM `status` WHERE (`statu_name` = "Left" OR
																`statu_name` = "Hide" OR
																`statu_name` = "Delete" OR
																`statu_name` = "Fired" OR
																`statu_name` = "Inactive" OR
																`statu_name` = "Flag"))
				) AS clnt ON clnt.`usrid` = req.`from_pk`
				WHERE a.`status_id` = 4
				/*
				AND STR_TO_DATE(e.`prjt_psd`, \'%Y-%m-%d\') >= STR_TO_DATE(\'' . $this->parameters["dfrom"] . '\', \'%Y-%m-%d\')
				AND STR_TO_DATE(e.`prjt_pcd`, \'%Y-%m-%d\') <= STR_TO_DATE(\'' . $this->parameters["dto"] . '\', \'%Y-%m-%d\')
				*/
				ORDER BY (a.`id`);';
    }

    static function processProjectArray($query) {
        $project = NULL;
        executeQuery("SET SESSION group_concat_max_len = 100000000;");
        $res = executeQuery($query);
        $num = mysql_num_rows($res);
        if ($num > 0) {
            $i = 0;
            $project = array();
            while ($row = mysql_fetch_assoc($res)) {
                $project[$i]["proj_manage"] = NULL;
                /* Project management */
                if (isset($row["id"]) && !empty($row["id"]) && $row["id"] != NULL) {
                    $project[$i]["proj_manage"] = array();
                    $project[$i]["proj_manage"]["id"] = $row["id"];
                    $project[$i]["proj_manage"]["req_id"] = $row["req_id"];
                    $project[$i]["proj_manage"]["quot_id"] = $row["quot_id"];
                    $project[$i]["proj_manage"]["po_id"] = $row["po_id"];
                    $project[$i]["proj_manage"]["client_id"] = $row["client_id"];
                    $project[$i]["proj_manage"]["inv_id"] = $row["inv_id"];
                    $project[$i]["proj_manage"]["ref_no"] = $row["proj_ref_no"];
                }
                /* Requirement */
                $project[$i]["requirement"] = NULL;
                if (isset($row["req_id"]) && !empty($row["req_id"]) && $row["req_id"] != NULL) {
                    $project[$i]["requirement"] = array();
                    $project[$i]["requirement"]["id"] = $row["req_id"];
                    $project[$i]["requirement"]["ethno_id"] = $row["ethnographer_id"];
                    $project[$i]["requirement"]["ethno_name"] = $row["ethnographer"];
                    $project[$i]["requirement"]["rep_id"] = $row["representative_id"];
                    $project[$i]["requirement"]["rep_name"] = $row["representative"];
                    $project[$i]["requirement"]["doethno"] = $row["doethno"];
                    $project[$i]["requirement"]["ptotal"] = $row["ptotal"];
                    $project[$i]["requirement"]["totsup"] = $row["totsup"];
                    $project[$i]["requirement"]["totinst"] = $row["totinst"];
                    /* Production / Manufacturing  */
                    $project[$i]["requirement"]["production"] = NULL;
                    $pdescp_id = explode("☻♥♥☻", $row["prod_descp_id"]);
                    if (is_array($pdescp_id) && sizeof($pdescp_id) > 1) {
                        $project[$i]["requirement"]["production"] = array();
                        $particular = explode("☻♥♥☻", $row["particular"]);
                        $qty = explode("☻♥♥☻", $row["qty"]);
                        $unit = explode("☻♥♥☻", $row["unit"]);
                        $req_descp_det_id = explode("☻♥♥☻", $row["req_descp_det_id"]);
                        $supply = explode("☻♥♥☻", $row["supply"]);
                        $installation = explode("☻♥♥☻", $row["installation"]);
                        for ($j = 0; $j < sizeof($pdescp_id) - 1; $j++) {
                            if (isset($pdescp_id[$j]) && isset($particular[$j]) && isset($qty[$j]) && isset($unit[$j])) {
                                $project[$i]["requirement"]["production"][$j]["id"] = ltrim($pdescp_id[$j], ',');
                                $project[$i]["requirement"]["production"][$j]["part"] = ltrim($particular[$j], ',');
                                $project[$i]["requirement"]["production"][$j]["qty"] = ltrim($qty[$j], ',');
                                $project[$i]["requirement"]["production"][$j]["unit"] = ltrim($unit[$j], ',');
                            }
                            $project[$i]["requirement"]["production"][$j]["deliinst"] = NULL;
                            $pdescpd_id = explode("☻♥☻", $req_descp_det_id[$j]);
                            if (is_array($pdescpd_id) && sizeof($pdescpd_id) > 1) {
                                $project[$i]["requirement"]["production"][$j]["deliinst"] = array();
                                $sply = explode("☻♥☻", $supply[$j]);
                                $instal = explode("☻♥☻", $installation[$j]);
                                for ($k = 0; $k < sizeof($pdescpd_id) - 1; $k++) {
                                    $project[$i]["requirement"]["production"][$j]["deliinst"][$k]["id"] = ltrim($pdescpd_id[$k], ',');
                                    $project[$i]["requirement"]["production"][$j]["deliinst"][$k]["supply"] = ltrim($sply[$k], ',');
                                    $project[$i]["requirement"]["production"][$j]["deliinst"][$k]["instal"] = ltrim($instal[$k], ',');
                                }
                            }
                        }
                    }
                    /* Painting */
                    $project[$i]["requirement"]["painting"] = NULL;
                    $block_id = explode("☻♥♥♥☻", $row["block_id"]);
                    if (is_array($block_id) && sizeof($block_id) > 1) {
                        $project[$i]["requirement"]["painting"] = array();
                        $block_name = explode("☻♥♥♥☻", $row["block_name"]);
                        $floor_id = explode("☻♥♥♥☻", $row["floor_id"]);
                        $floor_name = explode("☻♥♥♥☻", $row["floor_name"]);
                        $descp_id = explode("☻♥♥♥☻", $row["paint_descp_id"]);
                        $location = explode("☻♥♥♥☻", $row["location"]);
                        $length = explode("☻♥♥♥☻", $row["length"]);
                        $breadth = explode("☻♥♥♥☻", $row["breadth"]);
                        $area = explode("☻♥♥♥☻", $row["area"]);
                        $rate = explode("☻♥♥♥☻", $row["rate"]);
                        $total = explode("☻♥♥♥☻", $row["total"]);
                        for ($j = 0; $j < sizeof($block_id) - 1; $j++) {
                            $project[$i]["requirement"]["painting"][$j]["id"] = ltrim($block_id[$j], ',');
                            $project[$i]["requirement"]["painting"][$j]["name"] = ltrim($block_name[$j], ',');
                            $project[$i]["requirement"]["painting"][$j]["floor"] = NULL;
                            $flor_id = explode("☻♥♥☻", $floor_id[$j]);
                            if (is_array($flor_id) && sizeof($flor_id) > 1) {
                                $project[$i]["requirement"]["painting"][$j]["floor"] = array();
                                $flor_name = explode("☻♥♥☻", $floor_name[$j]);
                                $dep_id = explode("☻♥♥☻", $descp_id[$j]);
                                $loction = explode("☻♥♥☻", $location[$j]);
                                $lenth = explode("☻♥♥☻", $length[$j]);
                                $breath = explode("☻♥♥☻", $breadth[$j]);
                                $ara = explode("☻♥♥☻", $area[$j]);
                                $rat = explode("☻♥♥☻", $rate[$j]);
                                $totl = explode("☻♥♥☻", $total[$j]);
                                for ($k = 0; $k < sizeof($flor_id) - 1; $k++) {
                                    $project[$i]["requirement"]["painting"][$j]["floor"][$k] = array();
                                    $project[$i]["requirement"]["painting"][$j]["floor"][$k]["id"] = ltrim($flor_id[$k], ',');
                                    $project[$i]["requirement"]["painting"][$j]["floor"][$k]["name"] = ltrim($flor_name[$k], ',');
                                    $project[$i]["requirement"]["painting"][$j]["floor"][$k]["location"] = NULL;
                                    $dpid = explode("☻♥☻", $dep_id[$k]);
                                    if (is_array($dpid) && sizeof($dpid) > 1) {
                                        $project[$i]["requirement"]["painting"][$j]["floor"][$k]["location"] = array();
                                        $loc = explode("☻♥☻", $loction[$k]);
                                        $len = explode("☻♥☻", $lenth[$k]);
                                        $bth = explode("☻♥☻", $breath[$k]);
                                        $are = explode("☻♥☻", $ara[$k]);
                                        $rte = explode("☻♥☻", $rat[$k]);
                                        $tot = explode("☻♥☻", $totl[$k]);
                                        for ($l = 0; $l < sizeof($dpid) - 1; $l++) {
                                            $project[$i]["requirement"]["painting"][$j]["floor"][$k]["location"][$l]["id"] = ltrim($dpid[$l], ',');
                                            $project[$i]["requirement"]["painting"][$j]["floor"][$k]["location"][$l]["loc"] = ltrim($loc[$l], ',');
                                            $project[$i]["requirement"]["painting"][$j]["floor"][$k]["location"][$l]["length"] = ltrim($len[$l], ',');
                                            $project[$i]["requirement"]["painting"][$j]["floor"][$k]["location"][$l]["breadth"] = ltrim($bth[$l], ',');
                                            $project[$i]["requirement"]["painting"][$j]["floor"][$k]["location"][$l]["area"] = ltrim($are[$l], ',');
                                            $project[$i]["requirement"]["painting"][$j]["floor"][$k]["location"][$l]["rate"] = ltrim($rte[$l], ',');
                                            $project[$i]["requirement"]["painting"][$j]["floor"][$k]["location"][$l]["total"] = ltrim($tot[$l], ',');
                                        }
                                    }
                                }
                            }
                        }
                    }
                    /* SRS */
                    $project[$i]["requirement"]["SRS"]["doc_id"] = $row["req_doc_id"];
                    $project[$i]["requirement"]["SRS"]["fn"] = $row["SRS_fn"];
                    $project[$i]["requirement"]["SRS"]["type_id"] = $row["req_doc_type_id"];
                    $project[$i]["requirement"]["SRS"]["doc"] = $row["SRS"];
                    $project[$i]["requirement"]["SRS"]["mmtype"] = $row["req_mime_type"];
                    $project[$i]["requirement"]["SRS"]["doc_type"] = $row["req_doc_type"];
                    $project[$i]["requirement"]["SRS"]["dou"] = $row["req_dou"];
                }
                /* Quotation */
                $project[$i]["quotation"] = NULL;
                if (isset($row["qut_quot_id"]) && $row["qut_quot_id"] > 0) {
                    $project[$i]["quotation"] = array();
                    $project[$i]["quotation"]["id"] = $row["qut_quot_id"];
                    $project[$i]["quotation"]["addresse"] = $row["qut_addresse"];
                    $project[$i]["quotation"]["subject"] = $row["qut_subject"];
                    $project[$i]["quotation"]["descp"] = $row["qut_descp"];
                    $project[$i]["quotation"]["qptotal"] = $row["quot_ptotal"];
                    $project[$i]["quotation"]["qtotins"] = $row["quot_totins"];
                    $project[$i]["quotation"]["qtotsup"] = $row["quot_totsup"];
                    $project[$i]["quotation"]["qvat"] = $row["quot_vat"];
                    $project[$i]["quotation"]["qstc1"] = $row["quot_stc1"];
                    $project[$i]["quotation"]["qecess1"] = $row["quot_stc1_50_1236_2"];
                    $project[$i]["quotation"]["qhecess1"] = $row["quot_stc1_50_1236_1"];
                    $project[$i]["quotation"]["qstc2"] = $row["quot_stc2"];
                    $project[$i]["quotation"]["qecess2"] = $row["quot_stc2_50_1236_2"];
                    $project[$i]["quotation"]["qhecess2"] = $row["quot_stc2_50_1236_1"];
                    $project[$i]["quotation"]["ntotal"] = $row["quot_net_total"];
                    $project[$i]["quotation"]["QUOT"] = NULL;
                    $doc_id = explode("☻♥☻", $row["doc_quot_id"]);
                    if (is_array($doc_id) && sizeof($doc_id) > 1) {
                        $fn = explode("☻♥☻", $row["doc_quot_fn"]);
                        $type_id = explode("☻♥☻", $row["doc_quot_type_id"]);
                        $doc = explode("☻♥☻", $row["doc_quot_QUOT"]);
                        $mmtype = explode("☻♥☻", $row["doc_quot_mime_type"]);
                        $doc_type = explode("☻♥☻", $row["doc_quot_doc_type"]);
                        $dou = explode("☻♥☻", $row["doc_quot_dou"]);
                        for ($j = 0; $j < sizeof($doc_id) - 1; $j++) {
                            if (
                                    isset($doc_id[$j]) &&
                                    isset($fn[$j]) &&
                                    isset($type_id[$j]) &&
                                    isset($doc[$j]) &&
                                    isset($mmtype[$j]) &&
                                    isset($doc_type[$j]) &&
                                    isset($dou[$j])
                            ) {
                                $project[$i]["quotation"]["QUOT"][$j]["doc_id"] = ltrim($doc_id[$j], ',');
                                $project[$i]["quotation"]["QUOT"][$j]["fn"] = ltrim($fn[$j], ',');
                                $project[$i]["quotation"]["QUOT"][$j]["type_id"] = ltrim($type_id[$j], ',');
                                $project[$i]["quotation"]["QUOT"][$j]["doc"] = ltrim($doc[$j], ',');
                                $project[$i]["quotation"]["QUOT"][$j]["mmtype"] = ltrim($mmtype[$j], ',');
                                $project[$i]["quotation"]["QUOT"][$j]["doc_type"] = ltrim($doc_type[$j], ',');
                                $project[$i]["quotation"]["QUOT"][$j]["dou"] = ltrim($dou[$j], ',');
                            }
                        }
                    }
                }
                /* Client purchase Order */
                $project[$i]["PO"] = NULL;
                if (isset($row["cpor_id"]) && !empty($row["cpor_id"]) && $row["cpor_id"] != NULL) {
                    $project[$i]["PO"] = array();
                    $project[$i]["PO"]["id"] = $row["cpor_id"];
                    $project[$i]["PO"]["ref_no"] = $row["cpor_cpo_ref_no"];
                    $project[$i]["PO"]["date"] = $row["cpor_date"];
                    $project[$i]["PO"]["CPO"] = NULL;
                    $doc_id = explode("☻♥☻", $row["cpor_doc_id"]);
                    if (is_array($doc_id) && sizeof($doc_id) > 1) {
                        $fn = explode("☻♥☻", $row["CPO_fn"]);
                        $type_id = explode("☻♥☻", $row["cpor_doc_type_id"]);
                        $doc = explode("☻♥☻", $row["CPO"]);
                        $mmtype = explode("☻♥☻", $row["cpor_doc_mime_type"]);
                        $doc_type = explode("☻♥☻", $row["cpor_doc_type"]);
                        $dou = explode("☻♥☻", $row["cpor_doc_dou"]);
                        for ($j = 0; $j < sizeof($doc_id) - 1; $j++) {
                            if (isset($doc_id[$j]) &&
                                    isset($fn[$j]) &&
                                    isset($type_id[$j]) &&
                                    isset($doc[$j]) &&
                                    isset($mmtype[$j]) &&
                                    isset($doc_type[$j]) &&
                                    isset($dou[$j])) {
                                $project[$i]["PO"]["CPO"][$j]["doc_id"] = ltrim($doc_id[$j], ',');
                                $project[$i]["PO"]["CPO"][$j]["fn"] = ltrim($fn[$j], ',');
                                $project[$i]["PO"]["CPO"][$j]["type_id"] = ltrim($type_id[$j], ',');
                                $project[$i]["PO"]["CPO"][$j]["doc"] = ltrim($doc[$j], ',');
                                $project[$i]["PO"]["CPO"][$j]["mmtype"] = ltrim($mmtype[$j], ',');
                                $project[$i]["PO"]["CPO"][$j]["doc_type"] = ltrim($doc_type[$j], ',');
                                $project[$i]["PO"]["CPO"][$j]["dou"] = ltrim($dou[$j], ',');
                            }
                        }
                    }
                }
                /* Project */
                $project[$i]["project"] = NULL;
                if (isset($row["prjt_id"]) && !empty($row["prjt_id"]) && $row["prjt_id"] != NULL) {
                    $project[$i]["project"]["id"] = $row["prjt_id"];
                    $project[$i]["project"]["name"] = $row["prjt_name"];
                    $project[$i]["project"]["md"] = $row["prjt_md"];
                    $project[$i]["project"]["eng"] = $row["prjt_eng"];
                    $project[$i]["project"]["mng"] = $row["prjt_mng"];
                    $project[$i]["project"]["hld"] = $row["prjt_hld"];
                    $project[$i]["project"]["psd"] = $row["prjt_psd"];
                    $project[$i]["project"]["pcd"] = $row["prjt_pcd"];
                    $project[$i]["project"]["discussed"] = $row["prjt_discussed"];
                    $project[$i]["project"]["progress"] = $row["prjt_progress"];
                    $project[$i]["project"]["timeline"] = $row["prjt_met_timeline"];
                    $project[$i]["project"]["descp"] = NULL;
                    /* Project Description */
                    $pdes_id = explode("☻♥♥☻", $row["prj_des_id"]);
                    if (is_array($pdes_id) && sizeof($pdes_id) > 1) {
                        $project[$i]["project"]["descp"] = array();
                        $prj_des_proj_id = $row["prj_des_proj_id"];
                        $prj_des_task = explode("☻♥♥☻", $row["prj_des_task"]);
                        $prj_des_production = explode("☻♥♥☻", $row["prj_des_production"]);
                        $prj_des_status = explode("☻♥♥☻", $row["prj_des_status"]);
                        $prj_des_feedback = explode("☻♥♥☻", $row["prj_des_feedback"]);
                        $prj_des_obstacles = explode("☻♥♥☻", $row["prj_des_obstacles"]);
                        for ($j = 0; $j < sizeof($pdes_id) - 1; $j++) {
                            $project[$i]["project"]["descp"][$j]["id"] = ltrim($pdes_id[$j], ',');
                            $project[$i]["project"]["descp"][$j]["task"] = ltrim($prj_des_task[$j], ',');
                            $project[$i]["project"]["descp"][$j]["production"] = ltrim($prj_des_production[$j], ',');
                            $project[$i]["project"]["descp"][$j]["status"] = ltrim($prj_des_status[$j], ',');
                            $project[$i]["project"]["descp"][$j]["feedback"] = ltrim($prj_des_feedback[$j], ',');
                            $project[$i]["project"]["descp"][$j]["obstacles"] = ltrim($prj_des_obstacles[$j], ',');
                            /* PCC */
                            $project[$i]["project"]["descp"][$j]["pcc"] = NULL;
                            $pcc_id = explode("☻♥♥☻", $row["pcc_id"]);
                            if (is_array($pcc_id) && sizeof($pcc_id) > 1) {
                                $project[$i]["project"]["descp"][$j]["pcc"] = array();
                                $pcc_name = explode("☻♥♥☻", $row["pcc_name"]);
                                $pcc_city = explode("☻♥♥☻", $row["pcc_city"]);
                                $pcc_code = explode("☻♥♥☻", $row["pcc_code"]);
                                $pcc_revision = explode("☻♥♥☻", $row["pcc_revision"]);
                                $pcc_sd_wood = explode("☻♥♥☻", $row["pcc_sd_wood"]);
                                $pcc_sd_metal = explode("☻♥♥☻", $row["pcc_sd_metal"]);
                                $pcc_ed_project = explode("☻♥♥☻", $row["pcc_ed_project"]);
                                $pcc_frame_config = explode("☻♥♥☻", $row["pcc_frame_config"]);
                                $pcc_wrkstn_height = explode("☻♥♥☻", $row["pcc_wrkstn_height"]);
                                $pcc_tot_wrkstn = explode("☻♥♥☻", $row["pcc_tot_wrkstn"]);
                                /* PCC_task */
                                $task_descp_id = explode("☻♥♥☻", $row["pcc_task_descp_id"][$j]);
                                $task_descp_mat_descp = explode("☻♥♥☻", $row["pcc_task_descp_mat_descp"]);
                                $task_descp_size = explode("☻♥♥☻", $row["pcc_task_descp_size"]);
                                $task_descp_colour = explode("☻♥♥☻", $row["pcc_task_descp_colour"]);
                                $task_descp_qty = explode("☻♥♥☻", $row["pcc_task_descp_qty"]);
                                $task_descp_remark = explode("☻♥♥☻", $row["pcc_task_descp_remark"]);
                                $project[$i]["project"]["descp"][$j]["pcc"] = NULL;
                                for ($k = 0; $k < sizeof($pcc_id) - 1; $k++) {
                                    /* PCC_task */
                                    $project[$i]["project"]["descp"][$j]["pcc"][$k]["id"] = ltrim($pcc_id[$k], ',');
                                    $project[$i]["project"]["descp"][$j]["pcc"][$k]["name"] = ltrim($pcc_name[$k], ',');
                                    $project[$i]["project"]["descp"][$j]["pcc"][$k]["city"] = ltrim($pcc_city[$k], ',');
                                    $project[$i]["project"]["descp"][$j]["pcc"][$k]["rev"] = ltrim($pcc_revision[$k], ',');
                                    $project[$i]["project"]["descp"][$j]["pcc"][$k]["sdwood"] = ltrim($pcc_sd_wood[$k], ',');
                                    $project[$i]["project"]["descp"][$j]["pcc"][$k]["sdmetal"] = ltrim($pcc_sd_metal[$k], ',');
                                    $project[$i]["project"]["descp"][$j]["pcc"][$k]["edproject"] = ltrim($pcc_ed_project[$k], ',');
                                    $project[$i]["project"]["descp"][$j]["pcc"][$k]["frameconfig"] = ltrim($pcc_frame_config[$k], ',');
                                    $project[$i]["project"]["descp"][$j]["pcc"][$k]["wrkstnhet"] = ltrim($pcc_wrkstn_height[$k], ',');
                                    $project[$i]["project"]["descp"][$j]["pcc"][$k]["totwrkstn"] = ltrim($pcc_tot_wrkstn[$k], ',');
                                    $project[$i]["project"]["descp"][$j]["pcc"][$k]["task"] = NULL;
                                    $task_descp_id = explode("☻♥☻", $task_descp_id[$k]);
                                    if (is_array($task_descp_id) && sizeof($task_descp_id) > 1) {
                                        /* PCC_task_descp */
                                        $taskdescpid = explode("☻♥☻", $task_descp_id[$k]);
                                        $taskdescpmatdescp = explode("☻♥☻", $task_descp_mat_descp[$k]);
                                        $taskdescpsize = explode("☻♥☻", $task_descp_size[$k]);
                                        $taskdescpcolour = explode("☻♥☻", $task_descp_colour[$k]);
                                        $taskdescpqty = explode("☻♥☻", $task_descp_qty[$k]);
                                        $taskdescpremark = explode("☻♥☻", $task_descp_remark[$k]);
                                        if (is_array($task_descp_id) && sizeof($task_descp_id) > 1) {
                                            for ($l = 0; $l < sizeof($task_descp_id) - 1; $l++) {
                                                $project[$i]["project"]["descp"][$j]["pcc"][$k]["task"][$l]["id"] = ltrim($taskdescpid[$l], ',');
                                                $project[$i]["project"]["descp"][$j]["pcc"][$k]["task"][$l]["descp"] = ltrim($taskdescpmatdescp[$l], ',');
                                                $project[$i]["project"]["descp"][$j]["pcc"][$k]["task"][$l]["size"] = ltrim($taskdescpsize[$l], ',');
                                                $project[$i]["project"]["descp"][$j]["pcc"][$k]["task"][$l]["color"] = ltrim($taskdescpcolour[$l], ',');
                                                $project[$i]["project"]["descp"][$j]["pcc"][$k]["task"][$l]["qty"] = ltrim($taskdescpqty[$l], ',');
                                                $project[$i]["project"]["descp"][$j]["pcc"][$k]["task"][$l]["remark"] = ltrim($taskdescpremark[$l], ',');
                                            }
                                        }
                                    }
                                }
                            }
                            /* PCC chart */
                            $project[$i]["project"]["descp"][$j]["PCCCHART"] = NULL;
                            $pcc_doc_id = explode("☻♥♥☻", $row["pcc_doc_id"]);
                            if (is_array($pcc_doc_id) && sizeof($pcc_doc_id) > 1) {
                                $project[$i]["project"]["descp"][$j]["PCCCHART"] = array();
                                $pcc_doc_fn = explode("☻♥♥☻", $row["pcc_doc_fn"][$j]);
                                $pcc_doc_type_id = explode("☻♥♥☻", $row["pcc_doc_type_id"][$j]);
                                $pcc_doc_PCCHART = explode("☻♥♥☻", $row["pcc_doc_PCCHART"][$j]);
                                $pcc_doc_mime_type = explode("☻♥♥☻", $row["pcc_doc_mime_type"][$j]);
                                $pcc_doc_type = explode("☻♥♥☻", $row["pcc_doc_type"][$j]);
                                $pcc_doc_dou = explode("☻♥♥☻", $row["pcc_doc_dou"][$j]);
                                for ($k = 0; $k < sizeof($pcc_doc_id) - 1; $k++) {
                                    if (isset($pcc_doc_id[$k]) &&
                                            isset($pcc_doc_fn[$k]) &&
                                            isset($pcc_doc_type_id[$k]) &&
                                            isset($pcc_doc_PCCHART[$k]) &&
                                            isset($pcc_doc_mime_type[$k]) &&
                                            isset($pcc_doc_type[$k]) &&
                                            isset($pcc_doc_dou[$k])) {
                                        $project[$i]["project"]["descp"][$j]["PCCCHART"]["doc_id"] = ltrim($pcc_doc_id[$k], ',');
                                        $project[$i]["project"]["descp"][$j]["PCCCHART"]["fn"] = ltrim($pcc_doc_fn[$k], ',');
                                        $project[$i]["project"]["descp"][$j]["PCCCHART"]["type_id"] = ltrim($pcc_doc_type_id[$k], ',');
                                        $project[$i]["project"]["descp"][$j]["PCCCHART"]["doc"] = ltrim($pcc_doc_PCCHART[$k], ',');
                                        $project[$i]["project"]["descp"][$j]["PCCCHART"]["mmtype"] = ltrim($pcc_doc_mime_type[$k], ',');
                                        $project[$i]["project"]["descp"][$j]["PCCCHART"]["doc_type"] = ltrim($pcc_doc_type[$k], ',');
                                        $project[$i]["project"]["descp"][$j]["PCCCHART"]["dou"] = ltrim($pcc_doc_dou[$k], ',');
                                    }
                                }
                            }
                            /* Drawing */
                            $project[$i]["project"]["descp"][$j]["draw"] = NULL;
                            if (isset($row["draw_id"])) {
                                $project[$i]["project"]["descp"][$j]["draw"] = array();
                                $project[$i]["project"]["descp"][$j]["draw"]["id"] = $row["draw_id"];
                                $project[$i]["project"]["descp"][$j]["draw"]["dsid"] = $row["draw_designer_id"];
                                $project[$i]["project"]["descp"][$j]["draw"]["designer"] = $row["draw_designer"];
                                $project[$i]["project"]["descp"][$j]["draw"]["name"] = $row["draw_name"];
                                $project[$i]["project"]["descp"][$j]["draw"]["dou"] = $row["draw_up_date"];
                                $project[$i]["project"]["descp"][$j]["draw"]["doc"] = NULL;
                                /* Drawing File */
                                $draw_doc_id = explode("☻♥☻", $row["draw_doc_id"]);
                                if (is_array($draw_doc_id) && sizeof($draw_doc_id) > 1) {
                                    $draw_doc_fn = explode("☻♥☻", $row["draw_doc_fn"]);
                                    $draw_doc_type_id = explode("☻♥☻", $row["draw_doc_type_id"]);
                                    $draw_doc_DRAWING = explode("☻♥☻", $row["draw_doc_DRAWING"]);
                                    $draw_doc_mime_type = explode("☻♥☻", $row["draw_doc_mime_type"]);
                                    $draw_doc_type = explode("☻♥☻", $row["draw_doc_type"]);
                                    $draw_doc_dou = explode("☻♥☻", $row["draw_doc_dou"]);
                                    for ($k = 0; $k < sizeof($draw_id) - 1; $k++) {
                                        $project[$i]["project"]["descp"][$j]["draw"]["doc"][$k]["id"] = ltrim($draw_doc_id[$j], ',');
                                        $project[$i]["project"]["descp"][$j]["draw"]["doc"][$k]["fn"] = ltrim($draw_doc_fn[$j], ',');
                                        $project[$i]["project"]["descp"][$j]["draw"]["doc"][$k]["type_id"] = ltrim($draw_doc_type_id[$j], ',');
                                        $project[$i]["project"]["descp"][$j]["draw"]["doc"][$k]["doc"] = ltrim($draw_doc_DRAWING[$j], ',');
                                        $project[$i]["project"]["descp"][$j]["draw"]["doc"][$k]["mmtype"] = ltrim($draw_doc_mime_type[$j], ',');
                                        $project[$i]["project"]["descp"][$j]["draw"]["doc"][$k]["doc_type"] = ltrim($draw_doc_type[$j], ',');
                                        $project[$i]["project"]["descp"][$j]["draw"]["doc"][$k]["dou"] = ltrim($draw_doc_dou[$j], ',');
                                    }
                                }
                            }
                            /* Team Members */
                            $team_mem_id = explode("☻♥♥☻", $row["team_mem_id"]);
                            $project[$i]["project"]["descp"][$j]["members"] = NULL;
                            if (is_array($team_mem_id) && sizeof($team_mem_id) > 1) {
                                $project[$i]["project"]["descp"][$j]["members"] = array();
                                $team_member_id = explode("☻♥♥☻", $row["team_member_id"]);
                                $team_member = explode("☻♥♥☻", $row["team_member"]);
                                $team_mem_status = explode("☻♥♥☻", $row["team_mem_status"]);
                                for ($k = 0; $k < sizeof($team_mem_id) - 1; $k++) {
                                    $project[$i]["project"]["descp"][$j]["members"][$k]["id"] = ltrim($team_mem_id[$k], ',');
                                    $project[$i]["project"]["descp"][$j]["members"][$k]["mid"] = ltrim($team_member_id[$k], ',');
                                    $project[$i]["project"]["descp"][$j]["members"][$k]["member"] = ltrim($team_member[$k], ',');
                                    $project[$i]["project"]["descp"][$j]["members"][$k]["status"] = ltrim($team_mem_status[$k], ',');
                                }
                            }
                        }
                    }
                }
                /* Invoice */
                $project[$i]["invoice"] = NULL;
                if (isset($row["invc_id"]) && !empty($row["invc_id"]) && $row["invc_id"] != NULL) {
                    $project[$i]["invoice"]["id"] = $row["invc_id"];
                    $project[$i]["invoice"]["addresse"] = $row["invc_addresse"];
                    $project[$i]["invoice"]["subject"] = $row["invc_subject"];
                    $project[$i]["invoice"]["descp"] = $row["invc_descp"];
                    $project[$i]["invoice"]["iptotal"] = $row["invc_ptotal"];
                    $project[$i]["invoice"]["itotsup"] = $row["invc_totsup"];
                    $project[$i]["invoice"]["itotins"] = $row["invc_totins"];
                    $project[$i]["invoice"]["ivat"] = $row["invc_vat"];
                    $project[$i]["invoice"]["istc1"] = $row["invc_stc1"];
                    $project[$i]["invoice"]["iecess1"] = $row["invc_stc1_50_1236_2"];
                    $project[$i]["invoice"]["ihecess1"] = $row["invc_stc1_50_1236_1"];
                    $project[$i]["invoice"]["istc2"] = $row["invc_stc2"];
                    $project[$i]["invoice"]["iecess2"] = $row["invc_stc2_50_1236_2"];
                    $project[$i]["invoice"]["ihecess2"] = $row["invc_stc2_50_1236_1"];
                    $project[$i]["invoice"]["ntotal"] = $row["invc_net_total"];
                    /* Invoice Vehicle */
                    $project[$i]["invoice"]["driver"] = $row["invc_veh_driver"];
                    $project[$i]["invoice"]["vehicle_no"] = $row["invc_veh_vehicle_no"];
                    $project[$i]["invoice"]["mot"] = $row["invc_veh_mot"];
                    $project[$i]["invoice"]["empty_weight"] = $row["invc_veh_empty_weight"];
                    $project[$i]["invoice"]["loaded_weight"] = $row["invc_veh_loaded_weight"];
                    $project[$i]["invoice"]["total_weight"] = $row["invc_veh_total_weight"];
                    $project[$i]["invoice"]["advance_amt"] = $row["invc_veh_advance_amt"];
                    $project[$i]["invoice"]["rent"] = $row["invc_veh_rent"];
                    $project[$i]["invoice"]["arrival"] = $row["invc_veh_arrival"];
                    $project[$i]["invoice"]["departure"] = $row["invc_veh_departure"];
                    /* Invoice Document */
                    $project[$i]["invoice"]["doc"] = NULL;
                    $invc_doc_id = explode("☻♥☻", $row["invc_doc_id"]);
                    if (is_array($invc_doc_id) && sizeof($invc_doc_id) > 1) {
                        $project[$i]["invoice"]["doc"] = array();
                        $invc_fn = explode("☻♥☻", $row["invc_fn"]);
                        $invc_doc_type_id = explode("☻♥☻", $row["invc_doc_type_id"]);
                        $invc_doc_INVOICE = explode("☻♥☻", $row["invc_doc_INVOICE"]);
                        $invc_doc_mime_type = explode("☻♥☻", $row["invc_doc_mime_type"]);
                        $invc_doc_type = explode("☻♥☻", $row["invc_doc_type"]);
                        $invc_doc_dou = explode("☻♥☻", $row["invc_doc_dou"]);
                        for ($k = 0; $k < sizeof($invc_doc_id) - 1 && isset($project[$i]["invoice"]["doc"][$k]["id"]); $k++) {
                            $project[$i]["invoice"]["doc"][$k]["id"] = ltrim($invc_doc_id[$j], ',');
                            $project[$i]["invoice"]["doc"][$k]["fn"] = ltrim($invc_fn[$j], ',');
                            $project[$i]["invoice"]["doc"][$k]["type_id"] = ltrim($invc_doc_type_id[$j], ',');
                            $project[$i]["invoice"]["doc"][$k]["doc"] = ltrim($invc_doc_INVOICE[$j], ',');
                            $project[$i]["invoice"]["doc"][$k]["mmtype"] = ltrim($invc_doc_mime_type[$j], ',');
                            $project[$i]["invoice"]["doc"][$k]["doc_type"] = ltrim($invc_doc_type[$j], ',');
                            $project[$i]["invoice"]["doc"][$k]["dou"] = ltrim($invc_doc_dou[$j], ',');
                        }
                    }
                }
                /* Client */
                $project[$i]["client"] = NULL;
                if (isset($row["usrid"]) && !empty($row["usrid"]) && $row["usrid"] != NULL) {
                    $project[$i]["client"]["id"] = $row["usrid"];
                    $project[$i]["client"]["name"] = $row["user_name"];
                    $project[$i]["client"]["directory"] = $row["directory"];
                    $project[$i]["client"]["photo"] = $row["usrphoto"];
                    $project[$i]["client"]["email"] = explode("☻☻♥♥☻☻", $row["email"])[0];
                    $project[$i]["client"]["cellnumber"] = explode("☻☻♥♥☻☻", $row["cnumber"])[0];
                    $project[$i]["client"]["pcode"] = $row["pcode"];
                    $project[$i]["client"]["tnumber"] = $row["tnumber"];
                    $project[$i]["client"]["addressline"] = $row["addressline"];
                    $project[$i]["client"]["town"] = $row["town"];
                    $project[$i]["client"]["city"] = $row["city"];
                    $project[$i]["client"]["district"] = $row["district"];
                    $project[$i]["client"]["province"] = $row["province"];
                    $project[$i]["client"]["country"] = $row["country"];
                    $project[$i]["client"]["zipcode"] = $row["zipcode"];
                }
                $i++;
            }
        }
        $_SESSION["report"] = $project;
        return $project;
    }

    public function generateReport() {
        $this->array_project = report::processProjectArray($this->query_project);
        $project = $this->array_project;
        $requirement = $this->array_project;
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator(SOFT_NAME)
                ->setLastModifiedBy(SOFT_NAME)
                ->setTitle('Project Plan Chart')
                ->setSubject('Project Plan Chart')
                ->setDescription('Report generated by ' . SOFT_NAME . ' (Management Information System) Powered By MadMec.')
                ->setKeywords('MadMec')
                ->setCategory('Document');
        /* Draw table */
        $styleArray1 = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THICK,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
        );
        $styleArray2 = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
        );
        $myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'Project Plan Chart');
        $objPHPExcel->addSheet($myWorkSheet, 0);
        $objPHPExcel->setActiveSheetIndexByName('Project Plan Chart');
        $objPHPExcel->getActiveSheet()
                ->getPageSetup()
                ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT)
                ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4)
                ->setHorizontalCentered(true)
                ->setVerticalCentered(false);
        $objPHPExcel->getActiveSheet()
                ->getHeaderFooter()
                ->setOddHeader('&C&H Project Plan Chart Document Generated on ' . date('j-M-Y'))
                ->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');
        /* Setting a column’s width
          foreach(range('B','I') as $columnID) {
          $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
          ->setAutoSize(true);
          }
         */
        /* 4.6.30.	Group / outline a row */
        // $objPHPExcel->getActiveSheet()->getRowDimension('1')->setOutlineLevel(2);
        /* Prepare layout */
        $objPHPExcel->getActiveSheet()
                ->setCellValueByColumnAndRow(0, 1, 'Project Plan Chart');
        $objPHPExcel->getActiveSheet()
                /* HEADER */
                ->mergeCells('A1:P1');
        $objPHPExcel->getActiveSheet()->getStyle('A1:O1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyle('A1:O1')->getFill()->getStartColor()->setARGB('FF99AD88');
        $objPHPExcel->getActiveSheet()
                ->getStyle('A1:O1')
                ->getAlignment()
                ->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                ->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        /* Project Plan */
        /* Add titles  of the columns */
        $objPHPExcel->getActiveSheet()
                ->setCellValueByColumnAndRow(0, 2, 'SI No')
                ->setCellValueByColumnAndRow(1, 2, 'Project Manager')
                ->setCellValueByColumnAndRow(2, 2, 'Client')
                ->setCellValueByColumnAndRow(3, 2, 'Representative')
                ->setCellValueByColumnAndRow(4, 2, 'Project Name')
                ->setCellValueByColumnAndRow(5, 2, 'Planned Start Date')
                ->setCellValueByColumnAndRow(6, 2, 'Planned Committed Date')
                ->setCellValueByColumnAndRow(7, 2, 'Seen / Discussed')
                ->setCellValueByColumnAndRow(8, 2, 'Project Team members')
                ->setCellValueByColumnAndRow(9, 2, 'Project Status')
                ->setCellValueByColumnAndRow(10, 2, 'RSD')
                ->setCellValueByColumnAndRow(11, 2, 'Quotation')
                ->setCellValueByColumnAndRow(12, 2, 'Purchase Order')
                // ->setCellValueByColumnAndRow(13,2, 'PCC')
                ->setCellValueByColumnAndRow(13, 2, 'Invoice')
                ->setCellValueByColumnAndRow(14, 2, 'Met Time line');
        /* Colour the borders */
        $objPHPExcel->getActiveSheet()->getStyle('A1:P1')->applyFromArray($styleArray2);
        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($styleArray2);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($styleArray2);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($styleArray2);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($styleArray2);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($styleArray2);
        $objPHPExcel->getActiveSheet()->getStyle('F2')->applyFromArray($styleArray2);
        $objPHPExcel->getActiveSheet()->getStyle('G2')->applyFromArray($styleArray2);
        $objPHPExcel->getActiveSheet()->getStyle('H2')->applyFromArray($styleArray2);
        $objPHPExcel->getActiveSheet()->getStyle('I2')->applyFromArray($styleArray2);
        $objPHPExcel->getActiveSheet()->getStyle('J2')->applyFromArray($styleArray2);
        $objPHPExcel->getActiveSheet()->getStyle('K2')->applyFromArray($styleArray2);
        $objPHPExcel->getActiveSheet()->getStyle('L2')->applyFromArray($styleArray2);
        $objPHPExcel->getActiveSheet()->getStyle('M2')->applyFromArray($styleArray2);
        $objPHPExcel->getActiveSheet()->getStyle('N2')->applyFromArray($styleArray2);
        $objPHPExcel->getActiveSheet()->getStyle('O2')->applyFromArray($styleArray2);
        // $objPHPExcel->getActiveSheet()->getStyle('P2')->applyFromArray($styleArray2);
        /* SI No */
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(6);
        /* Project Manager */
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
        /* Client */
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
        /* Representative */
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(18);
        /* Project Name */
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
        /* Planned Start Date */
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(18);
        /* Planned Committed Date */
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
        /* Seen / Discussed */
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        /* Project Team members */
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(45);
        /* Project Status */
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        /* RSD */
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
        /* Quotation */
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
        /* Purchase Order */
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(30);
        /* PCC */
        // $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(30);
        /* Invoice */
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(30);
        /* Met Time line */
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
        $objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(25);
        // If you want to make a hyperlink to another worksheet/cell, use the following code:
        // $objPHPExcel->getActiveSheet()->setCellValue('E26', 'www.phpexcel.net');
        // $objPHPExcel->getActiveSheet()->getCell('E26')->getHyperlink()->setUrl(“sheet://'Sheetname'!A1”);
        /* Here there will be some code where you create $objPHPExcel */

        // redirect output to client browser
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment;filename="myfile.xlsx"');
        // header('Cache-Control: max-age=0');
        // $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        // $objWriter->save('php://output');
        $si_no = 1;
        $row = 3;
        for ($i = 0; $i < sizeof($project); $i++) {
            $newarr = explode(" ", str_replace($this->order, $this->replace, $project[$i]["requirement"]["production"][0]["part"]));
            $prod = 5;
            $count = 1;
            for ($loop = 0; $loop < sizeof($newarr); $loop++) {
                if ($loop == $prod) {
                    $count++;
                    $prod*=$count;
                }
            }
            $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight($count * 20);
            $objPHPExcel->getActiveSheet()
                    ->setCellValueByColumnAndRow(0, $row, $si_no)
                    ->setCellValueByColumnAndRow(1, $row, $project[$i]["project"]["mng"])
                    ->setCellValueByColumnAndRow(2, $row, $project[$i]["client"]["name"])
                    ->setCellValueByColumnAndRow(3, $row, $project[$i]["requirement"]["rep_name"])
                    ->setCellValueByColumnAndRow(4, $row, $project[$i]["project"]["name"])
                    ->setCellValueByColumnAndRow(5, $row, date('j-M-Y', strtotime($project[$i]["project"]["psd"])))
                    ->setCellValueByColumnAndRow(6, $row, date('j-M-Y', strtotime($project[$i]["project"]["pcd"])))
                    ->setCellValueByColumnAndRow(7, $row, $project[$i]["project"]["discussed"])
                    ->setCellValueByColumnAndRow(8, $row, 'Team members')
                    ->setCellValueByColumnAndRow(9, $row, $project[$i]["project"]["progress"])
                    ->setCellValueByColumnAndRow(14, $row, $project[$i]["project"]["timeline"]);
            /* RSD */
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, 'requi-' . $project[$i]["proj_manage"]["ref_no"]);
            if (isset($project[$i]["requirement"]["SRS"]["doc"]) && $project[$i]["requirement"]["SRS"]["doc"] != NULL && $project[$i]["requirement"]["SRS"]["doc"] != '')
                $objPHPExcel->getActiveSheet()->getCell('K' . $row)->getHyperlink()->setUrl($project[$i]["requirement"]["SRS"]["doc"]);

            /* Quotation */
            $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, 'quot-' . $project[$i]["proj_manage"]["ref_no"]);
            $ind = sizeof($project[$i]["quotation"]["QUOT"]) - 1;
            if (isset($project[$i]["quotation"]["QUOT"][$ind]["doc"]) && $project[$i]["quotation"]["QUOT"][$ind]["doc"] != NULL && $project[$i]["quotation"]["QUOT"][$ind]["doc"] != '') {
                $qt = $project[$i]["quotation"]["QUOT"][$ind]["doc"];
                $objPHPExcel->getActiveSheet()->getCell('L' . $row)->getHyperlink()->setUrl($qt);
            }
            /* Purchase Order */
            $objPHPExcel->getActiveSheet()->setCellValue('M' . $row, 'cpo-' . $project[$i]["proj_manage"]["ref_no"]);
            $ind = sizeof($project[$i]["PO"]["CPO"]) - 1;
            if (isset($project[$i]["PO"]["CPO"][$ind]["doc"]) && $project[$i]["PO"]["CPO"][$ind]["doc"] != NULL && $project[$i]["PO"]["CPO"][$ind]["doc"] != '') {
                $cpo = $project[$i]["PO"]["CPO"][$ind]["doc"];
                $objPHPExcel->getActiveSheet()->getCell('M' . $row)->getHyperlink()->setUrl($cpo);
            }
            // /* PCC */
            // $project[$i]["project"]["descp"][$j]["PCCCHART"]["doc"]
            // $objPHPExcel->getActiveSheet()->setCellValue('N'.$row, 'pcc-'.$project[$i]["proj_manage"]["ref_no"]);
            // $ind = sizeof($project[$i]["PO"]["CPO"])-1;
            // if(isset($project[$i]["PO"]["CPO"][$ind]["doc"]) && $project[$i]["PO"]["CPO"][$ind]["doc"] != NULL && $project[$i]["PO"]["CPO"][$ind]["doc"] != ''){
            // $cpo = $project[$i]["PO"]["CPO"][$ind]["doc"];
            // $objPHPExcel->getActiveSheet()->getCell('M'.$row)->getHyperlink()->setUrl($cpo);
            // }
            /* Invoice */
            $objPHPExcel->getActiveSheet()->setCellValue('N' . $row, 'pcc-' . $project[$i]["proj_manage"]["ref_no"]);
            $ind = sizeof($project[$i]["invoice"]["doc"]) - 1;
            if (isset($project[$i]["invoice"]["doc"][$ind]["doc"]) && $project[$i]["invoice"]["doc"][$ind]["doc"] != NULL && $project[$i]["invoice"]["doc"][$ind]["doc"] != '') {
                $inv = $project[$i]["invoice"]["doc"][$ind]["doc"];
                $objPHPExcel->getActiveSheet()->getCell('N' . $row)->getHyperlink()->setUrl($inv);
            }
            $objPHPExcel->getActiveSheet()->getStyle('A' . ($row))->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('B' . ($row))->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('C' . ($row))->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('D' . ($row))->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('E' . ($row))->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('F' . ($row))->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('G' . ($row))->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('H' . ($row))->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('I' . ($row))->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('J' . ($row))->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('K' . ($row))->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('L' . ($row))->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('M' . ($row))->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('N' . ($row))->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('O' . ($row))->applyFromArray($styleArray2);
            // $objPHPExcel->getActiveSheet()->getStyle('P'.($row))->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()
                    ->getStyle('A' . ($row) . ':O' . ($row))
                    ->getAlignment()
                    ->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                    ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $row+=1;
            $si_no+=1;
        }
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $filepath = DOC_ROOT . DOWNLOADS . "report.xlsx";
        $urlpath = URL . DOWNLOADS . "report.xlsx";
        $objWriter->save($filepath);
        echo '<a href="' . $urlpath . '" class="btn btn-success btn-lg">Download</a>';
        unset($objWriter);
    }

}

?>