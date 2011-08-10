<?php

function get_argument_by($key) {
	global $_MR;
	if (in_array($key, $_MR['controller_arguments'])) {
		$a = array_search($key, $_MR['controller_arguments']);
		if ($a == 0) {
			$a += 1;
			print_r($_MR['controller_arguments'][$a]);
			//return $_MR['controller_arguments'][$a];
		} elseif ($a % 2 == 0) {
			$a += 1;
			print_r($_MR['controller_arguments'][$a]);
			//return $_MR['controller_arguments'][$a];
		} else {
			return FALSE;
		}
		
	}
	
}

?>
