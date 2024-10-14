<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * FeedbackAnswers Controller
 *
 * @property \App\Model\Table\FeedbackAnswersTable $FeedbackAnswers
 *
 * @method \App\Model\Entity\FeedbackAnswer[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FeedbackAnswersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Contractors', 'FeedbackQuestions']
        ];
        $feedbackAnswers = $this->paginate($this->FeedbackAnswers);

        $this->set(compact('feedbackAnswers'));
    }

    /**
     * View method
     *
     * @param string|null $id Feedback Answer id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $feedbackAnswer = $this->FeedbackAnswers->get($id, [
            'contain' => ['Contractors', 'FeedbackQuestions']
        ]);

        $this->set('feedbackAnswer', $feedbackAnswer);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $feedbackAnswer = $this->FeedbackAnswers->newEntity();
        if ($this->request->is('post')) {
            $feedbackAnswer = $this->FeedbackAnswers->patchEntity($feedbackAnswer, $this->request->getData());
            if ($this->FeedbackAnswers->save($feedbackAnswer)) {
                $this->Flash->success(__('The feedback answer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The feedback answer could not be saved. Please, try again.'));
        }
        $contractors = $this->FeedbackAnswers->Contractors->find('list', ['limit' => 200]);
        $feedbackQuestions = $this->FeedbackAnswers->FeedbackQuestions->find('list', ['limit' => 200]);
        $this->set(compact('feedbackAnswer', 'contractors', 'feedbackQuestions'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Feedback Answer id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $feedbackAnswer = $this->FeedbackAnswers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $feedbackAnswer = $this->FeedbackAnswers->patchEntity($feedbackAnswer, $this->request->getData());
            if ($this->FeedbackAnswers->save($feedbackAnswer)) {
                $this->Flash->success(__('The feedback answer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The feedback answer could not be saved. Please, try again.'));
        }
        $contractors = $this->FeedbackAnswers->Contractors->find('list', ['limit' => 200]);
        $feedbackQuestions = $this->FeedbackAnswers->FeedbackQuestions->find('list', ['limit' => 200]);
        $this->set(compact('feedbackAnswer', 'contractors', 'feedbackQuestions'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Feedback Answer id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $feedbackAnswer = $this->FeedbackAnswers->get($id);
        if ($this->FeedbackAnswers->delete($feedbackAnswer)) {
            $this->Flash->success(__('The feedback answer has been deleted.'));
        } else {
            $this->Flash->error(__('The feedback answer could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
