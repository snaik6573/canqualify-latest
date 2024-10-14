<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * NotesStatus Controller
 *
 * @property \App\Model\Table\NotesStatusTable $NotesStatus
 *
 * @method \App\Model\Entity\NotesStatus[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class NotesStatusController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Contractors', 'Users', 'Leads']
        ];
        $notesStatus = $this->paginate($this->NotesStatus);

        $this->set(compact('notesStatus'));
    }

    /**
     * View method
     *
     * @param string|null $id Notes Status id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $notesStatus = $this->NotesStatus->get($id, [
            'contain' => ['Contractors', 'Users', 'Leads']
        ]);

        $this->set('notesStatus', $notesStatus);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $notesStatus = $this->NotesStatus->newEntity();
        if ($this->request->is('post')) {
            $notesStatus = $this->NotesStatus->patchEntity($notesStatus, $this->request->getData());
            if ($this->NotesStatus->save($notesStatus)) {
                $this->Flash->success(__('The notes status has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The notes status could not be saved. Please, try again.'));
        }
        $contractors = $this->NotesStatus->Contractors->find('list', ['limit' => 200]);
        $users = $this->NotesStatus->Users->find('list', ['limit' => 200]);
        $leads = $this->NotesStatus->Leads->find('list', ['limit' => 200]);
        $this->set(compact('notesStatus', 'contractors', 'users', 'leads'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Notes Status id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $notesStatus = $this->NotesStatus->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $notesStatus = $this->NotesStatus->patchEntity($notesStatus, $this->request->getData());
            if ($this->NotesStatus->save($notesStatus)) {
                $this->Flash->success(__('The notes status has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The notes status could not be saved. Please, try again.'));
        }
        $contractors = $this->NotesStatus->Contractors->find('list', ['limit' => 200]);
        $users = $this->NotesStatus->Users->find('list', ['limit' => 200]);
        $leads = $this->NotesStatus->Leads->find('list', ['limit' => 200]);
        $this->set(compact('notesStatus', 'contractors', 'users', 'leads'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Notes Status id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $notesStatus = $this->NotesStatus->get($id);
        if ($this->NotesStatus->delete($notesStatus)) {
            $this->Flash->success(__('The notes status has been deleted.'));
        } else {
            $this->Flash->error(__('The notes status could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
