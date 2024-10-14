<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
/**
 * ContractorUsers Controller
 *
 * @property \App\Model\Table\ContractorUsersTable $ContractorUsers
 *
 * @method \App\Model\Entity\ContractorUser[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ContractorUsersController extends AppController
{
    public function isAuthorized($user)
    {
	$contractorNav = false;
	if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN || $user['role_id'] == CONTRACTOR || $user['role_id'] == CONTRACTOR_ADMIN) {
		$contractorNav = true;		
	}
	$this->set('contractorNav', $contractorNav);
    if($this->request->getParam('action')=='contractorContacts') {
		if($user['role_id'] == CLIENT || $user['role_id'] == CLIENT_ADMIN || $user['role_id'] == CLIENT_VIEW || $user['role_id'] == CLIENT_BASIC)  {
			return true; 
		}
	}
    //if (isset($user['role_id']) && $user['active'] == 1) {
	if (isset($user['role_id'])) {
        if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN || $user['role_id'] == CLIENT || $user['role_id'] == CR  || $user['role_id'] == CONTRACTOR || $user['role_id'] == CONTRACTOR_ADMIN) 
		{
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
    public function index($service_id=null)
    {
        $this->loadModel('Contractors');
	    $contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');

         $contractor = $this->Contractors->get($contractor_id, [
            'contain' => ['Users']
        ]);

        $this->paginate = [
            'contain' => ['Users', 'Contractors'],
	    'conditions' => ['contractor_id'=>$contractor_id]
        ];
        $contractorUsers = $this->paginate($this->ContractorUsers);

        $this->set(compact('contractorUsers','contractor','service_id'));
    }

    /**
     * View method
     *
     * @param string|null $id Contractor User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null,$service_id=null, $cat_id=null)
    {
		if(!empty($service_id && $cat_id)){
		$this->viewBuilder()->setLayout('ajax');		
		}
		
        $contractorUser = $this->ContractorUsers->get($id, [
            'contain' => ['Users', 'Contractors']
        ]);
		$this->set(compact('contractorUser','service_id','cat_id'));
        //$this->set('contractorUser', $contractorUser);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($service_id=null, $cat_id=null, $id=null)
    {		
        $this->loadModel('Contractors');
		$contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
		/*
		//$url = $this->request->getPath(); 
		if($service_id==null && $cat_id==null){
			$service_id = 0;
			$cat_id = 0;}*/
        if($id!=null) {
        $contractorUser = $this->ContractorUsers->get($id, [
            'contain' => ['Users']
        ]);
        }
        else {
            $contractorUser = $this->ContractorUsers->newEntity();
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contractorUser = $this->ContractorUsers->patchEntity($contractorUser, $this->request->getData());
			$contractorUser->created_by = $this->getRequest()->getSession()->read('Auth.User.id');		
			$contractorUser->contractor_id =$contractor_id;

		   if ($this->ContractorUsers->save($contractorUser)) {
                $this->Flash->success(__('The contractor user has been saved.'));
                /*if($service_id!=null) {
                    return $this->redirect(['controller' => 'ContractorAnswers', 'action' => 'add-answers', $service_id, $cat_id]);
                }*/
				if(!empty($service_id && $cat_id)){		
					return $this->redirect(['action' => 'add', $service_id, $cat_id]);
				}else{
					return $this->redirect(['action' => 'index']);	
				}
               // return $this->redirect($url);
            }
            else {
                $this->Flash->error(__('The contractor user could not be saved. Please, try again.'));
            }
        }

        $contractor = $this->Contractors->get($contractor_id, [
            'contain' => ['Users']
        ]);
        $this->paginate = [
            'contain' => ['Users', 'Contractors'],
    	    'conditions' => ['contractor_id'=>$contractor_id]
        ];
        $contractorUsers = $this->paginate($this->ContractorUsers);

        $this->set(compact('contractorUser', 'contractorUsers','contractor','service_id','cat_id'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Contractor User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null,$service_id=null, $cat_id=null)
    {
		if(!empty($service_id && $cat_id)){
		$this->viewBuilder()->setLayout('ajax');		
		}
        $contractorUser = $this->ContractorUsers->get($id, [
            'contain' => ['Users']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contractorUser = $this->ContractorUsers->patchEntity($contractorUser, $this->request->getData());
			$contractorUser->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');
            if ($this->ContractorUsers->save($contractorUser)) {
                $this->Flash->success(__('The contractor user has been saved.'));
				if(!empty($service_id && $cat_id)){		
					return $this->redirect(['action' => 'add', $service_id, $cat_id]);
				}else{
					return $this->redirect(['action' => 'index']);	
				}
            }
            $this->Flash->error(__('The contractor user could not be saved. Please, try again.'));
        }        
        $this->set(compact('contractorUser','service_id','cat_id'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Contractor User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null, $service_id=null, $cat_id=null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $contractorUser = $this->ContractorUsers->get($id);
        if ($this->ContractorUsers->delete($contractorUser)) {
            $this->Flash->success(__('The contractor user has been deleted.'));
        } else {
            $this->Flash->error(__('The contractor user could not be deleted. Please, try again.'));
        }
        if($service_id!=null) {
            return $this->redirect(['action' => 'add', $service_id, $cat_id]);
        }
        else {
            return $this->redirect(['action' => 'index']);
        }
    }
	public function myProfile()
    {
		$id = $this->getRequest()->getSession()->read('Auth.User.coadmin_id');		
        $contractorUsers = $this->ContractorUsers->get($id, [
            'contain' => ['Users']
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $contractorUsers = $this->ContractorUsers->patchEntity($contractorUsers, $this->request->getData());
            $contractorUsers->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');
            if ($this->ContractorUsers->save($contractorUsers)) {
				
				if(null !== $this->request->getData('user.profile_photo')){
					$this->getRequest()->getSession()->write('Auth.User.profile_photo', $contractorUsers->user->profile_photo);				
				}
				$this->set('activeUser', $this->getRequest()->getSession()->read('Auth.User'));
			
                $this->Flash->success(__('The profile has been saved.'));
                return $this->redirect(['action'=>'my-profile']);
            }
            $this->Flash->error(__('The profile could not be saved. Please, try again.'));
        }
        $this->set(compact('contractorUsers'));
    } 
    
}
