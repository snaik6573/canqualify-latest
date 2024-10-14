<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.8
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

/*
 * Configure paths required to find CakePHP + general filepath constants
 */
require __DIR__ . '/paths.php';

/*
 * Bootstrap CakePHP.
 *
 * Does the various bits of setup that CakePHP needs to do.
 * This includes:
 *
 * - Registering the CakePHP autoloader.
 * - Setting the default application paths.
 */
require CORE_PATH . 'config' . DS . 'bootstrap.php';

use Cake\Cache\Cache;
use Cake\Console\ConsoleErrorHandler;
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;
use Cake\Core\Plugin;
use Cake\Database\Type;
use Cake\Datasource\ConnectionManager;
use Cake\Error\ErrorHandler;
use Cake\Http\ServerRequest;
use Cake\Log\Log;
use Cake\Mailer\Email;
use Cake\Mailer\TransportFactory;
use Cake\Utility\Inflector;
use Cake\Utility\Security;

/**
 * Uncomment block of code below if you want to use `.env` file during development.
 * You should copy `config/.env.default to `config/.env` and set/modify the
 * variables as required.
 *
 * It is HIGHLY discouraged to use a .env file in production, due to security risks
 * and decreased performance on each request. The purpose of the .env file is to emulate
 * the presence of the environment variables like they would be present in production.
 */
// if (!env('APP_NAME') && file_exists(CONFIG . '.env')) {
//     $dotenv = new \josegonzalez\Dotenv\Loader([CONFIG . '.env']);
//     $dotenv->parse()
//         ->putenv()
//         ->toEnv()
//         ->toServer();
// }

/*
 * Read configuration file and inject configuration into various
 * CakePHP classes.
 *
 * By default there is only one configuration file. It is often a good
 * idea to create multiple configuration files, and separate the configuration
 * that changes from configuration that does not. This makes deployment simpler.
 */
try {
    Configure::config('default', new PhpConfig());
    Configure::load('app', 'default', false);
    
} catch (\Exception $e) {
    exit($e->getMessage() . "\n");
}

/*
 * Load an environment local configuration file.
 * You can use a file like app_local.php to provide local overrides to your
 * shared configuration.
 */
//Configure::load('app_local', 'default');

/*
 * When debug = true the metadata cache should only last
 * for a short time.
 */
if (Configure::read('debug')) {
    Configure::write('Cache._cake_model_.duration', '+2 minutes');
    Configure::write('Cache._cake_core_.duration', '+2 minutes');
    // disable router cache during development
    Configure::write('Cache._cake_routes_.duration', '+2 seconds');
}

/*
 * Set the default server timezone. Using UTC makes time calculations / conversions easier.
 * Check http://php.net/manual/en/timezones.php for list of valid timezone strings.
 */
//date_default_timezone_set(Configure::read('App.defaultTimezone'));
date_default_timezone_set('America/Denver');

/*
 * Configure the mbstring extension to use the correct encoding.
 */
mb_internal_encoding(Configure::read('App.encoding'));

/*
 * Set the default locale. This controls how dates, number and currency is
 * formatted and sets the default language to use for translations.
 */
ini_set('intl.default_locale', Configure::read('App.defaultLocale'));

/*
 * Register application error and exception handlers.
 */
$isCli = PHP_SAPI === 'cli';
if ($isCli) {
    (new ConsoleErrorHandler(Configure::read('Error')))->register();
} else {
    (new ErrorHandler(Configure::read('Error')))->register();
}

/*
 * Include the CLI bootstrap overrides.
 */
if ($isCli) {
    require __DIR__ . '/bootstrap_cli.php';
}

/*
 * Set the full base URL.
 * This URL is used as the base of all absolute links.
 *
 * If you define fullBaseUrl in your config file you can remove this.
 */
