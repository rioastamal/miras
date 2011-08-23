<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * File berisi rutin code meload beberapa file agar dapat digunakan oleh 
 * installer, tidak semua fitur framework diload pada script installer ini.
 *
 * @package Miras
 * @subpackage Installer
 * @copyright 2011 CV. Astasoft Indonesia <http://www.astasoft.co.id/>
 * @copyright 2011 Rio Astamal <me@rioastamal.net>
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GPLv2
 */

include_once(BASE_PATH . '/mr/' . 'version_info.php');

// include compatibility routine
include_once(BASE_PATH . '/mr/' . 'compat.php');

// global variabel
$_MR = array();

// site config
include_once(BASE_PATH . '/mr/' . 'site_config.php');
include_once(BASE_PATH . '/mr/' . 'functions.php');
load_helper('url');

// agar fungsi get_base_url() dapat berjalan sesuai ekspektasi pada
// script install maka kita perlu melakukan 'hacking' pada agar
// nilai $_MR['base_url']

// split direktori install
$_uri = explode('/install', $_SERVER['REQUEST_URI']);

// susun base_url
// base url = part ke 0
$base_url = $_SERVER['HTTP_HOST'] . $_uri[0] . '/';
$base_url = get_current_protocol() . $base_url;
$_MR['base_url'] = $base_url;

load_helper('string');
load_helper('email');
$_mr_auto_libs = array(
					'controller', 
					'plugin',
					'template'
				);
					
// load library yang sifatnya auto-load
$_MR['autoload_libraries'] = $_mr_auto_libs + $_MR['autoload_libraries'];
foreach ($_MR['autoload_libraries'] as $lib) {
	load_library($lib);
}

// load menu
tpl_add_menu(array(
	'label' => 'Step 1',
	'id' => 'step_1',
	'title' => 'Step 1 of 4',
	'order' => 1
));	
tpl_add_menu(array(
	'label' => 'Step 2',
	'id' => 'step_2',
	'title' => 'Step 2 of 4',
	'order' => 1
));	
tpl_add_menu(array(
	'label' => 'Step 3',
	'id' => 'step_3',
	'title' => 'Step 3 of 4',
	'order' => 1
));	
tpl_add_menu(array(
	'label' => 'Step 4',
	'id' => 'step_4',
	'title' => 'Step 4 of 4',
	'order' => 1
));	
tpl_add_menu(array(
	'label' => 'Finish',
	'id' => 'finish',
	'title' => 'Last Step',
	'order' => 1
));	
