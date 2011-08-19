<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * File ini berisi fungsi-fungsi pembantu dalam melakukan manipulasi string
 * seperti generating, formatting, filterisasi, dll.
 *
 * @package Miras
 * @subpackage Helpers
 * @copyright 2011 CV. Astasoft Indonesia <http://www.astasoft.co.id/>
 * @copyright 2011 Rio Astamal <me@rioastamal.net>
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GPLv2
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

/**
 * Fungsi untuk mendapatkan karakter yang hanya alpha-numeric saja
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @param string $source String sumber
 * @param string $other_char Karakter lain yang diijinkan
 * @return string
 */
function mr_alpha_numeric($source, $other_char='') {
	return preg_replace('/[^0-9A-Za-z'. $other_char . ']/', '', $source);
}

/**
 * Fungsi untuk melakukan serialize jika diperlukan pada data yang 
 * bertipe object atau array
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 * 
 * @param $source
 * @return mixed
 */
function mr_serialize($source) {
	// lakukan serialize jika tipe data adalah array atau object
	if (is_object($source) || is_array($source)) {
		return serialize($source);
	}
	
	// selain itu maka, langsung saja kembalikan sesuai aslinya
	return $source;
}

/**
 * Fungsi untuk melakukan de-serialize jika diperlukan
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 * 
 * @param $source
 * @return mixed
 */
function mr_unserialize($source) {
	// coba lakukan serialize, akan FALSE jika bukan merupakan 
	// serializable string
	$temp = unserialize($source);
	if ($temp === FALSE) {
		// tidak false, maka $source bukan serializable string
		// kembalikan apa adanya
		return $soruce;
	}
	
	// source merupakan serializable, jadi kembalikan yang telah di
	// unserialize
	return $temp;
}