if (!Configure::read('App.fullBaseUrl')) {
    $s = null;
    if (env('HTTPS')) {
        $s = 's';
    }

    $httpHost = env('HTTP_HOST');
    if (isset($httpHost)) {
        Configure::write('App.fullBaseUrl', 'http' . $s . '://' . $httpHost);
    }
    unset($httpHost, $s);
}

Cache::setConfig(Configure::consume('Cache'));
ConnectionManager::setConfig(Configure::consume('Datasources'));
TransportFactory::setConfig(Configure::consume('EmailTransport'));
Email::setConfig(Configure::consume('Email'));
Log::setConfig(Configure::consume('Log'));
Security::setSalt(Configure::consume('Security.salt'));

/*
 * The default crypto extension in 3.0 is OpenSSL.
 * If you are migrating from 2.x uncomment this code to
 * use a more compatible Mcrypt based implementation
 */
//Security::engine(new \Cake\Utility\Crypto\Mcrypt());

/*
 * Setup detectors for mobile and tablet.
 */
ServerRequest::addDetector('mobile', function ($request) {
    $detector = new \Detection\MobileDetect();

    return $detector->isMobile();
});
ServerRequest::addDetector('tablet', function ($request) {
    $detector = new \Detection\MobileDetect();

    return $detector->isTablet();
});

/*
 * Enable immutable time objects in the ORM.
 *
 * You can enable default locale format parsing by adding calls
 * to `useLocaleParser()`. This enables the automatic conversion of
 * locale specific date formats. For details see
 * @link https://book.cakephp.org/3.0/en/core-libraries/internationalization-and-localization.html#parsing-localized-datetime-data
 */
Type::build('time')
    ->useImmutable();
Type::build('date')
    ->useImmutable();
Type::build('datetime')
    ->useImmutable();
Type::build('timestamp')
    ->useImmutable();

/*
 * Custom Inflector rules, can be set to correctly pluralize or singularize
 * table, model, controller names or whatever other string is passed to the
 * inflection functions.
 */
