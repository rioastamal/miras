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
		$artikel_count = ($config['article_count'] ? " ({$kat->jml_artikel}) " : '');
		$result .= $config['tag_open'] . $kat->kategori_nama . $artikel_count . "\n";
	}
	
	return $result;
}
