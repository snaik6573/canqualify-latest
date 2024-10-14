<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\Helper\BreadcrumbsHelper;
/**
 * ClientServices Controller
 *
 * @property \App\Model\Table\ClientServicesTable $ClientServices
 *
 * @method \App\Model\Entity\ClientService[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ClientServicesController extends AppController
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

    public function add($client_id=null)
    {
        $this->loadModel('Services');   
        $this->loadModel('Clients');
        $this->loadModel('ClientServices');
        $this->loadModel('Modules');

        $clients = $this->Clients->find('list',['keyField'=>'id','valueField'=>'company_name'])->order(['id'])->toArray();
        $user_id = $this->getRequest()->getSession()->read('Auth.User.id');

        if ($this->request->is(['patch', 'post', 'put'])) {
            if($this->request->getData('current_client_id')!==null) {
                $client_id = $this->request->getData('current_client_id');
                return $this->redirect(['action' => 'add', $client_id]);
            }
        }

        if($client_id!=null) { // Edit Client
        $client = $this->Clients->get($client_id, [
            'contain' => ['ClientServices', 'ClientServices.Services', 'ClientModules', 'ClientModules.Modules']
        ]);

        $clids = array();
        foreach($client['client_services'] as $cliservice) {
            $clids[$cliservice['id']] = $cliservice['service_id'];
        }

        $modclids = array();
        if(isset($client['client_modules']) && !empty($client['client_modules'])) {
            foreach($client['client_modules'] as $climodules) {
                $modclids[$climodules['id']] = $climodules['module_id'];
            }
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
        $requestData = $this->request->getData();

        if($this->request->getData('client_services')!=null) {

            $selectedServices = array();
            foreach($requestData['client_services'] as $key=>$val) {
                if($val['service_id']==0)  {
                    unset($requestData['client_services'][$key]);
                }
                else {
                    $selectedServices[] = $val['service_id'];                   
                }                           
            }
            // delete ClientServices
            foreach($clids as $serviceid) {
            if (!in_array($serviceid, $selectedServices)) {
                $entity = $this->Clients->ClientServices->find()->where(['client_id'=>$client_id,'service_id'=>$serviceid])->first();
                $result = $this->Clients->ClientServices->delete($entity);
            }
            }
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
                $entity = $this->Clients->ClientModules->find()->where(['client_id'=>$client_id,'module_id'=>$moduleid])->first();
                $result = $this->Clients->ClientModules->delete($entity);
            }
            }

            // new client_modules
            // foreach($newModules as $m) {
            //  $module = $this->Clients->ClientModules->newEntity();
            //  $module = $this->Clients->ClientModules->patchEntity($module, $m);
            //  $this->Clients->ClientModules->save($module);
            // }
        }
        
        $client_contractors = $this->User->getContractors($client_id);
        $client_services = array_diff($selectedServices,$clids);
        if(!empty($client_services)){
        $services = $this->Services->find('list', ['keyField'=>'id', 'valueField'=> 'name'])->where(['Services.id IN'=>$client_services])->toArray();
        foreach($services as $key=>$service) { //$clientsArr = $allClients[$cId]. ', '; 
            $new_service[]=$service;   }}
        $rm_services = array_diff($clids,$selectedServices);
        if(!empty($rm_services)){
        $services = $this->Services->find('list', ['keyField'=>'id', 'valueField'=> 'name'])->where(['Services.id IN'=>$rm_services])->toArray();
        foreach($services as $key=>$service) { //$clientsArr = $allClients[$cId]. ', '; 
            $remove_service[]=$service;   }         
        }
        $client = $this->Clients->patchEntity($client, $requestData);
        if ($result = $this->Clients->save($client)) {
            if(!empty($client_services) && !empty($client_contractors)){
            $this->Notification->addNotification($client_contractors,2,$client_id,$new_service);        
            }elseif(!empty($rm_services) && !empty($client_contractors)){
                $this->Notification->addNotification($client_contractors,3,$client_id,$remove_service);     
            }   
            $this->Flash->success(__('The client service has been saved.'));
            return $this->redirect(['action'=>'add', $client_id]);
        }
        }

        $services = $this->Services->find('list', ['keyField'=>'id', 'valueField'=>'name' ])->order(['service_order'])->toArray();
        $modules = $this->Modules->find('list', ['keyField'=>'id', 'valueField'=>'name' ])->toArray();
        $this->set(compact('client','clients','client_id','services','user_id','clids', 'modules', 'modclids'));
        }

        $this->set(compact('clients'));
    }

    /*public function add()
    {
    $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');

        $clientService = $this->ClientServices->newEntity();
        if ($this->request->is('post')) {
        $service_id = $this->request->getData('service_id');
        $ifExist = $this->ClientServices->find()->where(['service_id'=>$service_id, 'client_id'=>$client_id])->first();
        if($ifExist) {
              $this->Flash->error(__('The client service already selected.'));
                  return $this->redirect(['action' => 'index']);
        }

            $clientService = $this->ClientServices->patchEntity($clientService, $this->request->getData());
            $clientService->client_id = $client_id;
            $clientService->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
            if ($this->ClientServices->save($clientService)) {
                $this->Flash->success(__('The client service has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The client service could not be saved. Please, try again.'));
        }
    }


    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    /*public function index()
    {
	$client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');

        $this->paginate = [
            'contain' => ['Clients', 'Services'],
	    'conditions' => ['client_id'=>$client_id]
        ];
        $clientServices = $this->paginate($this->ClientServices);

        $this->set(compact('clientServices'));
    }*/

    /**
     * View method
     *
     * @param string|null $id Client Service id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function view($id = null)
    {
        $clientService = $this->ClientServices->get($id, [
            'contain' => ['Clients', 'Services']
        ]);

        $this->set(compact('clientService'));
    }*/

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */

   
    /*public function add()
    {
	$client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');

        $clientService = $this->ClientServices->newEntity();
        if ($this->request->is('post')) {
		$service_id = $this->request->getData('service_id');
		$ifExist = $this->ClientServices->find()->where(['service_id'=>$service_id, 'client_id'=>$client_id])->first();
		if($ifExist) {
          	  $this->Flash->error(__('The client service already selected.'));
                  return $this->redirect(['action' => 'index']);
		}

            $clientService = $this->ClientServices->patchEntity($clientService, $this->request->getData());
            $clientService->client_id = $client_id;
            $clientService->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
            if ($this->ClientServices->save($clientService)) {
                $this->Flash->success(__('The client service has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The client service could not be saved. Please, try again.'));
        }
        $clients = $this->ClientServices->Clients->find('list');
        $services = $this->ClientServices->Services->find('list');
        $this->set(compact('clientService', 'clients', 'services'));
    }*/

    /**
     * Edit method
     *
     * @param string|null $id Client Service id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function edit($id = null)
    {
	$client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');

        $clientService = $this->ClientServices->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $clientService = $this->ClientServices->patchEntity($clientService, $this->request->getData());
            $clientService->client_id = $client_id;
            $clientService->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');
            if ($this->ClientServices->save($clientService)) {
                $this->Flash->success(__('The client service has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The client service could not be saved. Please, try again.'));
        }
        $clients = $this->ClientServices->Clients->find('list');
        $services = $this->ClientServices->Services->find('list');
        $this->set(compact('clientService', 'clients', 'services'));
    }*/

    /**
     * Delete method
     *
     * @param string|null $id Client Service id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
   /* public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $clientService = $this->ClientServices->get($id);
        if ($this->ClientServices->delete($clientService)) {
            $this->Flash->success(__('The client service has been deleted.'));
        } else {
            $this->Flash->error(__('The client service could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }*/
}
