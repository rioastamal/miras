<?php if (!defined('BASE_PATH')) { exit('Access Forbidden'); }
/**
 * Menyimpan konstanta informasi seputar versi dari framework
 *
 * @package Miras
 * @subpackage Mr
 * @copyright 2011 CV. Astasoft Indonesia <http://www.astasoft.co.id/>
 * @copyright 2011 Rio Astamal <me@rioastamal.net>
 * @license http://www.gnu.org/licenses/gpl-2.0.txt GPLv2
 */
 
// informasi seputar framework
define('FRAMEWORK_NAME', 'Miras');
define('FRAMEWORK_VERSION', '1.0.2');
define('FRAMEWORK_STATUS_VERSION', 'dev');
define('FRAMEWORK_BUILD_NUMBER', 283);
define('FRAMEWORK_SHORT_VERSION', FRAMEWORK_NAME . ' v' . FRAMEWORK_VERSION);
define('FRAMEWORK_FULL_VERSION', FRAMEWORK_VERSION . '-' . FRAMEWORK_STATUS_VERSION);
define('FRAMEWORK_FULL_NAME', FRAMEWORK_NAME . ' ' . 'v' . FRAMEWORK_FULL_VERSION . ' build ' . FRAMEWORK_BUILD_NUMBER);
