<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * File ini berisi fungsi-fungsi yang digunakan untuk melakukan query ke 
 * database.
 *
 * @package Miras
 * @subpackage Libraries
 * @copyright 2011 CV. Astasoft Indonesia <http://www.astasoft.co.id/>
 * @copyright 2011 Rio Astamal <me@rioastamal.net>
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GPLv2
 */

/**
 * Fungsi untuk memulai session database transaksi. Ini hanya berlaku untuk
 * storage engine yang mendukung fitur TRANSACTION seperti InnoDB, ExtraDB,
 * atau lainnya.
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0.5
 *
 * @return void
 */
function mr_begin_trans() {
	global $_MR;
	
	if ($_MR['db_trans']) {
		$_MR['db']->set_autocommit(FALSE);
	}
}

/**
 * Fungsi untuk mengakhiri session database transaksi. Ini hanya berlaku untuk
 * storage engine yang mendukung fitur TRANSACTION seperti InnoDB, ExtraDB,
 * atau lainnya.
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0.5
 *
 * @return void
 */
function mr_end_trans() {
	global $_MR;
	
	if ($_MR['db_trans']) {
		$_MR['db']->set_autocommit(TRUE);
	}
}

/**
 * Fungsi untuk melakukan query COMMIT pada database, sehingga perubahan
 * yang dilakukan tersimpan.
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0.5
 *
 * @return void
 */
function mr_query_commit() {
	global $_MR;
	
	if ($_MR['db_trans']) {
		$_MR['db']->commit();
	}
}

/**
 * Fungsi untuk melakukan query ROLLBACK pada database, sehingga perubahan yang
 * dilakukan diabaikan oleh mysql server.
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0.5
 *
 * @return void
 */
function mr_query_rollback() {
	global $_MR;
	
	if ($_MR['db_trans']) {
		$_MR['db']->rollback();
	}
}

/**
 * Fungsi untuk melakukan wrapper query, setiap rutin kode yang melakukan query
 * database SEHARUSNYA menggunakan fungsi ini agar query yang dilakukan dapat
 * dihandle oleh internal Miras, seperti query caching, last query, dll.
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 * @changelog:
 * 		2011-29-10	=> Default nilai parameter kedua diubah dari 60 menjadi 0 (no-cache)
 *
 * @param string $query SQL Query yang akan dijalankan
 * @param int $cache_time Lama waktu cache akan disimpan (masukkan 0 jika tidak ingin melakukan cache)
 * @return mixed
 */
function mr_query($query, $cache_time=0) {
	global $_MR;
	
	$query = trim($query);
	
	// cek apakah query merupakan SELECT atau tidak
	if (mr_is_select_query($query)) {
		// cek apakah query cache diaktifkan?
		if (query_cache_status() === TRUE && $cache_time > 0) {
			// OK, query cache diaktifkan 
			// sekarang mari coba ambil cache dari file
			$result = query_cache_data($query, $cache_time);
			site_debug(print_r($result, TRUE), "CACHE QUERY");
			
			// cek $result, jika tidak FALSE maka query cache ada, jadi
			// berhenti sampai disini saja. Namun jika tidak ada maka jalankan
			// query biasa (atau lanjut terus ke kode dibawah)
			if ($result !== FALSE) {
				return $result;
			}
		}
	}
	
	$result = $_MR['db']->query($query);
	set_last_query($query);
	if ($result === FALSE) {
		// query error
		throw new Exception ('Query Error (' . $_MR['db']->errno .')<br/>' . $_MR['db']->error);
	}
	
	// karena query berhasil maka increase jumlah query
	increase_query_number();
	
	$record = array();
	while ($row = $result->fetch_object()) {
		// masukkan setiap result object ke array $artikel
		$record[] = $row;
	}
	
	// masukkan hasil query ke cache
	if (mr_is_select_query($query)) {
		if (query_cache_status() === TRUE && $cache_time > 0) {
			site_debug(print_r($record, TRUE), "WRITE QUERY CACHE");
			query_cache_write($query, $artikel);
		}
	}
	
	// tutup result
	$result->close();
	
	return $record;
}

/**
 * Fungsi untuk melakukan wrapper multi query, setiap rutin kode yang melakukan query
 * database SEHARUSNYA menggunakan fungsi ini agar query yang dilakukan dapat
 * dihandle oleh internal Miras, seperti last query, dll.
 *
 * PERINGATAN! Fungsi ini bersifat EXPERIMENTAL dan belum menjalani test.
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @param string $query SQL Query yang akan dijalankan
 * @return mixed
 */
