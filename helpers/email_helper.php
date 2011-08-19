<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * File ini berisi fungsi-fungsi kecil yang berhubungan dengan email
 *
 * @package Miras
 * @subpackage Helpers
 * @copyright 2011 CV. Astasoft Indonesia <http://www.astasoft.co.id/>
 * @copyright 2011 Rio Astamal <me@rioastamal.net>
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GPLv2
 */
 
/**
 * Fungsi untuk memvalidasi email
 *
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2009, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 *
 * @return boolean
 */
function valid_email($address) {
	if (preg_match("/^([a-z0-9\+_]+)(\.[a-z0-9\+_]+)*@([a-z0-9]+\.)+[a-z]{2,6}$/ix", $address)) {
		return TRUE;
	}
	
	return FALSE;
}


