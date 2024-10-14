<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ClientRequestsLeads Controller
 *
 * @property \App\Model\Table\ClientRequestsLeadsTable $ClientRequestsLeads
 *
 * @method \App\Model\Entity\ClientRequestsLead[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ClientRequestsLeadsController extends AppController
{
     public function isAuthorized($user)
    {
	if($this->request->getParam('action')=='view') {
        if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN || $user['role_id'] == CLIENT || $user['role_id'] == CLIENT_ADMIN || $user['role_id'] == CLIENT_VIEW || $user['role_id'] == CLIENT_BASIC) {
            $clientNav = true;
            $this->set('clientNav', $clientNav);
        }
    }
    else {
        $contractorNav = false;
        if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN || $user['role_id'] == CR) {
            $contractorNav = true;
        }
        $this->set('contractorNav', $contractorNav);
    }	

	if (isset($user['role_id']) && $user['active'] == 1) {
		if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN || $user['role_id'] == CONTRACTOR) {
			return true;
		}
	}
	// Default deny
	return false;
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Clients', 'Leads']
        ];
        $clientRequestsLeads = $this->paginate($this->ClientRequestsLeads);

        $this->set(compact('clientRequestsLeads'));
    }

    /**
     * View method
     *
     * @param string|null $id Client Requests Lead id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $clientRequestsLead = $this->ClientRequestsLeads->get($id, [
            'contain' => ['Clients', 'Leads']
        ]);

        $this->set('clientRequestsLead', $clientRequestsLead);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $clientRequestsLead = $this->ClientRequestsLeads->newEntity();
        if ($this->request->is('post')) {
            $clientRequestsLead = $this->ClientRequestsLeads->patchEntity($clientRequestsLead, $this->request->getData());
            if ($this->ClientRequestsLeads->save($clientRequestsLead)) {
                $this->Flash->success(__('The client requests lead has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The client requests lead could not be saved. Please, try again.'));
        }
        $clients = $this->ClientRequestsLeads->Clients->find('list', ['limit' => 200]);
        $leads = $this->ClientRequestsLeads->Leads->find('list', ['limit' => 200]);
        $this->set(compact('clientRequestsLead', 'clients', 'leads'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Client Requests Lead id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $clientRequestsLead = $this->ClientRequestsLeads->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $clientRequestsLead = $this->ClientRequestsLeads->patchEntity($clientRequestsLead, $this->request->getData());
            if ($this->ClientRequestsLeads->save($clientRequestsLead)) {
                $this->Flash->success(__('The client requests lead has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The client requests lead could not be saved. Please, try again.'));
        }
        $clients = $this->ClientRequestsLeads->Clients->find('list', ['limit' => 200]);
        $leads = $this->ClientRequestsLeads->Leads->find('list', ['limit' => 200]);
        $this->set(compact('clientRequestsLead', 'clients', 'leads'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Client Requests Lead id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $clientRequestsLead = $this->ClientRequestsLeads->get($id);
        if ($this->ClientRequestsLeads->delete($clientRequestsLead)) {
            $this->Flash->success(__('The client requests lead has been deleted.'));
        } else {
            $this->Flash->error(__('The client requests lead could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
