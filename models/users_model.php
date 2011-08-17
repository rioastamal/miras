<?php
/**
 * File ini berisi fungsi-fungsi yang tabel users
 * 
 * @package libraries
 * @copyright 2011 Bajol Startup Team
 */

function get_user_by_id($uid) {
	global $_MR;
	
	$db_user = DB_PREFIX . 'users u';
	$db_user_type = DB_PREFIX . 'user_type ut';
	$uid = $_MR['db']->real_escape_string($uid);
	$query = "SELECT u.*, ut.user_type_name FROM {$db_user} 
			  LEFT JOIN {$db_user_type} ON ut.user_type_id=u.user_type_id
			  WHERE u.user_id=$uid LIMIT 1";
	$result = mr_query($query);
	$profile = $result[0];
	$role = get_acl_role($uid, 1);
	$profile->role = $role;
	unset($profile->user_salt, $profile->user_pass);
	
	return $profile;
}

function get_acl_role($uid, $user_type_id) {
	global $_MR;
	
	$user_type_id = $_MR['db']->real_escape_string($user_type_id);
	$db_acl = DB_PREFIX . 'acl a';
	$db_user_meta = DB_PREFIX . 'user_meta um';
	$query = "SELECT a.acl_key, a.acl_value 
			FROM {$db_acl}
			WHERE user_type_id=$user_type_id
			UNION
			SELECT SUBSTR(um.user_meta_name, 5), um.user_meta_value 
			FROM {$db_user_meta} WHERE um.user_meta_name LIKE 'acl_%'
			AND um.user_id=$uid";	
	$result = mr_query($query);
	$role = array();
	foreach ($result as $row) {
		$role[$row->acl_key] = $row->acl_value;
	}
	
	return $role;
}
