<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Core\Configure;

/**
 * ContractorDocs Controller
 *
 * @property \App\Model\Table\ContractorDocsTable $ContractorDocs
 *
 * @method \App\Model\Entity\ContractorDoc[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ContractorDocsController extends AppController
{
    public function isAuthorized($user)
    {
	if (isset($user['role_id']) && $user['active']== 1) {
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
    /*public function index()
    {
        $this->paginate = [
            'contain' => ['FormsNDocs', 'Clients', 'Contractors']
        ];
        $contractorDocs = $this->paginate($this->ContractorDocs);

        $this->set(compact('contractorDocs'));
    }*/

    /**
     * View method
     *
     * @param string|null $id Contractor Doc id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $contractorDoc = $this->ContractorDocs->get($id, [
            'contain' => ['FormsNDocs', 'Clients', 'Contractors']
        ]);

        $this->set('contractorDoc', $contractorDoc);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($client_id=null, $fndocs_id=null)
    {
	$this->viewBuilder()->setLayout('ajax');

	$contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');

        $contractorDoc = $this->ContractorDocs->newEntity();
        if ($this->request->is(['patch', 'post', 'put'])) {
		$contractorDoc = $this->ContractorDocs->patchEntity($contractorDoc, $this->request->getData());

		$document = $this->request->getData('document');
		if($document!='') {
			$contractorDoc->client_id = $client_id;
			$contractorDoc->fndocs_id = $fndocs_id;
			$contractorDoc->contractor_id = $contractor_id;
			$contractorDoc->created_by = $this->getRequest()->getSession()->read('Auth.User.id');	

		    if ($this->ContractorDocs->save($contractorDoc)) {
		        $this->Flash->success(__('The contractor doc has been saved.'));
		        //return $this->redirect(['Controller' => 'Contractors', 'action' => 'dashboard']);
		    }
		}
		else {
	          	$this->Flash->error(__('The contractor doc could not be saved. Please, try again.'));
		}
        }
        //$formsNDocs = $this->ContractorDocs->FormsNDocs->find('list', ['limit' => 200]);
        //$clients = $this->ContractorDocs->Clients->find('list', ['limit' => 200]);
        //$contractors = $this->ContractorDocs->Contractors->find('list', ['limit' => 200]);

        $this->set(compact('contractorDoc'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Contractor Doc id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function edit($id = null)
    {
        $contractorDoc = $this->ContractorDocs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contractorDoc = $this->ContractorDocs->patchEntity($contractorDoc, $this->request->getData());
            if ($this->ContractorDocs->save($contractorDoc)) {
                $this->Flash->success(__('The contractor doc has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The contractor doc could not be saved. Please, try again.'));
        }
        $formsNDocs = $this->ContractorDocs->FormsNDocs->find('list', ['limit' => 200]);
        $clients = $this->ContractorDocs->Clients->find('list', ['limit' => 200]);
        $contractors = $this->ContractorDocs->Contractors->find('list', ['limit' => 200]);
        $this->set(compact('contractorDoc', 'formsNDocs', 'clients', 'contractors'));
    }*/

    /**
     * Delete method
     *
     * @param string|null $id Contractor Doc id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $contractorDoc = $this->ContractorDocs->get($id);
        if ($this->ContractorDocs->delete($contractorDoc)) {
            $this->Flash->success(__('The contractor doc has been deleted.'));
        } else {
            $this->Flash->error(__('The contractor doc could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
