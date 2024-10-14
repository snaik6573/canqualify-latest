<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Core\Configure;
use Cake\Mailer\MailerAwareTrait;       //  Built in function use for sending multiple email
use Cake\Auth\DefaultPasswordHasher;
use Cake\Utility\Security;
use Cake\ORM\TableRegistry;

require_once('../vendor/fpdf/fpdf/fpdf.php');
require_once('../vendor/fpdf/fpdi/src/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\IOFactory;
use \setasign\Fpdi\Fpdi;


/**
 * Employees Controller
 *
 * @property \App\Model\Table\EmployeesTable $Employees
 *
 * @method \App\Model\Entity\Employee[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmployeesController extends AppController
{
    use MailerAwareTrait;

  public function isAuthorized($user)
  {
  $contractorNav = false;
  $employeeNav = false;
  $clientNav = false;

  if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN || $user['role_id'] == CLIENT || $user['role_id'] == CONTRACTOR_ADMIN || $user['role_id'] == CR || $user['role_id'] == CLIENT_ADMIN || $user['role_id'] == CLIENT_VIEW || $user['role_id'] == CLIENT_BASIC) {
    $contractorNav = true;
  }
  $this->set('contractorNav', $contractorNav);

  if($this->request->getParam('action')=='dashboard' || $this->request->getParam('action')=='openTasks' ) {
    if($user['role_id'] != EMPLOYEE) {
      $employeeNav = true;
      $this->set('service_id', 4);
    } 
    if(!isset($user['contractor_id']) && $user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN) {
        $clientNav = true;
        $this->set('clientNav', $clientNav);
      }      
  }
  $this->set('employeeNav', $employeeNav);

  if($this->request->getParam('action')=='edit') {
    if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN) { 
      return true; 
    }
  }
  $clientCenterNav = false;
    if(isset($user['client_id']) && ($user['role_id'] == SUPER_ADMIN  || $user['role_id'] == ADMIN )){
        $clientCenterNav = true;
       $this->set('clientCenterNav', $clientCenterNav);
  }
  // if($this->request->getParam('action')=='index') {
  //       $clientNav = true;
  //      $this->set('clientNav', $clientNav);
  //   }

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
    public function index($service_id=null, $contractor_id=null)
    {
      $this->loadModel('ContractorServices');
      $this->loadModel('Contractors');
    
      if($contractor_id==null) {
        $contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
      }
    else { // login as client -> contractor list -> view employeeQual 
      $contractor = $this->Contractors->get($contractor_id);
      $this->getRequest()->getSession()->write('Auth.User.contractor_id', $contractor_id);
      $this->getRequest()->getSession()->write('Auth.User.contractor_company_name', $contractor->company_name);     
      $this->set('activeUser', $this->getRequest()->getSession()->read('Auth.User'));
    }
    $this->getRequest()->getSession()->delete('Auth.User.employee_id');
    $this->set('activeUser', $this->getRequest()->getSession()->read('Auth.User'));

      $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
      $totalCount = $this->Employees->find('all')->count();
      $where = '';
      $contractorEmp = $this->User->getContractorEmp($contractor_id);
      if(!empty($contractorEmp)){
       $where = ['Employees.id IN'=>$contractorEmp];
      }
      if($client_id!=null) {
        $sites = $this->User->getClientSites($client_id);           
            $this->paginate = [
                'contain' => ['States', 'Countries', 'Users','EmployeeSites.Sites'=>['conditions'=>['site_id IN'=>array_keys($sites)]]],
                'limit'=>$totalCount,
                'maxLimit'=>$totalCount,
                'conditions' => $where
            ];
      }
      else {
            $this->paginate = [
                'contain' => ['States', 'Countries', 'Users', 'EmployeeSites.Sites'],
                'limit'=>$totalCount,
                'maxLimit'=>$totalCount,
                'conditions' => $where
            ];
      }
      $employees ='';
      if(!empty($contractorEmp)){
      $employees = $this->paginate($this->Employees); }
        $employeesSlot = $this->ContractorServices
        ->find('list', ['keyField'=>'id','valueField'=>'slot'])           
        ->where(['contractor_id'=>$contractor_id, 'service_id'=>4])
        ->first();

        $contractorSites = $this->User->getContractorSitesForEmp($contractor_id,$service_id);
        $this->set(compact('employees', 'service_id','contractorSites','contractor_id','employeesSlot'));
    }

    /**
     * View method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
      $conn = ConnectionManager::get('default');
       $this->loadModel('Contractors');
       $this->loadModel('Trainings');
       $this->loadModel('EmployeeContractors');

        $employee = $this->Employees->get($id, [
            'contain' => ['States', 'Countries', 'Users', 'EmployeeSites.Sites']
        ]);
        $contractors = $this->User->getEmpContractors($id);
        $contractor = '';
        if(!empty($contractors)){
        $contractor = $this->Contractors
                    ->find('all')
                    ->select(['company_name','id'])
                    ->contain('EmployeeContractors', ['fields'=>['id']])
                    ->where(['id IN'=>$contractors])
                    ->first();
        }
        /*if contractor is not assigned*/
        $assignCon = '';
        if(empty($contractor)){
            $assignCon = $this->Contractors
                ->find('list', ['keyField' => 'id', 'valueField' => 'company_name'])
                ->where(['Users.active' => true])
                ->contain(['Users'])
                ->toArray();
        }
        //debug($assignCon);die;
        $empTrainings = array();
        foreach($employee->employee_sites as $emp_site) {
          $site_id = $emp_site->site_id;

              $getTrainings = $this->Trainings->find('list', ['keyField'=>'id', 'valueField'=>'name' ])->where(['active'=> true, "site_ids->'s_ids' @>"=>'["'.$site_id.'"]'])->toArray();
              $empTrainings[$site_id]['name'] = $emp_site->site->name;
              foreach($getTrainings as $key => $val) {
                  $empTrainings[$site_id]['trainings'][$key] = $val;
              }
          /*$getTrainings = $conn->execute("SELECT * FROM trainings WHERE '".$site_id."' = ANY (string_to_array(site_ids,','))")->fetchAll('assoc');
      if(!empty($getTrainings)) {
      $empTrainings[$emp_site->site_id]['name'] = $emp_site->site->name;
        foreach($getTrainings as $t) {
          $empTrainings[$emp_site->site_id]['trainings'][$t['id']] = $t['name'];
        }
      }*/
      }
        $employeeContractorId = '';
      if(isset($contractor['id']) && isset($employee->id)){
          $employeeContractor = $this->EmployeeContractors->find()->where(['employee_id' => $employee->id, 'contractor_id' => $contractor['id']])->select(['id'])->first();
          if(isset($employeeContractor->id)){
              $employeeContractorId = $employeeContractor->id;
          }
      }

        $service_id = 4;
      $this->set(compact('employee', 'empTrainings', 'service_id','contractor', 'assignCon', 'employeeContractorId'));
    }

  /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
  public function add($service_id=null)
    {
       $this->loadModel('EmployeeSites');
       $this->loadModel('Users');
       $this->loadModel('ContractorServices');
       $this->loadModel('Contractors');
       $this->loadModel('Countries');
       $this->loadModel('States');
       $this->loadModel('EmployeeContractors');

       $contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
       $contractor = $this->Contractors->get($contractor_id, [
            'contain' => ['Users']
        ]);
       $employeesSlot = $this->ContractorServices
        ->find('list', ['keyField'=>'id','valueField'=>'slot'])
        ->where(['contractor_id'=>$contractor_id, 'service_id'=>4])
        ->first();
       $employeesCount = 0;
       $contractorEmp = $this->User->getContractorEmp($contractor_id);
       if(!empty($contractorEmp)){
       $employeesCount = $this->Employees
        ->find()
        ->where(['Employees.id IN'=>$contractorEmp])
        ->count();
        }
       $available = $employeesSlot - $employeesCount;
       if($available==0) {
        $this->Flash->error(__('The available Employee Slot is 0. Please purchase additional slot to add Employee.'));
            return $this->redirect(['controller'=>'ContractorSites', 'action' => 'add-slot']);
       }
       $employee = $this->Employees->newEntity();
       $country = $this->Countries->newEntity();
       $state = $this->States->newEntity();
       $employeeContractor = $this->EmployeeContractors->newEntity();
       $user = $this->Users->newEntity();
    if ($this->request->is('post')) {

      if((($this->request->getData(['country_id']) != null) || ($this->request->getData(['state_id']) != null)) && ($this->request->getData(['country_id']) == 0)){
        $user_entered = true; // User entered Country and State
        $where= [
                  'OR' => ['username' => $this->request->getData('user.username')],
                          ['login_username'=> $this->request->getData('login_username')] ]; 

        $users =$this->Users->find()->where($where)->contain(['Employees'])->toArray(); 
        //$user =$this->Users->find()->where(['username'=>$this->request->getData('username')])->contain(['Employees'])->toArray();    
        if(!empty($users)) {
            $this->Flash->error(__('The Employee already exist.'));
            //return $this->redirect(['action' => 'index']);
        }else{
   
            $employee = $this->Employees->patchEntity($employee, $this->request->getData());
            $user = $this->Users->patchEntity($user,$this->request->getData('user'));
            if($this->request->getData(['is_login_enable']) == 0){
                $employee->is_login_enable = false;

                $emp_data = $this->request->getData();  

                if(!empty($emp_data['user']['username'])){
                  $user->username = $emp_data['user']['username'];
                  $employee->user_entered_email  = true;
                }else{          
                  $user->username = $emp_data['pri_contact_fn'] . $emp_data['pri_contact_ln']."@".(strtolower(str_replace(' ', '', $contractor['company_name']))).".com";
                  //$user->has_email = false;
                  $employee->user_entered_email  = false;
                }
                if(!empty($emp_data['login_username'])){
                  $employee->user->login_username = $emp_data['login_username'];
                  $employee->user->password =$emp_data['password'];
                }
                
            }else{
                  $employee->is_login_enable = true;      
                  $hasher = new DefaultPasswordHasher();
                  $secret_key = Security::hash(Security::randomBytes(32), 'sha256', false);   // Generate an API 'token'
                  $emp_data = $this->request->getData();
                  $user->secret_key = $secret_key;                       
                  $user->username = $emp_data['user']['username'];
                  if(!empty($emp_data['user']['username'])){   
                  $employee->user_entered_email  = true;
                  }else{          
                $employee->user->username = $emp_data['pri_contact_fn'] . $emp_data['pri_contact_ln']."@".(strtolower(str_replace(' ', '', $contractor['company_name']))).".com";
                //$employee->user->has_email = false;
                $employee->user_entered_email  = false;
                      }
                    if(!empty($emp_data['login_username'])){
                      $employee->user->login_username = $emp_data['login_username'];
                      $employee->user->password =$emp_data['password'];
                   }
                }
                $user->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
          
                if($user_result = $this->Users->save($user)){
                    $country->name = $this->request->getData(['country']);
                    $country->created_by = $user_result->id;
                    $country->user_entered = $user_entered;
                    $country_result = $this->Countries->save($country);
                 
                    $state->name = $this->request->getData(['state']);
                    $state->country_id = $country_result->id;
                    $state->user_entered = $user_entered;
                    $state->created_by = $user_result->id;
                    $state_result = $this->States->save($state);

                    unset($employee['user']);
                    $employee->user_id = $user_result->id;
                    $employee->country_id = $country_result->id;
                    $employee->state_id = $state_result->id;
                    $employee->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
                    $employee->contractor_id = $contractor_id;
               
               if ($result=$this->Employees->save($employee)) {
                  $this->getMailer('User')->send('save_employee', [$employee,$contractor['company_name']]);

                  $empid = $result->id;                
                  $employee['username'] = $this->request->getData(['user.username']);

                  if($user->active==1 && $this->request->getData(['is_login_enable']) == 1 && $employee->user_entered_email == 1) {
                    $url = Router::Url(['controller' => 'users', 'action' => 'reset-password'], true).'/'.$secret_key.'/1';
                    $employee->reset_url = $url;
                    $this->getMailer('User')->send('register_employee', [$employee,$contractor['company_name']]);
                  }

                  $employeeContractor->employee_id = $empid;
                  $employeeContractor->contractor_id = $contractor_id;
                  $employeeContractor->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
                  $this->EmployeeContractors->save($employeeContractor);
                   /*Previous code to add employee sites by selection on form*/
                   /*if($this->request->getData('site_id')!=null) {
                   foreach ($this->request->getData('site_id') as $site_id) {
                       $employeeSites = $this->EmployeeSites->newEntity();
                       $employeeSites->employee_id = $empid;
                       $employeeSites->site_id = $site_id;
                       $employeeSites->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
                       $this->EmployeeSites->save($employeeSites);
                   }
                 }*/
                 /*new code to inherit contractor sites*/
                   $contractorSites = $this->User->getContractorSitesForEmp($contractor_id);
                   if(!empty($contractorSites)) {
                       foreach ($contractorSites as $client_name => $c_sites){
                           foreach ($c_sites as $s_id => $s_name) {
                               $employeeSites = $this->EmployeeSites->newEntity();
                               $employeeSites->employee_id = $empid;
                               $employeeSites->site_id = $s_id;
                               $employeeSites->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
                               $this->EmployeeSites->save($employeeSites);
                           }
                       }
                   }

                $this->Flash->success(__('The employee has been saved.'));
                return $this->redirect(['action' => 'index',$service_id]);
            }
          }
            $this->Flash->error(__('The employee could not be saved. Please fill in the required fields.'));
            return $this->redirect(['controller' => 'Employees', 'action' => 'add',$service_id]);
        }
       }else{ // Normal Employee save
        $where= [
                   'OR' => ['username' => $this->request->getData('user.username')],
                           ['login_username'=> $this->request->getData('login_username')] ]; 
        $user =$this->Users->find()->where($where)->contain(['Employees'])->toArray();
        //$user =$this->Users->find()->where(['username'=>$this->request->getData('username')])->contain(['Employees'])->toArray();   
        if(!empty($user)) {
                $this->Flash->error(__('The Employee already exist.'));
                //return $this->redirect(['action' => 'index']);
        }
        else {
            $employee = $this->Employees->patchEntity($employee, $this->request->getData());
      
            if($this->request->getData(['is_login_enable']) == 0){
              $employee->is_login_enable = false;
        
                $emp_data = $this->request->getData();                
                if(!empty($emp_data['user']['username'])){
                $employee->user->username = $emp_data['user']['username'];
                $employee->user_entered_email  = true;
                      }else{          
                $employee->user->username = $emp_data['pri_contact_fn'] . $emp_data['pri_contact_ln']."@".(strtolower(str_replace(' ', '', $contractor['company_name']))).".com";
                //$employee->user->has_email = false;
                $employee->user_entered_email  = false;
                      }
                
                if(!empty($emp_data['login_username'])){
                  $employee->user->login_username = $emp_data['login_username'];
                  $employee->user->password = $emp_data['password'];
                }
                    
                } else {
                  $employee->is_login_enable = true;      
                    $emp_data = $this->request->getData();
                    $hasher = new DefaultPasswordHasher();
                    $secret_key = Security::hash(Security::randomBytes(32), 'sha256', false);   // Generate an API 'token'
                    $employee->user->secret_key = $secret_key;                        
                    $employee->user->username = $emp_data['user']['username'];  
                    if(!empty($emp_data['user']['username'])){              
                      $employee->user_entered_email  = true;
                    }else{          
                    $employee->user->username = $emp_data['pri_contact_fn'] . $emp_data['pri_contact_ln']."@".(strtolower(str_replace(' ', '', $contractor['company_name']))).".com";
                    //$employee->user->has_email = false;
                    $employee->user_entered_email  = false;
                      }
                      if(!empty($emp_data['login_username'])){
                        $employee->user->login_username = $emp_data['login_username'];
                        $employee->user->password = $emp_data['password'];
                      }
                }
                $employee->user->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
                $employee->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
                $employee->contractor_id = $contractor_id;

              if ($result=$this->Employees->save($employee)) {
                 $this->getMailer('User')->send('save_employee', [$employee,$contractor['company_name']]);
                  $empid = $result->id;
                  if($employee->user->active==1 && $this->request->getData(['is_login_enable']) == 1 && $employee->user_entered_email == 1) {
                      $url = Router::Url(['controller' => 'users', 'action' => 'reset-password'], true).'/'.$secret_key.'/1';
                      $employee->reset_url = $url;
                      $this->getMailer('User')->send('register_employee', [$employee,$contractor['company_name']]);
                  }

                  $employeeContractor->employee_id = $empid;
                  $employeeContractor->contractor_id = $contractor_id;
                  $employeeContractor->created_by = $this->getRequest()->getSession()->read('Auth.User.id');                
                  $this->EmployeeContractors->save($employeeContractor);
                  /*Previous code to add employee sites by selection on form*/
                  /*if($this->request->getData('site_id')!=null) {
                  foreach ($this->request->getData('site_id') as $site_id) {
                    $employeeSites = $this->EmployeeSites->newEntity();             
                    $employeeSites->employee_id = $empid;               
                    $employeeSites->site_id = $site_id;             
                    $employeeSites->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
                    $this->EmployeeSites->save($employeeSites);
                }
                }*/

                  $contractorSites = $this->User->getContractorSitesForEmp($contractor_id);
                  if(!empty($contractorSites)) {
                      foreach ($contractorSites as $client_name => $c_sites){
                          foreach ($c_sites as $s_id => $s_name) {
                              $employeeSites = $this->EmployeeSites->newEntity();
                              $employeeSites->employee_id = $empid;
                              $employeeSites->site_id = $s_id;
                              $employeeSites->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
                              $this->EmployeeSites->save($employeeSites);
                          }
                      }
                  }
                  
                $this->Flash->success(__('The employee has been saved.'));
                return $this->redirect(['action' => 'index',$service_id]);
            }
            $this->Flash->error(__('The employee could not be saved. Please fill in the required fields.'));
        }
      }
    }  // end of if 
    $contractorSites = $this->User->getContractorSitesForEmp($contractor_id);
    $states = $this->Employees->States->find('list', ['limit' => 200])->where(['user_entered'=>false])->toArray();
    $countries = $this->Employees->Countries->find('list', ['limit' => 200])->where(['user_entered'=>false])->toArray();
    $service_id = 4;
    $this->set(compact('employee','states','countries', 'contractorSites', 'service_id'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */    
    public function edit($id = null,$service_id=null)
    {
      $this->loadModel('EmployeeSites');
      $this->loadModel('Contractors');

        $employee = $this->Employees->get($id, [
            'contain' => ['Users']
        ]);
        $contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
        $contractor = $this->Contractors->get($contractor_id, [
            'contain' => ['Users']
        ]);
    
        $contractorSites = $this->User->getContractorSitesForEmp($contractor_id,$id); 
        $selectedSites = $this->EmployeeSites->find()->contain(['Sites','Employees'])->where(['employee_id'=>$id])->toArray();   

        if ($this->request->is(['patch', 'post', 'put'])) {        
        $employee = $this->Employees->patchEntity($employee, $this->request->getData());
        if($employee->is_login_enable == false) {       
          $emp_data = $this->request->getData();  
                         
              if(!empty($emp_data['user']['username'])){
                   $employee->user->username = $emp_data['user']['username'];
                   $employee->user_entered_email  = true;
                   if(!empty($emp_data['user']['login_username'])){
                      $employee->user->login_username = $emp_data['user']['login_username'];        
                    }else{
                      $employee->user->login_username = null;
                    }
                    
                  }else{          
                 $employee->user->username = $emp_data['pri_contact_fn'] . $emp_data['pri_contact_ln']."@".(strtolower(str_replace(' ', '', $contractor['company_name']))).".com";
                 $employee->user_entered_email  = false;
                 if(!empty($emp_data['user']['login_username'])){
                      $employee->user->login_username = $emp_data['user']['login_username'];                 
                    }else{
                      $employee->user->login_username = null;
                    }
                }   
      }else{
        $emp_data = $this->request->getData();                     
              if(!empty($emp_data['user']['username'])){
                   $employee->user->username = $emp_data['user']['username'];
                   $employee->user_entered_email  = true;
                   if(!empty($emp_data['user']['login_username'])){
                      $employee->user->login_username = $emp_data['user']['login_username'];        
                    }else{
                      $employee->user->login_username = null;
                    }
                    
                  }else{          
                 $employee->user->username = $emp_data['pri_contact_fn'] . $emp_data['pri_contact_ln']."@".(strtolower(str_replace(' ', '', $contractor['company_name']))).".com";
                 $employee->user_entered_email  = false;
                 if(!empty($emp_data['user']['login_username'])){
                      $employee->user->login_username = $emp_data['user']['login_username'];         
                    }else{
                      $employee->user->login_username = null;
                    }
                }   
      }
 // pr($employee);die;
      $employee->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');
      
            if ($this->Employees->save($employee)) {
                $this->Flash->success(__('The employee has been saved.'));

                //$deletedSites =array();
            if (is_array($this->request->getData('site_id'))) {
              foreach ($this->request->getData('site_id') as $site_id) { // Add
                  //if(!in_array($site_id, $selectedSites)) {
                  $employeeSite = $this->EmployeeSites->newEntity();
                  $employeeSite->employee_id = $id;       
                  $employeeSite->site_id = $site_id;        
                  $employeeSite->created_by = $this->getRequest()->getSession()->read('Auth.User.id');

                  $this->EmployeeSites->save($employeeSite);
                //}
                }
                    // deletedSites
                    //$deletedSites = array_diff($selectedSites, $this->request->getData('site_id'));
            }
            /*else {
            $deletedSites = $selectedSites;
            }*/

            /*if(!empty($deletedSites)) {
              $this->EmployeeSites->query()
                ->delete()        
                ->where(['site_id IN'=>$deletedSites, 'employee_id'=>$id])
                ->execute();
            }*/

                return $this->redirect(['action' => 'index', $service_id]);
            }
            $this->Flash->error(__('The employee could not be saved. Please, try again.'));
        }
        $where = ['OR'=>['user_entered IS NOT'=>true,'created_by'=>$employee->user_id]];
        $states = $this->Employees->States->find('list')->where(['country_id'=>$employee->country_id,$where])->toArray();
        $countries = $this->Employees->Countries->find('list')->where($where)->toArray();

        $service_id = 4;
        $this->set(compact('employee', 'states', 'countries', 'contractorSites', 'selectedSites', 'service_id'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $employee = $this->Employees->get($id);
        if ($this->Employees->delete($employee)) {
            $this->Flash->success(__('The employee has been deleted.'));
        } else {
            $this->Flash->error(__('The employee could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'employeeList']);
    }

    public function dashboard($employee_id=null,$contractor_id=null)
    {
        $this->loadModel('EmployeeContractors');
        $this->loadModel('TrainingPercentages');
        $this->loadModel('AggregateTrainingPercentages');

        if($this->User->isEmployee()) {
            $employee_id = $this->getRequest()->getSession()->read('Auth.User.employee_id');
        }
        else {
            $this->getRequest()->getSession()->write('Auth.User.employee_id', $employee_id);
            $this->set('activeUser', $this->getRequest()->getSession()->read('Auth.User'));
        }
        $employee = $this->Employees->get($employee_id, ['contain'=>['Users']]);
        /*check if employee is associated with contractor*/
        $contractor_id = '';
        $client_id = '';
        $contractor_clients = '';
        $formsNDocs = '';
        $isAssociation = 0;
        $isAssociation = $this->EmployeeContractors->find('all')->where(['employee_id'=>$employee_id])->count();
        if($isAssociation){
            /*if logged in user is contractor else get from employee id*/
            if($this->User->isContractor()) {
                $contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
            }else{
                $contractor_id = $this->User->getEmpContractor($employee_id);
            }

            /*if logged in user is client or get from contractor*/
            if($this->User->isClient()) {
                $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
            }
            if(!empty($contractor_id)) {
                $contractor_clients = $this->User->getClients($contractor_id);
            }
            if(!empty($contractor_clients)) {
                $formsNDocs = $this->formsnDocs($client_id, $contractor_clients);
                if($client_id != null) {
                    $formsNDocs = $this->formsnDocs($client_id, null);
                }
                else{
                    $formsNDocs = $this->formsnDocs(null, $contractor_clients);
                }
            }
        }

        /*employee trainigns / orientations*/
        $orientationMatrix = $this->TrainingPercentages
            ->find('all')
            ->contain(['Trainings'=>['fields' => ['name', 'active']]])
            ->where(['employee_id' => $employee_id])
            ->toArray();
        //debug($orientationMatrix);
        $orientationCompleteFlag = 0;
        $cnt = 0;
        $cnt = $this->AggregateTrainingPercentages->find('all')->where(['employee_id' => $employee_id])->select(['percentage'])->count();
        if($cnt > 0){
            $isOrientationComplete = $this->AggregateTrainingPercentages->find('all')->where(['employee_id' => $employee_id])->select(['percentage'])->first()->toArray();
            $orientationCompleteFlag = $isOrientationComplete['percentage'];
        }

        $this->set(compact('employee', 'employee_id','contractor_id', 'formsNDocs','isAssociation','orientationMatrix', 'orientationCompleteFlag'));
    }

    public function myProfile()
    {
      $employee_id = $this->getRequest()->getSession()->read('Auth.User.employee_id');
      $employee = $this->Employees->get($employee_id, ['contain'=>['Users']]);

      if ($this->request->is(['patch', 'post', 'put'])) {
        $employee = $this->Employees->patchEntity($employee, $this->request->getData());  
        $empData = $this->request->getData(); 
        if($employee['user_entered_email'] == false && !empty($empData['user']['username'])){
          $employee->user->username = $empData['user']['username'];
          $employee->user_entered_email = true;
        }elseif(empty($empData['user']['username'])) {
         $employee->user->username = $employee['pri_contact_fn']."@".$employee['pri_contact_ln'].".com";
                 $employee->user_entered_email  = false;
        } 
         
      if ($this->Employees->save($employee)) {
        $this->getRequest()->getSession()->write('Auth.User.registration_status', $employee->registration_status);
        
        if(null !== $this->request->getData('user.profile_photo')){
          $this->getRequest()->getSession()->write('Auth.User.profile_photo', $employee->user->profile_photo);        
        }
      $this->set('activeUser', $this->getRequest()->getSession()->read('Auth.User'));

      $this->Flash->success(__('Profile has been saved.'));
      return $this->redirect(['action'=>'myProfile']);
    }
    $this->Flash->error(__('Profile could not be saved. Please, try again.'));
      }

    $where = ['OR'=>['user_entered IS NOT'=>true,'created_by'=>$employee->user_id]];
    $states = $this->Employees->States->find('list')->where(['country_id'=>$employee->country_id,$where])->toArray();
    $countries = $this->Employees->Countries->find('list')->where($where)->toArray();
    
    $this->set(compact('employee','states','countries'));

    }
    public function openTasks($contractor_id=null)
    {
      $this->getRequest()->getSession()->delete('Auth.User.employee_id');
      $this->set('activeUser', $this->getRequest()->getSession()->read('Auth.User'));
      
      $contractorEmp = $this->User->getContractorEmp($contractor_id);
      $employees = $this->Employees->find()->select(['id','pri_contact_fn','pri_contact_ln'])
        ->where(['id In'=>$contractorEmp])->enableHydration(false)->toArray();

        $this->set(compact('employees'));
    }
    
/* Resend Emails */
    public function resendEmails($employee_id = null,$service_id=null){   
      $this->loadModel('Users');  
      $this->loadModel('Contractors'); 
      $this->autoRender = false;
      $contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
      $contractor = $this->Contractors->get($contractor_id, [
            'contain' => []
        ]);
       $employee = $this->Employees->get($employee_id, [
            'contain' => ['Users']
        ]);

        $hasher = new DefaultPasswordHasher();
        $secret_key = Security::hash(Security::randomBytes(32), 'sha256', false); 
        $url = Router::Url(['controller' => 'users', 'action' => 'reset-password'], true).'/'.$secret_key.'/1';
        $employee->reset_url = $url;       
              
                if($this->Users->query()->update()->set(['secret_key' => $secret_key])->where(['id' => $employee['user']['id']])->execute()){
                   $this->getMailer('User')->send('register_employee', [$employee,$contractor['company_name']]);
                  $this->Flash->success(__('The employee registration email has been send.'));
                return $this->redirect(['action' => 'index',$service_id]);
                }       
    }

    public function employeeList()
    {     
     $totalCount = $this->Employees->find('all')->count();    
       
        $this->paginate = [
                'contain'=>['Users', 'EmployeeContractors.Contractors'],
                'limit'=>$totalCount,
                'maxLimit'=>$totalCount
        ];
      $employees = $this->paginate($this->Employees);     
   //pr($employees);die;
      $this->set(compact('employees'));
    }

     public function moveContId()
    {     
      $this->autoRender = false;
      $this->loadModel('EmployeeContractors');
      $employees = $this->Employees->find('all')->toArray();  
      
      foreach ($employees as $key => $employee) {
         $employeeContractor = $this->EmployeeContractors->newEntity();
        // pr($empContractor);die;
         $employeeContractor->employee_id = $employee->id;
         $employeeContractor->contractor_id = $employee->contractor_id;
         
          $employeeContractor->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
         //pr($created_by);die;
         $this->EmployeeContractors->save($employeeContractor);
       }
        $this->Flash->success(__("The Contractor Id's Moved Succesfully  .")); 
     
    }

    public function profile($employee_id=null)
    {
      $this->loadModel('EmployeeQuestions');

      if(empty($employee_id)){
        $employee_id = $this->getRequest()->getSession()->read('Auth.User.employee_id');
      }
      $employee = $this->Employees->get($employee_id, ['contain'=>['Users','States','Countries']]);

      if ($this->request->is(['patch', 'post', 'put'])) {     
        $employee = $this->Employees->patchEntity($employee, $this->request->getData());
        $employee->profile_search = $this->request->getData('profile_search');       
        $this->Employees->save($employee); 
      }

      $questions = $this->EmployeeQuestions
      ->find()   
      ->contain(['QuestionTypes'=>['fields'=>['id', 'name']] ])     
      ->contain(['employeeAnswers'=>['conditions'=>['employee_id'=>$employee_id]] ])
      ->where(['active'=>true, 'employee_category_id IN '=>[19,20]])   
      ->order(['ques_order'=>'ASC','EmployeeQuestions.id'=>'ASC'])
      ->all();   
    //  pr($questions);      
            
     $this->set(compact('employee','questions'));
    }

    public function formsnDocs($client_id=null, $contractor_clients=array())
    {
        $this->loadModel('FormsNDocs');

        $formsNDocsWhere['show_to_employees'] = true;

        if($client_id!=null) {
            $formsNDocsWhere['client_id'] = $client_id;
        } elseif(!empty($contractor_clients)) {
            $formsNDocsWhere['client_id IN']= $contractor_clients;
        }

        $formsNDocs = $this->FormsNDocs
            ->find()
            ->where($formsNDocsWhere)
            ->contain(['Clients'=> ['fields'=> ['id', 'company_name']] ])
            ->toArray();
        return $formsNDocs;
    }

    /*update orientation completion*/
    public function updateOrientationCompletion($employee_id = null){

        $this->loadModel('EmployeeSites');
        $this->loadModel('Trainings');

        $conn = ConnectionManager::get('default');

        if($employee_id != null){
            $employeeSites = $this->EmployeeSites
                ->find('list', ['keyField'=>'id','valueField'=>'site_id'])
                ->where(['employee_id'=>$employee_id])->toArray();
            if(count($employeeSites) > 0){
                foreach ($employeeSites as $site){
                    $qry = "select trainings.id, trainings.site_ids from trainings where trainings.site_ids @> '{\"s_ids\": [\"".$site."\"]}'";
                    $trainings = $conn->execute($qry)->fetchAll('assoc');
                    if(!empty($trainings)){
                        foreach ($trainings as $training){
                            /*update training percentage*/
                            if(!empty($training['id']) && !empty($employee_id)){
                                    if($this->TrainingPercentage->saveTrainingCompletion($employee_id, $training['id'])){
                                        $this->Flash->success(__('The Orientation Completion has been updated.'));
                                    }
                            }

                        }
                    }else{
                        $this->Flash->success(__('No Orientation associated with an employee.'));
                    }
                }
            }else{
                $this->Flash->success(__('No Location associated with an employee.'));
            }
        }
        return $this->redirect(['action' => 'employeeList']);
    }

    /*function to download certificate of completion*/
    public function certifyCompletion($training_id = 0, $employee_id = 0, $client_id = null)
    {
        $this->loadModel('TrainingPercentages');

        $orientation = $this->TrainingPercentages
            ->find()
            ->contain(['Trainings'=>['fields' => ['name']]])
            ->contain(['Employees'=>['fields' => ['pri_contact_fn', 'pri_contact_ln']]])
            ->where(['employee_id' => $employee_id, 'training_id' => $training_id])->first()
            ->toArray();
        $emp_name = '';
        $emp_name .= (isset($orientation['employee']['pri_contact_fn']))? $orientation['employee']['pri_contact_fn'] : "";
        $emp_name .= (isset($orientation['employee']['pri_contact_ln']))? " " . $orientation['employee']['pri_contact_ln'] : "";

        if($client_id != null && $client_id == 3){
            $training_name = "BAE Systems ES - Contractor Safety Awareness";
        }else{
            $training_name = (isset($orientation['training']['name']))? $orientation['training']['name'] : "";
        }


        $completion_date = (isset($orientation['completion_date']))? $orientation['completion_date'] : "";
        $expiration_date = (isset($orientation['expiration_date']))? $orientation['expiration_date'] : "";
        $completion_date = date('d M Y', strtotime($completion_date));
        $expiration_date = date('d M Y', strtotime($expiration_date));


        $pdf = new FPDI('Portrait','mm',array(215.9,279.4)); // Array sets the X, Y dimensions in mm
        $pdf->AddPage();

        //$pagecount = $pdf->setSourceFile(CERTIFICATE);  // Add pdf template

        $url = TRAINING_CERTIFICATE.'emp_certificate_of_completion.pdf';

        $fileName = 'completion_Certificate_'.$training_id.'_'.$employee_id.'.pdf';
        $localfilePath = TRAINING_CERTIFICATE.$fileName;
        file_put_contents($localfilePath, file_get_contents($url));

        $pagecount = $pdf->setSourceFile($localfilePath);

        $tppl = $pdf->importPage(1);
        $pdf->useTemplate($tppl, 8, 9, 200);
        $pdf->AddFont('Allura-Regular','','Allura-Regular.php');// $pdf->Image($image,10,10,50,50); // X start, Y start, X width, Y width in mm
        $pdf->SetTitle($training_name . ": " . $emp_name);
        $pdf->SetFont('Helvetica','',20); // Font Name, Font Style (eg. 'B' for Bold), Font Size
        $pdf->SetTextColor(0,0,0); // RGB
        // X start, Y start in mm
        // $pdf->Write(1, $contractor->company_name);
        $pageWidth = $pdf->GetPageWidth();
        $width = $pdf->GetStringWidth($emp_name);
        $left = ($pageWidth-$width)/2;

        $pdf->SetXY($left, 71);
        $height = 11.0;
        $border = 0;
        $ln = 1;
        $align = 'C';
        $fill = FALSE;
        $pdf->Cell($width, $height, $emp_name, $border, $ln, $align, $fill);

        $pdf->SetFont('Helvetica','',25);
        $pdf->SetTextColor(0,0,0); // RGB

        /*split heading*/
        $certificateTitle1 = "Employee Orientation";
        $certificateTitle2 = "Completion Certificate";

        $width = $pdf->GetStringWidth($certificateTitle1);
        $left = ($pageWidth-$width)/2;

        $pdf->SetXY($left, 38);
        $pdf->Write(1, $certificateTitle1);

        $width = $pdf->GetStringWidth($certificateTitle2);
        $left = ($pageWidth-$width)/2;

        $pdf->SetXY($left, 54);
        $pdf->Write(1, $certificateTitle2);

        $pdf->SetFont('Helvetica','',12);
        $pdf->SetTextColor(0,0,0); // RGB

        $width = $pdf->GetStringWidth($training_name);
        $left = ($pageWidth-$width)/2;

        $pdf->SetXY($left, 94);
        $pdf->Write(1, $training_name);

            $pdf->SetTextColor(0,0,0); // RGB
            $pdf->SetFont('Helvetica','',10);
            $pdf->SetXY(38, 135);
            $pdf->Write(1, $completion_date);
            $pdf->SetXY(155, 135);
            $pdf->Write(1, $expiration_date);
        //$pdf->SetFont('Helvetica','',10);
        //$pdf->SetXY(164, 152);
        //$pdf->Write(1, $dt_expires);
        $pdf->Output('D', $fileName);
        unlink($localfilePath);
    }

    /*cron for adding/removing training percentage entries*/
    public function percentageEntries(){
        $this->loadModel('EmployeeSites');
        $this->loadModel('Trainings');
        $this->loadModel('TrainingPercentages');
        $this->loadModel('EmployeeContractors');
        $this->loadModel('ContractorClients');

        $training_processed = array();

        $trainings = $this->Trainings->find('all')->select(['id', 'site_ids', 'client_id'])->toArray();
        if(!empty($trainings)){
            foreach($trainings as $training){
                if(isset($training->id) && $training->id > 0){
                    $training_id = $training->id;
                    $client_id = $training->client_id;
                    if(!empty($training->site_ids['s_ids'])){
                        $allEmpsWithSites = $this->EmployeeSites
                            ->find('all')
                            ->contain(['Employees.EmployeeContractors'=>['fields'=>['id']]])
                            ->select(['employee_id','site_id'])
                            ->where(['site_id IN' => $training->site_ids['s_ids']])
                            ->toArray();
                        if(!empty($allEmpsWithSites)){
                            foreach ($allEmpsWithSites as $emp){
                                $employee_id = $emp->employee_id;
                                $exists = 0;
                                $exists = $this->TrainingPercentages
                                    ->find('all')
                                    ->where(['training_id' => $training_id, 'employee_id' => $employee_id, 'archieved' => false])
                                    ->count();
                                if($exists == 0){
                                    $contractor = $this->EmployeeContractors->find('all')->select(['contractor_id'])->where(['employee_id' => $employee_id])->first();
                                    if($contractor == null){
                                        echo 'contractor not found for'.$employee_id.'<br>';
                                    }else{
                                        if(isset($contractor->contractor_id)){
                                            $cliConAssoc = $this->ContractorClients->find('all')->where(['contractor_id' => $contractor->contractor_id, 'client_id' => $client_id])->count();
                                            if(isset($cliConAssoc) && $cliConAssoc > 0){
                                                $trainingpercentage = $this->TrainingPercentages->newEntity();
                                                $trainingpercentage = $this->TrainingPercentages->patchEntity($trainingpercentage, array('training_id'=> $training_id, 'employee_id' => $employee_id, 'contractor_id' => $contractor->contractor_id, 'client_id' => $client_id, 'percentage' => 0));
                                                if ($this->TrainingPercentages->save($trainingpercentage)) {
                                                    echo 'inserted<br>';
                                                }
                                            }else{
                                                echo 'client not found for'.$contractor->contractor_id.'<br>';
                                            }
                                        }
                                    }

                                }/*elseif($exists > 0){
                                    /*contractor is nolonger associated with client, archive training percentage entry
                                    $conn = ConnectionManager::get('default');
                                    $query = "UPDATE training_percentages set archieved = true  where training_id = ".$training_id." and employee_id = ".$employee_id;
                                    $update = $conn->execute($query);
                                    if($update)echo $query.'<br>';
                                }*/
                            }
                        }
                    }
                }
            }
        }
        die;
    }
}
