<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * WaitingOnLogs Controller
 *
 * @property \App\Model\Table\WaitingOnLogsTable $WaitingOnLogs
 *
 * @method \App\Model\Entity\WaitingOnLog[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WaitingOnLogsController extends AppController
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
    public function index()
    {
        $this->paginate = [
            'contain' => ['Contractors']
        ];
        $waitingOnLogs = $this->paginate($this->WaitingOnLogs);

        $this->set(compact('waitingOnLogs'));
    }

    /**
     * View method
     *
     * @param string|null $id Waiting On Log id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $waitingOnLog = $this->WaitingOnLogs->get($id, [
            'contain' => ['Contractors']
        ]);

        $this->set('waitingOnLog', $waitingOnLog);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $waitingOnLog = $this->WaitingOnLogs->newEntity();
        if ($this->request->is('post')) {
            $waitingOnLog = $this->WaitingOnLogs->patchEntity($waitingOnLog, $this->request->getData());
            if ($this->WaitingOnLogs->save($waitingOnLog)) {
                $this->Flash->success(__('The waiting on log has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The waiting on log could not be saved. Please, try again.'));
        }
        $contractors = $this->WaitingOnLogs->Contractors->find('list', ['limit' => 200]);
        $this->set(compact('waitingOnLog', 'contractors'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Waiting On Log id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $waitingOnLog = $this->WaitingOnLogs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $waitingOnLog = $this->WaitingOnLogs->patchEntity($waitingOnLog, $this->request->getData());
            if ($this->WaitingOnLogs->save($waitingOnLog)) {
                $this->Flash->success(__('The waiting on log has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The waiting on log could not be saved. Please, try again.'));
        }
        $contractors = $this->WaitingOnLogs->Contractors->find('list', ['limit' => 200]);
        $this->set(compact('waitingOnLog', 'contractors'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Waiting On Log id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $waitingOnLog = $this->WaitingOnLogs->get($id);
        if ($this->WaitingOnLogs->delete($waitingOnLog)) {
            $this->Flash->success(__('The waiting on log has been deleted.'));
        } else {
            $this->Flash->error(__('The waiting on log could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
