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

function hello_dolly_on_install() {}
function hello_dolly_on_uninstall() {}
function hello_dolly_on_activate() {}
function hello_dolly_on_deactivate() {}
function hello_dolly_on_upgrade() {}

function heldo_head() {
	echo ("<!-- I'm Hello Dolly ;) -->\n");
}

$da = NULL;
// TEST LOAD VIEW 
 load_view('dolly_test', $da, 'hello_dolly');

// TEST LOAD MODEL

load_model('dolly', 'hello_dolly');

// TEST LOAD LIBRARY
load_library('dolly_test', 'hello_dolly');
