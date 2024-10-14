<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\Helper\BreadcrumbsHelper;
/**
 * ClientQuestions Controller
 *
 * @property \App\Model\Table\ClientQuestionsTable $ClientQuestions
 *
 * @method \App\Model\Entity\ClientQuestion[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ClientQuestionsController extends AppController
{
    public function isAuthorized($user)
    {
	$clientNav = false;
	if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN) {
		$clientNav = true;
	}
	$this->set('clientNav', $clientNav);

	if (isset($user['role_id']) && $user['active'] == 1) {
		if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN || $user['role_id'] == CLIENT) {
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
    /*public function index()
    {
	$client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');

        $this->paginate = [
            'contain' => ['Clients', 'Questions', 'Questions.Categories'],
	    'conditions' => ['client_id'=>$client_id]
        ];
        $clientQuestions = $this->paginate($this->ClientQuestions);

        $this->set(compact('clientQuestions'));
    }*/

    /**
     * View method
     *
     * @param string|null $id Client Question id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function view($id = null)
    {
	$client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');

        $clientQuestion = $this->ClientQuestions->get($id, [
            'contain' => ['Clients', 'Questions']
        ]);

        $this->set(compact('clientQuestion'));
    }*/

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    /*public function add()
    {
	$this->loadModel('ClientServices');

	$client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');

        $clientQuestion = $this->ClientQuestions->newEntity();
        if ($this->request->is('post')) {
            $clientQuestion = $this->ClientQuestions->patchEntity($clientQuestion, $this->request->getData());

            $clientQuestion->client_id = $client_id;
            $clientQuestion->created_by = $this->getRequest()->getSession()->read('Auth.User.id');

            if ($this->ClientQuestions->save($clientQuestion)) {
                $this->Flash->success(__('The client question has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The client question could not be saved. Please, try again.'));
        }
        //$clients = $this->ClientQuestions->Clients->find('list');
        //$questions = $this->ClientQuestions->Questions->find('list', ['keyField'=>'id', 'valueField'=>'question']);

        $clientServices = $this->ClientServices
	->find()
	->contain(['Services'=>['fields'=>['id', 'name']]])
	->contain(['Services.Categories'=>['conditions'=>['Categories.active'=>true], 'fields'=>['id', 'name', 'category_id', 'service_id'], 'sort' => ['id' => 'ASC']]])
	->contain(['Services.Categories.Questions'=> ['conditions'=>['Questions.active'=>true], 'fields'=>['id', 'question', 'category_id']]])
	->where(['ClientServices.client_id'=>$client_id, 'Services.active'=>true])	
	->toArray();

	$questions = array();
	$categories = array();
	foreach ($clientServices as $cl) {
		foreach ($cl->service->categories as $cat) {
			$categories[$cat->id] = $cat->category_id!='' ? $categories[$cat->category_id] .' : '. $cat->name : $cat->name;
			foreach ($cat->questions as $question) {
				$questions[$categories[$cat->id]][$question->id] = $question->question;
			}
		}
	}
        $this->set(compact('clientQuestion', 'questions', 'clientServices'));
    }*/

    /**
     * Edit method
     *
     * @param string|null $id Client Question id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function edit($id = null)
    {
	$this->loadModel('ClientServices');

	$client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');

        $clientQuestion = $this->ClientQuestions->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $clientQuestion = $this->ClientQuestions->patchEntity($clientQuestion, $this->request->getData());

            $clientQuestion->client_id = $client_id;
            $clientQuestion->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');

            if ($this->ClientQuestions->save($clientQuestion)) {
                $this->Flash->success(__('The client question has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The client question could not be saved. Please, try again.'));
        }
        //$clients = $this->ClientQuestions->Clients->find('list');
        //$questions = $this->ClientQuestions->Questions->find('list', ['keyField'=>'id', 'valueField'=>'question']);

       $clientServices = $this->ClientServices
	->find()
	->contain(['Services'=>['fields'=>['id', 'name']]])
	->contain(['Services.Categories'=>['conditions'=>['Categories.active'=>true], 'fields'=>['id', 'name', 'category_id', 'service_id'], 'sort' => ['id' => 'ASC']]])
	->contain(['Services.Categories.Questions'=> ['conditions'=>['Questions.active'=>true], 'fields'=>['id', 'question', 'category_id']]])
	->where(['ClientServices.client_id'=>$client_id, 'Services.active'=>true])	
	->toArray();

	$questions = array();
	$categories = array();
	foreach ($clientServices as $cl) {
		foreach ($cl->service->categories as $cat) {
			$categories[$cat->id] = $cat->category_id!='' ? $categories[$cat->category_id] .' : '. $cat->name : $cat->name;
			foreach ($cat->questions as $question) {
				$questions[$categories[$cat->id]][$question->id] = $question->question;
			}
		}
	}

        $this->set(compact('clientQuestion', 'questions'));
    }*/

    /**
     * Delete method
     *
     * @param string|null $id Client Question id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $clientQuestion = $this->ClientQuestions->get($id);
        if ($this->ClientQuestions->delete($clientQuestion)) {
            $this->Flash->success(__('The client question has been deleted.'));
        } else {
            $this->Flash->error(__('The client question could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }*/
}
