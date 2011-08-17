<?php

add_hook('pre_routing', 'secure_url');

/**
 * Fungsi untuk men-secure dari URL Attack
 *
 * @author Alfa Radito <qwertqwe16@yahoo.co.id>
 * @since Version 1.0
 *
 * @return void
 */
function secure_url() {
	// lakukan filter URL, jika terdapat karakter yang tidak diinginkan
	// langsung keluar dari script (berhenti total)
	
	// logika.......
	$url = $_SERVER['REQUEST_URI'];
	$ret = preg_match('@^[a-zA-Z0-9:\-\._\/#~]+$@', $url);
	
	if (!$ret) {
		throw new Exception ("Terdapat karakter yang tidak diperboblehkan pada URL");
	}
}

function secure_url_on_install() {}
function secure_url_on_uninstall() {}
function secure_url_on_activate() {}
function secure_url_on_deactivate() {}
function secure_url_on_upgrade() {}
