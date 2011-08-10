<?php
add_hook('mr_init', 'no_ie6');
/**
 * Fungsi untuk menghentikan eksekusi script jika user menggunakan browser Internet Explorer versi 6
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @return void
 */

function no_ie6() {
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	// versi minimum yang OK
	$min_version = 7.0;
	
	// extract versi dari internet explorer menggunakan preg_match
	if (preg_match('@MSIE\s([0-9\.]+);+@', $user_agent, $matches)) {
		// konversi ke float nilai dari $matches[1]
		$version = (float)$matches[1];
		if ($version < $min_version) {
			throw new Exception ("Versi Internet Explorer anda ({$version}) terlalu lama, upgrade ke versi >= 7 atau pilih browser lain seperti Firefox 3 dan Chrome");
		}
	}
}

function no_ie6_on_install() {}
function no_ie6_on_uninstall() {}
function no_ie6_on_activate() {}
function no_ie6_on_deactivate() {}
function no_ie6_on_upgrade() {}
