<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;
/**
 * EmployeeAnswers Controller
 *
 * @property \App\Model\Table\EmployeeAnswersTable $EmployeeAnswers
 *
 * @method \App\Model\Entity\EmployeeAnswer[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmployeeAnswersController extends AppController
{
    public function isAuthorized($user)
    {
	$contractorNav = false;
	if($user['role_id'] != EMPLOYEE) {
		$contractorNav = true;
	}
	$this->set('contractorNav', $contractorNav);
	
	$employeeNav = false;
	if($user['role_id'] != EMPLOYEE) {
			$employeeNav = true;
	}
	$this->set('employeeNav', $employeeNav);

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
    /*public function index()
    {
        $this->paginate = [
            'contain' => ['Employees', 'EmployeeQuestions', 'Clients']
        ];
        $employeeAnswers = $this->paginate($this->EmployeeAnswers);

        $this->set(compact('employeeAnswers'));
    }*/

    /**
     * View method
     *
     * @param string|null $id Employee Answer id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function view($id = null)
    {
        $employeeAnswer = $this->EmployeeAnswers->get($id, [
            'contain' => ['Employees', 'EmployeeQuestions', 'Clients']
        ]);

        $this->set('employeeAnswer', $employeeAnswer);
    }*/

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($category_id=null,$employee_id=null)
    {
		$this->loadModel('EmployeeCategories');
		$this->loadModel('EmployeeQuestions');
		
        if($employee_id !=null) {
            $this->getRequest()->getSession()->write('Auth.User.employee_id', $employee_id);
            $this->set('activeUser', $this->getRequest()->getSession()->read('Auth.User'));
        }else{
            $employee_id = $this->getRequest()->getSession()->read('Auth.User.employee_id');
        }
        $contractor_id =null;
		$contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
		$employee = $this->EmployeeAnswers->Employees->get($employee_id);

		
        if($this->getRequest()->getSession()->read('Auth.User.role_id') == CLIENT_VIEW || $this->getRequest()->getSession()->read('Auth.User.role_id') == CLIENT_BASIC) {
            $is_locked = 1;
            $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
            $contractor_clients[] = $client_id;
            $this->set(compact('client_id'));
        }		
		else {
			$is_locked = 0;
			$contractor_clients = $this->User->getEmployeeClients($employee_id,$contractor_id);
		}

		$questions = $this->EmployeeQuestions
			->find()
			->contain(['QuestionTypes'=>['fields'=>['id', 'name']] ])
			->contain(['ClientEmployeeQuestions'=>[
					'fields'=>['id', 'client_id','employee_question_id','is_compulsory'], 
					'conditions'=>['client_id IN'=>$contractor_clients]]
				])
			->contain(['ClientEmployeeQuestions.Clients'=>['fields'=>['id', 'company_name']]])
			->contain(['employeeAnswers'=>['conditions'=>['employee_id'=>$employee_id]] ])
			->where(['active'=>true, 'employee_category_id'=>$category_id])
			->order(['ques_order'=>'ASC','EmployeeQuestions.id'=>'ASC'])
			->all(); 

		$employeeAnswer = $this->EmployeeAnswers->find('all', ['conditions'=>['employee_id'=>$employee_id]])->toArray();
		if(empty($employeeAnswer)) {
			$employeeAnswer = $this->EmployeeAnswers->newEntity();
		}

		if ($this->request->is(['patch', 'post', 'put'])) {
			$requestDt = $this->request->getData('employee_answers'); 
			foreach($requestDt as $key=>$val) {
			if(isset($val['employee_question_id'])) {
					$this->saveAnswer($val);
			}
			else {  // client_based questions save
				foreach($val as $key=>$v) {
					$this->saveAnswer($v);
				}
			}
			}
			$this->Flash->success(__('Answers has been saved.'));
			return $this->redirect(['action' => 'add', $category_id]);
			$this->set('submit', 1);
		}

		$states = $this->EmployeeAnswers->Employees->States->find('list', ['keyField'=>'name', 'valueField'=>'name'])->limit(200)->toArray();
		$category = $this->EmployeeCategories->find('all', ['conditions'=>['id'=>$category_id]])->select(['name'])->first();

		$this->set(compact('employeeAnswer', 'category', 'states', 'questions', 'employee_id','is_locked', 'category_id', 'employee'));
		
        /*$employeeAnswer = $this->EmployeeAnswers->newEntity();
        if ($this->request->is('post')) {
            $employeeAnswer = $this->EmployeeAnswers->patchEntity($employeeAnswer, $this->request->getData());
            if ($this->EmployeeAnswers->save($employeeAnswer)) {
                $this->Flash->success(__('The employee answer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The employee answer could not be saved. Please, try again.'));
        }
        $employees = $this->EmployeeAnswers->Employees->find('list', ['limit' => 200]);
        $employeeQuestions = $this->EmployeeAnswers->EmployeeQuestions->find('list', ['limit' => 200]);
        $clients = $this->EmployeeAnswers->Clients->find('list', ['limit' => 200]);
        $this->set(compact('employeeAnswer', 'employees', 'employeeQuestions', 'clients'));*/
    }
     public function addBasicAnswer($category_id=null,$employee_id=null)
    {
        $this->loadModel('EmployeeCategories');
        $this->loadModel('EmployeeQuestions');
        
        if($employee_id !=null) {
            $this->getRequest()->getSession()->write('Auth.User.employee_id', $employee_id);
            $this->set('activeUser', $this->getRequest()->getSession()->read('Auth.User'));
        }else{
            $employee_id = $this->getRequest()->getSession()->read('Auth.User.employee_id');
        }
        if($this->getRequest()->getSession()->read('Auth.User.role_id') == CLIENT_VIEW || $this->getRequest()->getSession()->read('Auth.User.role_id') == CLIENT_BASIC) {
            $is_locked = 1;           
        }       
        else {
            $is_locked = 0;           
        }
        $employee = $this->EmployeeAnswers->Employees->get($employee_id);
      
        $questions = $this->EmployeeQuestions
            ->find()
            ->contain(['QuestionTypes'=>['fields'=>['id', 'name']] ])
            /*->contain(['ClientEmployeeQuestions'=>[
                    'fields'=>['id', 'client_id','employee_question_id','is_compulsory'], 
                    'conditions'=>['client_id IN'=>$contractor_clients]]
                ])
            ->contain(['ClientEmployeeQuestions.Clients'=>['fields'=>['id', 'company_name']]])*/
            ->contain(['employeeAnswers'=>['conditions'=>['employee_id'=>$employee_id]] ])
            ->where(['active'=>true, 'employee_category_id'=>$category_id])
            ->order(['ques_order'=>'ASC','EmployeeQuestions.id'=>'ASC'])
            ->all(); 

        $employeeAnswer = $this->EmployeeAnswers->find('all', ['conditions'=>['employee_id'=>$employee_id]])->toArray();
        if(empty($employeeAnswer)) {
            $employeeAnswer = $this->EmployeeAnswers->newEntity();
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $requestDt = $this->request->getData('employee_answers'); 
            foreach($requestDt as $key=>$val) {
            if(isset($val['employee_question_id'])) {
                    $this->saveAnswer($val);
            }
            else {  // client_based questions save
                foreach($val as $key=>$v) {
                    $this->saveAnswer($v);
                }
            }
            }
            $this->Flash->success(__('Answers has been saved.'));
            return $this->redirect(['action' => 'add_basic_answer', $category_id]);
            $this->set('submit', 1);
        }

        $states = $this->EmployeeAnswers->Employees->States->find('list', ['keyField'=>'name', 'valueField'=>'name'])->limit(200)->toArray();
        $category = $this->EmployeeCategories->find('all', ['conditions'=>['id'=>$category_id]])->select(['name'])->first();

        $this->set(compact('employeeAnswer', 'category', 'states', 'questions', 'employee_id','is_locked', 'category_id', 'employee'));      
    }

	public function saveAnswer($val=array()) {
    $this->loadModel('EmployeeQuestions');
	$employee_id = $this->getRequest()->getSession()->read('Auth.User.employee_id');

	$val['employee_id'] = $employee_id;
	if( isset($val['answer']) && is_array($val['answer']) ) {
		$val['answer'] = implode(',',$val['answer']);
	}
	$client_id = isset($val['client_id']) ? $val['client_id'] : null;
	
	$saveDt = $this->EmployeeAnswers->find('all', ['conditions'=>['employee_id'=>$employee_id, 'employee_question_id'=>$val['employee_question_id'], 'client_id IS'=>$client_id]])->first();       

    $questiondt = $this->EmployeeQuestions
                ->find('all')
                ->contain(['QuestionTypes'=>['fields'=>['id', 'name']] ])
                ->where(['EmployeeQuestions.id'=>$val['employee_question_id']])
                ->first();
					
	if(empty($saveDt)) { // new answer
		if(isset($val['answer']) && $val['answer']!='' ) {                       
			if($val['answer']== 'other' && $questiondt->question_type->name == 'select_with_input') {
                $val['answer']='other: '.$val['answer_other'];
			}
            if($questiondt->question_type->name == 'acknowledge') {
            if($val['answer']== '0' && $val['date']=='' && $val['initials']==''){  
                $val['answer']='';
            }else{
                $val['answer']='value:'.$val['answer'].', date:'.$val['date']. ', initials:'.$val['initials'];
                }
            }
			if($val['answer']== '0' && $questiondt->question_type->name == 'checkbox_single') {
                $val['answer']='';
			}
			$val['created_by'] = $this->getRequest()->getSession()->read('Auth.User.id');
			$saveDt = $this->EmployeeAnswers->newEntity();
			$saveDt = $this->EmployeeAnswers->patchEntity($saveDt, $val);
            $this->EmployeeAnswers->save($saveDt);					
		}
	}
	else { // update answer
        if($val['answer']== 'other' && $questiondt->question_type->name == 'select_with_input') {
            $val['answer']='other: '.$val['answer_other'];
        }
        if($questiondt->question_type->name == 'acknowledge') {
            if($val['answer']== '0' && $val['date']=='' && $val['initials']==''){  
                $val['answer']='';
            }else{
                $val['answer']='value:'.$val['answer'].', date:'.$val['date']. ', initials:'.$val['initials'];
            }
        }
        if($val['answer']== '0' && $questiondt->question_type->name == 'checkbox_single') {
            $val['answer']='';
        }
		$val['modified_by'] = $this->getRequest()->getSession()->read('Auth.User.id');
		$saveDt = $this->EmployeeAnswers->patchEntity($saveDt, $val);
		$this->EmployeeAnswers->save($saveDt);
	}
    }
	
	
    /**
     * Edit method
     *
     * @param string|null $id Employee Answer id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function edit($id = null)
    {
        $employeeAnswer = $this->EmployeeAnswers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $employeeAnswer = $this->EmployeeAnswers->patchEntity($employeeAnswer, $this->request->getData());
            if ($this->EmployeeAnswers->save($employeeAnswer)) {
                $this->Flash->success(__('The employee answer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The employee answer could not be saved. Please, try again.'));
        }
        $employees = $this->EmployeeAnswers->Employees->find('list', ['limit' => 200]);
        $employeeQuestions = $this->EmployeeAnswers->EmployeeQuestions->find('list', ['limit' => 200]);
        $clients = $this->EmployeeAnswers->Clients->find('list', ['limit' => 200]);
        $this->set(compact('employeeAnswer', 'employees', 'employeeQuestions', 'clients'));
    }*/

    /**
     * Delete method
     *
     * @param string|null $id Employee Answer id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $employeeAnswer = $this->EmployeeAnswers->get($id);
        if ($this->EmployeeAnswers->delete($employeeAnswer)) {
            $this->Flash->success(__('The employee answer has been deleted.'));
        } else {
            $this->Flash->error(__('The employee answer could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }*/
}
