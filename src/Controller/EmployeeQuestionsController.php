<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;
/**
 * EmployeeQuestions Controller
 *
 * @property \App\Model\Table\EmployeeQuestionsTable $EmployeeQuestions
 *
 * @method \App\Model\Entity\EmployeeQuestion[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmployeeQuestionsController extends AppController
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
        $totalCount = $this->EmployeeQuestions->find('all')->count(); 

        /*$this->paginate = [
            'contain' => ['QuestionTypes', 'EmployeeCategories'],
            'limit'=>$totalCount,
            'maxLimit'=>$totalCount
        ];*/
        $employeeQuestions = $this->paginate($this->EmployeeQuestions);$where = [];
         if($this->User->isClient()) {
            $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
            $where = ['EmployeeQuestions.client_id'=>$client_id];
        }       
        $this->paginate = [
            'contain' => ['QuestionTypes', 'EmployeeCategories'],
            'conditions' => $where,
            'limit'=>$totalCount,
            'maxLimit'=>$totalCount
        ];

        $employeeQuestions = $this->paginate($this->EmployeeQuestions);

		if ($this->request->is(['patch', 'post', 'put'])) {
			$this->viewBuilder()->setLayout('ajax');

			$employeeCategory = $this->EmployeeQuestions->get($this->request->getData('id'));
			$employeeCategory = $this->EmployeeQuestions->patchEntity($employeeCategory, $this->request->getData());
			$employeeCategory->created_by = $this->getRequest()->getSession()->read('Auth.User.id');		
			if ($this->EmployeeQuestions->save($employeeCategory)) {
				echo '<div class="alert with-close alert-success alert-dismissible fade show" role="alert">The category has been saved.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
			}
			else {
				echo '<div class="alert with-close alert-danger alert-dismissible fade show" role="alert">The category could not be saved. Please, try again.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
			}
			exit;
		}
        $this->set(compact('employeeQuestions'));
    }

    /**
     * View method
     *
     * @param string|null $id Employee Question id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $employeeQuestion = $this->EmployeeQuestions->get($id, [
            'contain' => ['QuestionTypes', 'EmployeeCategories']
        ]);
		$employeeQuestion->question_options = implode("\r\n",json_decode($employeeQuestion['question_options']));

		$this->paginate = [
	        'contain' => ['QuestionTypes', 'EmployeeCategories'],
	        'conditions'=> ['employee_question_id'=>$id]
	    ];
	    $subQuestions = $this->paginate($this->EmployeeQuestions);
        
		$this->set(compact('employeeQuestion', 'subQuestions'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $employeeQuestion = $this->EmployeeQuestions->newEntity();
        if ($this->request->is('post')) {
            $employeeQuestion = $this->EmployeeQuestions->patchEntity($employeeQuestion, $this->request->getData());
			if($this->User->isClient()) {
            $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
            $employeeQuestion->client_id = $client_id;  
            }    
			$employeeQuestion->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
            $employeeQuestion->question_options = json_encode(explode("\r\n", $this->request->getData('question_options')));
            if ($this->EmployeeQuestions->save($employeeQuestion)) {
                $this->Flash->success(__('The employee question has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The employee question could not be saved. Please, try again.'));
        }
        $questionTypes = $this->EmployeeQuestions->QuestionTypes->find('list', ['limit' => 200]);
        $employeeCategories = $this->EmployeeQuestions->EmployeeCategories->find('list', ['limit' => 200]);
        if($this->User->isClient()) {
            $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
            $employeeCategories = $this->EmployeeQuestions->EmployeeCategories->find('list', ['limit' => 200])->where(['EmployeeCategories.client_id'=>$client_id]);;  
        }    
		$this->set(compact('employeeQuestion', 'questionTypes', 'employeeCategories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Employee Question id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $employeeQuestion = $this->EmployeeQuestions->get($id, [
            'contain' => []
        ]);
		$employeeQuestion->question_options =  implode("\r\n",json_decode($employeeQuestion['question_options']));
		
        if ($this->request->is(['patch', 'post', 'put'])) {
            $employeeQuestion = $this->EmployeeQuestions->patchEntity($employeeQuestion, $this->request->getData());
			$employeeQuestion->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');
            $employeeQuestion->question_options = json_encode(explode("\r\n", $this->request->getData('question_options') ));
            if ($this->EmployeeQuestions->save($employeeQuestion)) {
                $this->Flash->success(__('The employee question has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The employee question could not be saved. Please, try again.'));
        }
        $questionTypes = $this->EmployeeQuestions->QuestionTypes->find('list', ['limit' => 200]);
        $employeeCategories = $this->EmployeeQuestions->EmployeeCategories->find('list', ['limit' => 200]);
		if($this->User->isClient()) {
            $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
            $employeeCategories = $this->EmployeeQuestions->EmployeeCategories->find('list', ['limit' => 200])->where(['EmployeeCategories.client_id'=>$client_id]);;  
        }
		$questions = $this->EmployeeQuestions->find('list', ['keyField' => 'id', 'valueField' => 'question'])->where(['employee_category_id'=>$employeeQuestion->employee_category_id, 'is_parent'=>true]);

        $questionOptions = [];
        if ($employeeQuestion->employee_question_id != '') {
            $questionOptions = $this->EmployeeQuestions->find('list', ['keyField'=>'question_options', 'valueField'=>'question_options'])->where(['id'=>$employeeQuestion->employee_question_id])->first();
            $questionOptions = json_decode($questionOptions, true);
            $questionOptions = array_combine($questionOptions, $questionOptions);
        }
        $this->set(compact('employeeQuestion', 'questionTypes', 'employeeCategories', 'questions', 'questionOptions'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Employee Question id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $employeeQuestion = $this->EmployeeQuestions->get($id);
        if ($this->EmployeeQuestions->delete($employeeQuestion)) {
            $this->Flash->success(__('The employee question has been deleted.'));
        } else {
            $this->Flash->error(__('The employee question could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
	public function getQuestions($category_id=null)
    {
    	$this->viewBuilder()->setLayout('ajax');

        $questions = [];
        if ($category_id!==null) {
            $questions = $this->EmployeeQuestions->find('list', ['keyField' => 'id', 'valueField' => 'question'])->where(['employee_category_id'=>$category_id, 'is_parent'=>true]);
        }

		$this->set(compact('questions'));
	}
	
    public function getOptions($id=null)
    {
    	$this->viewBuilder()->setLayout('ajax');
        $questionOptions = [];
        if ($id!==null) {
            $questionOptions = $this->EmployeeQuestions->find('list', ['keyField'=>'question_options', 'valueField'=>'question_options'])->where(['id'=>$id])->first();
            
            $questionOptions = json_decode($questionOptions, true);
            $questionOptions = array_combine($questionOptions, $questionOptions);
        }

		$this->set(compact('questionOptions'));
	}
}
