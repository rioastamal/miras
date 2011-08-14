<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * File ini berisi fungsi-fungsi (query) yang berhubungan dengan tabel options
 *
 * @package models
 * @copyright 2011 CV. Astasoft Indonesia (http://www.astasoft.co.id/)
 */

/**
 * Fungsi untuk mendapatkan random string
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @param int $length Panjang string yang akan digenerate
 * @return string
 */
function mr_random_string($length=8) {
	// kumpulan random string yang akan diambil
	$string = '=-0987654321!@#$%^&*()_+\][poiuytrewqasdfghjkl;/.,mnbvcxzQWERTYUIOP{}|:LKJHGFDSAZXCVBNM<>?';
	// digunakan untuk fungsi mt_rand
	$str_len = strlen($string) - 1;	// minus 1 karena urutan dimulai dari 0
	
	// variabel penyimpan output
	$out = '';
	// loop sebanyak parameter yang diinputkan (default => 8)
	for ($i=0; $i<$length; $i++) {
		// posisi acak single string yang akan diambil
		// dari 0 sampai banyaknya string
		$pos = mt_rand(0, $str_len);
		// simpan pada output
		$out .= $string[$pos];	// cukup ambil satu string
	}
	
	// kembalkan output
	return $out;
}

/**
 * Fungsi untuk menghilangkan karakter non-numeric
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @param string $source String sumber yang akan diubah
 * @param boolean $integer Apakah akan dikembalikan dalam bentuk integer atau string
 * @return string
 */
function mr_only_numeric($source, $integer=FALSE) {
	$numeric = preg_replace('/[^0-9]/', '', $source);
	if ($integer) {
		// casting jika diperlukan
		$numeric = (int)$numeric;
	}
	return $numeric;
}
