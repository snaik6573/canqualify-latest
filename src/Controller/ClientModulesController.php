<?php
namespace App\Controller;
use App\Controller\AppController;

/**
 * ClientModules Controller
 *
 * @property \App\Model\Table\ClientModulesTable $ClientModules
 *
 * @method \App\Model\Entity\ClientModule[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ClientModulesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Clients', 'Modules']
        ];
        $clientModules = $this->paginate($this->ClientModules);

        $this->set(compact('clientModules'));
    }

    /**
     * View method
     *
     * @param string|null $id Client Module id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $clientModule = $this->ClientModules->get($id, [
            'contain' => ['Clients', 'Modules']
        ]);

        $this->set('clientModule', $clientModule);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $clientModule = $this->ClientModules->newEntity();
        if ($this->request->is('post')) {
            $clientModule = $this->ClientModules->patchEntity($clientModule, $this->request->getData());
			$clientModule->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
            if ($this->ClientModules->save($clientModule)) {
                $this->Flash->success(__('The client module has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The client module could not be saved. Please, try again.'));
        }
        $clients = $this->ClientModules->Clients->find('list', ['limit' => 200]);
        $modules = $this->ClientModules->Modules->find('list', ['limit' => 200]);
        $this->set(compact('clientModule', 'clients', 'modules'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Client Module id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $clientModule = $this->ClientModules->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $clientModule = $this->ClientModules->patchEntity($clientModule, $this->request->getData());
			$clientModule->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');
            if ($this->ClientModules->save($clientModule)) {
                $this->Flash->success(__('The client module has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The client module could not be saved. Please, try again.'));
        }
        $clients = $this->ClientModules->Clients->find('list', ['limit' => 200]);
        $modules = $this->ClientModules->Modules->find('list', ['limit' => 200]);
        $this->set(compact('clientModule', 'clients', 'modules'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Client Module id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $clientModule = $this->ClientModules->get($id);
        if ($this->ClientModules->delete($clientModule)) {
            $this->Flash->success(__('The client module has been deleted.'));
        } else {
            $this->Flash->error(__('The client module could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
