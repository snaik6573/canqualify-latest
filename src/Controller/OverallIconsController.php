<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
require_once("../vendor/aws/aws-autoloader.php"); 
use Aws\S3\S3Client;
use function GuzzleHttp\debug_resource;

/**
 * OverallIcons Controller
 *
 * @property \App\Model\Table\OverallIconsTable $OverallIcons
 *
 * @method \App\Model\Entity\OverallIcon[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OverallIconsController extends AppController
{
    public function isAuthorized($user)
    {
	$clientNav = false;
	$contractorNav = false;

	if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN || $user['role_id'] == CR) {

		if($this->request->getParam('action')=='iconchangeReport' || $this->request->getParam('action')=='safetyStatisticsReport' || $this->request->getParam('action')=='emrCitationFataliiesReport') {
			$clientNav = true;
		}
		if($this->request->getParam('action')=='forceChangeAdmin' ||$this->request->getParam('action')=='view'&& isset($user['contractor_id']))    {
			$contractorNav = true;
		}
	}
	$this->set('clientNav', $clientNav);
	$this->set('contractorNav', $contractorNav);

	if (isset($user['role_id']) && $user['active'] == 1) {
		return true;
	}
	// Default deny
	return false;
    }

    public function setIcons($temp = false, $contractor_id = null)
    {
   	if($temp == true){
		$this->render(false);
	}
	$this->loadModel('Contractors');
	$this->loadModel('SuggestedOverallIcons');

	if($contractor_id == null){
        $contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
    }

	$contractor = $this->Contractors->get($contractor_id);
	$preWaitingStatus = "";

	$waiting_on = $this->User->waiting_status();	

	// update Contractor
	//$contractor->waiting_on = $waiting_on['CanQualify'];
	$contractor->canqualify_date = date(DATE_ATOM);
	$contractor->is_locked = true;
	$contractor->data_submit = 0;
	$this->Contractors->save($contractor);
        $conn = ConnectionManager::get('default');
        $contractorClients = $conn->execute("update contractor_clients set waiting_on= 2 where contractor_id = ".$contractor_id);
	// save Waiting On Logs
	$this->User->saveWaitingOnLog($contractor_id, $preWaitingStatus, $waiting_on['CanQualify'], 'Final submit data');
				
    	//save Icons
        $status = array();
		$contractor_clients = $this->User->getClients($contractor_id);
		foreach($contractor_clients as $client_id) {
            if(isset(BENCHMARK[$client_id])) {
                $componentFilename = BENCHMARK[$client_id];
                $result = $this->$componentFilename->getIcons($contractor_id, $client_id);

            }
            else {
                $result = $this->Benchmark->getIcons($contractor_id, $client_id);
            }
            if(!empty($result)) { $status[$client_id] = $result;}
            if(isset($result['info'])) { $infoMsg = $result['info']; }
        }

    if(!empty($status)) {
	    foreach($status as $k => $s) {
		    $overallIcon = $this->SuggestedOverallIcons->find('all')->where(['client_id'=>$s['client_id'], 'contractor_id'=>$s['contractor_id']])->first();
		    if(!empty($overallIcon)) { // delete old
			    $this->SuggestedOverallIcons->delete($overallIcon);
		    }

		    $overallIcon = $this->SuggestedOverallIcons->newEntity();
		    $overallIcon = $this->SuggestedOverallIcons->patchEntity($overallIcon, $s);
		    //pr($overallIcon);die;
		    $this->SuggestedOverallIcons->save($overallIcon);
	    }

	    //$this->Flash->success(__('The icons has been saved.'));
	  	if($temp == true){
			$this->Flash->success(__('The data has been submitted to be verified / qualified by CanQualify.'));
		}
	   
	    if(isset($infoMsg)) { $this->Flash->error(__($infoMsg)); }
	}
		if($temp == true){
			return $this->redirect(['controller'=>'Contractors', 'action' => 'dashboard', $contractor_id]);
		}
	
	//$this->set(compact('icon'));
    }

    public function forceChange($client_id=null, $contractor_id=null, $review=null,$total_complete=null)
    {
	$this->loadModel('SuggestedOverallIcons');
	$this->loadModel('BenchmarkCategories');
	$this->loadModel('ContractorAnswers');

	$this->viewBuilder()->setLayout('ajax');
	if($total_complete == true){
		$this->setIcons();
		//return $this->redirect(['controller'=>'OverallIcons','action' => 'forceChange',$client_id, $contractor_id, $review]);
	}
	$userId = $this->getRequest()->getSession()->read('Auth.User.id');
	$client = $this->OverallIcons->Clients->find('all')->where(['Clients.id'=>$client_id])->first();
	$categories = $this->BenchmarkCategories->find('list')->where(['client_id'=>$client_id])->toArray();
	//$categories = $this->OverallIcons->Clients->Benchmarks->find('list', ['keyField'=>'id', 'valueField'=>'category'])->order(['id'])->toArray();
	$icons = Configure::read('icons');
	unset($icons[0]);

	$overallIcon = $this->OverallIcons->newEntity();
    if ($this->request->is(['patch', 'post', 'put'])) {
		$overallIcon = $this->OverallIcons->patchEntity($overallIcon, $this->request->getData());

		if(null!==$this->request->getData('icons')) {
			$emrdartstatus = $this->request->getData('icons');
			$overallIcon->icon = $emrdartstatus[0]['icon'];
			if(isset($emrdartstatus['overall_icon'])){
				$overallIcon->icon = $emrdartstatus['overall_icon'];
			}else{
                if(!empty($emrdartstatus) && count($emrdartstatus) > 0){
                                        foreach ($emrdartstatus as $i_status){
                                                if($i_status['icon'] < $overallIcon->icon){
                                                        $overallIcon->icon = $i_status['icon'];
                                                        if(isset($i_status['category'])) {
                                                                $overallIcon->category = $i_status['category'];
                                                            }
                        }
                    }
                }
			/*if(isset($emrdartstatus[0]['category'])) { $overallIcon->category = $emrdartstatus[0]['category']; }

			if(isset($emrdartstatus[1]['icon']) && $emrdartstatus[1]['icon'] < $emrdartstatus[0]['icon']) {
				$overallIcon->icon = $emrdartstatus[1]['icon'];
				if(isset($emrdartstatus[1]['category'])) { $overallIcon->category = $emrdartstatus[1]['category']; }
				}*/
			}
		}

		//$overallIcon->bench_type = 'OVERALL';
		$overallIcon->client_id = $client_id;
		$overallIcon->contractor_id = $contractor_id;
		$overallIcon->created_by = $userId;

		if ($this->OverallIcons->save($overallIcon)) {
            $this->Flash->success(__('The overall icon has been saved.'));
			
			if($review!=null) {
			$this->Notification->addNotification($contractor_id,5,$client_id);
			}else{
			$this->Notification->addNotification($contractor_id,4,$client_id);	
			}
			

				// update Contractor waiting_on status
				$contractor = $this->OverallIcons->Contractors->get($contractor_id);
				$preWaitingStatus = $contractor->waiting_on;
				
				$waiting_on = $this->User->waiting_status();	
				//$contractor->waiting_on = $waiting_on['Complete'];

				$this->OverallIcons->Contractors->save($contractor);

				if($overallIcon->icon == 1){
				    $waiting_on_status = 3;
                }else{
                    $waiting_on_status = 4;
                }
                $conn = ConnectionManager::get('default');
                $contractorClients = $conn->execute("update contractor_clients set waiting_on = ".$waiting_on_status." where contractor_id = ".$contractor_id);
				
				// save Waiting On Logs				
				$this->User->saveWaitingOnLog($contractor_id, $preWaitingStatus, $waiting_on['Complete'], 'CanQualify Review');

		}
		else {
	         	$this->Flash->error(__('The overall icon could not be saved. Please, try again.'));
		}
	}

    $suggestedOverallIcon = $this->SuggestedOverallIcons
	->find()
	->contain(['SuggestedIcons'])
	->contain(['SuggestedIcons.BenchmarkTypes'])
	->where(['SuggestedOverallIcons.client_id'=>$client_id, 'SuggestedOverallIcons.contractor_id'=>$contractor_id])
	->order(['SuggestedOverallIcons.created'=>'DESC'])
	->limit(1)
	->first();

	if($review==null) {
		$overallIconPrev = $this->OverallIcons
		->find()
		->contain(['Icons'])
    	->contain(['Icons.BenchmarkTypes'])
		->where(['OverallIcons.client_id'=>$client_id, 'OverallIcons.contractor_id'=>$contractor_id])
		->order(['OverallIcons.created'=>'DESC'])
		->limit(1)
		->first();
		$this->set(compact('overallIconPrev'));
	}
	$year_range = $this->Category->yearRange();
	if($client_id == 6){
		$year_range = end($year_range);
		//unset($icons[2]);

	}
	$noOfEmp = $this->ContractorAnswers
		->find('list',['keyField'=>'year', 'valueField'=>'answer'])
		->where(['contractor_id'=>$contractor_id, 'Questions.safety_type'=>'FTEMP', 'year IN'=>$year_range])
		->contain(['Questions'])
		->order(['year'=>'ASC'])
		->toArray();

    $this->set(compact('suggestedOverallIcon', 'overallIcon', 'icons', 'client', 'categories', 'userId', 'review', 'noOfEmp', 'client_id', 'contractor_id'));
    }

    public function forceChangeAdmin($client_id=null, $contractor_id=null, $review=null,$total_complete=null)
    {
	$this->loadModel('SuggestedOverallIcons');
	$this->loadModel('BenchmarkCategories');
	$this->loadModel('ContractorAnswers');
	if($total_complete == true){
		$this->setIcons(false, $contractor_id);
		//return $this->redirect(['action' => 'forceChangeAdmin',0, $contractor_id, $review]);
	}
	$contractor = $this->OverallIcons->Contractors->get($contractor_id);
	$preWaitingStatus = $contractor->waiting_on;
	
	$userId = $this->getRequest()->getSession()->read('Auth.User.id');	
	$contractor_clients = $this->User->getClients($contractor_id);

	$icons = Configure::read('icons');
	unset($icons[0]);

	$overallIcon = $this->OverallIcons->newEntity();
    if ($this->request->is(['patch', 'post', 'put'])) {
		if($this->request->getData('current_client_id')!==null) {
			$client_id = $this->request->getData('current_client_id');
	        return $this->redirect(['action' => 'forceChangeAdmin', $client_id, $contractor_id, $review]);
		}

		$overallIcon = $this->OverallIcons->patchEntity($overallIcon, $this->request->getData());

		if(null!==$this->request->getData('icons')) {
			$emrdartstatus = $this->request->getData('icons');
			$overallIcon->icon = $emrdartstatus[0]['icon'];
			if(isset($emrdartstatus['overall_icon'])){
				$overallIcon->icon = $emrdartstatus['overall_icon'];
			}else{
                if(!empty($emrdartstatus) && count($emrdartstatus) > 0){
                                        foreach ($emrdartstatus as $i_status){
                                                if($i_status['icon'] < $overallIcon->icon){
                                                        $overallIcon->icon = $i_status['icon'];
                                                        if(isset($i_status['category'])) {
                                                                $overallIcon->category = $i_status['category'];
                                                            }
                        }
                    }
                }

                /*if(isset($emrdartstatus[0]['category'])) { $overallIcon->category = $emrdartstatus[0]['category']; }
                if(isset($emrdartstatus[1]['icon']) && $emrdartstatus[1]['icon'] < $emrdartstatus[0]['icon']) {
                        $overallIcon->icon = $emrdartstatus[1]['icon'];
                        if(isset($emrdartstatus[1]['category'])) { $overallIcon->category = $emrdartstatus[1]['category']; }
                    }*/
			}
		}

		//$overallIcon->bench_type = 'OVERALL';
		$overallIcon->client_id = $client_id;
		$overallIcon->contractor_id = $contractor_id;
		$overallIcon->created_by = $userId;
		//pr($overallIcon);die;
		if ($this->OverallIcons->save($overallIcon)) {
		    $this->Flash->success(__('The overall icon has been saved.'));
			if($review!=null) {
			$this->Notification->addNotification($contractor_id,5,$client_id);
			}else{
			$this->Notification->addNotification($contractor_id,4,$client_id);	
			}
			// update Contractor
			if($review!=null) {
				$waiting_on = $this->User->waiting_status();
				//$contractor->waiting_on = $waiting_on['Complete'];
				$this->OverallIcons->Contractors->save($contractor);
                if($overallIcon->icon == 1){
                    $waiting_on_status = 3;
                }else{
                    $waiting_on_status = 4;
                }
                $conn = ConnectionManager::get('default');
                $contractorClients = $conn->execute("update contractor_clients set waiting_on = ".$waiting_on_status." where contractor_id = ".$contractor_id);
				
				// save Waiting On Logs				
				$this->User->saveWaitingOnLog($contractor_id, $preWaitingStatus, $waiting_on['Complete'], 'CanQualify Review');
			}
		}
		else {
		 	$this->Flash->error(__('The overall icon could not be saved. Please, try again.'));
		}
	}

	//$clients = $this->OverallIcons->Clients->find('list', ['keyField'=>'id', 'valueField'=>'company_name'])->toArray();
	$clients = $this->OverallIcons->Clients->find('list', ['keyField'=>'id', 'valueField'=>'company_name'])->where(['id IN'=>$contractor_clients])->toArray();

	if($client_id!=0) {
		$client = $this->OverallIcons->Clients->find('all')->where(['Clients.id'=>$client_id])->first();
		$categories = $this->BenchmarkCategories->find('list')->where(['client_id'=>$client_id])->toArray();

        // get suggestedOverallIcon for Canqualify Review
		$suggestedOverallIcon = $this->SuggestedOverallIcons
		->find()
		->contain(['SuggestedIcons'])
	    ->contain(['SuggestedIcons.BenchmarkTypes'])
		->where(['SuggestedOverallIcons.client_id'=>$client_id, 'SuggestedOverallIcons.contractor_id'=>$contractor_id])
		->order(['SuggestedOverallIcons.created'=>'DESC'])
		->limit(1)
		->first();

		if($review==null) { // get previous icons for Force Change
			$overallIconPrev = $this->OverallIcons
			->find()
			->contain(['Icons'])
        	->contain(['Icons.BenchmarkTypes'])
			->where(['OverallIcons.client_id'=>$client_id, 'OverallIcons.contractor_id'=>$contractor_id])
			->order(['OverallIcons.created'=>'DESC'])
			->limit(1)
			->first();
			$this->set(compact('overallIconPrev'));
		//pr($overallIconPrev);
		}
		$this->set(compact('client','categories','suggestedOverallIcon'));
	}
	
	$year_range = $this->Category->yearRange();
	if($client_id == 6){
		$year_range = end($year_range);
		//unset($icons[2]);

	}
	$noOfEmp = $this->ContractorAnswers
		->find('list',['keyField'=>'year', 'valueField'=>'answer'])
		->where(['contractor_id'=>$contractor_id, 'Questions.safety_type'=>'FTEMP', 'year IN'=>$year_range])
		->contain(['Questions'])
		->order(['year'=>'ASC'])
		->toArray();

	$this->set(compact('contractor', 'clients', 'overallIcon', 'icons', 'userId', 'review', 'noOfEmp', 'client_id'));
    }

    public function safetystatisticsReport($exportType=null)
    {
	$this->loadModel('Contractors');
	$this->loadModel('CanqYears');	
	$client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
    $client_contractors = array();
	$waiting_on = $this->User->waiting_status_ids();
	array_shift($waiting_on); // skips 1st status
    if(!empty($client_id)){
	$client_contractors = $this->User->getContractors($client_id, $waiting_on);
    }
	$categories = array('TRIR'=>'TRIR', 'LWCR'=>'LWCR', 'DART'=>'DART');	
	$year_range = $this->Category->yearRange(1);
	$yearSelected = array();
	$categoriesSelected = array();
	$contractors = array();
	$report = array();

	if(!empty($client_contractors)) {
	$contractors = $this->Contractors->find('list', ['keyField'=>'id', 'valueField'=>'company_name'])->where(['id IN'=>$client_contractors])->order('company_name');

	if ($this->request->is(['patch', 'post', 'put'])) {
		$contractor_ids = $this->request->getData('contractor_id')!='' ? array($this->request->getData('contractor_id')) : array();
		$yearSelected = $this->request->getData('year');
		$categoriesSelected = $this->request->getData('category');
		$report = $this->Safetyreport->getSafetyStatisticsReport($client_id, $contractor_ids, $yearSelected, $categoriesSelected);
	}
	}
		$i =0;
		$data = array();		
		if(!empty($report)) {				
			foreach ($report as $r) {
				foreach ($r['categories'] as $cat => $years) {
					$data[$i]['company_name'] = $r['company_name'];
					$data[$i]['category'] = $cat;
					foreach ($years as $year=>$value) {
						$data[$i][$year] = $value;
					}
					$i++;
				}
			}		
		}
		
	$this->set(compact('client_id', 'yearSelected', 'categoriesSelected', 'contractors', 'categories','year_range','report'));
    }

    public function emrCitationFataliiesReport()
    {
	$this->loadModel('Contractors');
	$client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
    $client_contractors = array();
	$waiting_on = $this->User->waiting_status_ids();
	array_shift($waiting_on); // skips 1st status
    if(!empty($client_id)){
	$client_contractors = $this->User->getContractors($client_id, $waiting_on);
    }
	$categories = array('EMR'=>'EMR', 'Citations'=>'Citations', 'Fatalities'=>'Fatalities');
	$years = $this->Category->yearRange('all');	
	$yearSelected = array();
	$categoriesSelected = array();
	$contractors = array();
	$report = array();

	if(!empty($client_contractors)) {
	$contractors = $this->Contractors->find('list', ['keyField'=>'id', 'valueField'=>'company_name'])->where(['id IN'=>$client_contractors])->order('company_name');
	if ($this->request->is(['patch', 'post', 'put'])) {
		$contractor_id = $this->request->getData('contractor_id')!='' ? array($this->request->getData('contractor_id')) : array();

		$yearSelected = $this->request->getData('year');
		$categoriesSelected = $this->request->getData('category');

		if($categoriesSelected=='EMR') {
			$report = $this->Safetyreport->getEMRReport($client_id, $contractor_id, $yearSelected);
		}
		elseif($categoriesSelected=='Citations') {
			$report = $this->Safetyreport->getCitationsReport($client_id, $contractor_id, $yearSelected);
		}
		else {
			$report = $this->Safetyreport->getFatalitiesReport($client_id, $contractor_id, $yearSelected);
		}
	}
	}
	$this->set(compact('client_id', 'yearSelected', 'categoriesSelected', 'contractors', 'categories','years','report'));
    }


    public function iconchangeReport($export_type=null)
    {
	$this->loadModel('Contractors');
	$this->loadModel('Users');

	$client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
	$client = $this->OverallIcons->Clients->find('all')->where(['Clients.id'=>$client_id])->first();
    $client_contractors = array();
    $iconList = Configure::read('icons');
	/*$waiting_on = $this->User->waiting_status();
	array_shift($waiting_on); // skips 1st status
    if(!empty($client_id)){
	$client_contractors = $this->User->getContractors($client_id, $waiting_on);
    }
	$contList = array();
	if(!empty($client_contractors)) {
		$contList = $this->Contractors
		->find('all')
		->select(['id', 'company_name'])
		->where(['Contractors.id IN' => $client_contractors])
		->contain(['States'])
		->contain(['Users'=>['fields'=>['username','active']]])*/
		/*->contain(['OverallIcons' => [
			'fields'=>['icon','contractor_id'],
			'conditions'=> ['OverallIcons.client_id'=>$client_id],
			'queryBuilder' => function ($q) { return $q->order(['OverallIcons.created' =>'DESC'])->limit(1);}
		]])*/
		/*->toArray();
	}*/

    if(!empty($client_id)){
	//$client_contractors = $this->User->getContractors($client_id);
        if($this->User->isClientUser()){
            $locationFilter = $this->User->getClientUserSites();
            $isClientUser = true;
        }
        if(!empty($locationFilter)){
            $client_contractors = $this->User->getContractors($client_id, array(), true, $locationFilter);
        }else{
            $client_contractors = $this->User->getContractors($client_id);
        }
    }
	$contList = array();
	if(!empty($client_contractors)) {
		$contList = $this->Contractors
		->find('all')
		->select(['id', 'company_name'])
		->where(['Contractors.id IN' => $client_contractors])
		->contain(['States'])
		->contain(['Users'=>['fields'=>['username','active']]])
		->contain(['OverallIcons' => [
			'conditions'=> ['OverallIcons.client_id'=>$client_id],
			'queryBuilder' => function ($q) { return $q->order(['OverallIcons.created' =>'DESC']);}
		]])	
		->contain(['OverallIcons.Icons'])
        	->contain(['OverallIcons.Icons.BenchmarkTypes'])	
		->order(['Contractors.company_name'=>'ASC'])
		->toArray();
		
	}
	//pr($contList);die;
	$users= array();
	$userData = $this->Users->find()->contain(['Roles','CanQualifyUsers','ClientUsers'=>['conditions'=>['role_id'=>CLIENT]],'ClientUsers.Clients'])->toArray();
	foreach ($userData as $key => $u) {
		if($u->role_id == $u->role['id']){
			$role_name = $u->role['role_title'];
		}
		$users[$u->id] = $u->id;
		if($u->client_user['user_id'] == $u->id){
		  $users[$u->id] = $u->client_user['pri_contact_fn']." ".$u->client_user['pri_contact_ln']." (".$u->client_user['client']['company_name'].")";
		}
		foreach ($u['canqualify_users'] as $key2 => $v) {
			if($v->user_id == $u->id){
			$users[$u->id] = $v->first_name." ".$v->last_name." (CanQualify)" ;
			//$users[$u->id] = $v->first_name." ".$v->last_name." (".$role_name.")" ;
			}
		}
	}
	 if($export_type != '0') {
    	$i =0;
    	$icon_from_deault = 0;
    	$data = array();		
    	if(!empty($contList)) {				
    		foreach ($contList as  $contractor) {   
    		foreach ($contractor->overall_icons as $overallIcon){
	    		if($overallIcon->review){
	            	$type ='Review';
	        	}else if($overallIcon->is_forced) {
	           		$type ='Forced Icon';
	        	}else{
	            	$type ='System';
	        	}                 
	            $forced_by = 'System';
				$iconFromStatus = $overallIcon->icon_from!=null ? $overallIcon->icon_from :  $icon_from_deault;
	       		$iconStatus = $overallIcon->icon;
				$notes = $overallIcon->notes;
				$notes= strip_tags($notes);
				$created = $overallIcon->created;
				if($overallIcon->is_forced && isset($users[$overallIcon->created_by])) { 
					$forced_by = $users[$overallIcon->created_by]; 
				}		   
				$data[$i]['icon_from'] = $iconList[$iconFromStatus]; 
				$data[$i]['iconStatus'] = $iconList[$iconStatus]; 
	    		$data[$i]['company_name'] = $contractor['company_name'];
	            $data[$i]['notes'] = $notes;	
	    		$data[$i]['created'] = $created.'-'.$forced_by;
	    		$data[$i]['type'] = $type;	               		
	                               				
	    		$i++;
    		}}
    	    }		

    	    $headT = array('System Review','Force Icon','Contractor / Supplier','Notes','Generated On','Type');	
            $title =$client['company_name'];
        	if($export_type == 'excel') { 
        			$this->Export->XportIconReportExcel($data,$headT,$title,$i); 
        			exit;
        	}
        	if($export_type == 'csv') {
        			$this->Export->XportIconReportCSV($data,$headT,$title,$i);
        			exit;
        	}
    	}
	$this->set(compact('contList', 'client_id', 'users'));
    }
	
    public function addDefaultIcon()
    {	
	$this->loadModel('Payments');	
	$this->loadModel('Contractors');

	$contractorIds = $this->Contractors->find('list', ['keyField'=>'id', 'valueField'=>'id' ])->where(['payment_status'=>1])->enableHydration(false)->toArray();
	foreach($contractorIds as $contractor_id) {
		$client_ids = $this->User->getClients($contractor_id);
		foreach($client_ids as $client_id) {
			$overallIcon = $this->Contractors->OverallIcons->newEntity();
			$overallIcon->client_id = $client_id;
			$overallIcon->contractor_id = $contractor_id;
			//$overallIcon->bench_type = 'OVERALL';
			$overallIcon->icon = 0;
			$overallIcon->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
			$this->Contractors->OverallIcons->save($overallIcon);					
		}	
	}
	$conn = ConnectionManager::get('default');
	$contractorUpdate = $conn->execute("update contractors set is_locked=false where payment_status=true");
    }
	

    // Update SuggestedOverallIcons category, OverallIcons category for BAE contractors
    /*public function setIconCat()
    {
	$this->BenchmarkBAE->setIconCat();
    }*/

    // Update OverallIcons category, Icons category for BAE contractors
    /*public function setIconCat2()
    {
	// update dart category
	$this->OverallIcons->Icons->query()->update()->set(['category'=>1])->where(['bench_type'=>'DART', 'category'=>6])->execute();
	$this->OverallIcons->Icons->query()->update()->set(['category'=>2])->where(['bench_type'=>'DART', 'category'=>7])->execute();
	$this->OverallIcons->Icons->query()->update()->set(['category'=>3])->where(['bench_type'=>'DART', 'category'=>8])->execute();
	$this->OverallIcons->Icons->query()->update()->set(['category'=>4])->where(['bench_type'=>'DART', 'category'=>9])->execute();
	$this->OverallIcons->Icons->query()->update()->set(['category'=>5])->where(['bench_type'=>'DART', 'category'=>10])->execute();

	// update Overall category
	$contractors = $this->OverallIcons->Icons->find()->where(['bench_type'=>'EMR','category is not'=>null])->toArray();
	foreach($contractors as $emrIcon) {
		$dartIcon = $this->OverallIcons->Icons->find()->where(['bench_type'=>'DART', 'overall_icon_id'=>$emrIcon->overall_icon_id])->first();
		if(!empty($dartIcon)) {
			//pr($dartIcon);
			echo $emrIcon['category'].' :: '.$dartIcon['category'].'<br>';

			$cat = $emrIcon['category'];
			if($dartIcon['icon'] < $emrIcon['icon']) {
				$cat = $dartIcon['category'];
			}

			$this->OverallIcons->query()
				->update()
				->set(['category' => $cat])
				->where(['id'=>$emrIcon->overall_icon_id])
				->execute();
		}
	}
    }*/

    /*public function saveimage() {
	//$this->request->allowMethod('ajax');   
	if ($this->request->is(['patch', 'post', 'put'])) {
		$imgBody = $this->request->getData('imgBody');
		$source = fopen($imgBody, 'r');
		$destination = fopen(EXPORT_IMG.'image.png', 'w');
		stream_copy_to_stream($source, $destination);
		fclose($source);
		fclose($destination);
	}
    }*/

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    /*public function index()
    {
        $this->paginate = [
            'contain' => ['Clients', 'Contractors']
        ];
        $overallIcons = $this->paginate($this->OverallIcons);

        $this->set(compact('overallIcons'));
    }*/

    /**
     * View method
     *
     * @param string|null $id Overall Icon id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $overallIcon = $this->OverallIcons->get($id, [
            'contain' => ['Clients', 'Contractors', 'Icons','BenchmarkCategories']
        ]);
        $this->set('overallIcon', $overallIcon);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    /*public function add()
    {
        $overallIcon = $this->OverallIcons->newEntity();
        if ($this->request->is('post')) {
            $overallIcon = $this->OverallIcons->patchEntity($overallIcon, $this->request->getData());
            if ($this->OverallIcons->save($overallIcon)) {
                $this->Flash->success(__('The overall icon has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The overall icon could not be saved. Please, try again.'));
        }
        $clients = $this->OverallIcons->Clients->find('list', ['limit' => 200]);
        $contractors = $this->OverallIcons->Contractors->find('list', ['limit' => 200]);
        $this->set(compact('overallIcon', 'clients', 'contractors'));
    }*/

    /**
     * Edit method
     *
     * @param string|null $id Overall Icon id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
  
    /**
     * Delete method
     *
     * @param string|null $id Overall Icon id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $overallIcon = $this->OverallIcons->get($id);
        if ($this->OverallIcons->delete($overallIcon)) {
            $this->Flash->success(__('The overall icon has been deleted.'));
        } else {
            $this->Flash->error(__('The overall icon could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }*/

      public function edit($id=null)
        {
        $this->loadModel('SuggestedOverallIcons');
	    $this->loadModel('BenchmarkCategories');

        $this->viewBuilder()->setLayout('ajax');
        
        $overallIcon = $this->OverallIcons->get($id, [
            'contain' => ['Icons']
        ]);

        $icons = Configure::read('icons');
	    unset($icons[0]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $overallIcon = $this->OverallIcons->patchEntity($overallIcon, $this->request->getData());
            $overallIcon->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');

            if(null!==$this->request->getData('icons')) {
			    $defaultstatus = $this->request->getData('icons');
			    $overallIcon->icon = $defaultstatus[0]['icon'];
			    if(isset($defaultstatus[0]['category'])) { $overallIcon->category = $defaultstatus[0]['category']; }

                foreach($this->request->getData('icons') as $icon) {
			    if($icon['icon'] < $overallIcon->icon) {
				    $overallIcon->icon = $icon['icon'];
				    if(isset($icon['category'])) { $overallIcon->category = $icon['category'];}                
                }               
                }
		    }
            if ($this->OverallIcons->save($overallIcon)) {
                $this->Flash->success(__('The overall icon has been saved.'));                
            }else{
            $this->Flash->error(__('The overall icon could not be saved. Please, try again.'));
        } }
	    $client_id = $overallIcon->client_id;
        $client = $this->OverallIcons->Clients->find('all')->where(['Clients.id'=>$client_id])->first();
	    $categories = $this->BenchmarkCategories->find('list')->where(['client_id'=>$client_id])->toArray();

	    $this->set(compact('overallIcon','client','categories','icons'));
	    }

	public function iconNotes($id = null)
    {
      $this->viewBuilder()->setLayout('ajax');
       $overallIcon = $this->OverallIcons->get($id, [
            'contain' => []
        ]);
        $this->set('overallIcon', $overallIcon);
    }

    /*new review function*/
    public function reviewSupplier($contractor_id = null, $client_id = null){

        /*load models*/
        $this->loadModel('Benchmarks');
        $this->loadModel('BenchmarkTypes');
        $this->loadModel('Clients');
        $this->loadModel('Contractors');
        /*function array*/
        $getBenchmarkFunction = array(1 => 'getEMR', 2 => 'getDART');
        $icons = Configure::read('icons');
        unset($icons[0]);

        if($contractor_id != null && $client_id != null){
            /*get client info*/
            $client = $this->Clients->find()->where(['id' => $client_id])->first();

            /*get contractor info*/
            $contractor = $this->Contractors->find()->where(['id' => $contractor_id])->first();

            $bNameList = $this->BenchmarkTypes->find('list',['keyField' => 'id', 'valueField' => 'name'])->toArray();

            /*get client benchmarks*/
            $benchmarkTypes = $this->Benchmarks->find('list',['keyField' => 'benchmark_type_id', 'valueField' => 'benchmark_type_id'])->where(['client_id' => $client_id])->toArray();
            $CbenchmarkTypes = $this->Benchmarks->find('all')
                                ->where(['client_id' => $client_id])
                                ->contain(['BenchmarkTypes' => ['fields' => ['name']]])
                                ->toArray();

            $suggestedIcons = array();
            if(!empty($benchmarkTypes)){
                foreach ($benchmarkTypes as $benchmark){
                    //debug($benchmark);

                    switch($benchmark){
                        /*EMR*/
                        case 1:
                            $clientBenchmarks = $this->Benchmarks->find('all')->where(['client_id' => $client_id, 'benchmark_type_id' => $benchmark])->toArray();
                            $EMR = $this->Safetyreport->getEMR($contractor_id);
                            $isEMR = 0;
                            foreach ($clientBenchmarks as $range){
                                if($EMR['avg'] >= $range->range_from)
                                {
                                    if($range->range_to != 0 && $EMR['avg'] < $range->range_to){
                                        $isEMR = $range->icon;
                                    }else{
                                        $isEMR = $range->icon;
                                    }

                                }
                            }
                            $suggestedIcons[$benchmark]['icon'] = $isEMR;
                            $suggestedIcons[$benchmark]['info'] = $EMR;
                            break;
                        /*DART*/
                        case 2:
                            $clientBenchmarks = $this->Benchmarks->find('all')->where(['client_id' => $client_id, 'benchmark_type_id' => $benchmark])->toArray();
                            $DART = $this->Safetyreport->getDART($contractor_id);
                            $isDART = 0;
                            foreach ($clientBenchmarks as $range){
                                if($DART['avg'] >= $range->range_from)
                                {
                                    if($range->range_to != 0 && $DART['avg'] < $range->range_to){
                                        $isDART  = $range->icon;
                                    }else{
                                        $isDART = $range->icon;
                                    }

                                }
                            }
                            $suggestedIcons[$benchmark]['icon'] = $isDART;
                            $suggestedIcons[$benchmark]['info'] = $DART;
                            break;
                        /*citation*/
                        case 9:
                            $citations = $this->Safetyreport->getCitations($contractor_id);
                            $isCitation = 3;
                            if(!empty($citations['year'])){
                                foreach ($citations['year'] as $y => $cit){
                                    if($cit > 0){
                                        $isCitation = 1;
                                        $suggestedIcons[$benchmark]['defaulters'][$y] = 'redBg';
                                    }
                                }
                            }
                            $suggestedIcons[$benchmark]['icon'] = $isCitation;
                            $suggestedIcons[$benchmark]['info'] = $citations;
                            break;
                        /*fatality*/
                        case 17:
                            $fatalities = $this->Safetyreport->getFatalities($contractor_id);
                            $isFatality = 3;
                            if(!empty($fatalities['year'])){
                                foreach ($fatalities['year'] as $y => $fat){
                                    if($fat > 0){
                                        $isFatality = 1;
                                        $suggestedIcons[$benchmark]['defaulters'][$y] = 'redBg';
                                    }
                                }
                            }
                            $suggestedIcons[$benchmark]['icon'] = $isFatality;
                            $suggestedIcons[$benchmark]['info'] = $fatalities;
                            break;

                    }

                }

            }else{
                $this->Flash->error(__('Benchmarks not found for client.'));
                return $this->redirect(['controller'=>'Contractors', 'action' => 'dashboard', $contractor_id]);
            }
        }else{
            $this->Flash->error(__('Client ID and/or Supplier ID missing.'));
            return $this->redirect(['controller'=>'Contractors', 'action' => 'index']);
        }
        //debug($suggestedIcons);
        $this->set(compact('suggestedIcons', 'CbenchmarkTypes', 'client', 'contractor', 'bNameList', 'icons'));

    }

    public function saveReview(){

        $success = '';
        $error = '';
        $suggestedOverallIcon_id = 0;
        $overallIcon_id = 0;

        $userId = $this->getRequest()->getSession()->read('Auth.User.id');

        $this->loadModel('ContractorClients');
        $this->loadModel('SuggestedIcons');
        $this->loadModel('SuggestedOverallIcons');
        $this->loadModel('Icons');
        $this->loadModel('OverallIcons');

        $contractorClient = $this->ContractorClients->newEntity();
        $suggestedOverallIcon = $this->SuggestedOverallIcons->newEntity();
        $suggestedIcon = $this->SuggestedIcons->newEntity();
        $overallIcon = $this->OverallIcons->newEntity();
        $icon = $this->Icons->newEntity();


        if ($this->request->is(['patch', 'post', 'put'])) {
            /*save suggested overall icon*/
            if(!empty($this->request->getData('suggested_overall_icon'))){
                $suggetedOverallIconData = $this->request->getData('suggested_overall_icon');
                $contractor_id = $suggetedOverallIconData['contractor_id'];
                $client_id = $suggetedOverallIconData['client_id'];

                $suggestedOverallIcon = $this->SuggestedOverallIcons->patchEntity($suggestedOverallIcon, $this->request->getData('suggested_overall_icon'));
                $suggestedOverallIcon->created_by = $userId;
                $suggestedOverallIcon->modified_by = $userId;
                $suggestedOverallIconSave = $this->SuggestedOverallIcons->save($suggestedOverallIcon);
                //debug($suggestedOverallIconSave);
                if ($suggestedOverallIconSave) {
                    $success.= ' Suggested Overall Icon saved successfully.';
                    $suggestedOverallIcon_id = $suggestedOverallIconSave->id;
                }else{
                    $error .= ' Suggested Overall Icon not saved.';
                }
            }

            /*save suggested icons*/
            if(!empty($this->request->getData('suggested_icon'))){
                $suggestedIconData = $this->request->getData('suggested_icon');

                if($suggestedOverallIcon_id != 0){
                    foreach ($suggestedIconData as $suggestedIconSingle){
                        $suggestedIcon = $this->SuggestedIcons->newEntity();
                        $suggestedIcon = $this->SuggestedIcons->patchEntity($suggestedIcon, $suggestedIconSingle);
                        $suggestedIcon->suggested_overall_icon_id = $suggestedOverallIcon_id;
                        $suggestedIcon->contractor_id = $contractor_id;
                        $suggestedIcon->client_id = $client_id;
                        //debug($suggestedIcon);
                        if ($this->SuggestedIcons->save($suggestedIcon)) {
                            $success .= ' Suggested Icon saved successfully.';
                            //echo 'saved';
                        }else{
                            $error .= ' Suggested Icon not saved.';
                            //echo 'not saved';
                        }
                    }

                }


            }
            /*save overall icon*/
            if(!empty($this->request->getData('overall_icon'))){
                $overallIconData = $this->request->getData('overall_icon');
                $overallIcon = $this->OverallIcons->newEntity();
                $overallIcon = $this->OverallIcons->patchEntity($overallIcon, $overallIconData);
                $overallIcon->created_by = $userId;
                $overallIcon->modified_by = $userId;
                if(empty($overallIconData['notes'])) {
                    $overallIcon->notes = "";
                }
                $overallIconSave = $this->OverallIcons->save($overallIcon);
                if ($overallIconSave) {
                    $success .= ' Overall Icon saved successfully.';
                    $overallIcon_id = $overallIconSave->id;
                }else{
                    $error .= ' Overall Icon not saved.';
                }
            }
            /*save icons*/
            /*derive overall icon*/
            $iconArr = array();
            if(!empty($this->request->getData('icon'))){
                $iconData = $this->request->getData('icon');
                if($overallIcon_id != 0){
                    foreach ($iconData as $iconSingle){
                        array_push($iconArr, $iconSingle['icon']);
                        $icon = $this->Icons->newEntity();
                        $icon = $this->Icons->patchEntity($icon, $iconSingle);
                        $icon->contractor_id = $contractor_id;
                        $icon->client_id = $client_id;
                        $icon->overall_icon_id = $overallIcon_id;
                        $icon->bench_type = $iconSingle['benchmark_type_id'];
                        if ($this->Icons->save($icon)) {
                            $success .= ' Icon saved successfully.';
                        }else{
                            $error .= ' Icon not saved.';
                        }
                    }

                }


            }
            /*update overall icon*/
            $finalOverallIcon = min($iconArr);
            $overallIcon = $this->OverallIcons->get($overallIcon_id);
            $overallIcon = $this->OverallIcons->patchEntity($overallIcon, array('icon' => $finalOverallIcon));
                if ($this->OverallIcons->save($overallIcon)) {
                    $success .= ' Final Overall Icon saved successfully.';
                }else{
                    $error .= ' Final Overall Icon not saved.';
                }
            /*update waiting on status*/
            $getContractorClient = $this->ContractorClients->find('all')->where(['contractor_id'=>$contractor_id,'client_id'=>$client_id])->first();
            if(!empty($getContractorClient->id)){
                $contractorClient = $this->ContractorClients->get($getContractorClient->id);
                $contractorClient = $this->ContractorClients->patchEntity($contractorClient, array('waiting_on' => 4));
                if ($this->ContractorClients->save($contractorClient)) {
                    $success .= ' waiting on status updated successfully.';
                }else{
                    $error .= ' waiting on status not updated.';
                }
            }


            //$this->set(compact('success', 'error'));
            if($success != ''){
                $this->Flash->success($success);
            }
            if($error != ''){
                $this->Flash->error($error);
            }

            return $this->redirect(['controller' => 'Contractors', 'action' => 'dashboard',$contractor_id]);

        }else{
            return $this->redirect(['controller' => 'Contractors', 'action' => 'index']);
        }

    }
}
