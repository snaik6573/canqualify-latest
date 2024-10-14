<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * SiteVisits Controller
 *
 * @property \App\Model\Table\SiteVisitsTable $SiteVisits
 *
 * @method \App\Model\Entity\SiteVisit[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SiteVisitsController extends AppController
{

    public function isAuthorized($user)
    {  
    $contractorNav = false;
    if($user['role_id'] == SUPER_ADMIN  || $user['role_id'] == ADMIN || $user['role_id'] == CLIENT || $user['role_id'] == CR || $user['role_id'] == CLIENT_ADMIN || $user['role_id'] == CLIENT_VIEW || $user['role_id'] == CLIENT_BASIC) {
        $contractorNav = true;
    }
    $this->set('contractorNav', $contractorNav);
    if($this->request->getParam('action')=='sitevisit' ||$this->request->getParam('action')=='view' ) {
        $clientNav = false;
        if(isset($user['client_id'])&& !isset($user['contractor_id'])) {
            $clientNav = true;
        }
        $this->set('clientNav', $clientNav);
        if($user['role_id'] == CLIENT || $user['role_id'] == CLIENT_ADMIN || $user['role_id'] == CLIENT_VIEW || $user['role_id'] == CLIENT_BASIC) {
            return true;
        }
    }
    if (isset($user['role_id']) && $user['active'] == 1) {
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
    public function index($contractor_id=null)
    {
        $this->loadModel('Clients');
        $this->loadModel('Contractors');
        $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
        $contractor_clients = $this->User->getClients($contractor_id);
        $contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
        $where['SiteVisits.contractor_id'] = $contractor_id;    
        if($client_id!=null) { 
            $where['SiteVisits.client_id'] = $client_id; 
        } elseif(!empty($contractor_clients)) {
            $where['SiteVisits.client_id IN']= $contractor_clients;
        }
        $this->paginate = [
            'contain' => ['Contractors', 'Sites','Clients'],
             'conditions' => $where,
        ];
        $site_visit = $this->Clients->find('list',['valueField'=>'site_visited'])->where(['id '=>$client_id])->enableHydration(false)->toArray(); 

        $siteVisits = $this->paginate($this->SiteVisits);
        $this->set(compact('siteVisits','contractor_id','site_visit'));
    }






    /**
     * View method
     *
     * @param string|null $id Site Visit id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $siteVisit = $this->SiteVisits->get($id, [
            'contain' => ['Contractors', 'Sites', 'Clients']
        ]);

        $this->set('siteVisit', $siteVisit);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($client_id=null)
    {
        $this->loadModel('Clients');
        $contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
        $contractor_clients  = $this->User->getClients($contractor_id);
      //  $clients = array();
        //foreach ($contractor_clients as $key => $value) {
          $clients = $this->Clients->find('list',['keyField'=>'id','valueField'=>'company_name'])->where(['id IN'=>$contractor_clients])->order(['id'])->toArray();
       // }
        
        $siteVisit = $this->SiteVisits->newEntity();
       
       if ($this->request->is(['patch', 'post', 'put'])) {
            if($this->request->getData('current_client_id')!==null) {
                $client_id = $this->request->getData('current_client_id');
                return $this->redirect(['action' => 'add', $client_id]);
            }
        }
        if($client_id!=null) { 
        $client = $this->Clients->get($client_id, [
            'contain' => []
        ]); 
        }
          if ($this->request->is('post')) {
            $siteVisit = $this->SiteVisits->patchEntity($siteVisit, $this->request->getData());
            $siteVisit->client_id = $client_id;
            $siteVisit->contractor_id = $contractor_id;
            $siteVisit->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
            if ($this->SiteVisits->save($siteVisit)) {
                $this->Flash->success(__('The site visit has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The site visit could not be saved. Please, try again.'));
        }
        $sites = "";
        if($client_id){
         $sites = $this->SiteVisits->Sites->find('list')->where(['client_id'=>$client_id]);
        $this->set(compact('sites','clients','siteVisit','client'));
        }
         $site_visit = $this->Clients->find('list',['valueField'=>'site_visited'])->where(['id '=>$client_id])->enableHydration(false)->toArray();  

        $this->set(compact('siteVisit', 'sites','clients','site_visit'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Site Visit id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->loadModel('Clients');
        $siteVisit = $this->SiteVisits->get($id, [
            'contain' => []
        ]);

        $clients = $this->Clients->find('list',['keyField'=>'id','valueField'=>'company_name'])->order(['id'])->toArray();
        $contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
        if ($this->request->is(['patch', 'post', 'put'])) {
            $siteVisit = $this->SiteVisits->patchEntity($siteVisit, $this->request->getData());
            if ($this->SiteVisits->save($siteVisit)) {
                $this->Flash->success(__('The site visit has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The site visit could not be saved. Please, try again.'));
        }
        $contractors = $this->SiteVisits->Contractors->find('list', ['limit' => 200]);
        $sites = $this->SiteVisits->Sites->find('list', ['limit' => 200]);
        $this->set(compact('siteVisit', 'contractors', 'sites','clients'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Site Visit id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $siteVisit = $this->SiteVisits->get($id);
        if ($this->SiteVisits->delete($siteVisit)) {
            $this->Flash->success(__('The site visit has been deleted.'));
        } else {
            $this->Flash->error(__('The site visit could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function sitevisit($client_id=null){
        $this->loadModel('Clients');
        $this->loadModel('Contractors');
        $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
        $contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
        $site_visit = $this->Clients->find()->select('site_visited')->where(['id'=>$client_id])->enableHydration(false)->first();      
     
        $where =['SiteVisits.client_id'=>$client_id];
    
        $this->paginate = [
            'contain' => ['Contractors', 'Sites','Clients'],
             'conditions' => $where,
        ];
        $siteVisits = $this->paginate($this->SiteVisits);   
    
        $this->set(compact('siteVisits','contractor_id','site_visit'));
    }
}
