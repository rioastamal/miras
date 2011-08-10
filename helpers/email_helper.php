<?php
/**
 * Fungsi untuk memvalidasi email
 *
 * @author Rio Astamal <me@rioastamal.net>
 * @since Version 1.0
 *
 * @return true or false
 */
function valid_email($address)
{
	if (preg_match("/^([a-z0-9\+_]+)(\.[a-z0-9\+_]+)*@([a-z0-9]+\.)+[a-z]{2,6}$/ix", $address)) {

		return TRUE;
	}
	
	return FALSE;
}


