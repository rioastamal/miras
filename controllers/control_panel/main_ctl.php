<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }

header('Location: ' . get_backend_url() . '/main-backend');
mr_clean_up();
exit;
