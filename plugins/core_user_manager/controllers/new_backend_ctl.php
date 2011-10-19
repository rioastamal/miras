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
load_helper('html');
load_helper('string');

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
							'username' => array(
												'label' => 'Username',
												'rules' => 'required|trim|common_username|callback=>new_user_name_check'
							),
							'password' => array(
												'label' => 'Password',
												'rules' => 'required|matches=>password2'
							),
							'password2' => array(
												'label' => 'Retype Password',
												'rules' => 'required'
							),
							'firstname' => array(
												'label' => 'First Name',
												'rules' => 'required|trim|min_length=>3|max_length=>30'
							),
							'lastname' => array(
												'label' => 'Last Name',
												'rules' => 'required|trim|min_length=>3|max_length=>50'
							),
							'email' => array(
											'label' => 'Email',
											'rules' => 'required|trim|valid_email|callback=>new_user_email_check'
							)
			);
			
			$errors = mr_form_validation($elements);
			
			$data->sess->username = $_POST['username'];
			$data->sess->password = $_POST['password'];
			$data->sess->password2 = $_POST['password2'];
			$data->sess->firstname = $_POST['firstname'];
			$data->sess->lastname = $_POST['lastname'];
			$data->sess->email = $_POST['email'];
			
			// role
			$data->sess->user_role = (int)$_POST['user-role'];
			// status
			$data->sess->user_status = (int)$_POST['user-status'];
			
			$salt = mr_random_string(8);
			$password = md5($salt . $data->sess->password);
			
			site_debug($salt . ' + ' . $data->sess->password . ' => ' . $password);
			
			$user_data = array(
				'user_name' => $data->sess->username,
				'user_first_name' => $data->sess->firstname,
				'user_last_name' => $data->sess->lastname,
				'user_pass' => $password,
				'user_salt' => $salt,
				'user_email' => $data->sess->email,
				'user_type_id' => $data->sess->user_role,
				'user_status' => $data->sess->user_status
			);
			
			if ($errors) {
				throw new Exception($errors);
			}
			
			// validasi berhasil terlewati, saatnya insert ke database
			core_insert_user($user_data);
			
			$message = 'User %s has been successfully added.';
			
			set_flash_message( sprintf($message, $data->sess->username) );
		} catch (Exception $e) {
			set_flash_message($e->getMessage());
			set_flash_class('flash-error');
		}
	}
	
	new_user_backend_index($data);
}

function new_user_name_check($param) {
	try {
		core_username_check($param['data']);
	} catch (Exception $e) {
		return $e->getMessage();
	}
}

function new_user_email_check($param) {
	try {
		core_email_check($param['data']);
	} catch (Exception $e) {
		return $e->getMessage();
	}
}

function new_user_backend_index($data=NULL) {
	load_view('backend/header');
	load_view('new_user', $data, 'core_user_manager');
	load_view('backend/sidebar');
	load_view('backend/footer');
}
