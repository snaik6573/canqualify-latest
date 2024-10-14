<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CanqualifyUsers Controller
 *
 * @property \App\Model\Table\CanqualifyUsersTable $CanqualifyUsers
 *
 * @method \App\Model\Entity\CanqualifyUser[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CanqualifyUsersController extends AppController
{
    public function isAuthorized($user)
    {
    $clientNav = false;

    if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN) {
        $clientNav = true;
        /*if($this->request->getParam('action')=='dashboard') {
            $this->getRequest()->getSession()->write('Auth.User.client_id', $this->request->getParam('pass.0'));
            $this->set('activeUser', $this->getRequest()->getSession()->read('Auth.User'));
        }*/
    }
    $this->set('clientNav', $clientNav);

    if($this->request->getParam('action')=='index') {
        if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN) {
            return true; 
        }
    }
    elseif($this->request->getParam('action')=='myProfile') {
        if($user['role_id'] != CLIENT) {
            return false; 
        }
    }
    if (isset($user['role_id']) && $user['active'] == 1) {
        if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN || $user['role_id'] == CLIENT || $user['role_id'] == CLIENT_ADMIN || $user['role_id'] == CLIENT_VIEW || $user['role_id'] == CLIENT_BASIC) {
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
        $this->paginate = [
            'contain' => ['Users']
        ];
        $canqualifyUsers = $this->paginate($this->CanqualifyUsers);

        $this->set(compact('canqualifyUsers'));
    }

    /**
     * View method
     *
     * @param string|null $id Canqualify User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $canqualifyUser = $this->CanqualifyUsers->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('canqualifyUser', $canqualifyUser);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $canqualifyUser = $this->CanqualifyUsers->newEntity();
        if ($this->request->is('post')) {
            $canqualifyUser = $this->CanqualifyUsers->patchEntity($canqualifyUser, $this->request->getData());
            if ($this->CanqualifyUsers->save($canqualifyUser)) {
                $this->Flash->success(__('The canqualify user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The canqualify user could not be saved. Please, try again.'));
        }
        $users = $this->CanqualifyUsers->Users->find('list', ['limit' => 200]);
        $this->set(compact('canqualifyUser', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Canqualify User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $canqualifyUser = $this->CanqualifyUsers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $canqualifyUser = $this->CanqualifyUsers->patchEntity($canqualifyUser, $this->request->getData());
            if ($this->CanqualifyUsers->save($canqualifyUser)) {
                $this->Flash->success(__('The canqualify user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The canqualify user could not be saved. Please, try again.'));
        }
        $users = $this->CanqualifyUsers->Users->find('list', ['limit' => 200]);
        $this->set(compact('canqualifyUser', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Canqualify User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $canqualifyUser = $this->CanqualifyUsers->get($id);
        if ($this->CanqualifyUsers->delete($canqualifyUser)) {
            $this->Flash->success(__('The canqualify user has been deleted.'));
        } else {
            $this->Flash->error(__('The canqualify user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
