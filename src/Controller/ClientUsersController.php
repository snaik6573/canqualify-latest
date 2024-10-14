<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Routing\Router;
/**
 * ClientUsers Controller
 *
 * @property \App\Model\Table\ClientUsersTable $ClientUsers
 *
 * @method \App\Model\Entity\ClientUser[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ClientUsersController extends AppController
{
    public function isAuthorized($user)
    {
	$clientNav = false;
	if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN) {
		$clientNav = true;
	}
	$this->set('clientNav', $clientNav);

	if($this->request->getParam('action')=='myProfile') {
		if($user['role_id'] == CLIENT_ADMIN || $user['role_id'] == CLIENT_VIEW || $user['role_id'] == CLIENT_BASIC) {
			return true; 
		}
	}
  
	if (isset($user['role_id']) && $user['active']==1) {
		if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN || $user['role_id'] == CLIENT || $user['role_id'] == CLIENT_ADMIN) {
			return true;
		}
	}
	// Default deny
	return false;
    }

    public function addClient($step = 1,$id = null,$client_id=null)
    {
        ini_set('memory_limit','-1');   
        $this->loadModel('Users');
        $this->loadModel('CustomerRepresentative');
        $this->loadModel('AccountTypes');
        $this->loadModel('Countries');
        $this->loadModel('States');
        $this->loadModel('Services');
        $this->loadModel('ClientServices');
        $this->loadModel('ClientModules');
        $this->loadModel('Modules');
        $this->loadModel('Clients');
        $this->loadModel('Questions');
        $this->loadModel('QuestionTypes');

        $user_id = $this->getRequest()->getSession()->read('Auth.User.id');
        $saved_status = 0;
        $clids = array();
        $servicelist= array();

        if($id != null) { // Edit Client
        $clientUser = $this->ClientUsers->get($id, [
            'contain' => ['Users','Clients', 'Clients.ClientServices', 'Clients.ClientServices.Services', 'Clients.ClientQuestions.Questions', 'Clients.ClientModules', 'Clients.ClientModules.Modules']
        ]);
        
        if(isset($clientUser['client_id'])){
            $client_id = $clientUser['client_id'];
        }

        $newstep = $clientUser->client->registration_status+1;
        $saved_status = $clientUser->client->registration_status;
       
        if($step > 1 && $saved_status != ($step-1) && $saved_status < $step) {
            $this->Flash->error(__('Please complete step'.$newstep));
            return $this->redirect(['action'=>'addClient/'.$newstep.'/'.$id]);                                
        }
        if(isset($clientUser->client['client_services']) && !empty($clientUser->client['client_services'])) {
            // Services for step 3
            foreach($clientUser->client['client_services'] as $cliservice) {
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
            ->contain(['Services.Categories.Questions.ClientQuestions'=> ['conditions'=>['ClientQuestions.client_id'=>$client_id]]])
            ->where(['ClientServices.client_id'=>$client_id, 'Services.active'=>true])
            ->toArray();
        }
        
    }
    else { // New Client
        $clientUser = $this->ClientUsers->newEntity();
        $client = $this->ClientUsers->Clients->newEntity();      
        if($step > 1) {
            $this->Flash->error(__('Please complete step 1'));
            return $this->redirect(['action'=>'addClient/1']);
        }
    }
    $modclids = array();
    if(isset($clientUser->client['client_modules']) && !empty($clientUser->client['client_modules'])) {
        foreach($clientUser->client['client_modules'] as $climodules) {
            $modclids[$climodules['id']] = $climodules['module_id'];
        }
    }
    // step 4
    $question = $this->Questions->newEntity();
    $questids = array();    
    if(isset($clientUser->client['client_questions']) && !empty($clientUser->client['client_questions'])) {
        foreach($clientUser->client['client_questions'] as $cliservice) {           
            $questids[$cliservice['question']['category_id']][] = $cliservice['question_id'];
        
        }
    }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $requestData = $this->request->getData();
            $clientUser = $this->ClientUsers->patchEntity($clientUser, $requestData);       
            // save data step 3 
            $selectedServices = array();
            if($this->request->getData('client.client_services')!=null) {
            $newServices = array();

            foreach($requestData['client']['client_services'] as $key=>$val) {
                if($val['service_id']==0)  {
                    unset($requestData['client']['client_services'][$key]);
                }
                else {
                    $selectedServices[] = $val['service_id'];                   
                    if (!in_array($val['service_id'], $clids)) {
                        $newServices[] = $val;
                    }   
                }                           
            }

            // delete ClientServices
            foreach($clids as $serviceid) {
            if (!in_array($serviceid, $selectedServices)) {
                $entity = $this->ClientUsers->Clients->ClientServices->find()->where(['client_id'=>$client_id,'service_id'=>$serviceid])->first();
                $result = $this->ClientUsers->Clients->ClientServices->delete($entity);
            }
            }

            foreach($newServices as $newService) { 
                $clientService = $this->ClientUsers->Clients->ClientServices->newEntity();
                $clientService = $this->ClientUsers->Clients->ClientServices->patchEntity($clientService, $newService);                
                $this->ClientUsers->Clients->ClientServices->save($clientService);
            }
        }
            if($this->request->getData('client.client_modules')!=null) {
            $selectedModules = array();
            $newModules = array();
            foreach($requestData['client']['client_modules'] as $key=>$val) {
                if($val['module_id']==0)  {
                    unset($requestData['client.client_modules'][$key]);
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
                $entity = $this->ClientUsers->Clients->ClientModules->find()->where(['client_id'=>$client_id,'module_id'=>$moduleid])->first();
                $result = $this->ClientUsers->Clients->ClientModules->delete($entity);
            }
            }
            // new insert
            foreach($newModules as $m) { 
                $module = $this->ClientUsers->Clients->ClientModules->newEntity();
                $module = $this->ClientUsers->Clients->ClientModules->patchEntity($module, $m);
                $this->ClientUsers->Clients->ClientModules->save($module);
            }
        }

            if($id != null) { // edit client
            $clientUser->client->modified_by = $user_id;
            }
            else { // new client
                $clientUser->client->created_by = $user_id;
            }

            if($saved_status > $this->request->getData('client.registration_status')) { 
                $clientUser->client->registration_status = $saved_status; 
            }
            
            $step = $this->request->getData('client.registration_status');
             /* User Entered Country and state */
            if($step  == 2 && ($this->request->getData('client.country_id') == 0)){
                $country = $this->Countries->newEntity();
                $state   = $this->States->newEntity();
                if(($this->request->getData('client.country_id') != null) || ($this->request->getData('client.state_id') != null)){
                    $user_entered = true; // User entered Country and State

                    $country->name = $this->request->getData('client.country');
                    $country->created_by = $clientUser->user->id;
                    $country->user_entered = $user_entered;
                  
                   if($country_result = $this->Countries->save($country)){
                     
                       $state->name = $this->request->getData('client.state');
                       $state->country_id = $country_result->id;
                       $state->user_entered = $user_entered;
                       $state->created_by = $clientUser->user->id;
                       $state_result = $this->States->save($state);

                       unset($clientUser['user']);
                       $clientUser->client->country_id = $country_result->id;
                       $clientUser->client->state_id = $state_result->id;

                       if ($result = $this->ClientUsers->save($clientUser)) {     
                       //pr($result);die;      
                            $this->Flash->success(__('The client has been saved.'));
                        if($step < 4) {
                            $step = $step + 1;
                            return $this->redirect(['action'=>'addClient/'.$step.'/'.$result->id.'/'.$client_id]);
                        }
                        else {
                            return $this->redirect(['action'=>'clientList']);
                            }
                        }
                    }
                   $this->Flash->error(__('The client could not be saved. Please, try again.'));
                }
            }
            // pr($clientUser);
           // pr($requestData);die;
            if($result = $this->ClientUsers->save($clientUser)) {
            //pr($result);die;          
            $this->Flash->success(__('The client has been saved.'));
            if($step < 4) {
                $step = $step + 1;
                return $this->redirect(['action'=>'addClient/'.$step.'/'.$result->id.'/'.$result->client_id]);
            }
            else {
                return $this->redirect(['controller'=>'ClientUsers','action'=>'clientList']);
            }
        }
        $this->Flash->error(__('The client could not be saved. Please, try again.'));

            // pr($clientUser);die;

        }

        if(isset($clientUser->client->id)){ /* Country and state edit */
           $where = ['OR'=>['user_entered IS NOT'=>true,'created_by'=>$clientUser->user_id]];
           $states = $this->ClientUsers->Clients->States->find('list')->where(['country_id'=>$clientUser->client->country_id])->toArray();
           $countries = $this->ClientUsers->Clients->Countries->find('list')->where([$where])->toArray();
        }else{  /* add */
           $states = $this->ClientUsers->Clients->States->find('list')->where(['user_entered'=>false])->toArray();
           $countries = $this->ClientUsers->Clients->Countries->find('list')->where(['user_entered'=>false])->toArray();
        }
        $services = $this->Services->find('list', ['keyField'=>'id', 'valueField'=>'name' ])->order(['service_order'])->toArray();    
        $modules = $this->Modules->find('list', ['keyField'=>'id', 'valueField'=>'name' ])->toArray();
        $customer_rep = $this->CustomerRepresentative->find('list', ['keyField'=>'id', 'valueField'=>'user.username' ])->contain(['Users']);
        $adminRole = array(SUPER_ADMIN, ADMIN,CR);
        $users = $this->Users->find('list', ['keyField'=>'id', 'valueField'=>'username' ])  
             ->where(['Users.role_id IN'=>$adminRole])->contain(['Roles'])->toArray();    
        $accountTypes = $this->AccountTypes->find('list');
        $questionTypes = $this->QuestionTypes->find('list')->toArray();
        $this->set(compact('clientUser','customer_rep','users','accountTypes','user_id','states','countries','services','modules','clids','modclids','servicelist','questionTypes','step','question'));
    }


    public function addquestions($cid = null,$clientUserId =null)
    {
    $this->loadModel('Questions');

    $question = $this->Questions->newEntity();
        if ($this->request->is(['patch', 'post', 'put'])) { 
            $question = $this->Questions->patchEntity($question, $this->request->getData());
            $question->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
            $question->question_options = json_encode(explode("\r\n", $this->request->getData('question_options')));
            if ($this->Questions->save($question)) {
                $this->Flash->success(__('The question has been saved.'));
                return $this->redirect(['action'=>'addClient/'.$this->request->getData('step').'/'.$clientUserId]);
            }
        else {
                $this->Flash->error(__('The question could not be saved. Please, try again.'));
                return $this->redirect(['action'=>'addClient/'.$this->request->getData('step').'/'.$clientUserId]);
            }
        }
    $question = $this->Questions->find()->where(['client_id'=>$cid]); 
    $this->set(compact('question'));
    $this->Render(false);   
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
    //pr($this->request->getData());die;     
        $this->viewBuilder()->setLayout('ajax');
      
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
    
        echo '<div class="alert with-close alert-success alert-dismissible fade show" role="alert">The Client Questions has been saved.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';        
        }
    }       
    
    //return $this->redirect(['action'=>'add/'.$step.'/'.$cid]);            
    $clientquestions = $this->ClientUsers->Clients->ClientQuestions->find()->where(['client_id'=>$cid]);
    $this->set(compact('clientquestions'));
   }

   public function clientList()
   {
    $this->loadModel('Users');
    $this->loadModel('Clients');

        $userList = $this->Users
        ->find('all')
        ->contain(['ClientUsers'])
        ->contain(['ClientUsers.Clients'])
        ->contain(['ClientUsers.Clients.AccountTypes']) 
        ->contain(['ClientUsers.Clients.Sites']) 
        ->contain(['ClientUsers.Clients.Sites.States']) 
        ->contain(['ClientUsers.Clients.Sites.Countries'])       
        ->where(['role_id'=>CLIENT])
        ->toArray();

    $this->set(compact('userList'));

    if ($this->request->is(['patch', 'post', 'put'])) { 
        $this->viewBuilder()->setLayout('ajax');
        $update = $this->request->getData('update');
        if(!empty($update) && $update == 'is_gc'){
            $client = $this->Clients->find()->where(['id'=>$this->request->getData('id')])->first();
            $user = $this->Clients->patchEntity($client, $this->request->getData());
            if ($this->Clients->save($client)) {
                echo '<div class="alert with-close alert-success alert-dismissible fade show" role="alert">The contractor has been saved.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
            }
            else {
                echo '<div class="alert with-close alert-danger alert-dismissible fade show" role="alert">The contractor could not be saved. Please, try again.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
            }
        }else{
            $user = $this->Users->find()->where(['username'=>$this->request->getData('username')])->first();
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                echo '<div class="alert with-close alert-success alert-dismissible fade show" role="alert">The contractor has been saved.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
            }
            else {
                echo '<div class="alert with-close alert-danger alert-dismissible fade show" role="alert">The contractor could not be saved. Please, try again.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
            }
        }

        exit;
        }

   }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
	$client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
        $totalCount = $this->ClientUsers->find('all')->where(['client_id'=>$client_id])->count();
        $this->paginate = [
         'contain' => ['Users', 'Users.Roles', 'Clients'],
	    'conditions' => ['client_id'=>$client_id],
            'limit'=>$totalCount,
            'maxLimit'=>$totalCount
        ];
        $clientUsers = $this->paginate($this->ClientUsers);
	
        // $client = $this->ClientUsers->Clients->find('all')->contain(['Users', 'Users.Roles'])->where(['Clients.id'=>$client_id])->first();
        $this->set(compact('clientUsers'));
    }

    /**
     * View method
     *
     * @param string|null $id Client User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $clientUser = $this->ClientUsers->get($id, [
            'contain' => ['Users', 'Clients']
        ]);

	if($clientUser->site_ids!='') {
		$site_ids = $clientUser->site_ids['s_ids'];
		$sitesAssigned = $this->ClientUsers->Clients->Sites->find('list', ['keyField'=>'id', 'valueField'=>'name' ])->where(['id IN'=>$site_ids])->toArray();
	}
        $this->set(compact('clientUser', 'sitesAssigned'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
	$this->loadModel('Users');

	$client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');

	if($this->User->isAdmin()) {
		//$getRole = $this->ClientUsers->Clients->find('list', ['keyField'=>'id', 'valueField'=>'user.role_id'])->contain('Users')->where(['Clients.id'=>$client_id])->toArray();
        $getRole = $this->ClientUsers->find('list', ['keyField'=>'client_id', 'valueField'=>'user.role_id'])->contain('Users')->where(['ClientUsers.client_id'=>$client_id ,'Users.role_id'=>CLIENT])->toArray();

		$roleId =  $getRole[$client_id];
	}
	elseif($this->User->isClient()) {
		$roleId = CLIENT;
	}
	$roles = $this->Users->Roles->find('list', ['keyField' => 'id', 'valueField' => 'role_title'])->where(['parent_id'=>$roleId]);

        $clientSites = $this->ClientUsers->Clients->Sites->find('list', ['keyField'=>'id', 'valueField'=>'name' ])->where(['client_id'=>$client_id])->toArray();
        $clientUser = $this->ClientUsers->newEntity();
        if ($this->request->is('post')) {
            $siteIds = $this->request->getData('site_ids');
            $clientUser = $this->ClientUsers->patchEntity($clientUser, $this->request->getData());

            $clientUser->client_id = $client_id;
            $clientUser->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
            $clientUser->site_ids = ['s_ids' => $siteIds];;
            if ($this->ClientUsers->save($clientUser)) {
                $this->Flash->success(__('The client user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The client user could not be saved. Please, try again.'));
        }
        //$users = $this->ClientUsers->Users->find('list');
        //$clients = $this->ClientUsers->Clients->find('list');
        $this->set(compact('clientUser', 'roles', 'clientSites'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Client User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
	$this->loadModel('Users');

    $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');

	if($this->User->isAdmin()) {
		// $getRole = $this->ClientUsers->Clients->find('list', ['keyField'=>'id', 'valueField'=>'user.role_id'])->contain('Users')->where(['Clients.id'=>$client_id])->toArray();
        $getRole = $this->ClientUsers->find('list', ['keyField'=>'client_id', 'valueField'=>'user.role_id'])->contain('Users')->where(['ClientUsers.client_id'=>$client_id ,'Users.role_id'=>CLIENT])->toArray();
        
		$roleId =  $getRole[$client_id];
	}
	elseif($this->User->isClient()) {
		$roleId = $this->getRequest()->getSession()->read('Auth.User.role_id');
        if(in_array($roleId,array(CLIENT_ADMIN)))
        {
            $roleId = 3;
        }
	}
	$roles = $this->Users->Roles->find('list', ['keyField' => 'id', 'valueField' => 'role_title'])->where(['parent_id'=>$roleId]);

	// client all sites
        $clientSites = $this->ClientUsers->Clients->Sites->find('list', ['keyField'=>'id', 'valueField'=>'name' ])->where(['client_id'=>$client_id])->toArray();

        $clientUser = $this->ClientUsers->get($id, [
            'contain' => ['Users']
        ]);

        $selectedSites = $this->ClientUsers->find('list', ['keyField'=>'id', 'valueField'=>'site_ids'])->where(['id'=>$id])->toArray();

        $csites = $selectedSites[$id]['s_ids'];
        if ($this->request->is(['patch', 'post', 'put'])) {
            $siteIds = array();
    		if (is_array( $this->request->getData('site_ids'))) {
                $siteIds = $this->request->getData('site_ids');
            }
            $clientUser = $this->ClientUsers->patchEntity($clientUser, $this->request->getData());
            $clientUser->site_ids = ['s_ids' => $siteIds];
            $clientUser->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');
            if ($this->ClientUsers->save($clientUser)) {
                $this->Flash->success(__('The client user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } 
            $this->Flash->error(__('The client user could not be saved. Please, try again.'));
        }      
        $this->set(compact('clientUser', 'roles', 'clientSites', 'csites'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Client User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->loadModel('Users');
        $this->request->allowMethod(['post', 'delete']);
        $clientUser = $this->ClientUsers->get($id);
        //debug($clientUser);die;
        if ($this->ClientUsers->delete($clientUser)) {
            $this->Flash->success(__('The client user has been deleted.'));
            /*delete related records*/
            $user = $this->Users->deleteAll(['id' => $clientUser->user_id]);
        } else {
            $this->Flash->error(__('The client user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function myProfile()
    {
	$id = $this->getRequest()->getSession()->read('Auth.User.cadmin_id');

        $clientUser = $this->ClientUsers->get($id, [
            'contain' => ['Users']
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $clientUser = $this->ClientUsers->patchEntity($clientUser, $this->request->getData());
            $clientUser->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');
            if ($this->ClientUsers->save($clientUser)) {
				
				if(null !== $this->request->getData('user.profile_photo')){
					$this->getRequest()->getSession()->write('Auth.User.profile_photo', $clientUser->user->profile_photo);				
				}
				$this->set('activeUser', $this->getRequest()->getSession()->read('Auth.User'));
				
                $this->Flash->success(__('The profile has been saved.'));
                return $this->redirect(['action'=>'my-profile']);
            }
            $this->Flash->error(__('The profile could not be saved. Please, try again.'));
        }
        $this->set(compact('clientUser'));
    }

    public function landingpageLinks()
    {
        $this->loadModel('Clients');
        $clients = $this->Clients->find('all')->select(['id', 'company_name'])->toArray();
        //$key = 'wt1U5MACWJFTXGenFoZoiLwQGrLgdbHA';
        //$id = Security::encrypt(11, $key);//place client id here
        $data = array();
        if(!empty($clients) && count($clients) > 0) {
            foreach($clients as $client){
                $id = bin2hex($client->id);
                $url = Router::Url(['controller' => 'users', 'action' => 'register',$id], true);
                array_push($data, array($client->id, $client->company_name, $url));
            }
        }
        $this->set(compact('data'));
    }
}
