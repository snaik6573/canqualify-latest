<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Mailer\MailerAwareTrait;       //  Built in function use for sending multiple email
use Cake\Auth\DefaultPasswordHasher;
use Cake\Utility\Security;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

class CustomerRepresentativeController extends AppController
{
    use MailerAwareTrait;

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
    $this->loadModel('Contractors');
    $cr = $this->CustomerRepresentative->find('list',['keyField'=>'id','valueField'=>'user.username'])->contain(['Users'])->toArray();    
    $defaultCr = $this->CustomerRepresentative->find('list',['keyField'=>'id','valueField'=>'id'])->where(['default_cr' => true])->first();
	$totalCount = $this->CustomerRepresentative->find('all')->count();	
        $this->paginate = [
            'contain' => ['Users'],
            'limit'  => $totalCount,
            'maxLimit'=> $totalCount
        ];
    $customerRepresentative = $this->CustomerRepresentative->newEntity();
    if ($this->request->is(['patch', 'post', 'put'])) {
        if($this->request->getData('id')!==null) {
            $id = $this->request->getData('id');
            $this->CustomerRepresentative->query()
                ->update()
                ->set(['default_cr' => false])
                ->execute();

            $this->CustomerRepresentative->query()
                ->update()
                ->set(['default_cr' => true])
                ->where(['id'=>$id])
                ->execute(); 

            $this->Flash->success(__("The Record has been set as default customer Representative"));
            return $this->redirect(['action' => 'index', $id]);
        }

    }
        $customerRepresentative = $this->paginate($this->CustomerRepresentative);
    

