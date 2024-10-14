<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
/**
 * Notes Controller
 *
 * @property \App\Model\Table\NotesTable $Notes
 *
 * @method \App\Model\Entity\Note[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class NotesController extends AppController
{
    public function isAuthorized($user)
    {
  $contractorNav = false;
  if($user['role_id'] == SUPER_ADMIN  || $user['role_id'] == ADMIN || $user['role_id'] == CLIENT || $user['role_id'] == CR || $user['role_id'] == CLIENT_ADMIN || $user['role_id'] == CLIENT_VIEW || $user['role_id'] == CLIENT_BASIC) {
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
    public function index($follow_up=0,$is_completed=false)
    {
  $CR_id = $this->getRequest()->getSession()->read('Auth.User.CR_id');
  $user_id = $this->getRequest()->getSession()->read('Auth.User.user_id');

  $totalCount = $this->Notes->find()->count();

  $conditions['Notes.is_completed'] = $is_completed;
  if($follow_up!=0) { // current CR notes
    $conditions['Notes.created_by'] = $user_id;
    $conditions['follow_up'] = true;
  }

  if ($this->request->is(['patch', 'post', 'put'])) {
        $from_date = $this->request->getData('from_date');
        $to_date = $this->request->getData('to_date');
    if($this->request->getData('follow_up_range')==1) { // Notes
      $conditions['follow_up'] = false;
            if(null !=$from_date && null !=$to_date ) {
                $conditions['DATE(Notes.created) >='] = $from_date;
                $conditions['DATE(Notes.created) <='] = $to_date;
            }  
    }
    elseif($this->request->getData('follow_up_range')==2) { // Follow Up
      $conditions['follow_up'] = true;
      if(null !=$from_date && null !=$to_date ) {
        $conditions['DATE(feature_date) >='] = $from_date;
        $conditions['DATE(feature_date) <='] = $to_date;
      }
    }
        else{
      unset($conditions['follow_up']);
      if(null !=$from_date && null !=$to_date ) {
            $conditions['OR'] = [
           ['DATE(Notes.created) >='=>$from_date, 'DATE(Notes.created) <=' => $to_date],
           ['DATE(Notes.feature_date) >='=>$from_date, 'DATE(Notes.feature_date) <=' => $to_date]
      ];
            }
        }
  }

  $this->paginate = [
    'contain' => ['Contractors', 'Users', 'Users.CustomerRepresentative', 'Users.ClientUsers.Clients'=>['conditions'=>['Users.role_id'=>CLIENT]],],
    'conditions' => $conditions,
    'limit'   => $totalCount,
    'maxLimit'=> $totalCount,
        'order' => [
            'Notes.created' => 'asc'
        ]
  ];

  $notes = $this->paginate($this->Notes);
  $this->set(compact('notes'));
    }

   /* public function notes()
    {
  $conditions = [];

  $contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
  if($contractor_id!=null) {
    $conditions['contractor_id'] = $contractor_id;
  }
  if($this->User->isClient()) {
    $conditions['show_to_client'] = 1;
  }

  $totalCount = $this->Notes->find('all')->count();   
  $this->paginate = [
      'contain' => ['Contractors', 'Users.Clients', 'Users.Roles'],
      'conditions' => $conditions,
      'order' => ['date ' => 'DESC'],
      'limit'   => $totalCount,
      'maxLimit'=> $totalCount
    ];
  $notes = $this->paginate($this->Notes);
  $this->set(compact('notes')); 
    }*/

    public function contractorNotes($is_completed=false)
    {      
        $this->loadModel('OverallIcons');
        $this->loadModel('Users');
      $totalCount = $this->Notes->find()->count();
      $contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');

      $conditions['contractor_id']= $contractor_id;
        $conditions['is_completed'] = $is_completed;

        if($this->User->isContractor()) {
        $conditions['show_to_contractor'] = 1;
      }
        if($this->User->isClient()) {
        $conditions['show_to_client'] = 1;
      }
      $this->paginate = [
          'contain' => ['Contractors', 'Users.ClientUsers.Clients'=>['conditions'=>['Users.role_id'=>CLIENT]], 'Users.Roles', 'Users.CustomerRepresentative'],
          'conditions' => $conditions,
          'limit'   => $totalCount,
            'maxLimit'=> $totalCount
      ];
        $notes = $this->paginate($this->Notes);
         //pr($notes);die;
        $OI_conditions['OverallIcons.contractor_id']= $contractor_id;
        if($this->User->isContractor()) {
        $OI_conditions['OverallIcons.show_to_contractor'] = 1;
      }
        if($this->User->isClient()) {
        $OI_conditions['OverallIcons.show_to_clients'] = 1;
        }
        $overallicon_notes = $this->OverallIcons
        ->find('all')
    ->contain(['Contractors'])
    ->contain(['Users'])
    ->contain(['Clients'])
        ->where($OI_conditions)
        ->toArray();
        $users= array();
        $userData = $this->Users->find()->contain(['Roles','CanQualifyUsers','ClientUsers'=>['conditions'=>['role_id'=>CLIENT]],'ClientUsers.Clients'])->toArray();
        //pr($userData);die;
        foreach ($userData as $key => $u) {
            if($u->role_id == $u->role['id']){
                $role_name = $u->role['role_title'];
            }
            $users[$u->id] = $u->id;
            if($u->client_user!=null && $u->client_user['user_id'] == $u->id){
              $users[$u->id] = $u->client_user['pri_contact_fn']." ".$u->client_user['pri_contact_ln']." (".$u->client_user['client']['company_name'].")";
            }else{
                $users[$u->id] = (empty($u->first_name)?"":$u->first_name)." ".(empty($u->last_name)?"":$u->last_name)." (".(empty($u->client_user['client']['company_name'])?"":$u->client_user['client']['company_name']).")";
            }
            foreach ($u['canqualify_users'] as $key2 => $v) {
                if($v->user_id == $u->id){
                $users[$u->id] = $v->first_name." ".$v->last_name." (CanQualify)" ;
                //$users[$u->id] = $v->first_name." ".$v->last_name." (".$role_name.")" ;
                }
            }
        }
       //pr($users);die;
        $this->set(compact('notes','overallicon_notes','users'));
    }

    /**
     * View method
     *
     * @param string|null $id Note id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $note = $this->Notes->get($id, [
            'contain' => ['Contractors','Users.ClientUsers.Clients'=>['conditions'=>['Users.role_id'=>CLIENT]], 'Users.Roles']
        ]);
  $this->set(compact('note'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
  $this->loadModel('Clients');

  $user_id = $this->getRequest()->getSession()->read('Auth.User.id');
  $role_id = $this->getRequest()->getSession()->read('Auth.User.role_id');

  $contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
        $note = $this->Notes->newEntity();
        if ($this->request->is('post')) {
            $note = $this->Notes->patchEntity($note, $this->request->getData());
            if($this->User->isClient()){
            $note->show_to_client = 1;
            } 
            $note->contractor_id = $contractor_id;
            $note->created_by = $user_id;
            $note->role_id = $role_id;

            if ($this->Notes->save($note)) {
                $this->Flash->success(__('The note has been saved.'));

                return $this->redirect($this->request->getData('refererUrl'));
            }
            $this->Flash->error(__('The note could not be saved. Please, try again.'));
        }
        else {
             $refererUrl = $this->referer();
             $this->set(compact('refererUrl'));
        }
        $contractors = $this->Notes->Contractors->find('list', ['limit' => 200]);
        $this->set(compact('note', 'contractors'));
    }

    public function addCrNote($contractor_id=null)
    {
  //$this->viewBuilder()->setLayout('ajax');
  $CR_id = $this->getRequest()->getSession()->read('Auth.User.CR_id');
  $user_id = $this->getRequest()->getSession()->read('Auth.User.id');
  $role_id = $this->getRequest()->getSession()->read('Auth.User.role_id');

  $contractor = $this->Notes->Contractors->get($contractor_id, ['contain'=>['Users']]);

        $note = $this->Notes->newEntity();
        if ($this->request->is('post')) {
            $note = $this->Notes->patchEntity($note, $this->request->getData());
            $note->contractor_id=$contractor_id;
            $note->created_by=$user_id;
            $note->role_id = $role_id;

            if ($this->Notes->save($note)) {
                $this->Flash->success(__('The note has been saved.'));
               //return $this->redirect(['controller'=> 'CustomerRepresentative', 'action' => 'contractor-list']);
            }
            else {
                $this->Flash->error(__('The note could not be saved. Please, try again.'));
            }
        }

        $this->paginate = [
            'conditions' => ['contractor_id'=>$contractor_id]
        ];
        $notes = $this->paginate($this->Notes);

        $this->set(compact('notes', 'note', 'contractor'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Note id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {        
        $note = $this->Notes->get($id, [
            'contain' => []
       ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $note = $this->Notes->patchEntity($note, $this->request->getData());
            $note->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');
            if ($this->Notes->save($note)) {
                $this->Flash->success(__('The note has been saved.'));
                return $this->redirect($this->request->getData('refererUrl'));
            }
            $this->Flash->error(__('The note could not be saved. Please, try again.'));
        }
        else {
             $refererUrl = $this->referer();
             $this->set(compact('refererUrl'));
        }
        $contractors = $this->Notes->Contractors->find('list', ['limit' => 200]);
        $this->set(compact('note', 'contractors'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Note id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $note = $this->Notes->get($id);
        if ($this->Notes->delete($note)) {
            $this->Flash->success(__('The note has been deleted.'));
        } else {
            $this->Flash->error(__('The note could not be deleted. Please, try again.'));
        }

        $this->redirect($this->referer());
    }

    public function clientNotes($client_id = null){
        if ($client_id == null) {
            $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
        }
        $this->loadModel('ClientNotes');
        $this->loadModel('ContractorClients');

        /*My Contractors*/
        $myContractors = array();
        $myContractors = $this->User->getContractors($client_id);

        $notes = $this->ClientNotes->find()
            ->where(['ClientNotes.contractor_id in' => $myContractors])
            ->order(['ClientNotes.created'=>'DESC'])
            ->all()->toArray();
        $this->set('notes', $notes);
}
}
