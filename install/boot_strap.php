<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * File ini berfungsi untuk meloading semua file library atau
 * konfigurasi yang diperlukan
 *
 * @package mr
 * @copyright 2011 CV. Astasoft Indonesia (http://www.astasoft.co.id/)
 */

include_once(BASE_PATH . '/mr/' . 'version_info.php');

// global variabel
$_MR = array();

// site config
include_once(BASE_PATH . '/mr/' . 'site_config.php');
include_once(BASE_PATH . '/mr/' . 'function.php');

load_helper('url');
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
