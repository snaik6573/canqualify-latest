<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
/**
 * ContractorContacts Controller
 *
 * @property \App\Model\Table\ContractorContactsTable $ContractorContacts
 *
 * @method \App\Model\Entity\ContractorContact[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ContractorContactsController extends AppController
{
    public function isAuthorized($user)
    {
	$contractorNav = false;
	if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN) {
		$contractorNav = true;
	}
	$this->set('contractorNav', $contractorNav);

	if (isset($user['role_id']) && $user['active'] == 1) {
		if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN || $user['role_id'] == CONTRACTOR || $user['role_id'] == CONTRACTOR_ADMIN) {
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
		$contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
		$totalCount = $this->ContractorContacts->find('all')->count();								
        $this->paginate = [
        'contain' => ['Contractors'],
	    'conditions' => ['contractor_id'=>$contractor_id],
		'limit'=>$totalCount,
        'maxLimit'=>$totalCount
        ];
        $contractorContacts = $this->paginate($this->ContractorContacts);

        $this->set(compact('contractorContacts'));
    }

    /**
     * View method
     *
     * @param string|null $id Contractor Contact id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $contractorContact = $this->ContractorContacts->get($id, [
            'contain' => ['Contractors']
        ]);

        $this->set('contractorContact', $contractorContact);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');

        $contractorContact = $this->ContractorContacts->newEntity();
        if ($this->request->is('post')) {
            $contractorContact = $this->ContractorContacts->patchEntity($contractorContact, $this->request->getData());
            $contractorContact->contractor_id = $contractor_id;
            $contractorContact->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
            if ($this->ContractorContacts->save($contractorContact)) {
                $this->Flash->success(__('The contractor contact has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The contractor contact could not be saved. Please, try again.'));
        }
        $contractors = $this->ContractorContacts->Contractors->find('list', ['limit' => 200]);
        $this->set(compact('contractorContact', 'contractors'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Contractor Contact id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');

        $contractorContact = $this->ContractorContacts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contractorContact = $this->ContractorContacts->patchEntity($contractorContact, $this->request->getData());
            $contractorContact->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');
            if ($this->ContractorContacts->save($contractorContact)) {
                $this->Flash->success(__('The contractor contact has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The contractor contact could not be saved. Please, try again.'));
        }
        $contractors = $this->ContractorContacts->Contractors->find('list', ['limit' => 200]);
        $this->set(compact('contractorContact', 'contractors'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Contractor Contact id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $contractorContact = $this->ContractorContacts->get($id);
        if ($this->ContractorContacts->delete($contractorContact)) {
            $this->Flash->success(__('The contractor contact has been deleted.'));
        } else {
            $this->Flash->error(__('The contractor contact could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
