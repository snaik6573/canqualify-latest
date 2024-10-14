<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;

/**
 * NaiscCodes Controller
 *
 * @property \App\Model\Table\NaiscCodesTable $NaiscCodes
 *
 * @method \App\Model\Entity\NaiscCode[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class NaiscCodesController extends AppController
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
	$totalCount = $this->NaiscCodes->find('all')->count();
        $this->paginate = [
            'limit'   => $totalCount,
            'maxLimit'=> $totalCount
        ];
        $naiscCodes = $this->paginate($this->NaiscCodes);

        $this->set(compact('naiscCodes'));
    }

    /**
     * View method
     *
     * @param string|null $id Naisc Code id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $naiscCode = $this->NaiscCodes->get($id, [
            'contain' => []
        ]);

        $this->set('naiscCode', $naiscCode);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $naiscCode = $this->NaiscCodes->newEntity();
        if ($this->request->is('post')) {
            $naiscCode = $this->NaiscCodes->patchEntity($naiscCode, $this->request->getData());
			$naiscCode->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
            if ($this->NaiscCodes->save($naiscCode)) {
                $this->Flash->success(__('The naisc code has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The naisc code could not be saved. Please, try again.'));
        }
        $this->set(compact('naiscCode'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Naisc Code id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $naiscCode = $this->NaiscCodes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $naiscCode = $this->NaiscCodes->patchEntity($naiscCode, $this->request->getData());
			$naiscCode->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');
            if ($this->NaiscCodes->save($naiscCode)) {
                $this->Flash->success(__('The naisc code has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The naisc code could not be saved. Please, try again.'));
        }
        $this->set(compact('naiscCode'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Naisc Code id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $naiscCode = $this->NaiscCodes->get($id);
        if ($this->NaiscCodes->delete($naiscCode)) {
            $this->Flash->success(__('The naisc code has been deleted.'));
        } else {
            $this->Flash->error(__('The naisc code could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
