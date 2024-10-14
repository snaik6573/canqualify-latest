<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;

/**
 * EmployeeContractors Controller
 *
 * @property \App\Model\Table\EmployeeContractorsTable $EmployeeContractors
 *
 * @method \App\Model\Entity\EmployeeContractor[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmployeeContractorsController extends AppController
{
    public function isAuthorized($user)
    {
    if (isset($user['role_id'])) {
        return true;
    }
    // Default deny
    return false;
    }

     public function acceptRequest($contractor_id = null)
    {
        $this->autoRender = false;
        $this->loadModel('ContractorRequests');
        $employee_id = $this->getRequest()->getSession()->read('Auth.User.employee_id');
        if(!empty($contractor_id && $employee_id)){
            $employeeContractor = $this->EmployeeContractors->newEntity();
            $employeeContractor->employee_id = $employee_id;
            $employeeContractor->contractor_id = $contractor_id;
             
            $employeeContractor->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
            if ($this->EmployeeContractors->save($employeeContractor)) {
                $this->Flash->success(__("Thank you for accepting the contractor's request. Now you are associated with that contractor."));
                
                $this->ContractorRequests->query()
                    ->update()
                    ->set(['status'=>2])
                    ->where(['status'=>1, 'contractor_id'=>$contractor_id, 'employee_id'=>$employee_id])
                    ->execute();
                $this->getRequest()->getSession()->write('Auth.User.contractor_id', $contractor_id);
                $this->set('activeUser', $this->getRequest()->getSession()->read('Auth.User'));

                return $this->redirect(['controller'=>'Employees','action' => 'dashboard']);
                }
            $this->Flash->error(__('The employee contractor could not be saved. Please, try again.'));            
        }

    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Employees', 'Contractors']
        ];
        $employeeContractors = $this->paginate($this->EmployeeContractors);

        $this->set(compact('employeeContractors'));
    }

    /**
     * View method
     *
     * @param string|null $id Employee Contractor id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $employeeContractor = $this->EmployeeContractors->get($id, [
            'contain' => ['Employees', 'Contractors']
        ]);

        $this->set('employeeContractor', $employeeContractor);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $employeeContractor = $this->EmployeeContractors->newEntity();
        if ($this->request->is('post')) {
            $employeeContractor = $this->EmployeeContractors->patchEntity($employeeContractor, $this->request->getData());
            if ($this->EmployeeContractors->save($employeeContractor)) {
                $this->Flash->success(__('The employee contractor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The employee contractor could not be saved. Please, try again.'));
        }
        $employees = $this->EmployeeContractors->Employees->find('list', ['limit' => 200]);
        $contractors = $this->EmployeeContractors->Contractors->find('list', ['limit' => 200]);
        $this->set(compact('employeeContractor', 'employees', 'contractors'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Employee Contractor id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $employeeContractor = $this->EmployeeContractors->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $employeeContractor = $this->EmployeeContractors->patchEntity($employeeContractor, $this->request->getData());
            if ($this->EmployeeContractors->save($employeeContractor)) {
                $this->Flash->success(__('The employee contractor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The employee contractor could not be saved. Please, try again.'));
        }
        $employees = $this->EmployeeContractors->Employees->find('list', ['limit' => 200]);
        $contractors = $this->EmployeeContractors->Contractors->find('list', ['limit' => 200]);
        $this->set(compact('employeeContractor', 'employees', 'contractors'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Employee Contractor id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->loadModel('ContractorServices');
        $this->loadModel('Contractors');

        $this->request->allowMethod(['post', 'delete']);

        $employeeContractor = $this->EmployeeContractors->get($id);
        $success = 'The employee contractor has been deleted.';
        $error = 'The employee contractor could not be deleted. Please, try again.';
        $referer = $this->request->referer();


        if ($this->EmployeeContractors->delete($employeeContractor)) {

            /*minus employee slot*/
            if(!empty($employeeContractor->contractor_id)){
                $contractor = $this->Contractors
                    ->find('all')
                    ->select(['company_name','id'])
                    ->contain('ContractorServices', ['conditions'=>['service_id' => 4]])
                    ->where(['id'=>$employeeContractor->contractor_id])
                    ->first();
                if(!empty($contractor->ContractorServices[0]->slot) && $contractor->ContractorServices[0]->slot > 0){
                    $slots = $contractor->ContractorServices[0]->slot;
                    $slots = $slots - 1;
                    $data['slot'] = $slots;
                    $contractorService = $this->ContractorServices->get($contractor->ContractorServices[0]->id);
                    $contractorService = $this->ContractorServices->patchEntity($contractorService, $data);
                    if ($this->ContractorServices->save($contractorService)) {
                        $this->Flash->success(__('The contractor employee slots has been updated.'));

                        return $this->redirect(['action' => 'index']);
                    }
                }
            }
            $this->Flash->success(__('The employee contractor association has been deleted.'));
        } else {
            $this->Flash->error(__('The employee contractor association could not be deleted. Please, try again.'));
        }

        $referer = $this->request->referer();
        if (strpos($referer, 'view') != '') {
            return $this->redirect(['controller'=>'Employees','action' => 'index']);
        } else {
            return $this->redirect(['action' => 'index']);
        }

    }
    public function manageContractors() {
    $employee_id = $this->getRequest()->getSession()->read('Auth.User.employee_id');

    $employee = $this->EmployeeContractors->Employees->get($employee_id, 
        ['contain'=>[
        'Users'=>['fields'=>['Users.id', 'Users.username']],
        'EmployeeContractors'=>['fields'=>['EmployeeContractors.id','EmployeeContractors.employee_id']],
        'EmployeeContractors.Contractors'=>['fields'=>['company_name','id']],      
        
    ] ]);

    $this->set(compact('employee'));
    }

    public function associateContractor(){
        $this->loadModel('Contractors');

        $employeeContractor = $this->EmployeeContractors->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            if(!empty($data['contractor_id'])){
                $activeUser = $this->getRequest()->getSession()->read('Auth.User');

                $data['created_by'] = $activeUser['id'];

                /*check if slots are available*/
                $contractor = $this->Contractors
                    ->find('all')
                    ->select(['company_name','id'])
                    ->contain('ContractorServices', ['conditions'=>['service_id' => 4]])
                    ->where(['id'=>$data['contractor_id']])
                    ->first();
                $employeeSlots = 0;
                if(!empty($contractor->contractor_services[0]->slot)){
                    $employeeSlots = $contractor->contractor_services[0]->slot;
                    if($employeeSlots <= 0){
                        $this->Flash->error(__('The employee contractor association could not be saved. No slots available. Please, try again.'));
                        return $this->redirect(['controller' => 'Employees','action' => 'view', $data['employee_id']]);
                    }
                }
                $employeeContractor = $this->EmployeeContractors->patchEntity($employeeContractor, $data);


                if ($this->EmployeeContractors->save($employeeContractor)) {
                    $this->Flash->success(__('The employee contractor association has been saved.'));
                }else{
                    $this->Flash->error(__('The employee contractor association could not be saved. Please, try again.'));
                }
            }else{
                $this->Flash->error(__('The employee contractor  association could not be saved. Contractor not selected. Please, try again.'));
            }
            return $this->redirect(['controller' => 'Employees','action' => 'view', $data['employee_id']]);
        }

    }
}
