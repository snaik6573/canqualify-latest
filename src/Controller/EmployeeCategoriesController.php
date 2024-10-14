<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;
/**
 * EmployeeCategories Controller
 *
 * @property \App\Model\Table\EmployeeCategoriesTable $EmployeeCategories
 *
 * @method \App\Model\Entity\EmployeeCategory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmployeeCategoriesController extends AppController
{
    public function isAuthorized($user)
    {
    $clientNav = false;
    if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN) {
        $clientNav = true;
    }
    $this->set('clientNav', $clientNav);

	// Admin can access every action
	if (isset($user['role_id']) && $user['active'] == 1) {
		//if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN){		
			return true;
		//}
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
        $totalCount = $this->EmployeeCategories->find('all')->count();
        $where = [];
        if($this->User->isClient()) {
            $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
            $where = ['EmployeeCategories.client_id'=>$client_id];
        }
        $this->paginate = [            
            'conditions' => $where,
            'limit'=>$totalCount,
            'maxLimit'=>$totalCount
        ];
        $employeeCategories = $this->paginate($this->EmployeeCategories);
		
		if ($this->request->is(['patch', 'post', 'put'])) {
			$this->viewBuilder()->setLayout('ajax');

			$employeeCategory = $this->EmployeeCategories->get($this->request->getData('id'));
			$employeeCategory = $this->EmployeeCategories->patchEntity($employeeCategory, $this->request->getData());
			$employeeCategory->created_by = $this->getRequest()->getSession()->read('Auth.User.id');		
			if ($this->EmployeeCategories->save($employeeCategory)) {
				echo '<div class="alert with-close alert-success alert-dismissible fade show" role="alert">The category has been saved.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
			}
			else {
				echo '<div class="alert with-close alert-danger alert-dismissible fade show" role="alert">The category could not be saved. Please, try again.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
			}
			exit;
		}
        $this->set(compact('employeeCategories'));
    }

    /**
     * View method
     *
     * @param string|null $id Employee Category id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $employeeCategory = $this->EmployeeCategories->get($id, [
            'contain' => ['EmployeeQuestions']
        ]);
		$sub_cat = $this->EmployeeCategories->find()->where(['employee_category_id'=>$id])->toArray();
		
        $this->set(compact('employeeCategory', 'sub_cat'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $employeeCategory = $this->EmployeeCategories->newEntity();
        if ($this->request->is('post')) {
            $employeeCategory = $this->EmployeeCategories->patchEntity($employeeCategory, $this->request->getData());
			if($this->User->isClient()) {
            $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
            $employeeCategory->client_id = $client_id;  
            }  
			$employeeCategory->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
            if ($this->EmployeeCategories->save($employeeCategory)) {
                $this->Flash->success(__('The employee category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The employee category could not be saved. Please, try again.'));
        }
		$employeeCategories = $this->EmployeeCategories->find('list');
		if($this->User->isClient()) {
            $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
            $employeeCategories = $this->EmployeeCategories->find('list', ['limit' => 200])->where(['EmployeeCategories.client_id'=>$client_id,'is_parent'=>true]);;  
        } 
        $this->set(compact('employeeCategory', 'employeeCategories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Employee Category id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $employeeCategory = $this->EmployeeCategories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $employeeCategory = $this->EmployeeCategories->patchEntity($employeeCategory, $this->request->getData());
			$employeeCategory->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');
            if ($this->EmployeeCategories->save($employeeCategory)) {
                $this->Flash->success(__('The employee category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The employee category could not be saved. Please, try again.'));
        }
		$employeeCategories = $this->EmployeeCategories->find('list');
		if($this->User->isClient()) {
            $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
            $employeeCategories = $this->EmployeeCategories->find('list', ['limit' => 200])->where(['EmployeeCategories.client_id'=>$client_id,'is_parent'=>true]);;  
        } 
        $this->set(compact('employeeCategory', 'employeeCategories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Employee Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $employeeCategory = $this->EmployeeCategories->get($id);
        if ($this->EmployeeCategories->delete($employeeCategory)) {
            $this->Flash->success(__('The employee category has been deleted.'));
        } else {
            $this->Flash->error(__('The employee category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
