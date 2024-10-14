<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
/**
 * Sites Controller
 *
 * @property \App\Model\Table\SitesTable $Sites
 *
 * @method \App\Model\Entity\Site[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SitesController extends AppController
{
    public function isAuthorized($user)
    {
    if($this->request->getParam('action')=='addsites') {
        $clientNav = true;
       $this->set('clientNav', $clientNav);
    }
   
	if($this->request->getParam('action')=='clientSites') {
		$clientNav = false;
		if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN) {
			$clientNav = true;
		}
		$this->set('clientNav', $clientNav);

		if($user['role_id'] == CLIENT || $user['role_id'] == CLIENT_ADMIN || $user['role_id'] == CLIENT_VIEW || $user['role_id'] == CLIENT_BASIC) { 
			return true; 
		}
	}
	if (isset($user['role_id']) && $user['active'] == 1) {
		if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN){		
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
	$totalCount = $this->Sites->find('all')->count();
	$this->paginate = [
	   	'contain' => ['Countries', 'Regions', 'States', 'Clients'],
		'limit'   => $totalCount,
		'maxLimit'=> $totalCount
      	];
        $sites = $this->paginate($this->Sites);
        $this->set(compact('sites'));
    }

    public function clientSites()
    {
	$client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
	$sites = $this->User->getClientSites($client_id);
    
    if (!empty($sites)){
	$this->paginate = [
	   	'contain' => ['Countries', 'Regions', 'States', 'Clients'],
		'conditions' => ['Sites.id IN'=>array_keys($sites)],
		'limit' => 10000,
		'maxLimit'=> 10000
	];

        $sites = $this->paginate($this->Sites);
        $this->set(compact('sites'));
         }  
    }
    /**
     * View method
     *
     * @param string|null $id Site id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $site = $this->Sites->get($id, [
            'contain' => ['Clients', 'Regions', 'States', 'Countries']
        ]);

        $this->set('site', $site);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
    $this->loadModel('Countries');
    $this->loadModel('States');
	$clients = $this->Sites->Clients->find('list', ['keyField' => 'id', 'valueField' => 'company_name']);
	$this->set(compact('clients'));
	$regions = $this->Sites->Regions->find('list');


        $site = $this->Sites->newEntity();
        $country = $this->Countries->newEntity();
        $state = $this->States->newEntity();
        if ($this->request->is('post')) {
           if((($this->request->getData(['country_id']) != null) || ($this->request->getData(['state_id']) != null)) && ($this->request->getData(['country_id']) == 0)){
              $user_entered = true; // User entered Country and State

              /* Admin entered country and state */
               $user_id = $this->getRequest()->getSession()->read('Auth.User.id');

               $country->name = $this->request->getData(['country']);
               $country->created_by = $user_id;
               $country->user_entered = $user_entered;

               if($country_result = $this->Countries->save($country)){
                 
                   $state->name = $this->request->getData(['state']);
                   $state->country_id = $country_result->id;
                   $state->user_entered = $user_entered;
                   $state->created_by = $user_id;
                   $state_result = $this->States->save($state);

                   $site = $this->Sites->patchEntity($site, $this->request->getData());
                   $site->country_id = $country_result->id;
                   $site->state_id = $state_result->id;
                   $site->created_by = $this->getRequest()->getSession()->read('Auth.User.id');

                   if ($this->Sites->save($site)) {
                      $this->Flash->success(__('The site has been saved.'));
                      return $this->redirect(['action' => 'index']);
                    }
                }
                $this->Flash->error(__('The site could not be saved. Please, try again.'));
                return $this->redirect(['controller' => 'Sites', 'action' => 'add']);

            }else{ // Normal flow site save

            $site = $this->Sites->patchEntity($site, $this->request->getData());

            $site->created_by = $this->getRequest()->getSession()->read('Auth.User.id');

            if ($this->Sites->save($site)) {
                $this->Flash->success(__('The site has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The site could not be saved. Please, try again.'));
          }
        }

        $states = $this->Sites->States->find('list')->where(['user_entered'=>false])->toArray();
        $countries = $this->Sites->Countries->find('list')->where(['user_entered'=>false])->toArray();

        $this->set(compact('site', 'regions', 'states', 'countries'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Site id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
	$clients = $this->Sites->Clients->find('list', ['keyField' => 'id', 'valueField' => 'company_name']);
	$this->set(compact('clients'));
	$regions = $this->Sites->Regions->find('list');

        $site = $this->Sites->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $site = $this->Sites->patchEntity($site, $this->request->getData());

            $site->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');

            if ($this->Sites->save($site)) {
                $this->Flash->success(__('The site has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The site could not be saved. Please, try again.'));
        }

        $where = ['OR'=>['user_entered IS NOT'=>true,'created_by'=>$site->created_by]];
        $states = $this->Sites->States->find('list')->where(['OR'=>['country_id'=>$site->country_id]])->toArray();
        $countries = $this->Sites->Countries->find('list')->where([$where])->toArray();
        $this->set(compact('site', 'regions', 'states', 'countries'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Site id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $site = $this->Sites->get($id);
        if ($this->Sites->delete($site)) {
            $this->Flash->success(__('The site has been deleted.'));
        } else {
            $this->Flash->error(__('The site could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function updateLocation($id = null)
    {
        $site = $this->Sites->get($id, [
            'contain' => ['Clients.Users','States', 'Countries']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $site = $this->Sites->patchEntity($site, $this->request->getData());
            if ($this->Sites->save($site)) {
                $this->Flash->success(__('The site has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The site could not be saved. Please, try again.'));
        }
        $this->set(compact('site'));
    }
    public function addsites()
    {
    $this->loadModel('Clients');
    $this->loadModel('Sites');
    $this->loadModel('Regions');
    $this->loadModel('Countries');
    $this->loadModel('States');
    $this->loadModel('AccountTypes');


    $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id'); 
    $site = $this->Sites->newEntity();
    $country =$this->Countries->newEntity();
    $state =$this->States->newEntity();
    $showErrors =false;
    if ($this->request->is(['patch', 'post', 'put'])) {
         if((($this->request->getData(['country_id']) != null) || ($this->request->getData(['state_id']) != null)) && ($this->request->getData(['country_id']) == 0)){
            $user_entered = true; // User entered Country and State            
            $user_id = $this->getRequest()->getSession()->read('Auth.User.id');
            $country->name = $this->request->getData(['country']);
            $country->created_by = $user_id;
            $country->user_entered = $user_entered;
            if($country_result = $this->Countries->save($country)){
                 
               $state->name = $this->request->getData(['state']);
               $state->country_id = $country_result->id;
               $state->user_entered = $user_entered;
               $state->created_by = $user_id;
               $state_result = $this->States->save($state);

               $site = $this->Sites->patchEntity($site, $this->request->getData());
               $site->country_id = $country_result->id;
               $site->state_id = $state_result->id;
               $site->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
               if ($result = $this->Sites->save($site)) {
                 $this->Flash->success(__('The Site has been saved.'));
                return $this->redirect(['controller'=>'Sites','action' => 'addsites']);
               }else{
               $this->Flash->error(__('The site could not be saved. Please, try again.'));
               $showErrors =true;
               $this->set('showErrors');
               }
              //return $this->redirect(['action' => 'addsites']);
            }         
         }else{
            $site = $this->Sites->patchEntity($site, $this->request->getData());
            $site->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
         
            if ($result = $this->Sites->save($site)) {
                $this->Flash->success(__('The Site has been saved.'));
                return $this->redirect(['controller'=>'Sites','action' => 'addsites']);

            }
            $this->Flash->error(__('The site could not be saved. Please, try again.'));
            $showErrors =true;
            $this->set('showErrors');
            
        }
    }
    $client = $this->Clients->get($client_id);
    $regionslist = $this->Regions->find('list')->where(['client_id'=>$client_id]);
    $sites = $this->Sites->find()->where(['client_id'=>$client_id, 'region_id IS'=>null])->toArray();      
    $regions = $this->Regions->find()->where(['client_id'=>$client_id])->contain(['Sites'])->toArray();
    $states = $this->States->find('list')->where(['user_entered'=>false])->toArray();
        $countries = $this->Countries->find('list')->where(['user_entered'=>false])->toArray();
    $accountTypes = $this->Clients->AccountTypes->find('list');
    $this->set(compact('client','site','sites', 'regions','countries','states','regionslist','accountTypes','showErrors'));
   } 
   public function addLocation()
    {
        $this->loadModel('Clients');
        $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');               
        $client = $this->Clients->get($client_id);
        //$client = $this->Clients->newEntity();
        if ($this->request->is(['patch', 'post', 'put'])) {     
            $client = $this->Clients->patchEntity($client, $this->request->getData());
            $client->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');

            if ($this->Clients->save($client)) {
                $this->getRequest()->getSession()->write('Auth.User.company_logo', $client->company_logo);

                $this->Flash->success(__('The Account Type has been saved.'));
                return $this->redirect(['action'=>'addsites']);
            }
           // $this->Flash->error(__('Client Locations could not be saved. Please, try again.'));
        }

        $accountTypes = $this->Clients->AccountTypes->find('list');         
        $regionslist = $this->Clients->Regions->find('list')->where(['client_id'=>$client_id]);
        $regions = $this->Clients->Regions->find()->where(['client_id'=>$client_id])->contain(['Sites'])->toArray();
        //$sites = $this->Clients->Sites->find()->where(['client_id'=>$client_id]);
        $sites = $this->Clients->Sites->find()->where(['client_id'=>$client_id, 'region_id IS'=>null])->toArray();
        $states = $this->Clients->States->find('list')->where(['user_entered'=>false])->toArray();
        $countries = $this->Clients->Countries->find('list')->where(['user_entered'=>false])->toArray(); 

        $this->set(compact('regionslist','countries','states','regions','sites'));
    }
    public function addregion()
    {
    
    $this->loadModel('Regions');    
    $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
    $region = $this->Regions->newEntity();
     
        if ($this->request->is(['patch', 'post', 'put'])) { 
            $region = $this->Regions->patchEntity($region, $this->request->getData());  
            $region->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
            if ($result = $this->Regions->save($region)) {
                $this->Flash->success(__('The region has been saved.'));
                return $this->redirect(['action'=>'addsites']);
            }
            $this->Flash->error(__('The region could not be saved. Please, try again.'));
            return $this->redirect(['action'=>'addsites']);
    }
    $regions = $this->Regions->find()->where(['client_id'=>$client_id]); 
    $regionslist = $this->Regions->find('list')->where(['client_id'=>$client_id]);
    $this->set(compact('regions','regionslist'));
    }



   
}
