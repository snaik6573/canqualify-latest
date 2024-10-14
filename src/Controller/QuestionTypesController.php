<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;

/**
 * QuestionTypes Controller
 *
 * @property \App\Model\Table\QuestionTypesTable $QuestionTypes
 *
 * @method \App\Model\Entity\QuestionType[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class QuestionTypesController extends AppController
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
		$totalCount = $this->QuestionTypes->find('all')->count();		
		$this->paginate = [	
			'contain' => [],		
			'limit' => $totalCount,
			'maxLimit'=> $totalCount
		];
        $questionTypes = $this->paginate($this->QuestionTypes);
        $this->set(compact('questionTypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Question Type id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $questionType = $this->QuestionTypes->get($id, [
            'contain' => ['Questions', 'Questions.Categories']
        ]);

        $this->set('questionType', $questionType);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $questionType = $this->QuestionTypes->newEntity();
        if ($this->request->is('post')) {
            $questionType = $this->QuestionTypes->patchEntity($questionType, $this->request->getData());
            $questionType->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
            if ($this->QuestionTypes->save($questionType)) {
                $this->Flash->success(__('The question type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The question type could not be saved. Please, try again.'));
        }
        $this->set(compact('questionType'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Question Type id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $questionType = $this->QuestionTypes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $questionType = $this->QuestionTypes->patchEntity($questionType, $this->request->getData());
            $questionType->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');
            if ($this->QuestionTypes->save($questionType)) {
                $this->Flash->success(__('The question type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The question type could not be saved. Please, try again.'));
        }
        $this->set(compact('questionType'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Question Type id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $questionType = $this->QuestionTypes->get($id);
        if ($this->QuestionTypes->delete($questionType)) {
            $this->Flash->success(__('The question type has been deleted.'));
        } else {
            $this->Flash->error(__('The question type could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
