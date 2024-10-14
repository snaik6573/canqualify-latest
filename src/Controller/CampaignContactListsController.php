<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;

/**
 * CampaignContactLists Controller
 *
 * @property \App\Model\Table\CampaignContactListsTable $CampaignContactLists
 *
 * @method \App\Model\Entity\CampaignContactList[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CampaignContactListsController extends AppController
{
    
    public function isAuthorized($user)
    {
      $contractorNav = false;
      if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN || $user['role_id'] == CLIENT || $user['role_id'] == CONTRACTOR_ADMIN || $user['role_id'] == CR) {
        $contractorNav = true;
      }
      $this->set('contractorNav', $contractorNav);
      $clientCenterNav = false;
        if(isset($user['client_id']) && ($user['role_id'] == SUPER_ADMIN  || $user['role_id'] == ADMIN )){
            $clientCenterNav = true;
           $this->set('clientCenterNav', $clientCenterNav);
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
    public function index()
    {
        $loggedUser = $this->getRequest()->getSession()->read('Auth.User.id');
        $activeUser = $this->getRequest()->getSession()->read('Auth.User');
        if($this->User->isClient()){
            if($activeUser['role_id']== CLIENT || $activeUser['role_id'] == CLIENT_ADMIN) {
                $CampaignContactLists = $this->CampaignContactLists->find()->where(['created_by'=>$loggedUser]);
            }
            if($activeUser['role_id'] == CLIENT_VIEW || $activeUser['role_id'] == CLIENT_BASIC) {
                $CampaignContactLists = $this->CampaignContactLists->find()->where(['created_by'=>$loggedUser]);
            }
        }elseif($this->User->isCR()){
                $CampaignContactLists = $this->CampaignContactLists->find()->where(['created_by'=>$loggedUser]);
        }
        else{
            $CampaignContactLists = $this->CampaignContactLists->find();
        }
        $campaignContactLists = $this->paginate($CampaignContactLists);

        $this->set(compact('campaignContactLists'));
    }

    /**
     * View method
     *
     * @param string|null $id Campaign Contact List id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $campaignContactList = $this->CampaignContactLists->get($id, [
            'contain' => []
        ]);

        $this->set('campaignContactList', $campaignContactList);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $campaignContactList = $this->CampaignContactLists->newEntity();
        if ($this->request->is('post')) {
       
            $campaignContactList = $this->CampaignContactLists->patchEntity($campaignContactList, $this->request->getData());
            $campaignContactList->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
            $campaignContactList->suppliers_ids = ['supplier_ids' => array_values(array_unique($this->request->getData('suppliers_ids')))];
            if ($this->CampaignContactLists->save($campaignContactList)) {
                $this->Flash->success(__('The campaign contact list has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The campaign contact list could not be saved. Please, try again.'));
        }
        $this->set(compact('campaignContactList'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Campaign Contact List id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->loadModel('Contractors');
        $campaignContactList = $this->CampaignContactLists->get($id, [
            'contain' => []
        ]);
       
        $name = $campaignContactList['name'];
        $camp_id = $campaignContactList['id'];
        $campList = array();
        $campList = $campaignContactList['suppliers_ids']['supplier_ids'];
        
        $andConditions = "contractors.id IN (".implode(',',$campList).")";
        
        // pr($andConditions);
        $conn = ConnectionManager::get('default');
         
        $contList = $conn->execute("SELECT contractors.*, states.name as state_name, users.username, users.active as active  FROM contractors 
            LEFT JOIN users ON users.id = (contractors.user_id) 
            LEFT JOIN states ON states.id = (contractors.state_id) 
            WHERE ".$andConditions)->fetchAll('assoc');    
        // pr($contList);
        $todaydate = date('m/d/Y');  // Today's date 
        $nextdate  = date('m/d/Y', strtotime("+15 days"));  // upcomming 15 day's
        $nextDate = (string) $nextdate;
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            // pr($this->request->getData('suppliers_ids')); die();
            $campaignContactList = $this->CampaignContactLists->patchEntity($campaignContactList, $this->request->getData());
            $campaignContactList->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');
            $campaignContactList->suppliers_ids = ['supplier_ids' => array_values(array_unique($this->request->getData('suppliers_ids')))];
            // pr($campaignContactList); die();
            if ($this->CampaignContactLists->save($campaignContactList)) {
                $this->Flash->success(__('The campaign contact list has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The campaign contact list could not be saved. Please, try again.'));
        }
        $this->set(compact('campaignContactList','contList','todaydate','name','camp_id'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Campaign Contact List id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $campaignContactList = $this->CampaignContactLists->get($id);
        if ($this->CampaignContactLists->delete($campaignContactList)) {
            $this->Flash->success(__('The campaign contact list has been deleted.'));
        } else {
            $this->Flash->error(__('The campaign contact list could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
