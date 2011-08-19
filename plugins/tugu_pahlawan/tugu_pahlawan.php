<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * File mendemonstrasikan bagaimana membuat dan menggunakan sebuah plugin.
 *
 * @package Miras
 * @subpackage Plugins
 * @copyright 2011 CV. Astasoft Indonesia <http://www.astasoft.co.id/>
 * @copyright 2011 Rio Astamal <me@rioastamal.net>
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GPLv2
 */
 
tpl_add_menu(array(
	'label' => 'Tugu Pahlawan',
	'id' => 'tugu_pahlawan',
	'title' => 'Sejarah Tugu Pahlawan',
	'url' => get_site_url() . '/tugu-pahlawan',
	'order' => 1	
));

add_hook('sidebar_view', 'tugu_pahlawan_sidebar');

function tugu_pahlawan_on_install() {}
function tugu_pahlawan_on_uninstall() {}
function tugu_pahlawan_on_activate() {}
function tugu_pahlawan_on_deactivate() {}
function tugu_pahlawan_on_upgrade() {}

function tugu_pahlawan_sidebar() {
	$data = NULL;
	$data->nama_user = get_user()->user_first_name;
	$data->nama_role = get_user()->role->rolename;
	load_view('sidebar', $data, 'tugu_pahlawan');
}

function tugu_pahlawan_role() {
	// default privilege untuk plugin tugu pahlawan
	// (ROLE INI TIDAK DIGUNAKAN NAMUN HANYA SEBAGAI CONTOH)
	return array(
		'can_declare_independence'	=> 1,
		'can_make_war'				=> 0,
		'can_make_peace'			=> 1
	);
}
