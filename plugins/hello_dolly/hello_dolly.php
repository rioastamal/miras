<?php

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
