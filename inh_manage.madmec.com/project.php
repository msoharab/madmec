<?php

class project {

    protected $parameters = array();
    private $order = array("\r\n", "\n", "\r");
    private $replace = ' ';
    private $query_project = '';
    private $query_lstdocs = '';
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
				ORDER BY (a.`id`);';
        if (isset($this->parameters["what"]))
            $this->query_lstdocs = 'SELECT
							`id`,
							`file_name`,
							`type_id`,
							CASE WHEN (`doc_loc` IS NULL OR `doc_loc` = "")
								 THEN "' . NULLLINK . '"
								 ELSE CONCAT("href=\"javascript:void(0);\" onClick=\"window.open(\'' . URL . '",`doc_loc`,"\');\"")
							END  AS doc_loc,
							`mime_type`,
							`doc_type`,
							DATE_FORMAT(`dou`,"%Y-%c-%d") AS dou
						FROM `documents`
						WHERE `status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
						AND `doc_type` = \'' . $this->parameters["what"] . '\'
						ORDER BY (`id`) DESC;';
    }

    public function addRequi() {
        $requi_pk = 0;
        $requi_desc_man_pk = array();
        $requi_desc_pat_pk = array();
        $block_id = 0;
        $floor_id = 0;
        $quot_pk = 0;
        $cpo_pk = 0;
        $proj_pk = 0;
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $ref_no = sprintf("%010s", mysql_result(executeQuery('SELECT COUNT(DISTINCT(`id`)) FROM `requirements`;'), 0) + 1);
        $curr_time = mysql_result(executeQuery("SELECT NOW();"), 0);
        /* Requirements */
        $query = 'INSERT INTO  `requirements` (`id`,
						`from_pk`,
						`to_pk`,
						`representative`,
						`ethnographer`,
						`ref_no`,
						`doethno`,
						`status_id`)  VALUES(
					NULL,
					\'' . mysql_real_escape_string($this->parameters["cliid"]) . '\',
					\'' . mysql_real_escape_string($_SESSION["IOS"]["id"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["cpnid"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["ethid"]) . '\',
					\'' . mysql_real_escape_string($ref_no) . '\',
					\'' . mysql_real_escape_string($this->parameters["doe"]) . '\',
					default);';
        if (executeQuery($query)) {
            $requi_pk = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
            /* Manufacturing project */
            /* Requirement Description */
            if (is_array($this->parameters["part"]) && sizeof($this->parameters["part"]) > -1) {
                for ($i = 0; $i < sizeof($this->parameters["part"]); $i++) {
                    $query = 'INSERT INTO  `requi_descp` (`id`,
							`requi_id`,
							`particular`,
							`qty`,
							`unit_id`,
							`block_id`,
							`floor_id`,
							`length`,
							`breadth`,
							`area`,
							`rate`,
							`total`,
							`status_id` ) VALUES(NULL,
							\'' . mysql_real_escape_string($requi_pk) . '\',
							\'' . mysql_real_escape_string($this->parameters["part"][$i]["parti"]) . '\',
							\'' . mysql_real_escape_string($this->parameters["part"][$i]["qty"]) . '\',
							\'' . mysql_real_escape_string($this->parameters["part"][$i]["unit"]) . '\',
							default,default,default,default,default,default,default,default);';
                    executeQuery($query);
                    /* Requirement Description Details */
                    $requi_desc_man_pk[$i] = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
                    for ($j = 0; $j < sizeof($this->parameters["part"][$i]["deliinst"]); $j++) {
                        $query = 'INSERT INTO  `requi_descp_details` (`id`,
								`requi_descp_id`,
								`supply`,
								`installation`,
								`status_id` ) VALUES(NULL,
								\'' . mysql_real_escape_string($requi_desc_man_pk[$i]) . '\',
								\'' . mysql_real_escape_string($this->parameters["part"][$i]["deliinst"][$j]["supply"]) . '\',
								\'' . mysql_real_escape_string($this->parameters["part"][$i]["deliinst"][$j]["instal"]) . '\',
								default);';
                        executeQuery($query);
                    }
                }
            }
            /* Painting project */
            if (is_array($this->parameters["paint"]) && sizeof($this->parameters["paint"]) > -1) {
                for ($i = 0; $i < sizeof($this->parameters["paint"]); $i++) {
                    $query = 'INSERT INTO  `blocks` (`id`,
							`block_name`,
							`status_id` ) VALUES(NULL,
							\'' . mysql_real_escape_string($this->parameters["paint"][$i]["blockname"]) . '\',
							default);';
                    executeQuery($query);
                    $block_id = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
                    for ($j = 0; $j < sizeof($this->parameters["paint"][$i]["floor"]); $j++) {
                        $query = 'INSERT INTO  `floors` (`id`,
								`block_id`,
								`floor_name`,
								`status_id` ) VALUES(NULL,
								\'' . mysql_real_escape_string($block_id) . '\',
								\'' . mysql_real_escape_string($this->parameters["paint"][$i]["floor"][$j]["floorname"]) . '\',
								default);';
                        executeQuery($query);
                        $floor_id = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
                        for ($k = 0; $k < sizeof($this->parameters["paint"][$i]["floor"][$j]["desc"]); $k++) {
                            $query = 'INSERT INTO  `requi_descp` (`id`,
									`requi_id`,
									`particular`,
									`qty`,
									`unit_id`,
									`block_id`,
									`floor_id`,
									`length`,
									`breadth`,
									`area`,
									`rate`,
									`total`,
									`status_id` ) VALUES(NULL,
									\'' . mysql_real_escape_string($requi_pk) . '\',
									\'' . mysql_real_escape_string($this->parameters["paint"][$i]["floor"][$j]["desc"][$k]["location"]) . '\',
									default,
									default,
									\'' . mysql_real_escape_string($block_id) . '\',
									\'' . mysql_real_escape_string($floor_id) . '\',
									\'' . mysql_real_escape_string($this->parameters["paint"][$i]["floor"][$j]["desc"][$k]["height"]) . '\',
									\'' . mysql_real_escape_string($this->parameters["paint"][$i]["floor"][$j]["desc"][$k]["breadth"]) . '\',
									\'' . mysql_real_escape_string($this->parameters["paint"][$i]["floor"][$j]["desc"][$k]["area"]) . '\',
									\'' . mysql_real_escape_string($this->parameters["paint"][$i]["floor"][$j]["desc"][$k]["rate"]) . '\',
									\'' . mysql_real_escape_string($this->parameters["paint"][$i]["floor"][$j]["desc"][$k]["amount"]) . '\',
									default);';
                            executeQuery($query);
                            $requi_desc_pat_pk[] = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
                        }
                    }
                }
            }
            /* Quotation */
            $query = 'INSERT INTO  `quotation` (`id`,
						`requi_id`,
						`ref_no`,
						`status`,
						`status_id`)  VALUES(
					NULL,
					\'' . mysql_real_escape_string($requi_pk) . '\',
					\'' . mysql_real_escape_string($ref_no) . '\',
					default,default);';
            executeQuery($query);
            $quot_pk = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
            /* Client Purchase Order */
            $query = 'INSERT INTO  `client_po` (`id`,
						`requi_id`,
						`quot_id`,
						`ref_no`,
						`cpo_ref_no`,
						`date`,
						`status_id`)  VALUES(
					NULL,
					\'' . mysql_real_escape_string($requi_pk) . '\',
					\'' . mysql_real_escape_string($quot_pk) . '\',
					\'' . mysql_real_escape_string($ref_no) . '\',
					NULL,NULL,default);';
            executeQuery($query);
            $cpo_pk = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
            /* Project */
            $query = 'INSERT INTO  `project` (`id`,
						`requi_id`,
						`quot_id`,
						`client_po`,
						`ref_no`,
						`name`,
						`project_md`,
						`project_eng`,
						`project_mng`,
						`project_hld`,
						`psd`,
						`pcd`,
						`discussed`,
						`progress`,
						`met_timeline`,
						`status_id`)  VALUES(
					NULL,
					\'' . mysql_real_escape_string($requi_pk) . '\',
					\'' . mysql_real_escape_string($quot_pk) . '\',
					\'' . mysql_real_escape_string($cpo_pk) . '\',
					\'' . mysql_real_escape_string($ref_no) . '\',
					\'' . mysql_real_escape_string($this->parameters["prj_name"]) . '\',
					NULL,NULL,NULL,NULL,
					NULL,NULL,
					default,default,default,default);';
            executeQuery($query);
            $proj_pk = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
            /* Project Description */
            for ($i = 0; $i < sizeof($requi_desc_man_pk); $i++) {
                // echo '<br />'. $requi_desc_man_pk[$i];
                $query = 'INSERT INTO  `project_description` (`id`,
							`proj_id`,
							`task`,
							`production`,
							`status`,
							`feedback`,
							`obstacles`,
							`status_id`)  VALUES(
						NULL,
						\'' . mysql_real_escape_string($proj_pk) . '\',
						\'' . mysql_real_escape_string($requi_desc_man_pk[$i]) . '\',
						default,default,NULL,NULL,default);';
                executeQuery($query);
            }
            for ($i = 0; $i < sizeof($requi_desc_pat_pk); $i++) {
                // echo '<br />'. $requi_desc_pat_pk[$i];
                $query = 'INSERT INTO  `project_description` (`id`,
							`proj_id`,
							`task`,
							`production`,
							`status`,
							`feedback`,
							`obstacles`,
							`status_id`)  VALUES(
						NULL,
						\'' . mysql_real_escape_string($proj_pk) . '\',
						\'' . mysql_real_escape_string($requi_desc_pat_pk[$i]) . '\',
						default,default,NULL,NULL,default);';
                executeQuery($query);
            }
            /* Invoice */
            $query = 'INSERT INTO  `invoice` (`id`,
						`requi_id`,
						`quot_id`,
						`client_po`,
						`proj_id`,
						`from_pk`,
						`to_pk`,
						`ref_no`,
						`status`,
						`status_id`)  VALUES(
					NULL,
					\'' . mysql_real_escape_string($requi_pk) . '\',
					\'' . mysql_real_escape_string($quot_pk) . '\',
					\'' . mysql_real_escape_string($cpo_pk) . '\',
					\'' . mysql_real_escape_string($proj_pk) . '\',
					\'' . mysql_real_escape_string($_SESSION["IOS"]["id"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["cliid"]) . '\',
					\'' . mysql_real_escape_string($ref_no) . '\',
					default,default);';
            executeQuery($query);
            $inv_pk = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
            /* Project Management */
            $query = 'INSERT INTO  `proj_management` (`id`,
						`req_id`,
						`quot_id`,
						`po_id`,
						`proj_id`,
						`client_id`,
						`inv_id`,
						`ref_no`,
						`status_id`)  VALUES(
					NULL,
					\'' . mysql_real_escape_string($requi_pk) . '\',
					\'' . mysql_real_escape_string($quot_pk) . '\',
					\'' . mysql_real_escape_string($cpo_pk) . '\',
					\'' . mysql_real_escape_string($proj_pk) . '\',
					\'' . mysql_real_escape_string($this->parameters["cliid"]) . '\',
					\'' . mysql_real_escape_string($inv_pk) . '\',
					\'' . mysql_real_escape_string($ref_no) . '\',
					default);';
            executeQuery($query);
            $flag = true;
        }
        if ($flag) {
            $para = array(
                "addressee" => NULL,
                "toaddress" => NULL
            );
            $parameters = array(
                "uid" => $this->parameters["cpnid"]
            );
            returnClientDet($para, $parameters);
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getProperties()->setCreator(SOFT_NAME)
                    ->setLastModifiedBy(SOFT_NAME)
                    ->setTitle('Requirement Specification')
                    ->setSubject('Requirement Specification Document')
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
            /*
              Set printing area
              $objPHPExcel->getActiveSheet()->getPageSetup()->setPrintArea('A1:I1');
             */
            /*
              Set printing break
              $objPHPExcel->getActiveSheet()->setBreak( 'A47' , PHPExcel_Worksheet::BREAK_ROW );
             */
            if (is_array($this->parameters["part"]) && sizeof($this->parameters["part"]) > -1) {
                $myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'Production Requirements');
                $objPHPExcel->addSheet($myWorkSheet, 0);
                $objPHPExcel->setActiveSheetIndexByName('Production Requirements');
                $objPHPExcel->getActiveSheet()
                        ->getPageSetup()
                        ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT)
                        ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4)
                        ->setHorizontalCentered(true)
                        ->setVerticalCentered(false);
                $objPHPExcel->getActiveSheet()
                        ->getHeaderFooter()
                        ->setOddHeader('&C&H Requirement Specification Document Generated on ' . date('j-M-Y'))
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
                        /* Logo */
                        ->mergeCells('B2:I5')
                        /* Reference no */
                        ->mergeCells('B6:C6')
                        /* Date */
                        ->mergeCells('G6:I6')
                        /* To address */
                        ->mergeCells('B8:E10')
                        /* Addressee */
                        ->mergeCells('B12:C12')
                        /* Subject */
                        ->mergeCells('B14:C14')
                        /* Designation */
                        ->mergeCells('B16:C16')
                        /* Project name */
                        ->mergeCells('B18:C18')
                        /* Paritculars */
                        ->mergeCells('C19:G19');

                /* Logo */
                if (file_exists(LOGO_IMAGE_DOC)) {
                    $objDrawing = new PHPExcel_Worksheet_Drawing();
                    $objDrawing->setName('IOS LOGO');
                    $objDrawing->setDescription('Integro Office Solution');
                    //Path to signature .jpg file
                    $signature = LOGO_IMAGE_DOC;
                    $objDrawing->setPath($signature);
                    $objDrawing->setOffsetX(0);
                    $objDrawing->setCoordinates('B2');
                    $objDrawing->setHeight(49);
                    $objDrawing->setWidth(769);
                    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
                }
                /* Reference no */
                $objPHPExcel->getActiveSheet()
                        ->setCellValueByColumnAndRow(1, 6, 'Reference no : ' . $ref_no);
                /* Date */
                $objPHPExcel->getActiveSheet()
                        ->setCellValueByColumnAndRow(6, 6, 'Date : ' . date('j-M-Y'));
                $objPHPExcel->getActiveSheet()->getStyle('B6:I6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                $objPHPExcel->getActiveSheet()->getStyle('B6:I6')->getFill()->getStartColor()->setARGB('FF00CCFF');
                /* To address */
                $objPHPExcel->getActiveSheet()
                        ->getStyle('B8:C10')
                        ->getAlignment()
                        ->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                $objPHPExcel->getActiveSheet()
                        ->setCellValueByColumnAndRow(1, 8, $para["toaddress"]);
                /* Addressee */
                $objPHPExcel->getActiveSheet()
                        ->setCellValueByColumnAndRow(1, 12, ADDRESSE . ' ' . $para["addressee"]);
                /* Subject */
                $objPHPExcel->getActiveSheet()
                        ->setCellValueByColumnAndRow(1, 14, 'RSD ' . SUBJECT);
                /* Designation */
                $objPHPExcel->getActiveSheet()
                        ->setCellValueByColumnAndRow(1, 16, DESIG);
                /* Project name */
                $objPHPExcel->getActiveSheet()
                        ->setCellValueByColumnAndRow(1, 18, ' Project Name : ' . $this->parameters["prj_name"]);
                /* Requirement Description */
                /* Add titles  of the columns */
                $objPHPExcel->getActiveSheet()
                        ->setCellValueByColumnAndRow(1, 19, 'Sl No:')
                        ->setCellValueByColumnAndRow(2, 19, 'Particular')
                        ->setCellValueByColumnAndRow(7, 19, 'Qty')
                        ->setCellValueByColumnAndRow(8, 19, 'Unit');
                /* Colour the borders */
                $objPHPExcel->getActiveSheet()->getStyle('B19')->applyFromArray($styleArray1);
                $objPHPExcel->getActiveSheet()->getStyle('C19')->applyFromArray($styleArray1);
                $objPHPExcel->getActiveSheet()->getStyle('D19')->applyFromArray($styleArray1);
                $objPHPExcel->getActiveSheet()->getStyle('E19')->applyFromArray($styleArray1);
                $objPHPExcel->getActiveSheet()->getStyle('F19')->applyFromArray($styleArray1);
                $objPHPExcel->getActiveSheet()->getStyle('G19')->applyFromArray($styleArray1);
                $objPHPExcel->getActiveSheet()->getStyle('H19')->applyFromArray($styleArray1);
                $objPHPExcel->getActiveSheet()->getStyle('I19')->applyFromArray($styleArray1);
                $objPHPExcel->getActiveSheet()->getStyle('B19:I19')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                $objPHPExcel->getActiveSheet()->getStyle('B19:I19')->getFill()->getStartColor()->setARGB('FF99AD88');
                $objPHPExcel->getActiveSheet()
                        ->getStyle('B21:I21')
                        ->getAlignment()
                        ->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(46);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(13);
                $objPHPExcel->getActiveSheet()->getRowDimension(19)->setRowHeight(20);
                // $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(-1);
                $row = 20;
                $si_no = 1;
                for ($i = 0; $i < sizeof($this->parameters["part"]); $i++) {
                    $newarr = explode(" ", str_replace($this->order, $this->replace, $this->parameters["part"][$i]["parti"]));
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
                            ->setCellValueByColumnAndRow(1, $row, $si_no)
                            ->setCellValueByColumnAndRow(2, $row, $this->parameters["part"][$i]["parti"])
                            ->setCellValueByColumnAndRow(7, $row, $this->parameters["part"][$i]["qty"])
                            ->setCellValueByColumnAndRow(8, $row, $this->parameters["part"][$i]["unit"]);
                    $objPHPExcel->getActiveSheet()->getStyle('C' . $row)->getAlignment()->setWrapText(true);
                    $objPHPExcel->getActiveSheet()->getStyle('B' . ($row))->applyFromArray($styleArray2);
                    $objPHPExcel->getActiveSheet()->getStyle('C' . ($row))->applyFromArray($styleArray2);
                    $objPHPExcel->getActiveSheet()->getStyle('H' . ($row))->applyFromArray($styleArray2);
                    $objPHPExcel->getActiveSheet()->getStyle('I' . ($row))->applyFromArray($styleArray2);
                    /* Requirement Description Details */
                    /* for($j=0;$j<sizeof($this->parameters["part"][$i]["deliinst"]);$j++){
                      if($j == 0){
                      // $objPHPExcel->getActiveSheet()
                      // ->setCellValueByColumnAndRow(5,$row, $this->parameters["part"][$i]["deliinst"][$j]["supply"])
                      // ->setCellValueByColumnAndRow(6,$row, $this->parameters["part"][$i]["deliinst"][$j]["instal"]);
                      $objPHPExcel->getActiveSheet()
                      ->setCellValueByColumnAndRow(5,$row, 0)
                      ->setCellValueByColumnAndRow(6,$row, 0);
                      }
                      else if($j != 0 && ($j % 2) == 0){
                      // $objPHPExcel->getActiveSheet()
                      // ->setCellValueByColumnAndRow(5,$row, $this->parameters["part"][$i]["deliinst"][$j]["supply"])
                      // ->setCellValueByColumnAndRow(6,$row, $this->parameters["part"][$i]["deliinst"][$j]["instal"]);
                      $objPHPExcel->getActiveSheet()
                      ->setCellValueByColumnAndRow(5,$row, 0)
                      ->setCellValueByColumnAndRow(6,$row, 0);
                      }else{
                      // $objPHPExcel->getActiveSheet()
                      // ->setCellValueByColumnAndRow(7,$row, $this->parameters["part"][$i]["deliinst"][$j]["supply"])
                      // ->setCellValueByColumnAndRow(8,$row, $this->parameters["part"][$i]["deliinst"][$j]["instal"]);
                      $objPHPExcel->getActiveSheet()
                      ->setCellValueByColumnAndRow(7,$row, 0)
                      ->setCellValueByColumnAndRow(8,$row, 0);
                      }
                      $objPHPExcel->getActiveSheet()->getStyle('F'.($row))->applyFromArray($styleArray2);
                      $objPHPExcel->getActiveSheet()->getStyle('G'.($row))->applyFromArray($styleArray2);
                      $objPHPExcel->getActiveSheet()->getStyle('H'.($row))->applyFromArray($styleArray2);
                      $objPHPExcel->getActiveSheet()->getStyle('I'.($row))->applyFromArray($styleArray2);
                      } */
                    $objPHPExcel->getActiveSheet()
                            ->mergeCells('C' . ($row) . ':G' . ($row))
                            ->getStyle('B' . ($row) . ':I' . ($row))
                            ->getAlignment()
                            ->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $row+=1;
                    $si_no+=1;
                }
            }
            // $objPHPExcel->getActiveSheet()->getStyle('C20:C'.($row-1))->getAlignment()->setWrapText(true);
            // $objPHPExcel->getActiveSheet()->getStyle('C20:C'.($row-1))->getAlignment()->setIndent(5);
            $row+=1;
            /* Footer */
            $objPHPExcel->getActiveSheet()
                    ->mergeCells('B' . ($row) . ':C' . ($row + 7));
            $objPHPExcel->getActiveSheet()
                    ->setCellValueByColumnAndRow(1, $row, QUOT_FOOT);
            $objPHPExcel->getActiveSheet()
                    ->getStyle('B' . ($row) . ':C' . ($row + 7))
                    ->getAlignment()
                    ->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
            $row += 12;
            $objPHPExcel->getActiveSheet()
                    ->mergeCells('B' . ($row) . ':C' . ($row + 2));
            $objPHPExcel->getActiveSheet()
                    ->setCellValueByColumnAndRow(1, $row, "Yours truly,\r\n" . $_SESSION["IOS"]["name"]);
            $objPHPExcel->getActiveSheet()
                    ->getStyle('B' . ($row) . ':C' . ($row + 2))
                    ->getAlignment()
                    ->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
            /* Painting project */
            if (is_array($this->parameters["paint"]) && sizeof($this->parameters["paint"]) > -1) {
                $myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'Painting Measurements');
                $objPHPExcel->addSheet($myWorkSheet, 0);
                $objPHPExcel->setActiveSheetIndexByName('Painting Measurements');
                $objPHPExcel->getActiveSheet()
                        ->getPageSetup()
                        ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT)
                        ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4)
                        ->setHorizontalCentered(true)
                        ->setVerticalCentered(false);
                $objPHPExcel->getActiveSheet()
                        ->getHeaderFooter()
                        ->setOddHeader('&C&H Requirement Specification Document Generated on ' . date('j-M-Y'))
                        ->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');
                /* Setting a column’s width
                  foreach(range('B','J') as $columnID) {
                  $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                  ->setAutoSize(true);
                  }
                 */
                /* Prepare layout */
                $objPHPExcel->getActiveSheet()
                        /* Logo */
                        ->mergeCells('B2:J5')
                        /* Reference no */
                        ->mergeCells('B6:E6')
                        /* Date */
                        ->mergeCells('H6:J6')
                        /* To address */
                        ->mergeCells('B8:E10')
                        /* Addressee */
                        ->mergeCells('B12:E12')
                        /* Subject */
                        ->mergeCells('B14:E14')
                        /* Designation */
                        ->mergeCells('B16:E16')
                        /* Project name */
                        ->mergeCells('B18:E18');
                /* IOS LOGO */
                if (file_exists(LOGO_IMAGE_DOC)) {
                    $objDrawing = new PHPExcel_Worksheet_Drawing();
                    $objDrawing->setName('IOS LOGO');
                    $objDrawing->setDescription('Integro Office Solution');
                    //Path to signature .jpg file
                    $signature = LOGO_IMAGE_DOC;
                    $objDrawing->setPath($signature);
                    $objDrawing->setOffsetX(20);
                    $objDrawing->setCoordinates('B2');
                    $objDrawing->setHeight(49);
                    $objDrawing->setWidth(809);
                    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
                }
                /* Reference no */
                $objPHPExcel->getActiveSheet()
                        ->setCellValueByColumnAndRow(1, 6, ' Reference no : ' . $ref_no);
                /* Date */
                $objPHPExcel->getActiveSheet()
                        ->setCellValueByColumnAndRow(7, 6, ' Date : ' . date('j-M-Y'));
                $objPHPExcel->getActiveSheet()->getStyle('B6:J6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                $objPHPExcel->getActiveSheet()->getStyle('B6:J6')->getFill()->getStartColor()->setARGB('FF00CCFF');
                /* To address */
                $objPHPExcel->getActiveSheet()
                        ->getStyle('B8:C10')
                        ->getAlignment()
                        ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()
                        ->setCellValueByColumnAndRow(1, 8, $para["toaddress"]);
                /* Addressee */
                $objPHPExcel->getActiveSheet()
                        ->setCellValueByColumnAndRow(1, 12, ADDRESSE . ' ' . $para["addressee"]);
                /* Subject */
                $objPHPExcel->getActiveSheet()
                        ->setCellValueByColumnAndRow(1, 14, 'RSD ' . SUBJECT);
                /* Designation */
                $objPHPExcel->getActiveSheet()
                        ->setCellValueByColumnAndRow(1, 16, DESIG);
                /* Project name */
                $objPHPExcel->getActiveSheet()
                        ->setCellValueByColumnAndRow(1, 18, ' Project Name : ' . $this->parameters["prj_name"]);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(46);
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(13);
                /* 4.6.30.	Group / outline a row */
                // $objPHPExcel->getActiveSheet()->getRowDimension('1')->setOutlineLevel(2);
                /* Add titles  of the columns */
                $row = 21;
                $si_no = 1;
                $objPHPExcel->getActiveSheet()
                        ->mergeCells('H19:J19')
                        ->mergeCells('B20:G20')
                        ->mergeCells('E19:G19');
                $objPHPExcel->getActiveSheet()
                        ->setCellValueByColumnAndRow(1, 19, 'Sl No:')
                        ->setCellValueByColumnAndRow(2, 19, 'Block')
                        ->setCellValueByColumnAndRow(3, 19, 'Floor')
                        ->setCellValueByColumnAndRow(4, 19, 'Location')
                        ->setCellValueByColumnAndRow(7, 19, 'Measurement in sq. ft.')
                        ->setCellValueByColumnAndRow(7, 20, 'Length')
                        ->setCellValueByColumnAndRow(8, 20, 'Breadth')
                        ->setCellValueByColumnAndRow(9, 20, 'Area');
                $objPHPExcel->getActiveSheet()->getStyle('B19')->applyFromArray($styleArray1);
                $objPHPExcel->getActiveSheet()->getStyle('C19')->applyFromArray($styleArray1);
                $objPHPExcel->getActiveSheet()->getStyle('D19')->applyFromArray($styleArray1);
                $objPHPExcel->getActiveSheet()->getStyle('E19')->applyFromArray($styleArray1);
                $objPHPExcel->getActiveSheet()->getStyle('H19')->applyFromArray($styleArray1);
                $objPHPExcel->getActiveSheet()->getStyle('F19:J20')->applyFromArray($styleArray1);
                //$objPHPExcel->getActiveSheet()->getStyle('F20')->applyFromArray($styleArray1);
                //$objPHPExcel->getActiveSheet()->getStyle('G20')->applyFromArray($styleArray1);
                $objPHPExcel->getActiveSheet()->getStyle('H20')->applyFromArray($styleArray1);
                $objPHPExcel->getActiveSheet()->getStyle('I20')->applyFromArray($styleArray1);
                $objPHPExcel->getActiveSheet()->getStyle('J20')->applyFromArray($styleArray1);
                $objPHPExcel->getActiveSheet()->getStyle('B20:E20')->applyFromArray($styleArray1);
                $objPHPExcel->getActiveSheet()->getStyle('B19:J20')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                $objPHPExcel->getActiveSheet()->getStyle('B19:J20')->getFill()->getStartColor()->setARGB('FF99AD88');
                $objPHPExcel->getActiveSheet()
                        ->getStyle('B19:J21')
                        ->getAlignment()
                        ->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                for ($i = 0; $i < sizeof($this->parameters["paint"]); $i++) {
                    $objPHPExcel->getActiveSheet()
                            ->setCellValueByColumnAndRow(2, $row, $this->parameters["paint"][$i]["blockname"]);
                    for ($j = 0; $j < sizeof($this->parameters["paint"][$i]["floor"]); $j++) {
                        $objPHPExcel->getActiveSheet()
                                ->setCellValueByColumnAndRow(3, $row, $this->parameters["paint"][$i]["floor"][$j]["floorname"]);
                        /* merge the blocks */
                        /*
                          $objPHPExcel->getActiveSheet()
                          ->getStyle('C'.($row).':C'.($row+sizeof($this->parameters["paint"][$i]["floor"][$j]["desc"])-1))
                          ->applyFromArray($styleArray2);
                          $objPHPExcel->getActiveSheet()
                          ->getStyle('C'.($row).':C'.($row+sizeof($this->parameters["paint"][$i]["floor"][$j]["desc"])-1))
                          ->getAlignment()
                          ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                          $objPHPExcel->getActiveSheet()
                          ->mergeCells('C'.($row).':C'.($row+sizeof($this->parameters["paint"][$i]["floor"][$j]["desc"])-1));
                          $objPHPExcel->getActiveSheet()
                          ->getStyle('D'.($row).':D'.($row+sizeof($this->parameters["paint"][$i]["floor"][$j]["desc"])))
                          ->applyFromArray($styleArray2);
                          $objPHPExcel->getActiveSheet()
                          ->getStyle('D'.($row).':D'.($row+sizeof($this->parameters["paint"][$i]["floor"][$j]["desc"])))
                          ->getAlignment()
                          ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                          $objPHPExcel->getActiveSheet()
                          ->mergeCells('D'.($row).':D'.($row+sizeof($this->parameters["paint"][$i]["floor"][$j]["desc"])));
                         */
                        for ($k = 0; $k < sizeof($this->parameters["paint"][$i]["floor"][$j]["desc"]); $k++) {
                            $newarr = explode(" ", str_replace($this->order, $this->replace, $this->parameters["paint"][$i]["floor"][$j]["desc"][$k]["location"]));
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
                                    ->setCellValueByColumnAndRow(1, $row, $si_no)
                                    ->setCellValueByColumnAndRow(4, $row, $this->parameters["paint"][$i]["floor"][$j]["desc"][$k]["location"])
                                    ->setCellValueByColumnAndRow(7, $row, $this->parameters["paint"][$i]["floor"][$j]["desc"][$k]["height"])
                                    ->setCellValueByColumnAndRow(8, $row, $this->parameters["paint"][$i]["floor"][$j]["desc"][$k]["breadth"])
                                    ->setCellValueByColumnAndRow(9, $row, $this->parameters["paint"][$i]["floor"][$j]["desc"][$k]["area"]);
                            //->setCellValueByColumnAndRow(8,$row, 0)
                            //->setCellValueByColumnAndRow(9,$row, 0);
                            // ->setCellValueByColumnAndRow(8,$row, $this->parameters["paint"][$i]["floor"][$j]["desc"][$k]["rate"])
                            // ->setCellValueByColumnAndRow(9,$row, $this->parameters["paint"][$i]["floor"][$j]["desc"][$k]["amount"]);
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $row)->getAlignment()->setWrapText(true);
                            $objPHPExcel->getActiveSheet()->getStyle('B' . ($row))->applyFromArray($styleArray2);
                            $objPHPExcel->getActiveSheet()->getStyle('C' . ($row))->applyFromArray($styleArray2);
                            $objPHPExcel->getActiveSheet()->getStyle('D' . ($row))->applyFromArray($styleArray2);
                            $objPHPExcel->getActiveSheet()->getStyle('E' . ($row))->applyFromArray($styleArray2);
                            //$objPHPExcel->getActiveSheet()->getStyle('F'.($row))->applyFromArray($styleArray2);
                            //$objPHPExcel->getActiveSheet()->getStyle('G'.($row))->applyFromArray($styleArray2);
                            $objPHPExcel->getActiveSheet()->getStyle('H' . ($row))->applyFromArray($styleArray2);
                            $objPHPExcel->getActiveSheet()->getStyle('I' . ($row))->applyFromArray($styleArray2);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . ($row))->applyFromArray($styleArray2);
                            $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(-1);
                            $objPHPExcel->getActiveSheet()
                                    ->mergeCells('E' . ($row) . ':G' . ($row))
                                    ->getStyle('B' . ($row) . ':J' . ($row))
                                    ->getAlignment()
                                    ->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                                    ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                            //$objPHPExcel->mergeCells('E'.($row).':G'.($row));
                            $row+=1;
                            $si_no+=1;
                        }
                    }
                }
            }
            $row += 1;
            /* Footer */
            $objPHPExcel->getActiveSheet()
                    ->mergeCells('B' . ($row) . ':E' . ($row + 7));
            $objPHPExcel->getActiveSheet()
                    ->setCellValueByColumnAndRow(1, $row, QUOT_FOOT);
            $objPHPExcel->getActiveSheet()
                    ->getStyle('B' . ($row) . ':E' . ($row + 7))
                    ->getAlignment()
                    ->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
            $row += 12;
            $objPHPExcel->getActiveSheet()
                    ->mergeCells('B' . ($row) . ':E' . ($row + 2));
            $objPHPExcel->getActiveSheet()
                    ->setCellValueByColumnAndRow(1, $row, "Yours truly,\r\n" . $_SESSION["IOS"]["name"]);
            $objPHPExcel->getActiveSheet()
                    ->getStyle('B' . ($row) . ':E' . ($row + 2))
                    ->getAlignment()
                    ->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
            $dirparameters = array(
                "directory" => NULL,
                "filename" => $ref_no . '_SRS_' . date('j-M-Y') . '.xlsx',
                "filedirectory" => NULL,
                "urlpath" => NULL,
                "url" => NULL
            );
            returnDirectoryDoc($dirparameters, $parameters);
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save($dirparameters["filedirectory"]);
            unset($objWriter);
            unset($objPHPExcel);
            /* documents */
            $query = 'INSERT INTO  `documents` (`id`,
						`file_name`,
						`type_id`,
						`doc_loc`,
						`mime_type`,
						`doc_type`,
						`dou`,
						`status_id`)  VALUES(
					NULL,
					\'' . $dirparameters["filename"] . '\',
					\'' . mysql_real_escape_string($requi_pk) . '\',
					\'' . $dirparameters["url"] . '\',
					\'application/vnd.ms-excel\',
					\'requirements\',
					default,
					default);';
            executeQuery($query);
            executeQuery("COMMIT");
        }
        return $flag;
    }

    static function processProjectArray($query) {
        $project = array();
        executeQuery("SET SESSION group_concat_max_len = 100000000;");
        $res = executeQuery($query);
        $num = mysql_num_rows($res);
        if ($num > 0) {
            $i = 0;
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
            $_SESSION["requirement"] = $project;
            $_SESSION["project"] = $project;
        } else {
            $_SESSION["requirement"] = NULL;
            $_SESSION["project"] = NULL;
        }
        return $project;
    }

    public function fetchRequirement() {
        $json = array();
        $this->array_project = project::processProjectArray($this->query_project);
        /* PCC */
        $taskDescpJson = array();
        /* Project Plan */
        $taskJson = array();
        $utype = array(
            "utype" => NULL,
            "uid" => NULL,
            "utyp" => array(0 => 1, 1 => 2, 2 => 4, 3 => 5, 4 => 6, 5 => 9)
        );
        $jsonutype = getUsers($utype);
        $useropt = '';
        for ($loop = 0; $loop < sizeof($jsonutype); $loop++) {
            $useropt .= $jsonutype[$loop]["html"];
        }
        if (sizeof($this->array_project)) {
            for ($i = 0; $i < sizeof($this->array_project) && isset($this->array_project[$i]["proj_manage"]["id"]); $i++) {
                $label = $this->array_project[$i]["proj_manage"]["ref_no"] . ' -- ' . $this->array_project[$i]["project"]["name"] . ' -- ' . date('j-M-Y', strtotime($this->array_project[$i]["requirement"]["doethno"]));
                $totinst = $this->array_project[$i]["requirement"]["totinst"];
                $stc2 = ceil($totinst * STC);
                $stc2_50_1236_2 = ceil($totinst * STC_E_CESS);
                $stc2_50_1236_1 = ceil($totinst * STC_H_E_CESS);
                $ntotinst = ceil($totinst + $stc2 + $stc2_50_1236_2 + $stc2_50_1236_1);
                // $ntotinst =(double)  ($totinst + $stc2 + $stc2_50_1236_2 + $stc2_50_1236_1);
                $ptotal = $this->array_project[$i]["requirement"]["ptotal"];
                $stc1 = ceil($ptotal * STC);
                $stc1_50_1236_2 = ceil($ptotal * STC_E_CESS);
                $stc1_50_1236_1 = ceil($ptotal * STC_H_E_CESS);
                $pntotal = ceil($ptotal + $stc1 + $stc1_50_1236_2 + $stc1_50_1236_1);
                // $pntotal = (double) ($ptotal + $stc1 + $stc1_50_1236_2 + $stc1_50_1236_1);
                $totsup = $this->array_project[$i]["requirement"]["totsup"];
                $vat = ceil($totsup * VAT);
                $ntotsup = ceil($totsup + $vat);
                // $ntotsup = (double) ($totsup + $vat);
                $nettotal = ceil($pntotal + $ntotsup + $ntotinst);
                $si_no = 1;
                /* Project Plan Production */
                $taskJson["Production"] = array();
                for ($j = 0; $this->array_project[$i]["requirement"]["production"] != NULL && $j < sizeof($this->array_project[$i]["requirement"]["production"]) - 1; $j++, $si_no++) {
                    $tsak_id = $this->array_project[$i]["requirement"]["production"][$j]["id"];
                    $tsak = $this->array_project[$i]["requirement"]["production"][$j]["part"];
                    $prrd = '<select class="form-control" id="prrd_ptask_' . $tsak_id . '"><option value="NULL" selected>Assign task to production </option><option value="Yes">Yes</option><option value="No">No</option></select><p class="help-block" id="prrd_ptask_msg_' . $tsak_id . '">Enter / Select</p>';
                    $tablerow = '<tr><td>' . $si_no . '</td><td>' . $tsak . '</td><td>' . $prrd . '</td><td><select class="form-control" id="assn_ptask_' . $tsak_id . '"><option value="NULL" selected>Select Assignee </option>' . $useropt . '</select><p class="help-block" id="assn_ptask_msg_' . $tsak_id . '">Enter / Select</p></td><td><textarea maxlength="160" placeholder="SMS / Feedback" id="prj_task_sms_' . $tsak_id . '"></textarea></td></tr>';
                    $taskJson["Production"][] = array(
                        "id" => $tsak_id,
                        "tablerow" => $tablerow,
                        "prrd_DOM" => '#prrd_ptask_' . $tsak_id,
                        "prrd_msg_DOM" => '#prrd_ptask_msg_' . $tsak_id,
                        "assn_DOM" => '#assn_ptask_' . $tsak_id,
                        "assn_msg_DOM" => '#assn_ptask_msg_' . $tsak_id,
                        "sms_DOM" => '#prj_task_sms_' . $tsak_id
                    );
                }
                /* Project Plan Painting */
                $taskJson["Painting"] = array();
                for ($j = 0; $this->array_project[$i]["requirement"]["painting"] != NULL && $j < sizeof($this->array_project[$i]["requirement"]["painting"]); $j++) {
                    for ($k = 0; $this->array_project[$i]["requirement"]["painting"][$j]["floor"] != NULL && $k < sizeof($this->array_project[$i]["requirement"]["painting"][$j]["floor"]); $k++) {
                        for ($l = 0; $this->array_project[$i]["requirement"]["painting"][$j]["floor"] != NULL && $l < sizeof($this->array_project[$i]["requirement"]["painting"][$j]["floor"]) - 1; $l++, $si_no++) {
                            $tsak_id = $this->array_project[$i]["requirement"]["painting"][$j]["floor"][$k]["location"][$l]["id"];
                            $tsak = $this->array_project[$i]["requirement"]["painting"][$j]["floor"][$k]["location"][$l]["loc"] . '<br /> Length = ' .
                                    $this->array_project[$i]["requirement"]["painting"][$j]["floor"][$k]["location"][$l]["length"] . '<br /> Breadth = ' .
                                    $this->array_project[$i]["requirement"]["painting"][$j]["floor"][$k]["location"][$l]["breadth"];
                            $prrd = '<select class="form-control" id="prrd_ptask_' . $tsak_id . '"><option value="NULL" selected>Assign task to production </option><option value="Yes">Yes</option><option value="No">No</option></select><p class="help-block" id="prrd_ptask_msg_' . $tsak_id . '">Enter / Select</p>';
                            $tablerow = '<tr><td>' . $si_no . '</td><td>' . $tsak . '</td><td>' . $prrd . '</td><td><select class="form-control" id="assn_ptask_' . $tsak_id . '"><option value="NULL" selected>Select Assignee </option>' . $useropt . '</select><p class="help-block" id="assn_ptask_msg_' . $tsak_id . '">Enter / Select</p></td><td><textarea maxlength="160" placeholder="SMS / Feedback" id="prj_task_sms_' . $tsak_id . '"></textarea></td></tr>';
                            $taskJson["Painting"][] = array(
                                "id" => $tsak_id,
                                "tablerow" => $tablerow,
                                "prrd_DOM" => '#prrd_ptask_' . $tsak_id,
                                "prrd_msg_DOM" => '#prrd_ptask_msg_' . $tsak_id,
                                "assn_DOM" => '#assn_ptask_' . $tsak_id,
                                "assn_msg_DOM" => '#assn_ptask_msg_' . $tsak_id,
                                "sms_DOM" => '#prj_task_sms_' . $tsak_id
                            );
                        }
                    }
                }
                /* PCC */
                for ($j = 0; $this->array_project[$i]["project"]["descp"] != NULL && $j < sizeof($this->array_project[$i]["project"]["descp"]); $j++) {
                    if ($this->array_project[$i]["project"]["descp"][$j]["production"] == 'Yes') {
                        $tsak_id = $this->array_project[$i]["project"]["descp"][$j]["id"];
                        $tsak = $this->array_project[$i]["project"]["descp"][$j]["task"];
                        $feedback = $this->array_project[$i]["project"]["descp"][$j]["feedback"];
                        $label = $this->array_project[$i]["proj_manage"]["ref_no"] . ' -- ' . $this->array_project[$i]["project"]["name"] . ' -- ' . $this->array_project[$i]["project"]["descp"][$j]["id"];
                        $option = '<option  value="' . $this->array_project[$i]["project"]["descp"][$j]["id"] . '" >' . $label . '</option>';
                        $prj_ded = '<br />' . $this->array_project[$i]["proj_manage"]["ref_no"] . '<br />' . $this->array_project[$i]["project"]["name"] . ' <br />' . $this->array_project[$i]["project"]["descp"][$j]["id"];
                        $tablerow = '<tr><td>' . $prj_ded . '</td><td>' . $tsak . '</td><td>' . $feedback . '</td></tr>';
                        $taskDescpJson[] = array(
                            "id" => $tsak_id,
                            "tablerow" => $tablerow,
                            "html" => $option
                        );
                    }
                }
                $json[] = array(
                    /* Common for all project features */
                    "html" => '<option  value="' . $this->array_project[$i]["proj_manage"]["req_id"] . '" >' . $label . '</option>',
                    "id" => $this->array_project[$i]["proj_manage"]["id"],
                    "prjid" => $this->array_project[$i]["project"]["id"],
                    "pname" => $this->array_project[$i]["project"]["name"],
                    "req_id" => $this->array_project[$i]["proj_manage"]["req_id"],
                    "quot_id" => $this->array_project[$i]["proj_manage"]["quot_id"],
                    "po_id" => $this->array_project[$i]["proj_manage"]["po_id"],
                    "inv_id" => $this->array_project[$i]["proj_manage"]["inv_id"],
                    "client_id" => $this->array_project[$i]["proj_manage"]["client_id"],
                    "ref_no" => $this->array_project[$i]["proj_manage"]["ref_no"],
                    "ethno_id" => $this->array_project[$i]["requirement"]["ethno_id"],
                    "ethno" => $this->array_project[$i]["requirement"]["ethno_name"],
                    "rep_id" => $this->array_project[$i]["requirement"]["rep_id"],
                    "rep" => $this->array_project[$i]["requirement"]["rep_name"],
                    "doethno" => $this->array_project[$i]["requirement"]["doethno"],
                    "artype" => "requirement",
                    "ptotal" => $ptotal,
                    "stc1" => $stc1,
                    "stc1_50_1236_2" => $stc1_50_1236_2,
                    "stc1_50_1236_1" => $stc1_50_1236_1,
                    "pntotal" => $pntotal,
                    "totsup" => $totsup,
                    "vat" => $vat,
                    "ntotsup" => $ntotsup,
                    "totinst" => $totinst,
                    "stc2" => $stc2,
                    "stc2_50_1236_2" => $stc2_50_1236_2,
                    "stc2_50_1236_1" => $stc2_50_1236_1,
                    "ntotinst" => $ntotinst,
                    "nettotal" => $nettotal,
                    /* Project Plan */
                    "req_descp" => $taskJson,
                    /* PCC */
                    "task_descp" => $taskDescpJson
                );
            }
            $_SESSION["requirement"] = $this->array_project;
        } else {
            $_SESSION["requirement"] = NULL;
        }
        return $json;
    }

    public function generateQuot() {
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        if ($_SESSION["requirement"] != NULL) {
            $requirement = $_SESSION["requirement"];
            /* Quotation */
            $query = 'UPDATE `quotation`
						SET `doi` = NOW(),
							`addresse` = \'' . mysql_real_escape_string(ADDRESSE . $this->parameters["rep"]) . '\',
							`subject` = \'' . mysql_real_escape_string($this->parameters["sub"]) . '\',
							`descp` = \'' . mysql_real_escape_string($this->parameters["qdesc"]) . '\',
							`ptotal` = \'' . mysql_real_escape_string($this->parameters["nptot"]) . '\',
							`totsup` = \'' . mysql_real_escape_string($this->parameters["nsuptot"]) . '\',
							`totins` = \'' . mysql_real_escape_string($this->parameters["ninstot"]) . '\',
							`vat` = \'' . mysql_real_escape_string($this->parameters["vat"]) . '\',
							`stc1` = \'' . mysql_real_escape_string($this->parameters["stc1"]) . '\',
							`stc1_50_1236_2` = \'' . mysql_real_escape_string($this->parameters["ecess1"]) . '\',
							`stc1_50_1236_1` = \'' . mysql_real_escape_string($this->parameters["hecess1"]) . '\',
							`stc2` = \'' . mysql_real_escape_string($this->parameters["stc2"]) . '\',
							`stc2_50_1236_2` = \'' . mysql_real_escape_string($this->parameters["ecess2"]) . '\',
							`stc2_50_1236_1` = \'' . mysql_real_escape_string($this->parameters["hecess2"]) . '\',
							`net_total` = \'' . mysql_real_escape_string($this->parameters["qgtot"]) . '\',
							`status` = "20"
						WHERE `id` = \'' . mysql_real_escape_string($this->parameters["requi_id"]) . '\';';
            if (executeQuery($query)) {
                $para = array(
                    "addressee" => NULL,
                    "toaddress" => NULL
                );
                $parameters = array(
                    "uid" => $this->parameters["client_id"]
                );
                returnClientDet($para, $parameters);
                $objPHPExcel = new PHPExcel();
                $objPHPExcel->getProperties()->setCreator(SOFT_NAME)
                        ->setLastModifiedBy(SOFT_NAME)
                        ->setTitle('Quotation')
                        ->setSubject('Quotation Document')
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
                /*
                  Set printing area
                  $objPHPExcel->getActiveSheet()->getPageSetup()->setPrintArea('A1:I1');
                 */
                /*
                  Set printing break
                  $objPHPExcel->getActiveSheet()->setBreak( 'A47' , PHPExcel_Worksheet::BREAK_ROW );
                 */
                /* Requirement */
                $requirement = $_SESSION["requirement"];
                for ($i = 0; $i < sizeof($requirement); $i++) {
                    if ($this->parameters["ind"] == $i &&
                            $requirement[$i]["proj_manage"]["req_id"] == $this->parameters["requi_id"] &&
                            $requirement[$i]["proj_manage"]["quot_id"] == $this->parameters["quot_id"]
                    ) {
                        /* Production / Manufacturing  */
                        if (is_array($requirement[$i]["requirement"]["production"]) && sizeof($requirement[$i]["requirement"]["production"]) > -1) {
                            $myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'Production Quotation');
                            $objPHPExcel->addSheet($myWorkSheet, 0);
                            $objPHPExcel->setActiveSheetIndexByName('Production Quotation');
                            $objPHPExcel->getActiveSheet()
                                    ->getPageSetup()
                                    ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT)
                                    ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4)
                                    ->setHorizontalCentered(true)
                                    ->setVerticalCentered(false);
                            $objPHPExcel->getActiveSheet()
                                    ->getHeaderFooter()
                                    ->setOddHeader('&C&H Quotation Document Generated on ' . date('j-M-Y'))
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
                                    /* Logo */
                                    ->mergeCells('B2:I5')
                                    /* Reference no */
                                    ->mergeCells('B6:C6')
                                    /* Date */
                                    ->mergeCells('G6:I6')
                                    /* To address */
                                    ->mergeCells('B8:E10')
                                    /* Addressee */
                                    ->mergeCells('B12:C12')
                                    /* Subject */
                                    ->mergeCells('B14:C14')
                                    /* Designation */
                                    ->mergeCells('B16:C16')
                                    /* Project name */
                                    ->mergeCells('B18:C18');
                            /* Logo */
                            if (file_exists(LOGO_IMAGE_DOC)) {
                                $objDrawing = new PHPExcel_Worksheet_Drawing();
                                $objDrawing->setName('IOS LOGO');
                                $objDrawing->setDescription('Integro Office Solution');
                                //Path to signature .jpg file
//									$signature = LOGO_IMAGE_DOC;
                                $signature = $_SESSION['BillingDetails']['BILL_LOGO'];
                                $objDrawing->setPath($signature);
                                $objDrawing->setOffsetX(0);
                                $objDrawing->setCoordinates('B2');
                                $objDrawing->setHeight(49);
                                $objDrawing->setWidth(769);
                                $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
                            }
                            /* Reference no */
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(1, 6, 'Reference no : ' . $this->parameters["ref_no"]);
                            /* Date */
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(6, 6, 'Date : ' . date('j-M-Y'));
                            $objPHPExcel->getActiveSheet()->getStyle('B6:I6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                            $objPHPExcel->getActiveSheet()->getStyle('B6:I6')->getFill()->getStartColor()->setARGB('FF00CCFF');
                            /* To address */
                            $objPHPExcel->getActiveSheet()
                                    ->getStyle('B8:C10')
                                    ->getAlignment()
                                    ->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(1, 8, $para["toaddress"]);
                            /* Addressee */
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(1, 12, ADDRESSE . ' ' . $para["addressee"]);
                            /* Subject */
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(1, 14, 'Quotation ' . $this->parameters["sub"]);
                            /* Designation */
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(1, 16, DESIG);
                            /* Project name */
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(1, 18, ' Project Name : ' . $this->parameters["prjname"]);
                            /* Requirement Description */
                            /* Add titles  of the columns */
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(1, 19, 'Sl No:')
                                    ->setCellValueByColumnAndRow(2, 19, 'Particular')
                                    ->setCellValueByColumnAndRow(3, 19, 'Qty')
                                    ->setCellValueByColumnAndRow(4, 19, 'Unit')
                                    ->setCellValueByColumnAndRow(5, 19, 'Supply')
                                    ->setCellValueByColumnAndRow(6, 19, 'Installation')
                                    ->setCellValueByColumnAndRow(7, 19, 'Supply')
                                    ->setCellValueByColumnAndRow(8, 19, 'Installation');
                            /* Colour the borders */
                            $objPHPExcel->getActiveSheet()->getStyle('B19')->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('C19')->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('D19')->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('E19')->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('F19')->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('G19')->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('H19')->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('I19')->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('B19:I19')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                            $objPHPExcel->getActiveSheet()->getStyle('B19:I19')->getFill()->getStartColor()->setARGB('FF99AD88');
                            $objPHPExcel->getActiveSheet()
                                    ->getStyle('B21:I21')
                                    ->getAlignment()
                                    ->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(46);
                            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(13);
                            $objPHPExcel->getActiveSheet()->getRowDimension(19)->setRowHeight(20);
                            // $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(-1);
                            $row = 20;
                            $si_no = 1;
                            for ($j = 0; $j < sizeof($requirement[$i]["requirement"]["production"]) - 1; $j++) {
                                $newarr = explode(" ", str_replace($this->order, $this->replace, $requirement[$i]["requirement"]["production"][$j]["part"]));
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
                                        ->setCellValueByColumnAndRow(1, $row, $si_no)
                                        ->setCellValueByColumnAndRow(2, $row, $requirement[$i]["requirement"]["production"][$j]["part"])
                                        ->setCellValueByColumnAndRow(3, $row, $requirement[$i]["requirement"]["production"][$j]["qty"])
                                        ->setCellValueByColumnAndRow(4, $row, $requirement[$i]["requirement"]["production"][$j]["unit"]);
                                $objPHPExcel->getActiveSheet()->getStyle('C' . $row)->getAlignment()->setWrapText(true);
                                $objPHPExcel->getActiveSheet()->getStyle('B' . ($row))->applyFromArray($styleArray2);
                                $objPHPExcel->getActiveSheet()->getStyle('C' . ($row))->applyFromArray($styleArray2);
                                $objPHPExcel->getActiveSheet()->getStyle('D' . ($row))->applyFromArray($styleArray2);
                                $objPHPExcel->getActiveSheet()->getStyle('E' . ($row))->applyFromArray($styleArray2);
                                for ($k = 0; $k < sizeof($requirement[$i]["requirement"]["production"][$j]["deliinst"]); $k++) {
                                    if ($k == 0) {
                                        $objPHPExcel->getActiveSheet()
                                                ->setCellValueByColumnAndRow(5, $row, $requirement[$i]["requirement"]["production"][$j]["deliinst"][$k]["supply"])
                                                ->setCellValueByColumnAndRow(6, $row, $requirement[$i]["requirement"]["production"][$j]["deliinst"][$k]["instal"]);
                                    } else if ($k != 0 && ($k % 2) == 0) {
                                        $objPHPExcel->getActiveSheet()
                                                ->setCellValueByColumnAndRow(5, $row, $requirement[$i]["requirement"]["production"][$j]["deliinst"][$k]["supply"])
                                                ->setCellValueByColumnAndRow(6, $row, $requirement[$i]["requirement"]["production"][$j]["deliinst"][$k]["instal"]);
                                    } else {
                                        $objPHPExcel->getActiveSheet()
                                                ->setCellValueByColumnAndRow(7, $row, $requirement[$i]["requirement"]["production"][$j]["deliinst"][$k]["supply"])
                                                ->setCellValueByColumnAndRow(8, $row, $requirement[$i]["requirement"]["production"][$j]["deliinst"][$k]["instal"]);
                                    }
                                    $objPHPExcel->getActiveSheet()->getStyle('F' . ($row))->applyFromArray($styleArray2);
                                    $objPHPExcel->getActiveSheet()->getStyle('G' . ($row))->applyFromArray($styleArray2);
                                    $objPHPExcel->getActiveSheet()->getStyle('H' . ($row))->applyFromArray($styleArray2);
                                    $objPHPExcel->getActiveSheet()->getStyle('I' . ($row))->applyFromArray($styleArray2);
                                }
                                $objPHPExcel->getActiveSheet()
                                        ->getStyle('B' . ($row) . ':I' . ($row))
                                        ->getAlignment()
                                        ->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                                        ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                $row+=1;
                                $si_no+=1;
                            }
                            // $objPHPExcel->getActiveSheet()->getStyle('C20:C'.($row-1))->getAlignment()->setWrapText(true);
                            // $objPHPExcel->getActiveSheet()->getStyle('C20:C'.($row-1))->getAlignment()->setIndent(5);
                            /* Calculations */
                            /* Total supply and installation */
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(7, $row, $this->parameters["totsup"])
                                    ->setCellValueByColumnAndRow(8, $row, $this->parameters["totins"]);
                            $row+=1;
                            /* VAT ON supply  */
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(7, $row, $this->parameters["vat"]);
                            $objPHPExcel->getActiveSheet()
                                    ->mergeCells('E' . $row . ':G' . $row);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(4, $row, 'Vat @ 14.5% on supply');
                            $row+=1;
                            /* STC ON Installation  */
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(8, $row, $this->parameters["stc2"]);
                            $objPHPExcel->getActiveSheet()
                                    ->mergeCells('E' . $row . ':G' . $row);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(4, $row, 'STC @ 12.36%');
                            $row+=1;
                            /* STC E.CESS ON Installation  */
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(8, $row, $this->parameters["ecess2"]);
                            $objPHPExcel->getActiveSheet()
                                    ->mergeCells('E' . $row . ':G' . $row);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(4, $row, 'E.Cess 50% on 2%');
                            $row+=1;
                            /* STC H.E.CESS ON Installation  */
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(8, $row, $this->parameters["hecess2"]);
                            $objPHPExcel->getActiveSheet()
                                    ->mergeCells('E' . $row . ':G' . $row);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(4, $row, 'H E.Cess 50% on 1%');
                            $row+=1;
                            /* Gross Total ON Supply and installation  */
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(7, $row, $this->parameters["nsuptot"])
                                    ->setCellValueByColumnAndRow(8, $row, $this->parameters["ninstot"]);
                            $objPHPExcel->getActiveSheet()
                                    ->mergeCells('E' . $row . ':G' . $row);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(4, $row, 'Total');
                            $row+=1;
                            /* Net Total Supply and installation  */
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(8, $row, ($this->parameters["nsuptot"] + $this->parameters["ninstot"]));
                            $objPHPExcel->getActiveSheet()
                                    ->mergeCells('E' . $row . ':G' . $row);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(4, $row, 'Net Total Supply and installation');
                            $row+=1;
                            /* Paint Total */
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(8, $row, $this->parameters["nptot"]);
                            $objPHPExcel->getActiveSheet()
                                    ->mergeCells('E' . $row . ':G' . $row);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(4, $row, 'Net Total Painting');
                            $row+=1;
                            /* Quotation total  */
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(8, $row, ($this->parameters["nsuptot"] + $this->parameters["ninstot"] + $this->parameters["nptot"]));
                            $objPHPExcel->getActiveSheet()
                                    ->mergeCells('E' . $row . ':G' . $row);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(4, $row, 'Quotation');
                            $row+=1;
                            /* Footer */
                            $objPHPExcel->getActiveSheet()
                                    ->mergeCells('B' . ($row) . ':C' . ($row + 7));
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(1, $row, QUOT_FOOT);
                            $objPHPExcel->getActiveSheet()
                                    ->getStyle('B' . ($row) . ':C' . ($row + 7))
                                    ->getAlignment()
                                    ->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                            $row += 12;
                            $objPHPExcel->getActiveSheet()
                                    ->mergeCells('B' . ($row) . ':C' . ($row + 2));
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(1, $row, "Yours truly,\r\n" . $_SESSION["IOS"]["name"]);
                            $objPHPExcel->getActiveSheet()
                                    ->getStyle('B' . ($row) . ':C' . ($row + 2))
                                    ->getAlignment()
                                    ->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                        }
                        /* Painting */
                        if (is_array($requirement[$i]["requirement"]["painting"]) && sizeof($requirement[$i]["requirement"]["painting"]) > -1) {
                            $myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'Painting Measurements');
                            $objPHPExcel->addSheet($myWorkSheet, 0);
                            $objPHPExcel->setActiveSheetIndexByName('Painting Measurements');
                            $objPHPExcel->getActiveSheet()
                                    ->getPageSetup()
                                    ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT)
                                    ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4)
                                    ->setHorizontalCentered(true)
                                    ->setVerticalCentered(false);
                            $objPHPExcel->getActiveSheet()
                                    ->getHeaderFooter()
                                    ->setOddHeader('&C&H Quotation Document Generated on ' . date('j-M-Y'))
                                    ->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');
                            /* Setting a column’s width
                              foreach(range('B','J') as $columnID) {
                              $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                              ->setAutoSize(true);
                              }
                             */
                            /* Prepare layout */
                            $objPHPExcel->getActiveSheet()
                                    /* Logo */
                                    ->mergeCells('B2:J5')
                                    /* Reference no */
                                    ->mergeCells('B6:E6')
                                    /* Date */
                                    ->mergeCells('H6:J6')
                                    /* To address */
                                    ->mergeCells('B8:E10')
                                    /* Addressee */
                                    ->mergeCells('B12:E12')
                                    /* Subject */
                                    ->mergeCells('B14:E14')
                                    /* Designation */
                                    ->mergeCells('B16:E16')
                                    /* Project name */
                                    ->mergeCells('B18:E18');
                            /* IOS LOGO */
                            if (file_exists($_SESSION['BillingDetails']['BILL_LOGO'])) {
                                $objDrawing = new PHPExcel_Worksheet_Drawing();
                                $objDrawing->setName('IOS LOGO');
                                $objDrawing->setDescription('Integro Office Solution');
                                //Path to signature .jpg file
//									$signature = LOGO_IMAGE_DOC;
                                $signature = $_SESSION['BillingDetails']['BILL_LOGO'];
                                $objDrawing->setPath($signature);
                                $objDrawing->setOffsetX(20);
                                $objDrawing->setCoordinates('B2');
                                $objDrawing->setHeight(49);
                                $objDrawing->setWidth(809);
                                $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
                            }
                            /* Reference no */
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(1, 6, ' Reference no : ' . $this->parameters["ref_no"]);
                            /* Date */
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(7, 6, ' Date : ' . date('j-M-Y'));
                            $objPHPExcel->getActiveSheet()->getStyle('B6:J6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                            $objPHPExcel->getActiveSheet()->getStyle('B6:J6')->getFill()->getStartColor()->setARGB('FF00CCFF');
                            /* To address */
                            $objPHPExcel->getActiveSheet()
                                    ->getStyle('B8:C10')
                                    ->getAlignment()
                                    ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(1, 8, $para["toaddress"]);
                            /* Addressee */
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(1, 12, ADDRESSE . ' ' . $para["addressee"]);
                            /* Subject */
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(1, 14, 'Quotation ' . $this->parameters["sub"]);
                            /* Designation */
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(1, 16, DESIG);
                            /* Project name */
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(1, 18, ' Project Name : ' . $this->parameters["prjname"]);
                            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(46);
                            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(13);
                            /* 4.6.30.	Group / outline a row */
                            // $objPHPExcel->getActiveSheet()->getRowDimension('1')->setOutlineLevel(2);
                            /* Add titles  of the columns */
                            $row = 21;
                            $si_no = 1;
                            $objPHPExcel->getActiveSheet()
                                    ->mergeCells('F19:J19')
                                    ->mergeCells('B20:E20');
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(1, 19, 'Sl No:')
                                    ->setCellValueByColumnAndRow(2, 19, 'Block')
                                    ->setCellValueByColumnAndRow(3, 19, 'Floor')
                                    ->setCellValueByColumnAndRow(4, 19, 'Location')
                                    ->setCellValueByColumnAndRow(5, 19, 'Measurement in sq. ft.')
                                    ->setCellValueByColumnAndRow(5, 20, 'Length')
                                    ->setCellValueByColumnAndRow(6, 20, 'Breadth')
                                    ->setCellValueByColumnAndRow(7, 20, 'Area')
                                    ->setCellValueByColumnAndRow(8, 20, 'Rate')
                                    ->setCellValueByColumnAndRow(9, 20, "Total \n\rAmount");
                            $objPHPExcel->getActiveSheet()->getStyle('B19')->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('C19')->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('D19')->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('E19')->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('F19:J19')->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('F20')->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('G20')->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('H20')->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('I20')->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('J20')->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('B20:E20')->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('B19:J20')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                            $objPHPExcel->getActiveSheet()->getStyle('B19:J20')->getFill()->getStartColor()->setARGB('FF99AD88');
                            $objPHPExcel->getActiveSheet()
                                    ->getStyle('B19:J21')
                                    ->getAlignment()
                                    ->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            for ($j = 0; $j < sizeof($requirement[$i]["requirement"]["painting"]); $j++) {
                                /* Block */
                                $objPHPExcel->getActiveSheet()
                                        ->setCellValueByColumnAndRow(2, $row, $requirement[$i]["requirement"]["painting"][$j]["name"]);
                                /* Floor */
                                for ($k = 0; $k < sizeof($requirement[$i]["requirement"]["painting"][$j]["floor"]); $k++) {
                                    $objPHPExcel->getActiveSheet()
                                            ->setCellValueByColumnAndRow(3, $row, $requirement[$i]["requirement"]["painting"][$j]["floor"][$k]["name"]);
                                    /* Location */
                                    for ($l = 0; $l < sizeof($requirement[$i]["requirement"]["painting"][$j]["floor"][$k]["location"]); $l++) {
                                        $newarr = explode(" ", str_replace($this->order, $this->replace, $requirement[$i]["requirement"]["painting"][$j]["floor"][$k]["location"][$l]["loc"]));
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
                                                ->setCellValueByColumnAndRow(1, $row, $si_no)
                                                ->setCellValueByColumnAndRow(4, $row, $requirement[$i]["requirement"]["painting"][$j]["floor"][$k]["location"][$l]["loc"])
                                                ->setCellValueByColumnAndRow(5, $row, $requirement[$i]["requirement"]["painting"][$j]["floor"][$k]["location"][$l]["length"])
                                                ->setCellValueByColumnAndRow(6, $row, $requirement[$i]["requirement"]["painting"][$j]["floor"][$k]["location"][$l]["breadth"])
                                                ->setCellValueByColumnAndRow(7, $row, $requirement[$i]["requirement"]["painting"][$j]["floor"][$k]["location"][$l]["area"])
                                                ->setCellValueByColumnAndRow(8, $row, $requirement[$i]["requirement"]["painting"][$j]["floor"][$k]["location"][$l]["rate"])
                                                ->setCellValueByColumnAndRow(9, $row, $requirement[$i]["requirement"]["painting"][$j]["floor"][$k]["location"][$l]["total"]);
                                        $objPHPExcel->getActiveSheet()->getStyle('E' . $row)->getAlignment()->setWrapText(true);
                                        $objPHPExcel->getActiveSheet()->getStyle('B' . ($row))->applyFromArray($styleArray2);
                                        $objPHPExcel->getActiveSheet()->getStyle('C' . ($row))->applyFromArray($styleArray2);
                                        $objPHPExcel->getActiveSheet()->getStyle('D' . ($row))->applyFromArray($styleArray2);
                                        $objPHPExcel->getActiveSheet()->getStyle('E' . ($row))->applyFromArray($styleArray2);
                                        $objPHPExcel->getActiveSheet()->getStyle('F' . ($row))->applyFromArray($styleArray2);
                                        $objPHPExcel->getActiveSheet()->getStyle('G' . ($row))->applyFromArray($styleArray2);
                                        $objPHPExcel->getActiveSheet()->getStyle('H' . ($row))->applyFromArray($styleArray2);
                                        $objPHPExcel->getActiveSheet()->getStyle('I' . ($row))->applyFromArray($styleArray2);
                                        $objPHPExcel->getActiveSheet()->getStyle('J' . ($row))->applyFromArray($styleArray2);
                                        $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(-1);
                                        $objPHPExcel->getActiveSheet()
                                                ->getStyle('B' . ($row) . ':J' . ($row))
                                                ->getAlignment()
                                                ->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                                                ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                        $row+=1;
                                        $si_no+=1;
                                    }
                                }
                            }
                            /* Calculations */
                            /* Total Painting */
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(9, $row, $this->parameters["ptotal"]);
                            $row+=1;
                            /* STC ON Painting  */
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(9, $row, $this->parameters["stc1"]);
                            $objPHPExcel->getActiveSheet()
                                    ->mergeCells('H' . $row . ':I' . $row);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(7, $row, 'STC @ 12.36%');
                            $row+=1;
                            /* STC E.CESS ON Painting  */
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(9, $row, $this->parameters["ecess1"]);
                            $objPHPExcel->getActiveSheet()
                                    ->mergeCells('H' . $row . ':I' . $row);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(7, $row, 'E.Cess 50% on 2%');
                            $row+=1;
                            /* STC H.E.CESS ON Painting  */
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(9, $row, $this->parameters["hecess1"]);
                            $objPHPExcel->getActiveSheet()
                                    ->mergeCells('H' . $row . ':I' . $row);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(7, $row, 'H E.Cess 50% on 1%');
                            $row+=1;
                            /* Gross Total ON Painting  */
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(9, $row, $this->parameters["nptot"]);
                            $objPHPExcel->getActiveSheet()
                                    ->mergeCells('H' . $row . ':I' . $row);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(7, $row, 'Painting Net Total');
                            $row += 1;
                            /* Footer */
                            $objPHPExcel->getActiveSheet()
                                    ->mergeCells('B' . ($row) . ':E' . ($row + 7));
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(1, $row, QUOT_FOOT);
                            $objPHPExcel->getActiveSheet()
                                    ->getStyle('B' . ($row) . ':E' . ($row + 7))
                                    ->getAlignment()
                                    ->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                            $row += 12;
                            $objPHPExcel->getActiveSheet()
                                    ->mergeCells('B' . ($row) . ':E' . ($row + 2));
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(1, $row, "Yours truly,\r\n" . $_SESSION["IOS"]["name"]);
                            $objPHPExcel->getActiveSheet()
                                    ->getStyle('B' . ($row) . ':E' . ($row + 2))
                                    ->getAlignment()
                                    ->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                        }
                        break;
                    }
                }
                $dirparameters = array(
                    "directory" => NULL,
                    "filename" => $this->parameters["ref_no"] . '_QUOT_' . date('j-M-Y') . '-' . md5(microtime(true)) . '.xlsx',
                    "filedirectory" => NULL,
                    "urlpath" => NULL,
                    "url" => NULL
                );
                returnDirectoryDoc($dirparameters, $parameters);
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                $objWriter->save($dirparameters["filedirectory"]);
                unset($objWriter);
                unset($objPHPExcel);
                /* documents */
                $query = 'INSERT INTO  `documents` (`id`,
							`file_name`,
							`type_id`,
							`doc_loc`,
							`mime_type`,
							`doc_type`,
							`dou`,
							`status_id`)  VALUES(
						NULL,
						\'' . $dirparameters["filename"] . '\',
						\'' . mysql_real_escape_string($this->parameters["quot_id"]) . '\',
						\'' . $dirparameters["url"] . '\',
						\'application/vnd.ms-excel\',
						\'quotation\',
						default,
						default);';
                executeQuery($query);
                $flag = true;
            }
        }
        if ($flag)
            executeQuery("COMMIT");
    }

    public function uploadCPO() {
        $flag = false;
        $size = ceil($this->parameters["size"] / 1024);
        $return = array(
            "url" => 'javascript:void(0);',
            "flag" => 0,
            "msg" => 'Error in uploading and saving client purchase order.'
        );
        global $filetypes;
        $listtypes = array_values($filetypes);
        if ($this->parameters["error"] == 0) {
            if (linear_search(strtolower($this->parameters["mmtype"]), $listtypes) && $size <= MAX_FILE_SIZE_KB) {
                executeQuery("SET AUTOCOMMIT=0;");
                executeQuery("START TRANSACTION;");
                /* Client Purchase Order */
                $query = 'UPDATE `client_po`
							SET `cpo_ref_no` = \'' . mysql_real_escape_string($this->parameters["cporefno"]) . '\',
							 `date` = \'' . mysql_real_escape_string($this->parameters["doi"]) . '\'
							WHERE `id` = \'' . mysql_real_escape_string($this->parameters["po_id"]) . '\'
							AND `ref_no` = \'' . mysql_real_escape_string($this->parameters["ref_no"]) . '\';';
                if (executeQuery($query)) {
                    $dirparameters = array(
                        "directory" => NULL,
                        "filename" => $this->parameters["ref_no"] . '_CPO_' . md5(microtime(true)) . '-' . str_replace(' ', '_', $this->parameters["filename"]),
                        "filedirectory" => NULL,
                        "urlpath" => NULL,
                        "url" => NULL
                    );
                    $parameters = array(
                        "uid" => $this->parameters["client_id"]
                    );
                    returnDirectoryDoc($dirparameters, $parameters);
                    if (move_uploaded_file($this->parameters["tmp_name"], $dirparameters["filedirectory"])) {
                        if (is_file($dirparameters["filedirectory"])) {
                            /* documents */
                            $query = 'INSERT INTO  `documents` (`id`,
										`file_name`,
										`type_id`,
										`doc_loc`,
										`mime_type`,
										`doc_type`,
										`dou`,
										`status_id`)  VALUES(
									NULL,
									\'' . $dirparameters["filename"] . '\',
									\'' . mysql_real_escape_string($this->parameters["po_id"]) . '\',
									\'' . $dirparameters["url"] . '\',
									\'' . mysql_real_escape_string($this->parameters["mmtype"]) . '\',
									\'client_po\',
									default,
									default);';
                            if (executeQuery($query)) {
                                executeQuery("COMMIT");
                                $return["url"] = URL . $dirparameters["url"];
                                $return["flag"] = 1;
                                $return["msg"] = 'Uploaded and saved client purchase order.';
                            }
                        }
                    }
                }
            } else {
                $return["url"] = 'javascript:void(0);';
                $return["flag"] = 0;
                $return["msg"] = 'Unsupported file type.<br /> Supposed to be (.doc) , (.docx) , (.pdf) , (.xls), (.xlsx)';
            }
        }
        return $return;
    }

    public function uploadDrawing() {
        $flag = false;
        $size = ceil($this->parameters["size"] / 1024);
        $return = array(
            "url" => 'javascript:void(0);',
            "flag" => 0,
            "msg" => 'Error in uploading and saving Drawing.'
        );
        global $filetypes;
        $listtypes = array_values($filetypes);
        if ($this->parameters["error"] == 0) {
            if (linear_search(strtolower($this->parameters["mmtype"]), $listtypes) && $size <= MAX_FILE_SIZE_KB) {
                executeQuery("SET AUTOCOMMIT=0;");
                executeQuery("START TRANSACTION;");
                /* Client Purchase Order */
                $query = 'INSERT INTO `drawing`(`id`,`user_pk`,`proj_id`,`proj_descp_id`,`draw_name`,`up_date`,`status_id`)'
                        . 'VALUES(NULL,'
                        . '"' . $this->parameters["designerid"] . '",'
                        . '"' . $this->parameters["prjmid"] . '",'
                        . '"' . $this->parameters["projdescid"] . '",'
                        . '"' . $this->parameters["ref_no"] . '",CURRENT_DATE,4)';
//					$query = 'UPDATE `client_po`
//							SET `cpo_ref_no` = \''.mysql_real_escape_string($this->parameters["cporefno"]).'\',
//							 `date` = \''.mysql_real_escape_string($this->parameters["doi"]).'\'
//							WHERE `id` = \''.mysql_real_escape_string($this->parameters["po_id"]).'\'
//							AND `ref_no` = \''.mysql_real_escape_string($this->parameters["ref_no"]).'\';';
                if (executeQuery($query)) {
                    $dirparameters = array(
                        "directory" => NULL,
                        "filename" => $this->parameters["ref_no"] . '_drawing_' . md5(microtime(true)) . '-' . str_replace(' ', '_', $this->parameters["filename"]),
                        "filedirectory" => NULL,
                        "urlpath" => NULL,
                        "url" => NULL
                    );
                    $parameters = array(
                        "uid" => $this->parameters["client_id"]
                    );
                    returnDirectoryDoc($dirparameters, $parameters);
                    if (move_uploaded_file($this->parameters["tmp_name"], $dirparameters["filedirectory"])) {
                        if (is_file($dirparameters["filedirectory"])) {
                            /* documents */
                            $query = 'INSERT INTO  `documents` (`id`,
										`file_name`,
										`type_id`,
										`doc_loc`,
										`mime_type`,
										`doc_type`,
										`dou`,
										`status_id`)  VALUES(
									NULL,
									\'' . $dirparameters["filename"] . '\',
									\'' . mysql_real_escape_string($this->parameters["po_id"]) . '\',
									\'' . $dirparameters["url"] . '\',
									\'' . mysql_real_escape_string($this->parameters["mmtype"]) . '\',
									\'drawing\',
									default,
									default);';
                            if (executeQuery($query)) {
                                executeQuery("COMMIT");
                                $return["url"] = URL . $dirparameters["url"];
                                $return["flag"] = 1;
                                $return["msg"] = 'Uploaded and saved client purchase order.';
                            }
                        }
                    }
                }
            } else {
                $return["url"] = 'javascript:void(0);';
                $return["flag"] = 0;
                $return["msg"] = 'Unsupported file type.<br /> Supposed to be (.doc) , (.docx) , (.pdf) , (.xls), (.xlsx)';
            }
        }
        return $return;
    }

    public function createProjectPlan() {
        $flag = false;
        /* Project */
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        $query = 'UPDATE  `project`
						SET `project_md` = \'' . mysql_real_escape_string($this->parameters["mdid"]) . '\',
							`project_eng` = \'' . mysql_real_escape_string($this->parameters["engid"]) . '\',
							`project_mng` = \'' . mysql_real_escape_string($this->parameters["mngid"]) . '\',
							`project_hld` = \'' . mysql_real_escape_string($this->parameters["hldid"]) . '\',
							`psd` = \'' . mysql_real_escape_string($this->parameters["sd"]) . '\',
							`pcd` = \'' . mysql_real_escape_string($this->parameters["cd"]) . '\',
							`discussed` = \'' . mysql_real_escape_string($this->parameters["sn"]) . '\',
							`progress` = \'' . mysql_real_escape_string($this->parameters["st"]) . '\',
							`met_timeline` = \'' . mysql_real_escape_string($this->parameters["mt"]) . '\'
					WHERE `requi_id` = \'' . mysql_real_escape_string($this->parameters["requi_id"]) . '\';';
        if (executeQuery($query)) {
            /* Project Task YES / NO */
            for ($i = 0; $i < sizeof($this->parameters["prod"]); $i++) {
                $query = 'UPDATE  `project_description`
								SET `production` = \'' . mysql_real_escape_string($this->parameters["prod"][$i]["production"]) . '\'
							WHERE `id` = \'' . mysql_real_escape_string($this->parameters["prod"][$i]["taskid"]) . '\';';
                executeQuery($query);
            }
            /* Project Task Assignee */
            for ($i = 0; $i < sizeof($this->parameters["assn"]); $i++) {
                if (isset($this->parameters["assn"][$i]["assnid"]) && $this->parameters["assn"][$i]["assnid"] != '' && $this->parameters["assn"][$i]["assnid"] > 0) {
                    $query = 'INSERT INTO  `project_team_members` (`id`,
								`project_id`,
								`proj_descp_id`,
								`team_member`,
								`project_status`,
								`status_id`)  VALUES(
							NULL,
							(SELECT `id` FROM `project` WHERE `ref_no` = \'' . mysql_real_escape_string($this->parameters["ref_no"]) . '\'),
							\'' . mysql_real_escape_string($this->parameters["assn"][$i]["taskid"]) . '\',
							\'' . mysql_real_escape_string($this->parameters["assn"][$i]["assnid"]) . '\',
							default,default);';
                    executeQuery($query);
                }
                if (isset($this->parameters["assn"][$i]["assnid"]) && $this->parameters["assn"][$i]["assnid"] != '' && $this->parameters["assn"][$i]["assnid"] > 0 &&
                        isset($this->parameters["assn"][$i]["sms"]) && $this->parameters["assn"][$i]["sms"] != '') {
                    $query = 'UPDATE  `project_description`
									SET `feedback` = \'' . mysql_real_escape_string($this->parameters["assn"][$i]["sms"]) . '\'
								 WHERE `id` = \'' . mysql_real_escape_string($this->parameters["assn"][$i]["taskid"]) . '\';';
                    executeQuery($query);
                    /* Send SMS */
                    $query = 'SELECT
								GROUP_CONCAT(cn.`cell_number`) AS cnumber
							FROM `cell_numbers` AS cn
							WHERE cn.`status_id` = (SELECT `id` FROM `status` WHERE `statu_name` = "Show" AND `status` = 1)
							AND cn.`user_pk` = \'' . mysql_real_escape_string($this->parameters["assn"][$i]["assnid"]) . '\'
							GROUP BY(cn.`user_pk`)
							HAVING COUNT(cn.`id`) < ' . MAX_SMS_NO . '
							ORDER BY(cn.`user_pk`)';
                    $res = executeQuery($query);
                    $cellno = NULL;
                    $msg = str_replace($this->order, $this->replace, $this->parameters["assn"][$i]["sms"]);
                    if (mysql_num_rows($res) > 0) {
                        $cellno = mysql_result($res, 0);
                    }
                    if ($cellno != NULL) {
                        $restPara = array(
                            "user" => 'madmec',
                            "password" => 'madmec',
                            "mobiles" => $cellno,
                            "sms" => $msg,
                            "senderid" => 'MADMEC',
                            "version" => 3,
                            "accountusagetypeid" => 1
                        );
                        $url = 'http://trans.profuseservices.com/sendsms.jsp?' . http_build_query($restPara);
                        $response = file_get_contents($url);
                        if ($response) {
                            $cellno = explode(",", $cellno);
                            if (is_array($cellno)) {
                                for ($j = 0; $j < sizeof($cellno); $j++) {
                                    $query = 'INSERT INTO `crm_sms`(`id`,
                                                                                                                `from_pk`,
                                                                                                                `to_pk`,
                                                                                                                `to_mobile`,
                                                                                                                `text`,
                                                                                                                `msg_type`,
                                                                                                                `date`,
                                                                                                                `status_id`) VALUES
													(NULL,
													\'' . mysql_real_escape_string($_SESSION["IOS"]["id"]) . '\',
													\'' . mysql_real_escape_string($this->parameters["assn"][$i]["assnid"]) . '\',
													\'' . mysql_real_escape_string($cellno[$j]) . '\',
													\'' . mysql_real_escape_string($msg) . '\',
													1,
													NOW(),
													14);';
                                    executeQuery($query);
                                }
                            } else {
                                $query = 'INSERT INTO `crm_sms`(`id`,
																	`from_pk`,
																	`to_pk`,
																	`to_mobile`,
																	`text`,
																	`msg_type`,
																	`date`,
																	`status_id`) VALUES
												(NULL,
												\'' . mysql_real_escape_string($_SESSION["IOS"]["id"]) . '\',
												\'' . mysql_real_escape_string($this->parameters["assn"][$i]["assnid"]) . '\',
												\'' . mysql_real_escape_string($cellno) . '\',
												\'' . mysql_real_escape_string($msg) . '\',
												1,
												NOW(),
												14);';
                                executeQuery($query);
                            }
                        }
                    }
                }
            }
            $flag = true;
        }
        if ($flag) {
            executeQuery("COMMIT");
        }
    }

    public function addPCC() {
        $pcc_pk = 0;
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        /* PCC */
        $query = 'INSERT INTO  `pcc` (`id`,
						`requi_id`,
						`quot_id`,
						`client_po`,
						`proj_id`,
						`proj_descp_id`,
						`name`,
						`city`,
						`code`,
						`revision`,
						`sd_wood`,
						`sd_metal`,
						`ed_project`,
						`frame_config`,
						`wrkstn_height`,
						`tot_wrkstn`,
						`status_id`)  VALUES(
					NULL,
					\'' . mysql_real_escape_string($this->parameters["requi_id"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["quot_id"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["po_id"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["prjid"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["taskid"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["pccn"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["pccl"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["pccc"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["pccrv"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["pccsdw"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["pccsdm"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["pccdd"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["pccfc"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["pccwh"]) . '\',
					\'' . mysql_real_escape_string($this->parameters["pcctw"]) . '\',
					default);';
        if (executeQuery($query)) {
            $pcc_pk = mysql_result(executeQuery('SELECT LAST_INSERT_ID();'), 0);
            /* PCC Task */
            if (is_array($this->parameters["taskdescp"]) && sizeof($this->parameters["taskdescp"]) > -1) {
                for ($i = 0; $i < sizeof($this->parameters["taskdescp"]); $i++) {
                    for ($j = 0; $j < sizeof($this->parameters["taskdescp"][$i]["deliinst"]); $j++) {
                        $query = 'INSERT INTO  `pcc_task` (`id`,
											`pcc_id`,
											`mat_descp`,
											`size`,
											`colour`,
											`qty`,
											`remark`,
											`status_id`) VALUES(NULL,
								\'' . mysql_real_escape_string($pcc_pk) . '\',
								\'' . mysql_real_escape_string($this->parameters["taskdescp"][$i]["parti"]) . '\',
								\'' . mysql_real_escape_string($this->parameters["taskdescp"][$i]["deliinst"][$j]["size"]) . '\',
								\'' . mysql_real_escape_string($this->parameters["taskdescp"][$i]["deliinst"][$j]["colour"]) . '\',
								\'' . mysql_real_escape_string($this->parameters["taskdescp"][$i]["deliinst"][$j]["qty"]) . '\',
								\'' . mysql_real_escape_string($this->parameters["taskdescp"][$i]["deliinst"][$j]["remark"]) . '\',
								default);';
                        executeQuery($query);
                    }
                }
            }
            $para = array(
                "addressee" => NULL,
                "toaddress" => NULL
            );
            $parameters = array(
                "uid" => $this->parameters["client_id"]
            );
            returnClientDet($para, $parameters);

            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getProperties()->setCreator(SOFT_NAME)
                    ->setLastModifiedBy(SOFT_NAME)
                    ->setTitle('PCC')
                    ->setSubject('Project Control Chart')
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
            /*
              Set printing break
              $objPHPExcel->getActiveSheet()->setBreak( 'A47' , PHPExcel_Worksheet::BREAK_ROW );
             */
            $myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'PCC');
            $objPHPExcel->addSheet($myWorkSheet, 0);
            $objPHPExcel->setActiveSheetIndexByName('PCC');
            $objPHPExcel->getActiveSheet()
                    ->getPageSetup()
                    ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT)
                    ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4)
                    ->setHorizontalCentered(true)
                    ->setVerticalCentered(false);
            $objPHPExcel->getActiveSheet()
                    ->getHeaderFooter()
                    ->setOddHeader('&C&H Production Control Chart Document Generated on ' . date('j-M-Y'))
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
                    /* Header */
                    ->mergeCells('A1:F1')
                    /* Project Name Title */
                    ->mergeCells('A2:C2')
                    /* Location and code Title */
                    ->mergeCells('A3:C3')
                    /* Frame Configuration Title */
                    ->mergeCells('A4:C4')
                    /* Workstation Height Title */
                    ->mergeCells('A5:C5')
                    /* Total Workstation Title */
                    ->mergeCells('A6:C6')
                    /* Revision Title */
                    ->mergeCells('A7:C7')
                    /* Starting Wood Work Title */
                    ->mergeCells('A8:C8')
                    /* Starting Wood Metal Title */
                    ->mergeCells('A9:C9')
                    /* Dispatch Title */
                    ->mergeCells('A10:C10')
                    /* Project Name Value */
                    ->mergeCells('D2:F2')
                    /* Location and code Value */
                    ->mergeCells('D3:E3')
                    /* Frame Configuration Value */
                    ->mergeCells('D4:F4')
                    /* Workstation Height Value */
                    ->mergeCells('D5:F5')
                    /* Total Workstation Value */
                    ->mergeCells('D6:F6')
                    /* Revision Value */
                    ->mergeCells('D7:F7')
                    /* Starting Date Wood Work Value */
                    ->mergeCells('D8:F8')
                    /* Starting Date Wood Metal Value */
                    ->mergeCells('D9:F9')
                    /* Dispatch Date Value */
                    ->mergeCells('D10:F10');
            /* Header */
            $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFill()->getStartColor()->setARGB('FF66EE33');
            $objPHPExcel->getActiveSheet()
                    ->getStyle('A1:F1')
                    ->getAlignment()
                    ->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()
                    ->setCellValueByColumnAndRow(0, 1, 'Production Control Chart');
            /* Project Name Title */
            $objPHPExcel->getActiveSheet()
                    ->setCellValueByColumnAndRow(0, 2, 'Project Name');
            /* Project Name Value */
            $objPHPExcel->getActiveSheet()
                    ->setCellValueByColumnAndRow(3, 2, $this->parameters["prjname"]);
            /* Location & Code Title */
            $objPHPExcel->getActiveSheet()
                    ->setCellValueByColumnAndRow(0, 3, 'Location & Code');
            /* Location Value */
            $objPHPExcel->getActiveSheet()
                    ->setCellValueByColumnAndRow(3, 3, $this->parameters["pccl"]);
            /* Code Value */
            $objPHPExcel->getActiveSheet()
                    ->setCellValueByColumnAndRow(5, 3, $this->parameters["pccc"]);
            /* Frame Configuration Title */
            $objPHPExcel->getActiveSheet()
                    ->setCellValueByColumnAndRow(0, 4, 'Frame Configuration');
            /* Frame Configuration Value */
            $objPHPExcel->getActiveSheet()
                    ->setCellValueByColumnAndRow(3, 4, $this->parameters["pccfc"]);
            /* Workstation Height Title */
            $objPHPExcel->getActiveSheet()
                    ->setCellValueByColumnAndRow(0, 5, 'Workstation Height');
            /* Workstation Height Value */
            $objPHPExcel->getActiveSheet()
                    ->setCellValueByColumnAndRow(3, 5, $this->parameters["pccwh"]);
            /* Total Workstation Title */
            $objPHPExcel->getActiveSheet()
                    ->setCellValueByColumnAndRow(0, 6, 'Total Workstation');
            /* Total Workstation Value */
            $objPHPExcel->getActiveSheet()
                    ->setCellValueByColumnAndRow(3, 6, $this->parameters["pcctw"]);
            /* Revision Title */
            $objPHPExcel->getActiveSheet()
                    ->setCellValueByColumnAndRow(0, 7, 'Revision');
            /* Revision Value */
            $objPHPExcel->getActiveSheet()
                    ->setCellValueByColumnAndRow(3, 7, $this->parameters["pccrv"]);
            /* Starting Date Wood Work Title */
            $objPHPExcel->getActiveSheet()
                    ->setCellValueByColumnAndRow(0, 8, 'Starting Wood Work');
            /* Starting Date Wood Work Value */
            $objPHPExcel->getActiveSheet()
                    ->setCellValueByColumnAndRow(3, 8, date('j-M-Y', strtotime($this->parameters["pccsdw"])));
            /* Starting Date Metal Work Title */
            $objPHPExcel->getActiveSheet()
                    ->setCellValueByColumnAndRow(0, 9, 'Starting Date Metal Work');
            /* Starting Date Metal Work Value */
            $objPHPExcel->getActiveSheet()
                    ->setCellValueByColumnAndRow(3, 9, date('j-M-Y', strtotime($this->parameters["pccsdm"])));
            /* Dispatch date Title */
            $objPHPExcel->getActiveSheet()
                    ->setCellValueByColumnAndRow(0, 10, 'Dispatch date');
            /* Dispatch date Value */
            $objPHPExcel->getActiveSheet()
                    ->setCellValueByColumnAndRow(3, 10, date('j-M-Y', strtotime($this->parameters["pccdd"])));
            /* Add titles  of the columns */
            $objPHPExcel->getActiveSheet()
                    ->setCellValueByColumnAndRow(0, 11, 'Sl No:')
                    ->setCellValueByColumnAndRow(1, 11, "Material \n Description")
                    ->setCellValueByColumnAndRow(2, 11, 'Size')
                    ->setCellValueByColumnAndRow(3, 11, 'Colour')
                    ->setCellValueByColumnAndRow(4, 11, 'Qty')
                    ->setCellValueByColumnAndRow(5, 11, "Remarks \n/ Others");
            /* Colour the borders */
            $objPHPExcel->getActiveSheet()->getStyle('A11')->applyFromArray($styleArray1);
            $objPHPExcel->getActiveSheet()->getStyle('B11')->applyFromArray($styleArray1);
            $objPHPExcel->getActiveSheet()->getStyle('C11')->applyFromArray($styleArray1);
            $objPHPExcel->getActiveSheet()->getStyle('D11')->applyFromArray($styleArray1);
            $objPHPExcel->getActiveSheet()->getStyle('E11')->applyFromArray($styleArray1);
            $objPHPExcel->getActiveSheet()->getStyle('F11')->applyFromArray($styleArray1);
            $objPHPExcel->getActiveSheet()->getStyle('A11:F11')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $objPHPExcel->getActiveSheet()->getStyle('A11:F11')->getFill()->getStartColor()->setARGB('FF99AD88');
            $objPHPExcel->getActiveSheet()
                    ->getStyle('A11:F11')
                    ->getAlignment()
                    ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)
                    ->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getRowDimension(11)->setRowHeight(28);
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(7);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(14);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            /* PCC */
            if (is_array($this->parameters["taskdescp"]) && sizeof($this->parameters["taskdescp"]) > -1) {
                $row = 12;
                $si_no = 1;
                for ($i = 0; $i < sizeof($this->parameters["taskdescp"]); $i++) {
                    $objPHPExcel->getActiveSheet()
                            ->mergeCells('A' . ($row) . ':F' . $row);
                    $objPHPExcel->getActiveSheet()
                            ->setCellValueByColumnAndRow(0, $row, $this->parameters["taskdescp"][$i]["parti"]);
                    $objPHPExcel->getActiveSheet()->getStyle('A' . ($row) . ':F' . $row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                    $objPHPExcel->getActiveSheet()->getStyle('A' . ($row) . ':F' . $row)->getFill()->getStartColor()->setARGB('FF66EE33');
                    $objPHPExcel->getActiveSheet()
                            ->getStyle('A' . ($row) . ':F' . $row)
                            ->getAlignment()
                            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()
                            ->getStyle('A' . ($row) . ':F' . $row)
                            ->getAlignment()
                            ->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('A' . ($row) . ':F' . $row)->applyFromArray($styleArray2);
                    $row+=1;
                    $end = sizeof($this->parameters["taskdescp"][$i]["deliinst"]) + ($row - 1);
                    $objPHPExcel->getActiveSheet()
                            ->getStyle('B' . ($row) . ':B' . ($end))
                            ->getAlignment()
                            ->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                            ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()
                            ->setCellValueByColumnAndRow(1, $row, $this->parameters["taskdescp"][$i]["parti"]);
                    $objPHPExcel->getActiveSheet()->getStyle('B' . ($row) . ':B' . $end)->applyFromArray($styleArray2);
                    $objPHPExcel->getActiveSheet()
                            ->mergeCells('B' . ($row) . ':B' . $end);
                    for ($j = 0; $j < sizeof($this->parameters["taskdescp"][$i]["deliinst"]); $j++) {
                        $newarr = explode(" ", str_replace($this->order, $this->replace, $this->parameters["taskdescp"][$i]["parti"]));
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
                                // ->setCellValueByColumnAndRow(1,$row, $this->parameters["taskdescp"][$i]["parti"])
                                ->setCellValueByColumnAndRow(2, $row, $this->parameters["taskdescp"][$i]["deliinst"][$j]["size"])
                                ->setCellValueByColumnAndRow(3, $row, $this->parameters["taskdescp"][$i]["deliinst"][$j]["colour"])
                                ->setCellValueByColumnAndRow(4, $row, $this->parameters["taskdescp"][$i]["deliinst"][$j]["qty"])
                                ->setCellValueByColumnAndRow(5, $row, $this->parameters["taskdescp"][$i]["deliinst"][$j]["remark"]);
                        $objPHPExcel->getActiveSheet()->getStyle('A' . ($row))->applyFromArray($styleArray2);
                        // $objPHPExcel->getActiveSheet()->getStyle('B'.($row))->applyFromArray($styleArray2);
                        $objPHPExcel->getActiveSheet()->getStyle('C' . ($row))->applyFromArray($styleArray2);
                        $objPHPExcel->getActiveSheet()->getStyle('D' . ($row))->applyFromArray($styleArray2);
                        $objPHPExcel->getActiveSheet()->getStyle('E' . ($row))->applyFromArray($styleArray2);
                        $objPHPExcel->getActiveSheet()->getStyle('F' . ($row))->applyFromArray($styleArray2);
                        $row+=1;
                        $si_no+=1;
                    }
                }
            }
            /* Footer  */
            $row+=1;
            $objPHPExcel->getActiveSheet()
                    /* Project Engineer  */
                    ->mergeCells('B' . $row . ':C' . $row)
                    /* Project Holder  */
                    ->mergeCells('D' . $row . ':E' . $row);
            $objPHPExcel->getActiveSheet()
                    ->getStyle('B' . $row . ':C' . $row)
                    ->getAlignment()
                    ->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                    ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()
                    ->getStyle('D' . $row . ':E' . $row)
                    ->getAlignment()
                    ->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                    ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            /* Project Engineer  */
            $objPHPExcel->getActiveSheet()
                    ->setCellValueByColumnAndRow(1, $row, "Project Engineer Sign");
            /* Project Holder  */
            $objPHPExcel->getActiveSheet()
                    ->setCellValueByColumnAndRow(3, $row, "Project Holder Sign");
            $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(35);
            $row+=6;
            $objPHPExcel->getActiveSheet()
                    /* Project Manager  */
                    ->mergeCells('B' . $row . ':C' . $row)
                    /* Project MD  */
                    ->mergeCells('D' . $row . ':E' . $row);
            $objPHPExcel->getActiveSheet()
                    ->getStyle('B' . $row . ':C' . $row)
                    ->getAlignment()
                    ->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                    ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()
                    ->getStyle('D' . $row . ':E' . $row)
                    ->getAlignment()
                    ->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                    ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            /* Project Manager  */
            $objPHPExcel->getActiveSheet()
                    ->setCellValueByColumnAndRow(1, $row, "Project Manager Sign");
            /* Project MD  */
            $objPHPExcel->getActiveSheet()
                    ->setCellValueByColumnAndRow(3, $row, "Project MD Sign");
            $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(35);
            /* Set printing area */
            $objPHPExcel->getActiveSheet()->getPageSetup()->setPrintArea('A0:F' . ($row + 2));
            $dirparameters = array(
                "directory" => NULL,
                "filename" => $this->parameters["ref_no"] . '_PCC_' . date('j-M-Y') . '-' . md5(microtime(true)) . '.xlsx',
                "filedirectory" => NULL,
                "urlpath" => NULL,
                "url" => NULL
            );
            returnDirectoryDoc($dirparameters, $parameters);
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save($dirparameters["filedirectory"]);
            unset($objWriter);
            unset($objPHPExcel);
            /* documents */
            $query = 'INSERT INTO  `documents` (`id`,
						`file_name`,
						`type_id`,
						`doc_loc`,
						`mime_type`,
						`doc_type`,
						`dou`,
						`status_id`)  VALUES(
					NULL,
					\'' . $dirparameters["filename"] . '\',
					\'' . mysql_real_escape_string($this->parameters["quot_id"]) . '\',
					\'' . $dirparameters["url"] . '\',
					\'application/vnd.ms-excel\',
					\'project_description\',
					default,
					default);';
            executeQuery($query);
            $flag = true;
        }
        if ($flag) {
            executeQuery("COMMIT");
        }
    }

    public function generateInvoice() {
        $flag = false;
        executeQuery("SET AUTOCOMMIT=0;");
        executeQuery("START TRANSACTION;");
        if ($_SESSION["requirement"] != NULL) {
            $requirement = $_SESSION["requirement"];
            /* Vehicle */
            $query1 = 'INSERT INTO  `vehicle` (`id`,
							`user_to_pk`,
							`user_from_pk`,
							`driver`,
							`vehicle_no`,
							`place`,
							`lr_no`,
							`transporter`,
							`mot`,
							`empty_weight`,
							`loaded_weight`,
							`total_weight`,
							`advance_amt`,
							`rent`,
							`arrival`,
							`departure`,
							`status_id`)  VALUES(
						NULL,
						\'' . mysql_real_escape_string($this->parameters["client_id"]) . '\',
						\'' . mysql_real_escape_string($_SESSION["IOS"]["id"]) . '\',
						\'' . mysql_real_escape_string($this->parameters["drivid"]) . '\',
						\'' . mysql_real_escape_string($this->parameters["vhno"]) . '\',
						\'' . mysql_real_escape_string($this->parameters["dlepla"]) . '\',
						\'' . mysql_real_escape_string($this->parameters["lrno"]) . '\',
						\'' . mysql_real_escape_string($this->parameters["transid"]) . '\',
						\'' . mysql_real_escape_string($this->parameters["motid"]) . '\',
						\'0\',
						\'0\',
						\'0\',
						\'0\',
						\'0\',
						default,
						default,
						default);';
            /* Invoice */
            $query2 = 'UPDATE `invoice`
						SET `doi` = NOW(),
							`addresse` = \'' . mysql_real_escape_string(ADDRESSE . $this->parameters["rep"]) . '\',
							`subject` = \'' . mysql_real_escape_string($this->parameters["sub"]) . '\',
							`descp` = \'' . mysql_real_escape_string($this->parameters["qdesc"]) . '\',
							`ptotal` = \'' . mysql_real_escape_string($this->parameters["nptot"]) . '\',
							`totsup` = \'' . mysql_real_escape_string($this->parameters["nsuptot"]) . '\',
							`totins` = \'' . mysql_real_escape_string($this->parameters["ninstot"]) . '\',
							`vat` = \'' . mysql_real_escape_string($this->parameters["vat"]) . '\',
							`stc1` = \'' . mysql_real_escape_string($this->parameters["stc1"]) . '\',
							`stc1_50_1236_2` = \'' . mysql_real_escape_string($this->parameters["ecess1"]) . '\',
							`stc1_50_1236_1` = \'' . mysql_real_escape_string($this->parameters["hecess1"]) . '\',
							`stc2` = \'' . mysql_real_escape_string($this->parameters["stc2"]) . '\',
							`stc2_50_1236_2` = \'' . mysql_real_escape_string($this->parameters["ecess2"]) . '\',
							`stc2_50_1236_1` = \'' . mysql_real_escape_string($this->parameters["hecess2"]) . '\',
							`net_total` = \'' . mysql_real_escape_string($this->parameters["qgtot"]) . '\',
							`status` = "20"
						WHERE `id` = \'' . mysql_real_escape_string($this->parameters["requi_id"]) . '\';';
            if (executeQuery($query1) && executeQuery($query2)) {
                $para = array(
                    "addressee" => NULL,
                    "toaddress" => NULL
                );
                $parameters = array(
                    "uid" => $this->parameters["client_id"]
                );
                returnClientDet($para, $parameters);
                $number = $this->parameters["qgtot"];
                $numtowords = convertNumberToWordsForIndia($number);
                $objPHPExcel = new PHPExcel();
                $objPHPExcel->getProperties()->setCreator(SOFT_NAME)
                        ->setLastModifiedBy(SOFT_NAME)
                        ->setTitle('Quotation')
                        ->setSubject('Quotation Document')
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
                /*
                  Set printing area
                  $objPHPExcel->getActiveSheet()->getPageSetup()->setPrintArea('A1:I1');
                 */
                /*
                  Set printing break
                  $objPHPExcel->getActiveSheet()->setBreak( 'A47' , PHPExcel_Worksheet::BREAK_ROW );
                 */
                /* Invoice */
                for ($i = 0; $i < sizeof($requirement); $i++) {
                    if ($this->parameters["ind"] == $i &&
                            $requirement[$i]["proj_manage"]["req_id"] == $this->parameters["requi_id"] &&
                            $requirement[$i]["proj_manage"]["quot_id"] == $this->parameters["quot_id"]
                    ) {
                        /* Production / Manufacturing  */
                        if (is_array($requirement[$i]["requirement"]["production"]) && sizeof($requirement[$i]["requirement"]["production"]) > -1) {
                            $myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'Production Invoice');
                            $objPHPExcel->addSheet($myWorkSheet, 0);
                            $objPHPExcel->setActiveSheetIndexByName('Production Invoice');
                            $objPHPExcel->getActiveSheet()
                                    ->getPageSetup()
                                    ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT)
                                    ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4)
                                    ->setHorizontalCentered(true)
                                    ->setVerticalCentered(false);
                            $objPHPExcel->getActiveSheet()
                                    ->getHeaderFooter()
                                    ->setOddHeader('&C&H Invoice Document Generated on ' . date('j-M-Y'))
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
                                    /* Logo */
                                    ->mergeCells('B2:I5')
                                    /* Invoice Heading */
                                    ->mergeCells('E6:G6')
                                    /* Reference no */
                                    ->mergeCells('B7:D7')
                                    /* Date */
                                    ->mergeCells('H11:I11')
                                    /* Billing address */
                                    ->mergeCells('B13:F15')
                                    /* Delivery address */
                                    ->mergeCells('G13:J15')
                                    /* Addressee */
                                    ->mergeCells('B20:D20')
                                    /* Subject */
                                    ->mergeCells('B21:E21')
                                    /* Designation */
                                    ->mergeCells('B22:C22')
                                    /* Project name */
                                    ->mergeCells('B24:G24')
                                    /* Particulars */
                                    ->mergeCells('C25:D25');
                            /* Logo */
                            if (file_exists(LOGO_IMAGE_DOC)) {
                                $objDrawing = new PHPExcel_Worksheet_Drawing();
                                $objDrawing->setName('IOS LOGO');
                                $objDrawing->setDescription('Integro Office Solution');
                                //Path to signature .jpg file
                                $signature = LOGO_IMAGE_DOC;
                                $objDrawing->setPath($signature);
                                $objDrawing->setOffsetX(0);
                                $objDrawing->setCoordinates('B2');
                                $objDrawing->setHeight(49);
                                $objDrawing->setWidth(669);
                                $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
                            }
                            /* Invoice Heading */
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(4, 6, '	 TAX INVOICE ');
                            /* Reference no */
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(1, 7, 'Reference no : ' . $this->parameters["ref_no"]);
                            /* TIN,PAN,STC,Category */
                            $objPHPExcel->getActiveSheet()->getStyle('B8:D11')->applyFromArray($styleArray2);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(1, 8, 'TIN No.:29250827721')
                                    ->mergeCells('B8:C8');
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(1, 9, 'Service tax No.:AKKPR4495GST001')
                                    ->mergeCells('B9:D9');
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(1, 10, 'Category:Works Contract')
                                    ->mergeCells('B10:C10');
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(1, 11, 'PAN No.:AKKPR4495G')
                                    ->mergeCells('B11:C11');
                            /* Date */
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(7, 7, 'Date : ' . date('j-M-Y'));
                            $objPHPExcel->getActiveSheet()->getStyle('B7:J7')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                            $objPHPExcel->getActiveSheet()->getStyle('B7:J7')->getFill()->getStartColor()->setARGB('FF00CCFF');
                            /* To address */
                            $objPHPExcel->getActiveSheet()
                                    ->mergeCells('B12:F12');
                            $objPHPExcel->getActiveSheet()->getStyle('B12')->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()
                                    ->getStyle('B13:D15')
                                    ->getAlignment()
                                    ->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(1, 12, 'Billing Address:')
                                    ->setCellValueByColumnAndRow(1, 13, $para["toaddress"]);
                            $objPHPExcel->getActiveSheet()->getStyle('B13:D15')->applyFromArray($styleArray1);
                            /* Delivery address */
                            $objPHPExcel->getActiveSheet()
                                    ->mergeCells('G12:J12');
                            $objPHPExcel->getActiveSheet()
                                    ->getStyle('G13:J15')
                                    ->getAlignment()
                                    ->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                            $objPHPExcel->getActiveSheet()->getStyle('G12:J12')->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(6, 12, 'Delivery Address:')
                                    ->setCellValueByColumnAndRow(6, 13, $para["toaddress"]);
                            $objPHPExcel->getActiveSheet()->getStyle('G13:J15')->applyFromArray($styleArray1);
                            /* Client TIN  and STC */
                            $objPHPExcel->getActiveSheet()->getStyle('B16:D17')->applyFromArray($styleArray2);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(1, 16, 'Client TIN No.:' . $para["tin"])
                                    ->mergeCells('B16:E16');
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(1, 17, 'Client Service Tax No.:' . $para["stc"])
                                    ->mergeCells('B17:E17');
                            /* Addressee */
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(1, 20, ADDRESSE . ' ' . $para["addressee"]);
                            /* Subject */
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(1, 21, 'Invoice ' . $this->parameters["sub"]);
                            /* Designation */
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(1, 22, DESIG);
                            /* Project name */
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(1, 24, ' Project Name : ' . $this->parameters["prjname"]);
                            /* Requirement Description */
                            /* Add titles  of the columns */
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(1, 25, 'Sl No:')
                                    ->setCellValueByColumnAndRow(2, 25, 'Particular')
                                    ->setCellValueByColumnAndRow(4, 25, 'Qty')
                                    ->setCellValueByColumnAndRow(5, 25, 'Unit')
                                    ->setCellValueByColumnAndRow(6, 25, 'Supply')
                                    ->setCellValueByColumnAndRow(7, 25, 'Installation')
                                    ->setCellValueByColumnAndRow(8, 25, 'Supply')
                                    ->setCellValueByColumnAndRow(9, 25, 'Installation');
                            /* Colour the borders */
                            $objPHPExcel->getActiveSheet()->getStyle('B25')->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('C25')->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('E25')->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('F25')->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('G25')->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('H25')->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('I25')->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('J25')->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('B25:J25')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                            $objPHPExcel->getActiveSheet()->getStyle('B25:J25')->getFill()->getStartColor()->setARGB('FF99AD88');
                            $objPHPExcel->getActiveSheet()
                                    ->getStyle('B25:J25')
                                    ->getAlignment()
                                    ->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(46);
                            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
                            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(13);
                            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(13);
                            //$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(13);
                            $objPHPExcel->getActiveSheet()->getRowDimension(25)->setRowHeight(20);
                            // $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(-1);
                            $row = 26;
                            $si_no = 1;
                            for ($j = 0; $j < sizeof($requirement[$i]["requirement"]["production"]) - 1; $j++) {
                                $newarr = explode(" ", str_replace($this->order, $this->replace, $requirement[$i]["requirement"]["production"][$j]["part"]));
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
                                        ->setCellValueByColumnAndRow(1, $row, $si_no)
                                        ->setCellValueByColumnAndRow(2, $row, $requirement[$i]["requirement"]["production"][$j]["part"])
                                        ->setCellValueByColumnAndRow(4, $row, $requirement[$i]["requirement"]["production"][$j]["qty"])
                                        ->setCellValueByColumnAndRow(5, $row, $requirement[$i]["requirement"]["production"][$j]["unit"]);
                                $objPHPExcel->getActiveSheet()->getStyle('C' . $row)->getAlignment()->setWrapText(true);
                                $objPHPExcel->getActiveSheet()->getStyle('B' . ($row))->applyFromArray($styleArray2);
                                $objPHPExcel->getActiveSheet()->getStyle('C' . ($row))->applyFromArray($styleArray2);
                                $objPHPExcel->getActiveSheet()->getStyle('D' . ($row))->applyFromArray($styleArray2);
                                $objPHPExcel->getActiveSheet()->getStyle('E' . ($row))->applyFromArray($styleArray2);
                                for ($k = 0; $k < sizeof($requirement[$i]["requirement"]["production"][$j]["deliinst"]); $k++) {
                                    if ($k == 0) {
                                        $objPHPExcel->getActiveSheet()
                                                ->setCellValueByColumnAndRow(6, $row, $requirement[$i]["requirement"]["production"][$j]["deliinst"][$k]["supply"])
                                                ->setCellValueByColumnAndRow(7, $row, $requirement[$i]["requirement"]["production"][$j]["deliinst"][$k]["instal"]);
                                    } else if ($k != 0 && ($k % 2) == 0) {
                                        $objPHPExcel->getActiveSheet()
                                                ->setCellValueByColumnAndRow(6, $row, $requirement[$i]["requirement"]["production"][$j]["deliinst"][$k]["supply"])
                                                ->setCellValueByColumnAndRow(7, $row, $requirement[$i]["requirement"]["production"][$j]["deliinst"][$k]["instal"]);
                                    } else {
                                        $objPHPExcel->getActiveSheet()
                                                ->setCellValueByColumnAndRow(8, $row, $requirement[$i]["requirement"]["production"][$j]["deliinst"][$k]["supply"])
                                                ->setCellValueByColumnAndRow(9, $row, $requirement[$i]["requirement"]["production"][$j]["deliinst"][$k]["instal"]);
                                    }
                                    $objPHPExcel->getActiveSheet()->getStyle('F' . ($row))->applyFromArray($styleArray2);
                                    $objPHPExcel->getActiveSheet()->getStyle('G' . ($row))->applyFromArray($styleArray2);
                                    $objPHPExcel->getActiveSheet()->getStyle('H' . ($row))->applyFromArray($styleArray2);
                                    $objPHPExcel->getActiveSheet()->getStyle('I' . ($row))->applyFromArray($styleArray2);
                                    $objPHPExcel->getActiveSheet()->getStyle('J' . ($row))->applyFromArray($styleArray2);
                                }
                                $objPHPExcel->getActiveSheet()
                                        ->getStyle('B' . ($row) . ':J' . ($row))
                                        ->getAlignment()
                                        ->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                                        ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                $objPHPExcel->getActiveSheet()
                                        ->mergeCells('C' . $row . ':D' . $row);

                                $row+=1;
                                $si_no+=1;
                            }
                            // $objPHPExcel->getActiveSheet()->getStyle('C20:C'.($row-1))->getAlignment()->setWrapText(true);
                            // $objPHPExcel->getActiveSheet()->getStyle('C20:C'.($row-1))->getAlignment()->setIndent(5);
                            /* Calculations */
                            /* Total supply and installation */
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(8, $row, $this->parameters["totsup"])
                                    ->setCellValueByColumnAndRow(9, $row, $this->parameters["totins"]);
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $row . ':J' . ($row))->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('I' . ($row))->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . ($row))->applyFromArray($styleArray1);
                            $row+=1;
                            /* VAT ON supply  */
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $row . ':J' . ($row))->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('I' . ($row))->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(8, $row, $this->parameters["vat"]);
                            $objPHPExcel->getActiveSheet()
                                    ->mergeCells('E' . $row . ':H' . $row);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(4, $row, 'Vat @ 14.5% on supply');
                            $row+=1;
                            /* STC ON Installation  */
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $row . ':J' . ($row))->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . ($row))->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(9, $row, $this->parameters["stc2"]);
                            $objPHPExcel->getActiveSheet()
                                    ->mergeCells('E' . $row . ':H' . $row);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(4, $row, 'STC @ 12.36%');
                            $row+=1;
                            /* STC E.CESS ON Installation  */
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $row . ':J' . ($row))->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . ($row))->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(9, $row, $this->parameters["ecess2"]);
                            $objPHPExcel->getActiveSheet()
                                    ->mergeCells('E' . $row . ':H' . $row);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(4, $row, 'E.Cess 50% on 2%');
                            $row+=1;
                            /* STC H.E.CESS ON Installation  */
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $row . ':J' . ($row))->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . ($row))->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(9, $row, $this->parameters["hecess2"]);
                            $objPHPExcel->getActiveSheet()
                                    ->mergeCells('E' . $row . ':H' . $row);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(4, $row, 'H E.Cess 50% on 1%');
                            $row+=1;
                            /* Gross Total ON Supply and installation  */
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $row . ':J' . ($row))->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('I' . ($row))->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . ($row))->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(8, $row, $this->parameters["nsuptot"])
                                    ->setCellValueByColumnAndRow(9, $row, $this->parameters["ninstot"]);
                            $objPHPExcel->getActiveSheet()
                                    ->mergeCells('E' . $row . ':H' . $row);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(4, $row, 'Total');
                            $row+=1;
                        }
                        /* Painting */
                        if (is_array($requirement[$i]["requirement"]["painting"]) && sizeof($requirement[$i]["requirement"]["painting"]) > -1) {
                            $row+=4;
                            $si_no = 1;
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(1, $row, 'Sl No:')
                                    ->setCellValueByColumnAndRow(2, $row, 'Block')
                                    ->setCellValueByColumnAndRow(3, $row, 'Floor')
                                    ->setCellValueByColumnAndRow(4, $row, 'Location')
                                    ->setCellValueByColumnAndRow(5, $row, 'Measurement in sq. ft.')
                                    ->setCellValueByColumnAndRow(5, $row + 1, 'Length')
                                    ->setCellValueByColumnAndRow(6, $row + 1, 'Breadth')
                                    ->setCellValueByColumnAndRow(7, $row + 1, 'Area')
                                    ->setCellValueByColumnAndRow(8, $row + 1, 'Rate')
                                    ->setCellValueByColumnAndRow(9, $row + 1, 'Total Amount');
                            /* colour the borders */
                            $objPHPExcel->getActiveSheet()->getStyle('B' . $row)->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('C' . $row)->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('D' . $row)->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $row)->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('F' . ($row) . ':J' . ($row))->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('F' . ($row + 1))->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('G' . ($row + 1))->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('H' . ($row + 1))->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('I' . ($row + 1))->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . ($row + 1))->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('B' . ($row + 1) . ':E' . ($row + 1))->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('B' . $row . ':J' . ($row + 1))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                            $objPHPExcel->getActiveSheet()->getStyle('B' . $row . ':J' . ($row + 1))->getFill()->getStartColor()->setARGB('FF99AD88');
                            $objPHPExcel->getActiveSheet()
                                    ->getStyle('B' . $row . ':J' . $row + 2)
                                    ->getAlignment()
                                    ->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(13);
                            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(13);
                            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(8);
                            ;
                            $row+=2;
                            for ($j = 0; $j < sizeof($requirement[$i]["requirement"]["painting"]); $j++) {
                                /* Block */
                                $objPHPExcel->getActiveSheet()
                                        ->setCellValueByColumnAndRow(2, $row, $requirement[$i]["requirement"]["painting"][$j]["name"]);
                                /* Floor */
                                for ($k = 0; $k < sizeof($requirement[$i]["requirement"]["painting"][$j]["floor"]); $k++) {
                                    $objPHPExcel->getActiveSheet()
                                            ->setCellValueByColumnAndRow(3, $row, $requirement[$i]["requirement"]["painting"][$j]["floor"][$k]["name"]);
                                    /* Location */
                                    for ($l = 0; $l < sizeof($requirement[$i]["requirement"]["painting"][$j]["floor"][$k]["location"]); $l++) {
                                        $newarr = explode(" ", str_replace($this->order, $this->replace, $requirement[$i]["requirement"]["painting"][$j]["floor"][$k]["location"][$l]["loc"]));
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
                                                ->setCellValueByColumnAndRow(1, $row, $si_no)
                                                ->setCellValueByColumnAndRow(4, $row, $requirement[$i]["requirement"]["painting"][$j]["floor"][$k]["location"][$l]["loc"])
                                                ->setCellValueByColumnAndRow(5, $row, $requirement[$i]["requirement"]["painting"][$j]["floor"][$k]["location"][$l]["length"])
                                                ->setCellValueByColumnAndRow(6, $row, $requirement[$i]["requirement"]["painting"][$j]["floor"][$k]["location"][$l]["breadth"])
                                                ->setCellValueByColumnAndRow(7, $row, $requirement[$i]["requirement"]["painting"][$j]["floor"][$k]["location"][$l]["area"])
                                                ->setCellValueByColumnAndRow(8, $row, $requirement[$i]["requirement"]["painting"][$j]["floor"][$k]["location"][$l]["rate"])
                                                ->setCellValueByColumnAndRow(9, $row, $requirement[$i]["requirement"]["painting"][$j]["floor"][$k]["location"][$l]["total"]);
                                        $objPHPExcel->getActiveSheet()->getStyle('E' . $row)->getAlignment()->setWrapText(true);
                                        $objPHPExcel->getActiveSheet()->getStyle('B' . ($row))->applyFromArray($styleArray2);
                                        $objPHPExcel->getActiveSheet()->getStyle('C' . ($row))->applyFromArray($styleArray2);
                                        $objPHPExcel->getActiveSheet()->getStyle('D' . ($row))->applyFromArray($styleArray2);
                                        $objPHPExcel->getActiveSheet()->getStyle('E' . ($row))->applyFromArray($styleArray2);
                                        $objPHPExcel->getActiveSheet()->getStyle('F' . ($row))->applyFromArray($styleArray2);
                                        $objPHPExcel->getActiveSheet()->getStyle('G' . ($row))->applyFromArray($styleArray2);
                                        $objPHPExcel->getActiveSheet()->getStyle('H' . ($row))->applyFromArray($styleArray2);
                                        $objPHPExcel->getActiveSheet()->getStyle('I' . ($row))->applyFromArray($styleArray2);
                                        $objPHPExcel->getActiveSheet()->getStyle('J' . ($row))->applyFromArray($styleArray2);
                                        $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(-1);
                                        $objPHPExcel->getActiveSheet()
                                                ->getStyle('B' . ($row) . ':J' . ($row))
                                                ->getAlignment()
                                                ->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                                                ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                                        $row+=1;
                                        $si_no+=1;
                                    }
                                }
                            }
                            /* Calculations */
                            /* Total Painting */
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $row . ':J' . ($row))->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . ($row))->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(9, $row, $this->parameters["ptotal"]);
                            $row+=1;
                            /* STC ON Painting  */
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $row . ':J' . ($row))->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . ($row))->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(9, $row, $this->parameters["stc1"]);
                            $objPHPExcel->getActiveSheet()
                                    ->mergeCells('E' . $row . ':H' . $row);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(4, $row, 'STC @ 12.36%');
                            $row+=1;
                            /* STC E.CESS ON Painting  */
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $row . ':J' . ($row))->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . ($row))->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(9, $row, $this->parameters["ecess1"]);
                            $objPHPExcel->getActiveSheet()
                                    ->mergeCells('E' . $row . ':I' . $row);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(4, $row, 'E.Cess 50% on 2%');
                            $row+=1;
                            /* STC H.E.CESS ON Painting  */
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $row . ':J' . ($row))->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . ($row))->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(9, $row, $this->parameters["hecess1"]);
                            $objPHPExcel->getActiveSheet()
                                    ->mergeCells('E' . $row . ':I' . $row);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(4, $row, 'H E.Cess 50% on 1%');
                            $row+=1;
                            /* Gross Total ON Painting  */
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $row . ':J' . ($row))->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . ($row))->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(9, $row, $this->parameters["nptot"]);
                            $objPHPExcel->getActiveSheet()
                                    ->mergeCells('E' . $row . ':I' . $row);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(4, $row, 'Net Painting Total');
                            $row+=1;
                            /* Net Total Supply and installation  */
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $row . ':J' . ($row))->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . ($row))->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(9, $row, ($this->parameters["nsuptot"] + $this->parameters["ninstot"]));
                            $objPHPExcel->getActiveSheet()
                                    ->mergeCells('E' . $row . ':I' . $row);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(4, $row, 'Net Total Supply and installation');
                            $row+=1;
                            /* GRAND TOTAL */
                            $objPHPExcel->getActiveSheet()->getStyle('E' . $row . ':J' . ($row))->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()->getStyle('J' . ($row))->applyFromArray($styleArray1);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(9, $row, $this->parameters["qgtot"]);
                            $objPHPExcel->getActiveSheet()
                                    ->mergeCells('E' . $row . ':I' . $row)
                                    ->mergeCells('B' . ($row + 2) . ':J' . ($row + 3));
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(4, $row, 'Grand Total')
                                    ->setCellValueByColumnAndRow(1, $row + 2, 'Total Amount in words:' . $numtowords);
                            $objPHPExcel->getActiveSheet()->getStyle('B' . ($row + 2) . ':D' . ($row + 2))->applyFromArray($styleArray2);
                            $row+=4;
                            /* Note */
                            $objPHPExcel->getActiveSheet()
                                    ->mergeCells('B' . $row . ':J' . $row);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(1, $row, 'Note :As per the Amendment, S.T. 50% borne by Service Provider & 50% should be borne by Service Recepient');
                            $row += 2;
                            /* Transport Details */
                            $objPHPExcel->getActiveSheet()->getStyle('B' . ($row) . ':D' . ($row + 3))->applyFromArray($styleArray2);
                            $objPHPExcel->getActiveSheet()
                                    ->mergeCells('B' . $row . ':D' . ($row));
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(1, $row, 'Place:' . $this->parameters["dlepla"]);
                            $objPHPExcel->getActiveSheet()
                                    ->mergeCells('F' . $row . ':J' . ($row + 3));
                            $objPHPExcel->getActiveSheet()->getStyle('F' . $row . ':J' . ($row + 3))->applyFromArray($styleArray2);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(5, $row, CERT_FOOT);
                            $row+=1;
                            $objPHPExcel->getActiveSheet()
                                    ->mergeCells('B' . $row . ':D' . ($row));
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(1, $row, 'Lr_no :' . $this->parameters["lrno"]);
                            $row+=1;
                            $objPHPExcel->getActiveSheet()
                                    ->mergeCells('B' . $row . ':D' . ($row));
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(1, $row, 'Vehicle_no :' . $this->parameters["vhno"]);
                            $row+=1;
                            $objPHPExcel->getActiveSheet()
                                    ->mergeCells('B' . $row . ':D' . ($row));
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(1, $row, 'Transporter :' . $this->parameters["motid"]);
                            $row += 2;
                            /* Bank Details */
                            $objPHPExcel->getActiveSheet()->getStyle('B' . $row . ':E' . ($row + 3))->applyFromArray($styleArray2);
                            $objPHPExcel->getActiveSheet()
                                    ->mergeCells('B' . $row . ':E' . ($row + 3))
                                    ->mergeCells('H' . ($row + 1) . ':J' . ($row + 2))
                                    ->mergeCells('H' . ($row) . ':J' . ($row))
                                    ->mergeCells('H' . ($row + 3) . ':J' . ($row + 3));
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(1, $row, BANK_FOOT);
                            $objPHPExcel->getActiveSheet()->getStyle('H' . $row . ':J' . ($row + 3))->applyFromArray($styleArray2);
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(7, $row, 'For Integra Office Solutions.')
                                    ->setCellValueByColumnAndRow(7, $row + 3, 'Authorized Signatory.');
                            $row += 6;
                            /* Footer */
                            $objPHPExcel->getActiveSheet()->getStyle('B' . $row . ':E' . ($row + 7))->applyFromArray($styleArray2);
                            $objPHPExcel->getActiveSheet()
                                    ->mergeCells('B' . ($row) . ':E' . ($row + 7));
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(1, $row, QUOT_FOOT);
                            $objPHPExcel->getActiveSheet()
                                    ->getStyle('B' . ($row) . ':E' . ($row + 7))
                                    ->getAlignment()
                                    ->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                            $row += 12;
                            $objPHPExcel->getActiveSheet()
                                    ->mergeCells('B' . ($row) . ':E' . ($row + 2));
                            $objPHPExcel->getActiveSheet()
                                    ->setCellValueByColumnAndRow(1, $row, "Yours truly,\r\n" . $_SESSION["IOS"]["name"]);
                            $objPHPExcel->getActiveSheet()
                                    ->getStyle('B' . ($row) . ':E' . ($row + 2))
                                    ->getAlignment()
                                    ->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                        }
                        break;
                    }
                }
                $dirparameters = array(
                    "directory" => NULL,
                    "filename" => $this->parameters["ref_no"] . '_Invoice_' . date('j-M-Y') . '-' . md5(microtime(true)) . '.xlsx',
                    "filedirectory" => NULL,
                    "urlpath" => NULL,
                    "url" => NULL
                );
                returnDirectoryDoc($dirparameters, $parameters);
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                $objWriter->save($dirparameters["filedirectory"]);
                unset($objWriter);
                unset($objPHPExcel);
                /* documents */
                $query = 'INSERT INTO  `documents` (`id`,
							`file_name`,
							`type_id`,
							`doc_loc`,
							`mime_type`,
							`doc_type`,
							`dou`,
							`status_id`)  VALUES(
						NULL,
						\'' . $dirparameters["filename"] . '\',
						\'' . mysql_real_escape_string($this->parameters["quot_id"]) . '\',
						\'' . $dirparameters["url"] . '\',
						\'application/vnd.ms-excel\',
						\'invoice\',
						default,
						default);';
                executeQuery($query);
                $flag = true;
            }
        }
        if ($flag)
            executeQuery("COMMIT");
    }

    public function ListDocs() {
        $lstdocs = array();
        $res = executeQuery($this->query_lstdocs);
        $num = mysql_num_rows($res);
        if ($num > 0) {
            $i = 0;
            while ($row = mysql_fetch_assoc($res)) {
                $lstdocs[$i]["id"] = $row["id"];
                $lstdocs[$i]["file_name"] = $row["file_name"];
                $lstdocs[$i]["type_id"] = $row["type_id"];
                $lstdocs[$i]["doc_loc"] = $row["doc_loc"];
                $lstdocs[$i]["mime_type"] = $row["mime_type"];
                $lstdocs[$i]["doc_type"] = $row["doc_type"];
                $lstdocs[$i]["dou"] = date('j-M-Y', strtotime($row["dou"]));
                $i++;
            }
            $_SESSION["listDocs"] = $lstdocs;
        } else {
            $_SESSION["listDocs"] = NULL;
        }
        $tot = sizeof($lstdocs);
        if ($tot > 0) {
            for ($i = 0; $i < $tot; $i++) {
                $jsonptype[] = array(
                    "html" => '<tr><td>' . ($i + 1) . '</td><td>' . $lstdocs[$i]["file_name"] . '</td><td>' . $lstdocs[$i]["dou"] . '</td><td><button type="button" class="btn btn-primary" ' . $lstdocs[$i]["doc_loc"] . '>Open</button></td></tr>',
                    "ind" => $i
                );
            }
        } else {
            $jsonptype = array(
                "html" => '<tr><td colspan="4">0 ' . $this->parameters["what"] . ' available.</td></tr>',
                "ind" => 0
            );
        }
        return $jsonptype;
        /*
          if($_SESSION["project"] != NULL){
          $project = $_SESSION["project"];
          for($i=0;$i<sizeof($project);$i++){
          if($this->parameters["ind"] == $i &&
          $project[$i]["proj_manage"]["req_id"] == $this->parameters["requi_id"] &&
          $project[$i]["proj_manage"]["quot_id"] == $this->parameters["quot_id"]
          ){
          // Project management
          if(isset($project[$i]["proj_manage"]["id"]) && !empty($project[$i]["proj_manage"]["id"]) && $project[$i]["proj_manage"]["id"] != NULL){
          // $project[$i]["proj_manage"]["id"]
          // $project[$i]["proj_manage"]["req_id"]
          // $project[$i]["proj_manage"]["quot_id"]
          // $project[$i]["proj_manage"]["po_id"]
          // $project[$i]["proj_manage"]["client_id"]
          // $project[$i]["proj_manage"]["inv_id"]
          // $project[$i]["proj_manage"]["ref_no"]
          }
          // Requirement
          if(isset($project[$i]["requirement"]["id"]) && !empty($project[$i]["requirement"]["id"]) && $project[$i]["requirement"]["id"] != NULL){
          // $project[$i]["requirement"]["id"]
          // $project[$i]["requirement"]["ethno_id"]
          // $project[$i]["requirement"]["ethno_name"]
          // $project[$i]["requirement"]["rep_id"]
          // $project[$i]["requirement"]["rep_name"]
          // $project[$i]["requirement"]["doethno"]
          // $project[$i]["requirement"]["ptotal"]
          // $project[$i]["requirement"]["totsup"]
          // $project[$i]["requirement"]["totinst"]
          // Production / Manufacturing
          if(is_array($project[$i]["requirement"]["production"]) && sizeof($project[$i]["requirement"]["production"]) > 0){
          for($j=0;$j<sizeof($pdescp_id);$j++){
          // $project[$i]["requirement"]["production"][$j]["id"]
          // $project[$i]["requirement"]["production"][$j]["part"]
          // $project[$i]["requirement"]["production"][$j]["qty"]
          // $project[$i]["requirement"]["production"][$j]["unit"]
          if(is_array($project[$i]["requirement"]["production"][$j]["deliinst"]) && sizeof($project[$i]["requirement"]["production"][$j]["deliinst"]) > 0){
          for($k=0;$k<sizeof($pdescpd_id);$k++){
          // $project[$i]["requirement"]["production"][$j]["deliinst"][$k]["id"]
          // $project[$i]["requirement"]["production"][$j]["deliinst"][$k]["supply"]
          // $project[$i]["requirement"]["production"][$j]["deliinst"][$k]["instal"]
          }
          }
          }
          }
          // Painting
          if(is_array($project[$i]["requirement"]["painting"]) && sizeof($project[$i]["requirement"]["painting"]) > 0){
          for($j=0;$j<sizeof($project[$i]["requirement"]["painting"]);$j++){
          // $project[$i]["requirement"]["painting"][$j]["id"]
          // $project[$i]["requirement"]["painting"][$j]["name"]
          if(is_array($project[$i]["requirement"]["painting"][$j]["floor"]) && sizeof($project[$i]["requirement"]["painting"][$j]["floor"]) > 0){
          for($k=0;$k<sizeof($project[$i]["requirement"]["painting"][$j]["floor"]);$k++){
          // $project[$i]["requirement"]["painting"][$j]["floor"][$k]
          // $project[$i]["requirement"]["painting"][$j]["floor"][$k]["id"]
          // $project[$i]["requirement"]["painting"][$j]["floor"][$k]["name"]
          if(is_array($project[$i]["requirement"]["painting"][$j]["floor"][$k]["location"]) && sizeof($project[$i]["requirement"]["painting"][$j]["floor"][$k]["location"]) > 0){
          for($l=0;$l<sizeof($project[$i]["requirement"]["painting"][$j]["floor"][$k]["location"]);$l++){
          // $project[$i]["requirement"]["painting"][$j]["floor"][$k]["location"][$l]["id"]
          // $project[$i]["requirement"]["painting"][$j]["floor"][$k]["location"][$l]["loc"]
          // $project[$i]["requirement"]["painting"][$j]["floor"][$k]["location"][$l]["length"]
          // $project[$i]["requirement"]["painting"][$j]["floor"][$k]["location"][$l]["breadth"]
          // $project[$i]["requirement"]["painting"][$j]["floor"][$k]["location"][$l]["area"]
          // $project[$i]["requirement"]["painting"][$j]["floor"][$k]["location"][$l]["rate"]
          // $project[$i]["requirement"]["painting"][$j]["floor"][$k]["location"][$l]["total"]
          }
          }
          }
          }
          }
          }
          // SRS
          // $project[$i]["requirement"]["SRS"]["doc_id"]
          // $project[$i]["requirement"]["SRS"]["fn"]
          // $project[$i]["requirement"]["SRS"]["type_id"]
          // $project[$i]["requirement"]["SRS"]["doc"]
          // $project[$i]["requirement"]["SRS"]["mmtype"]
          // $project[$i]["requirement"]["SRS"]["doc_type"]
          // $project[$i]["requirement"]["SRS"]["dou"]
          }
          // Quotation
          if(isset($project[$i]["quotation"]["id"]) !empty($project[$i]["quotation"]["id"]) && $project[$i]["quotation"]["id"] != NULL){
          // $project[$i]["quotation"]["id"]
          // $project[$i]["quotation"]["addresse"]
          // $project[$i]["quotation"]["subject"]
          // $project[$i]["quotation"]["descp"]
          // $project[$i]["quotation"]["qptotal"]
          // $project[$i]["quotation"]["qtotins"]
          // $project[$i]["quotation"]["qtotsup"]
          // $project[$i]["quotation"]["qvat"]
          // $project[$i]["quotation"]["qstc1"]
          // $project[$i]["quotation"]["qecess1"]
          // $project[$i]["quotation"]["qhecess1"]
          // $project[$i]["quotation"]["qstc2"]
          // $project[$i]["quotation"]["qecess2"]
          // $project[$i]["quotation"]["qhecess2"]
          // $project[$i]["quotation"]["ntotal"]
          if(is_array($project[$i]["quotation"]["QUOT"]) && sizeof($project[$i]["quotation"]["QUOT"]) > 0){
          for($j=0;$j<sizeof($project[$i]["quotation"]["QUOT"]);$j++){
          // $project[$i]["quotation"]["QUOT"][$j]["doc_id"]
          // $project[$i]["quotation"]["QUOT"][$j]["fn"]
          // $project[$i]["quotation"]["QUOT"][$j]["type_id"]
          // $project[$i]["quotation"]["QUOT"][$j]["doc"]
          // $project[$i]["quotation"]["QUOT"][$j]["mmtype"]
          // $project[$i]["quotation"]["QUOT"][$j]["doc_type"]
          // $project[$i]["quotation"]["QUOT"][$j]["dou"]
          }
          }
          }
          // Client purchase Order
          if(isset($project[$i]["PO"]["id"]) && !empty($project[$i]["PO"]["id"]) && $project[$i]["PO"]["id"] != NULL){
          // $project[$i]["PO"]["id"]
          // $project[$i]["PO"]["ref_no"]
          // $project[$i]["PO"]["date"]
          if(is_array($project[$i]["PO"]["CPO"]) && sizeof($project[$i]["PO"]["CPO"])){
          for($j=0;$j<sizeof($project[$i]["PO"]["CPO"]);$j++){
          // $project[$i]["PO"]["CPO"][$j]["doc_id"]
          // $project[$i]["PO"]["CPO"][$j]["fn"]
          // $project[$i]["PO"]["CPO"][$j]["type_id"]
          // $project[$i]["PO"]["CPO"][$j]["doc"]
          // $project[$i]["PO"]["CPO"][$j]["mmtype"]
          // $project[$i]["PO"]["CPO"][$j]["doc_type"]
          // $project[$i]["PO"]["CPO"][$j]["dou"]
          }
          }
          }
          // Project
          if(isset($project[$i]["project"]["id"]) && !empty($project[$i]["project"]["id"]) && $project[$i]["project"]["id"] != NULL){
          // $project[$i]["project"]["id"]
          // $project[$i]["project"]["name"]
          // $project[$i]["project"]["md"]
          // $project[$i]["project"]["eng"]
          // $project[$i]["project"]["mng"]
          // $project[$i]["project"]["hld"]
          // $project[$i]["project"]["psd"]
          // $project[$i]["project"]["pcd"]
          // $project[$i]["project"]["discussed"]
          // $project[$i]["project"]["progress"]
          // $project[$i]["project"]["timeline"]
          // Project Description
          if(is_array($project[$i]["project"]["descp"]) && sizeof($project[$i]["project"]["descp"]) > 0){
          for($j=0;$j<sizeof($project[$i]["project"]["descp"]);$j++){
          // $project[$i]["project"]["descp"][$j]["id"]
          // $project[$i]["project"]["descp"][$j]["task"]
          // $project[$i]["project"]["descp"][$j]["production"]
          // $project[$i]["project"]["descp"][$j]["status"]
          // $project[$i]["project"]["descp"][$j]["feedback"]
          // $project[$i]["project"]["descp"][$j]["obstacles"]
          // PCC
          if(is_array($project[$i]["project"]["descp"][$j]["pcc"]) && sizeof($project[$i]["project"]["descp"][$j]["pcc"]) > 0){
          for($k=0;$k<sizeof($project[$i]["project"]["descp"][$j]["pcc"]);$k++){
          // PCC_task
          // $project[$i]["project"]["descp"][$j]["pcc"][$k]["id"]
          // $project[$i]["project"]["descp"][$j]["pcc"][$k]["name"]
          // $project[$i]["project"]["descp"][$j]["pcc"][$k]["city"]
          // $project[$i]["project"]["descp"][$j]["pcc"][$k]["rev"]
          // $project[$i]["project"]["descp"][$j]["pcc"][$k]["sdwood"]
          // $project[$i]["project"]["descp"][$j]["pcc"][$k]["sdmetal"]
          // $project[$i]["project"]["descp"][$j]["pcc"][$k]["edproject"]
          // $project[$i]["project"]["descp"][$j]["pcc"][$k]["frameconfig"]
          // $project[$i]["project"]["descp"][$j]["pcc"][$k]["wrkstnhet"]
          // $project[$i]["project"]["descp"][$j]["pcc"][$k]["totwrkstn"]
          if(is_array($project[$i]["project"]["descp"][$j]["pcc"][$k]["task"]) && sizeof($project[$i]["project"]["descp"][$j]["pcc"][$k]["task"]) > 0){
          // PCC_task_descp
          for($l=0;$l<sizeof($project[$i]["project"]["descp"][$j]["pcc"][$k]["task"]);$l++){
          // $project[$i]["project"]["descp"][$j]["pcc"][$k]["task"][$l]["id"]
          // $project[$i]["project"]["descp"][$j]["pcc"][$k]["task"][$l]["descp"]
          // $project[$i]["project"]["descp"][$j]["pcc"][$k]["task"][$l]["size"]
          // $project[$i]["project"]["descp"][$j]["pcc"][$k]["task"][$l]["color"]
          // $project[$i]["project"]["descp"][$j]["pcc"][$k]["task"][$l]["qty"]
          // $project[$i]["project"]["descp"][$j]["pcc"][$k]["task"][$l]["remark"]
          }
          }
          }
          }
          //  PCC chart
          if(is_array($project[$i]["project"]["descp"][$j]["PCCCHART"]) && sizeof($project[$i]["project"]["descp"][$j]["PCCCHART"]) > 0){
          for($k=0;$k<sizeof($project[$i]["project"]["descp"][$j]["PCCCHART"]);$k++){
          // $project[$i]["project"]["descp"][$j]["PCCCHART"]["doc_id"]
          // $project[$i]["project"]["descp"][$j]["PCCCHART"]["fn"]
          // $project[$i]["project"]["descp"][$j]["PCCCHART"]["type_id"]
          // $project[$i]["project"]["descp"][$j]["PCCCHART"]["doc"]
          // $project[$i]["project"]["descp"][$j]["PCCCHART"]["mmtype"]
          // $project[$i]["project"]["descp"][$j]["PCCCHART"]["doc_type"]
          // $project[$i]["project"]["descp"][$j]["PCCCHART"]["dou"]
          }
          }
          // Drawing
          if(isset($project[$i]["project"]["id"]) !empty($project[$i]["project"]["id"]) && $project[$i]["project"]["id"] != NULL){
          // $project[$i]["project"]["descp"][$j]["draw"]["id"]
          // $project[$i]["project"]["descp"][$j]["draw"]["dsid"]
          // $project[$i]["project"]["descp"][$j]["draw"]["designer"]
          // $project[$i]["project"]["descp"][$j]["draw"]["name"]
          // $project[$i]["project"]["descp"][$j]["draw"]["dou"]
          // Drawing File
          if(is_array($project[$i]["project"]["descp"][$j]["draw"]["doc"]) && sizeof($project[$i]["project"]["descp"][$j]["draw"]["doc"]) > 0){
          for($k=0;$k<sizeof($project[$i]["project"]["descp"][$j]["draw"]["doc"]);$k++){
          // $project[$i]["project"]["descp"][$j]["draw"]["doc"][$k]["id"]
          // $project[$i]["project"]["descp"][$j]["draw"]["doc"][$k]["fn"]
          // $project[$i]["project"]["descp"][$j]["draw"]["doc"][$k]["type_id"]
          // $project[$i]["project"]["descp"][$j]["draw"]["doc"][$k]["doc"]
          // $project[$i]["project"]["descp"][$j]["draw"]["doc"][$k]["mmtype"]
          // $project[$i]["project"]["descp"][$j]["draw"]["doc"][$k]["doc_type"]
          // $project[$i]["project"]["descp"][$j]["draw"]["doc"][$k]["dou"]
          }
          }
          }
          // Team Members
          if(is_array($project[$i]["project"]["descp"][$j]["members"]) && sizeof($project[$i]["project"]["descp"][$j]["members"]) > 0){
          for($k=0;$k<sizeof($project[$i]["project"]["descp"][$j]["members"]);$k++){
          // $project[$i]["project"]["descp"][$j]["members"][$k]["id"]
          // $project[$i]["project"]["descp"][$j]["members"][$k]["mid"]
          // $project[$i]["project"]["descp"][$j]["members"][$k]["member"]
          // $project[$i]["project"]["descp"][$j]["members"][$k]["status"]
          }
          }
          }
          }
          }
          // Invoice
          if(isset($project[$i]["invoice"]["id"]) !empty($project[$i]["invoice"]["id"]) && $project[$i]["invoice"]["id"] != NULL){
          // $project[$i]["invoice"]["id"]
          // $project[$i]["invoice"]["addresse"]
          // $project[$i]["invoice"]["subject"]
          // $project[$i]["invoice"]["descp"]
          // $project[$i]["invoice"]["iptotal"]
          // $project[$i]["invoice"]["itotsup"]
          // $project[$i]["invoice"]["itotins"]
          // $project[$i]["invoice"]["ivat"]
          // $project[$i]["invoice"]["istc1"]
          // $project[$i]["invoice"]["iecess1"]
          // $project[$i]["invoice"]["ihecess1"]
          // $project[$i]["invoice"]["istc2"]
          // $project[$i]["invoice"]["iecess2"]
          // $project[$i]["invoice"]["ihecess2"]
          // $project[$i]["invoice"]["ntotal"]
          // Invoice Vehicle
          // $project[$i]["invoice"]["driver"];
          // $project[$i]["invoice"]["vehicle_no"];
          // $project[$i]["invoice"]["mot"];
          // $project[$i]["invoice"]["empty_weight"]
          // $project[$i]["invoice"]["loaded_weight"]
          // $project[$i]["invoice"]["total_weight"]
          // $project[$i]["invoice"]["advance_amt"]
          // $project[$i]["invoice"]["rent"]
          // $project[$i]["invoice"]["arrival"]
          // $project[$i]["invoice"]["departure"]
          // Invoice Document
          $project[$i]["invoice"]["doc"] = NULL;
          $invc_doc_id = explode("☻♥☻",$row["invc_doc_id"]);
          if(is_array($project[$i]["invoice"]["doc"]) && sizeof($project[$i]["invoice"]["doc"]) > 0){
          for($k=0;$k<sizeof($project[$i]["invoice"]["doc"]);$k++){
          // $project[$i]["invoice"]["doc"][$k]["id"]
          // $project[$i]["invoice"]["doc"][$k]["fn"]
          // $project[$i]["invoice"]["doc"][$k]["type_id"]
          // $project[$i]["invoice"]["doc"][$k]["doc"]
          // $project[$i]["invoice"]["doc"][$k]["mmtype"]
          // $project[$i]["invoice"]["doc"][$k]["doc_type"]
          // $project[$i]["invoice"]["doc"][$k]["dou"]
          }
          }
          }
          // Client
          if(isset($project[$i]["client"]["id"]) && !empty($project[$i]["client"]["id"]) && $project[$i]["client"]["id"] != NULL){
          // $project[$i]["client"]["id"]
          // $project[$i]["client"]["name"]
          // $project[$i]["client"]["directory"]
          // $project[$i]["client"]["photo"]
          // $project[$i]["client"]["email"]
          // $project[$i]["client"]["cellnumber"]
          // $project[$i]["client"]["pcode"]
          // $project[$i]["client"]["tnumber"]
          // $project[$i]["client"]["addressline"]
          // $project[$i]["client"]["town"]
          // $project[$i]["client"]["city"]
          // $project[$i]["client"]["district"]
          // $project[$i]["client"]["province"]
          // $project[$i]["client"]["country"]
          // $project[$i]["client"]["zipcode"]
          }
          }
          }
         */
        // $lst_doc = array(
        // "display" => isset($_POST["display"]) ? $_POST["display"] : false,
        // "what" => isset($_POST["what"]) ? $_POST["what"] : false
        // );
    }

}

?>
