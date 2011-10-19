<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * Berisi default menu untuk control panel (backend)
 *
 * @package Miras
 * @subpackage Mr
 * @copyright 2011 CV. Astasoft Indonesia <http://www.astasoft.co.id/>
 * @copyright 2011 Rio Astamal <me@rioastamal.net>
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GPLv2
 * @since Version 1.0.3
 */

// cek apakah session untuk admin telah ada
if (mr_session_getdata($_MR['cp_session_name'])) {
		
	// default backend menu
	tpl_add_menu(array(
		'label' => 'Home',
		'id' => 'mr_home',
		'url' => get_backend_url(),
		'title' => 'CPanel Home',
		'order' => 1
	));	
	
	// jalankan hooks yang berhubungan dengan manipulasi menu
	run_hooks('add_more_backend_menu');
	
	// temporer logout link, kemungkinan dimasa datang tidak digunakan
	tpl_add_menu(array(
		'label' => 'Logout',
		'id' => 'mr_logout',
		'url' => get_backend_url() . '/main-backend/action/logout',
		'title' => 'Logout Session',
		'order' => 1
	));	
}
