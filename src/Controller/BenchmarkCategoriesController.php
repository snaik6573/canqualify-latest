<?php
namespace App\Controller;
use App\Controller\AppController;

/**
 * BenchmarkCategories Controller
 *
 * @property \App\Model\Table\BenchmarkCategoriesTable $BenchmarkCategories
 *
 * @method \App\Model\Entity\BenchmarkCategory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BenchmarkCategoriesController extends AppController
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
        $this->paginate = [
            'contain' => ['Clients']
        ];
        $benchmarkCategories = $this->paginate($this->BenchmarkCategories);

        $this->set(compact('benchmarkCategories'));
    }

    /**
     * View method
     *
     * @param string|null $id Benchmark Category id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $benchmarkCategory = $this->BenchmarkCategories->get($id, [
            'contain' => ['Clients']
        ]);

        $this->set('benchmarkCategory', $benchmarkCategory);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($client_id=null)
    {
	$this->viewBuilder()->setLayout('ajax');

        $benchmarkCategory = $this->BenchmarkCategories->newEntity();
        if ($this->request->is('post')) {
		$benchmarkCategory = $this->BenchmarkCategories->patchEntity($benchmarkCategory, $this->request->getData());
		$benchmarkCategory->client_id = $client_id;
		$benchmarkCategory->created_by = $this->getRequest()->getSession()->read('Auth.User.id');

		if ($this->BenchmarkCategories->save($benchmarkCategory)) {
                	$this->Flash->success(__('The benchmark category has been saved.'));
			//return $this->redirect(['action' => 'index']);
		}
		else {
			$this->Flash->error(__('The benchmark category could not be saved. Please, try again.'));
		}
        }
        $clients = $this->BenchmarkCategories->Clients->find('list', ['keyField' => 'id', 'valueField' => 'company_name'], ['limit' => 200]);

        $this->set(compact('benchmarkCategory', 'clients', 'client_id'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Benchmark Category id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $benchmarkCategory = $this->BenchmarkCategories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $benchmarkCategory = $this->BenchmarkCategories->patchEntity($benchmarkCategory, $this->request->getData());
            $benchmarkCategory->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');
			if ($this->BenchmarkCategories->save($benchmarkCategory)) {
                $this->Flash->success(__('The benchmark category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The benchmark category could not be saved. Please, try again.'));
        }
        $clients = $this->BenchmarkCategories->Clients->find('list', ['limit' => 200]);
        $this->set(compact('benchmarkCategory', 'clients'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Benchmark Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $benchmarkCategory = $this->BenchmarkCategories->get($id);
        if ($this->BenchmarkCategories->delete($benchmarkCategory)) {
            $this->Flash->success(__('The benchmark category has been deleted.'));
        } else {
            $this->Flash->error(__('The benchmark category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
