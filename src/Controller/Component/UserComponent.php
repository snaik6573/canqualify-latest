<?php
namespace App\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Controller\Component;
use Cake\Controller\Controller;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class UserComponent extends Component {
	public function getuser() {
		$this->controller = $this->_registry->getController();
		return $this->controller->getRequest()->getSession()->read('Auth.User');
	}

	public function isAdmin() {
		$this->controller = $this->_registry->getController();
		if($this->controller->getRequest()->getSession()->read('Auth.User.role_id') == SUPER_ADMIN || $this->controller->getRequest()->getSession()->read('Auth.User.role_id') == ADMIN) {
			return $this->controller->getRequest()->getSession()->read('Auth.User');
		}
		return false;
	}

	public function isClient() {
		$this->controller = $this->_registry->getController();
		$activeUser = $this->controller->getRequest()->getSession()->read('Auth.User');
		if($activeUser['role_id']== CLIENT || $activeUser['role_id'] == CLIENT_ADMIN || $activeUser['role_id'] == CLIENT_VIEW || $activeUser['role_id'] == CLIENT_BASIC) {
			return $activeUser;
		}
		return false;
	}
    public function isClientUser() {
        $this->controller = $this->_registry->getController();
        $activeUser = $this->controller->getRequest()->getSession()->read('Auth.User');
        if($activeUser['role_id'] == CLIENT_ADMIN || $activeUser['role_id'] == CLIENT_VIEW || $activeUser['role_id'] == CLIENT_BASIC) {
            return $activeUser;
        }
        return false;
    }

	public function isContractor() {
		$this->controller = $this->_registry->getController();		
		$activeUser = $this->controller->getRequest()->getSession()->read('Auth.User');
		if($activeUser['role_id']== CONTRACTOR || $activeUser['role_id'] == CONTRACTOR_ADMIN) {
			return $activeUser;
		}
		return false;
	}
	public function isCR() {
		$this->controller = $this->_registry->getController();
		if($this->controller->getRequest()->getSession()->read('Auth.User.role_id') == CR) {
			return $this->controller->getRequest()->getSession()->read('Auth.User');
		}
		return false;
	}
	public function isEmployee() {
		$this->controller = $this->_registry->getController();
		$activeUser = $this->controller->getRequest()->getSession()->read('Auth.User');
		if($activeUser['role_id']== EMPLOYEE) {
			return $activeUser;
		}
		return false;
	}
	
	public function setUserSession($user=array()) {		
		$this->controller = $this->_registry->getController();
		$this->Users = TableRegistry::get('Users');
		$activeUser = $this->controller->getRequest()->getSession()->read('Auth.User');
		if($activeUser['role_id'] == CONTRACTOR) {
			$getContractor = $this->Users->Contractors->find('all')->select(['id','registration_status','company_logo','company_name','emp_req'])->where(['user_id' => $user['id']])->first();
			if(!empty($getContractor)) {
			$this->controller->getRequest()->getSession()->write('Auth.User.contractor_id', $getContractor->id);
			$this->controller->getRequest()->getSession()->write('Auth.User.registration_status', $getContractor->registration_status);
			$this->controller->getRequest()->getSession()->write('Auth.User.company_logo', $getContractor->company_logo);
			$this->controller->getRequest()->getSession()->write('Auth.User.company_name', $getContractor->company_name);
			$this->controller->getRequest()->getSession()->write('Auth.User.emp_req', $getContractor->emp_req);
			}
		}
        elseif($activeUser['role_id'] == ADMIN) {
            $getAdmin = $this->Users->find('all')->select(['id'])->where(['id' => $user['id']])->first();
            if(!empty($getAdmin)) {
			$this->controller->getRequest()->getSession()->write('Auth.User.admin_id', $getAdmin->id);			
			}
		}
		elseif($activeUser['role_id'] == CLIENT) {
			/* Privious Code */
			// $getClient = $this->Users->Clients->find('all')->select(['id','company_logo','company_name'])->where(['user_id' => $user['id']])->first();	
		$getClient = $this->Users
	        ->find('all')
	        ->contain(['ClientUsers'=>['fields'=>['pri_contact_fn','pri_contact_ln']]])
	        ->contain(['ClientUsers.Clients'=>['fields'=>['id','company_name','company_logo']]])
	        ->where(['role_id'=>CLIENT,'ClientUsers.user_id'=>$user['id']])
	        ->first();
			if(!empty($getClient['client_user']['client'])) {
			$client = $getClient['client_user']['client'];
			$clientUser = $getClient['client_user'];
			$this->controller->getRequest()->getSession()->write('Auth.User.client_id', $client->id);
			$this->controller->getRequest()->getSession()->write('Auth.User.company_logo', $client->company_logo);
			$this->controller->getRequest()->getSession()->write('Auth.User.company_name', $client->company_name);
			$this->controller->getRequest()->getSession()->write('Auth.User.user_firstname', $clientUser->pri_contact_fn);
            $this->controller->getRequest()->getSession()->write('Auth.User.user_lastname', $clientUser->pri_contact_ln);
			}
		}
		elseif($activeUser['role_id'] == CLIENT_ADMIN || $activeUser['role_id'] == CLIENT_VIEW || $activeUser['role_id'] == CLIENT_BASIC){	
  			$getClient = $this->Users->ClientUsers->find('all')->select(['ClientUsers.id','client_id','site_ids','Clients.id','Clients.company_logo','Clients.company_name','ClientUsers.pri_contact_fn','ClientUsers.pri_contact_ln'])->contain(['Clients'])->where(['ClientUsers.user_id' => $user['id']])->first();
  			if(!empty($getClient) ) {
			$this->controller->getRequest()->getSession()->write('Auth.User.client_id', $getClient->client->id);
			$this->controller->getRequest()->getSession()->write('Auth.User.company_logo', $getClient->client->company_logo);
			$this->controller->getRequest()->getSession()->write('Auth.User.company_name', $getClient->client->company_name);
			$this->controller->getRequest()->getSession()->write('Auth.User.cadmin_id', $getClient->id);
			$this->controller->getRequest()->getSession()->write('Auth.User.cadmin_sites', $getClient->site_ids);
                $this->controller->getRequest()->getSession()->write('Auth.User.user_firstname', $getClient->pri_contact_fn);
                $this->controller->getRequest()->getSession()->write('Auth.User.user_lastname', $getClient->pri_contact_ln);
			}
		}
		elseif($activeUser['role_id'] == EMPLOYEE) {			
			/*$getEmployee = $this->Users->Employees->find('all')->select(['Employees.id', 'Employees.registration_status','Employees.user_entered_email','Contractors.company_name','Contractors.company_logo'])->contain(['Contractors'])->where(['Employees.user_id' =>
			$user['id']])->first();	*/
			$getEmployee = $this->Users->Employees->find('all')->select(['Employees.id', 'Employees.registration_status','Employees.user_entered_email'])->where(['Employees.user_id' =>
			$user['id']])->first();							
			if(!empty($getEmployee)){
			$this->controller->getRequest()->getSession()->write('Auth.User.employee_id', $getEmployee->id);
			$this->controller->getRequest()->getSession()->write('Auth.User.registration_status', $getEmployee->registration_status);
			$this->controller->getRequest()->getSession()->write('Auth.User.user_entered_email', $getEmployee->user_entered_email);
			//$this->controller->getRequest()->getSession()->write('Auth.User.company_name', $getEmployee->contractor->company_name);
			//$this->controller->getRequest()->getSession()->write('Auth.User.company_logo', $getEmployee->contractor->company_logo);
			}
		}
        elseif($activeUser['role_id'] == CR) {			
			$getCR = $this->Users->CustomerRepresentative->find('all')->select(['id','user_id'])->where(['user_id' =>
			$user['id']])->first();
            if(!empty($getCR)){
			$this->controller->getRequest()->getSession()->write('Auth.User.CR_id', $getCR->id);
			$this->controller->getRequest()->getSession()->write('Auth.User.user_id', $getCR->user_id);
			}
		}
		elseif($activeUser['role_id'] == CONTRACTOR_ADMIN) {			
			$getContractor = $this->Users->ContractorUsers->find('all')->select(['ContractorUsers.id','contractor_id','Contractors.id','Contractors.company_logo','Contractors.registration_status'])->contain(['Contractors'])->where(['ContractorUsers.user_id' => $user['id']])->first();
			if(!empty($getContractor)){
			$this->controller->getRequest()->getSession()->write('Auth.User.contractor_id', $getContractor->contractor_id);
			$this->controller->getRequest()->getSession()->write('Auth.User.company_logo', $getContractor->contractor->company_logo);
			$this->controller->getRequest()->getSession()->write('Auth.User.registration_status', $getContractor->contractor->registration_status);
		    $this->controller->getRequest()->getSession()->write('Auth.User.coadmin_id', $getContractor->id);			
			}
		}
		return false;
	}
	/*public function unsetUserSession() {		
		$this->controller = $this->_registry->getController();		
		$activeUser = $this->controller->getRequest()->getSession()->read('Auth.User');
		//pr($activeUser);die;
		if(in_array($activeUser['role_id'],ADMIN_ALL)) {
			//unset contractor & client
			$this->controller->getRequest()->getSession()->delete('Auth.User.contractor_id');
			$this->controller->getRequest()->getSession()->delete('Auth.User.contractor_company_name');

			$this->controller->getRequest()->getSession()->delete('Auth.User.client_id');
			$this->controller->getRequest()->getSession()->delete('Auth.User.client_company_name');
		}
		elseif(in_array($activeUser['role_id'],CONTRACTOR_USERS) ||$activeUser['role_id'] == CONTRACTOR) {
			//unset employee
			$this->controller->getRequest()->getSession()->delete('Auth.User.employee_id');
		}
		elseif(in_array($activeUser['role_id'],CLIENT_USERS) || $activeUser['role_id'] == CLIENT ) {
			//unset contractor
			$this->controller->getRequest()->getSession()->delete('Auth.User.contractor_id');
			$this->controller->getRequest()->getSession()->delete('Auth.User.contractor_company_name');			
			//unset employee
			$this->controller->getRequest()->getSession()->delete('Auth.User.employee_id');
		}
		elseif($activeUser['role_id'] == CR) {	
			$this->controller->getRequest()->getSession()->delete('Auth.User.contractor_id');
			$this->controller->getRequest()->getSession()->delete('Auth.User.contractor_company_name');
		}
		return false;
	}*/
	public function redirectOnlogin()
	{
		$this->controller = $this->_registry->getController();
		$this->Contractors = TableRegistry::get('Contractors');
		$this->Users = TableRegistry::get('Users');
		$activeUser = $this->controller->getRequest()->getSession()->read('Auth.User');
		
		if(isset($activeUser['role_id'])) {
			if($activeUser['role_id'] == SUPER_ADMIN || $activeUser['role_id'] == ADMIN) {
				return $this->controller->redirect(['action' => 'dashboard']);
			}elseif($activeUser['role_id'] == CONTRACTOR) {
				$contractor = $this->Contractors->get($activeUser['contractor_id'], ['contain'=>['Users']]);
				$subscription_date = date('Y-m-d', strtotime($contractor->subscription_date));
				$todayDate = date('Y-m-d');
				if($activeUser['registration_status']==1) {
					return $this->controller->redirect(['controller' => 'ContractorClients', 'action' => 'add']);
				}
				elseif($activeUser['registration_status']==2) {
					return $this->controller->redirect(['controller' => 'Payments', 'action' => 'checkout']);
				}elseif($subscription_date < $todayDate ){
					return $this->controller->redirect(['controller' => 'Payments', 'action' => 'checkout',1]);
				}
				return $this->controller->redirect(['controller' => 'Contractors', 'action' => 'dashboard']);
			}
			elseif($activeUser['role_id'] == CONTRACTOR_ADMIN) {
				return $this->controller->redirect(['controller' => 'Contractors', 'action' => 'dashboard']);
			}
			elseif($activeUser['role_id'] == CLIENT || $activeUser['role_id'] == CLIENT_ADMIN || $activeUser['role_id'] == CLIENT_BASIC) {
				return $this->controller->redirect(['controller' => 'Clients', 'action' => 'dashboard']);
			}
			elseif( $activeUser['role_id'] == CLIENT_VIEW ) {
				return $this->controller->redirect(['controller' => 'Contractors', 'action' => 'contractorList']);
			}
			elseif($activeUser['role_id'] == EMPLOYEE) {			
				$this->Employees = TableRegistry::get('Employees');
				$getEmployee = $this->Employees->find('all')->where(['id' => $activeUser['employee_id']])->first();
				if($getEmployee['registration_status']==0) {
					return $this->controller->redirect(['controller' => 'Employees', 'action' => 'myProfile']);
				}
				return $this->controller->redirect(['controller' => 'Employees', 'action' => 'dashboard']);
			}
			elseif($activeUser['role_id'] == CR) {			
				return $this->controller->redirect(['controller' => 'CustomerRepresentative', 'action' => 'dashboard']);
			}
			elseif($activeUser['role_id'] == DEVELOPER) {			
				return $this->controller->redirect(['controller' => 'Developers', 'action' => 'dashboard']);
			}
		}
		return false;
	}

	public function waiting_status()
	{
		$this->WaitingOn = TableRegistry::get('WaitingOn');
		$waiting_on = $this->WaitingOn->find('list', ['keyField'=>'status', 'valueField'=>'status' ])->toArray();		
		return $waiting_on;
	}

    public function waiting_status_ids()
    {
        $this->WaitingOn = TableRegistry::get('WaitingOn');
        $waiting_on = $this->WaitingOn->find('list', ['keyField'=>'id', 'valueField'=>'status' ])->toArray();
        return $waiting_on;
    }

    public function getWaitingOnStatus($contractor_id = null, $client_id = null)
    {
        $this->ContractorClients = TableRegistry::get('ContractorClients');
        $row = $this->ContractorClients->find()->first()->where(['client_id' => $client_id, 'contractor_id' => $contractor_id])->toArray();
        debug($row);
        die;
        return $waiting_on;
    }

	public function isContractorAssigned() {
		$isContractorAssigned = false;
		if($this->isClient() && $this->controller->getRequest()->getSession()->read('Auth.User.role_id') !== CLIENT_VIEW) {
			$client_id = $this->controller->getRequest()->getSession()->read('Auth.User.client_id');
			$contractor_id = $this->controller->getRequest()->getSession()->read('Auth.User.contractor_id');
			$client_contractors = $this->getContractors($client_id);
			if(in_array($contractor_id, $client_contractors)) {
				$isContractorAssigned = true;
			}
		}
		return $isContractorAssigned;
	}

	public function getContractorSites($contractor_id=null)
	{
		$this->ContractorSites = TableRegistry::get('ContractorSites');
		
		$contractorSites = $this->ContractorSites->find('list', ['keyField'=>'id', 'valueField'=>'site_id'])->where(['contractor_id'=>$contractor_id,'is_archived'=> false])->order(['id'=>'ASC'])->toArray();
		
		return $contractorSites;
	}
    public function checkContractorLocations($contractor_id=null)
    {
        $this->ContractorSites = TableRegistry::get('ContractorSites');
        $this->Clients = TableRegistry::get('Clients');
        $locationReq = array();
        $clients = array();
        if(!empty($contractor_id))
            $clients = $this->getClientNames($contractor_id);
        if(!empty($clients)){
            foreach ($clients as $clientId => $clientName) {
                if($clientId == 17){continue;}//canqualify marketplace
                $contractorSites = $this->ContractorSites->find('all')->where(['contractor_id'=>$contractor_id,'is_archived'=> false, 'client_id' => $clientId])->count();
                if($contractorSites <= 0)
                {
                    $locationReq[$clientId] = $clientName;
                }
            }
        }

        return $locationReq;
    }

	public function getClientSites($client_id=null,$region_id=null)
	{
		$this->controller = $this->_registry->getController();
		$activeUser = $this->controller->getRequest()->getSession()->read('Auth.User');

		$this->Sites = TableRegistry::get('Sites');
		$where[] = ['client_id'=>$client_id];
		if(!empty($activeUser['cadmin_sites'])) {              			
			$where['id IN'] = $activeUser['cadmin_sites']['s_ids'];
		}
		if(!empty($region_id)){
			$where['region_id'] =$region_id;
		}
		if(isset($_SERVER['ENVIRONMENT']) && $_SERVER['ENVIRONMENT'] == 'production'){
			$order = ['name'=>'ASC'];
		}
		else {
			$order = ['id'=>'ASC'];
		}
		$sites = $this->Sites->find('list', ['keyField'=>'id', 'valueField'=>'name'])->where([$where])->order($order)->toArray();
		return $sites;
	}

    public function getClientUserSites()
    {
        $this->controller = $this->_registry->getController();
        $activeUser = $this->controller->getRequest()->getSession()->read('Auth.User');
        $this->ClientUsers = TableRegistry::get('ClientUsers');
        $userSites = $this->ClientUsers->find()->select('site_ids')->where(['ClientUsers.user_id' => $activeUser['id']])->first()->toArray();
        $userLocations = array();
        if(!empty($userSites['site_ids']['s_ids']))
            $userLocations = $userSites['site_ids']['s_ids'];
        return $userLocations;
    }
	/*public function getRegions($client_id = null)
	{		
		$this->Regions = TableRegistry::get('Regions');
			
		$regions = $this->Regions->find('list', ['keyField'=>'id', 'valueField'=>'name'])->where(['client_id'=>$client_id])->toArray();
			
		return $regions;
	}*/

	public function getContractors($client_id=null, $waitingStatus=array(), $isactive= false, $userLocations = null)
	{
		$this->ContractorClients = TableRegistry::get('ContractorClients');
		$this->ContractorSites = TableRegistry::get('ContractorSites');

		$where = ['client_id'=>$client_id];
		if(!$this->isAdmin() && !$this->isCR()) {
			$where['Contractors.payment_status'] = true;
			if($isactive == false){
                $where['Users.active'] = true;
            }

		}
		if(!empty($waitingStatus)) {
		 	$where['ContractorClients.waiting_on IN'] = $waitingStatus;
		}

		/*client user specific*/
        if($userLocations != null && !empty($userLocations)){
            $locationContrators = $this->ContractorSites
                ->find('list', ['keyField'=>'contractor_id', 'valueField'=>'contractor_id'])
                ->where(['site_id IN ' => $userLocations, 'client_id' => $client_id])
                ->distinct(['contractor_id'])
                ->toArray();

            if(!empty($locationContrators)){
                $where['Contractors.id IN'] = $locationContrators;
        }
        }
         $contractors = $this->ContractorClients
            ->find('list', ['keyField'=>'contractor_id', 'valueField'=>'contractor_id'])
            ->where($where)
    		->contain(['Contractors', 'Contractors.Users'])
    		->contain(['Contractors', 'Contractors.Users'])
            ->distinct(['contractor_id'])
            ->toArray();

		 /*foreach($contractorSites as $contractor) {
		 	$contractors[] = $contractor->contractor_id;
		 }*/
		return $contractors;

		// $this->ContractorSites = TableRegistry::get('ContractorSites');
		// $contractors = array();
		// $sites = $this->getClientSites($client_id);
		// if(!empty($sites)) {
		// $where = ['site_id IN' => array_keys($sites), 'Contractors.payment_status'=>true, 'Users.active'=>true,'ContractorSites.is_archived'=>false];
		// if(!empty($waitingStatus)) {
		// 	$where['waiting_on IN'] = $waitingStatus;
		// }
		// $contractorSites = $this->ContractorSites
		// ->find()
		// ->select('contractor_id')
		// ->where($where)
		// ->contain(['Contractors.Users'])
		// ->distinct(['contractor_id']);
		// foreach($contractorSites as $contractor) {
		// 	$contractors[] = $contractor->contractor_id;
		// }
		// }
	}
    public function getClientUserContractors()
    {
        $this->ContractorSites = TableRegistry::get('ContractorSites');

        $this->controller = $this->_registry->getController();
        $activeUser = $this->controller->getRequest()->getSession()->read('Auth.User');

        $client_id = null;
        if(!empty($activeUser['client_id'])){
            $client_id = $activeUser['client_id'];
        }
        $sites = array();
        $sites = $this->getClientUserSites();

        $locationContrators = array();
        /*client user specific*/
        if(!empty($client_id) && !empty($sites)){
                $locationContrators = $this->ContractorSites
                    ->find('list', ['keyField'=>'contractor_id', 'valueField'=>'contractor_id'])
                    ->where(['site_id IN ' => $sites, 'client_id' => $client_id])
                    ->distinct(['contractor_id'])
                    ->toArray();
        }
        return $locationContrators;
    }

    public function getClientNames($contractor_id=null, $temp=false)
    {
        $this->ContractorClients = TableRegistry::get('ContractorClients');
        /*skip marketplace*/
        $where = ['contractor_id' => $contractor_id, 'client_id !=' => 4];
        /*if(!$this->isAdmin() && !$this->isCR()) {
            $where['Users.active'] = true;
        }*/

        $contractorClients = $this->ContractorClients
            ->find('list', ['keyField'=>'client_id', 'valueField'=>'client.company_name'])
            ->where($where)
            ->contain(['Clients'])
            ->distinct(['client_id'])
            ->toArray();


        return $contractorClients;
    }

	public function getClients($contractor_id=null, $temp=false)
	{
        $this->ContractorClients = TableRegistry::get('ContractorClients');
		
		$where = ['contractor_id' => $contractor_id];
		/*if(!$this->isAdmin() && !$this->isCR()) {
			$where['Users.active'] = true;
		}*/
		
		$contractorClients = $this->ContractorClients
		->find('list', ['keyField'=>'client_id', 'valueField'=>'client_id'])
		->where($where)
		->contain(['Contractors.Users'])
		->distinct(['client_id'])
		->toArray();
		
		$contractorTempclients = [];
		if($temp) {
			$this->ContractorTempclients = TableRegistry::get('ContractorTempclients');

			$contractorTempclients = $this->ContractorTempclients
			->find('list', ['keyField'=>'client_id', 'valueField'=>'client_id'])
			->where(['contractor_id' => $contractor_id])
			->contain(['Contractors.Users'])
			->distinct(['client_id'])
			->toArray();
		}
		$clients = array_unique(array_merge($contractorClients, $contractorTempclients));
		if(count($contractorClients) > 1 && (in_array(4, $contractorClients ))) { 
			foreach ($clients as $key => $clId) {
        		if($clId == 4){
        			unset($clients[$key]);
        		}
        } }

		return $clients;


		// $this->ContractorSites = TableRegistry::get('ContractorSites');
		// $contractorSites = $this->ContractorSites
		// ->find('list', ['keyField'=>'client_id', 'valueField'=>'client_id'])
		// ->where(['contractor_id' => $contractor_id, 'is_archived' =>false, 'Users.active'=>true])
		// ->contain(['Contractors.Users'])
		// ->distinct(['client_id'])
		// ->toArray();
		// $contractorTempsites = [];
		// if($temp) {
		// 	$this->ContractorTempsites = TableRegistry::get('ContractorTempsites');

		// 	$contractorTempsites = $this->ContractorTempsites
		// 	->find('list', ['keyField'=>'client_id', 'valueField'=>'client_id'])
		// 	->where(['contractor_id' => $contractor_id, 'Users.active'=>true])
		// 	->contain(['Contractors.Users'])
		// 	->distinct(['client_id'])
		// 	->toArray();
		// }
		// $clients = array_unique(array_merge($contractorSites, $contractorTempsites));
	}
	public function getEmpContractors($employee_id=null)
	{
        $this->EmployeeContractors = TableRegistry::get('EmployeeContractors');
		
		$where['employee_id' ] = $employee_id;
		$where['Users.active'] = true;
				
		$contractors = $this->EmployeeContractors
		->find('list', ['keyField'=>'contractor_id', 'valueField'=>'contractor_id'])
		->where($where)
		->contain(['Employees.Users'])
		->distinct(['contractor_id'])
		->toArray();

		return $contractors;	
	}
    public function getEmpContractor($employee_id=null)
    {
        $this->EmployeeContractors = TableRegistry::get('EmployeeContractors');

        $where['employee_id' ] = $employee_id;
        $where['Users.active'] = true;
        $c_id = '';

        $contractors = $this->EmployeeContractors
            ->find()
            ->where($where)
            ->contain(['Employees.Users'])
            ->select(['contractor_id'])
            ->first()
            ->toArray();

        $c_id = $contractors['contractor_id'];
        return $c_id;
    }
	public function getContractorEmp($contractor_id=null)
	{
        $this->EmployeeContractors = TableRegistry::get('EmployeeContractors');
		
		$where['contractor_id' ] = $contractor_id;
		$where['Users.active'] = true;
				
		$employees = $this->EmployeeContractors
		->find('list', ['keyField'=>'employee_id', 'valueField'=>'employee_id'])
		->where($where)
		->contain(['Employees.Users'])
		->distinct(['employee_id'])
		->toArray();

		return $employees;	
	}

	public function getContractorServices($contractor_id=null, $allSites=false) {
		$this->Services = TableRegistry::get('Services');
		$this->Products = TableRegistry::get('Products');
		$this->ContractorServices = TableRegistry::get('ContractorServices');
        $this->ClientServices = TableRegistry::get('ClientServices');
        $this->ContractorClients = TableRegistry::get('ContractorClients');

		//$this->TempEmployeeSlots = TableRegistry::get('TempEmployeeSlots');
		$services = array('services'=>array(), 'totalPrice'=>0, 'new_client'=>false, 'new_service'=>false);
		$clients = $this->getClients($contractor_id, $allSites);	

        /* $contClients = $this->ContractorClients->find('list',['keyField' => 'id', 'valueField' => 'client_id'])->where(['contractor_id'=>$contractor_id])->toArray();	
		//if(!empty($clients) && count($contClients) >= 1 && (in_array(4, $clients )))*/
		if(!empty($clients)  && (in_array(4, $clients ))) { 
			foreach ($clients as $key => $clId) {
        		if($clId == 4){
        			unset($clients[$key]);
        		}
        } }
        if(!empty($clients)) {
		        $getservices = $this->Services
		        ->find('all')
		        ->select(['id','name'])
		        ->contain(['ClientServices' => ['conditions'=>['client_id IN'=>$clients], 'fields'=>['service_id','client_id'] ]])
		        ->enableHydration(false)
		        ->order(['id'])
		        ->toArray();

		$totalPrice = 0;
		foreach($getservices as $key => $service) {
			if(empty($service['client_services'])) { continue; }

			$services['services'][$service['id']]['name'] = $service['name'];
			$services['services'][$service['id']]['service_id'] = $service['id'];

			foreach($service['client_services'] as $cls) {
				$services['services'][$service['id']]['client_ids'][] = $cls['client_id'];
			}

			// pricing
			$employeeslot = Configure::read('EmployeeQual');
			$product_price = 0;

			$client_cnt = count($service['client_services']);
			$product = $this->Products->find('all')->where(['service_id' => $service['id'], 'range_from <= ' => $client_cnt, 'range_to >= ' => $client_cnt])->first(); 
			if(!empty($product)) {
				$product_price = $product->pricing;				 
			}

			if($service['id'] == 4) { // if employeeQual
   				$services['services'][$service['id']]['slot'] = 5; // add default slot

                // get previous slot
				$contractorServices = $this->ContractorServices->find()->select(['id','slot'])->where(['contractor_id'=>$contractor_id, 'service_id'=>$service['id']])->first();
				if(!empty($contractorServices)) {
					$product_price = $contractorServices->slot * $employeeslot['base'];
    				$services['services'][$service['id']]['slot'] = $contractorServices->slot;
				}
			}		
            $services['services'][$service['id']]['price'] = $product_price;			
			$totalPrice = $totalPrice + $product_price;
		}                                 

		$services['totalPrice'] = $totalPrice;
		}

		return $services;
	}
	
	public function calculatePayment($contractor_id=null, $services=array(),$renew = false) {
		$this->ContractorServices = TableRegistry::get('ContractorServices');
		$this->Contractors = TableRegistry::get('Contractors'); 
		$this->ContractorClients = TableRegistry::get('ContractorClients'); 

		$contractor = $this->Contractors->get($contractor_id);
		$contClients = $this->ContractorClients->find('list',['keyField' => 'client_id', 'valueField' => 'client_id'])->where(['contractor_id'=>$contractor_id])->toArray();
		if(!$renew){  
      	$contractorServices = $this->ContractorServices
			->find('list', ['keyField'=>'service_id', 'valueField'=> "client_ids"])
			->where(['contractor_id'=>$contractor_id])
			->toArray();

        if(!empty($contractorServices)) {
        	$clientIds = array();
        	foreach ($contractorServices as $key => $contractorService) {
        		 foreach ($contractorService['c_ids'] as $key => $cli) {
   				  $clientIds[] = $cli;
   				 }         		
        	}
        	$clientIds = array_unique($clientIds);

			if((count($clientIds)==1 && in_array(4, $clientIds) )){
			 $newServices = array_keys($services['services']);
			 $contractorServices = [];
			 }else{ 
		    $newServices = array_diff(array_keys($services['services']), array_keys($contractorServices)); }
		    if(!empty($newServices)) {
			    $services['new_service'] = true;
		    }
        }

		$totalPrice = 0;
		foreach($services['services'] as $service_id => $service) {

            if(isset($contractorServices[$service_id])) { // if service exist in contractorServices
                $new_clients = array();               
                if(isset($contractorServices[$service_id]['c_ids']) ) {
    				$client_ids = $contractorServices[$service_id]['c_ids']; // extisting clients of current service
	    			$new_clients = array_diff($service['client_ids'], $client_ids);
                }
                if(!empty($new_clients)) {
					$services['new_client'] = true;
                }

                $services['services'][$service_id]['client_ids'] = $new_clients;

                if($service_id!=2 && $service_id!=3) { // if not InsureQual and AuditQual
    				   //$services['services'][$service_id]['client_ids'] = $new_clients;

					   $product = $this->Products->find('all')->where(['service_id' => $service_id, 'range_from <= ' => count($new_clients), 'range_to >= ' => count($new_clients)])->first();
					    if(!empty($product)) {
						    $product_price = $product->pricing;

						    if($service['price'] < $product_price) {
                                $services['new_service'] = true;
							    $services['services'][$service_id]['price'] = $product_price;
							    
                                if($service_id==4) { // if employeeQual
                        			$employeeslot = Configure::read('EmployeeQual');
                                    $services['services'][$service_id]['slot'] = $employeeslot['base'];
                                }
						    }
						    elseif(empty($new_clients)) {
    					        unset($services['services'][$service_id]);
    				        }
							else {
							   unset($services['services'][$service_id]['price']);
						    }
					    }
                        else {
                            if(empty($new_clients)) {
					            unset($services['services'][$service_id]);
				            }
                        }
                }
                else {
                        if(empty($new_clients)) {
					        unset($services['services'][$service_id]);
				        }
                }
			}
            if(isset($services['services'][$service_id]['price'])) {
                $totalPrice = $totalPrice + $services['services'][$service_id]['price'];
            }
		}

		$services['totalPrice'] = $totalPrice;	    
		}
        //pr($services);

		$services = $this->calculateDiscount($services,$contractor_id);
        //pr($services);

		if(($services['new_client']||$services['new_service']) && count($contClients) > 1) {
			$services = $this->calProInvice($contractor_id,$services);
		}
		
		$services['reactivation_fee']= ''; 
		$todayDate = strtotime(date('m/d/Y'));
		if(!empty($contractor['subscription_date'])){
		$renewSubDate = strtotime(date('m/d/Y', strtotime($contractor['subscription_date'])));
       	if($renewSubDate < $todayDate) {
			$services = $this->calReactivation($contractor_id,$services,$todayDate,$renewSubDate);
		}}
        $services['canqualify_discount'] = '';
		$services = $this->calCanqDiscount($services,$contractor_id);

		return $services;
	}
	public function calReactivation($contractor_id=null,$services =array(),$todayDate=null,$renewSubDate=null) // Prorated Payment Functionality
	{
		$diff = $todayDate -$renewSubDate; 
		$datediff = abs(round($diff / 86400)); 	
		$pro=false;
		if($datediff >30){
			$lateFeeDate = strtotime(date("m/d/Y", strtotime("+1 month", $renewSubDate)));
				if($todayDate > $lateFeeDate){
					$pro=true;
					//$services = $this->calProInvice($contractor_id,$services,$pro);
				}
			$services['reactivation_fee'] = REACTIVATION_FEE;
		}

		$services['final_price'] = (!empty($services['final_price']) ? $services['final_price'] : 0) + (!empty($services['reactivation_fee']) ? $services['reactivation_fee'] : 0);
		
		return $services;		
	}
	public function calProInvice($contractor_id=null,$services =array(),$pro=false) // Prorated Payment Functionality
	{
		$this->Contractors = TableRegistry::get('Contractors');  
		$contractor = $this->Contractors->get($contractor_id);
		
		$todayDate = strtotime(date('m/d/Y'));
		$renewSubDate = strtotime(date('m/d/Y', strtotime($contractor['subscription_date'])));		
		
		if($pro){
			$renewSubDate = strtotime(date('m/d/Y', strtotime('+ 1 year',$renewSubDate)));		
		}
		if($renewSubDate > $todayDate) {
		$year1 = date('Y', $todayDate);	$year2 = date('Y', $renewSubDate);
		$month1 = date('m', $todayDate);$month2 = date('m', $renewSubDate);
		$month_diff = ((($year2 - $year1) * 12) + ($month2 - $month1)+1); 
		$final_price = 0;
		if($month_diff > 0 && $month_diff < 12){
			foreach($services['services'] as $service_id => $service) { 
		 	if(isset($service['price'])) {	
			$one_month_price =  ($service['final_price'] / 12);
			$pre_invoice_price = round($one_month_price * $month_diff);
			$services['services'][$service_id]['final_price'] = $pre_invoice_price;
			$final_price = $final_price + $services['services'][$service_id]['final_price'];
			 }
			}	
		$services['final_price'] = $final_price;
		}}
		return $services;
		
	}
	public function calCanqDiscount($services= array(),$contractor_id=null){
		$this->PaymentDiscounts = TableRegistry::get('PaymentDiscounts');

		$final_price = $services['final_price'];	

		$canqualify_discounts = $this->PaymentDiscounts->find('all')->where(['contractor_id'=>$contractor_id])->first();
		$canq_discount = '';
		if(!empty($canqualify_discounts)){
			$canq_discount =$canqualify_discounts->discount_price;
			$valid_date =  	$canqualify_discounts->valid_date;
			$todayDate = strtotime(date('m/d/Y'));
			$validDate = strtotime(date('m/d/Y', strtotime($valid_date)));	
		}
		if(!empty($canq_discount && $services['services'])&& $validDate >=$todayDate){
            $services['canqualify_discount'] = $canq_discount;
            $final_price = $final_price-$services['canqualify_discount'];
        }
        $services['final_price'] = $final_price;

        return $services;
	}
	public function calculateDiscount($services =array(),$contractor_id=null) // Discount Functionality
	{
		$this->ClientServices = TableRegistry::get('ClientServices');		
		$this->Clients = TableRegistry::get('Clients');

		$final_price = 0;			
		 foreach($services['services'] as $service_id => $service) { 
		 	if(isset($service['price'])){
		 	$is_gc = false;
		 	$clients = $service['client_ids'];

		 	if(!empty($clients)) {
                $clientServices = $this->ClientServices->find('all')->where(['client_id IN' => $clients, 'service_id' => $service_id])->toArray();
                $discountedServices = $this->ClientServices->find('all')->where(['client_id IN' => $clients, 'service_id' => $service_id, 'discount >' => 0])->count();
                //pr($clientServices).'<br/>';
            }
		 	$discounts = array();

		 	if(!empty($clients)){
		 	    $gc = 0;
		 	    $gc = $this->Clients->find('all')->where(['id in' => $clients, 'is_gc' => true])->count();
		 	    $is_gc = (isset($gc) && $gc ==1 && 1 == count($clients)) ? true : false;
            }
		 	    if($is_gc == true){
                    $discounts[] = 0;
                    $service['price'] = 0;
                }elseif(!empty($clientServices)){
                    if(count($clientServices) == 1 || count($clientServices) == $discountedServices){
                        foreach ($clientServices as $clientService) {
                            if($clientService['is_percentage']){
                                $per_dis = $clientService['discount'];
                                $discounts[] = round(($per_dis / 100) * $service['price']);
                            }else{
                                $discounts[] = $clientService['discount']; }
                        }
                    }
                }else{
                    $discounts[] = 0;
                }

                if(!empty($discounts)){
	                    $discount =  max($discounts);
	                    if($discount <= $service['price']){
		                    $price = $service['price'] - $discount;
		                    $services['services'][$service_id]['discount'] = $discount;              
		                    $services['services'][$service_id]['final_price'] = $price;
		                    $final_price = $final_price + $services['services'][$service_id]['final_price'];
               		 	}else{
	               		 	$services['services'][$service_id]['discount'] = 0;              
		                    $services['services'][$service_id]['final_price'] = $service['price'];
		                    $final_price = $final_price + $services['services'][$service_id]['final_price'];
               		 	}

               		 }else{
                    $services['services'][$service_id]['discount'] = 0;
                    $services['services'][$service_id]['final_price'] = $service['price'];
                    $final_price = $final_price + $services['services'][$service_id]['final_price'];
                }
                }
		 }

                $services['final_price'] = $final_price;

            return $services;
	}

	public function getContractorSitesForEmp($contractor_id=null,$employee_id=null,$emp_contractors=null) {
		$this->ClientServices = TableRegistry::get('ClientServices');
		$this->EmployeeSites = TableRegistry::get('EmployeeSites');
		if(!empty($contractor_id)){
	    $contractor_clients = $this->getClients($contractor_id);
		}else{
			$contractor_clients = $this->getEmployeeClients($employee_id);
		}
        $employeeSites = $this->EmployeeSites
                        ->find('list',['keyField'=>'id','valueField'=>'site_id'])
                        ->where(['employee_id'=>$employee_id])->toArray();

		$andConditions['is_archived'] = false;
		if(!empty($contractor_id)){
		$andConditions['contractor_id'] = $contractor_id;
		}else{
			$andConditions['contractor_id IN'] = $emp_contractors;
		}
        if(!empty($employeeSites)) {
        	$andConditions['site_id NOT IN'] = $employeeSites;
        }
	    /*$contractors = $this->Clients
            ->find('all')
            ->select(['id','company_name'])
            ->contain(['ContractorSites'=> ['fields'=> ['id', 'site_id', 'client_id', 'contractor_id'], 'conditions'=>$andConditions]]) 
            ->contain(['ContractorSites.Sites'=> ['fields'=> ['id', 'name']] ])
            ->enableHydration(false)
            ->where(['id IN'=>$contractor_clients])
            ->toArray();

		    $contractorSites = [];		
            foreach ($contractors as $cl) {        
                if(!empty($cl['contractor_sites'])){
                    foreach ($cl['contractor_sites'] as $site) {
                        $contractorSites[$cl['company_name']][$site['site']['id']] = $site['site']['name'];
                    }           
                }
            }
        */

        $clients = $this->ClientServices
            ->find('all')
            ->select(['id', 'client_id', 'service_id'])
            ->contain(['Clients' => ['fields'=> ['id','company_name']]])
            ->contain(['Clients.ContractorSites'=> ['fields'=> ['id', 'site_id', 'client_id', 'contractor_id'], 'conditions'=>$andConditions]]) 
            ->contain(['Clients.ContractorSites.Sites'=> ['fields'=> ['id', 'name']] ])
            ->where(['ClientServices.client_id IN'=>$contractor_clients, 'ClientServices.service_id'=>4]) // employeeQual
            ->enableHydration(false)
            ->toArray();

		$contractorSites = [];		
        foreach ($clients as $client) {        
            if(!empty($client['client']['contractor_sites'])){
                foreach ($client['client']['contractor_sites'] as $site) {
                    $contractorSites[$client['client']['company_name']][$site['site']['id']] = $site['site']['name'];
                }           
            }
        }

        return $contractorSites;
    }

	public function isSubscriptionRenewed($contractor = array()) {
		
		$subscription_date = date('Y-m-d', strtotime($contractor->subscription_date));
		$dt = date('Y-m-d', strtotime("+90 days"));
		
        if($contractor->subscription_date!=null && $subscription_date <= $dt) {
			return false;
		}
		
		return true;
	}
	
	public function saveWaitingOnLog($contractor_id, $from, $to, $saved_from)
	{
		$this->controller = $this->_registry->getController();
		$this->WaitingOnLogs = TableRegistry::get('WaitingOnLogs');
		
		$waitingOnLog = $this->WaitingOnLogs->newEntity();
		$waitingOnLog->contractor_id = $contractor_id;
		$waitingOnLog->from_status = $from;
		$waitingOnLog->to_status = $to;
		$waitingOnLog->saved_from = $saved_from;
		$waitingOnLog->created_by = $this->controller->getRequest()->getSession()->read('Auth.User.id');

        $this->WaitingOnLogs->save($waitingOnLog);
		
		return $waitingOnLog;
	}
	
	public function getEmployeeClients($employee_id=null,$contractor_id=null)
	{
		$this->Employees = TableRegistry::get('Employees');
		$this->ContractorClients = TableRegistry::get('ContractorClients');

		/*$contractor_id = $this->Employees
        ->find('list', ['keyField'=>'contractor_id', 'valueField'=>'contractor_id'])
        ->where(['id'=>$employee_id])
        ->first();*/
        $emp_contractors =   $this->getEmpContractors($employee_id);
        if($contractor_id!=null) { 
        	$where['contractor_id'] = $contractor_id; 
    	}else {
       		 $where['contractor_id IN']= $emp_contractors;
   		}

		//$where = ['contractor_id' => $contractor_id];
		if(!$this->isAdmin() && !$this->isCR()) {
			$where['Users.active'] = true;
		}
		
		$clients = $this->ContractorClients
		->find('list', ['keyField'=>'client_id', 'valueField'=>'client_id'])
		->where($where)
		->contain(['Contractors.Users'])
		->distinct(['client_id'])
		->toArray();

		return $clients;
	}
	public function getUserbyRoles( $users_ids=array(),$role=null)
	{	
		$this->Contractors = TableRegistry::get('Contractors');
		//$this->Clients = TableRegistry::get('Clients');
		$this->ClientUsers = TableRegistry::get('ClientUsers');
		$users = array();			
				if($role == CONTRACTOR){
				$users = $this->Contractors->find('list', ['keyField'=>'id', 'valueField'=> 'user_id'])->contain(['Users'])->where(['Contractors.id IN'=>$users_ids, 'Users.active IS'=>true])->toArray();
				}
				elseif($role == CLIENT){
				// $users = $this->Clients->find('list', ['keyField'=>'id', 'valueField'=> 'user_id'])->contain(['Users'])->where(['Clients.id IN'=>$users_ids, 'Users.active IS'=>true])->toArray();
				$users = $this->ClientUsers->find('list', ['keyField'=>'client_id', 'valueField'=> 'user_id'])->contain(['Users'])->where(['ClientUsers.client_id IN'=>$users_ids, 'Users.active IS'=>true])->toArray();
				}			
			return $users;
	}

    /*public function removeContractorSites($contractor_id=null, $deletedSites=array()) {
		$this->Services = TableRegistry::get('Services');
		$this->ContractorSites = TableRegistry::get('ContractorSites');
	
		$existingClients = $this->getClients($contractor_id);
        pr($existingClients);

        if($contractor_id !=null && !empty($deletedSites)) {

    	$this->ContractorSites->query()
			->delete()				
			->where(['site_id IN'=>$deletedSites, 'contractor_id'=>$contractor_id])
			->execute();

		$newClients = $this->getClients($contractor_id);
        pr($newClients);

        $removedClient = array_diff($existingClients, $newClients);
        pr($removedClient);

        if(!empty($removedClient)) {
            $contractorServices = $this->ContractorServices->find('all')->where(['contractor_id'=>$contractor_id])->all();
		    foreach($contractorServices as $contractorService) {
                $client_ids = $contractorService->client_ids;
                if(isset($client_ids[]) {
                    unset($client_ids[]);
                }

			    $contractorService->client_ids = ['c_ids' => $client_ids];
			    $contractorService->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');
			    $this->ContractorServices->save($contractorService);
		    }
        }
        }
    }*/


	public function update_contractor_ans($requestData=array(), $contractor_id=null, $user_id=null) {

		$this->Questions = TableRegistry::get('Questions');
		$this->Contractors = TableRegistry::get('Contractors');

  		$states = $this->Contractors->States->find('list')->toArray();
		//debug($requestData);
		$contractor_id = $contractor_id;

		$questions = $this->Questions
		->find('list', ['keyField'=>'id', 'valueField'=>'question'])
		->select(['id','question'])
		->where(['show_on_register_form'=>true, 'active'=>true])
		->order(['ques_order'=>'ASC','Questions.id'=>'ASC'])
		->toArray();

	    foreach($questions as $key=>$val) {
		    $contractorAnswers = array();

		    if($val == 'Company name' && isset($requestData['company_name'])) { $contractorAnswers['answer'] = $requestData['company_name']; }
		    elseif($val == 'Address' && isset($requestData['addressline_1'])) { $contractorAnswers['answer'] = $requestData['addressline_1']; }
		    elseif($val == 'City' && isset($requestData['city'])) { $contractorAnswers['answer'] = $requestData['city']; }
		    elseif($val == 'State' && isset($requestData['state_id'])) { $contractorAnswers['answer'] = $states[$requestData['state_id']]; }
		    elseif($val == 'State' && isset($requestData['state'])) { $contractorAnswers['answer'] = $requestData['state']; }
		    elseif($val == 'Zip' && isset($requestData['zip'])) { $contractorAnswers['answer'] = $requestData['zip']; }
		    elseif($val == 'Primary Contact (title):' && isset($requestData['pri_contact_title'])) { $contractorAnswers['answer'] = $requestData['pri_contact_title']; }
		    elseif($val == 'Telephone' && isset($requestData['pri_contact_pn'])) { $contractorAnswers['answer'] = $requestData['pri_contact_pn']; }
		    elseif($val == 'Primary Contact (title):' && isset($requestData['pri_contact_title'])) { $contractorAnswers['answer'] = $requestData['pri_contact_title']; }
		    elseif($val == 'Company Tax Identification Number (TIN)' && isset($requestData['company_tin'])) {
		        $c_tin = preg_replace("/[^0-9.]/", '', $requestData['company_tin']);
                $contractorAnswers['answer'] = $c_tin;
		    }


		    if(!isset($contractorAnswers['answer'])) { continue; }

		    $contractorAnswers['question_id'] = $key;
		    $contractorAnswers['contractor_id'] = $contractor_id;
		    $saveDt = $this->Contractors->ContractorAnswers->find('all', ['conditions'=>['contractor_id'=>$contractor_id, 'question_id'=>$key]])->first();	
		    if(empty($saveDt)) { // new answer
        		$contractorAnswers['created_by'] = $user_id;
			    $saveDt = $this->Contractors->ContractorAnswers->newEntity();
		    }
            else {
                $contractorAnswers['modified_by'] = $user_id;
            }
		   $saveDt = $this->Contractors->ContractorAnswers->patchEntity($saveDt, $contractorAnswers);
		   $this->Contractors->ContractorAnswers->save($saveDt);
	    }
	}

	public function update_contractor($requestData=array(), $contractor_id=null) {
		$this->Questions = TableRegistry::get('Questions');
		$this->Contractors = TableRegistry::get('Contractors');

  		$states = $this->Contractors->States->find('list', ['keyField'=>'name', 'valueField'=>'id' ])->toArray();

		$contractor = $this->Contractors->get($contractor_id);

		$questions = $this->Questions
		->find('list', ['keyField'=>'id', 'valueField'=>'question'])
		->select(['id','question'])
		->where(['show_on_register_form'=>true, 'active'=>true])
		->order(['ques_order'=>'ASC','Questions.id'=>'ASC'])
		->toArray();

		$quesField['Company name'] = 'company_name';
		$quesField['Address'] = 'addressline_1';
		$quesField['City'] = 'city';
		$quesField['State'] = 'state_id';
		$quesField['Zip'] = 'zip';
		$quesField['Telephone'] = 'pri_contact_pn';
		$quesField['Primary Contact (title):'] = 'pri_contact_title';
		$quesField['Company Tax Identification Number (TIN)'] = 'company_tin';

        $saveDt = array();
		foreach($requestData as $key=>$val) {
		    if(!empty($questions[$val['question_id']]) && in_array($questions[$val['question_id']], $questions)) {
			    $quesName = $questions[$val['question_id']];
                if($quesField[$quesName] == 'state_id') {
        			$saveDt[$quesField[$quesName]] = $states[$val['answer']];
                }elseif ($val['question_id'] == 11){
                    $temp = preg_replace("/[^0-9.]/", '', $val['answer']);
                    $saveDt[$quesField[$quesName]] = $temp;
                }
                else {
        			$saveDt[$quesField[$quesName]] = $val['answer'];
                }
		    }
		}
		$saveDt = $this->Contractors->patchEntity($contractor, $saveDt);
		$contractor = $this->Contractors->save($saveDt);
	}

	public function getClientList(){    	
	    $conn = ConnectionManager::get('default');
	   
		$clientList = $conn->execute("SELECT id,client_id,company_name,active,under_configuration
		FROM client_list where active = true AND under_configuration = false ORDER BY company_name")->fetchAll('assoc');		
	    if(!empty($clientList)){
	    	$clients = array();
	    	foreach ($clientList as $client) {
	    		$clients[$client['client_id']] = $client['company_name'];
	    	}
	    }
	    return $clients;
    }
   /*public function getEmpExp($contractor_id=null)
	{ 
		$this->Employees = TableRegistry::get('Employees');
		$this->EmployeeExplanations = TableRegistry::get('EmployeeExplanations');

		$contEmp = $this->Employees
        ->find('list', ['keyField'=>'id', 'valueField'=>'id'])
        ->where(['contractor_id'=>$contractor_id])
        ->toArray();
        $empExp = false;
        if(!empty($contEmp)) {
        foreach ($contEmp as $key => $emp) {        	 
	        $empExplanations = $this->EmployeeExplanations
	        ->find('all')	       
	        ->contain(['Employees'])        
	        ->where(['employee_id'=>$emp ])      
	        ->first();
	        //pr($empExplanations);
	        if(empty($empExplanations)){
	        	$empExp = true;
	        	break;
	        }
       	 }
   		}else{
   			$empExp = true;
   		}

      
    	 return $empExp;

	}*/
	public function getCraftCertificate($contractor_id=null)
	{ 
		$this->Employees = TableRegistry::get('Employees');
		$this->EmployeeExplanations = TableRegistry::get('EmployeeExplanations');
		$contEmp = $this->getContractorEmp($contractor_id);
		/*$contEmp = $this->Employees
        ->find('list', ['keyField'=>'id', 'valueField'=>'id'])
        ->where(['contractor_id'=>$contractor_id])
        ->toArray();*/
        $empExpCount = 0;   
        if(!empty($contEmp)) {         	 
	        $empExplanations = $this->EmployeeExplanations
	        ->find('all')	       
	        ->contain(['Employees'])        
	        ->where(['employee_id IN'=>$contEmp ])      
	        ->toArray();	        
       	}
   		if(!empty($empExplanations)){
       		$empExpCount = count($empExplanations);
       	}
    	return $empExpCount;
	}

	public function associateWithMarketplace($contractor_id = null,$renew_subscription=false)
    {       
    	$this->ContractorClients = TableRegistry::get('ContractorClients');
    	$this->Payments = TableRegistry::get('Payments');       
    	$this->Contractors = TableRegistry::get('Contractors');   
    	$this->Users = TableRegistry::get('Users');  
    	$this->controller = $this->_registry->getController();
        
        $contractor = $this->controller->Contractors->get($contractor_id, ['contain'=>['Users']]);
        $contractor_id = $contractor->id;       

        if(!$renew_subscription){
        $contclient = $this->ContractorClients->newEntity();
        $contclient->client_id = 4;
        $contclient->contractor_id = $contractor_id;
        $contclient->created_by = $this->controller->getRequest()->getSession()->read('Auth.User.id');
        $this->ContractorClients->save($contclient); 
    	}
       /* $request_email = $contractor->user->username;
        $nvp_response_array = $this->dummyDetails($request_email);

        $payment = $this->Payments->newEntity();

        $payment->totalprice = 0;
        $payment->contractor_id = $contractor_id;
        $payment->created_by = $this->controller->getRequest()->getSession()->read('Auth.User.id');
        if($renew_subscription){
        	$payment->payment_type = 2;
        }else{
        	$payment->payment_type = 1;
    	}
        $payment->email = isset($nvp_response_array['EMAIL']) ? $nvp_response_array['EMAIL'] : '';
        if(!empty($nvp_response_array)) {
            $payment->response = json_encode($nvp_response_array);           
            $payment->transaction_status = isset($nvp_response_array['ACK']) ? $nvp_response_array['ACK'] : '';           
            $payment->p_timestamp = isset($nvp_response_array['TIMESTAMP']) ? $nvp_response_array['TIMESTAMP'] : '';            

        }else {
            $payment->transaction_status = 'Failure';
        } */
        /*if ($result = $this->Payments->save($payment)) {
        if ($result['transaction_status'] == 'Success' || $result['transaction_status'] == 'SuccessWithWarning') {
            // Set contractor payment_status and registration_status
            $subscription_date = $contractor->subscription_date;

            // contractor payment first time
            if($contractor->registration_status ==1) {
                $new_contractor = true;

                $contractor->payment_status = 1;
                $contractor->registration_status = 3;
                $this->controller->getRequest()->getSession()->write('Auth.User.registration_status', 3);

                $subscription_date = date('Y-m-d', strtotime('+ 1 year')); //n/d/Y
            } 
            if($this->controller->getRequest()->getSession()->read('Auth.User.active')==false){
            $this->Users->query()->update()->set(['active'=>true])
                    ->where(['id'=>$contractor->user_id])
                    ->execute();
                $this->controller->getRequest()->getSession()->write('Auth.User.active', true);
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
            $this->savePaymentDetails($result->id,$contractor_id,$renew_subscription);
            
            // set default icon
            $this->setDefaultIcon($contractor_id);

        }}*/

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

    function savePaymentDetails($payment_id=0,$contractor_id = null,$renew_subscription = false) {
    $this->ContractorServices = TableRegistry::get('ContractorServices'); 
    $this->PaymentDetails = TableRegistry::get('PaymentDetails'); 
          
        if(!$renew_subscription){  
        $contractorService = $this->ContractorServices->newEntity();    
        $contractorService->service_id = 1;       
        $contractorService->client_ids =['c_ids' => [4]];
        $contractorService->contractor_id = $contractor_id;
        $contractorService->created_by =$this->controller->getRequest()->getSession()->read('Auth.User.id');
         $this->ContractorServices->save($contractorService);         
     	}else{
     		$contractorService = $this->ContractorServices->find('all')->where(['contractor_id'=>$contractor_id, 'client_ids'=>['c_ids' => [4]]])->first();
     		if(!empty($contractorService)) { 
     			$contractorService->modified_by = $this->controller->getRequest()->getSession()->read('Auth.User.id');
			$this->ContractorServices->save($contractorService);
     		}
     	}
        // save PaymentDetails
        $paymentDetail = $this->PaymentDetails->newEntity();
        //$paymentDetail = $this->PaymentDetails->patchEntity($paymentDetail, $service);
        $paymentDetail->service_id = 1;
        $paymentDetail->client_ids = ['c_ids' => [4]];         
        $paymentDetail->product_price = 99;
        $paymentDetail->discount = 99;
        $paymentDetail->price = 0;        
        $paymentDetail->payment_id = $payment_id;
        $paymentDetail->created_by = $this->controller->getRequest()->getSession()->read('Auth.User.id');

        $this->PaymentDetails->save($paymentDetail);
    }
    
    function setDefaultIcon($contractor_id = null) {   
    $this->OverallIcons = TableRegistry::get('OverallIcons'); 
    $this->controller = $this->_registry->getController();

    $overallicons = $this->OverallIcons->find('all')->where(['contractor_id'=>$contractor_id, 'client_id'=>4])->count();
        if($overallicons == 0){
            $overallIcon = $this->OverallIcons->newEntity();
            $overallIcon->client_id = 4;
            $overallIcon->contractor_id = $contractor_id;
            $overallIcon->bench_type = 'OVERALL';
            $overallIcon->icon = 0;
            $overallIcon->created_by =  $this->controller->getRequest()->getSession()->read('Auth.User.id');

            $this->OverallIcons->save($overallIcon);
        }    
    }
}
