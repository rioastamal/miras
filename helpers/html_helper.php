<?php
/**
 * File ini berisi fungsi-fungsi yang membantu mempermudah penggunaan tag HTML 
 * pada controllers atau views
 * 
 * @package helper
 * @copyright 2011 Bajol Startup Team
 */

/**
 * Fungsi ini berguna untuk mencetak string 'checked="checked"' yang berguna
 * pada saat 'repopulating' form setelah submit. Fungsi ini dikhususkan
 * untuk penggunaan pada tag input type checkbox dan radio. 
 *
 * @param $val1 mixed Nilai pertama yang akan dibandingkan
 * @param $val2 mixed Nilai kedua yang akan dibandingkan
 * @param $padleft string Karakter/string yang ditambahkan pada sebelah kiri hasil
 * @param $padright string Karakter/string yang akan ditambahkan pada sebelah kanan hasil
 * @return string
 */
function mr_checked_if($val1, $val2, $padleft=' ', $padright='') {
	// bandingkan nilai dengan perbanding HARUS BERTIPE SAMA PERSIS
	// lihat penggunaan tanda ====
	if ($val1 === $val2) {
		return $padleft . 'checked="checked"' . $padright;
	}
	
	// jika nilai tidak sama kembalikan string kosong
	return '';
}

/**
 * Fungsi ini berguna untuk mencetak string 'selected="selected"' yang berguna
 * pada saat 'repopulating' form setelah submit. Fungsi ini dikhususkan
 * untuk penggunaan pada tag option yang digunakan dalam tag select. 
 *
 * @param $val1 mixed Nilai pertama yang akan dibandingkan
 * @param $val2 mixed Nilai kedua yang akan dibandingkan
 * @param $padleft string Karakter/string yang ditambahkan pada sebelah kiri hasil
 * @param $padright string Karakter/string yang akan ditambahkan pada sebelah kanan hasil
 * @return string
 */
function mr_selected_if($val1, $val2, $padleft=' ', $padright='') {
	if ($val1 === $val2) {
		return $padleft . 'selected="selected"' . $padright;
	}
	
	// jika nilai tidak sama kembalikan string kosong
	return '';
}
