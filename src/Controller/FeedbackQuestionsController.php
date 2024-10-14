<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * FeedbackQuestions Controller
 *
 * @property \App\Model\Table\FeedbackQuestionsTable $FeedbackQuestions
 *
 * @method \App\Model\Entity\FeedbackQuestion[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FeedbackQuestionsController extends AppController
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
        $feedbackQuestions = $this->paginate($this->FeedbackQuestions);

        $this->set(compact('feedbackQuestions'));
    }

    /**
     * View method
     *
     * @param string|null $id Feedback Question id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $feedbackQuestion = $this->FeedbackQuestions->get($id, [
            'contain' => ['FeedbackAnswers']
        ]);

        $this->set('feedbackQuestion', $feedbackQuestion);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $feedbackQuestion = $this->FeedbackQuestions->newEntity();
        if ($this->request->is('post')) {
            $feedbackQuestion = $this->FeedbackQuestions->patchEntity($feedbackQuestion, $this->request->getData());
            $feedbackQuestion->question_options = json_encode(explode("\r\n", $this->request->getData('question_options')));
            if ($this->FeedbackQuestions->save($feedbackQuestion)) {
                $this->Flash->success(__('The feedback question has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The feedback question could not be saved. Please, try again.'));
        }
        $this->set(compact('feedbackQuestion'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Feedback Question id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $feedbackQuestion = $this->FeedbackQuestions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $feedbackQuestion = $this->FeedbackQuestions->patchEntity($feedbackQuestion, $this->request->getData());
            if ($this->FeedbackQuestions->save($feedbackQuestion)) {
                $this->Flash->success(__('The feedback question has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The feedback question could not be saved. Please, try again.'));
        }
        $this->set(compact('feedbackQuestion'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Feedback Question id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $feedbackQuestion = $this->FeedbackQuestions->get($id);
        if ($this->FeedbackQuestions->delete($feedbackQuestion)) {
            $this->Flash->success(__('The feedback question has been deleted.'));
        } else {
            $this->Flash->error(__('The feedback question could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
