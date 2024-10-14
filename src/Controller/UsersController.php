<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Mailer\MailerAwareTrait;       //  Built in function use for sending multiple email
use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Security;
use Cake\ORM\TableRegistry;
require_once(ROOT."/vendor/aws/aws-autoloader.php"); 
use Aws\S3\S3Client;
use Cake\I18n\Time;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    use MailerAwareTrait;

    public function isAuthorized($user)
    {
	if($this->request->getParam('action')=='dashboard' || $this->request->getParam('action')=='contractor_list' ) {
		if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN || $user['role_id'] == DEVELOPER) {
			return true; 
		}
	}
	if (isset($user['role_id']) ) {
		return true;
	}
	// Default deny
	return false;
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
		/*$totalCount = $this->Users->find('all')->count();
        $this->paginate = [
            'contain' => ['Roles'],
            'limit'   => $totalCount,
			'maxLimit'=> $totalCount
        ];
        $users = $this->paginate($this->Users);*/
		
		/*$totalCount = $this->Users->find('all')->count();
        $this->paginate = [
            'contain' => [
				'Roles', 
				'CustomerRepresentative', 
				'Clients', 'ClientUsers', 'ClientUsers.Clients', 
				'Contractors', 'ContractorUsers', 'ContractorUsers.Contractors',
				'Employees', 'Employees.Contractors'
			],
            'limit'   => $totalCount,
			'maxLimit'=> $totalCount
        ];
        $users = $this->paginate($this->Users);
		$this->set(compact('users'));*/
		
		if ($this->request->is(['patch', 'post', 'put'])) {
		if($this->request->getData('id')!==null) {
	        $this->viewBuilder()->setLayout('ajax');
			
            $user = $this->Users->get($this->request->getData('id'));
			$user->active = $this->request->getData('active') ;
            if ($this->Users->save($user)) {
                echo '<div class="alert with-close alert-success alert-dismissible fade show" role="alert">The user has been saved.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';            
    	    }
    	    else {
    		    echo '<div class="alert with-close alert-danger alert-dismissible fade show" role="alert">The user could not be saved. Please, try again.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
    	    }
  	    exit;
        }
		}
		
		//$aColumns = array('Users.id', 'Users.username', 'company_name', 'pri_contact', 'Roles.role_title', 'Users.active');
		$aColumns = array('Users.id', 'Users.username', 'Roles.role_title', 'Users.active');
		if(isset($_GET['draw'])) {
			$this->viewBuilder()->setLayout('ajax_content');
			
			/*
			* Paging
			*/
			$page = $_GET['start'] / $_GET['length'] + 1 ;
			
			$limit = 10;
			if($_GET['length'] != '-1') { // length != all
				$limit = $_GET['length'];
			}
			
			/*
			* Ordering
			*/
			$orderArr = [];
			if(!empty($_GET['order'])){
				/*compNm = ['Clients.company_name', 'Contractors.company_name'];
				if($aColumns[$_GET['order'][0]['column']] == 'company_name') {
					foreach($compNm as $c) {
						//$orderArr[$c] = $_GET['order'][0]['dir'];	
						$orderArr[] = $c.' '.$_GET['order'][0]['dir'];						
					}
				}
				else {*/
					$orderArr[] = $aColumns[$_GET['order'][0]['column']].' '.$_GET['order'][0]['dir'];
				//}
			}

			/*
			* Filtering
			*/
			$sWhere = [];
			if ($_GET['search']['value'] != "") {
				// search on string fields
				$strCloumns = ['Users.username', 'Roles.role_title'];
				
				foreach($strCloumns as $cl) {
					$sWhere['OR']['LOWER('.$cl.') LIKE'] = '%'.strtolower($_GET['search']['value']).'%';
				}
				
				/*$strCloumns = ['Users.username', 'company_name', 'pri_contact', 'Roles.name'];
				$compNm = ['Clients.company_name', 'Contractors.company_name'];
				$userNmArray = ['Clients.pri_contact_fn', 'Contractors.pri_contact_fn', 'ClientUsers.pri_contact_fn', 'ContractorUsers.pri_contact_fn', 'Employees.pri_contact_fn', 'CustomerRepresentative.pri_contact_fn',
								'Clients.pri_contact_ln', 'Contractors.pri_contact_ln', 'ClientUsers.pri_contact_ln', 'ContractorUsers.pri_contact_ln', 'Employees.pri_contact_ln', 'CustomerRepresentative.pri_contact_ln'
							];				
				foreach($strCloumns as $cl) {
					if($cl == 'company_name') {
						foreach($compNm as $c) {
							$sWhere['OR']['LOWER('.$c.') LIKE'] = '%'.strtolower($_GET['search']['value']).'%';
						}
					}
					elseif($cl == 'pri_contact') {
						foreach($userNmArray as $c) {
							$sWhere['OR']['LOWER('.$c.') LIKE'] = '%'.strtolower($_GET['search']['value']).'%';
						}
					}
					else {
						$sWhere['OR']['LOWER('.$cl.') LIKE'] = '%'.strtolower($_GET['search']['value']).'%';
					}
				}*/
			}
		
			$this->paginate = [
				'page' => $page,
				'limit' => $limit,
				'contain' => [
					'Roles', 
					'CustomerRepresentative', 
					 'ClientUsers', 'ClientUsers.Clients', 
					'Contractors', 'ContractorUsers', 'ContractorUsers.Contractors',
					'Employees'
				],
				'conditions' => $sWhere,
				'order' => $orderArr				
			];
			$users = $this->paginate($this->Users);
			
			//$totalCount = $this->Users->find('all')->count();
			$totalCount = $this->request->getParam('paging')['Users']['count'];

			$this->set(compact('users', 'totalCount'));
		}
		
	/*$roleid = $this->getRequest()->getSession()->read('Auth.User.role_id');
	if ($roleid == SUPER_ADMIN || $roleid == ADMIN) {
        $adminRole = array(SUPER_ADMIN, ADMIN);
    	$users = $this->Users->find()
        ->select(['Users.id', 'username', 'active', 'role_id', 'Roles.role_title'])
        ->where(['Users.role_id IN'=>$adminRole])->contain(['Roles'])->toArray();

    	$cr = $this->Users->find()
        ->select(['Users.id', 'username', 'active', 'role_id', 'Roles.role_title', 'CustomerRepresentative.pri_contact_fn', 'CustomerRepresentative.pri_contact_ln', 'CustomerRepresentative.user_id'])
        ->where(['Users.role_id'=>CR])->contain(['Roles','CustomerRepresentative'])->toArray();

    	$clients = $this->Users->find()
        ->select(['Users.id', 'username', 'active', 'role_id', 'Roles.role_title', 'Clients.id', 'Clients.pri_contact_fn', 'Clients.pri_contact_ln', 'Clients.user_id', 'Clients.company_name'])
        ->where(['Users.role_id'=>CLIENT])->contain(['Roles','Clients'])->toArray();

        $clientUserRole = array(CLIENT_ADMIN, CLIENT_VIEW, CLIENT_BASIC);
    	$clientUsers = $this->Users->find()
        ->select(['Users.id', 'username', 'active', 'role_id', 'Roles.role_title', 'ClientUsers.id', 'ClientUsers.pri_contact_fn', 'ClientUsers.pri_contact_ln', 'ClientUsers.user_id', 'Clients.company_name'])
        ->where(['Users.role_id IN'=>$clientUserRole])->contain(['Roles','ClientUsers','ClientUsers.Clients'])->toArray();

    	$contractors = $this->Users->find()
        ->select(['Users.id', 'username', 'active', 'role_id', 'Roles.role_title', 'Contractors.id', 'Contractors.pri_contact_fn', 'Contractors.pri_contact_ln', 'Contractors.user_id', 'Contractors.company_name'])
        ->where(['Users.role_id'=>CONTRACTOR])->contain(['Roles', 'Contractors'])->toArray();

    	$contractorUsers = $this->Users->find()
        ->select(['Users.id', 'username', 'active', 'role_id', 'Roles.role_title', 'ContractorUsers.id', 'ContractorUsers.pri_contact_fn', 'ContractorUsers.pri_contact_ln', 'ContractorUsers.user_id', 'Contractors.company_name'])
        ->where(['Users.role_id'=>CONTRACTOR_ADMIN])->contain(['Roles', 'ContractorUsers', 'ContractorUsers.Contractors'])->toArray();

    	$employees = $this->Users->find()
        ->select(['Users.id', 'username', 'active', 'role_id', 'Roles.role_title', 'Employees.id','Employees.pri_contact_fn', 'Employees.pri_contact_ln','Employees.user_id', 'Contractors.company_name'])
        ->where(['Users.role_id'=>EMPLOYEE])->contain(['Roles','Employees','Employees.Contractors'])->toArray();

        if ($this->request->is(['patch', 'post', 'put'])) {
	        $this->viewBuilder()->setLayout('ajax');
            $role_id = $this->request->getData('role_id');
            $user_details = [];
            if(in_array($role_id, $adminRole) || $role_id == CR) {
                $user = $this->Users->get($this->request->getData('id'));
            }
            elseif($role_id == CLIENT) {
                $user = $this->Users->get($this->request->getData('id'), ['contain' => ['Clients']]);
                $user_details = $user->client;               
            }
            elseif($role_id == CONTRACTOR) {
                $user = $this->Users->get($this->request->getData('id'), ['contain' => ['Contractors']]);
                $user_details = $user->contractor;
            }              
            elseif($role_id == EMPLOYEE) {
                $user = $this->Users->get($this->request->getData('id'), ['contain' => ['Employees', 'Employees.Contractors']]);
                if($user->has('employee')) {
                $user_details = ['pri_contact_fn'=>$user->employee->pri_contact_fn, 'company_name'=>$user->employee->contractor->company_name];
                }
            }
            elseif(in_array($role_id, $clientUserRole)) {
                $user = $this->Users->get($this->request->getData('id'), ['contain' => ['ClientUsers','ClientUsers.Clients']]);
                if($user->has('client_user')) {
                $user_details = ['pri_contact_fn'=>$user->client_user->pri_contact_fn, 'company_name'=>$user->client_user->client->company_name];
                }                          
            }
            elseif($role_id == CONTRACTOR_ADMIN) {
                $user = $this->Users->get($this->request->getData('id'), ['contain' => ['ContractorUsers', 'ContractorUsers.Contractors']]);
                if($user->has('contractor_user')) {
                $user_details = ['pri_contact_fn'=>$user->contractor_user->pri_contact_fn, 'company_name'=>$user->contractor_user->contractor->company_name];
                }               
            }

            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                echo '<div class="alert with-close alert-success alert-dismissible fade show" role="alert">The user has been saved.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';            
    		    //if($user->active==1) {
    			    //$this->getMailer('User')->send('register_approve', [$user, $user_details]);
    		    //}
    	    }
    	    else {
    		    echo '<div class="alert with-close alert-danger alert-dismissible fade show" role="alert">The user could not be saved. Please, try again.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
    	    }
    	    exit;
            }

        $this->set(compact('users','clients','clientUsers','contractors','contractorUsers','employees','cr'));
	}
	else{		
		$this->Flash->error(__('You are not authorized to access that location.'));
		$this->redirect(['controller' => 'Users', 'action' => 'login']);
	}*/
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Roles']
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $user->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $roles = $this->Users->Roles->find('list', ['keyField' => 'id', 'valueField' => 'role_title'])->where(['role_title IN'=>['Admin', 'Developer']]);
        $this->set(compact('user', 'roles'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $user->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');

            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $roles = $this->Users->Roles->find('list', ['keyField' => 'id', 'valueField' => 'role_title'])->where(['role_title'=>'Admin']);
        $this->set(compact('user', 'roles'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
		
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function login($login_secret_key=null)
    {
	$this->viewBuilder()->setLayout('login');
	
	$cookie = ['username'=>'', 'password'=>'', 'remember_me'=>0];
	if ($this->Cookie->read('cq_remember_me')) {
		$cookie = $this->Cookie->read('cq_remember_me');
	}

	if($login_secret_key!==null) {
		$user = $this->Users->find()->where(['login_secret_key'=>$login_secret_key])->enableHydration(false)->first();
		if(!empty($user)) {
			$this->Auth->setUser($user);

			$role = $this->Users->Roles->get($user['role_id'])->toArray();
			$this->getRequest()->getSession()->write('Auth.User.role', $role['role_title']);
			
			// set user session
			$this->User->setUserSession($user);	
			
			// if redirect 			
			$redirect = $this->request->getQuery('redirect');
			if($redirect!='') {
				return $this->redirect($redirect);
			}

			// redirect to dashboard
			$this->User->redirectOnlogin();	
		}
		else {
			$this->Flash->error('Login url has been expired!');
			return $this->redirect(['action' => 'login']);
		}
	}
	
    if ($this->request->is('post')) {
	// login with old password
	$user1 = $this->Users->find()->where(['username' => $this->request->getData('username'),'old_password' => sha1($this->request->getData('password'))])->first();
	if(isset($user1) && !empty($user1))
	{
		$hasher = new DefaultPasswordHasher();
		$secret_key = Security::hash(Security::randomBytes(32), 'sha256', false);	
		$user1->secret_key = $secret_key;
		$this->Users->save($user1);
		return $this->redirect(array("controller" => "Users","action" => "resetPassword", $secret_key));			 	
	}

	// login
	$user = $this->Auth->identify();
    //pr($user);die;
	if ($user) {
		/*if($user['active']==false) {
			$this->Flash->error('User is not active.');
			return $this->redirect(['action' => 'login']);
		}*/
		
		if($user['role_id'] == CONTRACTOR) {
		$contractor = $this->Users->Contractors->find('all')->where(['user_id' => $user['id']])->first();	
		$subscription_date = date('Y-m-d', strtotime($contractor['subscription_date']));
		$todayDate = date('Y-m-d');
		if($subscription_date > $todayDate && $user['active']==false ){
				return $this->redirect(['action' => 'inactive_user_msg']);
			}
		}elseif(in_array($user['role_id'],CONTRACTOR_USERS)){
			$getContUser = $this->Users->ContractorUsers->find('all')
			->contain(['Contractors'=>['fields'=>['id', 'pri_contact_fn','pri_contact_ln']] ])
			->contain(['Contractors.Users'=>['fields'=>['id', 'role_id','active']] ])
			->where(['ContractorUsers.user_id' => $user['id']])->first();
			
		$masterUser = $getContUser->contractor->user;			
			if($masterUser['active']==false ){
				return $this->redirect(['action' => 'inactive_user_msg',$masterUser['id']]);
			}			
		}elseif(in_array($user['role_id'],CLIENT_USERS)){
			/*$getClientUser = $this->Users->ClientUsers->find('all')
			->contain(['Clients'=>['fields'=>['id', 'pri_contact_fn','pri_contact_ln']] ])
			->contain(['Clients.Users'=>['fields'=>['id', 'role_id','active']] ])
			->where(['ClientUsers.user_id' => $user['id']])->first();
			
		$masterUser = $getClientUser->client->user;	*/
        $getUser = $this->Users->find()->contain(['ClientUsers'])->where(['Users.id' => $user['id']])->first();
         
        $getPrimaryClient = $this->Users->ClientUsers->find('all') 
            ->contain(['Users'])        
            ->where(['client_id' => $getUser['client_user']['client_id'],'Users.role_id'=>CLIENT])->first();

        $masterUser = $getPrimaryClient['user'];

			if($masterUser['active']==false ){
				return $this->redirect(['action' => 'inactive_user_msg',$masterUser['id']]);
			}			
		}
		else{
			if($user['active']==false) {
			//$this->Flash->error('User is not active.');
			return $this->redirect(['action' => 'inactive_user_msg']);
			}
		}

		$this->Auth->setUser($user);
		$id = $user['id'];
		$userupdate = $this->Users->get($id, [
			'contain' => []
		]);
		$userupdate->last_login = date(DATE_ATOM);
		$this->Users->save($userupdate);			

		// if remember_me
		if($this->request->getData('remember_me') == 1)	{			
			$this->Cookie->write('cq_remember_me', $this->request->getData());
		}
		else {
			$this->Cookie->delete('cq_remember_me');
		}

		$role = $this->Users->Roles->get($user['role_id'])->toArray();
		$this->getRequest()->getSession()->write('Auth.User.role', $role['role_title']);
		
		// set user session
		$this->User->setUserSession($user);		
		
		// if redirect 
		$redirect = $this->request->getQuery('redirect');
		if($redirect!='') { return $this->redirect($redirect); }

		// redirect to dashboard
		$this->User->redirectOnlogin();
     	}
     	else { // if user
		$this->Flash->error('Your username or password is incorrect.');
		}
    } // if post
    else {
	$this->User->redirectOnlogin();
    }
	$this->set(compact('cookie'));
    }
	
    /*public function loginAs()
    {
	$clientList = $this->Users->find('list', ['keyField'=>'username', 'valueField'=>'client.company_name'])->where(['role_id' => CLIENT, 'active'=>true, 'company_name !='=>''])->contain(['Clients'])->order(['company_name'])->toArray();

	$contractorList = $this->Users->find('list', ['keyField'=>'username', 'valueField'=>'contractor.company_name'])->where(['role_id' => CONTRACTOR, 'company_name !='=>''])->contain(['Contractors'])->order(['company_name'])->toArray();	

    $employeeList = $this->Users->find('list', ['keyField'=>'username', 'valueField'=>'username'])->where(['role_id' => EMPLOYEE, 'is_login_enable' =>true,'user_entered_email'=>true])->contain(['Employees'])->order(['username'])->toArray(); 
    $employeeList1 = $this->Users->find('list', ['keyField'=>'id', 'valueField'=>'login_username'])->where(['role_id' => EMPLOYEE, 'is_login_enable' =>true,'has_email'=>false])->contain(['Employees'])->order(['username'])->toArray(); 

    $crList = $this->Users->find('list', ['keyField'=>'username', 'valueField'=>'username'])->where(['role_id' => CR, 'active'=>true])->order(['username'])->toArray();

    $adminList = $this->Users->find('list', ['keyField'=>'username', 'valueField'=>'username'])->where(['role_id' => ADMIN, 'active'=>true])->order(['username'])->toArray();

    $contractorUserList = $this->Users->find('list', ['keyField'=>'username', 'valueField'=>'username'])->where(['role_id' => CONTRACTOR_ADMIN, 'active'=>true])->order(['username'])->toArray();	
	if(!empty($contractorUserList)){
	foreach($contractorUserList as $key =>$contractorUser){
		$getUser = $this->Users->find()->where(['username' => $contractorUser])->first();
		$getContUser = $this->Users->ContractorUsers->find('all')
			->contain(['Contractors'=>['fields'=>['id', 'pri_contact_fn','pri_contact_ln']] ])
			->contain(['Contractors.Users'=>['fields'=>['id', 'role_id','active']] ])
			->where(['ContractorUsers.user_id' => $getUser['id']])->first();
		$masterUser = $getContUser['contractor']['user'];
		if($masterUser['active']==false){ 
		 unset($contractorUserList[$key]);
		}		
	}}
    $clientUserList = $this->Users->find('list', ['keyField'=>'username', 'valueField'=>'username'])
        ->where([['OR'=>['AND'=>
					 ['role_id' => CLIENT_ADMIN],
					 ['role_id' => CLIENT_VIEW],
                     ['role_id' => CLIENT_BASIC]
	     ] ], 'active'=>true])->order(['username'])->toArray();
	
	if(!empty($clientUserList)){
	foreach($clientUserList as $key =>$clientUser){
		$getUser = $this->Users->find()->where(['username' => $clientUser])->first();
		$getClientUser = $this->Users->ClientUsers->find('all')
			->contain(['Clients'=>['fields'=>['id', 'pri_contact_fn','pri_contact_ln']] ])
			->contain(['Clients.Users'=>['fields'=>['id', 'role_id','active']] ])
			->where(['ClientUsers.user_id' => $getUser['id']])->first();
		
		$masterUser = $getClientUser['client']['user'];
		if($masterUser['active']==false){ 
		 unset($clientUserList[$key]);
		}		
	}}
	
	$currentLogin = $this->getRequest()->getSession()->read('Auth.User');
	
	if ($this->request->is('post')) {
        $role_id = explode(",",$this->request->getData('role_id'));   
        if(empty($this->request->getData('username'))) {
            $user = $this->Users->find()->where(['id'=>$this->request->getData('id'), 'role_id IN'=>$role_id])->enableHydration(false)->first();
        } else{ 
		$user = $this->Users->find()->where(['username'=>$this->request->getData('username'), 'role_id IN'=>$role_id])->enableHydration(false)->first();
        }
       
		$this->Auth->setUser($user);
		$this->getRequest()->getSession()->write('Auth.User.lastlogin', $currentLogin);
		$role = $this->Users->Roles->get($user['role_id'])->toArray();
		$this->getRequest()->getSession()->write('Auth.User.role', $role['role_title']);
		
		// set user session
		$this->User->setUserSession($user);	
		
		// redirect to dashboard
		$this->User->redirectOnlogin();		
	}
	$this->set(compact('clientList','contractorList','crList','adminList','clientUserList','contractorUserList','employeeList','employeeList1'));
    }*/

    public function loginAs()
    {
    $clientList = $this->Users->find('list', ['keyField'=>'username', 'valueField'=>'client_user.client.company_name'])->where(['role_id' => CLIENT, 'active'=>true,])->contain(['ClientUsers'])->contain(['ClientUsers.Clients'])->order(['company_name'])->toArray();

    $contractorList = $this->Users->find('list', ['keyField'=>'username', 'valueField'=>'contractor.company_name'])->where(['role_id' => CONTRACTOR, 'company_name !='=>''])->contain(['Contractors'])->order(['company_name'])->toArray(); 

    $employeeList = $this->Users->find('list', ['keyField'=>'username', 'valueField'=>'username'])->where(['role_id' => EMPLOYEE, 'is_login_enable' =>true,'user_entered_email'=>true])->contain(['Employees'])->order(['username'])->toArray(); 
    $employeeList1 = $this->Users->find('list', ['keyField'=>'id', 'valueField'=>'login_username'])->where(['role_id' => EMPLOYEE, 'is_login_enable' =>true,'has_email'=>false])->contain(['Employees'])->order(['username'])->toArray(); 

    $crList = $this->Users->find('list', ['keyField'=>'username', 'valueField'=>'username'])->where(['role_id' => CR, 'active'=>true])->order(['username'])->toArray();

    $adminList = $this->Users->find('list', ['keyField'=>'username', 'valueField'=>'username'])->where(['role_id' => ADMIN, 'active'=>true])->order(['username'])->toArray();

    $contractorUserList = $this->Users->find('list', ['keyField'=>'username', 'valueField'=>'username'])->where(['role_id' => CONTRACTOR_ADMIN, 'active'=>true])->order(['username'])->toArray();   
    if(!empty($contractorUserList)){
    foreach($contractorUserList as $key =>$contractorUser){
        $getUser = $this->Users->find()->where(['username' => $contractorUser])->first();
        $getContUser = $this->Users->ContractorUsers->find('all')
            ->contain(['Contractors'=>['fields'=>['id', 'pri_contact_fn','pri_contact_ln']] ])
            ->contain(['Contractors.Users'=>['fields'=>['id', 'role_id','active']] ])
            ->where(['ContractorUsers.user_id' => $getUser['id']])->first();

        if( isset($getContUser['contractor']['user']) ) $masterUser = $getContUser['contractor']['user'];
        if(isset($masterUser['active']) && $masterUser['active']==false){ 
         unset($contractorUserList[$key]);
        }       
    }}
    $clientUserList = $this->Users->find('list', ['keyField'=>'username', 'valueField'=>'username'])
        ->where([['OR'=>['AND'=>
                     ['role_id' => CLIENT_ADMIN],
                     ['role_id' => CLIENT_VIEW],
                     ['role_id' => CLIENT_BASIC]
         ] ], 'active'=>true])->order(['username'])->toArray();
    
    if(!empty($clientUserList)){
        foreach($clientUserList as $key =>$clientUser){
            $getUser = $this->Users->find()->contain(['ClientUsers'])->where(['username' => $clientUser])->first();
            
            if( isset($getUser['client_user']['client_id']) ) {
                $getPrimaryClient = $this->Users->ClientUsers->find('all') 
                    ->contain(['Users'])        
                    ->where(['client_id' => $getUser['client_user']['client_id'],'Users.role_id'=>CLIENT])->first();

                $masterUser = $getPrimaryClient['user'];
                if($masterUser['active']==false){ 
                unset($clientUserList[$key]);
                }
            }       
        }
    }
    
    $currentLogin = $this->getRequest()->getSession()->read('Auth.User');
    
    if ($this->request->is('post')) {
        $role_id = explode(",",$this->request->getData('role_id'));   
        if(empty($this->request->getData('username'))) {
            $user = $this->Users->find()->where(['id'=>$this->request->getData('id'), 'role_id IN'=>$role_id])->enableHydration(false)->first();
        } else{ 
        $user = $this->Users->find()->where(['username'=>$this->request->getData('username'), 'role_id IN'=>$role_id])->enableHydration(false)->first();
        }
       
        $this->Auth->setUser($user);
        $this->getRequest()->getSession()->write('Auth.User.lastlogin', $currentLogin);
        $role = $this->Users->Roles->get($user['role_id'])->toArray();
        $this->getRequest()->getSession()->write('Auth.User.role', $role['role_title']);
        
        // set user session
        $this->User->setUserSession($user); 
        
        // redirect to dashboard
        $this->User->redirectOnlogin();     
    }
    $this->set(compact('clientList','contractorList','crList','adminList','clientUserList','contractorUserList','employeeList','employeeList1'));
    }
	
    public function backtoAdmin()
    {
	$lastLogin = $this->getRequest()->getSession()->read('Auth.User.lastlogin');	
	$this->Auth->setUser($lastLogin);		
	$this->User->redirectOnlogin();
    }

    public function forgotPassword()
    {
	$this->viewBuilder()->setLayout('login');

        if ($this->request->is(['post'])) {

            $user = $this->Users->findByUsername($this->request->getData('username'))->first();
            if (empty($user)) {
                $this->Flash->error('Sorry, this email address is not registered with us. If you still think you have already registered, please email us at support@canqualify.com. Our support team will help you further.');
            } else {
		$hasher = new DefaultPasswordHasher();
		$secret_key = Security::hash(Security::randomBytes(32), 'sha256', false);	// Generate an API 'token'
		//$secret = $hasher->hash($secret_key);		// Bcrypt the token so BasicAuthenticate can check it during login.

		$user = $this->Users->patchEntity($user, $this->request->getData());
		$user->secret_key = $secret_key;
		if ($this->Users->save($user)) {
			$url = Router::Url(['controller' => 'users', 'action' => 'reset-password'], true) . '/' . $secret_key;

			$user->reset_url = $url;
			$this->getMailer('User')->send('resetpassword', [$user]);

			$this->Flash->success(__('Thank you for your patience.'));
			return $this->redirect(['controller'=> 'users', 'action' => 'forgot-password']);
		}
		$this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
	}
    }

    public function resetPassword($secretKey=null,$setnew=null)
    {
	$this->viewBuilder()->setLayout('login');

	$user = $this->Users->findBySecretKey($secretKey)->first();

	if(empty($user)) {
                return $this->redirect(['action' => 'login']);
	}

	if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $user->secret_key = '';
            $user->old_password = '';
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Password updated successfully!'));
                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error(__('Password could not be updated. Please, try again.'));
        }

        $this->set(compact('user','setnew'));
    }

    // Contractor Register
    public function register($cli_id = null)
    {
            $this->viewBuilder()->setLayout('default');
    $this->loadModel('Contractors');
    $this->loadModel('Leads');  
    $this->loadModel('CustomerRepresentative');
    $this->loadModel('Countries');
    $this->loadModel('States');
    $this->loadModel('ContractorTempclients');
    $this->loadModel('Clients');
    

        $states = $this->Contractors->States->find('list')->where(['user_entered'=>false])->toArray();
        $countries = $this->Contractors->Countries->find('list')->where(['user_entered'=>false])->toArray();
        $clients = $this->Clients->find('list', ['keyField'=>'id', 'valueField'=>'id' ])->toArray();
        $client_names = $this->Clients->find('list', ['keyField'=>'id', 'valueField'=>'company_name'])->toArray();
        //$defaultCR = $this->CustomerRepresentative->find('list',['keyField'=>'id','valueField'=>'id'])->where(['default_cr' => true])->first();

        $contractor = $this->Contractors->newEntity();
        $usecaptcha = Configure::read('google_recatpcha_settings.usecaptcha');
        $customer_rep_ids = Configure::read('Contractor_CR');
        $waiting_on = $this->User->waiting_status();

        if ($this->request->is('post')) {
            if((($this->request->getData(['country_id']) != null) || ($this->request->getData(['state_id']) != null)) && ($this->request->getData(['country_id']) == 0)){
                $user_entered = true; // User entered Country and State

                 /* User entered Country and State */ 
                $user = $this->Users->newEntity();
                $user = $this->Users->patchEntity($user, $this->request->getData(['user'])); 
                $user->role_id = CONTRACTOR;
                $user->created_by = 0;
                $user->active = true;

                if($user_result = $this->Users->save($user)) {

                    $country = $this->Countries->newEntity();
                    $country->name = $this->request->getData(['country']);
                    $country->created_by = $user_result->id;
                    $country->user_entered = $user_entered;
                    $country_result = $this->Countries->save($country);

                    $state = $this->States->newEntity();
                    $state->name = $this->request->getData(['state']);
                    $state->country_id = $country_result->id;
                    $state->user_entered = $user_entered;
                    $state->created_by = $user_result->id;
                    $state_result = $this->States->save($state);

                     // Leads status updating            
                    $whereleads = [
                        'OR' => ['company_name' => $contractor['company_name'],
                                ['phone_no'=> $contractor['pri_contact_pn']],
                                ['email'=> $contractor->user['username']]
                        ]];            
                    $leads = $this->Leads->find("all")->where($whereleads)->toArray();
                    foreach($leads as $value){
                        $leads = TableRegistry::get('Leads');
                        $query = $leads->query();
                        $query->update()->set(['lead_status_id' => 6])->where(['id' => $value['id']])->execute();
                    }
                    // End Lead status

                    $contractorData = $this->request->getData();  
                    unset($contractorData['user']); 

                    $contractor = $this->Contractors->patchEntity($contractor, $contractorData);
                    $contractor->user_id = $user_result->id;
                    $contractor->country_id = $country_result->id;
                    $contractor->state_id = $state_result->id;
                    $contractor->registration_status = 1;
                    $contractor->waiting_on = $waiting_on['Contractor'];
                    $contractor->customer_representative_id = ['cr_ids' => array_values($customer_rep_ids)];
                    //$contractor->customer_representative_id = $defaultCR;

                    /*format tin before save*/
                    if($contractor->company_tin) {
                        $contractor->company_tin = preg_replace("/[^0-9.]/", '', $contractor->company_tin);
                    }

                    if ($result = $this->Contractors->save($contractor)) {

                    $userDt = $this->Users->find()->where(['id'=>$user->id])->enableHydration(false)->first();
                    $this->Auth->setUser($userDt);

                    $role = $this->Users->Roles->get($user['role_id'])->toArray();
                    $this->getRequest()->getSession()->write('Auth.User.role', $role['role_title']);
                    
                    $this->getRequest()->getSession()->write('Auth.User.contractor_id', $contractor->id);
                    $this->getRequest()->getSession()->write('Auth.User.registration_status', $contractor->registration_status);
                    $this->getRequest()->getSession()->write('Auth.User.company_logo', $contractor->company_logo); 
                    $this->getRequest()->getSession()->write('Auth.User.emp_req', $contractor->emp_req); 

                    /* save contractor_answers */
                    $this->User->update_contractor_ans($this->request->getData(), $contractor->id, $user->id);
                                      
                    $this->getMailer('User')->send('register', [$contractor->user]);
                    //$this->Flash->success(__('Congratulations!'));
                    //return $this->redirect(['action' => 'thankYou']);

                    //$this->getMailer('User')->send('register_contractor', [$user]);

                    return $this->redirect(['controller' => 'ContractorClients', 'action' => 'add']);
                    }
                }

                $this->Flash->error(__('The Supplier could not be registered. Please, try again.'));
                return $this->redirect(['controller' => 'Users', 'action' => 'register']);
           
            } else { // Normal save Users
           
            if($usecaptcha==1 && !$this->verifyRecatpcha($this->request->getData())) {
                $this->Flash->error(__('Invalid Captcha. Please, try again.'),array('class' => 'alert alert-danger'));
                return  $this->redirect(array("controller" => "Users","action" => "register"));
            }

            $contractor = $this->Contractors->patchEntity($contractor, $this->request->getData());            
            $contractor->user->role_id = CONTRACTOR;
            $contractor->user->created_by = 0;
            $contractor->user->active = true;
            $contractor->registration_status = 1;
            $contractor->waiting_on = $waiting_on['Contractor'];
            $contractor->customer_representative_id = ['cr_ids' => array_values($customer_rep_ids)];
            //$contractor->customer_representative_id = $defaultCR;

            // Leads status updating            
            $whereleads = [
                'OR' => ['company_name' => $contractor['company_name'],
                        ['phone_no'=> $contractor['pri_contact_pn']],
                        ['email'=> $contractor->user['username']]
                ]];            
            $leads = $this->Leads->find("all")->where($whereleads)->toArray();
            foreach($leads as $value){
                $leads = TableRegistry::get('Leads');
                $query = $leads->query();
                $query->update()->set(['lead_status_id' => 6])->where(['id' => $value['id']])->execute();
            }
            // End Lead status
            /*format tin before save*/
                if($contractor->company_tin) {
                    $contractor->company_tin = preg_replace("/[^0-9.]/", '', $contractor->company_tin);
                }

            if ($result = $this->Contractors->save($contractor)) {
                $userDt = $this->Users->find()->where(['id'=>$contractor->user->id])->enableHydration(false)->first();
                $this->Auth->setUser($userDt);

                $role = $this->Users->Roles->get($contractor->user->role_id)->toArray();
                $this->getRequest()->getSession()->write('Auth.User.role', $role['role_title']);
                
                $this->getRequest()->getSession()->write('Auth.User.contractor_id', $contractor->id);
                $this->getRequest()->getSession()->write('Auth.User.registration_status', $contractor->registration_status);
                $this->getRequest()->getSession()->write('Auth.User.company_logo', $contractor->company_logo);
                $this->getRequest()->getSession()->write('Auth.User.emp_req', $contractor->emp_req);  

                /* save contractor_answers */
                $this->User->update_contractor_ans($this->request->getData(), $contractor->id, $contractor->user->id);
                if($cli_id !=  null) { 
                       //$key = 'wt1U5MACWJFTXGenFoZoiLwQGrLgdbHA';
                       //$client_id = Security::decrypt($cli_id, $key);
                	 $client_id = hex2bin($cli_id);
                }
                // if($client_id != 4){
                //  $this->User->associateWithMarketplace($contractor->id); 
                // }
                 if($cli_id !=  null) {   
                       if(in_array($client_id, $clients)){ 
                        $tempclient = $this->ContractorTempclients->newEntity();
                        $tempclient->client_id = $client_id;
                        $tempclient->contractor_id = $contractor->id;
                        $tempclient->created_by = $this->getRequest()->getSession()->read('Auth.User.id');

                        $this->ContractorTempclients->save($tempclient); 
                        if($contractor->registration_status == 1) {
                            $contractor->registration_status = 2;
                            $this->Contractors->save($contractor);
                         }   
                        if($client_id == 4){
                            return $this->redirect(['controller' => 'ContractorClients', 'action' => 'add',$client_id]);  
                        }else{
                        return $this->redirect(['controller' => 'Payments', 'action' => 'checkout']);     
                        }        
                   } }              
                $this->getMailer('User')->send('register', [$contractor->user]);
                //$this->Flash->success(__('Congratulations!'));
                //return $this->redirect(['action' => 'thankYou']);

                //$this->getMailer('User')->send('register_contractor', [$contractor->user]);

                return $this->redirect(['controller' => 'ContractorClients', 'action' => 'add']);

            }

            $this->Flash->error(__('The Supplier could not be registered. Please, try again.'));
            }
        }
        $this->set(compact('contractor', 'states', 'countries', 'usecaptcha', 'client_names'));
 
   }
    public function myProfile()
    {
	    $id = $this->getRequest()->getSession()->read('Auth.User.id');
	    $user = $this->Users->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $user->modified_by = $id;
            if ($this->Users->save($user)) {
                if(null !== $this->request->getData('password')){
                    $this->Flash->success(__('Paswword has been updated successfully. Please, login again.'));
		            return $this->redirect(['action' => 'logout']);
                }
				
				if(null !== $this->request->getData('profile_photo')){
					$this->getRequest()->getSession()->write('Auth.User.profile_photo', $user->profile_photo);
					$this->set('activeUser', $this->getRequest()->getSession()->read('Auth.User'));
				}
                $this->Flash->success(__('Profile has been saved.'));
		        return $this->redirect(['action' => 'my-profile']);
            }
            $this->Flash->error(__('Profile could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    public function changePassword()
    {
	    $id = $this->getRequest()->getSession()->read('Auth.User.id');
	    $user = $this->Users->get($id, [
            'fields' => ['id','username'],
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {			
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $user->modified_by = $id;
            if ($this->Users->save($user)) {
                $this->getRequest()->getSession()->destroy();
                $this->Flash->success(__('Paswword has been updated successfully. Please, login again.'));
		        return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error(__('Paswword could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    public function thankYou()
    {
	$this->viewBuilder()->setLayout('login');
    }

    public function settings()
    {
	    $id = $this->getRequest()->getSession()->read('Auth.User.id');
	    $user = $this->Users->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $user->modified_by = $id;

            if ($this->Users->save($user)) {
                if(null !== $this->request->getData('password')){
                    $this->Flash->success(__('Paswword has been updated successfully. Please, login again.'));
		            return $this->redirect(['action' => 'logout']);
                }
                $this->Flash->success(__('Profile has been saved.'));
        		return $this->redirect(['action' => 'my-profile']);
            }
            $this->Flash->error(__('Profile could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    public function logout()
    {
	    $this->viewBuilder()->setLayout('login');

	    $this->Flash->success('You are now logged out.');
	    return $this->redirect($this->Auth->logout());
    }

    public function dashboard() //admin dashboard
    {
	$this->loadModel('Contractors');
	$this->loadModel('Clients');
	$this->loadModel('OverallIcons');

	//unset contractor & client
	$this->getRequest()->getSession()->delete('Auth.User.contractor_id');
	$this->getRequest()->getSession()->delete('Auth.User.contractor_company_name');

	$this->getRequest()->getSession()->delete('Auth.User.client_id');
	$this->getRequest()->getSession()->delete('Auth.User.client_company_name');
	//$this->User->unsetUserSession();	

	$contractors = $this->Contractors
		->find()
		->select(['company_name', 'addressline_1', 'addressline_2', 'city', 'state_id', 'country_id', 'zip', 'latitude', 'longitude'])
		->contain(['States'=> ['fields'=>['name']]])
		->contain(['Countries'=> ['fields'=>['name']]])
		->all();

	$clients = $this->Clients
		->find()
		->select(['id', 'company_name'])
		->contain(['Sites'=> ['fields'=>['client_id', 'addressline_1', 'addressline_2', 'city', 'state_id', 'country_id', 'zip', 'latitude', 'longitude']]])
		->contain(['Sites.States'=> ['fields'=>['name']]])
		->contain(['Sites.Countries'=> ['fields'=>['name']]])
		->all();

        $matrix = $this->OverallIcons
		->find()
		->select('icon')
		->distinct('contractor_id')
		->order(['contractor_id', 'OverallIcons.created'=>'DESC'])
		->enableHydration(false)
		->toArray();

		$iconGray = 0;
		$iconGreen = 0;
		$iconRed = 0;
		$iconYellow = 0;
		foreach($matrix as $chart) {
			if ($chart['icon']==0) { $iconGray++;  }
			elseif ($chart['icon']==1) { $iconRed++;  }
			elseif ($chart['icon']==2) { $iconYellow++; }
			else { $iconGreen++; }
		}
		$pieChart = array($iconGreen, $iconYellow, $iconRed, $iconGray);

		$this->set(compact('contractors', 'clients', 'pieChart'));
    }

    public function diagnostics()
    {			
	$users = $this->Users->find('all')
        ->select(['id','username','role_id'])		
		->contain(['Contractors'])
		->contain(['CustomerRepresentative'])
		->contain(['ClientUsers'])
		->contain(['Employees'])
		->contain(['Roles'=>['fields'=> ['id','name'] ]])
		->where(['Contractors.user_id IS'=>null, 'CustomerRepresentative.user_id IS'=>null, 'ClientUsers.user_id IS'=>null, 'Employees.user_id IS'=>null, 'role_id !='=>SUPER_ADMIN])
		->toArray();

	$this->set(compact('users'));
    }

    public function deleteDiagnostics($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'diagnostics']);
    }

    public function resetPasswordUsers() {  
    	$users = $this->Users->find('list',['keyField'=>'id','valueField'=>'username'])->toArray();
    	$url = Router::Url(['controller' => 'users', 'action' => 'login'], true);

    	if ($this->request->is(['patch', 'post', 'put'])) {	

    		$uMail['password']  = $this->request->getData('password');    	
    		$hasher = new DefaultPasswordHasher();
    	    $newPass = $this->request->getData('username');
    	    $rpass   = $hasher->hash($this->request->getData('password')); 
    		
    		foreach ($users as $key => $value) {
    			if( $newPass == $key ){

    				$userstbl = TableRegistry::get('Users');
            		$query = $userstbl->query();
    				$query->update()->set(['password' =>$rpass ])->where(['id' => $key])->execute();
                    $uMail['username'] = $value;
                    $uMail['reset_url'] = $url;
    				$this->getMailer('User')->send('reset_password_users', [$uMail]);
    			}
    		}
    		
    		$this->Flash->success(__("User Password Changed and sent on registered email."));
    	}          
        
		$this->set(compact('users'));
	}
	public function inactiveUserMsg($user_id=null)
    {	
		$this->viewBuilder()->setLayout('login');
		
		if(!empty($user_id)){
			$user = $this->Users->get($user_id);
		 
			if($user['role_id']==CONTRACTOR){
				$contractor = $this->Users->Contractors->find()->where(['user_id' => $user['id']])->first(); 
				$this->set(compact('contractor'));
			}elseif($user['role_id']==CLIENT){
				$clientUser = $this->Users->ClientUsers->find()->where(['user_id' => $user['id']])->first(); 
			$this->set(compact('clientUser'));}
		}		
    }
     // Employee Registeration
    public function empRegister()
    {
    $this->viewBuilder()->setLayout('emp_register');
    $this->loadModel('Employees');  
    $this->loadModel('Countries');
    $this->loadModel('States');  
    $this->loadModel('Contractors');

        $states = $this->Employees->States->find('list')->where(['user_entered'=>false])->toArray();
        $countries = $this->Employees->Countries->find('list')->where(['user_entered'=>false])->toArray();

        //$defaultCR = $this->CustomerRepresentative->find('list',['keyField'=>'id','valueField'=>'id'])->where(['default_cr' => true])->first();

        $employee = $this->Employees->newEntity();
        $usecaptcha = Configure::read('google_recatpcha_settings.usecaptcha');      
        $waiting_on = $this->User->waiting_status();

        if ($this->request->is('post')) {
            if((($this->request->getData(['country_id']) != null) || ($this->request->getData(['state_id']) != null)) && ($this->request->getData(['country_id']) == 0)){
                $user_entered = true; // User entered Country and State

                 /* User entered Country and State */ 
                $user = $this->Users->newEntity();
                $user = $this->Users->patchEntity($user, $this->request->getData(['user']));                 
                $user->role_id = EMPLOYEE;
                $user->created_by = 0;
                $user->active = true;

                if($user_result = $this->Users->save($user)) {

                    $country = $this->Countries->newEntity();
                    $country->name = $this->request->getData(['country']);
                    $country->created_by = $user_result->id;
                    $country->user_entered = $user_entered;
                    $country_result = $this->Countries->save($country);

                    $state = $this->States->newEntity();
                    $state->name = $this->request->getData(['state']);
                    $state->country_id = $country_result->id;
                    $state->user_entered = $user_entered;
                    $state->created_by = $user_result->id;
                    $state_result = $this->States->save($state);
                   
                    $empData = $this->request->getData();  
                    unset($empData['user']); 

                    $employee = $this->Employees->patchEntity($employee, $empData);
                    $employee->user_id = $user_result->id;
                    $employee->country_id = $country_result->id;
                    $employee->state_id = $state_result->id;
                    $employee->registration_status = 1;
                    $employee->user_entered_email  = true;

                    if ($result = $this->Employees->save($employee)) {

                    $userDt = $this->Users->find()->where(['id'=>$user->id])->enableHydration(false)->first();
                    $this->Auth->setUser($userDt);

                    $role = $this->Users->Roles->get($user['role_id'])->toArray();
                    $this->getRequest()->getSession()->write('Auth.User.role', $role['role_title']);
                    
                    $this->getRequest()->getSession()->write('Auth.User.employee_id', $employee->id);
                    $this->getRequest()->getSession()->write('Auth.User.registration_status', $employee->registration_status);  
                    $this->getRequest()->getSession()->write('Auth.User.user_entered_email', $employee->user_entered_email);               
                                   
                    return $this->redirect(['controller' => 'Employees', 'action' => 'dashboard']);
                    }
                }

                $this->Flash->error(__('The Employee could not be registered. Please, try again.'));
                return $this->redirect(['controller' => 'Users', 'action' => 'emp_register']);
           
            } else { // Normal save Users
           
            if($usecaptcha==1 && !$this->verifyRecatpcha($this->request->getData())) {
                $this->Flash->error(__('Invalid Captcha. Please, try again.'),array('class' => 'alert alert-danger'));
                return  $this->redirect(array("controller" => "Users","action" => "emp_register"));
            }            
            $employee = $this->Employees->patchEntity($employee, $this->request->getData());                           
            $employee->user->role_id = EMPLOYEE;
            $employee->user->created_by = 0;
            $employee->user->active = true;
            $employee->registration_status = 1;
            $employee->created_by = 0;
            $employee->user_entered_email  = true;
// pr($employee);die;
            if ($result = $this->Employees->save($employee)) {
                $userDt = $this->Users->find()->where(['id'=>$employee->user->id])->enableHydration(false)->first();
                $this->Auth->setUser($userDt);

                $role = $this->Users->Roles->get($employee->user->role_id)->toArray();
                $this->getRequest()->getSession()->write('Auth.User.role', $role['role_title']);
                
                $this->getRequest()->getSession()->write('Auth.User.employee_id', $employee->id);
                $this->getRequest()->getSession()->write('Auth.User.registration_status', $employee->registration_status);
               $this->getRequest()->getSession()->write('Auth.User.user_entered_email', $employee->user_entered_email);
              

                return $this->redirect(['controller' => 'Employees', 'action' => 'dashboard']);

            }

            $this->Flash->error(__('The Employee could not be registered. Please, try again.'));
            }
        }
        $this->set(compact('employee', 'states', 'countries', 'usecaptcha'));
 
   }

   //Generate link for Client Landing Page 
   public function GenClientLandingPageLink($client_id)
   {
    $this->render(false);
   
    //$key = 'wt1U5MACWJFTXGenFoZoiLwQGrLgdbHA';
    //$id = Security::encrypt(11, $key);//place client id here
    $id = bin2hex($client_id);
    $url = Router::Url(['controller' => 'users', 'action' => 'register',$id]);
    echo $url;
   }
    /*public function contractorList()
    {
       ini_set('memory_limit','-1');
        $this->loadModel('Contractors');
        $this->loadModel('Clients');
        $contractor = $this->Contractors->newEntity();

        $users = $this->Users->newEntity();
        $contList = array();

        $allClients = $this->Clients->find('list', ['keyField'=>'id', 'valueField'=>'company_name' ])->toArray();
       
        $conn = ConnectionManager::get('default');
        $filterDate = '';
        $dt = date('Y-m-d', strtotime("+90 days"));

        $where = ' 1 = 1';

        if ($this->request->is(['patch', 'post', 'put'])) {
            if($this->request->getData('sub_date')!='')
            {
                $filterDate = $this->request->getData('sub_date');
                $dt = date('Y-m-d', strtotime("+".$filterDate." days"));

                $where .=" AND subscription_date <= '".$dt."'";
            }

            if(is_array($this->request->getData('user'))) {
                $this->viewBuilder()->setLayout('ajax');
          
                 $contractor = $this->Contractors->get($this->request->getData('id'), [
                    'contain'=>['Users']
                ]);
                $prevActive = $contractor->user->active;
                $contractor = $this->Contractors->patchEntity($contractor, $this->request->getData());              

                if ($this->Contractors->save($contractor)) {
                    echo '<div class="alert with-close alert-success alert-dismissible fade show" role="alert">The contractor has been saved.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
                }
                else {
                    echo '<div class="alert with-close alert-danger alert-dismissible fade show" role="alert">The contractor could not be saved. Please, try again.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
                }
                exit;
            }
        }
        $contList = $conn->execute("SELECT (subscription_date <= '".$dt."') as renew_subscription, contractors.*, users.id as uid, users.username, users.active
        FROM contractors Contractors 
        LEFT JOIN users Users ON Users.id = Contractors.user_id WHERE".$where)->fetchAll('assoc');
            // pr($contList);die;
       $this->set(compact('contList', 'users','contractor', 'filterDate','allClients'));
    }
    public function generateKey($contractor_id)
    {
        $this->loadModel('Contractors');
        $this->viewBuilder()->setLayout('ajax');   

        $contractor = $this->Contractors->get($contractor_id, ['contain'=>['Users']]);      
        $user = $this->Users->find()->where(['id' => $contractor['user_id']])->first();      
        
        if(isset($user) && empty($user['login_secret_key']))
        {
            $hasher = new DefaultPasswordHasher();
            $secret_key = Security::hash(Security::randomBytes(32), 'sha256', false);   
            $user->login_secret_key = $secret_key; 
            $this->Users->save($user);  
            $contractor = $this->Contractors->get($contractor_id, ['contain'=>['Users']]);  
            
            $this->set(compact('contractor'));
        }       
        $this->set(compact('contractor'));
    }*/
   /* public function associateWithMarketplace($contractor_id = null)
    {       
        $this->loadModel('Contractorclients');
        $this->loadModel('Payments');
        
        $contractor = $this->Contractors->get($contractor_id, ['contain'=>['Users']]);
        $contractor_id = $contractor->id;       

        $contclient = $this->Contractorclients->newEntity();
        $contclient->client_id = 4;
        $contclient->contractor_id = $contractor_id;
        $contclient->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
        $this->Contractorclients->save($contclient); 

        $services = $this->User->getContractorServices($contractor_id, true);
        $calculatePayment = $this->User->calculatePayment($contractor_id, $services);//pr($calculatePayment);die;

        $request_email = $contractor->user->username;
        $nvp_response_array = $this->dummyDetails($request_email);

        $payment = $this->Payments->newEntity();

        $payment->totalprice = $calculatePayment['final_price'];
        $payment->contractor_id = $contractor_id;
        $payment->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
        $payment->payment_type = 1;
        $payment->email = isset($nvp_response_array['EMAIL']) ? $nvp_response_array['EMAIL'] : '';
        if(!empty($nvp_response_array)) {
            $payment->response = json_encode($nvp_response_array);           
            $payment->transaction_status = isset($nvp_response_array['ACK']) ? $nvp_response_array['ACK'] : '';           
            $payment->p_timestamp = isset($nvp_response_array['TIMESTAMP']) ? $nvp_response_array['TIMESTAMP'] : '';            

        }else {
            $payment->transaction_status = 'Failure';
        } 
        if ($result = $this->Payments->save($payment)) {
        if ($result['transaction_status'] == 'Success' || $result['transaction_status'] == 'SuccessWithWarning') {
            // Set contractor payment_status and registration_status
            $subscription_date = $contractor->subscription_date;

            // contractor payment first time
            if($contractor->registration_status < 3) {
                $new_contractor = true;

                $contractor->payment_status = 1;
                $contractor->registration_status = 3;
                $this->getRequest()->getSession()->write('Auth.User.registration_status', 3);

                $subscription_date = date('Y-m-d', strtotime('+ 1 year')); //n/d/Y
            } 
            if($this->getRequest()->getSession()->read('Auth.User.active')==false){
            $this->Users->query()->update()->set(['active'=>true])
                    ->where(['id'=>$contractor->user_id])
                    ->execute();
                $this->getRequest()->getSession()->write('Auth.User.active', true);
            }
            $contractor->subscription_date = $subscription_date;
            $this->Contractors->save($contractor);

            $payment->subscription_date = $subscription_date;
            
            $paymentStartDate =  date('Y/m/d'); 
            $paymentEndDate = date('Y/m/d', strtotime($contractor['subscription_date']));       
            $payment->payment_start = $paymentStartDate;
            $payment->payment_end = $paymentEndDate;

            $payment = $this->Payments->save($payment);
        
            // save ContractorServices and paymentDetails
            $this->savePaymentDetails($calculatePayment, $result->id,$contractor_id);
            
            // set default icon
            $this->setDefaultIcon($contractor_id);

        }}

    }
    public function dummyDetails($response_email=null)
    {
        $now = Time::now();

        $nvp_response_array= array();
        $nvp_response_array['TIMESTAMP'] = $now;
        $nvp_response_array['ACK'] = 'Success';
        $nvp_response_array['EMAIL'] = $response_email ;
       
        return $nvp_response_array;
    }

    function savePaymentDetails($calculatePayment=array(), $payment_id=0,$contractor_id = null) {
    $this->loadModel('ContractorServices');
    $this->loadModel('PaymentDetails');

    foreach($calculatePayment['services'] as $service_id => $service) {       
            $contractorService = $this->ContractorServices->newEntity();
            $contractorService = $this->ContractorServices->patchEntity($contractorService, $service);
            $contractorService->client_ids =['c_ids' => array_values($service['client_ids'])];
            $contractorService->contractor_id = $contractor_id;
            $contractorService->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
            $this->ContractorServices->save($contractorService);         
     
        // save PaymentDetails
        $paymentDetail = $this->PaymentDetails->newEntity();
        $paymentDetail = $this->PaymentDetails->patchEntity($paymentDetail, $service);
        $paymentDetail->client_ids = ['c_ids' => array_values($service['client_ids'])]; 
        if(isset($service['price'])) { 
        $paymentDetail->product_price = $service['price'];
        $paymentDetail->discount = $service['discount'];
        $paymentDetail->price = $service['final_price'];
        }
        $paymentDetail->payment_id = $payment_id;
        $paymentDetail->created_by = $this->getRequest()->getSession()->read('Auth.User.id');

        $this->PaymentDetails->save($paymentDetail);
    }
    }
    function setDefaultIcon($contractor_id = null) {
    $this->loadModel('OverallIcons');
   
    $client_ids = $this->User->getClients($contractor_id);

    foreach($client_ids as $client_id) {
        $overallicons = $this->OverallIcons->find('all')->where(['contractor_id'=>$contractor_id, 'client_id'=>$client_id])->count();
        if($overallicons == 0){
            $overallIcon = $this->OverallIcons->newEntity();
            $overallIcon->client_id = $client_id;
            $overallIcon->contractor_id = $contractor_id;
            $overallIcon->bench_type = 'OVERALL';
            $overallIcon->icon = 0;
            $overallIcon->created_by = $this->getRequest()->getSession()->read('Auth.User.id');

            $this->OverallIcons->save($overallIcon);
        }
    }
    }*/

   /*redundant users*/
    public function redundantUsers(){
        $this->loadModel('Roles');
        $conn = ConnectionManager::get('default');
        /*canqualify_users query*/
        /*select users.id as user_id, users.username as username, canqualify_users.id as foreign_k, users.role_id as role_id
  from users
  left join canqualify_users on users.id = canqualify_users.user_id
  where users.role_id in(1,9,11) and canqualify_users.id is null*/

        $query = "select users.id as user_id, users.username as username, employees.id as foreign_k, 7 as role_id 
  from users
  left join employees on users.id = employees.user_id 
  where users.role_id = 7 and employees.id is null
  UNION
  select users.id as user_id, users.username as username, contractors.id as foreign_k, 2 as role_id 
  from users
  left join contractors on users.id = contractors.user_id 
  where users.role_id = 2 and contractors.id is null
  UNION
  select users.id as user_id, users.username as username, contractor_users.id as foreign_k, 8 as role_id 
  from users
  left join contractor_users on users.id = contractor_users.user_id 
  where users.role_id = 8 and contractor_users.id is null
  UNION
  select users.id as user_id, users.username as username, customer_representative.id as foreign_k, 8 as role_id 
  from users
  left join customer_representative on users.id = customer_representative.user_id 
  where users.role_id = 4 and customer_representative.id is null
  UNION
  select users.id as user_id, users.username as username, client_users.id as foreign_k, users.role_id as role_id 
  from users
  left join client_users on users.id = client_users.user_id 
  where users.role_id in(3,5,6,10) and client_users.id is null";
        $roles = array();
        $roles = $this->Roles->find('list', ['keyField' => 'id', 'valueField' => 'role_title'])->toArray();
        $empList = $conn->execute($query)->fetchAll('assoc');
        $this->set(compact('empList', 'roles'));
    }

    public function deleteUser($id = null){
        $this->loadModel('Users');
        $this->request->allowMethod(['post', 'delete']);

        $conn = ConnectionManager::get('default');
        $query = "delete from users where id = ".$id;
        $deleteUser = $conn->execute($query)->fetchAll('assoc');
        if (isset($deleteUser[0])) {
            $this->Flash->success(__('The user account has been deleted.'));
        } else {
            $this->Flash->error(__('The user account could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'redundantUsers']);


    }
}
