<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
/**
 * Service helper
 */
class UserHelper extends Helper
{
	public function getUser() {
		$activeUser = $this->_View->get('activeUser');

		return $activeUser;
	}

	public function isAdmin() {
		$activeUser = $this->getUser();
		if($activeUser['role_id'] == SUPER_ADMIN || $activeUser['role_id'] == ADMIN) {
			return $activeUser;
		}
		return false;
	}

	public function isClient() {
		$activeUser = $this->getUser();
		if($activeUser['role_id']== CLIENT || $activeUser['role_id'] == CLIENT_ADMIN || $activeUser['role_id'] == CLIENT_VIEW || $activeUser['role_id'] == CLIENT_BASIC) {
			return $activeUser;
		}
		return false;
	}

	public function isContractor() {
		$activeUser = $this->getUser();
		if($activeUser['role_id']== CONTRACTOR || $activeUser['role_id'] == CONTRACTOR_ADMIN) {
			return $activeUser;
		}
		return false;
	}
	public function isCR() {
		$activeUser = $this->getUser();
		if($activeUser['role_id'] == CR) {
			return $activeUser;
		}
		return false;
	}
	public function isEmployee() {
		$activeUser = $this->getUser();
		if($activeUser['role_id']== EMPLOYEE) {
			return $activeUser;
		}
		return false;
	}

	public function getClients($contractor_id=null)
	{
		// $this->ContractorSites = TableRegistry::get('ContractorSites');

		// $contractorSites = $this->ContractorSites
		// ->find()
		// ->select('client_id')
		// ->where(['contractor_id' => $contractor_id,'is_archived'=>false, 'Users.active'=>true])
		// ->contain(['Contractors.Users'])
		// ->distinct(['client_id']);

		// $clients = array();
		// foreach($contractorSites as $client) {
		// 	$clients[] = $client->client_id;
		// }
		// return $clients;
		$this->ContractorClients = TableRegistry::get('ContractorClients');

		$where = ['contractor_id' => $contractor_id];
		if(!$this->isAdmin() && !$this->isCR()) {
			$where['Users.active'] = true;
		}
		
		$clients = $this->ContractorClients
		->find('list', ['keyField'=>'client_id', 'valueField'=>'client_id'])
		->where($where)
		->contain(['Contractors.Users'])
		->distinct(['client_id'])
		->toArray();
		
		if(count($clients) > 1 && (in_array(4, $clients ))) { 
			foreach ($clients as $key => $clId) {
        		if($clId == 4){
        			unset($clients[$key]);
        		}
        } }
		return $clients;
	}

	public function getContractors($client_id=null)
	{
		$this->ContractorClients = TableRegistry::get('ContractorClients');

		$where = ['client_id' => $client_id];
		if(!$this->isAdmin() && !$this->isCR()) {
			$where['Contractors.payment_status'] = true;
			$where['Users.active'] = true;
		}
		
		$contractors = $this->ContractorClients
        ->find('list', ['keyField'=>'contractor_id', 'valueField'=>'contractor_id'])
		->where($where)
		->contain(['Contractors.Users'])
		->distinct(['contractor_id'])
		->toArray();
		return $contractors;

		// $this->ContractorSites = TableRegistry::get('ContractorSites');

		// $contractorSites = $this->ContractorSites
		// ->find()
		// ->select('contractor_id')
		// ->where(['client_id' => $client_id,'is_archived'=>false,'Contractors.payment_status'=>true, 'Users.active'=>true])
		// ->contain(['Contractors.Users'])
		// ->distinct(['contractor_id']);

		// $contractors = array();
		// foreach($contractorSites as $contractor) {
		// 	$contractors[] = $contractor->contractor_id;
		// }		
		// return $contractors;
	}
	/*public function getEmpExp($contractor_id=null,$employee_id =null)
	{ 
		$this->Employees = TableRegistry::get('Employees');
		$this->EmployeeExplanations = TableRegistry::get('EmployeeExplanations');
		$empExp = false;
		if(!empty($contractor_id)){
			$contEmp = $this->Employees
	        ->find('list', ['keyField'=>'id', 'valueField'=>'id'])
	        ->where(['contractor_id'=>$contractor_id])
	        ->toArray();	        
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
	   		}
   		}
   		if(!empty($employee_id)){
   			//$empExp = false;           	 
	        $empExplanations = $this->EmployeeExplanations
	        ->find('all')	       
	        ->contain(['Employees'])        
	        ->where(['employee_id'=>$employee_id ])      
	        ->toArray();
	        //pr($empExplanations);
	        if(empty($empExplanations)){
	        	$empExp = true;	        	
	        }
   		}

        return $empExp;

	}*/
	// public function getEmpCertificate($employee_id=null)
	// { 
	// 	$this->Employees = TableRegistry::get('Employees');
	// 	$this->EmployeeExplanations = TableRegistry::get('EmployeeExplanations');

