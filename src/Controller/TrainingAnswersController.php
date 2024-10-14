<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
/**
 * TrainingAnswers Controller
 *
 * @property \App\Model\Table\TrainingAnswersTable $TrainingAnswers
 *
 * @method \App\Model\Entity\TrainingAnswer[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TrainingAnswersController extends AppController
{
    public function isAuthorized($user)
    {
	$contractorNav = false;
	$employeeNav = false;

	if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN || $user['role_id'] == CLIENT) {
		$contractorNav = true;
	}
	$this->set('contractorNav', $contractorNav);

	if($this->request->getParam('action')=='addAnswers') {
		if($user['role_id'] != EMPLOYEE) {
			$employeeNav = true;
		}
        if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN) {
        $clientNav = true;
        $this->set('clientNav', $clientNav);
        }
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
    public function index()
    {
        $this->paginate = [
            'contain' => ['Employees', 'TrainingQuestions']
        ];
        $trainingAnswers = $this->paginate($this->TrainingAnswers);

        $this->set(compact('trainingAnswers'));
    }

    /**
     * View method
     *
     * @param string|null $id Training Answer id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function view($id = null)
    {
        $trainingAnswer = $this->TrainingAnswers->get($id, [
            'contain' => ['Employees', 'TrainingQuestions']
        ]);

        $this->set('trainingAnswer', $trainingAnswer);
    }*/

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    /*public function add()
    {
        $trainingAnswer = $this->TrainingAnswers->newEntity();
        if ($this->request->is('post')) {
            $trainingAnswer = $this->TrainingAnswers->patchEntity($trainingAnswer, $this->request->getData());
            if ($this->TrainingAnswers->save($trainingAnswer)) {
                $this->Flash->success(__('The training answer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The training answer could not be saved. Please, try again.'));
        }
        $employees = $this->TrainingAnswers->Employees->find('list');
        $trainingQuestions = $this->TrainingAnswers->TrainingQuestions->find('list');
        $this->set(compact('trainingAnswer', 'employees', 'trainingQuestions'));
    }*/

    public function addAnswers($service_id=null, $training_id=null, $employee_id=null)
    {
	$this->loadModel('Trainings');
	$this->loadModel('TrainingQuestions');
	$this->loadModel('TrainingPercentages');

	$is_locked = 0;


    if(in_array($this->getRequest()->getSession()->read('Auth.User.role_id'),array(CLIENT_VIEW, CLIENT_BASIC))) {
        $is_locked = 1;
    }
	
	if($employee_id==null) {
		$employee_id = $this->getRequest()->getSession()->read('Auth.User.employee_id');
	}
	else {
		$this->getRequest()->getSession()->write('Auth.User.employee_id', $employee_id);
		$this->set('activeUser', $this->getRequest()->getSession()->read('Auth.User'));
	}

	$trainingAnswer = $this->TrainingAnswers->find('all', ['conditions'=>['employee_id'=>$employee_id]])->toArray();
	if(empty($trainingAnswer)) {
 	       $trainingAnswer = $this->TrainingAnswers->newEntity();
	}
	if ($this->request->is(['patch', 'post', 'put'])) {
		$requestDt = $this->request->getData('training_answers'); 

        if(!empty($requestDt)){
        $v = array();  
		foreach($requestDt as $key=>$val) {
			$val['employee_id'] = $employee_id;
			$val['created_by'] = $this->getRequest()->getSession()->read('Auth.User.id');

			$saveDt = $this->TrainingAnswers->find('all', ['conditions'=>['employee_id'=>$employee_id, 'training_questions_id'=>$val['training_questions_id']]])->first();

			if( isset($val['answer']) && is_array($val['answer']) ) {
                $val['answer'] = json_encode($val['answer']);
            }else{
                if(isset($val['answer'])){
                 $v[0] = $val['answer'];
                 $val['answer'] = json_encode($v);
               }
            }
            
            if(isset($val['answer']) && $val['answer'] == '[""]'){
                if(!empty($val['training_questions_id'] && $val['employee_id'])){
                //delete the record answer
                $this->TrainingAnswers->query()
                    ->delete()              
                    ->where(['training_questions_id'=>$val['training_questions_id'],'employee_id'=>$val['employee_id']])
                    ->execute(); 
                }
           }else{
			if(empty($saveDt)) { // new answer
    			if(isset($val['answer']) && $val['answer']!='' ) {
    				$saveDt = $this->TrainingAnswers->newEntity();
    				$saveDt = $this->TrainingAnswers->patchEntity($saveDt, $val);
    				$this->TrainingAnswers->save($saveDt);					
    			}
			}
			else { // update answer
				$saveDt = $this->TrainingAnswers->patchEntity($saveDt, $val);
				$this->TrainingAnswers->save($saveDt);
			}
           }

		}      
        /* calculate and/or save [ercentage to database*/
		$this->TrainingPercentage->saveTrainingCompletion($employee_id,$training_id);
        $this->Flash->success(__('The training answer has been saved.'));
       }
	}
    	$employee = $this->TrainingAnswers->Employees->find()->where(['id'=>$employee_id])->first();

        $trainingQuestions = $this->TrainingQuestions
		->find()
		->contain(['QuestionTypes'=>['fields'=>['id', 'name']] ])
		->contain(['TrainingAnswers'=>['conditions'=>['employee_id'=>$employee_id]] ])
		->where(['active'=>true, 'training_id'=>$training_id])
		->order(['ques_order'=>'ASC','TrainingQuestions.id'=>'ASC'])
		->all();

	    $training = $this->Trainings->find('all', ['conditions'=>['id'=>$training_id]])->first();
        $ansPerc = 0;

        $getPercentageRecord = $this->TrainingPercentages->find('all')->where(['training_id' => $training_id, 'employee_id' => $employee_id, 'archieved' => false])->first();
        if(!empty($getPercentageRecord->percentage))
        {
            $ansPerc = $getPercentageRecord->percentage;
        }

        $this->set(compact('trainingAnswer', 'employee', 'trainingQuestions', 'training', 'training_id', 'is_locked','service_id', 'ansPerc'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Training Answer id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function edit($id = null)
    {
        $trainingAnswer = $this->TrainingAnswers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $trainingAnswer = $this->TrainingAnswers->patchEntity($trainingAnswer, $this->request->getData());
            if ($this->TrainingAnswers->save($trainingAnswer)) {
                $this->Flash->success(__('The training answer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The training answer could not be saved. Please, try again.'));
        }
        $employees = $this->TrainingAnswers->Employees->find('list', ['limit' => 200]);
        $trainingQuestions = $this->TrainingAnswers->TrainingQuestions->find('list', ['limit' => 200]);
        $this->set(compact('trainingAnswer', 'employees', 'trainingQuestions'));
    }*/

    /**
     * Delete method
     *
     * @param string|null $id Training Answer id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $trainingAnswer = $this->TrainingAnswers->get($id);
        if ($this->TrainingAnswers->delete($trainingAnswer)) {
            $this->Flash->success(__('The training answer has been deleted.'));
        } else {
            $this->Flash->error(__('The training answer could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function setvideoStatus(){
    $this->viewBuilder()->setLayout('ajax');
    $v =  array();
    $employee_id = $this->getRequest()->getSession()->read('Auth.User.employee_id');
    if($data = $this->request->getData());
    $training_answer = $this->TrainingAnswers->find()->where(['employee_id'=>$employee_id,'training_questions_id'=>$data['q_id']])->toArray();
    if($training_answer){ //update 
            exit();
    }else{ // new record
    $trainingAnswers = $this->TrainingAnswers->newEntity();
    $trainingAnswers->employee_id = $employee_id;
    $trainingAnswers->training_questions_id = $data['q_id'];
    $v[0] = $data['answer'];
    $data['answer'] = json_encode($v);
    $trainingAnswers->answer = $data['answer'];
    $trainingAnswers->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
    $this->TrainingAnswers->save($trainingAnswers);   
    }
    }
    public function saveAns(){
        $answers =array();
        $i=0;
       $this->viewBuilder()->setLayout('ajax');
       $employee_id = $this->getRequest()->getSession()->read('Auth.User.employee_id');
       $this->loadModel('TrainingQuestions');
       if ($this->request->is(['patch', 'post', 'put'])) {
            $qid = $this->request->getData('qid');
            $answer = $this->request->getData('answer');
            $answers['answer'] = json_encode($answer);
            $saveDt = $this->TrainingAnswers->find('all', ['conditions'=>['employee_id'=>$employee_id, 'training_questions_id'=>$qid]])->first();
           if($answers['answer'] == "null"){
              //delete the record answer
            $this->TrainingAnswers->query()
                ->delete()              
                ->where(['training_questions_id'=>$qid,'employee_id'=>$employee_id])
                ->execute();
           } 
           if(empty($saveDt) && $answers['answer'] != "null") { // new answer
                    $saveDt = $this->TrainingAnswers->newEntity();
                    $saveDt = $this->TrainingAnswers->patchEntity($saveDt, $answers);
                    $saveDt->employee_id = $employee_id;
                    $saveDt->training_questions_id = $qid;
                    $saveDt->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
                    // pr($saveDt);
                    $this->TrainingAnswers->save($saveDt);                  
            }
            else { // update answer
                $saveDt = $this->TrainingAnswers->patchEntity($saveDt, $answers);
                 // pr($saveDt );die;
                $this->TrainingAnswers->save($saveDt);
            }
            $this->Flash->success(__('The training answer has been saved.'));
        }
    }
    /* function showMessage(){
        $v ="";
       $this->viewBuilder()->setLayout('ajax');
       $this->loadModel('TrainingQuestions');
       if ($this->request->is(['patch', 'post', 'put'])) {
       $qid = $this->request->getData('qid');
       $attribute = $this->request->getData('data_attr');
       $data_attribute = $this->TrainingQuestions->find()->select(['data_attribute'])->where(['id'=>$qid])->toArray();
       if(!empty($attribute)){
        foreach ($data_attribute as $key => $data) {
            $dataAttr  = json_decode($data->data_attribute); // form database 
             // pr($dataAttr);
             // pr($attribute);
            if(!empty($dataAttr)){
             foreach ($dataAttr as $key => $value) {
                // pr($key); pr($attribute);
                  if($attribute == $key){
                        $v = $value;     
                  }
              }
            }           
        }
        echo $v;
        exit(0);
       }

    }
    }*/
}
