<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * File ini berisi fungsi-fungsi yang membantu mempermudah penggunaan tag HTML 
 * pada controllers atau views
 *
 * @package Miras
 * @subpackage Helpers
 * @copyright 2011 CV. Astasoft Indonesia <http://www.astasoft.co.id/>
 * @copyright 2011 Rio Astamal <me@rioastamal.net>
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GPLv2
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

function mr_form_validation($rules, $config=array()) {
	$errors = array();
	$error_string = '';
	
	$default = array(
		'root_open_tag' => '<ul>',
		'open_tag' => '<li>',
		'close_tag' => '</li>',
		'root_close_tag' => '</ul>'
	);
	
	$config = $config + $default;
	
	foreach ($rules as $element => $actions) {
		// pecah id (0) dan nama label (1)
		$element = explode('|', $element);
		
		// cek setiap aturan action yang ditujukan untuk elemen tersebut
		$actions = explode('|', $actions);
		foreach ($actions as $act) {
			// jika variabel error untuk elemen tertentu sudah terisi
			// maka tidak perlu melakukan pengecekan
			if (!isset($errors[$element[0]])) {
				// apply rules
				$retval = _apply_rules($element, $act);
				if ($retval !== TRUE) {
					$errors[$element[0]] = $config['open_tag'] . $retval . $config['close_tag'];
				}
			}
		}
	}
	
	// gabungkan array errors menjadi sebuah string
	if ($errors) {
		$error_string = implode("\n", $errors);
		$error_string = $config['root_open_tag'] . $error_string . $config['root_close_tag'];
	}
	
	return $error_string;
}

function _apply_rules($element, $action_name) {
	$id = $element[0];
	$label = $element[1];
	
	switch ($action_name) {
		case 'required':
			if (is_array($_POST[$id])) {
				if (count($_POST[$id]) == 0) {
					return sprintf('Field &quot;%s&quot; tidak boleh kosong.', $label);
				}
			} else {
				if (trim($_POST[$id]) == '') {
					return sprintf('Field &quot;%s&quot; tidak boleh kosong.', $label);
				}
			}
		break;
		
		case 'trim':
			$_POST[$id] = trim($_POST[$id]);
		break;
		
		case 'valid_email':
			load_helper('email');
			if (!valid_email($_POST[$id])) {
				return sprintf('Email tidak valid untuk field %s.', $label);
			}
		break;
		
		default:
			// cek apakah action name matches=>nama_field
			// ini digunakan untuk pencocokan field password yang memerlukan
			// kesamaan dengan field yang lain
			if (preg_match('/^matches\s?=>\s?(.*)/', $action_name, $matches)) {
				$field = $matches[1];
				if ($_POST[$id] !== $_POST[$field]) {
					return sprintf('Isi field %s tidak sama.', $label);
				}
			} else {
				// user diperbolehkan menggunakan custom rules yang berisi
				// fungsi yang hanya memerlukan satu parameter
				// contoh: md5, strtoupper, ucfirst dan lain-lain
				
				// cek terlebih dahulu apakah fungsi tersebut ada atau tidak
				if (function_exists($action_name)) {
					$_POST[$id] = call_user_func($action_name, $_POST[$id]);
				}
			}
		break;
	}
	
	return TRUE;
}