	//     $empExp = false;           	 
	//         $empExplanations = $this->EmployeeExplanations
	//         ->find('all')	       
	//         ->contain(['Employees'])        
	//         ->where(['employee_id'=>$employee_id ])      
	//         ->toArray();
	//         //pr($empExplanations);
	//         if(empty($empExplanations)){
	//         	$empExp = true;	        	
	//         }
	//         return $empExp;

	// }
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
    	} else {
       		 $where['contractor_id IN']= $emp_contractors;
   		}

		//$where = ['contractor_id IN ' => $contractors];
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
	public function getContractorEmp($contractor_id=null)
	{
        $this->EmployeeContractors = TableRegistry::get('EmployeeContractors');
		
		$where['contractor_id' ] = $contractor_id;
		$where['Users.active'] = true;
				
		$contractors = $this->EmployeeContractors
		->find('list', ['keyField'=>'employee_id', 'valueField'=>'employee_id'])
		->where($where)
		->contain(['Employees.Users'])
		->distinct(['employee_id'])
		->toArray();

		return $contractors;	
	}
	public function getContractorcount()
	{
		$this->Users = TableRegistry::get('Users');
		
		$where = ['role_id' => CONTRACTOR];
		if(!$this->isAdmin() && !$this->isCR()) {
			$where['active'] = true;
		}
		
		$contractors = $this->Users
		->find()
		->where($where)
		->count();
		
		return $contractors;
	}
	
	public function getClientsount()
	{
		$this->Users = TableRegistry::get('Users');
		
		$where = ['role_id' => CLIENT];
		if(!$this->isAdmin() && !$this->isCR()) {
			$where['active'] = true;
		}
		$clients = $this->Users
		->find()
		->where($where)
		->count();					
		return $clients;
	}
	
	public function getCRFount()
	{
		$this->Users = TableRegistry::get('Users');
		
		$crf = $this->Users
		->find()
		->where(['role_id' => CR, 'active'=>true])
		->count();
		
		return $crf;
	}

	public function getWaitingonCnt()
	{
		$this->ContractorClients = TableRegistry::get('ContractorClients');

		$wtContractors = $this->ContractorClients
		->find('all')
		->where(['waiting_on' => STATUS_CANQUALIFY, 'client_id !=' => 4, 'contractor_id !=' => 502])
		->count();
		return $wtContractors;
	}

	public function getContractor($contractor_id=null)
	{
		$this->Contractors = TableRegistry::get('Contractors');

		$contractor = $this->Contractors->get($contractor_id, [
		    'contain'=>['States', 'Countries', 'Users']
		]);
		
		return $contractor;
	}

	public function getClientSites($client_id=null, $activeUser=array())
	{
		$this->Sites = TableRegistry::get('Sites');
		
		$where[] = ['client_id'=>$client_id];
		if(isset($activeUser['cadmin_sites']) && $activeUser['cadmin_sites']!='') {        
			//$site_ids = explode(',',$activeUser['cadmin_sites']);			
			$where['id IN'] = $activeUser['cadmin_sites']['s_ids'];
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

	public function getContractorSites($contractor_id=null)
	{
		$this->ContractorSites = TableRegistry::get('ContractorSites');

		$contractorSites = $this->ContractorSites->find('list', ['keyField'=>'id', 'valueField'=>'site_id'])->where(['contractor_id'=>$contractor_id,'is_archived'=>false])->order(['id'=>'ASC'])->toArray();
		
		return $contractorSites;
	}
	
	public function getSitesbyClient($contractor_id=null, $client_id=null)
	{
		$this->ContractorSites = TableRegistry::get('ContractorSites');

		$contractorSites = $this->ContractorSites->find('list', ['keyField'=>'site.id', 'valueField'=>'site.name'])
                            ->where(['contractor_id'=>$contractor_id,'is_archived'=>false,'ContractorSites.client_id'=>$client_id])
                            ->contain(['Sites' =>['fields'=>['id', 'name']]])
                            ->toArray();
							
		return $contractorSites;
	}
	
	public function getEmployeeCount($contractor_id=null)
	{	
		$this->Employees = TableRegistry::get('Employees');
		
		$employeeCount = $this->Employees
        ->find('all')           
        ->where(['contractor_id'=>$contractor_id])
        ->count();

		return $employeeCount;
	}
	
	public function getCreatedBy($user, $activeUser)
	{
		if($activeUser['role_id'] == SUPER_ADMIN) { // if logged in Admin : show email link
		echo $user->username;
		} else { // if logged in client or contractor
			if($user->role->id == SUPER_ADMIN) {
				echo 'CanQualify User';
			}
			elseif(!empty($user->client)) {
				echo $user->client->company_name.' User';
			}
		}
	}
	public function getUserbyRole($user_id=null,$role=null)
	{
		$this->Contractors = TableRegistry::get('Contractors');
		$this->Clients = TableRegistry::get('Clients');
		$users = array();			
				if($role == CONTRACTOR){
				$user = $this->Contractors->find('list', ['keyField'=>'id', 'valueField'=> 'user_id'])->contain(['Users'])->where(['Contractors.id'=>$user_id, 'Users.active IS'=>true])->first();
				}
				elseif($role == CLIENT){
				$user = $this->Clients->find('list', ['keyField'=>'id', 'valueField'=> 'user_id'])->contain(['Users'])->where(['Clients.id'=>$user_id, 'Users.active IS'=>true])->first();
				}			
			return $user;
	}
	public function getClientServices()
    {
	$client_id = $this->getView()->getRequest()->getSession()->read('Auth.User.client_id');

	$this->ClientServices = TableRegistry::get('ClientServices');

	$clientServices = $this->ClientServices
		->find('list', ['keyField'=>'service_id','valueField'=>'service.name'])	
        ->contain('Services')		
		->where(['client_id'=>$client_id])
		->toArray();
	
	return $clientServices;
    }
	public function getEmpQualWithAdmin()
    {		
		$this->ClientServices = TableRegistry::get('ClientServices');		
		$client_id = $this->getView()->getRequest()->getSession()->read('Auth.User.client_id');
				
		$empQualWithAdmin = $this->ClientServices
			->find()
			->select(['id','client_id','service_id','empqual_with_admin'])       	
			->where(['client_id'=>$client_id,'service_id'=>4])
			->first();			
		return $empQualWithAdmin;
		
    }
    public function getEmpReqService()
    {		
		$this->ClientServices = TableRegistry::get('ClientServices');	
		$enable_empReq = 0;	
		$client_id = $this->getView()->getRequest()->getSession()->read('Auth.User.client_id');
				
		$enable_empReq = $this->ClientModules->find('all')->where(['client_id'=>$client_id, 'module_id'=>3])->count();	
		return $enable_empReq;
		
    }
    public function getEmployees($contractor_id=null){
    	$this->Employees = TableRegistry::get('Employees');

    	$employees = $this->Employees
    	->find()
    	->select(['id','pri_contact_fn','pri_contact_ln'])
    	->where(['contractor_id'=>$contractor_id])
    	->enableHydration(false)	
    	->toArray();

    	return $employees;
    }
     public function openTask_enabled($client_id=null){
    	$this->Clients = TableRegistry::get('Clients');

    	$openTask = $this->Clients 
    	->find('list',['id'])
    	->where(['id IN'=>$client_id,'open_task_enabled'=>true])
    	->toArray();

    	return $openTask;
    }
    public function getNaicsCode($contractor_id = null){    	
	    $conn = ConnectionManager::get('default');
	   
		$naics_code = $conn->execute("SELECT contractor_id,naisc_code,title
		FROM naisc_views where contractor_id =$contractor_id ")->fetchAll('assoc');		
	    if(!empty($naics_code)){
	    	$naics_code = $naics_code[0];
	    }
	    return $naics_code;
    }
    public function getCraftCertificate($contractor_id=null,$employee_id = null)
	{ 
		$this->Employees = TableRegistry::get('Employees');
		$this->EmployeeExplanations = TableRegistry::get('EmployeeExplanations');
		$empExpCount = 0;  
		if(!empty($contractor_id)) {
		$contEmp = $this->getContractorEmp($contractor_id);
		/*$contEmp = $this->Employees
        ->find('list', ['keyField'=>'id', 'valueField'=>'id'])
        ->where(['contractor_id'=>$contractor_id])
        ->toArray();*/
         
        if(!empty($contEmp)) {         	 
	        $empExplanations = $this->EmployeeExplanations
	        ->find('all')	       
	        ->contain(['Employees'])        
	        ->where(['employee_id IN'=>$contEmp ])      
	        ->toArray();	        
       	}
   		}
   		if(!empty($employee_id)){
   			$empExplanations = $this->EmployeeExplanations
	        ->find('all')	       
	        ->contain(['Employees'])        
	        ->where(['employee_id'=>$employee_id ])      
	        ->toArray();
   		}
   		if(!empty($empExplanations)){
       		$empExpCount = count($empExplanations);
       }
    	return $empExpCount;

	}

    public function getClientReports($client_id = null)
    {
        $this->ClientReports = TableRegistry::get('ClientReports');
        $reports = $this->ClientReports->find('all')->contain(['Reports'])->where(['client_id'=>$client_id])->toArray();
        return $reports;
    }
}
