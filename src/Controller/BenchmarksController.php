<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Core\Configure;

/**
 * Benchmarks Controller
 *
 * @property \App\Model\Table\BenchmarksTable $Benchmarks
 *
 * @method \App\Model\Entity\Benchmark[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BenchmarksController extends AppController
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
    public function index($client_id=null)
    {
	$totalCount = $this->Benchmarks->find('all')->count();						
	/*$this->paginate = [
            'contain' => ['BenchmarkCategories', 'Clients', 'BenchmarkTypes'],
            'limit'=>$totalCount,
            'maxLimit'=>$totalCount
	];*/
    $where = [];
	if($this->User->isClient()) {
	    $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
        $where['Benchmarks.client_id'] = $client_id;
    }
    elseif($client_id!=0) {
        $where['Benchmarks.client_id'] = $client_id;
    }
	$this->paginate = [
        'contain' => ['BenchmarkCategories', 'Clients', 'BenchmarkTypes'],
	    'conditions' => $where,
        'limit'=>$totalCount,
        'maxLimit'=>$totalCount
	];

	$benchmark = $this->Benchmarks->newEntity();
    if ($this->request->is(['patch', 'post', 'put'])) {
		if($this->request->getData('current_client_id')!==null) {
			$client_id = $this->request->getData('current_client_id');
            return $this->redirect(['action' => 'index', $client_id]);
		}
    }
   	$benchmarks = $this->paginate($this->Benchmarks);

	$clients = $this->Benchmarks->Clients->find('list', ['keyField'=>'id', 'valueField'=>'company_name'])->toArray();
    $client = [];
	if($client_id!=0) {
		$client = $this->Benchmarks->Clients->find('all')->where(['Clients.id'=>$client_id])->first();
    }
    $this->set(compact('benchmarks', 'benchmark', 'clients', 'client'));
    }

    /**
     * View method
     *
     * @param string|null $id Benchmark id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $benchmark = $this->Benchmarks->get($id, [
            'contain' => ['BenchmarkCategories', 'Clients', 'BenchmarkTypes']
        ]);

        $this->set(compact('benchmark'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($client_id=null)
    {
	$benchmark = $this->Benchmarks->newEntity();

	if ($this->request->is(['patch', 'post', 'put'])) {
		$benchmark = $this->Benchmarks->patchEntity($benchmark, $this->request->getData());
        $benchmark->client_id = $client_id;
		$benchmark->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
		if ($this->Benchmarks->save($benchmark)) {
			$this->Flash->success(__('The benchmark has been saved.'));
			return $this->redirect(['action' => 'index', $client_id]);
		}
		$this->Flash->error(__('The benchmark could not be saved. Please, try again.'));
    }

    $benchmarkCategories = $this->Benchmarks->BenchmarkCategories->find('list', ['limit' => 200])->where(['client_id'=>$client_id]);
    $benchmarkTypes = $this->Benchmarks->BenchmarkTypes->find('list', ['limit' => 200]);
    $client = $this->Benchmarks->Clients->find('all')->where(['Clients.id'=>$client_id])->first();
	$icons = Configure::read('icons');

	$this->set(compact('benchmark', 'benchmarkCategories', 'client', 'benchmarkTypes', 'icons'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Benchmark id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $benchmark = $this->Benchmarks->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $benchmark = $this->Benchmarks->patchEntity($benchmark, $this->request->getData());
            $benchmark->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');

            if ($this->Benchmarks->save($benchmark)) {
                $this->Flash->success(__('The benchmark has been saved.'));

                return $this->redirect(['action' => 'index', $benchmark->client_id]);
            }
            $this->Flash->error(__('The benchmark could not be saved. Please, try again.'));
        }

        $client_id = $benchmark->client_id;
        $benchmarkCategories = $this->Benchmarks->BenchmarkCategories->find('list', ['limit' => 200])->where(['client_id'=>$client_id]);
        $benchmarkTypes = $this->Benchmarks->BenchmarkTypes->find('list', ['limit' => 200]);
        $client = $this->Benchmarks->Clients->find('all')->where(['Clients.id'=>$client_id])->first();
	    $icons = Configure::read('icons');

        $this->set(compact('benchmark', 'benchmarkCategories', 'client', 'benchmarkTypes', 'icons'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Benchmark id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $benchmark = $this->Benchmarks->get($id);
        if ($this->Benchmarks->delete($benchmark)) {
            $this->Flash->success(__('The benchmark has been deleted.'));
        } else {
            $this->Flash->error(__('The benchmark could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
