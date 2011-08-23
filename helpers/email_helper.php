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
 * Fungsi untuk memvalidasi email. REGEX untuk validasi email 
 * menggunakan milik Jonathan Gotti (http://jgotti.net/).
 *
 * @author Rio Astamal
 * @since 1.0
 * @changelog
 *  2011-08-23 -> mengganti regex milik CodeIgniter dengan implementasi milik Jonathan Gotti
 *
 * @param string $addess Alamat email yang akan dicek
 * @return boolean
 */
function valid_email($address) {
	$quotable		= '@,"\[\]\\x5c\\x00-\\x20\\x7f-\\xff';
	$local_quoted	= '"(?:[^"]|(?<=\\x5c)"){1,62}"';
	$local_unquoted	= '(?:(?:[^' . $quotable . '\.]|\\x5c(?=[' . $quotable . ']))' . 
					  '(?:[^' . $quotable . '\.]|(?<=\\x5c)[' . $quotable.']|\\x5c(?=[' . $quotable . '])|\.(?=[^\.])){1,62}' . 
					  '(?:[^' . $quotable . '\.]|(?<=\\x5c)[' . $quotable . '])|[^' . $quotable . '\.]{1,2})';
	$local			= '(' . $local_unquoted . '|' . $local_quoted . ')';

	$_0_255			= '(?:[0-1]?\d?\d|2[0-4]\d|25[0-5])';
	$domain_ip		= '\[' . $_0_255 . '(?:\.' . $_0_255 . '){3}\]';
	$domain_name	= '(?!.{64})(?:[a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9]\.?|[a-zA-Z0-9]\.?)+\.(?:xn--[a-zA-Z0-9]+|[a-zA-Z]{2,6})';

	$exp = "/^(?:{$local_unquoted}|{$local_quoted})@(?:{$domain_name}|{$domain_ip})$/";
	
	if (preg_match($exp, $address)) {
		return TRUE;
	}
	
	return FALSE;
}


