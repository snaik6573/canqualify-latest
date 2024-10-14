<?php
namespace App\Controller;
use App\Controller\AppController;

/**
 * BenchmarkTypes Controller
 *
 * @property \App\Model\Table\BenchmarkTypesTable $BenchmarkTypes
 *
 * @method \App\Model\Entity\BenchmarkType[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BenchmarkTypesController extends AppController
{
	
	 public function isAuthorized($user)
    {
	if($this->request->getParam('action')=='index') {
		if($user['role_id'] == CLIENT || $user['role_id'] == CLIENT_ADMIN || $user['role_id'] == CLIENT_VIEW || $user['role_id'] == CLIENT_BASIC) {
			return true; 
		}
	}
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
        $benchmarkTypes = $this->paginate($this->BenchmarkTypes);

        $this->set(compact('benchmarkTypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Benchmark Type id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $benchmarkType = $this->BenchmarkTypes->get($id, [
            'contain' => ['Benchmarks']
        ]);

        $this->set('benchmarkType', $benchmarkType);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $benchmarkType = $this->BenchmarkTypes->newEntity();
        if ($this->request->is('post')) {
            $benchmarkType = $this->BenchmarkTypes->patchEntity($benchmarkType, $this->request->getData());
            if ($this->BenchmarkTypes->save($benchmarkType)) {
                $this->Flash->success(__('The benchmark type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The benchmark type could not be saved. Please, try again.'));
        }
        $this->set(compact('benchmarkType'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Benchmark Type id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $benchmarkType = $this->BenchmarkTypes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $benchmarkType = $this->BenchmarkTypes->patchEntity($benchmarkType, $this->request->getData());
            if ($this->BenchmarkTypes->save($benchmarkType)) {
                $this->Flash->success(__('The benchmark type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The benchmark type could not be saved. Please, try again.'));
        }
        $this->set(compact('benchmarkType'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Benchmark Type id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $benchmarkType = $this->BenchmarkTypes->get($id);
        if ($this->BenchmarkTypes->delete($benchmarkType)) {
            $this->Flash->success(__('The benchmark type has been deleted.'));
        } else {
            $this->Flash->error(__('The benchmark type could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
