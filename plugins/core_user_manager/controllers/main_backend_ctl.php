<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * Controller untuk menampilkan daftar user
 *
 * @package Miras
 * @subpackage Plugins
 * @copyright 2011 CV. Astasoft Indonesia <http://www.astasoft.co.id/>
 * @copyright 2011 Rio Astamal <me@rioastamal.net>
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GPLv2
 */
mr_backend_auth();
mr_check_privilege('can_view_user_core');

set_active_menu('core_user_manager');
set_page_title('User Manager');
load_model('user_type');
load_model('core_user', 'core_user_manager');

$action = get_argument_by('action');

$data = new stdClass();
$data->user = get_user();
$data->site_url = get_site_url();
$data->plugin_url = $data->site_url . '/core-user-manager/new-backend';
$data->action_url = $data->site_url . '/core-user-manager/main-backend/action/bulk';
$data->status_list = get_user_status_list();
$data->role_list = get_user_type();

$data->bulk_action_list = array();

$bulk_list = new stdClass();
$bulk_list->id = '';
$bulk_list->name = '-- Change Status --';
$data->bulk_action_list[] = $bulk_list;

foreach ($data->status_list as $code => $status) {
	$bulk_list = new stdClass();
	$bulk_list->id = 'status-' . $status;
	$bulk_list->name = ucwords($status);
	$data->bulk_action_list[] = $bulk_list;
}

$bulk_list = new stdClass();
$bulk_list->id = '';
$bulk_list->name = '-- Change Role --';
$data->bulk_action_list[] = $bulk_list;

foreach ($data->role_list as $role) {
	$bulk_list = new stdClass();
	$bulk_list->id = 'role-' . $role->user_type_id;
	$bulk_list->name = ucwords($role->user_type_name);
	$data->bulk_action_list[] = $bulk_list;
}

mr_add_js('jquery', '1.6.4');

switch ($action) {
	case 'bulk':	
		if (isset($_POST['user_id'])) {
			// super admin dan guest hilangkan dari daftar user
			// karena seharusnya kedua user tersebut hanya perlu diedit secara
			// individual bukan secara bersamaan (bulk)
			$specials = array($_MR['super_admin_id'], $_MR['guest_user_id']);
			$target_user = array_diff($_POST['user_id'], $specials);
		
			$action = '';
			
			// --- UPDATE STATUS ---
			$bulk_action = $_POST['bulk-action'];
			if (preg_match('/^status\-([a-zA-Z_]+[a-zA-Z_0-9]*)+$/', $bulk_action, $matches)) {
				// user status berdasarkan nama
				$status_name = strtolower($matches[1]);
				
				$set_data = array(
								// ubah dari name ke id status integer
								'user_status' => get_user_status_number($status_name)
				);
				
				main_backend_update($target_user, $set_data);
			}
			
			// --- UPDATE ROLE ---
			if (preg_match('/^role\-([0-9])+$/', $bulk_action, $matches)) {
				$role_id = (int)$matches[1];
				
				$set_data = array(
									'user_type_id' => $role_id
				);
				
				main_backend_update($target_user, $set_data);
			}
		} else {
			set_flash_message('No user selected.');
		}
		main_backend_index($data);
	break;
	
	case 'index':
	default:
		main_backend_index($data);
	break;
}

function main_backend_update($users, $set_data) {
	$errors = array();
	
	foreach ($users as $user) {
		$where = array(
					'user_id' => array(
										'value' => $user,
										'op' => '='
					),
		);
		
		try {
			core_user_update($set_data, $where);
		} catch (Exception $e) {
			$errors[] = '<li>' . $e->getMessage() . '</li>';
		}
	}
	
	if ($errors) {
		$message = '<ul>' . implode("\n", $errors) . '</ul>';
		$message = "There's some errors while updating. {$message}";
		set_flash_class('flash-error');
		set_flash_message($message);
	} else {
		set_flash_message('Users has been successfully updated.');
	}
}

function main_backend_index($data=NULL) {
	$users = get_user_by();
	$data->users = $users;
		
	load_view('backend/header');
	load_view('main', $data, 'core_user_manager');
	load_view('backend/sidebar');
	load_view('backend/footer');
}
