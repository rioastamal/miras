<?php

// koment titik ae
/**
 * Internal Function
 */
tpl_add_menu(array(
	'label' => 'Hello Dolly',
	'id' => 'dolly',
	'title' => 'Hello Dolly',
	'order' => 1	
));

add_hook('page_head', 'heldo_head');
add_hook('user_set_role', 'set_dolly_role');

function hello_dolly_on_install() {}
function hello_dolly_on_uninstall() {}
function hello_dolly_on_activate() {}
function hello_dolly_on_deactivate() {}
function hello_dolly_on_upgrade() {}
function hello_dolly_role() {
	return array(
			'ngefuck'	=>	1,
			'petting'	=>	0
	);
}

function heldo_head() {
	echo ("<!-- I'm Hello Dolly ;) -->\n");
}

function set_dolly_role($role) {
	$role_list = hello_dolly_role();
	
	foreach ($role_list as $role_key=>$role_val) {
		/*
		if ($role->is_super_admin) {
			$role->$role_key = 1;
		}
		*/
		if (!isset($role->$role_key)) {
			$role->$role_key = $role_val;
		}
	}
}

$da = NULL;
// TEST LOAD VIEW 
load_view('dolly_test', $da, 'hello_dolly');

// TEST LOAD MODEL

load_model('dolly', 'hello_dolly');

// TEST LOAD LIBRARY
load_library('dolly_test', 'hello_dolly');
