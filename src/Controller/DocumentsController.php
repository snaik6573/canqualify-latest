<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
/**
 * Documents Controller
 *
 * @property \App\Model\Table\DocumentsTable $Documents
 *
 * @method \App\Model\Entity\Document[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DocumentsController extends AppController
{
    public function isAuthorized($user)
    {
	// Admin can access every action
	if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN || $user['role_id'] == CLIENT || $user['role_id'] == CLIENT_ADMIN || $user['role_id'] == CLIENT_VIEW || $user['role_id'] == CONTRACTOR) {
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
        $this->paginate = [
            'contain' => ['Clients', 'Contractors']
        ];
        $documents = $this->paginate($this->Documents);

        $this->set(compact('documents'));
    }

    /**
     * View method
     *
     * @param string|null $id Document id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $document = $this->Documents->get($id, [
            'contain' => ['Clients', 'Contractors', 'DocumentVersions']
        ]);

        $this->set('document', $document);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($document_id=null, $client_id=null)
    {
	$this->viewBuilder()->setLayout('ajax');
	if($client_id==null) {
		$client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');		
	}
	$contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');		
	$user_id = $this->getRequest()->getSession()->read('Auth.User.id');

	if($document_id!=null) {
		$getParentDoc = $this->Documents->find('all')->where(['id'=>$document_id])->first();
	        $this->set(compact('getParentDoc'));

		$document_count = $this->Documents
		->find('all')
		->where(['OR'=>['AND'=>
				['id'=>$document_id],
				['document_id'=>$document_id, 'contractor_id'=>$contractor_id]
				]
			])
		->count();
	}
	else {
		$document_count = 0;
	}	
	$document = $this->Documents->newEntity();
        if ($this->request->is('post')) {
		$document = $this->Documents->patchEntity($document, $this->request->getData());
		$document->client_id = $client_id;
		$document->contractor_id = $contractor_id;						
		$document->doc_version = $document_count+1;
		$document->created_by =$user_id ;
		$document->document_id = $document_id;

		if ($this->Documents->save($document)) {
			$this->Flash->success(__('The document has been saved.'));
			return $this->redirect(['controller'=>'Contractors', 'action' => 'dashboard', $contractor_id]);
		}
		$this->Flash->error(__('The document could not be saved. Please, try again.'));
        }

        //$clients = $this->Documents->Clients->find('list', ['limit' => 200]);
        //$contractors = $this->Documents->Contractors->find('list', ['limit' => 200]);
        $this->set(compact('document', 'document_id'));
    }
	
	 public function approve($document_id=null, $client_id=null)
    {
	$this->viewBuilder()->setLayout('ajax');
	if($client_id==null) {
		$client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');		
	}
	$getStatus = $this->Documents->find('all')->where(['document_id'=>$document_id])->last();	
	
	$contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');		
	$user_id = $this->getRequest()->getSession()->read('Auth.User.id');
	
	$document = $this->Documents->newEntity();
        if ($this->request->is('post')) {
		$status = $getStatus['status'] + 1;
		$document = $this->Documents->patchEntity($document, $this->request->getData());
		$document->client_id = $client_id;
		$document->contractor_id = $contractor_id;								
		$document->created_by =$user_id ;		
		$document->document_id =$document_id ;		
		$document->status = $status;

		if ($this->Documents->save($document)) {
			$this->Flash->success(__('The document has been saved.'));
			return $this->redirect(['controller'=>'Contractors', 'action' => 'dashboard', $contractor_id]);
		}
		$this->Flash->error(__('The document could not be saved. Please, try again.'));
        }

        //$clients = $this->Documents->Clients->find('list', ['limit' => 200]);
        //$contractors = $this->Documents->Contractors->find('list', ['limit' => 200]);
        $this->set(compact('document', 'document_id'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Document id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
	$this->viewBuilder()->setLayout('ajax');

	/*if($this->User->isClient()) {
		$client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
	}*/
	$contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
	$user_id = $this->getRequest()->getSession()->read('Auth.User.id');

        $document = $this->Documents->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $status = $document->status + 1;
            $document = $this->Documents->patchEntity($document, $this->request->getData());
            $document->status = $status;
            $document->modified_by = $user_id;

            if ($this->Documents->save($document)) {
                $this->Flash->success(__('The document has been saved.'));

		return $this->redirect(['controller'=>'Contractors', 'action' => 'dashboard', $contractor_id]);
            }
            $this->Flash->error(__('The document could not be saved. Please, try again.'));
        }
        $clients = $this->Documents->Clients->find('list', ['limit' => 200]);
        $contractors = $this->Documents->Contractors->find('list', ['limit' => 200]);
        $this->set(compact('document', 'clients', 'contractors'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Document id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $document = $this->Documents->get($id);
        if ($this->Documents->delete($document)) {
            $this->Flash->success(__('The document has been deleted.'));
        } else {
            $this->Flash->error(__('The document could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
