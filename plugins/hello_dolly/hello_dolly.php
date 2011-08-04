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

function heldo_head() {
	echo ("<!-- I'm Hello Dolly ;) -->\n");
}

$da = null;
// TEST LOAD VIEW 
 load_view('dolly_test', $da, 'hello_dolly');

// TEST LOAD MODEL
// load_model('dolly_model');

// TEST LOAD LIBRARY
// load_library('dolly_test');
