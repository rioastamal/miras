<?php

add_hook('pre_routing', 'secure_url');

function secure_url() {
	// lakukan filter URL, jika terdapat karakter yang tidak diinginkan
	// langsung keluar dari script (berhenti total)
	
	// logika.......
}
