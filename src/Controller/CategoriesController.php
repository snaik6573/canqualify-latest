<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\View\Helper\BreadcrumbsHelper;
/**
 * Categories Controller
 *
 * @property \App\Model\Table\CategoriesTable $Categories
 *
 * @method \App\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CategoriesController extends AppController
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
	$totalCount = $this->Categories->find('all')->count();								
        $this->paginate = [
            'contain' => ['Services'],
            'limit'=>$totalCount,
            'maxLimit'=>$totalCount
        ];
        $categories = $this->paginate($this->Categories);

	if ($this->request->is(['patch', 'post', 'put'])) {
		$this->viewBuilder()->setLayout('ajax');

		$category = $this->Categories->get($this->request->getData('id'));
		$category = $this->Categories->patchEntity($category, $this->request->getData());
		$category->created_by = $this->getRequest()->getSession()->read('Auth.User.id');		
		if ($this->Categories->save($category)) {
			echo '<div class="alert with-close alert-success alert-dismissible fade show" role="alert">The category has been saved.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
		}
		else {
			echo '<div class="alert with-close alert-danger alert-dismissible fade show" role="alert">The category could not be saved. Please, try again.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
		}
		exit;
	}			
        $this->set(compact('categories'));
    }

    /**
     * View method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $category = $this->Categories->get($id, [
            'contain' => ['Services', 'Questions', 'Questions.QuestionTypes']
        ]);
		$sub_cat = $this->Categories->find()->where(['category_id'=>$id])->contain(['Services'])->toArray();
		//echo "<pre>"; print_r($sub_cat);
		$this->set(compact('category', 'sub_cat'));        
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $category = $this->Categories->newEntity();
        if ($this->request->is('post')) {
            $category = $this->Categories->patchEntity($category, $this->request->getData());
            $category->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('The category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The category could not be saved. Please, try again.'));
        }
        $services = $this->Categories->Services->find('list');
	//$categories = $this->Categories->find('list');
	$categories = $this->Category->getServiceCatgories();
        $this->set(compact('category', 'services', 'categories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $category = $this->Categories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $category = $this->Categories->patchEntity($category, $this->request->getData());
            $category->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');
            if ($this->Categories->save($category)) {
                $this->Flash->success(__('The category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The category could not be saved. Please, try again.'));
        }
        $services = $this->Categories->Services->find('list');
	//$categories = $this->Categories->find('list');
	$categories = $this->Category->getServiceCatgories();
        $this->set(compact('category', 'services', 'categories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $category = $this->Categories->get($id);
        if ($this->Categories->delete($category)) {
            $this->Flash->success(__('The category has been deleted.'));
        } else {
            $this->Flash->error(__('The category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
