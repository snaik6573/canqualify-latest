<?php
namespace App\Controller;
use Cake\Event\Event;
use App\Controller\AppController;

/**
 * EmployeeExplanations Controller
 *
 * @property \App\Model\Table\EmployeeExplanationsTable $EmployeeExplanations
 *
 * @method \App\Model\Entity\EmployeeExplanation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmployeeExplanationsController extends AppController
{
	public function isAuthorized($user)
    {
	$contractorNav = false;
	$employeeNav = false;
	
	if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN || $user['role_id'] == CLIENT || $user['role_id'] == CONTRACTOR_ADMIN || $user['role_id'] == CR) {
	$contractorNav = true;
	}
	$this->set('contractorNav', $contractorNav);

	if(isset($user['employee_id']) && ($user['role_id'] == SUPER_ADMIN  || $user['role_id'] == ADMIN || $user['role_id'] == CONTRACTOR || $user['role_id'] == CONTRACTOR_ADMIN || $user['role_id'] == CR  )){
        $employeeNav = true;
       $this->set('employeeNav', $employeeNav);
    }

	if($user['role_id'] != EMPLOYEE) {
		$employeeNav = true;
		$this->set('service_id', 4);
	}
    if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN) {
        $clientNav = true;
        $this->set('clientNav', $clientNav);
    } 
    
	$this->set('employeeNav', $employeeNav);

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
        $this->loadModel('DocumentTypes');  
		$employee_id = $this->getRequest()->getSession()->read('Auth.User.employee_id');
        $totalCount = $this->EmployeeExplanations->find('all')->count();
		$this->paginate = [
            'contain' => ['Employees'],
			'conditions' => ['employee_id'=>$employee_id],
			'limit'  => $totalCount,
			'maxLimit'=> $totalCount
        ];
        $employeeExplanations = $this->paginate($this->EmployeeExplanations);
        $documentTypes = $this->DocumentTypes->find('list')->toArray();
        $this->set(compact('employeeExplanations','documentTypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Employee Explanation id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$employee_id = $this->getRequest()->getSession()->read('Auth.User.employee_id');
        $employeeExplanation = $this->EmployeeExplanations->get($id, [
            'contain' => ['Employees']
        ]);
		$employee = $this->EmployeeExplanations->Employees->get($employee_id, [
            'contain' => ['Users']
		]);

        $this->set(compact('employeeExplanation','employee'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
   /* public function add()
    {
        $employeeExplanation = $this->EmployeeExplanations->newEntity();
        if ($this->request->is('post')) {
            $employeeExplanation = $this->EmployeeExplanations->patchEntity($employeeExplanation, $this->request->getData());
            if ($this->EmployeeExplanations->save($employeeExplanation)) {
                $this->Flash->success(__('The employee explanation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The employee explanation could not be saved. Please, try again.'));
        }
        $employees = $this->EmployeeExplanations->Employees->find('list', ['limit' => 200]);
        $this->set(compact('employeeExplanation', 'employees'));
    }*/
	public function add($employee_id =null)
    {
    $this->loadModel('DocumentTypes');  

    if(empty($employee_id)){
	$employee_id = $this->getRequest()->getSession()->read('Auth.User.employee_id');
    }
    if(!empty($employee_id)){
    $this->getRequest()->getSession()->write('Auth.User.employee_id',$employee_id);
     $this->set('activeUser', $this->getRequest()->getSession()->read('Auth.User'));
    } 
	$employee = $this->EmployeeExplanations->Employees->get($employee_id, [
            'contain' => ['Users']
    ]);
	
	$userId = $this->getRequest()->getSession()->read('Auth.User.id');
    $documentTypes = $this->DocumentTypes->find('list')->toArray();
	$employeeExplanation = $this->EmployeeExplanations->newEntity();
	if ($this->request->is(['patch', 'post', 'put'])) {
		$requestDt = $this->request->getData('employeeExplanations');
        // pr($requestDt);die;
		foreach($requestDt as $key => $val) {
			if($val['document']!='') {
				$employeeExplanation = $this->EmployeeExplanations->newEntity();
				$employeeExplanation = $this->EmployeeExplanations->patchEntity($employeeExplanation, $val);
				$employeeExplanation->employee_id = $employee_id;
				$employeeExplanation->created_by = $userId;
//pr($employeeExplanation);die;
				if($this->EmployeeExplanations->save($employeeExplanation)) {
					//$this->Flash->success(__('The EmployeeExplanations has been saved.'));
				}
				/*else {
					$this->Flash->error(__('The EmployeeExplanations could not be saved. Please, try again.'));
				}*/
			}
			/*else {
				$this->Flash->error(__('The EmployeeExplanations could not be saved. Please, try again.'));
			}*/
		}
		$this->Flash->success(__('The Document has been Uploaded.'));
	}	
		
	$this->paginate = [
            'contain' => ['Employees'],
	    'conditions' => ['employee_id'=>$employee_id]
    ];
    $employeeExplanations = $this->paginate($this->EmployeeExplanations); 
    $this->set(compact('employeeExplanation', 'employeeExplanations', 'employee','documentTypes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Employee Explanation id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->loadModel('DocumentTypes');

		$employee_id = $this->getRequest()->getSession()->read('Auth.User.employee_id');
        $employeeExplanation = $this->EmployeeExplanations->get($id, [
            'contain' => []
        ]);		
		$employee = $this->EmployeeExplanations->Employees->get($employee_id, [
            'contain' => ['Users']
    ]);
        $documentTypes = $this->DocumentTypes->find('list')->toArray();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $employeeExplanation = $this->EmployeeExplanations->patchEntity($employeeExplanation, $this->request->getData());
            if ($this->EmployeeExplanations->save($employeeExplanation)) {
                $this->Flash->success(__('The Document has been Uploaded.'));

                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('The Document could not be Uploaded. Please, try again.'));
        }
        $employees = $this->EmployeeExplanations->Employees->find('list', ['limit' => 200]);
        $this->set(compact('employeeExplanation', 'employees','employee','documentTypes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Employee Explanation id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $employeeExplanation = $this->EmployeeExplanations->get($id);
        if ($this->EmployeeExplanations->delete($employeeExplanation)) {
            $this->Flash->success(__('The Document has been deleted.'));
        } else {
            $this->Flash->error(__('The Document could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'add']);
    }
    public function expList($contractor_id = null,$review = false)
    {
        $this->loadModel('Employees');
        $this->loadModel('EmployeeContractors');
        $this->loadModel('DocumentTypes'); 

        if(empty($contractor_id)){
            $contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
        }              
            // $empExplanations = $this->EmployeeExplanations
            // ->find('all')          
            // ->contain(['Employees'])        
            // ->where(['Employees.contractor_id'=>$contractor_id])      
            // ->toArray();

            //  $employees = $this->Employees
            // ->find('all')          
            // ->contain(['EmployeeExplanations'])        
            // ->where(['Employees.contractor_id'=>$contractor_id])      
            // ->toArray();
            $employeesContractors = $this->EmployeeContractors
            ->find('all')  
            ->contain(['Employees'=> ['fields'=>['id','pri_contact_fn','pri_contact_ln']]])   
            ->contain(['Employees.EmployeeExplanations'])        
            ->where(['EmployeeContractors.contractor_id'=>$contractor_id])  
            ->toArray();
        //  pr($employeesContractors);
           
        $documentTypes = $this->DocumentTypes->find('list')->toArray();
        $this->set(compact('employeesContractors','documentTypes','review'));
    }    
}