        $this->set(compact('customerRepresentative','cr','defaultCr'));
    }

    /**
     * View method
     *
     * @param string|null $id Customer Representative id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $customerRepresentative = $this->CustomerRepresentative->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('customerRepresentative', $customerRepresentative);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $customerRepresentative = $this->CustomerRepresentative->newEntity();
        if ($this->request->is('post')) {
            $customerRepresentative = $this->CustomerRepresentative->patchEntity($customerRepresentative, $this->request->getData());

            $hasher = new DefaultPasswordHasher();
            $secret_key = Security::hash(Security::randomBytes(32), 'sha256', false);	// Generate an API 'token'

            $customerRepresentative->user->secret_key = $secret_key;
            $customerRepresentative->user->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
            if ($this->CustomerRepresentative->save($customerRepresentative)) {
		if($customerRepresentative->user->active==1) {
			$url = Router::Url(['controller' => 'users', 'action' => 'reset-password'], true).'/'.$secret_key.'/1';
			$customerRepresentative->reset_url = $url;

			$this->getMailer('User')->send('register_cr', [$customerRepresentative]);
		}
                $this->Flash->success(__('The customer representative has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customer representative could not be saved. Please, try again.'));
        }
        $users = $this->CustomerRepresentative->Users->find('list', ['limit' => 200]);
        $this->set(compact('customerRepresentative', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Customer Representative id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        //$this->loadModel('Users');
	$this->loadModel('Contractors');
	$this->loadModel('Clients');

        $customerRepresentative = $this->CustomerRepresentative->get($id, [
            'contain' => ['Users']
        ]);
	$prevActive = $customerRepresentative->user->active;

    // $contractorList = $this->Users->find('list', ['keyField'=>'contractor.id', 'valueField'=>'contractor.company_name'])->where(['role_id' => CONTRACTOR, 'active'=>true])->contain(['Contractors'])->order(['company_name'])->toArray();

	//$contractorList = $this->Contractors->find('list', ['keyField'=>'id', 'valueField'=>'company_name'])->contain(['Users'])->order(['company_name'])->toArray();

    //$clientList = $this->Clients->find('list', ['keyField'=>'id', 'valueField'=>'company_name'])->contain(['Users'])->order(['company_name'])->toArray();

	//$asignedContractors = $this->Contractors->find('list', ['keyField'=>'id', 'valueField'=>'id'])->where(['customer_representative_id'=>$customerRepresentative->id])->contain(['Users'])->toArray();

	//$asignedClients = $this->Clients->find('list', ['keyField'=>'id', 'valueField'=>'id'])->where(['customer_representative_id'=>$customerRepresentative->id])->contain(['Users'])->toArray();

        if ($this->request->is(['patch', 'post', 'put'])) {
			/*
            // assign / unasign Contractors

            if (null!==$this->request->getData('contractor_name')) {
		    if (is_array( $this->request->getData('contractor_name'))) {
		        foreach( $this->request->getData('contractor_name') as $contractor_id ) {
				$this->Contractors->query()
				->update()
				->set(['customer_representative_id' => $customerRepresentative->id])
				->where(['id'=>$contractor_id])
				->execute();
		        }
			$unasignedContractors = array_diff($asignedContractors, $this->request->getData('contractor_name'));
		    }
		    else {
			$unasignedContractors = $asignedContractors;
		    }

		    //unasign Contractors
		    if(!empty($unasignedContractors)) {
			$this->Contractors->query()
				->update()
				->set(['customer_representative_id' => ''])
				->where(['id IN'=>$unasignedContractors])
				->execute();
		    }
            }

            // assign / unasign Clients
            if (null!==$this->request->getData('client_name')) {
		    if (is_array( $this->request->getData('client_name') )) {
		        foreach( $this->request->getData('client_name') as $client_id ) {
				$this->Clients->query()
				->update()
				->set(['customer_representative_id' => $customerRepresentative->id])
				->where(['id'=>$client_id])
				->execute();
		        }
			$unasignedClients = array_diff($asignedClients, $this->request->getData('client_name'));
		    }
		    else {
			$unasignedClients = $asignedClients;
		    }

		    //unasign Clients
		    if(!empty($unasignedClients)) {
			$this->Clients->query()
				->update()
				->set(['customer_representative_id' => ''])
				->where(['id IN'=>$unasignedClients])
				->execute();
		    }
            }
			*/
            $customerRepresentative = $this->CustomerRepresentative->patchEntity($customerRepresentative, $this->request->getData());

            $hasher = new DefaultPasswordHasher();
            $secret_key = Security::hash(Security::randomBytes(32), 'sha256', false);	// Generate an API 'token'

            $customerRepresentative->user->secret_key = $secret_key;
            $customerRepresentative->user->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');
            if ($this->CustomerRepresentative->save($customerRepresentative)) {
			// send email on active
            if(!$prevActive && $customerRepresentative->user->active) {
                $url = Router::Url(['controller' => 'users', 'action' => 'reset-password'], true).'/'.$secret_key.'/1';
                $customerRepresentative->reset_url = $url;

                $this->getMailer('User')->send('register_cr', [$customerRepresentative]);
            }
                $this->Flash->success(__('The customer representative has been saved.'));
				return $this->redirect(['action' => 'edit',$id]);
               // return $this->redirect(['action' => 'index']);
            }
            //$this->Flash->error(__('The customer representative could not be saved. Please, try again.'));
        }
        $users = $this->CustomerRepresentative->Users->find('list', ['limit' => 200]);
        $this->set(compact('customerRepresentative', 'users')); //, 'contractorList', 'clientList', 'asignedContractors', 'asignedClients'
    }

    /**
     * Delete method
     *
     * @param string|null $id Customer Representative id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $customerRepresentative = $this->CustomerRepresentative->get($id);
        if ($this->CustomerRepresentative->delete($customerRepresentative)) {
            $this->Flash->success(__('The customer representative has been deleted.'));
        } else {
            $this->Flash->error(__('The customer representative could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function myProfile()
    {	
	    $CR_id = $this->getRequest()->getSession()->read('Auth.User.CR_id');	
	    $customerrepresentative = $this->CustomerRepresentative->get($CR_id, ['contain'=>['Users']]);
		
	    if ($this->request->is(['patch', 'post', 'put'])) {
			$customerrepresentative = $this->CustomerRepresentative->patchEntity($customerrepresentative, $this->request->getData());
			if ($this->CustomerRepresentative->save($customerrepresentative)) {
				
				if(null !== $this->request->getData('user.profile_photo')){
					$this->getRequest()->getSession()->write('Auth.User.profile_photo', $customerrepresentative->user->profile_photo);				
				}
				$this->set('activeUser', $this->getRequest()->getSession()->read('Auth.User'));
				
				$this->Flash->success(__('Profile has been saved.'));
				return $this->redirect(['action'=>'myProfile']);
			}
			$this->Flash->error(__('Profile could not be saved. Please, try again.'));
	    }

	    $this->set(compact('customerrepresentative'));
    }

    public function dashboard()
    {
       $this->loadModel('Users');
       $this->loadModel('Notes');
    
	    $this->getRequest()->getSession()->delete('Auth.User.contractor_id');
		$this->getRequest()->getSession()->delete('Auth.User.contractor_company_name');
		//$this->User->unsetUserSession();	
		
        $user_id = $this->getRequest()->getSession()->read('Auth.User.id');
        $CR_id = $this->getRequest()->getSession()->read('Auth.User.CR_id');

       $this->getRequest()->getSession()->delete('Auth.User.contractor_id');

       $todaydate=date('Y-m-d');
       $nextdate = date('Y-m-d', strtotime("+8 days"));

        $contractors = $this->Users
        ->find()
        ->contain(['Contractors'])
        //->where(['role_id' => CONTRACTOR, 'Contractors.customer_representative_id'=> $CR_id])
		->where(['role_id' => CONTRACTOR, "Contractors.customer_representative_id->'cr_ids' @> " => '['.$CR_id.']'])
        ->count();
		
        /*$clients = $this->Users
        ->find()
        ->contain(['Clients'])
        ->where(['role_id' => CLIENT, 'Clients.customer_representative_id'=> $CR_id])
        ->count();*/
        
         $followup = $this->Notes
        ->find()
        ->where(['created_by'=> $user_id, 'follow_up'=>true])
        ->count();

      /* $todaysfollowup = $this->Notes
        ->find('all')
        ->contain(['Contractors'])
             ->where(['Notes.customer_representative_id'=> $CR_id, 'Notes.feature_date'=>$todaydate, 'follow_up'=>true])
        ->toArray();*/
        
       $conn = ConnectionManager::get('default');

       $todaysfollowup =$conn->execute("SELECT (subscription_date <= '".$nextdate."') as renew_subscription, contractors.id as contractor_id, contractors.*, Notes.*
       FROM notes Notes
       LEFT JOIN contractors Contractors ON Contractors.id = Notes.contractor_id WHERE Notes.created_by=".$user_id." and  Notes.follow_up=true and Notes.is_completed = false")->fetchAll('assoc');

       // $todaysfollowup =$conn->execute("SELECT (subscription_date <= '".$nextdate."') as renew_subscription, contractors.id as contractor_id, contractors.*, Notes.*
       // FROM notes Notes
       // LEFT JOIN contractors Contractors ON Contractors.id = Notes.contractor_id WHERE Notes.created_by=".$user_id." and Notes.feature_date>='".$todaydate."' or Notes.follow_up=true")->fetchAll('assoc');


       $this->set(compact('contractors','followup','todaysfollowup'));
    }

    public function contractorList()
    {
	    ini_set('memory_limit','-1');
        $this->loadModel('Contractors');
        $this->loadModel('Clients');
        $contractor = $this->Contractors->newEntity();

	    $CR_id = $this->getRequest()->getSession()->read('Auth.User.CR_id');	
	    $CustomerRepresentative = $this->CustomerRepresentative->newEntity();
	    $contList = array();

        $allClients = $this->Clients->find('list', ['keyField'=>'id', 'valueField'=>'company_name' ])->toArray();
        
	    $conn = ConnectionManager::get('default');
	    $filterDate = '';
	    $dt = date('Y-m-d', strtotime("+8 days"));

	    //$where = " customer_representative_id=$CR_id";
		$where = " customer_representative_id->'cr_ids' @> '[".$CR_id."]'";

	    if ($this->request->is(['patch', 'post', 'put'])) {
		    if($this->request->getData('sub_date')!='')
		    {
			    $filterDate = $this->request->getData('sub_date');
			    $dt = date('Y-m-d', strtotime("+".$filterDate." days"));

			    $where .= " AND subscription_date <= '".$dt."'";
		    }

            //
		    if(is_array($this->request->getData('user'))) {
	            $this->viewBuilder()->setLayout('ajax');
                // $contractor = $this->Contractors->get($this->request->getData('id'), [
                //     'contain'=>['Users', 'CustomerRepresentative', 'CustomerRepresentative.Users']
                // ]);
                 $contractor = $this->Contractors->get($this->request->getData('id'), [
                    'contain'=>['Users']
                ]);
                $prevActive = $contractor->user->active;
                $contractor = $this->Contractors->patchEntity($contractor, $this->request->getData());
                // send email on active
                /*$cr_ids = $contractor->customer_representative_id['cr_ids'];
                if($contractor->registration_status == 1 && !$prevActive && $contractor->user->active) {
                        //if(isset($contractor->customer_representative) && !empty($contractor->customer_representative) ){
                        //  $cr_email =  $contractor->customer_representative->user->username; 
                        //}
                        $cr_emails = $this->CustomerRepresentative->find('list', ['keyField'=>'id', 'valueField'=>'user.username' ])->where(['CustomerRepresentative.id IN'=>$cr_ids])->contain(['Users'])->toArray();
                        $this->getMailer('User')->send('register_approve', [$contractor->user, $contractor, $cr_emails]);       
                }*/

                if ($this->Contractors->save($contractor)) {
		            echo '<div class="alert with-close alert-success alert-dismissible fade show" role="alert">The contractor has been saved.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
	            }
	            else {
		            echo '<div class="alert with-close alert-danger alert-dismissible fade show" role="alert">The contractor could not be saved. Please, try again.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
	            }
	            exit;
            }
	    }
	    $contList = $conn->execute("SELECT (subscription_date <= '".$dt."') as renew_subscription, contractors.*, users.id as uid, users.username, users.active
	    FROM contractors Contractors 
	    LEFT JOIN users Users ON Users.id = Contractors.user_id WHERE".$where)->fetchAll('assoc');
	    //debug($contList);

	    /*$where['customer_representative_id'] = $CR_id;
	    if ($this->request->is(['patch', 'post', 'put'])) {
		    if($this->request->getData('sub_date')!='')
		    {
			    $filterDate = $this->request->getData('sub_date');
			    $dt = date('Y-m-d', strtotime("+".$filterDate." days"));
			    $where['subscription_date <='] = $dt;
			    $where['payment_status'] = true;
		    }
	    }
	    $contList = $this->Contractors
		    ->find('all')
		    ->contain(['Users'])
		    ->where([$where])
		    ->toArray();*/

	    /*$days = $this->request->getData('sub_date');	
	    $dt = date('Y-m-d H:i:s+05:30', strtotime("+".$days." days -1 year"));	

	    $contList = $conn->execute("SELECT contractors.*, states.name as state_name, countries.name as countries__name, users.username AS users__username, users.active AS users__active,payments.created as subscription FROM contractors  LEFT JOIN states ON states.id = (contractors.state_id) LEFT JOIN countries ON countries.id = (contractors.country_id) LEFT JOIN users ON users.id = (contractors.user_id) LEFT JOIN payments ON payments.contractor_id = (contractors.id) WHERE payments.created <= '".$dt."' and customer_representative_id =".$CR_id." order by payments.created ASC LIMIT ".$totalCount)->fetchAll('assoc');*/
	    
	    $this->set(compact('contList', 'contractor', 'CustomerRepresentative', 'filterDate','allClients'));
    }

    /*public function clientList() {
	    $this->loadModel('Clients');

	    $CR_id = $this->getRequest()->getSession()->read('Auth.User.CR_id');	
	    $CustomerRepresentative = $this->CustomerRepresentative->newEntity();

	    $clientList = $this->Clients->find()->contain(['AccountTypes', 'Users'])->where(['customer_representative_id'=>$CR_id])->toArray();

	    $this->set(compact('clientList', 'CustomerRepresentative'));
    }*/

    public function sendInvoice($contractor_id)
    {
	    $this->loadModel('Contractors');
	    $this->viewBuilder()->setLayout('ajax');

	    $CR_id = $this->getRequest()->getSession()->read('Auth.User.CR_id');
	    $custResentative = $this->CustomerRepresentative->get($CR_id, ['contain'=>['Users']]);

	    $contractor = $this->Contractors->get($contractor_id, ['contain'=>['Users']]);
	  
		$services = $this->User->getContractorServices($contractor_id, true);
		//if($renew_subscription) {
			$invoice = $this->User->calculatePayment($contractor_id, $services,true);
		//}	
	    if ($this->request->is(['patch', 'post', 'put'])) {
	        $data = $this->request->getData();
	        if($this->getMailer('User')->send('send_invoice', [$contractor, $this->request->getData('subject'),  $this->request->getData('message')])) {
		        $contractor->send_invoice = 1;
	                $this->Contractors->save($contractor);
	        }
	        $this->Flash->success(__('The invoice has been sent to the contractor.'));
	        //return $this->redirect(['action'=>'contractorList']);
	    }

	    $this->set(compact('contractor', 'invoice'));
    }

    /*
	public function selectRep()
    {
        $this->loadModel('Clients');
        $this->loadModel('CustomerRepresentative');

        $clients = $this->Clients->find('list',['keyField'=>'id','valueField'=>'company_name']);
        $cr = $this->CustomerRepresentative->find('list',['keyField'=>'id','valueField'=>'user.username'])->contain(['Users'])->toArray();
        $clientList = $this->Clients->find('all')->toArray();
        if ($this->request->is(['patch', 'post', 'put'])) {
            if($this->request->getData()) {
            $cl[] = array();
            $client_id = $this->request->getData('client_id');
            $id = $this->request->getData('id');
            $cl = $this->User->getContractors($client_id);
             
             foreach ($cl as $key => $value) {              
                $contractors = TableRegistry::get('Contractors');
                $query = $contractors->query();
                $query->update()
                ->set(['customer_representative_id' => $id])
                ->where(['id'=>$value])
                ->execute();
            }
             $this->Flash->success(__("The customer Representative has set to the client's contractors"));
            }
          
        } 
     
        $this->set(compact('clients','cr','clientList'));
    }*/
	
    public function loginAs()
    {
        $this->loadModel('Contractors');
        $this->loadModel('Roles');
        $contractor_id =  $this->getRequest()->getSession()->read('Auth.User.contractor_id');  
        $getContractor = $this->Contractors->find()->where(['Contractors.id'=>$contractor_id,'active'=>true])->contain(['Users'])->enableHydration(false)->first();  
        $currentLogin = $this->getRequest()->getSession()->read('Auth.User');
        $CR_id = $this->getRequest()->getSession()->read('Auth.User.CR_id');  
       
        if(!empty($getContractor)){          
   		    $this->Auth->setUser($getContractor['user']);              
		    $this->getRequest()->getSession()->write('Auth.User.lastlogin', $currentLogin);
            $role = $this->Roles->get($getContractor['user']['role_id'])->toArray();

		    $this->getRequest()->getSession()->write('Auth.User.role', $role['role_title']);         		   	
			$this->getRequest()->getSession()->write('Auth.User.contractor_id', $getContractor['id']);
			$this->getRequest()->getSession()->write('Auth.User.registration_status', $getContractor['registration_status']);
			$this->getRequest()->getSession()->write('Auth.User.company_logo', $getContractor['company_logo']);
            
            $this->User->redirectOnlogin();			
		} else {
          $this->Flash->error(__("Invalid Login"));
          return $this->redirect(['controller'=>'Contractors','action'=>'dashboard',$contractor_id]); }	
    }
}