//Inflector::rules('plural', ['/^(inflect)or$/i' => '\1ables']);
//Inflector::rules('irregular', ['red' => 'redlings']);
//Inflector::rules('uninflected', ['dontinflectme']);
//Inflector::rules('transliteration', ['/å/' => 'aa']);
$usecaptcha = 0;
if(isset($_SERVER['ENVIRONMENT']) && $_SERVER['ENVIRONMENT'] == 'production' ){
	$usecaptcha = 1;
}
Configure::write('google_recatpcha_settings', array(
    'usecaptcha' => $usecaptcha,
    'site_key'=>'6Ld9UaMUAAAAAJyl_uFaaAh6EXCvbvWjjoVBGAtC',
    'secret_key'=>'6Ld9UaMUAAAAANtoaljNI8ZetiftOsDtJVNHg-na'
));
/*Configure::write('paypalDirectSandbox', array(
    'api_endpoint' => 'https://api-3t.sandbox.paypal.com/nvp',
    'api_username' => 'ashvinip21_biz_api1.gmail.com',
    'api_password' => '5EXSB95YWXPP2PE4',
    'api_signature'=> 'A.8KTDaltweUKh89nNQZKC.5zSeiAGuZK1Kod6bFzWWKDHXUpj8PdGXz'
));
*/
if(isset($_SERVER['ENVIRONMENT']) && $_SERVER['ENVIRONMENT'] == 'production' ){
Configure::write('paypalDirectSandbox', array(
    'api_endpoint' => 'https://api-3t.paypal.com/nvp',
    'api_username' => 'info_api1.canqualify.com',
    'api_password' => '4NH78TBVSAZ4ZE5Y',
    'api_signature'=> 'AzwltlIYYy2c7RDl2SxFGTLXN6jxAZbvAL1RcVW2Esyr1Sd7tUqFsDiM'
    /*'api_username' => 'aaron.harker_api1.canqualify.com',
    'api_password' => 'NW37ESMWGPFR4PWX',
    'api_signature'=> 'AMrU3CdBFCZG-bjPUZT3.bUtX5DEA2ivxLFizpF.IWd1fbE79XODtV-W'*/
));
}
else
{
Configure::write('paypalDirectSandbox', array(
    'api_endpoint' => 'https://api-3t.sandbox.paypal.com/nvp',
    'api_username' => 'arundhati.lambore-facilitator_api1.canqualify.com',
    'api_password' => 'DLYAZFN6XUUBRDKB',
    'api_signature'=> 'ARVllR0TjguXil1XV758FW4PBwhBAxl4wQAnQoGGqWvi.UyueowWPSL7',
    'sandbox' => false
));
}
Configure::write('customer_service', array(
     'phone_no' => '(801) 851-1810',
)); 
if(isset($_SERVER['ENVIRONMENT']) && $_SERVER['ENVIRONMENT'] == 'production' ){
	Configure::write('uploaded_path', 'https://data-canqualifyer.s3.amazonaws.com/');
	Configure::write('bucket_path', 'data-canqualifyer');
	//Configure::write('bucket_path_backup', 'data-canqualifyer-backup');
}
else {
	Configure::write('uploaded_path', 'https://demo-data-canqualifyer.s3.amazonaws.com/');
	Configure::write('bucket_path', 'demo-data-canqualifyer');
	Configure::write('bucket_path_backup', 'demo-data-canqualifyer-backup');
}
Configure::write('year_range', array('2015'=>'2015','2016'=>'2016','2017'=>'2017','2018'=>'2018'));
Configure::write('icons', array('0'=>'Grey','1'=>'Red','2'=>'Yellow','3'=>'Green'));
Configure::write('payment_type', [
	'contractor' => ['new'=>'1','renew_subscription'=>'2','new_client'=>'3','new_service'=>'4','employee_slot'=>'5', 'new_site'=>'6']
]);
Configure::write('note_type', array('1'=>'Normal','2'=>'Follow Up','3'=>'Emails Sent','4'=>'Phone Call made','5'=>'Status'));

/* cakephp pdf */


Configure::write('CakePdf', [
    'engine' => [
        'className' => 'CakePdf.WkHtmlToPdf',
        'binary' => '/usr/bin/wkhtmltopdf', //LINUX
        //'binary' => 'C:\PROGRA~1\wkhtmltopdf\bin\wkhtmltopdf.exe', //WINDOWS
        'options' => [
            'debug' => true,
            'print-media-type' => false,
            'outline' => true,
            'dpi' => 96
        ]
    ],
    'pageSize' => 'Letter',
]);


/* EmployeeQual Default Pricining*/

Configure::write('EmployeeQual', array(
    'base' => '5',
    'price' => '25',
    'range' => '1000'
));
     
/* Default Customer Representative */
Configure::write('Contractor_CR', array(4));
Configure::write('Lead_CR', array(4));


/* Catgeory  with Question id */
Configure::write('q_id',['General_liablity' =>
        [
        'cat_id' => '14',
        'p_expiration_qid' => '43',
        'p_effective_qid' => '42'
        ]
    ,
    'Automobile_liablity' =>
        [
        'cat_id' => '15',
        'p_expiration_qid' => '55',
        'p_effective_qid' => '54'
        ]
    ,
    'Excess/Umbreall_liablity' =>
        [
        'cat_id' => '16',
        'p_expiration_qid' => '65',
        'p_effective_qid' => '64'
        ]
    ,
    'worker_compensation' =>
        [
        'cat_id' => '17',
        'p_expiration_qid' => '456',
        'p_effective_qid' => '72'
        ]
    

]);
/* InsureQual years */
Configure::write('insure_years', array(
    //'0' => 2019,
    //'0' => 2020,
    //'0' => 2022
    0 => 2023,
    1 => 2024
));
/* Google Map */
Configure::write('show_map',false);
