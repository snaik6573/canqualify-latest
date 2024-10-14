<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\View\Helper\BreadcrumbsHelper;
use Cake\ORM\TableRegistry;
/**
 * ContractorSites Controller
 *
 * @property \App\Model\Table\ContractorSitesTable $ContractorSites
 *
 * @method \App\Model\Entity\ContractorSite[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ContractorSitesController extends AppController
{
    public function isAuthorized($user)
    {
	$contractorNav = false;
	if(in_array($user['role_id'], ARRAY(SUPER_ADMIN, ADMIN, CLIENT, CLIENT_ADMIN))) {
		$contractorNav = true;
	}
	$this->set('contractorNav', $contractorNav);

	if($this->request->getParam('action')=='unasign') {
		if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN || $user['role_id'] == CR) {
			return true;
		}
	}
        if($this->request->getParam('action')=='manageSites' && in_array($user['role_id'], array(CLIENT, CLIENT_ADMIN))) {
                return true;
        }
	//if (isset($user['role_id']) && $user['active']== 1) {
	if (isset($user['role_id'])) {
		if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN || $user['role_id'] == CONTRACTOR || $user['role_id'] == CONTRACTOR_ADMIN || $user['role_id'] == CR) {
			return true;
		}
	}
	// Default deny
	return false;
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    /*public function index()
    {
	$contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
	$totalCount = $this->ContractorSites->find('all')->count();	
	
        $this->paginate = [
            'conditions'=>['contractor_id'=>$contractor_id,'is_archived'=>false],
            'contain'=>['Contractors', 'Sites'],
            'limit'=>$totalCount,
            'maxLimit'=>$totalCount
        ];
        $contractorSites = $this->paginate($this->ContractorSites);
	//echo '<pre>'; print_r($contractorSites);
        $this->set(compact('contractorSites'));
    }*/

    /**
     * View method
     *
     * @param string|null $id Contractor Site id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $contractorSite = $this->ContractorSites->get($id, [
            'contain'=>['Contractors', 'Clients', 'Sites']
        ]);

        $this->set('contractorSite', $contractorSite);
    }

    function getSlots() {
	$employeeslot = Configure::read('EmployeeQual');


	/* Emp Slot configure */
	$slotArray = ['emplist'=>["Employees : 0 Price : $ 0"],'slots'=>[]];

	for ($i=0; $i <=$employeeslot['range']; $i++) {
		$slot = $i*$employeeslot['base'];
		$slotPrice = $employeeslot['price'] * $i;

		$slotArray['emplist'][$i] =  "Employees : " .$slot." Price : $ ".$slotPrice;

		$slotArray['slots'][$i]['slot'] = $slot;
		$slotArray['slots'][$i]['price'] = $slotPrice;
	}

    return $slotArray;
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function addSlot()
    {
	
		$this->loadModel('TempEmployeeSlots');
		$this->loadModel('PaymentDiscounts');

   		$contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');       
   		
		/* Emp Slot configure */
   		$slotArray = $this->getSlots();

		if ($this->request->is(['patch', 'post', 'put'])) {
		$this->viewBuilder()->setLayout('ajax');
		/* selection Employee slot save */ 
		if($this->request->getData(['emp_slot']) != null ) {	
		    $tempSlots = $this->TempEmployeeSlots->find()->where(['contractor_id'=>$contractor_id])->first();
		    if(empty($tempSlots)) {
  			    $tempSlots = $this->TempEmployeeSlots->newEntity();
  			}
            $emp = $this->request->getData('emp_slot');

			$flag = 0;
			$price = 0;
			$calculatedSlot = 0;
			foreach ($slotArray['slots'] as $key => $value) {
					if($emp <= $value['slot']){
						$flag =1;
						$price = $value['price'];
						$calculatedSlot = $value['slot'];
						break;
					}
			}
			$tempSlots->price = $price;
		    $tempSlots->slot = $calculatedSlot;
		    $tempSlots->contractor_id = $contractor_id;
		    $tempSlots->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
		    $this->TempEmployeeSlots->save($tempSlots);
		}
        $ajaxtrue = 1;
        $this->set(compact('ajaxtrue'));
    	}

    	$slot = $this->TempEmployeeSlots->find()->where(['contractor_id'=>$contractor_id])->first();
    	$canqualify_discounts = $this->PaymentDiscounts->find('all')->where(['contractor_id'=>$contractor_id])->first();
    	if(!empty($canqualify_discounts) && !empty($slot) ){
    		$canq_discount =$canqualify_discounts->discount_price;
			$valid_date =  	$canqualify_discounts->valid_date;
			$todayDate = strtotime(date('m/d/Y'));
			$validDate = strtotime(date('m/d/Y', strtotime($valid_date))); 
			if(!empty($canq_discount)&& $validDate >=$todayDate){
	            $slot['canqualify_discount'] = $canq_discount;
	        }}
	    $this->set(compact('contractor_id','slot'));
    }
    
    public function add()
    {	
	$this->loadModel('Users');
	$this->loadModel('Clients');
	$this->loadModel('Contractors');
	$this->loadModel('ContractorClients');
	$this->loadModel('EmployeeContractors');
	$this->loadModel('EmployeeSites');

	$contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
	$allClients = $this->ContractorSites->Sites->find('list', ['keyField'=>'id', 'valueField'=>'client_id' ])->toArray();   
	$contractorSite = $this->ContractorSites->newEntity();
	if ($this->request->is(['patch', 'post', 'put'])) {       
		if (is_array($this->request->getData('site_id'))) {
			foreach ($this->request->getData('site_id') as $site_id) { // Add
			    //if(!in_array($site_id, $sites)) {
				$ContractorSites = $this->ContractorSites->find('all')->where(['contractor_id'=>$contractor_id,'site_id'=>$site_id])->first();			
					if(!empty($ContractorSites)){
							$this->ContractorSites->query()->update()
								->set(['is_archived'=> false])
								->where(['site_id' => $site_id,'contractor_id'=>$contractor_id])
								->execute();
					}else{		
			        $ContractorSites = $this->ContractorSites->newEntity();
                	$ContractorSites = $this->ContractorSites->patchEntity($ContractorSites, $this->request->getData());
					$ContractorSites->site_id = $site_id;
					$ContractorSites->client_id = $allClients[$site_id];
					$ContractorSites->created_by = $this->getRequest()->getSession()->read('Auth.User.id');	
					$this->ContractorSites->save($ContractorSites);
					/*add it to employees sites*/
                        $emps = $this->EmployeeContractors->find('list', ['keyField'=>'employee_id', 'valueField'=>'employee_id' ])->where(['contractor_id' => $contractor_id])->toArray();
                        if(!empty($emps)){
                            foreach($emps as $k => $employee_id){
                                $employeeSites = $this->EmployeeSites->newEntity();
                                $employeeSites->employee_id = $employee_id;
                                $employeeSites->site_id = $site_id;
                                $employeeSites->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
                                $this->EmployeeSites->save($employeeSites);
                            }
                        }
					}
				//}
		    } 
		    $this->Flash->success(__('The Contractor Sites has been saved.'));
			return $this->redirect(['action' => 'manageSites']);
		}
		
	}
		
	$sites = $this->ContractorSites->find('list', ['keyField'=>'site_id', 'valueField'=>'site_id'])->where(['contractor_id'=>$contractor_id,'is_archived'=>false])->toArray();		
	$contractor_clients = $this->User->getClients($contractor_id);
	
    $where = []; 
	$where['Sites.client_id  IN'] = $contractor_clients;
    if(!empty($sites)) {
            $where['Sites.id NOT IN'] = $sites; 
            //$where['Sites.client_id  IN'] = $contractor_clients;         
    }
	// $clients = $this->Clients
	// ->find()
	// ->select(['id', 'company_name'])
	// ->contain(['Sites'=>['fields'=>['id', 'name', 'client_id'], 'conditions'=>$where]])
	// ->contain(['Users'])		
	// ->where(['Users.active'=>true,'Users.under_configuration'=>false])
	// ->enableHydration(false)
	// ->toArray();

	// $clientSites = array();
 //    foreach ($clients as $cl) {
	//     if(!empty($cl['sites'])){
	// 	    foreach ($cl['sites'] as $site) {				
	// 		    $clientSites[$cl['company_name']][$site['id']] = $site['name'];
	// 	    }			
	//     }
 //    }	
	$userList = $this->Users
        ->find('all')
        ->contain(['ClientUsers'])
        ->contain(['ClientUsers.Clients'])    
        ->contain(['ClientUsers.Clients.Sites'=>['fields'=>['id', 'name', 'client_id'], 'conditions'=>$where]])           
        ->where(['active'=>true,'role_id'=>CLIENT,'Users.under_configuration'=>false])
        ->toArray();
      
    $clients = array();
    foreach ($userList as $key => $user) {
        $client = $user['client_user']['client'];
        //if(!empty($client)){
         $clients[] = $client;
        //}
    }
    $clientSites = array();
    foreach ($clients as $cl) {
	    if(!empty($cl['sites'])){
		    foreach ($cl['sites'] as $site) {				
			    $clientSites[$cl['company_name']][$site['id']] = $site['name'];
		    }			
	    }
    }	

	$contractorSites = $this->Contractors->get($contractor_id, 
        ['contain'=>[
		'Users'=>['fields'=>['Users.id', 'Users.username']],
		'ContractorSites'=>['fields'=>['ContractorSites.id','ContractorSites.contractor_id'],'conditions'=>['is_archived'=>false]],
		'ContractorSites.Sites'=>['fields'=>['name']],
		'ContractorSites.Sites.Clients'=>['fields'=>['company_name']],
		'ContractorSites.Sites.Regions'=>['fields'=>['name']]
	] ]);

    $this->set(compact('contractorSite', 'clientSites', 'contractor_id', 'sites', 'contractorSites'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Contractor Site id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
	    $contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
	
        //$this->request->allowMethod(['post', 'delete']);
		$contractorSite = $this->ContractorSites->get($id);
		$client_id = $this->request->getData('client_id');

		$this->ContractorSites->query()->update()
		->set(['is_archived'=> true])
		->where(['id' => $id])
		->execute();

		$this->Flash->success(__('The contractor site has been deleted.'));
		/*$siteCnt = $this->ContractorSites->find('all')->where(['contractor_id'=>$contractor_id,'client_id'=>$client_id])->count();
		if($siteCnt == 1){
		    $this->Flash->error(__($siteCnt .' The contractor site could not be deleted. Please, try again.'));
		}else{
			if ($this->ContractorSites->delete($contractorSite)) {	
				$this->Flash->success(__('The contractor site has been deleted.'));
			 	} else {
			    $this->Flash->error(__('The contractor site could not be deleted. Please, try again.'));
			 }
		}*/
		return $this->redirect($this->referer());
    }

    public function checkSiteCount(){
	$this->autoRender = false;
	$clientSiteCnt = 0;
	$contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');

    if ($this->request->is(['patch', 'post', 'put'])) {
		$client_id = $this->request->getData('client_id');
		$clientSiteCnt = $this->ContractorSites->find('all')->where(['contractor_id'=>$contractor_id,'client_id'=>$client_id,'is_archived'=>false])->count();
	}
	echo $clientSiteCnt;
    }

    public function manageSites() {
	$this->loadModel('Contractors');

	$contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
	$contractor_clients = $this->User->getClients($contractor_id);
	$contractor = $this->Contractors->get($contractor_id, 
        ['contain'=>[
		'Users'=>['fields'=>['Users.id', 'Users.username']],
		'ContractorSites'=>['fields'=>['ContractorSites.id','ContractorSites.contractor_id'],'conditions'=>['is_archived'=>false]],
		'ContractorSites.Sites'=>['fields'=>['name','she_fname','she_lname','she_title','she_phone','she_email','facility_fname', 'facility_lname', 'facility_title', 'facility_phone', 'facility_email']],
		'ContractorSites.Sites.Clients'=>['fields'=>['company_name','id']],
		'ContractorSites.Sites.Regions'=>['fields'=>['name']]
	] ]);

	$this->set(compact('contractor','contractor_clients'));
    }

    public function unasign($contractor_id=null)
    {
	$client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');

	$this->request->allowMethod(['post', 'delete']);
	$this->ContractorSites->deleteAll(['client_id'=>$client_id, 'contractor_id'=>$contractor_id]);

	$this->Flash->success(__('The contractor has been un-asigned.'));
	return $this->redirect(['controller'=>'Clients', 'action'=>'contractorList']);
    }
}


/*public function siteAdd()
    {
	$this->loadModel('ContractorTempsites');
	$this->loadModel('Clients');	
	$contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');	
	$contractorSite = $this->ContractorTempsites->newEntity();
	
	$selectedSites = $this->ContractorTempsites->find('list', ['keyField'=>'site_id', 'valueField'=>'site_id'])->where(['contractor_id'=>$contractor_id])->toArray();
		
	 $clients = $this->Clients
	->find()
	->select(['id', 'company_name'])
	->contain(['Sites'=>['fields'=>['id', 'name', 'client_id']]])		
	->contain(['Users'])		
	->where(['Users.active'=>true])
	->enableHydration(false)
	->toArray();
	
	$clientSites = array();
	foreach ($clients as $cl) {
		if(!empty($cl['sites'])){		
			foreach ($cl['sites'] as $site) {				
				$clientSites[$cl['company_name']][$site['id']] = $site['name'];
			}			
		}
	}	
	$this->set(compact('contractorSite', 'clientSites', 'contractor_id', 'selectedSites'));	
    }*/

    /**
     * Edit method
     *
     * @param string|null $id Contractor Site id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function edit($id = null)
    {
	$contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
        $contractorSite = $this->ContractorSites->get($id, [
            'contain'=>[]
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contractorSite = $this->ContractorSites->patchEntity($contractorSite, $this->request->getData());
            $contractorSite->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');
            if ($this->ContractorSites->save($contractorSite)) {
                $this->Flash->success(__('The contractor site has been saved.'));
		return $this->redirect($this->referer());
                //return $this->redirect(['controller'=>'Contractors', 'action'=>'index']);
            }
            $this->Flash->error(__('The contractor site could not be saved. Please, try again.'));
        }
        $contractors = $this->ContractorSites->Contractors->find('list', ['limit'=>200]);
        $sites = $this->ContractorSites->Sites->find('list', ['limit'=>200]);
        $this->set(compact('contractorSite', 'contractors', 'sites', 'contractor_id'));
    }*/
