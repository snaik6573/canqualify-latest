<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ClientEmployeeQuestions Controller
 *
 * @property \App\Model\Table\ClientEmployeeQuestionsTable $ClientEmployeeQuestions
 *
 * @method \App\Model\Entity\ClientEmployeeQuestion[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ClientEmployeeQuestionsController extends AppController
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
    /*public function index()
    {
        $this->paginate = [
            'contain' => ['Clients', 'EmployeeQuestions']
        ];
        $clientEmployeeQuestions = $this->paginate($this->ClientEmployeeQuestions);

        $this->set(compact('clientEmployeeQuestions'));
    }*/

    /**
     * View method
     *
     * @param string|null $id Client Employee Question id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function view($id = null)
    {
        $clientEmployeeQuestion = $this->ClientEmployeeQuestions->get($id, [
            'contain' => ['Clients', 'EmployeeQuestions']
        ]);

        $this->set('clientEmployeeQuestion', $clientEmployeeQuestion);
    }*/

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($client_id=null)
    {
		$this->loadModel('ClientServices');
		$this->loadModel('EmployeeCategories');
		
        if($this->User->isClient()) {
            $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
        }
        $clients = $this->ClientServices
		->find('list',['keyField'=>'client.id','valueField'=>'client.company_name'])
		->contain(['Clients'])
		->where(['service_id'=>4])
		->toArray();
	
        $user_id = $this->getRequest()->getSession()->read('Auth.User.id');

        if ($this->request->is(['patch', 'post', 'put'])) {
		    if($this->request->getData('current_client_id')!==null) {
			    $client_id = $this->request->getData('current_client_id');
                return $this->redirect(['action' => 'add', $client_id]);
		    }
			
		$this->viewBuilder()->setLayout('ajax');
		if(null !== $this->request->getData('client_employee_questions'))
		{
			$client_questions = $this->request->getData('client_employee_questions');
			$employee_category_id = $this->request->getData('employee_category_id');
			
    		foreach($client_questions as $key=>$val) {
				if($val['employee_question_id']==0 )  {
					unset($client_questions['client_employee_questions'][$key]);
					if(isset($val['id']))  {
						$entity = $this->ClientEmployeeQuestions->get($val['id']);
						$result = $this->ClientEmployeeQuestions->delete($entity);
					}
				}
				
				$val['client_id'] = $client_id;
				$val['employee_category_id'] = $employee_category_id;
				
				$saveDt = $this->ClientEmployeeQuestions->find('all', ['conditions'=>['client_id'=>$client_id, 'employee_question_id'=>$val['employee_question_id'],]])->first();
				if(empty($saveDt)) { // new ClientEmployeeQuestions
					$saveDt = $this->ClientEmployeeQuestions->newEntity();
					$saveDt = $this->ClientEmployeeQuestions->patchEntity($saveDt, $val);
					$saveDt->created_by = $user_id;
					$this->ClientEmployeeQuestions->save($saveDt);								
				}
				else { // update ClientEmployeeQuestions
					$saveDt = $this->ClientEmployeeQuestions->patchEntity($saveDt, $val);
					$saveDt->modified_by = $user_id;
					$this->ClientEmployeeQuestions->save($saveDt);
				}
			}
			echo '<div class="alert with-close alert-success alert-dismissible fade show" role="alert">The Client Employee Questions has been saved.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
			exit;
		}
		}

        if($client_id!=null) { // Edit Client
			$client = $this->ClientServices->Clients->get($client_id, [
				'contain' => ['ClientEmployeeQuestions']
			]);
		$whereQue = [];
        $whereCat = [];
        if($this->User->isClient()) {
            $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');  

            $whereQue = ['EmployeeQuestions.client_id'=>$client_id];
            $whereCat = ['EmployeeCategories.client_id'=>$client_id];
             }	
			$employeeCategories = $this->EmployeeCategories
			->find()
			->select(['id', 'name', 'employee_category_id','client_id'])
			->contain(['EmployeeQuestions'=> [
                'conditions'=>['EmployeeQuestions.active'=>true,$whereQue], 
                'fields'=>['id', 'question', 'employee_category_id','question_options','is_parent','parent_option','employee_question_id', 'ques_order','client_id'], 
                'queryBuilder' => function ($q) { return $q->order(['EmployeeQuestions.ques_order'=>'ASC', 'EmployeeQuestions.id'=>'ASC']); }
            ]])
			->contain(['EmployeeQuestions.QuestionTypes'=>['fields'=>['id', 'name']] ])
			->contain(['EmployeeQuestions.ClientEmployeeQuestions'=> ['conditions'=>['ClientEmployeeQuestions.client_id'=>$client_id]]])
			->where(['EmployeeCategories.active'=>true,$whereCat])
			->order(['employee_category_order'=>'ASC','id'=>'ASC'])
			->toArray();
		
			$this->set(compact('client', 'employeeCategories'));
        }
        $this->set(compact('clients', 'user_id'));
		
        /*$clientEmployeeQuestion = $this->ClientEmployeeQuestions->newEntity();
        if ($this->request->is('post')) {
            $clientEmployeeQuestion = $this->ClientEmployeeQuestions->patchEntity($clientEmployeeQuestion, $this->request->getData());
            if ($this->ClientEmployeeQuestions->save($clientEmployeeQuestion)) {
                $this->Flash->success(__('The client employee question has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The client employee question could not be saved. Please, try again.'));
        }
        $clients = $this->ClientEmployeeQuestions->Clients->find('list', ['limit' => 200]);
        $employeeQuestions = $this->ClientEmployeeQuestions->EmployeeQuestions->find('list', ['limit' => 200]);
        $this->set(compact('clientEmployeeQuestion', 'clients', 'employeeQuestions'));*/
    }
    /**
     * Edit method
     *
     * @param string|null $id Client Employee Question id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function edit($id = null)
    {
        $clientEmployeeQuestion = $this->ClientEmployeeQuestions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $clientEmployeeQuestion = $this->ClientEmployeeQuestions->patchEntity($clientEmployeeQuestion, $this->request->getData());
            if ($this->ClientEmployeeQuestions->save($clientEmployeeQuestion)) {
                $this->Flash->success(__('The client employee question has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The client employee question could not be saved. Please, try again.'));
        }
        $clients = $this->ClientEmployeeQuestions->Clients->find('list', ['limit' => 200]);
        $employeeQuestions = $this->ClientEmployeeQuestions->EmployeeQuestions->find('list', ['limit' => 200]);
        $this->set(compact('clientEmployeeQuestion', 'clients', 'employeeQuestions'));
    }*/

    /**
     * Delete method
     *
     * @param string|null $id Client Employee Question id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $clientEmployeeQuestion = $this->ClientEmployeeQuestions->get($id);
        if ($this->ClientEmployeeQuestions->delete($clientEmployeeQuestion)) {
            $this->Flash->success(__('The client employee question has been deleted.'));
        } else {
            $this->Flash->error(__('The client employee question could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }*/
}
