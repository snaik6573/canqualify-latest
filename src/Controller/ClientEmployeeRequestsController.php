<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\MailerAwareTrait; 

/**
 * ClientEmployeeRequests Controller
 *
 * @property \App\Model\Table\ClientEmployeeRequestsTable $ClientEmployeeRequests
 *
 * @method \App\Model\Entity\ClientEmployeeRequest[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ClientEmployeeRequestsController extends AppController
{
   use MailerAwareTrait;

    public function isAuthorized($user)
    {

    if($this->request->getParam('action')=='index'|| $this->request->getParam('action')=='view') {
        if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN || $user['role_id'] == CLIENT || $user['role_id'] == CLIENT_ADMIN || $user['role_id'] == CLIENT_VIEW || $user['role_id'] == CLIENT_BASIC) {
            $clientNav = true;
            $this->set('clientNav', $clientNav);
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
    $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
    $totalCount = $this->ClientEmployeeRequests->find('all')->count();                              
        $this->paginate = [
        'conditions' => ['OR'=>['employee_id'=>$employee_id,'client_id'=>$client_id]],
            'contain' => ['Employees', 'Clients'],
            'limit'=>$totalCount,
            'maxLimit'=>$totalCount
        ];
        $clientEmployeeRequests = $this->paginate($this->ClientEmployeeRequests);

        $this->set(compact('clientEmployeeRequests'));
    }

   /* public function index()
    {
        $this->paginate = [
            'contain' => ['Clients', 'Employees']
        ];
        $clientEmployeeRequests = $this->paginate($this->ClientEmployeeRequests);

        $this->set(compact('clientEmployeeRequests'));
    }*/


    /**
     * View method
     *
     * @param string|null $id Client Employee Request id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $clientEmployeeRequest = $this->ClientEmployeeRequests->get($id, [
            'contain' => ['Clients', 'Employees']
        ]);

        $this->set('clientEmployeeRequest', $clientEmployeeRequest);
    }


     /* send request to Employee */
    public function add($employee_id=null, $client_id=null)
    {
        $this->loadModel('Clients');
        $this->viewBuilder()->setLayout('ajax');
    
        if($client_id == null)  {
            $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
        }       
        $client = $this->Clients->get($client_id, [
               'contain'=>[]
        ]);
        $employee = $this->ClientEmployeeRequests->Employees->get($employee_id, [
                'contain'=>['Users']
        ]);

        $clientEmployeeRequest = $this->ClientEmployeeRequests->newEntity();
        if ($this->request->is('post')) {
            $clientEmployeeRequest = $this->ClientEmployeeRequests->patchEntity($clientEmployeeRequest, $this->request->getData());
            $clientEmployeeRequest->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
            $clientEmployeeRequest->client_id = $client_id;
            $clientEmployeeRequest->employee_id = $employee_id;
            $clientEmployeeRequest->status = 1;

            if ($this->ClientEmployeeRequests->save($clientEmployeeRequest)) {
                $this->Flash->success(__('The client request has been sent.'));
                if($employee->user_entered_email == true)  {          
                 $this->getMailer('User')->send('send_emp_request', [$employee, $this->request->getData()]);
                }               
            }
            else {
                $this->Flash->error(__('The client request could not be saved. Please, try again.'));
            }
        }
       
        $this->set(compact('clientEmployeeRequest','client','employee'));
    }
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    /*public function add()
    {
        $clientEmployeeRequest = $this->ClientEmployeeRequests->newEntity();
        if ($this->request->is('post')) {
            $clientEmployeeRequest = $this->ClientEmployeeRequests->patchEntity($clientEmployeeRequest, $this->request->getData());
            if ($this->ClientEmployeeRequests->save($clientEmployeeRequest)) {
                $this->Flash->success(__('The client employee request has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The client employee request could not be saved. Please, try again.'));
        }
        $clients = $this->ClientEmployeeRequests->Clients->find('list', ['limit' => 200]);
        $employees = $this->ClientEmployeeRequests->Employees->find('list', ['limit' => 200]);
        $this->set(compact('clientEmployeeRequest', 'clients', 'employees'));
    }*/

    /**
     * Edit method
     *
     * @param string|null $id Client Employee Request id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $clientEmployeeRequest = $this->ClientEmployeeRequests->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $clientEmployeeRequest = $this->ClientEmployeeRequests->patchEntity($clientEmployeeRequest, $this->request->getData());
            if ($this->ClientEmployeeRequests->save($clientEmployeeRequest)) {
                $this->Flash->success(__('The client employee request has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The client employee request could not be saved. Please, try again.'));
        }
        $clients = $this->ClientEmployeeRequests->Clients->find('list', ['limit' => 200]);
        $employees = $this->ClientEmployeeRequests->Employees->find('list', ['limit' => 200]);
        $this->set(compact('clientEmployeeRequest', 'clients', 'employees'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Client Employee Request id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $clientEmployeeRequest = $this->ClientEmployeeRequests->get($id);
        if ($this->ClientEmployeeRequests->delete($clientEmployeeRequest)) {
            $this->Flash->success(__('The client employee request has been deleted.'));
        } else {
            $this->Flash->error(__('The client employee request could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
