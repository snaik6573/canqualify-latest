<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;
use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Core\Configure;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    public function beforeFilter(Event $event)
    {
		parent::beforeFilter($event);

		$activeUser = $this->getRequest()->getSession()->read('Auth.User');
		$this->set('activeUser', $activeUser);

        $this->Auth->allow(['contactUs', 'thankYou']);
        
        
        if(isset($activeUser['role_id'])) {
            if($activeUser['role_id'] == SUPER_ADMIN || $activeUser['role_id'] == ADMIN) {
                $this->viewBuilder()->setLayout('admin');	
            }
            elseif($activeUser['role_id'] == CR) {
                $this->viewBuilder()->setLayout('customerCR');	
            }
            elseif($activeUser['role_id'] == CONTRACTOR || $activeUser['role_id'] == CONTRACTOR_ADMIN) {
                $this->viewBuilder()->setLayout('contractor');
            }
            elseif($activeUser['role_id'] == CLIENT || $activeUser['role_id'] == CLIENT_ADMIN || $activeUser['role_id'] == CLIENT_VIEW || $activeUser['role_id'] == CLIENT_BASIC) {
                $this->viewBuilder()->setLayout('client');
            }
            elseif($activeUser['role_id'] == EMPLOYEE) {
                $this->viewBuilder()->setLayout('employee');
            }
            elseif($activeUser['role_id'] == DEVELOPER) {
                $this->viewBuilder()->setLayout('developer');
            }
        }
    }
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */

    public $helpers = array('Category','Breadcrumbs', 'Safetyreport');    

    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);

        $this->loadComponent('Flash');
		$this->loadComponent('Cookie');
		$this->loadComponent('Fileupload');
        $this->loadComponent('Auth', [
	    'authorize' => ['Controller'],         
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'username',
                        'password' => 'password'
                    ],
                    'finder' => 'auth'
                ]
            ],
            'storage' => 'Session'
        ]);

		$this->loadComponent('User'); // custom Component
		$this->loadComponent('Category'); // custom Component
		$this->loadComponent('Fileuploads3');
		$this->loadComponent('Export');
		$this->loadComponent('Safetyreport');
		$this->loadComponent('Benchmark');
		$this->loadComponent('Notification');
        $this->loadComponent('Percentage');
        $this->loadComponent('TrainingPercentage');
        $this->loadComponent('Training');
        $this->loadComponent('EmployeeCategory');
        $this->loadComponent('Email');
		foreach(BENCHMARK as $customComponent) {
			$this->loadComponent($customComponent);
		}
        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');

        // Allow the display action so our PagesController
        // continues to work. Also enable the read only actions.
        $this->Auth->allow(['login', 'logout', 'register', 'forgotPassword', 'resetPassword', 'thankYou', 'uploadFile','display','getStates','inactiveUserMsg','employeeList','empRegister','startCampaign', 'percentageEntries', 'accountExpiringToday', 'accountExpiring']);
    }

    public function verifyRecatpcha($aData)
    {
        if(!$aData) {
           return true;
        }
        if(isset($aData['g-recaptcha-response']))
        {
		$recaptcha_secret = Configure::read('google_recatpcha_settings.secret_key');
		$url = "https://www.google.com/recaptcha/api/siteverify?secret=".$recaptcha_secret."&response=".$aData['g-recaptcha-response'];
		$response = json_decode(@file_get_contents($url));  
		if($response->success == true) {
			return true;
		}
		else {
			return false;
		}
	}
	else {
		return false;
	}
    }
}