<?php
namespace App\Controller;
use App\Controller\AppController;

/**
 * CronQuestionUpdates Controller
 *
 * @property \App\Model\Table\CronQuestionUpdatesTable $CronQuestionUpdates
 *
 * @method \App\Model\Entity\CronQuestionUpdate[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CronQuestionUpdatesController extends AppController
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
	//updatePercentage function for Cron job
	public function updatePercentage()
	{
		//ini_set('memory_limit','-1');
		//set_time_limit(300);
		$cronQuestionUpdates = $this->CronQuestionUpdates
		->find('all')
		->select(['id','client_id', 'category_id'])			
		->toArray();
		foreach($cronQuestionUpdates as $cronQuestionUpdate)
		{
			$client_id = $cronQuestionUpdate->client_id;
			$category_id = $cronQuestionUpdate->category_id;				
				
			$result = $this->Percentage->getPercentage($category_id,null,null,$client_id);			
			if($result==true){
				$this->CronQuestionUpdates->query()
				->delete()				
				->where(['client_id'=>$client_id,'category_id'=>$category_id])
				->execute();
			}
		}
		$this->Flash->success(__('The Percentage has been saved.'));	
	}
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    /*public function index()
    {
        $this->paginate = [
            'contain' => ['Clients', 'Categories']
        ];
        $cronQuestionUpdates = $this->paginate($this->CronQuestionUpdates);

        $this->set(compact('cronQuestionUpdates'));
    }*/
	
    /**
     * View method
     *
     * @param string|null $id Cron Question Update id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function view($id = null)
    {
        $cronQuestionUpdate = $this->CronQuestionUpdates->get($id, [
            'contain' => ['Clients', 'Categories']
        ]);

        $this->set('cronQuestionUpdate', $cronQuestionUpdate);
    }*/

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    /*public function add()
    {
        $cronQuestionUpdate = $this->CronQuestionUpdates->newEntity();
        if ($this->request->is('post')) {
            $cronQuestionUpdate = $this->CronQuestionUpdates->patchEntity($cronQuestionUpdate, $this->request->getData());
            if ($this->CronQuestionUpdates->save($cronQuestionUpdate)) {
                $this->Flash->success(__('The cron question update has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cron question update could not be saved. Please, try again.'));
        }
        $clients = $this->CronQuestionUpdates->Clients->find('list', ['limit' => 200]);
        $categories = $this->CronQuestionUpdates->Categories->find('list', ['limit' => 200]);
        $this->set(compact('cronQuestionUpdate', 'clients', 'categories'));
    }*/

    /**
     * Edit method
     *
     * @param string|null $id Cron Question Update id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function edit($id = null)
    {
        $cronQuestionUpdate = $this->CronQuestionUpdates->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cronQuestionUpdate = $this->CronQuestionUpdates->patchEntity($cronQuestionUpdate, $this->request->getData());
            if ($this->CronQuestionUpdates->save($cronQuestionUpdate)) {
                $this->Flash->success(__('The cron question update has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cron question update could not be saved. Please, try again.'));
        }
        $clients = $this->CronQuestionUpdates->Clients->find('list', ['limit' => 200]);
        $categories = $this->CronQuestionUpdates->Categories->find('list', ['limit' => 200]);
        $this->set(compact('cronQuestionUpdate', 'clients', 'categories'));
    }*/

    /**
     * Delete method
     *
     * @param string|null $id Cron Question Update id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
   /* public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $cronQuestionUpdate = $this->CronQuestionUpdates->get($id);
        if ($this->CronQuestionUpdates->delete($cronQuestionUpdate)) {
            $this->Flash->success(__('The cron question update has been deleted.'));
        } else {
            $this->Flash->error(__('The cron question update could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }*/
}
