<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * Controller untuk menambahkan user baru
 *
 * @package Miras
 * @subpackage Plugins
 * @copyright 2011 CV. Astasoft Indonesia <http://www.astasoft.co.id/>
 * @copyright 2011 Rio Astamal <me@rioastamal.net>
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GPLv2
 */
mr_backend_auth();

set_active_menu('core_user_manager');
set_page_title('User Manager');
load_model('core_user', 'core_user_manager');
load_model('user_type');

$action = get_argument_by('action');

$data = new stdClass();
$data->user = get_user();
$data->site_url = get_site_url();
$data->post_url = $data->site_url . '/core-user-manager/new-backend/action/save';
$data->status_list = get_user_status_list();
$data->user_types = get_user_type();

// load javascript jquery library
mr_add_js('jquery', '1.6.4');

switch ($action) {
	case 'save':
		new_user_backend_save($data);
	break;
	
	case 'index':
	default:
		new_user_backend_index($data);
	break;
}

function new_user_backend_save($data=NULL) {
	// jika bukan POST maka arahkan ke index
	if (isset($_POST['create-user-button'])) {
		try {
			$elements = array(
				'username|Username' => 'required|trim',
				'password|Password' => 'required|matches=>password2',
				'password2|Confirmation Password' => 'required',
				'firstname|First Name' => 'required|trim',
				'lastname|Last Name' => 'required',
				'email|Email' => 'required|trim|valid_email'
			);
			
			load_helper('html');
			$errors = mr_form_validation($elements);
			
			$data->sess->username = $_POST['username'];
			$data->sess->password = $_POST['password'];
			$data->sess->password2 = $_POST['password2'];
			$data->sess->firstname = $_POST['firstname'];
			$data->sess->lastname = $_POST['lastname'];
			$data->sess->email = $_POST['email'];
			
			if ($errors) {
				throw new Exception($errors);
			}
			
			set_flash_message('TEST');
		} catch (Exception $e) {
			set_flash_message($e->getMessage());
			set_flash_class('flash-error');
		}
	}
	
	new_user_backend_index($data);
}

function new_user_backend_index($data=NULL) {
	load_view('backend/header');
	load_view('new_user', $data, 'core_user_manager');
	load_view('backend/sidebar');
	load_view('backend/footer');
}
