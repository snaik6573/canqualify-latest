<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ContractorTempclients Controller
 *
 * @property \App\Model\Table\ContractorTempclientsTable $ContractorTempclients
 *
 * @method \App\Model\Entity\ContractorTempclient[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ContractorTempclientsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Contractors', 'Sites', 'Clients']
        ];
        $contractorTempclients = $this->paginate($this->ContractorTempclients);

        $this->set(compact('contractorTempclients'));
    }

    /**
     * View method
     *
     * @param string|null $id Contractor Tempclient id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $contractorTempclient = $this->ContractorTempclients->get($id, [
            'contain' => ['Contractors', 'Sites', 'Clients']
        ]);

        $this->set('contractorTempclient', $contractorTempclient);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $contractorTempclient = $this->ContractorTempclients->newEntity();
        if ($this->request->is('post')) {
            $contractorTempclient = $this->ContractorTempclients->patchEntity($contractorTempclient, $this->request->getData());
            if ($this->ContractorTempclients->save($contractorTempclient)) {
                $this->Flash->success(__('The contractor tempclient has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The contractor tempclient could not be saved. Please, try again.'));
        }
        $contractors = $this->ContractorTempclients->Contractors->find('list', ['limit' => 200]);
        $sites = $this->ContractorTempclients->Sites->find('list', ['limit' => 200]);
        $clients = $this->ContractorTempclients->Clients->find('list', ['limit' => 200]);
        $this->set(compact('contractorTempclient', 'contractors', 'sites', 'clients'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Contractor Tempclient id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $contractorTempclient = $this->ContractorTempclients->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contractorTempclient = $this->ContractorTempclients->patchEntity($contractorTempclient, $this->request->getData());
            if ($this->ContractorTempclients->save($contractorTempclient)) {
                $this->Flash->success(__('The contractor tempclient has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The contractor tempclient could not be saved. Please, try again.'));
        }
        $contractors = $this->ContractorTempclients->Contractors->find('list', ['limit' => 200]);
        $sites = $this->ContractorTempclients->Sites->find('list', ['limit' => 200]);
        $clients = $this->ContractorTempclients->Clients->find('list', ['limit' => 200]);
        $this->set(compact('contractorTempclient', 'contractors', 'sites', 'clients'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Contractor Tempclient id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $contractorTempclient = $this->ContractorTempclients->get($id);
        if ($this->ContractorTempclients->delete($contractorTempclient)) {
            $this->Flash->success(__('The contractor tempclient has been deleted.'));
        } else {
            $this->Flash->error(__('The contractor tempclient could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