function mr_query_multi($query, $cache_time=60) {
	global $_MR;
	
	$query = trim($query);
	
	$multi = $_MR['db']->multi_query($query);
	set_last_query($query);
	if ($multi === FALSE) {
		// query error
		throw new Exception ('Query Error (' . $_MR['db']->errno .')<br/>' . $_MR['db']->error);
	}
	
	// parse hasil query yang pe
	$i = 0;
	
	$records = array();
	do {
		if ($result = $_MR['db']->store_result()) {
			while ($row = $result->fetch_object()) {
				// masukkan setiap result object ke array $artikel
				$records[$i++][] = $row;
			}
			
			// kosongkan result
			$result->free();
			increase_query_number();
		}
	} while ($_MR['db']->next_result());
	
	return $records;
}

/**
 * Fungsi untuk melakukan SQL INSERT
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 * 
 * @param string $query SQL Query INSERT yang akan dieksekusi
 * @return int 
 */
function mr_query_insert($query, $return_id=FALSE) {
	global $_MR;
	
	$result = $_MR['db']->query($query);
	set_last_query($query);
	
	if ($result === FALSE) {
		// query error
		throw new Exception ('Query Error (' . $_MR['db']->errno .')<br/>' . $_MR['db']->error);
	}
	
	increase_query_number();
	
	if ($return_id === TRUE) {
		// ZERO atau nilai dari AUTO_INCREMENT jika ada
		return $_MR['db']->insert_id;
	}
	
	// kembalikan affected rows
	return $_MR['db']->affected_rows;
}

/**
 * Fungsi untuk melakukan SQL UPDATE
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 * 
 * @param string $query SQL Query UPDATE yang akan dieksekusi
 * @return int 
 */
function mr_query_update($query, $return_id=FALSE) {
	return mr_query_insert($query);
}

/**
 * Fungsi untuk melakukan SQL DELETE
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 * 
 * @param string $query SQL Query DELETE yang akan dieksekusi
 * @return int 
 */
function mr_query_delete($query, $return_id=FALSE) {
	return mr_query_insert($query);
}

/**
 * Fungsi untuk menentukan apakah suatu query merupakan clause SELECT atau bukan
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @param string $query SQL query yang dianalisa
 * @return boolean
 */
function mr_is_select_query($query) {
	return preg_match('/^\bSELECT\b/i', $query);
}

/**
 * Wrapper fungsi untuk MySQLi real_escape_string
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @param string $string - String yang akan diescape
 * @return string
 */
function mr_escape_string($string) {
	global $_MR;
	
	return $_MR['db']->real_escape_string($string);
}

/**
 * Fungsi sederhana untuk membangun query select dari array
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0.4
 *
 * @param array|string $data	Array Field yang akan diquery
 * @param string $from			Nama tabel yang akan di select
 * @return string
 */
function mr_query_select($data, $from='') {
	$result = array();
	
	if (is_array($data)) {
		// gabungkan item dengan separator koma
		$result = implode(', ', $data);
	} else {
		// kembalikan apa adanya karena berupa string
		$result = $data;
	}
	
	if ($from) {
		$result = $result . ' FROM ' . $from;
	}
	
	return 'SELECT ' . $result;
}

/**
 * Fungsi sederhana untuk membangun query WHERE dari array, struktur dari
 * parameter pertama adalah sebagai berikut:
 *
 * <code>
 * array(
 *		'field_name' => array(
 *							'value' => 'someval',
 *							'op'	=> '='
 *						),
 *						array(
 *							'value'		=> 'someval2',
 *							'op'		=> '!=',
 *							// opsional jika diisi maka data tidak akan coba
 *							// dicasting oleh fungsi
 *							'nocast'	=> TRUE	
 *						)
 * );
 * </code>
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0.5
 *
 * @param array|string $data	Item yang akan diubah menjadi klausa query
 * @param string $operator		String operator AND atau OR
 * @return string
 */
