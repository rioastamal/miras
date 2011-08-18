<?php

echo ('What position you want?');
load_library('session');
session_construct();

load_helper('email');
$email = array(
			'ir_11214n70@yahoo.co.id',
			'ir 11214n70@yahoo.com',
			'ir.11214n70@yahoo.com',
			's060080@si.stikom.edu',
			'09-56@yaho.co',
			'fadfa.com'
	     );
	     
	echo '<BR>';
foreach($email as $eml) {
	echo ($eml . var_dump(valid_email($eml)) . '<BR>');
}

print_r($_MR['sessions']);
// mr_session_destroy();
