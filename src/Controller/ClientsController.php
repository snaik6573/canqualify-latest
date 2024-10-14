<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\Helper\BreadcrumbsHelper;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
// require_once("../vendor/aws/aws-autoloader.php"); 
use Aws\S3\S3Client;
use Cake\Mailer\MailerAwareTrait;  
/**
 * Clients Controller
 *
 * @property \App\Model\Table\ClientsTable $Clients
 *
 * @method \App\Model\Entity\Client[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ClientsController extends AppController
{    
	use MailerAwareTrait;
    public function isAuthorized($user)
    {
	$clientNav = false;

	if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN) {
		$clientNav = true;
		/*if($this->request->getParam('action')=='dashboard') {
			$this->getRequest()->getSession()->write('Auth.User.client_id', $this->request->getParam('pass.0'));
			$this->set('activeUser', $this->getRequest()->getSession()->read('Auth.User'));
		}*/
	}
	$this->set('clientNav', $clientNav);

	if($this->request->getParam('action')=='index') {
		if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN) {
			return true; 
		}
	}
	elseif($this->request->getParam('action')=='myProfile') {
		if($user['role_id'] != CLIENT) {
			return false; 
		}
	}
	if (isset($user['role_id']) && $user['active'] == 1) {
		if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN || $user['role_id'] == CLIENT || $user['role_id'] == CLIENT_ADMIN || $user['role_id'] == CLIENT_VIEW || $user['role_id'] == CLIENT_BASIC) {
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
    public function index()
    {
    	$totalCount = $this->Clients->find('all')->count();
		$this->paginate = [
            'contain'=>['AccountTypes', 'Sites', 'Sites.States', 'Sites.Countries', 'Users'],
            'limit'=>$totalCount,
            'maxLimit'=>$totalCount			
        ];
        $clients = $this->paginate($this->Clients);
        $this->set(compact('clients'));

		if ($this->request->is(['patch', 'post', 'put'])) {
	    $this->viewBuilder()->setLayout('ajax');
        $client = $this->Clients->find()->where(['Users.username'=>$this->request->getData('user.username')])->contain(['Users'])->first();
        $client = $this->Clients->patchEntity($client, $this->request->getData());
        if ($this->Clients->save($client)) {
			echo '<div class="alert with-close alert-success alert-dismissible fade show" role="alert">The contractor has been saved.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
	    }
	    else {
			echo '<div class="alert with-close alert-danger alert-dismissible fade show" role="alert">The contractor could not be saved. Please, try again.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
	    }
	    exit;
		}
    }

    /**
     * View method
     *
     * @param string|null $id Client id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
	$this->loadModel('ClientUsers');
        // $client = $this->Clients->get($id, [
        //     'contain'=>['AccountTypes', 'States', 'Countries', 'ClientServices', 'ClientServices.Services', 'Sites','Sites.Regions']
        // ]);

        $clientUser = $this->ClientUsers->find()
			->contain(['Users'=>['fields'=>['Users.id', 'Users.username', 'Users.active']]])
			->contain(['Clients'])
			->contain(['Clients.ClientServices'])
			->contain(['Clients.ClientServices.Services'=>['fields'=>['id', 'name']]])
			->contain(['Clients.AccountTypes'])
			->contain(['Clients.States'])
			->contain(['Clients.Countries'])
			->contain(['Clients.Sites'=>['fields'=>['id', 'name', 'client_id']]])
			->contain(['Clients.Sites.Regions'=>['fields'=>['name']]])
			->where(['client_id'=>$id,'Users.role_id'=>CLIENT])
			->first();

	$this->set(compact('clientUser'));
    }

   

   public function addquestions($cid = null)
   {
	$this->loadModel('Questions');

	$question = $this->Questions->newEntity();
        if ($this->request->is(['patch', 'post', 'put'])) { 
            $question = $this->Questions->patchEntity($question, $this->request->getData());
            $question->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
            $question->question_options = json_encode(explode("\r\n", $this->request->getData('question_options')));
            if ($this->Questions->save($question)) {
                $this->Flash->success(__('The question has been saved.'));
                return $this->redirect(['action'=>'add/'.$this->request->getData('step').'/'.$cid]);
            }
  	    else {
                $this->Flash->error(__('The question could not be saved. Please, try again.'));
                return $this->redirect(['action'=>'add/'.$this->request->getData('step').'/'.$cid]);
            }
        }
	$question = $this->Questions->find()->where(['client_id'=>$cid]); 
	$this->set(compact('question'));
	$this->Render(false);   
   }

    public function sitesdelete($id = null)
    {
	$this->viewBuilder()->setLayout('ajax');	
	$this->loadModel('Sites');	
        $this->request->allowMethod(['post', 'delete']);
        $site = $this->Sites->get($id);
        if ($this->Sites->delete($site)) {
            $this->Flash->success(__('The site has been deleted.'));
        } else {
            $this->Flash->error(__('The site could not be deleted. Please, try again.'));
        }
	$this->Render(false);        
    }
    public function regiondelete($id = null)
    {
	$this->viewBuilder()->setLayout('ajax');
	$this->loadModel('Regions');	
        $this->request->allowMethod(['post', 'delete']);
        $region = $this->Regions->get($id);
        if ($this->Regions->delete($region)) {
            $this->Flash->success(__('The region has been deleted.'));
        } else {
            $this->Flash->error(__('The region could not be deleted. Please, try again.'));
        }
	$this->Render(false);
    }

    public function questiondelete($id = null)
    {
	$this->viewBuilder()->setLayout('ajax');
	$this->loadModel('Questions');	
        $this->request->allowMethod(['post', 'delete']);
        $region = $this->Questions->get($id);
        if ($this->Questions->delete($region)) {
            $this->Flash->success(__('The Questions has been deleted.'));
        } else {
            $this->Flash->error(__('The Questions could not be deleted. Please, try again.'));
        }
	$this->Render(false);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
   public function add($step = 1, $id = null )
    {		
	$this->loadModel('Services');	
	$this->loadModel('Questions');
	$this->loadModel('QuestionTypes');
	$this->loadModel('CustomerRepresentative');
	$this->loadModel('Clients');
	$this->loadModel('ClientServices');
	$this->loadModel('ClientModules');
	$this->loadModel('Contractors');
	$this->loadModel('ContractorSites');
	$this->loadModel('Modules');
	$this->loadModel('Leads');
	$this->loadModel('Notifications');
    $this->loadModel('ClientQuestions');
    $this->loadModel('Users');
    $this->loadModel('Countries');
    $this->loadModel('States');
    
	$user_id = $this->getRequest()->getSession()->read('Auth.User.id');
	$saved_status = 0;
	
	$clids = array();
	$servicelist= array();

	if($id != null) { // Edit Client
		$client = $this->Clients->get($id, [
			'contain' => ['Users', 'ClientServices', 'ClientServices.Services', 'ClientQuestions.Questions', 'ClientModules', 'ClientModules.Modules']
		]);

		$newstep = $client->registration_status+1;
		$saved_status = $client->registration_status;
		
		if($step > 1 && $saved_status != ($step-1) && $saved_status < $step) {
			$this->Flash->error(__('Please complete step'.$newstep));
			return $this->redirect(['action'=>'add/'.$newstep.'/'.$id]);								
		}

		if(isset($client['client_services']) && !empty($client['client_services'])) {
			// Services for step 3
			foreach($client['client_services'] as $cliservice) {
				$clids[$cliservice['id']] = $cliservice['service_id'];
			}
		
			// Services.Categories.Questions for step 4
			$servicelist = $this->ClientServices
			->find()		
			->contain(['Services'=>
			['fields'=>['id', 'name'], 
			'queryBuilder' => function ($q) { return $q->order(['service_order'=>'ASC']); }
			]])
			->contain(['Services.Categories'=>['conditions'=>['Categories.active'=>true], 'fields'=>['id', 'name', 'category_id', 'service_id'], 'sort'=>['id'=>'ASC']]])
			->contain(['Services.Categories.Questions'=> [
                'conditions'=>['Questions.active'=>true], 
                'fields'=>['id', 'question', 'category_id','question_options','is_parent','question_id','parent_option', 'ques_order'], 
                'queryBuilder' => function ($q) { return $q->order(['Questions.ques_order'=>'ASC', 'Questions.id'=>'ASC']); }
            ]])
			->contain(['Services.Categories.Questions.QuestionTypes'=>['fields'=>['id', 'name']] ])
			->contain(['Services.Categories.Questions.ClientQuestions'=> ['conditions'=>['ClientQuestions.client_id'=>$id]]])
			->where(['ClientServices.client_id'=>$id, 'Services.active'=>true])
			->toArray();
		}
	}
	else { // New Client
		$client = $this->Clients->newEntity();
		if($step > 1) {
			$this->Flash->error(__('Please complete step 1'));
			return $this->redirect(['action'=>'add/1']);
		}
	}
	
	$modclids = array();
	if(isset($client['client_modules']) && !empty($client['client_modules'])) {
		foreach($client['client_modules'] as $climodules) {
			$modclids[$climodules['id']] = $climodules['module_id'];
		}
	}

	// step 4
	$question = $this->Questions->newEntity();
	$questids = array();	
	if(isset($client['client_questions']) && !empty($client['client_questions'])) {
		foreach($client['client_questions'] as $cliservice) {			
			$questids[$cliservice['question']['category_id']][] = $cliservice['question_id'];
		
		}
	}

    if ($this->request->is(['patch', 'post', 'put'])) {
		$requestData = $this->request->getData();
		// Save Data Step 4
        if($requestData['registration_status'] == 4){
        // SafetyQual Auto Insert
        foreach($servicelist as $s){
             if($s['service_id'] == 6) {
                foreach($s['service']['categories'] as $c){
                    foreach($c['questions'] as $question){
                        if(empty($question['client_questions'])) {
                        $clientQuestion = $this->ClientQuestions->newEntity();
				        $clientQuestion->client_id = $id;
				        $clientQuestion->question_id = $question['id'];
                        $clientQuestion->is_safety_sensitive = true;
                        $clientQuestion->is_safety_nonsensitive = true;
                        $clientQuestion->is_compulsory = true;
                        $clientQuestion->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
                     	$this->ClientQuestions->save($clientQuestion);	
                        }
                    }
                }
            }
        }
    	}
		// EOF Save Data Step 4	

		// save data step 3	
		$selectedServices = array();
		if($this->request->getData('client_services')!=null) {
			$newServices = array();

			foreach($requestData['client_services'] as $key=>$val) {
				if($val['service_id']==0)  {
					unset($requestData['client_services'][$key]);
				}
				else {
					$selectedServices[] = $val['service_id'];					
					if (!in_array($val['service_id'], $clids)) {
						$newServices[] = $val['service_id'];
					}	
				}							
			}

			// delete ClientServices
			foreach($clids as $serviceid) {
			if (!in_array($serviceid, $selectedServices)) {
				$entity = $this->Clients->ClientServices->find()->where(['client_id'=>$id,'service_id'=>$serviceid])->first();
				$result = $this->Clients->ClientServices->delete($entity);
			}
			}
			/* Notificartion Area */
     		/*$contractor_id = $this->ContractorSites->find("all")->select('contractor_id')->where(['client_id'=>$client->id])->distinct('contractor_id')->toArray();
     	   $client_contractors = $this->User->getContractors($client->id); 
     	   $service_title = "";
           foreach ($client_contractors as $key => $value1) {                   
               foreach ($newServices as $key => $value) {
                    $notification = $this->Notifications->newEntity();
                    $service_title = $this->Services->find("all")->select('name')->where(['id'=>$value])->first();
                    $company_name = $client->company_name;    
                    $notification->notifications = "The ".$company_name." has selected services ".$service_title->name;
                    $notification->from_notification = $client->id;
                    $notification->to_notification = $value1;
                    $notification->is_read = 0;
                    $notification->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
                    $this->Notifications->save($notification);                          
                }
            }*/
		}

		if($this->request->getData('client_modules')!=null) {
			$selectedModules = array();
			$newModules = array();
			foreach($requestData['client_modules'] as $key=>$val) {
				if($val['module_id']==0)  {
					unset($requestData['client_modules'][$key]);
				}
				else {
					$selectedModules[] = $val['module_id'];
					if (!in_array($val['module_id'], $modclids)) {
						$newModules[] = $val;
					}
				}
			}

			// delete client_modules
			foreach($modclids as $moduleid) {
			if (!in_array($moduleid, $selectedModules)) {
				$entity = $this->Clients->ClientModules->find()->where(['client_id'=>$id,'module_id'=>$moduleid])->first();
				$result = $this->Clients->ClientModules->delete($entity);
			}
			}
			// new insert
			foreach($newModules as $m) {
				$module = $this->Clients->ClientModules->newEntity();
				$module = $this->Clients->ClientModules->patchEntity($module, $m);
				$this->Clients->ClientModules->save($module);
			}
		}
		// EOF save data step 3	

		$client = $this->Clients->patchEntity($client, $requestData);


		// save data step 1	
		//if($this->request->getData('customer_representative_id')!=null) {

		// save data step 1		
		/*if($this->request->getData('customer_representative_id')!=null) {

		    $client->customer_representative_id = implode(',', $this->request->getData('customer_representative_id'));
		}*/
		/*if($this->request->getData('contractor_custrep_id')!=null) {
	        $client->contractor_custrep_id = $this->request->getData('contractor_custrep_id');
	    }*/
		// EOF save data step 1

		if($id != null) { // edit client
			$client->modified_by = $user_id;

			// set customer_representative_id to client's contractors
			/*if($this->request->getData('contractor_custrep_id')!=null) {
			    $contractor_custrep_id = $this->request->getData('contractor_custrep_id');

	            $clientContractors = $this->User->getContractors($id);

	            foreach ($clientContractors as $contractor_id) {              
	                $query = $this->Contractors->query();
	                $query->update()
	                ->set(['customer_representative_id' => $contractor_custrep_id])
	                ->where(['id'=>$contractor_id])
	                ->execute();
	            }
			}*/

			/* Update in lead Customer Repreesentative */
			/*if($this->request->getData('lead_custrep_id')!=null) {
			    $lead_custrep_id = $this->request->getData('lead_custrep_id');                       
	                $query = $this->Leads->query();
	                $query->update()
	                ->set(['customer_representative_id' => $lead_custrep_id])
	                ->where(['client_id'=>$id])
	                ->execute();	            
			}*/
		}
		else { // new client
			$client->created_by = $user_id;
		}

		if($saved_status > $this->request->getData('registration_status')) { 
			$client->registration_status = $saved_status; 
		}
        
		$step = $this->request->getData('registration_status');
		/* User Entered Country and state */
		if($step  == 2 && ($this->request->getData(['country_id']) == 0)){
			$country = $this->Countries->newEntity();
			$state   = $this->States->newEntity();
			if(($this->request->getData(['country_id']) != null) || ($this->request->getData(['state_id']) != null)){
                $user_entered = true; // User entered Country and State

                $country->name = $this->request->getData(['country']);
                $country->created_by = $client->user->id;
                $country->user_entered = $user_entered;
              
               if($country_result = $this->Countries->save($country)){
                 
                   $state->name = $this->request->getData(['state']);
                   $state->country_id = $country_result->id;
                   $state->user_entered = $user_entered;
                   $state->created_by = $client->user->id;
                   $state_result = $this->States->save($state);

                   unset($client['user']);
                   $client->country_id = $country_result->id;
                   $client->state_id = $state_result->id;
                   if ($result = $this->Clients->save($client)) {			
						$this->Flash->success(__('The client has been saved.'));
					if($step < 4) {
						$step = $step + 1;
						return $this->redirect(['action'=>'add/'.$step.'/'.$result->id]);
					}
					else {
						return $this->redirect(['action'=>'index']);
						}
					}
				}
			   $this->Flash->error(__('The client could not be saved. Please, try again.'));
            }
		}
		if ($result = $this->Clients->save($client)) {			
			$this->Flash->success(__('The client has been saved.'));
			if($step < 4) {
				$step = $step + 1;
				return $this->redirect(['action'=>'add/'.$step.'/'.$result->id]);
			}
			else {
				return $this->redirect(['action'=>'index']);
			}
		}
		$this->Flash->error(__('The client could not be saved. Please, try again.'));
	}

    $adminRole = array(SUPER_ADMIN, ADMIN,CR);
    $users = $this->Users->find('list', ['keyField'=>'id', 'valueField'=>'username' ])  
             ->where(['Users.role_id IN'=>$adminRole])->contain(['Roles'])->toArray();    
    $accountTypes = $this->Clients->AccountTypes->find('list');
    
    if(isset($client->id)){ /* Country and state edit */
       $where = ['OR'=>['user_entered IS NOT'=>true,'created_by'=>$client->user_id]];
       $states = $this->Clients->States->find('list')->where(['country_id'=>$client->country_id])->toArray();
       $countries = $this->Clients->Countries->find('list')->where([$where])->toArray();
    }else{  /* add */
       $states = $this->Contractors->States->find('list')->where(['user_entered'=>false])->toArray();
       $countries = $this->Contractors->Countries->find('list')->where(['user_entered'=>false])->toArray();
    }
 
	$questionTypes = $this->QuestionTypes->find('list')->toArray();
	$services = $this->Services->find('list', ['keyField'=>'id', 'valueField'=>'name' ])->order(['service_order'])->toArray();
	$customer_rep = $this->CustomerRepresentative->find('list', ['keyField'=>'id', 'valueField'=>'user.username' ])->contain(['Users']);
	$modules = $this->Modules->find('list', ['keyField'=>'id', 'valueField'=>'name' ])->toArray();

	if($id != null)	{
		$sites = $this->Clients->Sites->find()->where(['client_id'=>$id]);
		$regionslist = $this->Clients->Regions->find('list')->where(['client_id'=>$id]);
		$regions = $this->Clients->Regions->find()->where(['client_id'=>$id])->contain(['Sites'])->toArray();
		$sites = $this->Clients->Sites->find()->where(['client_id'=>$id, 'region_id IS'=>null])->toArray();		

		$this->set(compact('sites', 'regions', 'regionslist', 'client', 'accountTypes', 'states', 'countries', 'services', 'step', 'servicelist','questionTypes','question','user_id','clids', 'questids','customer_rep', 'modules', 'modclids','users'));
	}
	else {
		$this->set(compact('client', 'accountTypes', 'states', 'countries', 'services', 'step', 'servicelist','questionTypes','question','user_id','clids', 'questids', 'customer_rep', 'modules', 'modclids','users'));
	}
    }

    public function addClientQuestions($step=null, $cid=null)
    {
	$this->viewBuilder()->setLayout('ajax');
	$this->loadModel('ClientQuestions');
	$this->loadModel('Questions');
	//$this->loadModel('CronQuestionUpdates');
	
	$clientquestions = $this->ClientQuestions->newEntity();
	$selectedQuestions = array();
	$selectedcats = array();
	
	if ($this->request->is(['patch', 'post', 'put'])) {		
        $this->viewBuilder()->setLayout('ajax');
		/*if(null !== $this->request->getData('insureCats'))
		{
		    $catList=$this->request->getData('insureCats');			
			foreach($catList as $cat_id)
			{	
				$selectedcats[] = $cat_id;																		
				$questions = $this->Questions->find('list', ['keyField'=>'id', 'valueField'=>'id'])->where(['category_id'=>$cat_id])->toArray();				
				if(!empty($questions)) { // new answer					
					foreach($questions as $key=>$val) {											
						$saveDt = $this->ClientQuestions->newEntity();						
						$saveDt->question_id = $val;
						$saveDt->client_id = $cid;
						$saveDt->is_safety_sensitive = 1;
						$saveDt->is_safety_nonsensitive = 1;
						$saveDt->is_compulsory = 1;	
						$saveDt->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
						$this->ClientQuestions->save($saveDt);									
					}
				}
			}
		}*/	
		$category_id = $this->request->getData('category_id');		
		if(null !== $this->request->getData('client_questions'))
		{
		$client_questions = $this->request->getData('client_questions');
	
    		foreach($client_questions as $key=>$val) {
			if($val['question_id']==0 )  {
				unset($client_questions['client_questions'][$key]);
				if(isset($val['id']))  {
					$entity = $this->ClientQuestions->get($val['id']);
					$result = $this->ClientQuestions->delete($entity);
				}	
			}
			$saveDt = $this->ClientQuestions->find('all', ['conditions'=>['client_id'=>$cid, 'question_id'=>$val['question_id'],]])->first();
			
			/*if( isset($val['correct_answer']) && is_array($val['correct_answer']) ) {
                $val['correct_answer'] = implode(',',$val['correct_answer']);
            }*/
			if(empty($saveDt)) { // new answer
				$saveDt = $this->ClientQuestions->newEntity();
				$saveDt = $this->ClientQuestions->patchEntity($saveDt, $val);
             	$this->ClientQuestions->save($saveDt);	
								
			}
			else { // update answer
				$saveDt = $this->ClientQuestions->patchEntity($saveDt, $val);	
                $this->ClientQuestions->save($saveDt);
			}
			}
		/* client-question add or delete 
		/*$cron_questions = $this->CronQuestionUpdates->find()->where(['category_id'=>$category_id,'client_id'=>$cid])->first();
		
		if(empty($cron_questions)){
		$cron_que_updates = $this->CronQuestionUpdates->newEntity();
	    $cron_que_updates->category_id = $category_id;        
        $cron_que_updates->client_id = $cid;		
		$this->CronQuestionUpdates->save($cron_que_updates);
		}*/
		echo '<div class="alert with-close alert-success alert-dismissible fade show" role="alert">The Client Questions has been saved.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
		
		//$this->Percentage->getPercentage($category_id,null,null,$cid); 
         
		}
	}		
	
	//return $this->redirect(['action'=>'add/'.$step.'/'.$cid]);			
	$clientquestions = $this->Clients->ClientQuestions->find()->where(['client_id'=>$cid]);
   	$this->set(compact('clientquestions'));
   }

    /**
     * Delete method
     *
     * @param string|null $id Client id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $client = $this->Clients->get($id);
        if ($this->Clients->delete($client)) {
            $this->Flash->success(__('The client has been deleted.'));
        } else {
            $this->Flash->error(__('The client could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action'=>'index']);
    }

    /*public function myProfile()
    {
	$this->loadModel('Contractors');

	$client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');

	$client = $this->Clients->get($client_id, [
        'contain'=>[
		'Users'=>['fields'=>['Users.id', 'Users.username', 'Users.profile_photo']],
		'ClientServices.Services'=>['fields'=>['id', 'name']],
		'ClientServices.Services.Products'=>['fields'=>['service_id', 'pricing']],
		'Sites'=>['fields'=>['id', 'name', 'client_id']],
		'Sites.Regions'=>['fields'=>['name']]
        ]
	]);
	if ($this->request->is(['patch', 'post', 'put'])) {
	    $client = $this->Clients->patchEntity($client, $this->request->getData());
	    $client->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');
		
	    if ($this->Clients->save($client)) {
			if(null !== $this->request->getData('company_logo')){
				$this->getRequest()->getSession()->write('Auth.User.company_logo', $client->company_logo);
			}
			if(null !== $this->request->getData('user.profile_photo')){
				$this->getRequest()->getSession()->write('Auth.User.profile_photo', $client->user->profile_photo);				
			}
			$this->set('activeUser', $this->getRequest()->getSession()->read('Auth.User'));
			
			$this->Flash->success(__('Profile has been saved.'));
			return $this->redirect(['action'=>'my-profile']);
	    }
	    $this->Flash->error(__('Profile could not be saved. Please, try again.'));
	}

	$where = ['OR'=>['user_entered IS NOT'=>true,'created_by'=>$client->user_id]];
	$states = $this->Contractors->States->find('list')->where(['country_id'=>$client->country_id,$where])->toArray();
	$countries = $this->Contractors->Countries->find('list')->where($where)->toArray();

	$this->set(compact('client','states', 'countries'));
    }*/
    public function myProfile()
    {
	$this->loadModel('Contractors');
	$this->loadModel('ClientUsers');

	$client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');

	// $client = $this->Clients->get($client_id, [
 	//        'contain'=>[
	// 	'Users'=>['fields'=>['Users.id', 'Users.username', 'Users.profile_photo']],
	// 	'ClientServices.Services'=>['fields'=>['id', 'name']],
	// 	'ClientServices.Services.Products'=>['fields'=>['service_id', 'pricing']],
	// 	'Sites'=>['fields'=>['id', 'name', 'client_id']],
	// 	'Sites.Regions'=>['fields'=>['name']]
 	//        ]
	// ]);
	$clientUser = $this->ClientUsers->find()
			->contain(['Users'=>['fields'=>['Users.id', 'Users.username', 'Users.profile_photo']]])
			->contain(['Clients'])
			->contain(['Clients.ClientServices.Services'=>['fields'=>['id', 'name']]])
			->contain(['Clients.ClientServices.Services.Products'=>['fields'=>['service_id', 'pricing']]])
			->contain(['Clients.Sites'=>['fields'=>['id', 'name', 'client_id']]])
			->contain(['Clients.Sites.Regions'=>['fields'=>['name']]])
			->where(['client_id'=>$client_id,'Users.role_id'=>CLIENT])
			->first();
			//pr($clientUser);die;
        


	if ($this->request->is(['patch', 'post', 'put'])) {
	    $clientUser = $this->ClientUsers->patchEntity($clientUser, $this->request->getData());
	    $clientUser->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');
		
	    if ($clientUser = $this->ClientUsers->save($clientUser)) {
			if(null !== $this->request->getData('company_logo')){
				$this->getRequest()->getSession()->write('Auth.User.company_logo', $clientUser->client->company_logo);
			}
			if(null !== $this->request->getData('user.profile_photo')){
				$this->getRequest()->getSession()->write('Auth.User.profile_photo', $clientUser->user->profile_photo);				
			}
			$this->set('activeUser', $this->getRequest()->getSession()->read('Auth.User'));
			
			$this->Flash->success(__('Profile has been saved.'));
			return $this->redirect(['action'=>'my-profile']);
	    }
	    $this->Flash->error(__('Profile could not be saved. Please, try again.'));
	}

	$where = ['OR'=>['user_entered IS NOT'=>true,'created_by'=>$clientUser->user_id]];
	$states = $this->Contractors->States->find('list')->where(['country_id'=>$clientUser->client->country_id,$where])->toArray();
	$countries = $this->Contractors->Countries->find('list')->where($where)->toArray();

	$this->set(compact('clientUser','states', 'countries'));
    }

    public function searchContractor()
    {
    ini_set('memory_limit','-1');	
	$this->loadModel('Contractors');
	//$this->loadModel('IndustryTypes');
	$this->loadModel('NaiscCodes');
	$this->loadModel('Leads');
   
	$clientIdLead = CanQualify_Marketplace;  
	$client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
	$client_contractors = $this->User->getContractors($client_id);

	    $clientUserContractors = array();
	    $isClientUser = false;
        if(!empty($client_id)) {
            if ($this->User->isClientUser()) {
                $clientUserContractors = $this->User->getClientUserContractors();
                $isClientUser = true;
            }
        }


        $contList = array();
	$leads = array();
	$customersByCname = array();
	$andConditions = array();

	$contractor = $this->Contractors->newEntity();	

	//$andConditions[] = "contractors.payment_status=true";
	$andConditions[] = "users.active=true";
	$andConditions[] = "contractors.profile_search=true";
	$andConditions = implode(' AND ',$andConditions);
	$conn = ConnectionManager::get('default');
		
	$contList = $conn->execute("SELECT contractors.*, states.name as state_name, users.username, client_requests.status as requestStatus FROM contractors 
			LEFT JOIN users ON users.id = (contractors.user_id) 
			LEFT JOIN states ON states.id = (contractors.state_id) 
			LEFT JOIN client_requests ON client_requests.contractor_id=contractors.id AND client_requests.client_id =$client_id			
			WHERE ".$andConditions." ")->fetchAll('assoc');

	$leads = $conn->execute("SELECT leads.*,client_requests_leads.status as requestStatus FROM leads
			LEFT JOIN client_requests_leads ON client_requests_leads.lead_id=leads.id AND client_requests_leads.client_id= $clientIdLead WHERE leads.client_id = ".$clientIdLead)->fetchAll('assoc');	

	if ($this->request->is(['patch', 'post', 'put'])) {		
		$contactnm = $this->request->getData('contact_name');
		$companynm = $this->request->getData('company_name');
		$email = $this->request->getData('username');
		$city = $this->request->getData('city');
		$state = $this->request->getData('state');
		$zip = $this->request->getData('zip');
		//$industry_type = $this->request->getData('industry_type');
		$naics_codes = $this->request->getData('naics_codes');

		/*$orConditions = array();
		if($contactnm!='') { $orConditions[]=['Contractors.pri_contact_fn LIKE'=>"%".$contactnm."%"]; }
		if($companynm!='') { $orConditions[]=['Contractors.company_name LIKE'=>"%".$companynm."%"]; }
		if($email!='') { $orConditions[]=['Users.username'=>$email]; }
		if($city!='') { $orConditions[]=['Contractors.city'=>$city]; }
		if($state!='') { $orConditions[]=['States.name'=>$state]; }
		

		$andConditions = array();
		$andConditions[]=['Users.active'=>true];
		if(!empty($client_contractors)) {$andConditions[]=['Contractors.id NOT IN'=>$client_contractors];}

		$contList = $this->Contractors
		->find('all')
		->contain(['Users'=>['fields'=>['Users.username']] ])
		->contain(['States'=>['fields'=>['name']] ])
		//->contain(['ContractorAnswers'=>['fields'=>['ContractorAnswers.answer','ContractorAnswers.contractor_id']]])
		->contain(['ClientRequests'=>['fields'=>['contractor_id']] ])		
		->where([
			'AND'=>$andConditions,
			'OR'=>$orConditions])
		->toArray();
		*/

		// all client_contractors
		// $client_contractors = $this->Contractors->ContractorSites
		// ->find('list', ['keyField'=>'contractor_id', 'valueField'=>'contractor_id'])
		// ->where(['client_id' => $client_id])
		// ->distinct(['contractor_id'])
		// ->toArray();
		$leads = array();
		$naics_code ='';
		$joinIndustry ='';
		$selectIndustry='';
		$andConditions = array();
		$orConditions = array();
		if($contactnm!='') { 
			$contactnm = explode(' ',$contactnm);
			$count = count($contactnm);
			//pr($count);die;	
			if($count==1){
				 $orConditions = ["LOWER(contractors.pri_contact_fn) LIKE LOWER('%".$contactnm[0]."%')","LOWER(contractors.pri_contact_ln) LIKE LOWER('%".$contactnm[0]."%')"];				
			}else{
			$andConditions[]="LOWER(contractors.pri_contact_fn) LIKE LOWER('%".$contactnm[0]."%')"; 
			if(isset($contactnm[1])) {
			$andConditions[]="LOWER(contractors.pri_contact_ln) LIKE LOWER('%".$contactnm[1]."%')";
			}}
		}
		if($companynm!='') { $andConditions[]="LOWER(contractors.company_name) LIKE LOWER ('%".$companynm."%')"; }
		if($email!='') { $andConditions[]="users.username LIKE '%".$email."%'";  }
		if($city!='') { $andConditions[]="LOWER(contractors.city) LIKE LOWER('%".$city."%')";  }
		if($state!='') { $andConditions[]="states.name LIKE '%".$state."%'";  }
		if($zip!='') { $andConditions[]="contractors.zip LIKE '%".$zip."%'";  }

		/*if($industry_type!='') { 
			if(is_numeric($industry_type)) {
				$naics_code = $industry_type;
			}
			else {
				$industryTypes = $this->IndustryTypes->find()->select(['naics_code'])->where(['title'=>$industry_type])->first();
				$naics_code = $industryTypes->naics_code;
			}
			$joinIndustry = 'LEFT JOIN contractor_answers ON contractor_answers.contractor_id=contractors.id';
			$andConditions[]="contractor_answers.answer ='".$naics_code."' ";
		}*/

		if(!empty($naics_codes)) { 
			$naics_codes = "'".implode ("', '", $naics_codes)."'";
			$selectIndustry = ', contractor_answers.answer as naics_code';
			$joinIndustry = 'LEFT JOIN contractor_answers ON contractor_answers.contractor_id=contractors.id';
			$andConditions[]="contractor_answers.answer IN(".$naics_codes.")";
			$andConditions[] = "contractor_answers.question_id = ".Naisc_Question;
		}

		//$andConditions[] = "contractors.payment_status=true";
		$andConditions[] = "users.active=true";
		// if(!empty($client_contractors)) {
		// 	// $customersByCname = $this->Contractors->find('list', ['keyField'=>'company_name', 'valueField'=>'company_name'])->contain(['Users'])->where(['Users.active'=>true, 'Contractors.payment_status'=>true, 'Contractors.id NOT IN'=>$client_contractors])->toArray();
		// 	$customersByCname = $this->Contractors->find('list', ['keyField'=>'company_name', 'valueField'=>'company_name'])->contain(['Users'])->where(['Users.active'=>true, 'Contractors.payment_status'=>true, 'Contractors.id IN'=>$client_contractors])->toArray();

		// 	// $clContractorList = implode(', ',$client_contractors);
		// 	// $andConditions[] = "contractors.id IN (".$clContractorList.")";
		// }
		// else {
			$customersByCname = $this->Contractors->find('list', ['keyField'=>'company_name', 'valueField'=>'company_name'])->contain(['Users'])->where(['Users.active'=>true])->toArray();
		// }
		$andConditions = implode(' AND ',$andConditions);
		$orConditions = implode(' OR ',$orConditions);
		if(!empty($orConditions)){
			$orConditions = 'AND ('.$orConditions.')';
		}

		$conn = ConnectionManager::get('default');
		
		$contList = $conn->execute("SELECT contractors.*, states.name as state_name, users.username ".$selectIndustry.", client_requests.status as requestStatus FROM contractors 
			LEFT JOIN users ON users.id = (contractors.user_id) 
			LEFT JOIN states ON states.id = (contractors.state_id) 
			LEFT JOIN client_requests ON client_requests.contractor_id=contractors.id AND client_requests.client_id =$client_id
			".$joinIndustry."
			WHERE ".$andConditions.' '.$orConditions)->fetchAll('assoc');	
				
		
		
		/* Search Leads data  */
		// $leads = $this->Leads->find('all')->toArray();
		if(empty($naics_codes)) { 
		$andConditions2 = array();
		$orConditions1 = array();
		$andConditions2[] = "leads.client_id= $clientIdLead ";
		if($contactnm!='') { 
			if($count==1){
				 $orConditions1 = ["LOWER(contact_name_first) LIKE LOWER('%".$contactnm[0]."%')","LOWER(contact_name_last) LIKE LOWER('%".$contactnm[0]."%')"];				
			}else{		
			$andConditions2[]="LOWER(contact_name_first) LIKE LOWER('%".$contactnm[0]."%')"; 
			if(isset($contactnm[1])) {
			$andConditions2[]="LOWER(contact_name_last) LIKE LOWER('%".$contactnm[1]."%')";
			}}
		}
		if($companynm!='') { $andConditions2[]="LOWER(company_name) LIKE LOWER('%".$companynm."%')"; }
		if($email!='') { $andConditions2[]="email LIKE '%".$email."%'";  }
		if($city!='') { $andConditions2[]="LOWER(city) LIKE LOWER('%".$city."%')";  }
		if($state!='') { $andConditions2[]="state LIKE '%".$state."%'";  }
		if($zip!='') { $andConditions2[]="zip_code LIKE '%".$zip."%'";  }

		if(!empty($andConditions2)) {
			$andConditions2 = implode(' AND ',$andConditions2);
		}
		else {
			$andConditions2 = '';
		}
		$orConditions1 = implode(' OR ',$orConditions1);
		if(!empty($orConditions1) && !empty($andConditions2)){
			$orConditions1 = 'AND ('.$orConditions1.')';
		}
		// elseif(!empty($orConditions1) && empty($andConditions2)){
		// 	$orConditions1 = $orConditions1;
		// }
		//$leads = $this->Leads->find()->where([$andConditions2])->toArray();
		
		$leads = $conn->execute("SELECT leads.*,client_requests_leads.status as requestStatus FROM leads
			LEFT JOIN client_requests_leads ON client_requests_leads.lead_id=leads.id AND client_requests_leads.client_id=".$clientIdLead." WHERE ".$andConditions2.' '.$orConditions1)->fetchAll('assoc');	
	    }

	}
	
	
	//$industrytype = $this->IndustryTypes->find('list', ['keyField'=>'id', 'valueField'=>'title' ])->toArray();		
	$states = $this->Contractors->States->find('list', ['keyField'=>'name', 'valueField'=>'name' ])->toArray();		
	$naisccodes = $this->NaiscCodes->find('list', ['keyField'=>'naisc_code', 'valueField'=> function ($e) { return $e->naisc_code.' - '.$e->title; }])->limit(4000);
	$this->set(compact('contractor', 'contList', 'customersByCname', 'naisccodes', 'states','leads','client_contractors', 'clientUserContractors', 'isClientUser'));
    }    

    public function dashboard($client_id=null)
    {

	$this->loadModel('Contractors');
	$this->loadModel('OverallIcons');
	$this->loadModel('FinalOverallIcons');
	$this->loadModel('ContractorSites');
	$this->loadModel('ContractorClients');
	$this->loadModel('ClientServices');
	$this->loadModel('Sites');
    $this->loadModel('Users');
    $this->loadModel('Explanations');
    $this->loadModel('WatchLists');
    $this->loadModel('Leads');
    $this->loadModel('ClientNotes');



        if($client_id == null){
                        $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
                    }
                if($this->User->isAdmin()) {
                    $client = $this->Clients->get($client_id);

                    $this->getRequest()->getSession()->write('Auth.User.client_id', $client_id);
                    $this->getRequest()->getSession()->write('Auth.User.client_company_name', $client->company_name);

                    $this->set('activeUser', $this->getRequest()->getSession()->read('Auth.User'));
                }

        //unset contractor
        $this->getRequest()->getSession()->delete('Auth.User.contractor_id');
        $this->getRequest()->getSession()->delete('Auth.User.contractor_company_name');

        //unset employee
        $this->getRequest()->getSession()->delete('Auth.User.employee_id');
        //	$this->User->unsetUserSession();
        $client = $this->Clients->get($client_id);
        $client_serice_rep = $this->Users->find()
                ->where(['Users.id'=>$client['client_service_rep']])->first();


        /*counts*/
        $myContractors = array();
        $sites = array();
        $userSites = null;
        if(!empty($client_id)) {
            $userLocations = array();
            if($this->User->isClientUser()){
                $userSites = $this->User->getClientUserSites();
            }
            if(!empty($userSites)){
                $myContractors = $this->User->getContractors($client_id, array(), true, $userSites);
            }else{

                $myContractors = $this->User->getContractors($client_id);
            }
        }



        $sites = $this->User->getClientSites($client_id);
        $totalSuppliers = 0;
        $totalSuppliers = count($myContractors);

        $awaitingReviews = 0;
        if(!empty($myContractors)){
            $queryAwaitingReviews = $this->ContractorClients->find('all',['conditions' => ['waiting_on' => STATUS_CANQUALIFY, 'id in' => $myContractors]]);
            $awaitingReviews = $queryAwaitingReviews->count();
        }

        $explanations = 0;
        if(!empty($myContractors)){
            $queryExplanations = $this->Explanations->find('all',['conditions' => ['id in' => $myContractors]]);
            $explanations = $queryExplanations->count();
        }

        /*Watch list contractor*/
        $waiting_on = $this->User->waiting_status_ids();
        $watchList = array();
        if(!empty($myContractors)){
            $watchList = $this->WatchLists->find('all')
                ->where(['client_id' => $client_id, 'contractor_id IN' => $myContractors])->limit(3)->toArray();
        }

        $watchListCount = 0;
        if(!empty($myContractors)){
            $watchListCount = $this->WatchLists->find('all')
                ->where(['client_id' => $client_id, 'contractor_id IN' => $myContractors])->count();
        }


        $client_contractors = array();
        $client_contractors = $myContractors;

        $clientSites = array();

        if(!empty($sites)) {
                    $clientSites = $this->Sites
                            ->find()
                        ->where(['Sites.id IN' => array_keys($sites)])
                        ->contain(['States', 'Countries'])
                        ->toArray();
        }

        $pieChart = array();
        $overallComplianceChart = array();
        $siteComplianceChart = array();
        $complianceCnt = 0;

        if(!empty($client_contractors)) {
                    $matrix = $this->OverallIcons
                            ->find()
                        ->select('icon')
                        ->distinct('contractor_id')
                        ->where(['client_id'=>$client_id, 'contractor_id IN'=>$client_contractors])
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
            $complianceCnt = $pieChart[0];


        $overallComplianceChart = array(
            "chart" => array("enablesmartlabels" => "1",
                                "exportEnabled" => "1",
                                "showlabels" => "0",
                                "plottooltext"=> "\$label, <b>\$value</b>",
                                "showPercentInTooltip" => "1",
                                "valuePosition" => "inside",
                                "valueFontColor" => "#FFFFFF",
                                "canvasPadding" => "0",
                                "chartLeftMargin" => "0",
                                "chartTopMargin" => "0",
                                "chartRightMargin" => "0",
                                "chartBottomMargin" => "0",
                                "doughnutRadius" => "60",
                                "theme" => "fusion"),
            "data" => array(array("label" => "Waiting On Contractor", "value" => $pieChart[3], "color" => "#808080",  "showValue" => ($pieChart[3]>0)? 1 : 0),
                            array("label" => "Compliant", "value"=> "$pieChart[0]", "color"=> "#4CB581",  "showValue" => ($pieChart[0]>0)? 1 : 0),
                            array("label"=> "Conditional", "value"=> "$pieChart[1]", "color"=> "#FFC800", "showValue" => ($pieChart[1]>0)? 1 : 0),
                            array("label"=> "Non-compliant", "value"=> "$pieChart[2]", "color"=> "#D14F57",  "showValue" => ($pieChart[2]>0)? 1 : 0)
                            )
                     );
        $siteName = $greenIcon = $yellowIcon = $redIcon = $grayIcon = array();
        foreach($sites as $siteId => $name) {
                    $contractor_ids = $this->ContractorSites->find('list', ['keyField'=>'id', 'valueField'=>'contractor_id'])->where(['site_id'=>$siteId,'is_archived'=>false, 'contractor_id in' => $client_contractors])->toArray();
                    $matrix2 = array();
                    $iconGray = 0;
                    $iconGreen = 0;
                    $iconRed = 0;
                    $iconYellow = 0;
                    if(!empty($contractor_ids)) {
                    $iconGray = $this->FinalOverallIcons->find('all')->where(['client_id' => $client_id, 'contractor_id IN' => $contractor_ids, 'icon' => 0])->count();
                    $iconRed = $this->FinalOverallIcons->find('all')->where(['client_id' => $client_id, 'contractor_id IN' => $contractor_ids, 'icon' => 1])->count();
                    $iconYellow = $this->FinalOverallIcons->find('all')->where(['client_id' => $client_id, 'contractor_id IN' => $contractor_ids, 'icon' => 2])->count();
                    $iconGreen = $this->FinalOverallIcons->find('all')->where(['client_id' => $client_id, 'contractor_id IN' => $contractor_ids, 'icon' => 3])->count();
            }
            array_push($siteName, array('label' => '<span style="display:none;">ID' .$siteId . "ID</span>" . $name));
            array_push($greenIcon, array('value' => $iconGreen, 'showValue' => ($iconGreen > 0) ? 1 : 0));
            array_push($yellowIcon, array('value' => $iconYellow, 'showValue' => ($iconYellow > 0) ? 1 : 0));
            array_push($redIcon, array('value' => $iconRed, 'showValue' => ($iconRed > 0) ? 1 : 0));
            array_push($grayIcon, array('value' => $iconGray, 'showValue' => ($iconGray > 0) ? 1 : 0));
        }

        $siteComplianceChart = array(
            "chart" => array(
            "numvisibleplot" => "6",
            "exportEnabled" => "1",
            "showvalues" => "1",
            "decimals" => "1",
            "valuefontcolor" => "#FFFFFF",
            "plottooltext" => "\$label has \$dataValue (<b>\$percentValue<\/b>) \$seriesName suppliers",
                "canvasPadding" => "0",
                "chartLeftMargin" => "0",
                "chartTopMargin" => "20",
                "chartRightMargin" => "0",
                "chartBottomMargin" => "0",
            "theme" => "fusion"
            ),
          "categories"=> array([
              "category" => $siteName
          ]),
          "dataset" => array(
                array( "seriesname" => "Waiting on Contractor",
                  "color" => "#818181",
                  "data" => $grayIcon),
                  array( "seriesname" => "Conditional",
                      "color" => "#FFC800",
                      "data" => $yellowIcon),
                  array( "seriesname" => "Non-compliant",
                      "color" => "#D14F57",
                      "data" => $redIcon),
                  array( "seriesname" => "Compliant",
                      "color" => "#4CB581",
                      "data" => $greenIcon)
          )
        );
        }
        /*Supplier Registration*/
        $leadsConverted = $this->Leads->find('all')->where(['client_id'=>$client_id, 'lead_status_id' => 6])->count();
        $leadsPending = $this->Leads->find('all')->where(['client_id'=>$client_id, 'lead_status_id !=' => 6])->count();

        $supplierRegistrationChart = array(
            "chart" => array("enablesmartlabels" => "1",
                "exportEnabled" => "1",
                "showlabels" => "0",
                "plottooltext"=> "\$label, <b>\$value</b>",
                "showPercentInTooltip" => "1",
                "valuePosition" => "inside",
                "valueFontColor" => "#FFFFFF",
                "canvasPadding" => "0",
                "chartLeftMargin" => "0",
                "chartTopMargin" => "0",
                "chartRightMargin" => "0",
                "chartBottomMargin" => "10",
                "doughnutRadius" => "30",
                "pieRadius" => "80",
                "startingAngle" => "0",
                "theme" => "fusion"),
            "data" => array(array("label" => "Registered", "value" => $leadsConverted, "color" => "#2E428A"),
                array("label" => "Pending", "value"=> $leadsPending, "color"=> "#55C6E8")
            )
        );

        /*notes*/
       // $myContractors = $this->User->getContractors($client_id);
        $recentMessages = array();
        if(!empty($myContractors)){
            $recentMessages = $this->ClientNotes->find()
                ->where(['ClientNotes.contractor_id in' => $myContractors, 'client_id' => $client_id])
                ->order(['ClientNotes.created'=>'DESC'])
                ->limit(5)
                ->all()->toArray();
        }

        $contractors = array();
        if(!empty($client_contractors)) {
                    $contractors = $this->Contractors
                            ->find()
                        ->select(['company_name', 'addressline_1', 'addressline_2', 'city', 'state_id', 'country_id', 'zip', 'latitude', 'longitude'])
                        ->contain(['States'=> ['fields'=>['name']]])
                        ->contain(['Countries'=> ['fields'=>['name']]])
                        ->where(['Contractors.id IN'=>$myContractors])
                        ->all();
        }
        $clientServices = $this->ClientServices->find()->where(['client_id'=>$client_id])->toArray();
        $site_visit = $this->Clients->find()->select('site_visited')->where(['id'=>$client_id])->enableHydration(false)->first();

        /*if(!empty($region_id)){
            $region = $this->Regions->find('all')->where(['id'=>$region_id])->first();
            $this->set(compact('region'));
        }*/

        $this->set('overallCompliance', json_encode($overallComplianceChart));
        $this->set('siteCompliance', json_encode($siteComplianceChart));
        $this->set('supplierRegistration', json_encode($supplierRegistrationChart));
        $this->set('currentPage', 'Dashboard');
        $this->set(compact('recentMessages','explanations','awaitingReviews','totalSuppliers', 'complianceCnt','watchList','waiting_on','watchListCount','clientSites','contractors', 'client_id','client_serice_rep','clientServices','site_visit'));

    }

    public function siteCompliance($row=null)
    {
	$this->viewBuilder()->setLayout('ajax');
	$client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');

	$sites = $this->User->getClientSites($client_id);
	$sitesIds = array_keys($sites);
	//$sites = $this->Clients->Sites->find()->select(['id','name'])->where(['client_id'=>$client_id])->order(['name'=>'ASC'])->enableHydration(false)->toArray();
	//echo '<pre>'; print_r($sites); echo '</pre>';

	if(isset($sitesIds[$row])) {
		$site_id = $sitesIds[$row];
		$siteName = $sites[$site_id];

		$pieChart = array();

		$contractor_ids = $this->Clients->ContractorSites->find('list', ['keyField'=>'id', 'valueField'=>'contractor_id'])->where(['site_id'=>$site_id,'is_archived'=>false])->toArray();
		$matrix2 = array();
		$iconGray = 0;
		$iconGreen = 0;
		$iconRed = 0;
		$iconYellow = 0;

		if(!empty($contractor_ids)) {
			$matrix2 = $this->Clients->OverallIcons
			->find()
			->select(['icon', 'contractor_id'])
			->distinct('contractor_id')
			->where(['contractor_id IN'=>$contractor_ids, 'client_id'=>$client_id])
			->order(['contractor_id', 'OverallIcons.created'=>'DESC'])
			->enableHydration(false)
			->toArray();

			foreach($matrix2 as $chart2) {
				if ($chart2['icon']==0) { $iconGray++;  }
				elseif ($chart2['icon']==1) { $iconRed++; }
				elseif ($chart2['icon']==2) { $iconYellow++; }
				else { $iconGreen++; }
			}
		}
		$pieChart = array($iconGreen, $iconYellow, $iconRed, $iconGray);
	}
	$this->set(compact('siteName','pieChart'));
    }

    public function employeeList($export_type=null,$isEmail = false,$client_id=null)
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '300');
        $iconList = Configure::read('icons');
        $this->loadModel('Contractors');
        $this->loadModel('ContractorSites');
        $this->loadModel('Sites');
        $this->loadModel('Employees');
        $this->loadModel('EmployeeSites');
        $this->loadModel('EmployeeContractors');
        $this->loadModel('EmployeeTrainings');
        $this->loadModel('Trainings');
        $this->loadModel('ClientUsers');

        $extras = array();

        if($client_id){
            $client_id = 3;
        }else{
            $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
        }
        if(!empty($client_id)){
            $extras['client_logo'] = $client_id . '.jpg';
        }
        $extras['client_name'] = '';
        $extras['client_name'] = $this->getRequest()->getSession()->read('Auth.User.client_company_name');
        $extras['file_name'] = 'orientation_status';

        //$client_contractors = $this->User->getContractors($client_id);
        if($this->User->isClientUser()){
            $locationFilter = $this->User->getClientUserSites();
            $isClientUser = true;
        }


        $conn = ConnectionManager::get('default');
        $qry = "select training_percentages.*, contractors.company_name, 
employees.pri_contact_fn, employees.pri_contact_ln,
trainings.name
from training_percentages
left join contractors on (training_percentages.contractor_id = contractors.id)
left join trainings on (training_percentages.training_id = trainings.id)
left join employees on (training_percentages.employee_id = employees.id)
where training_percentages.client_id = ".$client_id ."and training_percentages.percentage = 100";
        $fetchedData = $conn->execute($qry)->fetchAll('assoc');
        $employeeList = array();
        $i = 0;
        foreach ($fetchedData as $fetchedDataRow){
            $employeeList[$i]['percentage'] = (isset($fetchedDataRow['percentage']) && $fetchedDataRow['percentage'] >= 100) ? 'Complete' : 'Incomplete';
            $employeeList[$i]['completed_on'] = "";
            if(isset($fetchedDataRow['percentage']) &&  $fetchedDataRow['percentage'] >= 100 && isset($fetchedDataRow['completion_date'])){
                $employeeList[$i]['completed_on'] = $fetchedDataRow['completion_date'];
            }
            $employeeList[$i]['expires_on'] = "";
            if(isset($fetchedDataRow['percentage']) &&  $fetchedDataRow['percentage'] >= 100 && isset($fetchedDataRow['expiration_date'])){
                $employeeList[$i]['expires_on'] = $fetchedDataRow['expiration_date'];
            }
            $employeeList[$i]['emp_name'] = " ";
            if(isset($fetchedDataRow['pri_contact_fn'])){
                $employeeList[$i]['emp_name'] .= $fetchedDataRow['pri_contact_fn'];
            }
            if(isset($fetchedDataRow['pri_contact_ln'])){
                $employeeList[$i]['emp_name'] .= ' '.$fetchedDataRow['pri_contact_ln'];
            }
            $employeeList[$i]['contractor_name'] = isset($fetchedDataRow['company_name']) ? $fetchedDataRow['company_name'] : ' ';
            $employeeList[$i]['training'] = (!empty($fetchedDataRow['name'])) ? $fetchedDataRow['name'] : '';
            $employeeList[$i]['employee_sites'] = isset($fetchedDataRow['work_locations']) ? $fetchedDataRow['work_locations'] : '';


            if($export_type == null) {
                $employeeList[$i]['contractor_id'] = isset($fetchedDataRow['contractor_id']) ? $fetchedDataRow['contractor_id'] : '';
                $employeeList[$i]['employee_id'] = isset($fetchedDataRow['employee_id']) ? $fetchedDataRow['employee_id'] : '';
            }
            $i++;
        }

        $this->getRequest()->getSession()->delete('Auth.User.employee_id');
        $this->set('activeUser', $this->getRequest()->getSession()->read('Auth.User'));
        $activeUser = $this->getRequest()->getSession()->read('Auth.User');


        //aaa
        $headT = array('Status', 'Completion Date', 'Expiration Date', 'Employee', 'Supplier Name', 'Training Type', 'Work Locations');

        if($export_type == 'excel') {
            $this->Export->XportAsExcel($employeeList,$headT, $extras);
            exit;
        }
        if($export_type == 'csv') {
            $this->Export->XportAsCSV($employeeList,$headT, $extras);
            exit;
        }
        $this->set(compact('employeeList'));
    }

    public function searchEmployee()
    {
    ini_set('memory_limit','-1');   
    $this->loadModel('Employees');    

    $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
   
    $empList = array();       
    $andConditions = array();

    $employee = $this->Employees->newEntity();  

    //$andConditions[] = "contractors.payment_status=true";
    $andConditions[] = "users.active=true";
    $andConditions[] = "employees.is_login_enable=true";
    $andConditions[] = "employees.profile_search=true";
    $andConditions = implode(' AND ',$andConditions);
    $conn = ConnectionManager::get('default');
        
    $empList = $conn->execute("SELECT Employees.*, states.name as state_name, users.username, client_employee_requests.status as requestStatus FROM employees 
            LEFT JOIN users ON users.id = (employees.user_id) 
            LEFT JOIN states ON states.id = (employees.state_id) 
            LEFT JOIN client_employee_requests ON client_employee_requests.employee_id=employees.id AND client_employee_requests.client_id =$client_id         
            WHERE ".$andConditions." ")->fetchAll('assoc');   

    if ($this->request->is(['patch', 'post', 'put'])) {     
        $contactnm = $this->request->getData('contact_name');        
        $email = $this->request->getData('username');
        $city = $this->request->getData('city');
        $state = $this->request->getData('state');
        $zip = $this->request->getData('zip');       
       
        $andConditions = array();
        $orConditions = array();
        if($contactnm!='') { 
            $contactnm = explode(' ',$contactnm);
            $count = count($contactnm);
            //pr($count);die;   
            if($count==1){
                 $orConditions = ["LOWER(employees.pri_contact_fn) LIKE LOWER('%".$contactnm[0]."%')","LOWER(employees.pri_contact_ln) LIKE LOWER('%".$contactnm[0]."%')"];             
            }else{
            $andConditions[]="LOWER(employees.pri_contact_fn) LIKE LOWER('%".$contactnm[0]."%')"; 
            if(isset($contactnm[1])) {
            $andConditions[]="LOWER(employees.pri_contact_ln) LIKE LOWER('%".$contactnm[1]."%')";
            }}
        }     
        if($email!='') { $andConditions[]="users.username LIKE '%".$email."%'";  }
        if($city!='') { $andConditions[]="LOWER(employees.city) LIKE LOWER('%".$city."%')";  }
        if($state!='') { $andConditions[]="states.name LIKE '%".$state."%'";  }
        if($zip!='') { $andConditions[]="employees.zip LIKE '%".$zip."%'";  }
          

        $andConditions[] = "users.active=true";       
	    $andConditions[] = "employees.is_login_enable=true";
	    $andConditions[] = "employees.profile_search=true";
       
        $andConditions = implode(' AND ',$andConditions);
        $orConditions = implode(' OR ',$orConditions);
        if(!empty($orConditions)){
            $orConditions = 'AND ('.$orConditions.')';
        }

        $conn = ConnectionManager::get('default');
        
        $empList = $conn->execute("SELECT employees.*, states.name as state_name, users.username , client_employee_requests.status as requestStatus FROM employees 
            LEFT JOIN users ON users.id = (employees.user_id) 
            LEFT JOIN states ON states.id = (employees.state_id) 
            LEFT JOIN client_employee_requests ON client_employee_requests.employee_id=employees.id AND client_employee_requests.client_id =$client_id
           
            WHERE ".$andConditions.' '.$orConditions)->fetchAll('assoc');   
            
    }
         
    $states = $this->Employees->States->find('list', ['keyField'=>'name', 'valueField'=>'name' ])->toArray();
       
    $this->set(compact('employee', 'empList', 'states'));
    }
   	
      /**
     * Edit method
     *
     * @param string|null $id Client id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function edit($id = null)
    {
	$this->loadModel('Services');	
        $client = $this->Clients->get($id, ['contain'=>['Users', 'ClientServices', 'ClientQuestions','Sites','Regions']]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $client = $this->Clients->patchEntity($client, $this->request->getData());
            if ($this->Clients->save($client)) {
                $this->Flash->success(__('The client has been saved.'));

                return $this->redirect(['action'=>'index']);
            }
            $this->Flash->error(__('The client could not be saved. Please, try again.'));
        }
	$accountTypes = $this->Clients->AccountTypes->find('list');
	$states = $this->Clients->States->find('list');
	$countries = $this->Clients->Countries->find('list');
	$users = $this->Clients->Users->find('list');

	if(isset($client['client_services'])) {
		foreach($client['client_services'] as $cliservice) {
			$clids[] = $cliservice['service_id'];
		}		
	}
	if(empty($clids)) { $clids =1; }
	$query = $this->Services->find('all', [ 'conditions'=>['Services.id IN' =>$clids ]]);
	$services = $query->all();					
	$this->set(compact('client', 'accountTypes', 'states', 'countries', 'users', 'services'));
    }*/

    /*Reports*/
    public function complianceReport($client_id=null)
    {
        $this->loadModel('Contractors');
        $this->loadModel('ContractorClients');
        $this->loadModel('SafetyRates');
        $this->loadModel('FinalOverallIcons');
        $this->loadModel('IndustryAverages');
        $this->loadModel('Benchmarks');
        $this->loadModel('BenchmarkTypes');

        if ($client_id == null) {
            $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
        }

        /*My Contractors*/
       /* $myContractors = $this->ContractorClients
            ->find('list', ['valueField' => 'id'])
            ->where(['client_id' => $client_id])
            ->toArray();*/
       $isClientUser = false;
        if($this->User->isClientUser()){
            $locationFilter = $this->User->getClientUserSites();
            $isClientUser = true;
        }
        if(!empty($locationFilter)){
            $myContractors = $this->User->getContractors($client_id, array(), true, $locationFilter);
        }else{
            $myContractors = $this->User->getContractors($client_id);
        }
        $where = array();
        if($isClientUser == true){
            $where = ['contractor_id IN' => $myContractors];
        }
        /*Forced Icon*/
        $review = array();
        $forced = array();
        $total = $green = $yellow = $red = $redForced = $yellowForced = $redForced = 0;
        $compliant = $nonCompliant = 0;

        $whereTotal = array_merge($where, ['client_id' => $client_id]);
        $total =  $this->FinalOverallIcons
            ->find('all')
            ->where($whereTotal)
            ->count();

        $whereGreen = array_merge($where, ['client_id' => $client_id, 'icon' => '3', 'is_forced' => false]);
        $green = $this->FinalOverallIcons
            ->find('all')
            ->where($whereGreen)
            ->count();

        $whereGreenForced = array_merge($where, ['client_id' => $client_id, 'icon' => '3', 'is_forced' => true]);
        $greenForced = $this->FinalOverallIcons
            ->find('all')
            ->where($whereGreenForced)
            ->count();
        $compliant = $green + $greenForced;

        $whereYellow = array_merge($where, ['client_id' => $client_id, 'icon' => '2', 'is_forced' => false]);
        $yellow = $this->FinalOverallIcons
            ->find('all')
            ->where($whereYellow)
            ->count();
        $whereYellowForced = array_merge($where, ['client_id' => $client_id, 'icon' => '2', 'is_forced' => true]);
        $yellowForced = $this->FinalOverallIcons
            ->find('all')
            ->where($whereYellowForced)
            ->count();
        $conditional = $yellow + $yellowForced;

        $whereRed = array_merge($where, ['client_id' => $client_id, 'icon' => '1', 'is_forced' => false]);
        $red = $this->FinalOverallIcons
            ->find('all')
            ->where($whereRed)
            ->count();
        $whereRedForced = array_merge($where, ['client_id' => $client_id, 'icon' => '1', 'is_forced' => true]);
        $redForced = $this->FinalOverallIcons
            ->find('all')
            ->where($whereRedForced)
            ->count();
        $nonCompliant = $red + $redForced;

        $forcedIcon = array(
            "chart" => array(
                "exportEnabled" => "1",
                "caption" => "Forced Icon by Compliance",
                "subcaption" => "Current Year",
                "showplotborder" => "1",
                "plotfillalpha" => "60",
                "hoverfillcolor" => "#CCCCCC",
                "numberprefix" => "$",
                "plottooltext" => "<b>\$label</b> <b>\$value</b>, \$percentValue of parent category",
                "showlegend" => "1",
                "showpercentvalues" => "1",
                "legendposition" => "bottom",
                "canvasPadding" => "0",
                "chartLeftMargin" => "0",
                "chartRightMargin" => "0",
                "chartBottomMargin" => "0",
                "theme" => "fusion"
                ),
            "category" => array(
                array(
                    "label" => "Suppliers",
                    "tooltext" => "Please hover over a sub-category to see details",
                    "color" => "#ffffff",
                    "value" => $total,
                    "category" => [
                        array(
                            "label" => "Compliant",
                            "color" => "#4CB581",
                            "value" => $compliant,
                            "showLabel" =>($compliant > 0)? 1 : 0,
                            "category" => [
                                array("label" => "Forced", "color" => "#4CB581","value" => $greenForced, "showLabel" =>($greenForced > 0)? 1 : 0),
                                array("label" => "By Review", "color" => "#4CB581", "value" => $green, "showLabel" =>($green > 0)? 1 : 0)
                                ]
                        ),
                        array(
                            "label" => "Conditional",
                            "color" => "#FFC800",
                            "value" => $conditional,
                            "showLabel" =>($conditional > 0)? 1 : 0,
                            "category" => [
                                array("label" => "Forced", "color" => "#FFC800","value" => $yellowForced, "showLabel" =>($yellowForced > 0)? 1 : 0,),
                                array("label" => "Review", "color" => "#FFC800", "value" => $yellow, "showLabel" =>($yellow > 0)? 1 : 0,)
                            ]
                        ),
                        array(
                            "label" => "Non-compliant",
                            "color" => "#D14F57",
                            "value" => $nonCompliant,
                            "showLabel" =>($nonCompliant > 0)? 1 : 0,
                            "category" => [
                                array("label" => "Forced", "color" => "#D14F57","value" => $redForced, "showLabel" =>($redForced > 0)? 1 : 0,),
                                array("label" => "Review", "color" => "#D14F57", "value" => $red, "showLabel" =>($red > 0)? 1 : 0,)
                            ]
                        )
                        ]
                )
            )
        );
        $this->set('forcedIcon', $forcedIcon);

        /*EMR, DART, TRIR, LWCR*/
        $yearRange = $this->Category->yearRange();
        $benchmarkArr = array(1 => 'EMR', 2 => 'DART', 3 => 'TRIR', 4 => 'LWCR');
        $groupData = array();
        $subcaption = '';
        $years = '';
        $yellowData = array();
        $redData = array();
        $greenData = array();
        foreach ($benchmarkArr as $bench_key => $bench_value)
        {
            $clientBenchmarks = $this->Benchmarks->find()->where(['client_id' => $client_id, 'benchmark_type_id' => $bench_key ])->order(['icon'])->all()->toArray();
            if(!empty($clientBenchmarks)){
                $years = $redData = $yellowData = $greenData = array();
                
                foreach ($yearRange as $year) {
                    $subcaption = ($subcaption == '') ? $year.' - ' : $subcaption;
                    $red = $yellow = $green = 0;
                    foreach ($clientBenchmarks as $benchmark){
                        $cnt = 0;
                        $where = ['contractor_id in' => $myContractors, 'year' => $year, 'type' => $bench_value, 'answer >=' => $benchmark['range_from']];
                        if($benchmark['range_to'] > 0){
                            $where['answer <='] = $benchmark['range_to'];
                        }
                        $cnt = $this->SafetyRates->find('all')->where([$where])->count();
                        switch($benchmark['icon']){
                            case 1: $red += $cnt;
                                break;
                            case 2: $yellow += $cnt;
                                break;
                            case 3: $green += $cnt;
                                break;
                        }

                    }
                    array_push($years, array('label' => $year));
                    array_push($greenData, array('value' => $green));
                    array_push($yellowData, array('value' => $yellow));
                    array_push($redData, array('value' => $red));

                }
                $subcaption .= $year;
            }

            $groupData[$bench_value] = array(
                "chart" => array(
                    "exportEnabled" => "1",
                    "caption" => $bench_value,
                    "subcaption" => $subcaption,
                    "xaxisname" => "Years",
                    "yaxisname" => "Total number of Supplier",
                    "formatnumberscale" => "1",
                    "plottooltext" => "<b>\$dataValue</b> suppliers <b>\$seriesName</b> in \$label",
                    "theme" => "fusion",
                    "drawcrossline" => "1"
                ),
                "categories" => array([
                    "category" => $years
                ]),
                "dataset" => array(
                    array( "seriesname" => "Conditional",
                        "color" => "#FFC800",
                        "data" => $yellowData),
                    array( "seriesname" => "Non-compliant",
                        "color" => "#D14F57",
                        "data" => $redData),
                    array( "seriesname" => "Compliant",
                        "color" => "#4CB581",
                        "data" => $greenData)
                )
            );
        }

        $this->set('groupData', $groupData);

        /*Fatalities and Citation*/
        $lineData = array();
        $lineGraphs = array(1 => 'fatalities', 2 => 'citation');
        foreach ($lineGraphs as $key => $val){
            $subcaption = '';
            $tempdata = array();
            foreach ($yearRange as $year) {
                $subcaption = ($subcaption == '') ? $year . ' - ' : $subcaption;
                $sum = 0;
                $tempSafetyData = $this->SafetyRates->find('list', ['keyField' => 'contractor_id', 'valueField' => 'answer'])->where(['contractor_id in' => $myContractors, 'year' => $year, 'type' => $val])->toArray();
                $sum = array_sum(array_filter($tempSafetyData));
                array_push($tempdata, ['label' => $year, 'value' => $sum]);
            }
            $subcaption .= $year;
            $lineData[$val] = array(
                "chart" => array(
                    "exportEnabled" => "1",
                    "caption" => ucfirst($val),
                    "yaxisname" => "No. of ".ucfirst($val),
                    "subcaption" => $subcaption,
                    "rotatelabels" => "1",
                    "setadaptiveymin" => "1",
                    "theme" => "fusion"
                ),
                "data" => $tempdata
            );
        }
        $this->set('lineData', $lineData);
         /*Severity Rate (SR)*/
        $lineDataSR = array();
        $lineGraphs = array(1 => 'SR');
        foreach ($lineGraphs as $key => $val){
            $subcaption = '';
            $tempdata = array();
            foreach ($yearRange as $year) {
                $subcaption = ($subcaption == '') ? $year . ' - ' : $subcaption;
                $sum = 0;
                $tempSafetyData = $this->SafetyRates->find('list', ['keyField' => 'contractor_id', 'valueField' => 'answer'])->where(['contractor_id in' => $myContractors, 'year' => $year, 'type' => $val])->toArray();
                if($tempSafetyData){
                $sum = array_sum(array_filter($tempSafetyData))/count($tempSafetyData);
            	}
                array_push($tempdata, ['label' => $year, 'value' => $sum]);
            }
            $subcaption .= $year;
            $lineDataSR[$val] = array(
                "chart" => array(
                    "exportEnabled" => "1",
                    "caption" => ucfirst($val),
                    "yaxisname" => "No. of ".ucfirst($val),
                    "subcaption" => $subcaption,
                    "rotatelabels" => "1",
                    "setadaptiveymin" => "1",
                    "theme" => "fusion"
                ),
                "data" => $tempdata
            );
        }
        $this->set('lineDataSR', $lineDataSR);

        $this->set('parentPage', 'Reports');
        $this->set('currentPage', 'Compliance');
    }

    public function supplierReport($client_id=null){

        $this->loadModel('Contractors');
        $this->loadModel('ContractorClients');
        $this->loadModel('SafetyRates');
        $this->loadModel('FinalOverallIcons');
        $this->loadModel('IndustryAverages');
        $this->loadModel('Leads');
        $this->loadModel('LeadStatus');
        $this->loadModel('Sites');
        $this->loadModel('ContractorSites');

        $todaydate = date('m/d/Y');

        if ($client_id == null) {
            $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
        }

        /*My Contractors*/
        /*$myContractors = $this->ContractorClients
            ->find('list', ['valueField' => 'id'])
            ->where(['client_id' => $client_id])
            ->toArray();*/
        //$myContractors = $this->User->getContractors($client_id);

        $isClientUser = false;
        if($this->User->isClientUser()){
            $locationFilter = $this->User->getClientUserSites();
            $isClientUser = true;
        }
        if(!empty($locationFilter)){
            $myContractors = $this->User->getContractors($client_id, array(), true, $locationFilter);
        }else{
            $myContractors = $this->User->getContractors($client_id);
        }
        /*$where = array();
        if($isClientUser == true){
            $where = ['contractor_id IN' => $myContractors];
        }*/

        $waitingOnContractor = $waitingOnClient = $waitingOnCanqualify = $waitingOnComplete = 0;

        $waitingOnContractor = $this->ContractorClients->find('all')->where(['waiting_on' => STATUS_CONTRACTOR, 'contractor_id in' => $myContractors])->count();
        $waitingOnClient = $this->ContractorClients->find('all')->where(['waiting_on' => STATUS_CLIENT, 'contractor_id in' => $myContractors])->count();
        $waitingOnCanqualify = $this->ContractorClients->find('all')->where(['waiting_on' => STATUS_CANQUALIFY, 'contractor_id in' => $myContractors])->count();
        $waitingOnComplete = $this->ContractorClients->find('all')->where(['waiting_on' => STATUS_COMPLETE, 'contractor_id in' => $myContractors])->count();


        /*waiting on*/
        $supplierWaitingOnData = array();
        array_push($supplierWaitingOnData, ['label' => 'Contractor', 'value' => $waitingOnContractor]);
        array_push($supplierWaitingOnData, ['label' => 'Client', 'value' => $waitingOnClient]);
        array_push($supplierWaitingOnData, ['label' => 'Canqualify', 'value' => $waitingOnCanqualify]);
        array_push($supplierWaitingOnData, ['label' => 'Complete', 'value' => $waitingOnComplete]);
        $supplierWaitingOn = array(
            "chart" => array(
                "exportEnabled" => "1",
                "xaxisname" => "Waiting On",
                "yaxisname" => "No. of Suppliers",
                "theme" => "fusion"
            ),
            "data" => $supplierWaitingOnData
        );
        $this->set('supplierWaitingOn', json_encode($supplierWaitingOn));

        /*Supplier Registration*/
        $supplierRegistrationData = array();
        $allStatuses = $this->LeadStatus->find('all')->toArray();
        if(!empty($allStatuses)){
            foreach ($allStatuses as $status){
                $temp = 0;
                $temp = $this->Leads->find('all')->where(['client_id'=>$client_id, 'lead_status_id' => $status['id']])->count();
                array_push($supplierRegistrationData, array("label" => $status['status'], "value" => $temp, "color" => $status['color']));
            }
        }

        $supplierRegistrationChart = array(
            "chart" => array("enablesmartlabels" => "1",
                "exportEnabled" => "1",
                "showlabels" => "0",
                "plottooltext"=> "\$label, <b>\$value</b>",
                "showPercentInTooltip" => "1",
                "valuePosition" => "inside",
                "valueFontColor" => "#FFFFFF",
                "canvasPadding" => "0",
                "chartLeftMargin" => "0",
                "chartTopMargin" => "0",
                "chartRightMargin" => "0",
                "chartBottomMargin" => "10",
                "doughnutRadius" => "40",
                "pieRadius" => "100",
                "startingAngle" => "0",
                "theme" => "fusion"),
            "data" => $supplierRegistrationData
        );
        $this->set('supplierRegistration', json_encode($supplierRegistrationChart));

        /*subscription expired by site*/
        $siteSubscriptionChart = '';
        if($isClientUser){
            $clientSites = $this->Sites->find('list', ['keyField'=>'id', 'valueField'=>'name'])->where(['client_id' => $client_id, 'id IN ' => $locationFilter])->toArray();
        }
        else{
            $clientSites = $this->Sites->find('list', ['keyField'=>'id', 'valueField'=>'name'])->where(['client_id' => $client_id])->toArray();
        }
        if(!empty($clientSites) && count($clientSites) > 0){
            $siteName = $expired = $notExpired = array();
            foreach($clientSites as $siteId=>$name) {
                $siteContractorIds = $this->ContractorSites->find('list', ['keyField'=>'id', 'valueField'=>'contractor_id'])->where(['site_id'=>$siteId,'is_archived'=>false, 'contractor_id in' => $myContractors])->toArray();
                if(!empty($siteContractorIds) && count($siteContractorIds) > 0){

                    $expiredCnt = $this->Contractors->find('all')->where(['CAST(subscription_date AS DATE) <='=>$todaydate, 'id in ' => $siteContractorIds])->count();
                    $notExpiredCnt = $this->Contractors->find('all')->where(['CAST(subscription_date AS DATE) >'=>$todaydate, 'id in ' => $siteContractorIds])->count();


                    array_push($siteName, array('label' => $name));
                    array_push($expired, array('value' => $expiredCnt));
                    array_push($notExpired, array('value' => $notExpiredCnt));

                }
            }

            $siteSubscriptionChart = array(
                "chart" => array(
                    "exportEnabled" => "1",
                    "numvisibleplot" => "6",
                    "showvalues" => "1",
                    "decimals" => "1",
                    "stack100percent" => "0",
                    "valuefontcolor" => "#FFFFFF",
                    "plottooltext" => "\$label has \$dataValue (<b>\$percentValue<\/b>) \$seriesName supplier\/s",
                    "canvasPadding" => "0",
                    "chartLeftMargin" => "0",
                    "chartTopMargin" => "20",
                    "chartRightMargin" => "0",
                    "chartBottomMargin" => "0",
                    "theme" => "fusion"
                ),
                "categories"=> array([
                    "category" => $siteName
                ]),
                "dataset" => array(
                    array( "seriesname" => "Current",
                        "color" => "#4CB581",
                        "data" => $notExpired),
                    array( "seriesname" => "Expired",
                        "color" => "#FFC800",
                        "data" => $expired)
                )
            );
        }

        $this->set('siteSubscriptionChart', $siteSubscriptionChart);

        /*overall subscription*/
        $total = $expired = $expiredActive = $expiredInactive = $notExpired = $notExpired = $notExpiredInactive =0;
        $total = $this->Contractors->find('all')->where(['id in' => $myContractors])->count();
        $expired = $this->Contractors->find('all')->where(['id in' => $myContractors, 'CAST(subscription_date AS DATE) <='=>$todaydate])->count();
        $expiredActive = $this->Contractors->find('all')->contain(['Users'])->where(['Contractors.id in' => $myContractors, 'CAST(Contractors.subscription_date AS DATE) <='=>$todaydate, 'Users.active' => true])->count();
        $expiredInactive = $this->Contractors->find('all')->contain(['Users'])->where(['Contractors.id in' => $myContractors, 'CAST(Contractors.subscription_date AS DATE) <='=>$todaydate, 'Users.active' => false])->count();
        $notExpired = $this->Contractors->find('all')->where(['id in' => $myContractors, 'CAST(subscription_date AS DATE) >'=>$todaydate])->count();
        $notExpiredActive = $this->Contractors->find('all')->contain(['Users'])->where(['Contractors.id in' => $myContractors, 'CAST(Contractors.subscription_date AS DATE) >'=>$todaydate, 'Users.active' => true])->count();
        $notExpiredInactive = $this->Contractors->find('all')->contain(['Users'])->where(['Contractors.id in' => $myContractors, 'CAST(Contractors.subscription_date AS DATE) >'=>$todaydate, 'Users.active' => false])->count();
        $overallSubscription = array(
            "chart" => array(
                "exportEnabled" => "1",
                "showplotborder" => "1",
                "plotfillalpha" => "60",
                "hoverfillcolor" => "#CCCCCC",
                "numberprefix" => "$",
                "plottooltext" => "<b>\$label</b> <b>\$value</b>, \$percentValue of parent category",
                "showlegend" => "1",
                "showpercentvalues" => "1",
                "legendposition" => "bottom",
                "canvasPadding" => "0",
                "chartLeftMargin" => "0",
                "chartRightMargin" => "0",
                "chartBottomMargin" => "0",
                "theme" => "fusion"
            ),
            "category" => array(
                array(
                    "label" => "Suppliers",
                    "tooltext" => "Please hover over a sub-category to see details",
                    "color" => "#ffffff",
                    "value" => $total,
                    "category" => [
                        array(
                            "label" => "Expired",
                            "color" => "#FFC800",
                            "value" => $expired,
                            "showLabel" =>($expired > 0)? 1 : 0,
                            "category" => [
                                array("label" => "Active", "color" => "#4CB581","value" => $expiredActive, "showLabel" =>($expiredActive > 0)? 1 : 0,),
                                array("label" => "Inactive", "color" => "#4CB581", "value" => $expiredInactive, "showLabel" =>($expiredInactive > 0)? 1 : 0,)
                            ]
                        ),
                        array(
                            "label" => "Current",
                            "color" => "#4CB581",
                            "value" => $notExpired,
                            "showLabel" =>($notExpired > 0)? 1 : 0,
                            "category" => [
                                array("label" => "Active", "color" => "#FFC800","value" => $notExpiredActive, "showLabel" =>($notExpiredActive > 0)? 1 : 0,),
                                array("label" => "Inactive", "color" => "#FFC800", "value" => $notExpiredInactive, "showLabel" =>($notExpiredInactive > 0)? 1 : 0,)
                            ]
                        )
                    ]
                )
            )
        );
        $this->set('overallSubscription', $overallSubscription);
        $this->set('parentPage', 'Reports');
        $this->set('currentPage', 'Suppliers');
    }
	
	public function getLocations($label=false,$id=null)
    {
        $this->loadModel('Sites');
        $this->viewBuilder()->setLayout('ajax_content');

        $stateOptions = [];
        if ($id!==null) {
            $stateOptions = $this->Sites->find('list', ['keyField'=>'id', 'valueField'=>'name'])->where(['client_id'=>$id])->toArray();
        }
        $this->set(compact('stateOptions','label'));
    }

    public function removeClient($contractor_id = null, $client_id = null){

        /*$this->loadModel('ClientRequests');
        $this->loadModel('ClientQuestions');
        $this->loadModel('ClientEmployeeQuestions');*/
        $this->loadModel('ContractorClients');
       /* $this->loadModel('ContractorAnswers');
        $this->loadModel('EmployeeAnswers');*/

        $errorMsg = '';
        $successMsg = '';
        if($contractor_id != null && $client_id != null){

            /*if(!$this->ClientRequests->deleteAll(['contractor_id' => $contractor_id, 'client_id' => $client_id])){
                $errorMsg = "Error deleting Client Requests.<br>";
            }else{ $successMsg = "Client Requests removed successfully.<br>";}*/

                /*delete answers to questions that belong to only given client*/
                /*$otherClients = $this->ContractorClients->find('list', ['valueField' => 'client_id'])
                    ->where(['contractor_id' => $contractor_id, 'client_id !=' => $client_id])
                    ->toArray();
                $otherClients = array_unique($otherClients);*/

                /*Delete answers for client questions*/
                /*$allClientsQuestions = $this->ClientQuestions->find('list', ['keyField' => 'id', 'valueField' => 'question_id'])->where(['client_id in' => $otherClients])->toArray();
                $allClientsQuestions = (array_unique($allClientsQuestions));

                $removeAnswerQuestions = $this->ClientQuestions->find('list', ['keyField' => 'id', 'valueField' => 'question_id'])->where(['client_id' => $client_id, 'question_id not in' => $allClientsQuestions])->toArray();
                $removeAnswerQuestions = (array_unique($removeAnswerQuestions));

                if(!$this->ContractorAnswers->deleteAll(['contractor_id' => $contractor_id, 'question_id in' => $removeAnswerQuestions])){
                    $errorMsg = "Error deleting Contractor Answers.<br>";
                }else{ $successMsg = "Contractor Answers removed successfully.<br>";}*/

                /*Remove employeeQual answers*/
                /*$allClientsEmpQuestions = $this->ClientEmployeeQuestions->find('list', ['keyField' => 'id', 'valueField' => 'employee_question_id'])->where(['client_id in' => $otherClients])->toArray();
                $allClientsEmpQuestions = (array_unique($allClientsEmpQuestions));

                $removeAnswerEmpQuestions = $this->ClientEmployeeQuestions->find('list', ['keyField' => 'id', 'valueField' => 'employee_question_id'])->where(['client_id' => $client_id, 'question_id not in' => $allClientsEmpQuestions])->toArray();
                $removeAnswerEmpQuestions = (array_unique($removeAnswerEmpQuestions));

                $employees = $this->EmployeeContractors->find('list', ['keyField' => 'id', 'valueField' => 'employee_id'])->where(['contractor_id' => $contractor_id])->toArray();

                if(!$this->EmployeeAnswers->deleteAll(['employee_id in' => $employees, 'employee_question_id in' => $removeAnswerEmpQuestions])){
                    $errorMsg = "Error deleting Employee Answers.<br>";
                }else{ $successMsg = "Employee Answers removed successfully.<br>";}*/


                /*delete contractor client relationship*/
                if(!$this->ContractorClients->deleteAll(['contractor_id' => $contractor_id, 'client_id' => $client_id])){
                    $this->Flash->error(__('Something went wrong. Please, try again.'));
                }else{
                    $this->Flash->success(__('Client removed successfully.'));
                }


        }else{
            $this->Flash->error(__('Something went wrong. Please, try again.'));
        }
        $this->redirect(['controller' => 'Contractors', 'action' => 'dashboard', $contractor_id]);
    }

    public function aggregateOrientationReport($export_type=null, $client_id=null){

        //$this->loadModel('Clients');

        if($client_id == null){
            $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
        }
        if($client_id != null){

            $conn = ConnectionManager::get('default');
            $qry = "select aggregate_training_percentages.*, employees.pri_contact_fn, employees.pri_contact_ln, contractors.company_name
                    from aggregate_training_percentages
                    left join employees on(employees.id = aggregate_training_percentages.employee_id)
                    left join contractors ON(contractors.id = aggregate_training_percentages.contractor_id) 
                    where aggregate_training_percentages.client_id = " . $client_id;
            $fetchedData = $conn->execute($qry)->fetchAll('assoc');
            $employeeList = array();
            $i = 0;

            foreach ($fetchedData as $fetchedDataRow){
                $employeeList[$i]['percentage'] = (isset($fetchedDataRow['percentage']) && $fetchedDataRow['percentage'] >= 100) ? 'Complete' : 'Incomplete';

                $employeeList[$i]['emp_name'] = " ";
                if(isset($fetchedDataRow['pri_contact_fn'])){
                    $employeeList[$i]['emp_name'] .= $fetchedDataRow['pri_contact_fn'];
                }
                if(isset($fetchedDataRow['pri_contact_ln'])){
                    $employeeList[$i]['emp_name'] .= ' '.$fetchedDataRow['pri_contact_ln'];
                }
                $employeeList[$i]['contractor_name'] = isset($fetchedDataRow['company_name']) ? $fetchedDataRow['company_name'] : ' ';

                $employeeList[$i]['contractor_id'] = isset($fetchedDataRow['contractor_id']) ? strval($fetchedDataRow['contractor_id']) : '';
                $employeeList[$i]['employee_id'] = isset($fetchedDataRow['employee_id']) ? strval($fetchedDataRow['employee_id']) : '';
                $i++;
            }
            if($export_type != null){

                $extras = array();
                $extras['client_logo'] = $client_id . '.jpg';
                $clientName = $this->Clients->find('all')->select(['company_name'])->where(['id' => $client_id])->first();
                $extras['client_name'] = '';
                if(isset($clientName->company_name))
                $extras['client_name'] = $clientName->company_name;
                $extras['file_name'] = 'employee_orientation_report_'.$client_id;
                $extras['title'] = 'orientation_report_'.$client_id;

                $headT = array('Status', 'Employee', 'Supplier Name', 'contractor_id', 'employee_id');

                if($export_type == 'excel') {
                    $this->Export->XportAsExcel($employeeList,$headT, $extras);
                    exit;
                }
                if($export_type == 'csv') {
                    $this->Export->XportAsCSV($employeeList,$headT, $extras);
                    exit;
                }
            }

            $this->set(compact('employeeList'));
        }else{
            /*client id not found*/
        }

    }

    public function addClientsToGc(){
        $this->loadModel('GcClients');

        /*Add association form*/
        $clients = $this->Clients->find('list', ['keyField'=>'id', 'valueField'=>'company_name' ])->where(['is_gc is not true'])->order(['company_name'])->toArray();
        $GC_clients = $this->Clients->find('list', ['keyField'=>'id', 'valueField'=>'company_name' ])->where(['is_gc' => true])->order(['company_name'])->toArray();


        /*show existing relations*/
        $conn = ConnectionManager::get('default');
        $qry = "select gc_clients.*, client1.company_name as gc, client2.company_name as parent from gc_clients 
                left join clients as client1 on(client1.id = gc_clients.gc_client_id) 
                left join clients as client2 on(client2.id = gc_clients.parent_client_id)";
        $allAssoc = $conn->execute($qry)->fetchAll('assoc');

        /*add new association*/
        if ($this->request->is(['patch', 'post', 'put'])) {
            $postData = $this->request->getData();
            $conn = ConnectionManager::get('default');
            if(!empty($postData['gc_client_id']) && !empty($postData['parent_client_id'])){
                $exists = $conn->execute("select count(*) as cnt from gc_clients where gc_client_id = ".$postData['gc_client_id']." and parent_client_id = ".$postData['parent_client_id'])->fetchAll('assoc');
                if(isset($exists[0]['cnt']) && $exists[0]['cnt'] <= 0){
                    $today = date('Y-m-d');
                    $qry = "insert into gc_clients(gc_client_id, parent_client_id, created, modified) values(".$postData['gc_client_id'].",".$postData['parent_client_id'].",'".$today."', '".$today."')";
                    $allAssoc = $conn->execute($qry)->fetchAll('assoc');
                    if (empty($allAssoc[0])) {
                        $this->Flash->success(__('The association has been saved.'));
                        return $this->redirect(['action'=>'addClientsToGc']);
                    }
                    else {
                        $this->Flash->error(__('The association could not be saved. Please, try again.'));
                        return $this->redirect(['action'=>'addClientsToGc']);
                    }
                }else{
                    $this->Flash->error(__('Association already exists'));
                    return $this->redirect(['action'=>'addClientsToGc']);
                }
            }else{
                $this->Flash->error(__('Form data is incorect. Please, try again.'));
                return $this->redirect(['action'=>'addClientsToGc']);
            }

        }

        $this->set(compact('clients', 'GC_clients', 'allAssoc'));

    }

    public function removeClientsToGc($id = null){
        if($id != null){
            $conn = ConnectionManager::get('default');
            $remove = $conn->execute("delete from gc_clients where id =" . $id)->fetchAll('assoc');
            if(empty($remove[0])){
                $this->Flash->success(__('The association has been removed.'));
                return $this->redirect(['action'=>'addClientsToGc']);
            }else{
                $this->Flash->error(__('The association could not be removed. Please, try again.'));
                return $this->redirect(['action'=>'addClientsToGc']);
            }
        }else{
            $this->Flash->error(__('The association could not be removed. id missing. Please, try again.'));
            return $this->redirect(['action'=>'addClientsToGc']);
        }
    }
}
