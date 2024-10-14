<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Mailer\MailerAwareTrait;       //  Built in function use for sending multiple email
/**
 * CustomerrNotes Controller
 *
 * @property \App\Model\Table\CustomerrNotesTable $CustomerrNotes
 *
 * @method \App\Model\Entity\CustomerrNote[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CustomerrNotesController extends AppController
{
    public function isAuthorized($user)
    {
	// Admin can access every action
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
    public function index($follow_up=0, $contractor_id=null)
    {	
	$CR_id = $this->getRequest()->getSession()->read('Auth.User.CR_id');	

	$totalCount = $this->CustomerrNotes->find()->count();
	$conditions = [];		
	$this->paginate = [];
	if($follow_up!=0) {
		$conditions['CustomerrNotes.customer_representative_id'] = $CR_id;
		$conditions['follow_up'] = true;
	}
	if($contractor_id!=null)
	{
		$conditions['contractor_id'] = $contractor_id;				
	}
	if ($this->request->is(['patch', 'post', 'put'])) {	
		
		if($this->request->getData('follow_up_range')==1) {
			$conditions['follow_up'] = false;
		}
		elseif($this->request->getData('follow_up_range')==2){
			$conditions['follow_up'] = true;		
			if(null !=$this->request->getData('from_date') && null !=$this->request->getData('to_date') )
			{
				$conditions['feature_date >='] = $this->request->getData('from_date');		
				$conditions['feature_date <='] = $this->request->getData('to_date');					
			}
		}			
		$this->paginate = [
            'contain' => ['Contractors', 'CustomerRepresentative'],
            'conditions' => $conditions
		];
		
	}
	else{	
    $this->paginate = [
            'contain' => ['Contractors', 'CustomerRepresentative'],
            'conditions' => $conditions
    ];
	}
	$customerrNotes = $this->paginate($this->CustomerrNotes);
    $this->set(compact('customerrNotes'));
    }

    /**
     * View method
     *
     * @param string|null $id Customerr Note id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $customerrNote = $this->CustomerrNotes->get($id, [
            'contain' => ['Contractors', 'CustomerRepresentative']
        ]);

        $this->set('customerrNote', $customerrNote);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($contractor_id=null)
    {
		$this->viewBuilder()->setLayout('ajax');
		$cr_id = $this->getRequest()->getSession()->read('Auth.User.CR_id');
		$user_id = $this->getRequest()->getSession()->read('Auth.User.id');
        $customerrNote = $this->CustomerrNotes->newEntity();
        if ($this->request->is('post')) {
            $customerrNote = $this->CustomerrNotes->patchEntity($customerrNote, $this->request->getData());
			$customerrNote->customer_representative_id = $cr_id;
			$customerrNote->contractor_id=$contractor_id;
			$customerrNote->created_by=$user_id;
            if ($this->CustomerrNotes->save($customerrNote)) {
                $this->Flash->success(__('The customerr note has been saved.'));
             
            }			
        }
        $contractors = $this->CustomerrNotes->Contractors->find('list', ['limit' => 200]);
        $customerRepresentative = $this->CustomerrNotes->CustomerRepresentative->find('list', ['limit' => 200]);
        $this->set(compact('customerrNote', 'contractors', 'customerRepresentative'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Customerr Note id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $customerrNote = $this->CustomerrNotes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $customerrNote = $this->CustomerrNotes->patchEntity($customerrNote, $this->request->getData());
			$customerrNote->user->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');
            if ($this->CustomerrNotes->save($customerrNote)) {
                $this->Flash->success(__('The customerr note has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customerr note could not be saved. Please, try again.'));
        }
        $contractors = $this->CustomerrNotes->Contractors->find('list', ['limit' => 200]);
        $customerRepresentative = $this->CustomerrNotes->CustomerRepresentative->find('list', ['limit' => 200]);
        $this->set(compact('customerrNote', 'contractors', 'customerRepresentative'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Customerr Note id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $customerrNote = $this->CustomerrNotes->get($id);
        if ($this->CustomerrNotes->delete($customerrNote)) {
            $this->Flash->success(__('The customerr note has been deleted.'));
        } else {
            $this->Flash->error(__('The customerr note could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
	public function addFollowup($id=null)
	{
		$this->viewBuilder()->setLayout('ajax');
		$cr_id = $this->getRequest()->getSession()->read('Auth.User.CR_id');
		$user_id = $this->getRequest()->getSession()->read('Auth.User.id');
        $customerrNote = $this->CustomerrNotes->newEntity();
		
		if ($this->request->is(['patch', 'post', 'put'])) {					
            $customerrNote = $this->CustomerrNotes->patchEntity($customerrNote, $this->request->getData());
			$customerrNote->customer_representative_id = $cr_id;
			$customerrNote->contractor_id=$id;
			$customerrNote->created_by=$user_id;
            if ($this->CustomerrNotes->save($customerrNote)) {
                $this->Flash->success(__('Contractor Follow Up has been saved.'));
            }            
        }
		$this->set(compact('customerrNote'));
	}

}
