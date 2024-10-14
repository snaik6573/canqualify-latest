<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CronClientAdd Controller
 *
 * @property \App\Model\Table\CronClientAddTable $CronClientAdd
 *
 * @method \App\Model\Entity\CronClientAdd[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CronClientAddController extends AppController
{
    public function isAuthorized($user)
    {
    // Admin can access every action
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
        $this->paginate = [
            'contain' => ['Contractors', 'Clients']
        ];
        $cronClientAdd = $this->paginate($this->CronClientAdd);

        $this->set(compact('cronClientAdd'));
    }

    /**
     * View method
     *
     * @param string|null $id Cron Client Add id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $cronClientAdd = $this->CronClientAdd->get($id, [
            'contain' => ['Contractors', 'Clients']
        ]);

        $this->set('cronClientAdd', $cronClientAdd);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $cronClientAdd = $this->CronClientAdd->newEntity();
        if ($this->request->is('post')) {
            $cronClientAdd = $this->CronClientAdd->patchEntity($cronClientAdd, $this->request->getData());
            if ($this->CronClientAdd->save($cronClientAdd)) {
                $this->Flash->success(__('The cron client add has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cron client add could not be saved. Please, try again.'));
        }
        $contractors = $this->CronClientAdd->Contractors->find('list', ['limit' => 200]);
        $clients = $this->CronClientAdd->Clients->find('list', ['limit' => 200]);
        $this->set(compact('cronClientAdd', 'contractors', 'clients'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Cron Client Add id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $cronClientAdd = $this->CronClientAdd->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cronClientAdd = $this->CronClientAdd->patchEntity($cronClientAdd, $this->request->getData());
            if ($this->CronClientAdd->save($cronClientAdd)) {
                $this->Flash->success(__('The cron client add has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cron client add could not be saved. Please, try again.'));
        }
        $contractors = $this->CronClientAdd->Contractors->find('list', ['limit' => 200]);
        $clients = $this->CronClientAdd->Clients->find('list', ['limit' => 200]);
        $this->set(compact('cronClientAdd', 'contractors', 'clients'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Cron Client Add id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $cronClientAdd = $this->CronClientAdd->get($id);
        if ($this->CronClientAdd->delete($cronClientAdd)) {
            $this->Flash->success(__('The cron client add has been deleted.'));
        } else {
            $this->Flash->error(__('The cron client add could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function clientAdd(){
        $this->loadModel('CronClientAdd');
        $this->loadModel('ContractorAnswers');
        $contractors = $this->CronClientAdd->find()->toArray();
        $category_id =0;
        $contractor_id=0;
        $year= 0;
        foreach ($contractors as $cont) {            
            $category = $this->ContractorAnswers->find()
                ->select(['id','year'])
                ->contain(['questions'=> ['fields'=> ['id', 'category_id']] ])
                ->where(['contractor_id'=>$cont['contractor_id']])
                ->enableHydration(false)
                ->toArray();  
                $contractor_id = $cont['contractor_id'];
            foreach ($category as $key => $cat) {               
                $category_id = $cat['Questions']['category_id'];
                $year = $cat['year'];
                $this->Percentage->getPercentage($category_id,$contractor_id,$year);
                $this->CronClientAdd->query()
                ->delete()              
                ->where(['contractor_id'=>$contractor_id])
                ->execute();
            }       
        }
    }
}
