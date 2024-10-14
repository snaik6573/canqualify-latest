<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * NaicCodes Controller
 *
 * @property \App\Model\Table\NaicCodesTable $NaicCodes
 *
 * @method \App\Model\Entity\NaicCode[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class NaicCodesController extends AppController
{
    public function isAuthorized($user)
    {
    // Admin can access every action
    if (isset($user['role_id']) && $user['active'] == 1) {
        if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN){       
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
        $totalCount = $this->NaicCodes->find('all')->count();
        $this->paginate = [
            'limit'   => $totalCount,
            'maxLimit'=> $totalCount
        ];
        $naicCodes = $this->paginate($this->NaicCodes);

        $this->set(compact('naicCodes'));
    }

    /**
     * View method
     *
     * @param string|null $id Naic Code id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $naicCode = $this->NaicCodes->get($id, [
            'contain' => []
        ]);

        $this->set('naicCode', $naicCode);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $naicCode = $this->NaicCodes->newEntity();
        if ($this->request->is('post')) {
            $naicCode = $this->NaicCodes->patchEntity($naicCode, $this->request->getData());
            $naicCode->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
            if ($this->NaicCodes->save($naicCode)) {
                $this->Flash->success(__('The naic code has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The naic code could not be saved. Please, try again.'));
        }
        $this->set(compact('naicCode'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Naic Code id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $naicCode = $this->NaicCodes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $naicCode = $this->NaicCodes->patchEntity($naicCode, $this->request->getData());
            $naicCode->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');
            if ($this->NaicCodes->save($naicCode)) {
                $this->Flash->success(__('The naic code has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The naic code could not be saved. Please, try again.'));
        }
        $this->set(compact('naicCode'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Naic Code id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $naicCode = $this->NaicCodes->get($id);
        if ($this->NaicCodes->delete($naicCode)) {
            $this->Flash->success(__('The naic code has been deleted.'));
        } else {
            $this->Flash->error(__('The naic code could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
