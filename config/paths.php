<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         3.0.0
 * @license       MIT License (https://opensource.org/licenses/mit-license.php)
 */

/**
 * Use the DS to separate the directories in other defines
 */
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

/**
 * These defines should only be edited if you have cake installed in
 * a directory layout other than the way it is distributed.
 * When using custom settings be sure to use the DS and do not add a trailing DS.
 */

/**
 * The full path to the directory which holds "src", WITHOUT a trailing DS.
 */
define('ROOT', dirname(__DIR__));

/**
 * The actual directory name for the application directory. Normally
 * named 'src'.
 */
define('APP_DIR', 'src');

/**
 * Path to the application's directory.
 */
define('APP', ROOT . DS . APP_DIR . DS);

/**
 * Path to the config directory.
 */
define('CONFIG', ROOT . DS . 'config' . DS);

/**
 * File path to the webroot directory.
 *
 * To derive your webroot from your webserver change this to:
 *
 * `define('WWW_ROOT', rtrim($_SERVER['DOCUMENT_ROOT'], DS) . DS);`
 */
define('WWW_ROOT', ROOT . DS . 'webroot' . DS);

/**
 * Path to the tests directory.
 */
define('TESTS', ROOT . DS . 'tests' . DS);

/**
 * Path to the temporary files directory.
 */
define('TMP', ROOT . DS . 'tmp' . DS);

/**
 * Path to the logs directory.
 */
define('LOGS', ROOT . DS . 'logs' . DS);

/**
 * Path to the cache files directory. It can be shared between hosts in a multi-server setup.
 */
define('CACHE', TMP . 'cache' . DS);

/**
 * The absolute path to the "cake" directory, WITHOUT a trailing DS.
 *
 * CakePHP should always be installed with composer, so look there.
 */
define('CAKE_CORE_INCLUDE_PATH', ROOT . DS . 'vendor' . DS . 'cakephp' . DS . 'cakephp');

/**
 * Path to the cake directory.
 */
define('CORE_PATH', CAKE_CORE_INCLUDE_PATH . DS);
define('CAKE', CORE_PATH . 'src' . DS);

/*define('UPLOAD_EXPLAINATIONS', WWW_ROOT.'uploads/explanations/');
define('EXPLAINATIONS_PATH', 'uploads/explanations/');

define('UPLOAD_FORMS_N_DOCS', WWW_ROOT.'uploads/forms_n_docs/');
define('FORMS_N_DOCS_PATH', 'uploads/forms_n_docs/');

define('UPLOAD_ANSWERS', WWW_ROOT.'uploads/contractor_ans/');
define('ANSWERS_PATH', 'uploads/contractor_ans/');

define('UPLOAD_CHANGE_ICON', WWW_ROOT.'uploads/change_icon/');*/

define('DOWNLOAD_PQF', WWW_ROOT.'uploads/pqf/');
define('UPLOAD_LEADS', WWW_ROOT.'uploads/leads/');
define('UPLOAD_HELP_FILES', WWW_ROOT.'uploads/help_files/');
define('IMPORT_DOCS', WWW_ROOT.'uploads/importdocs/');
define('IMPORT_IA', WWW_ROOT.'uploads/industry_Average/');
define('IMPORT_INVOICE', WWW_ROOT.'uploads/invoice/');
define('CERTIFICATE', WWW_ROOT.'uploads/certificate/');
define('TRAINING_CERTIFICATE', WWW_ROOT.'uploads/training_certificates/');
define('REPORT', WWW_ROOT.'uploads/Reports/');

/* Path to the Roles */
define('SUPER_ADMIN',1);
define('CONTRACTOR',2);
define('CLIENT',3);
define('CR',4);
define('CLIENT_ADMIN',5);
define('CLIENT_VIEW',6);
define('EMPLOYEE',7);
define('CONTRACTOR_ADMIN',8);
define('ADMIN',9);
define('CLIENT_BASIC',10);
define('DEVELOPER',11);

define('ADMIN_ALL', [SUPER_ADMIN, ADMIN]);
define('CLIENT_USERS', [CLIENT_ADMIN, CLIENT_VIEW, CLIENT_BASIC]);
define('CONTRACTOR_USERS', [CONTRACTOR_ADMIN]);


define('BENCHMARK', ['3'=>'BenchmarkBAE','6'=>'BenchmarkHuntonGR','19' => 'BenchmarkHuntonGR', '21' => 'BenchmarkHuntonGR','14 '=>'BenchmarkBAE']);

// Define Late Fee & Reactivation Fee.
define('LATE_FEE',99);
define('REACTIVATION_FEE',99);

if(isset($_SERVER['ENVIRONMENT']) && $_SERVER['ENVIRONMENT'] == 'production' ){ 
	define('CC_EMAIL', ['aaron@canqualify.com', 'arundhati.lambore@canqualify.com', 'jen.richman@canqualify.com']);
} else {
	define('CC_EMAIL', ['aaron@canqualify.com','jen.richman@canqualify.com']);
}

define('CanQualify_Marketplace',4);
define('Naisc_Question',2);

/*waiting on status*/
define('STATUS_CONTRACTOR', 1);
define('STATUS_CANQUALIFY', 2);
define('STATUS_CLIENT', 3);
define('STATUS_COMPLETE', 4);

//client modules
define('CONTRACTOR_FND', 3);

//contractor_formsndocs
define('CONTRACTOR_DOC_TYPES', ['Master Subcontract Agreement', 'Subcontract Agreement', 'Other']);

//Define vesion for css & js
define('css_version',2);
define('js_version',6);
