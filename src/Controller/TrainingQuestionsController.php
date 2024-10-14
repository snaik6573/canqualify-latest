<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
 
/**
 * TrainingQuestions Controller
 *
 * @property \App\Model\Table\TrainingQuestionsTable $TrainingQuestions
 *
 * @method \App\Model\Entity\TrainingQuestion[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TrainingQuestionsController extends AppController
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
	$totalCount = $this->TrainingQuestions->find('all')->count();
	$this->paginate = [
            'contain' => ['QuestionTypes', 'Trainings', 'Clients'],            
            'limit'=>$totalCount,
            'maxLimit'=>$totalCount
	];

	$trainingQuestions = $this->paginate($this->TrainingQuestions);
	if ($this->request->is(['patch', 'post', 'put'])) {
		$this->viewBuilder()->setLayout('ajax');

		$trainingQuestion = $this->TrainingQuestions->get($this->request->getData('id'));
		if(!empty($trainingQuestion)) {
			$trainingQuestion = $this->TrainingQuestions->patchEntity($trainingQuestion, $this->request->getData());
			$trainingQuestion->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
			if ($this->TrainingQuestions->save($trainingQuestion)) {
				echo '<div class="alert with-close alert-success alert-dismissible fade show" role="alert">The Training Question has been saved.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
			}
			else {
				echo '<div class="alert with-close alert-danger alert-dismissible fade show" role="alert">The Training Question could not be saved. Please, try again.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
			}
		}
		exit;
	}
        $this->set(compact('trainingQuestions'));
    }

    /**
     * View method
     *
     * @param string|null $id Training Question id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $trainingQuestion = $this->TrainingQuestions->get($id, [
            'contain' => ['QuestionTypes', 'Trainings', 'Clients']
        ]);

        $this->set('trainingQuestion', $trainingQuestion);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($training_id=null, $client_id=null)
    {
        $trainingQuestion = $this->TrainingQuestions->newEntity();

        if ($this->request->is('post')) {
            $trainingQuestion = $this->TrainingQuestions->patchEntity($trainingQuestion, $this->request->getData());
            $trainingQuestion->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
            $trainingQuestion->client_id = $client_id;
            if($this->request->getData('question_options')!='') {
                $trainingQuestion->question_options = json_encode(explode("\r\n", $this->request->getData('question_options')));
            }
            if($this->request->getData('correct_answer')!='') {
                $trainingQuestion->correct_answer = json_encode(explode("\r\n", $this->request->getData('correct_answer')));
            }

            if ($this->TrainingQuestions->save($trainingQuestion)) {
                $this->Flash->success(__('The training question has been saved.'));

                return $this->redirect(['controller' => 'Trainings', 'action' => 'view', $training_id]);
            }
            $this->Flash->error(__('The training question could not be saved. Please, try again.'));
        }
        $radiochk = array('radio', 'checkbox', 'input');
        $questionTypes = $this->TrainingQuestions->QuestionTypes->find('list')->where(['name IN'=>$radiochk]);
        $trainings = $this->TrainingQuestions->Trainings->find('list')->where(['trainings.client_id'=>$client_id]);	

        $this->set(compact('trainingQuestion', 'questionTypes', 'trainings', 'training_id'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Training Question id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null, $training_id=null, $client_id=null)
    {
        $trainingQuestion = $this->TrainingQuestions->get($id, [
            'contain' => []
        ]);
	if($trainingQuestion->question_options!='') {
        	$trainingQuestion->question_options = implode("\r\n",json_decode($trainingQuestion['question_options']));
	}

        if ($this->request->is(['patch', 'post', 'put'])) {
            $trainingQuestion = $this->TrainingQuestions->patchEntity($trainingQuestion, $this->request->getData());
            $trainingQuestion->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');
            $trainingQuestion->client_id = $client_id;
            if($this->request->getData('question_options')!='') {
                $trainingQuestion->question_options = json_encode(explode("\r\n", $this->request->getData('question_options')));
            }
            if($this->request->getData('correct_answer')!='') {
                $trainingQuestion->correct_answer = json_encode(explode("\r\n", $this->request->getData('correct_answer')));
            }
            if ($this->TrainingQuestions->save($trainingQuestion)) {
                $this->Flash->success(__('The training question has been saved.'));

                return $this->redirect(['controller' => 'Trainings', 'action' => 'view', $training_id]);
            }
            $this->Flash->error(__('The training question could not be saved. Please, try again.'));
        }
        $radiochk = array('radio', 'checkbox', 'input');
        $questionTypes = $this->TrainingQuestions->QuestionTypes->find('list')->where(['name IN'=>$radiochk]);
        $trainings = $this->TrainingQuestions->Trainings->find('list')->where(['trainings.client_id'=>$client_id]);
        //$clients = $this->TrainingQuestions->Clients->find('list', ['limit' => 200]);

        $this->set(compact('trainingQuestion', 'questionTypes', 'trainings', 'training_id'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Training Question id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $trainingQuestion = $this->TrainingQuestions->get($id);
        if ($this->TrainingQuestions->delete($trainingQuestion)) {
            $this->Flash->success(__('The training question has been deleted.'));
        } else {
            $this->Flash->error(__('The training question could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function questionHelper($id = null, $training_id=null, $client_id=null){
        $trainingQuestion = $this->TrainingQuestions->get($id, [
            'contain' => ['QuestionTypes', 'Trainings', 'Clients']
        ]);
       
        if ($this->request->is(['patch', 'post', 'put'])) {
             $trainingQuestion = $this->TrainingQuestions->patchEntity($trainingQuestion, $this->request->getData());
            $trainingQuestion->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');
            $trainingQuestion->client_id = $client_id;
            if($this->request->getData('question_options')!='') {
                $trainingQuestion->question_options = json_encode(explode("\r\n", $this->request->getData('question_options')));
            }
            if($this->request->getData('correct_answer')!='') {
                $trainingQuestion->correct_answer = json_encode(explode("\r\n", $this->request->getData('correct_answer')));
            }
            if($this->request->getData('data_attribute')!='') {
                $trainingQuestion->data_attribute = json_encode($this->request->getData(['data_attribute']));
            }
            if ($this->TrainingQuestions->save($trainingQuestion)) {
                $this->Flash->success(__('The training question has been saved.'));

                return $this->redirect(['controller' => 'Trainings', 'action' => 'view', $training_id]);
            }
            $this->Flash->error(__('The training question could not be saved. Please, try again.'));
        }

        $this->set('trainingQuestion', $trainingQuestion);
    }
}
