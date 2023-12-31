CREATE TABLE `mms_user_roles` (
	`id`  int(11) NOT NULL ,
	`user_email_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
	`add_user` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`page_draft` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`page_publish` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`menus` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`file_upload` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`mo_smo_inspection` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`io_inspection` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`allocation_mo_smo` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`allocation_io` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`reallocation` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
	`modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
	`form_verification_home` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`allocation_home` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`ro_inspection` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`set_roles` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`allocation_dy_ama` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`allocation_ho_mo_smo` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`allocation_jt_ama` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`allocation_ama` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`dy_ama` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`ho_mo_smo` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`jt_ama` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`ama` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`masters` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`super_admin` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`renewal_verification` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`renewal_allocation` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`view_reports` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`pao` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`sample_inward` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`sample_forward` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`generate_inward_letter` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`sample_allocated` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`sample_testing_progress` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`sample_result_approval` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`finalized_sample` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`administration` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`verify_sample` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`reports` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`dashboard` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`ho` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`ro` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`so` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`ral` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`cal` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`user_flag` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`out_forward` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`once_update_permission` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`old_appln_data_entry` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`so_inspection` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`smd_inspection` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`feedbacks` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`unlock_user` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`transfer_appl` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`inspection_pp` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`so_grant_pp` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
	`re_esign` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



CREATE TABLE `pages` (
	`id` int(11) NOT NULL,
	`title` varchar(100) NULL DEFAULT NULL,
	`content` text COLLATE utf8_unicode_ci DEFAULT NULL,
	`user_email_id` varchar(200) NULL DEFAULT NULL,
	`status` varchar(50) NULL DEFAULT NULL,
	`archive_date` timestamp NULL DEFAULT NULL,
	`meta_keyword` varchar(200) NULL DEFAULT NULL,
	`meta_description` text COLLATE utf8_unicode_ci DEFAULT NULL,
	`publish_date` timestamp NULL DEFAULT NULL,
	`delete_status` varchar(10) NULL DEFAULT NULL,
	`created` timestamp NULL DEFAULT NULL,
	`modified` timestamp NULL DEFAULT NULL

)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `mms_user_file_uploads` (
	`id`  int(11) NOT NULL,
	`file` varchar(200) NULL DEFAULT NULL,
	`user_email_id` varchar(200) NULL DEFAULT NULL,
	`user_once_no` varchar(200) NULL DEFAULT NULL,
	`file_name` varchar(200) NULL DEFAULT NULL,
	`delete_status` varchar(10) NULL DEFAULT NULL,
	`created` TIMESTAMP NULL DEFAULT NULL,
	`modified` TIMESTAMP NULL DEFAULT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE `menus` (
	`id` int(11) NOT NULL,
	`position` varchar(20)  NULL DEFAULT NULL,
	`parent` varchar(50)  NULL DEFAULT NULL,
	`order_id` bigint(50) NULL DEFAULT NULL,
	`link_id` varchar(200) NULL DEFAULT NULL,
	`link_type` varchar(20)  NULL DEFAULT NULL,
	`external_link` varchar(200)  NULL DEFAULT NULL,
	`title` varchar(100)  NULL DEFAULT NULL,
	`created`  timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
	`modified` timestamp NULL DEFAULT NULL,
	`user_email_id` varchar(200)  NULL DEFAULT NULL,
	`delete_status` varchar(10)  NULL DEFAULT NULL
	
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;