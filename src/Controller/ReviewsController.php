<?php
namespace App\Controller;
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
require_once("../vendor/aws/aws-autoloader.php"); 
use Aws\S3\S3Client;

/**
 * Reviews Controller
 *
 * @property \App\Model\Table\ReviewsTable $Reviews
 *
 * @method \App\Model\Entity\Review[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ReviewsController extends AppController
{
    public function isAuthorized($user)
    {
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
	$this->viewBuilder()->setLayout('ajax');	
	$contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');

        $this->paginate = [
            'contain' => ['Clients', 'Contractors'],
            'conditions' => ['Reviews.contractor_id'=>$contractor_id]
        ];
        $reviews = $this->paginate($this->Reviews);

        $this->set(compact('reviews'));
    }

    /**
     * View method
     *
     * @param string|null $id Review id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $review = $this->Reviews->get($id, [
            'contain' => ['Clients', 'Contractors']
        ]);

        $this->set('review', $review);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {     
	$this->viewBuilder()->setLayout('ajax');
	
        $review = $this->Reviews->newEntity();

	$client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
	$contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');

        if ($this->request->is('post')) {
		$review = $this->Reviews->patchEntity($review, $this->request->getData());
		$review->client_id = $client_id;
		$review->contractor_id = $contractor_id;
		$review->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
		if ($this->Reviews->save($review)) {
			$this->Flash->success(__('The review has been saved.'));
			return $this->redirect(['controller'=>'contractors','action' => 'dashboard', $contractor_id]);
		}
		else {
			$this->Flash->error(__('The review could not be saved. Please, try again.'));
			return $this->redirect(['controller'=>'contractors','action' => 'dashboard', $contractor_id]);
		}
        }

        //$clients = $this->Reviews->Clients->find('list', ['limit' => 200]);
        //$contractors = $this->Reviews->Contractors->find('list', ['limit' => 200]);
        $this->set(compact('review'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Review id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $review = $this->Reviews->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $review = $this->Reviews->patchEntity($review, $this->request->getData());
            $review->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');

            if ($this->Reviews->save($review)) {
                $this->Flash->success(__('The review has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The review could not be saved. Please, try again.'));
        }

        //$clients = $this->Reviews->Clients->find('list', ['limit' => 200]);
        //$contractors = $this->Reviews->Contractors->find('list', ['limit' => 200]);
        $this->set(compact('review'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Review id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $review = $this->Reviews->get($id);
        if ($this->Reviews->delete($review)) {
            $this->Flash->success(__('The review has been deleted.'));
        } else {
            $this->Flash->error(__('The review could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function review($id=null)
    {
	$this->viewBuilder()->setLayout('ajax');

	$review = $this->Reviews->get($id, [
            'contain' => ['Clients', 'Contractors']
        ]);

        $this->set('review', $review);
    }
}
