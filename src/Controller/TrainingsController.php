<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
/**
 * Trainings Controller
 *
 * @property \App\Model\Table\TrainingsTable $Trainings
 *
 * @method \App\Model\Entity\Training[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TrainingsController extends AppController
{
    public function isAuthorized($user)
    {
	/*$clientNav = false;
	if($user['role'] == 'Admin') {
		$clientNav = true;
	}
	$this->set('clientNav', $clientNav);*/
    $clientNav = false;
    if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN) {
        $clientNav = true;
    }
    $this->set('clientNav', $clientNav);

	// Admin can access every action
	if (isset($user['role_id']) && $user['active'] == 1) {
		if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN || $user['role_id'] == CLIENT || $user['role_id'] == CLIENT_ADMIN || $user['role_id'] == CLIENT_VIEW) {
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
		$where = [];
        if($this->User->isClient()) {
            $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');  

            $where = ['Trainings.client_id'=>$client_id];
        }
        if($this->User->isAdmin()) {
           $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');           
          if(!empty($client_id)){
            $where = ['Trainings.client_id'=>$client_id];           
           }else{
             $where = '';
           }
        } 
        
		$totalCount = $this->Trainings->find('all')->count();								        				
        $this->paginate = [
            'contain' => ['Categories', 'Clients'],			
			'limit'=>$totalCount,
            'maxLimit'=>$totalCount,
            'conditions' => $where
        ];
        $trainings = $this->paginate($this->Trainings);
		
		if ($this->request->is(['patch', 'post', 'put'])) {
		$this->viewBuilder()->setLayout('ajax');
		$training = $this->Trainings->get($this->request->getData('id'));
		$training = $this->Trainings->patchEntity($training, $this->request->getData());
		$training->created_by = $this->getRequest()->getSession()->read('Auth.User.id');		
		if ($this->Trainings->save($training)) {
			echo '<div class="alert with-close alert-success alert-dismissible fade show" role="alert">The Training has been saved.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
		}
		else {
			echo '<div class="alert with-close alert-danger alert-dismissible fade show" role="alert">The Training could not be saved. Please, try again.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
		}
		exit;
	}
        $this->set(compact('trainings'));
    }

    /**
     * View method
     *
     * @param string|null $id Training id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
	$this->loadModel('Sites');
        $training = $this->Trainings->get($id, [
            'contain' => ['Categories', 'Clients', 'TrainingQuestions']
        ]);

	$sitesAssigned = array();
	if(!empty($training->site_ids)) {
		$sitesAssigned = $this->Sites->find('list', ['keyField'=>'id', 'valueField'=>'name'])->where(['id IN'=>$training->site_ids['s_ids']])->toArray();
	}	
        $this->set(compact('training', 'sitesAssigned'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($client_id=null)
    {
		$this->loadModel('Sites');
		$this->loadModel('Clients');
        $this->loadModel('TrainingQuestions');
		
        if($this->User->isClient()) {
            $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
        }

        $training = $this->Trainings->newEntity();	    
		$userId = $this->getRequest()->getSession()->read('Auth.User.id');

        if ($this->request->is(['patch', 'post', 'put'])) {
		    if($this->request->getData('current_client_id')!==null) {
			    $client_id = $this->request->getData('current_client_id');
	            return $this->redirect(['action' => 'add', $client_id]);
		    }
            $training = $this->Trainings->patchEntity($training, $this->request->getData());

            $training->client_id = $client_id;
            $training->site_ids = ['s_ids' => $training->site_ids];
            $training->created_by = $userId;
           
            if ($res = $this->Trainings->save($training)) {
             
                if(!empty($training->traning_video)){
                $trainingQuestion = $this->TrainingQuestions->newEntity();
                $trainingQuestion->question = "Are you sure, watched your training video complete ? (Need to watch video complete this Question)";
                $trainingQuestion->question_type_id = 1;
                $trainingQuestion->training_id =  $res->id;
                $trainingQuestion->client_id = $res->client_id;
                $trainingQuestion->active = true;
                $trainingQuestion->is_video = true;
                $trainingQuestion->ques_order = 1;
                $trainingQuestion->correct_answer =json_encode(["complete"]);
                $trainingQuestion->created_by = $userId;
                $this->TrainingQuestions->save($trainingQuestion);
               }	
                $this->Flash->success(__('The training has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The training could not be saved. Please, try again.'));
        }

        /*if($client_id!=0) {
		    $client = $this->Clients->find('all')->where(['id'=>$client_id])->first();
		    $this->set(compact('client'));
		}*/

		if($client_id!=null) {
            $client = $this->Clients->find('all')->where(['id'=>$client_id])->first();
            $sites = $this->Sites->find('list', ['keyField'=>'id', 'valueField'=>'name'])->where(['client_id'=>$client_id])->toArray();
    		$trainings = $this->Trainings->find('list')->where(['client_id'=>$client_id, 'is_parent'=>true]);
	    	$this->set(compact('trainings', 'sites','client'));
		}
		$clients = $this->Clients->find('list', ['keyField'=>'id', 'valueField'=>'company_name'])->toArray();
        $this->set(compact('training', 'clients'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Training id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {		
		$this->loadModel('Sites');
        $this->loadModel('TrainingQuestions');
        $this->loadModel('TrainingAnswers');      
        $userId = $this->getRequest()->getSession()->read('Auth.User.id');
        $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
        $training = $this->Trainings->get($id, [
            'contain' => ['TrainingQuestions']
        ]);
        $tempAns = array();
        if ($this->request->is(['patch', 'post', 'put'])) {
             foreach ($training->training_questions as $key => $value) {
             if(!strcmp($value->question,"Are you sure, watched your training video complete ? (Need to watch video complete this Question)")){
            $ans = $this->TrainingQuestions->TrainingAnswers->find()->where(['training_questions_id'=>$value->id])->toArray();
            $tempAns =$ans;       
             /* Delete ans along with question */
              $this->TrainingQuestions->TrainingAnswers->query()
                      ->delete()  
                      ->where(['training_questions_id' => $value->id])
                      ->execute();
              $this->TrainingQuestions->query()
                      ->delete()  
                      ->where(['id' => $value->id])
                      ->execute();
             }
            }  
         
            $training = $this->Trainings->patchEntity($training, $this->request->getData());            
            $training->site_ids = ['s_ids' => $training->site_ids];
            $training->modified_by = $userId;
   
            if ($res = $this->Trainings->save($training)) {
                if(!empty($training->traning_video)){
                $trainingQuestion = $this->TrainingQuestions->newEntity();
                $trainingQuestion->question = "Are you sure, watched your training video complete ? (Need to watch video complete this Question)";
                $trainingQuestion->question_type_id = 1;
                $trainingQuestion->training_id =  $res->id;
                $trainingQuestion->client_id = $client_id;
                $trainingQuestion->active = true;
                $trainingQuestion->is_video = true;
                $trainingQuestion->ques_order = 1;
                $trainingQuestion->correct_answer =json_encode(["complete"]);
                $trainingQuestion->created_by = $userId;          
                $result = $this->TrainingQuestions->save($trainingQuestion);
                if($tempAns){
                foreach ($tempAns as  $ans) {
                $training_answer = $this->TrainingAnswers->newEntity();
                $training_answer = $this->TrainingAnswers->patchEntity($training_answer,$tempAns);
                $training_answer->employee_id = $ans->employee_id;
                $training_answer->answer =  $ans->answer;
                $training_answer->training_questions_id= $result->id;
                $training_answer->created_by = $userId;

                $this->TrainingAnswers->save($training_answer);   
                }                        
                }            
               }
                $this->Flash->success(__('The training has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The training could not be saved. Please, try again.'));
        }
        $sites = $this->Sites->find('list', ['keyField'=>'id', 'valueField'=>'name'])->where(['client_id'=>$training->client_id])->toArray();

        $trainings = $this->Trainings->find('list')->where(['id !='=>$training->id, 'client_id'=>$training->client_id, 'is_parent'=>true]);
        $this->set(compact('training', 'trainings', 'sites'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Training id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $training = $this->Trainings->get($id);
        if ($this->Trainings->delete($training)) {
            $this->Flash->success(__('The training has been deleted.'));
        } else {
            $this->Flash->error(__('The training could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
