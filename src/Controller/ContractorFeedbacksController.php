<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;

/**
 * ContractorFeedbacks Controller
 *
 * @property \App\Model\Table\ContractorFeedbacksTable $ContractorFeedbacks
 *
 * @method \App\Model\Entity\ContractorFeedback[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ContractorFeedbacksController extends AppController
{
    public function isAuthorized($user)
    {
    $contractorNav = false;
    if($user['role_id'] == SUPER_ADMIN  || $user['role_id'] == ADMIN || $user['role_id'] == CLIENT || $user['role_id'] == CR || $user['role_id'] == CLIENT_ADMIN || $user['role_id'] == CLIENT_VIEW || $user['role_id'] == CLIENT_BASIC) {
        $contractorNav = true;
    }
    $this->set('contractorNav', $contractorNav);

    if($this->request->getParam('action')=='index') {
        if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN) { 
            return true; 
        }
    }
    if (isset($user['role_id'])) {
        return true;
    }
    // Default deny
    return false;
    }


     public function feedback($contractor_id = null)
    {
        $this->loadModel('FeedbackQuestions');
        $this->loadModel('FeedbackAnswers');
        $contractorFeedback = $this->ContractorFeedbacks->newEntity();
        $feedbackAnswers = $this->FeedbackAnswers->newEntity();
        $questions = $this->FeedbackQuestions
                ->find()                
                ->order(['FeedbackQuestions.id'=>'ASC'])
                ->toArray(); 
        
        if ($this->request->is('post')) { //pr($this->request->getData());
            $contractorFeedback = $this->ContractorFeedbacks->patchEntity($contractorFeedback, $this->request->getData());           
            $contractorFeedback->contractor_id = $contractor_id;
            $feedback_answers = $this->request->getData('feedback_answers');

            foreach ($feedback_answers as $key => $val) { 
                $feedbackAnswers = $this->FeedbackAnswers->newEntity();
                if(isset($val['answer']) && $val['answer']!='' ) { 
                       if(isset($val['answer']) && is_array($val['answer']) ) {            
                            if(in_array('Other', $val['answer'])){
                            $val['answer'][3] = 'Other:'.$val['answer_other'];
                            } 
                        $val['answer'] = implode(',',$val['answer']);                      
                        }                       
                    
                    /*if($val['answer']== 'Other') {
                        $val['answer']='Other: '.$val['answer_other'];
                    }*/
                 }
               $feedbackAnswers->contractor_id =$contractor_id;
               $feedbackAnswers->feedback_question_id = $val['question_id'];
               $feedbackAnswers->answer = $val['answer'];

               $this->FeedbackAnswers->save($feedbackAnswers);
            }

         if ($this->ContractorFeedbacks->save($contractorFeedback)) {
                $this->Flash->success(__('Thank you for your feedback!'));

                if($this->User->isContractor()) {
                    return $this->redirect(['controller'=>'Contractors', 'action' => 'dashboard']);
                exit;
                }
                else {
                    return $this->redirect(['controller'=>'Contractors', 'action' => 'dashboard', $contractor_id]);
                    exit;
                }

                
            }
            //$this->Flash->error(__('Your Feedback could not be saved. Please, try again.'));
        }
        $contractors = $this->ContractorFeedbacks->Contractors->find('list', ['limit' => 200]);
        $this->set(compact('contractorFeedback', 'contractors','questions'));
    }
    public function review($id=null)
    {
    $this->viewBuilder()->setLayout('ajax');

    $contractorFeedbacks = $this->ContractorFeedbacks->get($id, [
            'contain' => []
        ]);

        $this->set(compact('contractorFeedbacks'));
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        // $this->paginate = [
        //     'contain' => ['Contractors']
        // ];
        // $contractorFeedbacks = $this->paginate($this->ContractorFeedbacks);

        $totalCount = $this->ContractorFeedbacks->find('all')->count();
        $this->paginate = [
            'contain'=>['Contractors'],
            'limit'   => $totalCount,
            'maxLimit'=> $totalCount
        ];
        
        $contractorFeedbacks = $this->paginate($this->ContractorFeedbacks);

        $this->set(compact('contractorFeedbacks'));
    }

    /**
     * View method
     *
     * @param string|null $id Contractor Feedback id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->loadModel('FeedbackQuestions');
        $contractorFeedback = $this->ContractorFeedbacks->get($id, [
            'contain' => ['Contractors']
        ]);

        $questions = $this->FeedbackQuestions
        ->find()     
        ->contain(['FeedbackAnswers'=>['conditions'=>['contractor_id'=>$contractorFeedback['contractor_id']] ]]) 
        ->all(); 

        $this->set(compact('contractorFeedback','questions'));      
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    /*public function add()
    {
        $contractorFeedback = $this->ContractorFeedbacks->newEntity();
        if ($this->request->is('post')) {
            $contractorFeedback = $this->ContractorFeedbacks->patchEntity($contractorFeedback, $this->request->getData());
            if ($this->ContractorFeedbacks->save($contractorFeedback)) {
                $this->Flash->success(__('The contractor feedback has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The contractor feedback could not be saved. Please, try again.'));
        }
        $contractors = $this->ContractorFeedbacks->Contractors->find('list', ['limit' => 200]);
        $this->set(compact('contractorFeedback', 'contractors'));
    }*/

    /**
     * Edit method
     *
     * @param string|null $id Contractor Feedback id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function edit($id = null)
    {
        $contractorFeedback = $this->ContractorFeedbacks->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contractorFeedback = $this->ContractorFeedbacks->patchEntity($contractorFeedback, $this->request->getData());
            if ($this->ContractorFeedbacks->save($contractorFeedback)) {
                $this->Flash->success(__('The contractor feedback has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The contractor feedback could not be saved. Please, try again.'));
        }
        $contractors = $this->ContractorFeedbacks->Contractors->find('list', ['limit' => 200]);
        $this->set(compact('contractorFeedback', 'contractors'));
    }*/

    /**
     * Delete method
     *
     * @param string|null $id Contractor Feedback id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $contractorFeedback = $this->ContractorFeedbacks->get($id);
        if ($this->ContractorFeedbacks->delete($contractorFeedback)) {
            $this->Flash->success(__('The contractor feedback has been deleted.'));
        } else {
            $this->Flash->error(__('The contractor feedback could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }*/
   

}
