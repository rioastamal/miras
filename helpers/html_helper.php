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

/**
 * Fungsi untuk melakukan validasi form 
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0.4
 *
 * @param array $rules - Kumpulan label dan aturan yang perlu dilakukan pada field
 * @param array $config - Array konfigurasi yang berhubungan dengan ouput error
 * @return string
 */ 
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
	
	foreach ($rules as $element_id => $el) {
		// cek setiap aturan action yang ditujukan untuk elemen tersebut
		$actions = explode('|', $el['rules']);
		foreach ($actions as $act) {
			// jika variabel error untuk elemen tertentu sudah terisi
			// maka tidak perlu melakukan pengecekan
			if (!isset($errors[$element_id])) {
				// apply rules
				$retval = _apply_rules($element_id, $act, $rules);
				if ($retval !== TRUE) {
					$errors[$element_id] = $config['open_tag'] . $retval . $config['close_tag'];
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

/**
 * Fungsi untuk menjalankan proses validasi sebuah field
 * -- Ini adalah fungsi PRIVATE --
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0.4
 *
 * @param string $id - Nama ID dari field HTML yang akan diproses
 * @param string $action_name - Nama aturan atau validasi yang akan dijalankan
 * @param array $rules - Array original dari aturan (saat ini hanya digunakan pada matches rules)
 */
function _apply_rules($id, $action_name, $rules) {
	$label = $rules[$id]['label'];
	
	switch ($action_name) {
		case 'required':
			if (is_array($_POST[$id])) {
				if (count($_POST[$id]) == 0) {
					return sprintf('The field &quot;%s&quot; cannot be empty.', $label);
				}
			} else {
				if (trim($_POST[$id]) == '') {
					return sprintf('The field &quot;%s&quot; cannot be empty.', $label);
				}
			}
		break;
		
		case 'trim':
			$_POST[$id] = trim($_POST[$id]);
		break;
		
		case 'valid_email':
			load_helper('email');
			if (!valid_email($_POST[$id])) {
				return sprintf('The field &quot;%s&quot; must contain valid email address.', $label);
			}
		break;
		
		case 'alpha':
			if (!preg_match('/^([a-zA-Z])+$/', $_POST[$id])) {
				return sprintf('The field &quot;%s&quot; must contain alpha character only.', $label);
			}
		break;
		
		case 'numeric':
			if (!preg_match('/^([0-9])+$/', $_POST[$id])) {
				return sprintf('The field &quot;%s&quot; must contain alpha character only.', $label);
			}
		brea;
		
		case 'alpha_num':
			if (!preg_match('/^([a-zA-Z0-9])+$/', $_POST[$id])) {
				return sprintf('The field &quot;%s&quot; must contain only alpha numeric characters only.');
			}
		break;

		case 'alpha_num_dash':
			if (!preg_match('/^([a-zA-Z0-9\-])+$/', $_POST[$id])) {
				return sprintf('The field &quot;%s&quot; must contain only alpha numeric and dash (-) characters only.', $label);
			}
		break;
		
		case 'alpha_num_underscore':
			if (!preg_match('/^([a-zA-Z0-9_])+$/', $_POST[$id])) {
				return sprintf('The field &quot;%s&quot; must contain only alpha numeric and underscore characters only.', $label);
			}
		break;
		
		case 'alpha_num_ud':
			if (!preg_match('/^([a-zA-Z0-9_\-])+$/', $_POST[$id])) {
				return sprintf('The field &quot;%s&quot; must contain only alpha numeric, underscore and dash characters only.', $label);
			}
		break;
		
		case 'alpha_space':
			if (!preg_match('/^([a-zA-Z0-9\ ])+$/', $_POST[$id])) {
				return sprintf('The field &quot;%s&quot; must contain only alpha and space characters only.', $label);
			}
		break;
		
		case 'alpha_num_space':
			if (!preg_match('/^([a-zA-Z0-9\ ])+$/', $_POST[$id])) {
				return sprintf('The field &quot;%s&quot; must contain only alpha numeric, and space characters only.', $label);
			}
		break;
		
		case 'alpha_num_uds':
			if (!preg_match('/^([a-zA-Z0-9\_\-\ ])+$/', $_POST[$id])) {
				return sprintf('The field &quot;%s&quot; must contain only alpha numeric, underspace, dash and space characters only.', $label);
			}
		break;
		
		case 'common_username':
			$uname = trim($_POST[$id]);
			// cek untuk beberapa username yang user tidak boleh menggunakan
			$specials = 'admin|guest|administrator|superadmin|anonymous|username|miras';
			if (preg_match('/(' . $specials . ')/i', $uname)) {
				return sprintf( 'Cannot use &quot;%s&quot;, please choose another username.', $uname);
			}
			
			if (!preg_match('/^([a-zA-Z0-9_\-\.])+$/', $_POST[$id])) {
				return sprintf('The field &quot;%s&quot; must contain only alpha numeric, dash, underscore and dot (.) characters only.', $label);
			}
		break;
		
		default:
			// --- FIELD MATCHES --
			// cek apakah action name matches=>nama_field
			// ini digunakan untuk pencocokan field password yang memerlukan
			// kesamaan dengan field yang lain
			if (preg_match('/^matches\s?=>\s?(.*)/', $action_name, $matches)) {
				$match_field = $matches[1];
				if ($_POST[$id] !== $_POST[$match_field]) {
					return sprintf('The value of field &quot;%s&quot; does not match with field &quot;%s&quot;.', $label, $rules[$match_field]['label']);
				}
				
			// -- USER CALLBACK --
			// cek apakah rules berakhiran dengan string '_callback'
			// jika iya maka coba panggil fungsi tersebut (tanpa _callback)
			} elseif (preg_match('/^callback=>([a-zA-Z_]+[a-zA-Z_:0-9]*)+$/', $action_name, $matches)) {
				$function_name = $matches[1];
				
				$param = array(
								'field_name' => $id,
								'data' => $_POST[$id]
						);
								
				// cek apakah callback berupa fungsi murni atau sebuah static
				// function dari class dengan melakukan pengecekan pada 
				// string '::'
				if (strpos($function_name, '::') === FALSE) {
					if (function_exists($function_name)) {
						$retval = call_user_func($function_name, $param);
						if ($retval) {
							// callback seharusnya mengembalikan non-empty 
							// string jadi secara otomatis TRUE
							return $retval;
						}
					}
				} else {
					// split class dan methodnya
					list($class, $method) = explode('::', $function_name);
					
					// callback berupa class
					if (class_exists($class)) {
						if (method_exists($class, $method)) {
							$retval = call_user_func(array($class, $method), $param);
							if ($retval) {
								return $retval;
							}
						}
					}
				}
				
			// -- MINIMUM LENGTH --
			// cek apakah rules min_length=>NUMBER
			} elseif (preg_match('/^min_length\s?=>\s?(.*)/', $action_name, $matches)) {
				$length = (int)$matches[1];
				if (strlen($_POST[$id]) < $length) {
					return sprintf('The minimum length for field &quot;%s&quot; is %d character(s).', $label, $length);
				}
				
			// -- MAXIMUM LENGTH --
			// cek apakah rules max_length=>NUMBER
			} elseif (preg_match('/^max_length\s?=>\s?(.*)/', $action_name, $matches)) {
				$length = (int)$matches[1];
				if (strlen($_POST[$id]) > $length) {
					return sprintf('The maximum length for field &quot;%s&quot; is %d character(s).', $label, $length);
				}
				
			// -- EXACT LENGTH --
			// cek apakah rules exact_length=>NUMBER
			} elseif (preg_match('/^exact_length\s?=>\s?(.*)/', $action_name, $matches)) {
				$length = (int)$matches[1];
				if (strlen($_POST[$id]) !== $length) {
					return sprintf('The length for field &quot;%s&quot; must %d character(s) long.', $label, $length);
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
	
	// jika sampai disini maka field berhasil melewati semua rules
	return TRUE;
}