function mr_query_where($data, $operator='AND') {
	$result = array();
	
	// cek apakah data kosong (bernilai FALSE) atau tidak
	if (!$data) {
		return '';
	}
	
	// cek apakah data merupakan array atau berupa string
	if (is_array($data)) {
		foreach ($data as $field => $item) {
			// escape string untuk keamananan data
			$item['value'] = mr_escape_string($item['value']);
			
			// jika value berupa string dan tidak terdapat item dengan key 'nocast'
			// maka tambahkan penutup single quote pada value tersebut
			if (is_string($item['value']) && !isset($item['nocast'])) {
				$item['value'] = "'{$item['value']}'";
			}
			
			// cek apakah operator mengandung kata like jika iya maka UPPERCASE-kan
			if (stripos($item['op'], 'like') !== FALSE) {
				$item['op'] = strtoupper(trim($item['op']));
				$item['op'] = " {$item['op']} ";
			}
			// masukkan sementara ke array result
			$result[] = "{$field}{$item['op']}{$item['value']}";
		}
		
		// gabungkan hasil dengan $operator yang ditentukan pada parameter-2
		$result = implode(" {$operator} ", $result);
	} else {
		// sepertinya user lebih suka membangun query sendiri ;)
		$result = $data;
	}
	return 'WHERE ' . $result;
}

/**
 * Fungsi sederhana untuk membangun query join dari array, bentuk dari parameter
 * array yang diterima adalah:
 *
 * <code>
 * array(
 *		'type' 	=> 'left', // bisa 'right' atau 'inner'
 *		'table'	=> 'some_table st',	// nama table yang akan dijoin
 *		'field'	=> 'st.nama_kolom=tb.nama_kolom,	// kolom yang dicocokkan
 * );
 * </code>
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0.5
 *
 * @param array|string		Item data yang akan dijoin
 * @return string
 */
function mr_query_join($data) {
	$result = array();
	
	if (is_array($data)) {
		foreach ($data as $join) {
			$_join = strtoupper($join['tipe']) . ' JOIN ';
			$_join .= $join['table'] . ' ON ';
			$_join .= $join['field'];
			$result[] = $_join;
		}
		$result = implode("\n", $result);
	} else {
		$result = $data;
	}
	
	return $result;
}

/**
 * Fungsi untuk membangun klausa query INSERT
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0.5
 *
 * @param string $table_name - Nama tabel tanpa prefix
 * @param array $values - Associative array yang berisi index: nama kolom dan value: nilai dari kolom
 * @return string
 */
function mr_query_build_insert($table_name, $values) {
	$query = '';
	
	if (!is_array($values)) {
		throw new Exception('Parameter kedua pada mr_query_build_insert harus bertipe Array.');
	}
	
	// 1) filter semua input data
	// 2) cek untuk pemberian quote jika tipe string
	foreach ($values as $col => $val) {
		$values[$col] = mr_escape_string($val);
		
		if (is_string($val)) {
			$values[$col] = "'{$val}'";
		}
	}
	
	// gabungkan keys(column) dengan separator koma
	$columns = implode(', ', array_keys($values));
	
	// gabungkan values dengan separator koma
	$values = implode(', ', $values);
	
	$table_name = DB_PREFIX . $table_name;
	$query = "INSERT INTO {$table_name} ({$columns}) VALUES ({$values})";
	
	return $query;
}

/**
 * Fungsi untuk membangun klausa query UPDATE
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0.5
 *
 * @param string $table_name - Nama tabel tanpa prefix
 * @param array $values - Associative array yang berisi index: nama kolom dan value: nilai dari kolom yang akan diupdate
 * @param array $where - Array untuk klausa where (fungsi mr_query_where untuk detail)
 * @return string
 */
 
function mr_query_build_update($table_name, $values, $where) {
	$query = '';
	$set = array();
	
	if (!is_array($values)) {
		throw new Exception('Parameter kedua pada mr_query_build_update harus bertipe Array.');
	}
	
	// 1) filter semua input data
	// 2) cek untuk pemberian quote jika tipe string
	foreach ($values as $col => $val) {
		$values[$col] = mr_escape_string($val);
		
		if (is_string($val)) {
			$values[$col] = "'{$val}'";
		}
		
		// tambahkan tanda sama dengan '=' sehingga menjadi sesuatu seperti
		// foo=123 atau foo='bar'
		$set[$col] = $col . '=' . $values[$col];
	}
	
	// gambungkan untuk membuat klausa SET
	$set = implode(', ', $set);
	
	// proses where
	$where = mr_query_where($where);
	
	$table_name = DB_PREFIX . $table_name;
	$query = "UPDATE {$table_name} SET {$set} {$where}";
	
	return $query;
}
