<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;


/**
 * ContractorClients Controller
 *
 * @property \App\Model\Table\ContractorClientsTable $ContractorClients
 *
 * @method \App\Model\Entity\ContractorClient[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ContractorClientsController extends AppController
{
     public function isAuthorized($user)
    {
    $contractorNav = false;
    if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN) {
        $contractorNav = true;
    }
    $this->set('contractorNav', $contractorNav);

    if($this->request->getParam('action')=='unasign') {
        if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN || $user['role_id'] == CR) {
            return true;
        }
    }
    if (isset($user['role_id'])) {
        if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN || $user['role_id'] == CONTRACTOR || $user['role_id'] == CONTRACTOR_ADMIN || $user['role_id'] == CR) {
            return true;
        }
    }
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        // $this->paginate = [
        //     'contain' => ['Contractors', 'Clients']
        // ];
        // $contractorClients = $this->paginate($this->ContractorClients);

        // $this->set(compact('contractorClients'));
    }

    /**
     * View method
     *
     * @param string|null $id Contractor Client id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $contractorClient = $this->ContractorClients->get($id, [
            'contain' => ['Contractors', 'Clients']
        ]);

        $this->set('contractorClient', $contractorClient);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
   public function add($req_client_id=null)
    {
    $this->loadModel('Clients');
    $this->loadModel('Users');
    $this->loadModel('Contractors');
    $this->loadModel('ContractorTempclients');
    
    $contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
    $contractor = $this->ContractorClients->Contractors->get($contractor_id);
    
    $clients = $this->ContractorClients->find('list', ['keyField'=>'client_id', 'valueField'=>'client_id'])->where(['contractor_id'=>$contractor_id])->toArray();
    $tempClient = $this->ContractorTempclients->find('list', ['keyField'=>'client_id', 'valueField'=>'client_id'])->where(['contractor_id'=>$contractor_id])->toArray();

    // on client request accept add client to ContractorTempclients
    if($req_client_id!=null && !in_array($req_client_id, $tempClient)) {
        $tempclient = $this->ContractorTempclients->newEntity();
        $tempclient->client_id = $req_client_id;
        $tempclient->contractor_id = $contractor_id;
        $tempclient->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
        $this->ContractorTempclients->save($tempclient);
        
        // fetch tempClient again
        $tempClient = $this->ContractorTempclients->find('list', ['keyField'=>'client_id', 'valueField'=>'client_id'])->where(['contractor_id'=>$contractor_id])->toArray();        
    }
    
    $where = [];
    if(!empty($clients)) {
            $where['Clients.id NOT IN'] = $clients;
    }
    // $clients = $this->Clients
    // ->find()
    // ->select(['id', 'company_name'])
    // ->contain(['Users'=>['conditions'=>['Users.role_id'=>'3','Users.active'=>true,'Users.under_configuration'=>false]]])        
    // ->where($where)
    // ->toArray();

    $userList = $this->Users
        ->find('all')
        ->contain(['ClientUsers'])
        ->contain(['ClientUsers.Clients'=>['conditions'=>[$where]]])               
        ->where(['role_id'=>CLIENT,'Users.under_configuration'=>false])
        ->toArray();
      
    $clientList = array();
    foreach ($userList as $key => $user) {
        $client = $user['client_user']['client'];
        //if(!empty($client)){
         $clientList[] = $client;
        //}
    }
    
    $clientSelection = array();
    foreach ($clientList as $cl) {
        if(!empty($cl['id'])){
            if($cl['id'] == 4 ){
                $clientSelection[$cl['company_name']][$cl['id']] = 'CanQualify Free Listed for Marketing';
            }else{
                $clientSelection[$cl['company_name']][$cl['id']] = $cl['company_name'];}
        }
    }
    if(!empty($clientSelection)){
        $clientSelection = array('CanQualify Marketplace' => $clientSelection['CanQualify Marketplace']) + $clientSelection;
    }
    $contractorClient = $this->ContractorTempclients->newEntity();

    if ($this->request->is(['patch', 'post', 'put'])) {
        $this->viewBuilder()->setLayout('ajax');

        /* save tempSites  */ 
        $deletedclients =array();         
        if (is_array($this->request->getData('client_id'))) {
            foreach ($this->request->getData('client_id') as $client_id) { // Add
                if(!in_array($client_id, $tempClient)) {
                    $contractorTempclients = $this->ContractorTempclients->newEntity();
                    $contractorTempclients = $this->ContractorTempclients->patchEntity($contractorClient, $this->request->getData());
                    $contractorTempclients->client_id = $client_id;
                    $contractorTempclients->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
                    $this->ContractorTempclients->save($contractorTempclients);
                }
            }

            // deleted tempClients
            $deletedclients = array_intersect($tempClient, $this->request->getData('client_id'));
            // Update registration_status
            if($contractor->registration_status == 1) {
                $contractor->registration_status = 2;
                $this->ContractorClients->Contractors->save($contractor);
            }  
           
        }
        else {
                $deletedclients = $tempClients;
        }
        if(!empty($deletedclients)) {
            $this->ContractorTempclients->query()
                ->delete()              
                ->where(['client_id IN'=>$deletedclients, 'contractor_id'=>$contractor_id])
                ->execute();
        }
        $ajaxtrue = 1;
        $this->set(compact('ajaxtrue'));
    }

    $services = $this->User->getContractorServices($contractor_id, true);
    $paymentInfo = $this->User->calculatePayment($contractor_id, $services);//pr($paymentInfo);
    $contractorClients = $this->ContractorClients
            ->find()
            ->where(['contractor_id'=>$contractor_id])
            ->contain(['Contractors'=>['fields'=>['Contractors.id', 'Contractors.company_name']]])
            ->contain(['Clients'=>['fields'=>['Clients.id', 'Clients.company_name']]])
            ->toArray();
 
    $this->set(compact('contractor','contractorClient', 'paymentInfo', 'clientSelection', 'contractor_id', 'tempClient', 'contractorClients', 'req_client_id','clients'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Contractor Client id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $contractorClient = $this->ContractorClients->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contractorClient = $this->ContractorClients->patchEntity($contractorClient, $this->request->getData());
            if ($this->ContractorClients->save($contractorClient)) {
                $this->Flash->success(__('The contractor client has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The contractor client could not be saved. Please, try again.'));
        }
        $contractors = $this->ContractorClients->Contractors->find('list', ['limit' => 200]);
        $clients = $this->ContractorClients->Clients->find('list', ['limit' => 200]);
        $this->set(compact('contractorClient', 'contractors', 'clients'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Contractor Client id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $contractorClient = $this->ContractorClients->get($id);
        if ($this->ContractorClients->delete($contractorClient)) {
            $this->Flash->success(__('The contractor client has been deleted.'));
        } else {
            $this->Flash->error(__('The contractor client could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function manageClients() {
    $contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');

    $contractor = $this->ContractorClients->Contractors->get($contractor_id, 
        ['contain'=>[
        'Users'=>['fields'=>['Users.id', 'Users.username']],
        'ContractorClients'=>['fields'=>['ContractorClients.id','ContractorClients.contractor_id']],
        'ContractorClients.Clients'=>['fields'=>['company_name','id']],      
        
    ] ]);

    $this->set(compact('contractor'));
    }

    // Move Data ContractorSite to ContractorClients 
    public function updateClients(){
        $this->loadModel('Clients');
        $this->loadModel('ContractorSites');
        $existinClients = $this->Clients->find('list',['keyField'=>'id','valueField'=>'id'])->toArray();

        foreach ($existinClients as $key => $clientId) {
            $contractors = $this->ContractorSites
            ->find('list', ['keyField'=>'id', 'valueField'=>'contractor_id'])
            ->where(['client_id'=>$clientId])
            ->distinct(['contractor_id'])
            ->toArray();

            foreach ($contractors as $key => $cont) {
                $is_exists = $this->ContractorClients->find()
                                 ->where(['contractor_id'=>$cont,'client_id'=>$clientId])
                                 ->count();
                if($is_exists==0){
                    $contractorClient = $this->ContractorClients->newEntity();
                    $contractorClient->client_id = $clientId;
                    $contractorClient->contractor_id= $cont;
                    $contractorClient->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
                    $this->ContractorClients->save($contractorClient);
                }
            }
        }
    }

    public function transferWaitingOn(){
        $this->loadModel('Contractors');
        $this->loadModel('ContractorClients');
        $allContractors =  $this->Contractors->find('all')->toArray();
        $conn = ConnectionManager::get('default');
        $status = array('Contractor' => 1, 'Canqualify' => 2,'Client' => 3,'Complete' => 4);
        foreach ($allContractors as $contractor) {
            echo $cnt = $this->ContractorClients->find('all')->where(['contractor_id' => $contractor['id'], 'client_id !=' => 4])->count();
                //debug($contractor);die;
                $empList = $conn->execute("update contractor_clients set waiting_on = ".$status[$contractor['waiting_on_orig']]." where contractor_id = ".$contractor['id']."");

        }
        die;
    }

    public function updateWaitingOn(){

        if ($this->request->is('post')) {
            $postData = $this->request->getData();
            if(!empty($postData['waiting_on']) && !empty($postData['client_id']) && !empty($postData['contractor_id'])){
                $conn = ConnectionManager::get('default');
                $query = "UPDATE contractor_clients set waiting_on = ".$postData['waiting_on']." where client_id = ".$postData['client_id']." and contractor_id = ".$postData['contractor_id'];

                $update = $conn->execute($query);

            }
            return $this->redirect(['controller'=>'Contractors', 'action' => 'dashboard', $postData['contractor_id']]);
        }
    }
   
}
