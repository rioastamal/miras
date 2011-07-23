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
}
