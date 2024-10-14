<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\MailerAwareTrait; 

/**
 * ContractorRequests Controller
 *
 * @property \App\Model\Table\ContractorRequestsTable $ContractorRequests
 *
 * @method \App\Model\Entity\ContractorRequest[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ContractorRequestsController extends AppController
{
    use MailerAwareTrait;
    public function isAuthorized($user)
    {
     if($this->request->getParam('action')=='index'|| $this->request->getParam('action')=='view') {
        if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN || $user['role_id'] == CONTRACTOR || $user['role_id'] == CONTRACTOR_ADMIN) {
            $contractorNav = true;
            $this->set('contractorNav', $contractorNav);
        }
    }
    else {
        $employeeNav = false;
        if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN || $user['role_id'] == CR) {
            $employeeNav = true;
        }
        $this->set('employeeNav', $employeeNav);
    }

    if (isset($user['role_id'])) {
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
    $employee_id = $this->getRequest()->getSession()->read('Auth.User.employee_id');
    $contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
    $totalCount = $this->ContractorRequests->find('all')->count();                              
        $this->paginate = [
        'conditions' => ['OR'=>['employee_id'=>$employee_id,'contractor_id'=>$contractor_id]],
            'contain' => ['Employees', 'Contractors'],
            'limit'=>$totalCount,
            'maxLimit'=>$totalCount
        ];
        $contractorRequests = $this->paginate($this->ContractorRequests);

        $this->set(compact('contractorRequests'));
    }

    /**
     * View method
     *
     * @param string|null $id Contractor Request id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $contractorRequest = $this->ContractorRequests->get($id, [
            'contain' => ['Contractors', 'Employees']
        ]);

        $this->set('contractorRequest', $contractorRequest);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */

      /* send request to Employee */
    public function add($employee_id=null, $contractor_id=null)
    {
        $this->loadModel('Contractor');
        $this->viewBuilder()->setLayout('ajax');
    
        if($contractor_id == null)  {
            $contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
        }
        $contractor = $this->ContractorRequests->Contractors->get($contractor_id, [
                'contain'=>['Users']
        ]);
        $employee = $this->ContractorRequests->Employees->get($employee_id, [
                'contain'=>['Users']
        ]);

        $contractorRequest = $this->ContractorRequests->newEntity();
        if ($this->request->is('post')) {
            $contractorRequest = $this->ContractorRequests->patchEntity($contractorRequest, $this->request->getData());
            $contractorRequest->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
            $contractorRequest->contractor_id = $contractor_id;
            $contractorRequest->employee_id = $employee_id;
            $contractorRequest->status = 1;

            if ($this->ContractorRequests->save($contractorRequest)) {
                $this->Flash->success(__('The contractor request has been sent.'));
                if($employee->user_entered_email == true)  {          
                 $this->getMailer('User')->send('send_emp_request', [$employee, $this->request->getData()]);
                }               
            }
            else {
                $this->Flash->error(__('The contractor request could not be saved. Please, try again.'));
            }
        }
       
        $this->set(compact('contractorRequest','contractor','employee'));
    }





   /* public function add()
    {
        $contractorRequest = $this->ContractorRequests->newEntity();
        if ($this->request->is('post')) {
            $contractorRequest = $this->ContractorRequests->patchEntity($contractorRequest, $this->request->getData());
            if ($this->ContractorRequests->save($contractorRequest)) {
                $this->Flash->success(__('The contractor request has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The contractor request could not be saved. Please, try again.'));
        }
        $contractors = $this->ContractorRequests->Contractors->find('list', ['limit' => 200]);
        $employees = $this->ContractorRequests->Employees->find('list', ['limit' => 200]);
        $this->set(compact('contractorRequest', 'contractors', 'employees'));
    }*/

    /**
     * Edit method
     *
     * @param string|null $id Contractor Request id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
   /* public function edit($id = null)
    {
        $contractorRequest = $this->ContractorRequests->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contractorRequest = $this->ContractorRequests->patchEntity($contractorRequest, $this->request->getData());
            if ($this->ContractorRequests->save($contractorRequest)) {
                $this->Flash->success(__('The contractor request has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The contractor request could not be saved. Please, try again.'));
        }
        $contractors = $this->ContractorRequests->Contractors->find('list', ['limit' => 200]);
        $employees = $this->ContractorRequests->Employees->find('list', ['limit' => 200]);
        $this->set(compact('contractorRequest', 'contractors', 'employees'));
    }*/

    /**
     * Delete method
     *
     * @param string|null $id Contractor Request id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $contractorRequest = $this->ContractorRequests->get($id);
        if ($this->ContractorRequests->delete($contractorRequest)) {
            $this->Flash->success(__('The contractor request has been deleted.'));
        } else {
            $this->Flash->error(__('The contractor request could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
