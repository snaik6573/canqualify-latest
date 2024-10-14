<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;

/**
 * EmployeeSites Controller
 *
 * @property \App\Model\Table\EmployeeSitesTable $EmployeeSites
 *
 * @method \App\Model\Entity\EmployeeSite[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */

class EmployeeSitesController extends AppController
{
    public function isAuthorized($user)
    {
	$contractorNav = false;
	if($user['role_id'] != CONTRACTOR) {
		$contractorNav = true;
    }
    $this->set('contractorNav', $contractorNav);
    
	$employeeNav = false;
    if($user['role_id'] != EMPLOYEE) {
        $employeeNav = true;
        $this->set('service_id', 4);
    }
    $this->set('employeeNav', $employeeNav);
    $clientCenterNav = false;
    if(isset($user['client_id']) && ($user['role_id'] == SUPER_ADMIN  || $user['role_id'] == ADMIN )){
        $clientCenterNav = true;
       $this->set('clientCenterNav', $clientCenterNav);
    }
	// Admin can access every action
	if (isset($user['role_id']) && $user['active']== 1) {
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
    /*public function index()
    {
        $this->paginate = [
            'contain' => ['Employees', 'Sites']
        ];
        $employeeSites = $this->paginate($this->EmployeeSites);

        $this->set(compact('employeeSites'));

    }*/

    /**
     * View method
     *
     * @param string|null $id Employee Site id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function view($id = null)
    {
        $employeeSite = $this->EmployeeSites->get($id, [
            'contain' => ['Employees', 'Sites']
        ]);

        $this->set('employeeSite', $employeeSite);
    }*/

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($employee_id=null)
    {
        $this->loadModel('Employees');
        $sites = array();
        $contractorSites =array();
        $employeeSite = $this->EmployeeSites->newEntity();
        $contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
        if(empty($employee_id)){
            $employee_id = $this->getRequest()->getSession()->read('Auth.User.employee_id'); 
        }
      
        $emp_contractors = $this->User->getEmpContractors($employee_id);
        if(!empty($emp_contractors)){
        $contractorSites = $this->User->getContractorSitesForEmp($contractor_id,$employee_id,$emp_contractors);
        }
        $selectedSites = $this->EmployeeSites->find()->contain(['Sites','Employees'])->where(['employee_id'=>$employee_id])->toArray();
    
        if ($this->request->is('post')) {
		if(!empty($this->request->getData('site_id'))) {
        foreach ($this->request->getData('site_id') as $site_id) {
                    $employeeSites = $this->EmployeeSites->newEntity();             
                    $employeeSites->employee_id = $employee_id;              
                    $employeeSites->site_id = $site_id;             
                    $employeeSites->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
                    $this->EmployeeSites->save($employeeSites);
                }
                $this->Flash->success(__('The employee site has been saved.'));
                return $this->redirect(['action' => 'add',$employee_id]);
        }
        }
        $sites = $this->EmployeeSites->Sites->find('list', ['limit' => 200]);
        $this->set(compact('employeeSite','sites','contractorSites','selectedSites'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Employee Site id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function edit($id = null)
    {
        $employeeSite = $this->EmployeeSites->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $employeeSite = $this->EmployeeSites->patchEntity($employeeSite, $this->request->getData());
			 $employeeSite->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');
            if ($this->EmployeeSites->save($employeeSite)) {
                $this->Flash->success(__('The employee site has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The employee site could not be saved. Please, try again.'));
        }
        $employees = $this->EmployeeSites->Employees->find('list', ['limit' => 200]);
        $sites = $this->EmployeeSites->Sites->find('list', ['limit' => 200]);
        $this->set(compact('employeeSite', 'employees', 'sites'));
    }*/

    /**
     * Delete method
     *
     * @param string|null $id Employee Site id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $employeeSite = $this->EmployeeSites->get($id);
        if ($this->EmployeeSites->delete($employeeSite)) {
            $this->Flash->success(__('The employee site has been deleted.'));
        } else {
            $this->Flash->error(__('The employee site could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }*/
}