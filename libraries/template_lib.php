<?php

/**
 * File ini berisi fungsi-fungsi (query) yang berhubungan manipulasi template
 * (views)
 *
 * @package libraries
 * @copyright 2011 Bajol Startup Team
 */

/**
 * Fungsi ini untuk meload daftar kategori
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.1
 *
 * @param array $user_config parameter untuk menentukan output dari daftar kategori
 * @return string
 */
function tpl_get_kategori($user_config=array()) {
	// konfigurasi default yang disediakan untuk output daftar kategori
	$default_config = array(
		'article_count' => FALSE,
		'tag_open' => '<li>',
		'tag_close' => '</li>'
	);
	
	// gabungkan kedua configurasi
	// jika keys dari $user_config ada maka nilai dari key tersebut yang akan digunakan
	// bukan dari $defaul_config
	$config = $default_config + $user_config;
	
	$result = '';
	
	// load kategori model
	load_model('kategori');
	$kategori = get_all_kategori();
	
	// hasil kosong atau terjadi error
	if (!$kategori) {
		return $result;
	}
	
	// jika sampai disini maka terdapat item pada $kategori
	foreach ($kategori as $kat) {		
		$menu_object = new stdClass();
		$menu_object->link_tag_open = '<a>';
		$menu_object->link_label = $kat->kategori_nama;
		$menu_object->link_tag_close = '</a>';
		$menu_object->object = $kat;
		
		run_hooks('build_kategori_tpl', $menu_object);
		
		$result .= $config['tag_open'] . $menu_object->link_tag_open . $menu_object->link_label . $menu_object->link_tag_close . $config['tag_close'] . "\n";
	}
	
	return $result;
}
