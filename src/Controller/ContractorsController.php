<?php
namespace App\Controller;
require_once('../vendor/fpdf/fpdf/fpdf.php');
require_once('../vendor/fpdf/fpdi/src/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Mailer\MailerAwareTrait;       //  Built in function use for sending multiple email
use Cake\Datasource\ConnectionManager;
use \setasign\Fpdi\Fpdi;


/**
 * Contractors Controller
 *
 * @property \App\Model\Table\ContractorsTable $Contractors
 *
 * @method \App\Model\Entity\Contractor[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ContractorsController extends AppController
{
    use MailerAwareTrait;

    public function isAuthorized($user)
    {
	$contractorNav = false;
	if($user['role_id'] == SUPER_ADMIN  || $user['role_id'] == ADMIN || $user['role_id'] == CLIENT || $user['role_id'] == CR || $user['role_id'] == CLIENT_ADMIN || $user['role_id'] == CLIENT_VIEW || $user['role_id'] == CLIENT_BASIC) {
		$contractorNav = true;
	}
	$this->set('contractorNav', $contractorNav);
    if($this->request->getParam('action')=='subscriptionsEndReport') {
        $clientNav = true;
       $this->set('clientNav', $clientNav);
    }
    $clientCenterNav = false;
    if(isset($user['client_id']) && ($user['role_id'] == SUPER_ADMIN  || $user['role_id'] == ADMIN )){
        $clientCenterNav = true;
        $clientNav = true;
       $this->set('clientCenterNav', $clientCenterNav);
       $this->set('clientNav', $clientNav);
    }
	if($this->request->getParam('action')=='index') {
		if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN) {
			return true;
		}
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
    // Deferred pagination code 
    /* public function index($export_type=1)
    {
        // $totalCount = $this->Contractors->find('all')->count();                 
        // $this->paginate = [
        //         'contain'=>['States', 'Countries', 'Users', 'Payments'],
        //         'limit'=>$totalCount,
        //         'maxLimit'=>$totalCount
        // ];
        // $contractors = $this->paginate($this->Contractors);   

        $this->loadModel('Clients');
        $allClients = $this->Clients->find('list', ['keyField'=>'id', 'valueField'=>'company_name' ])->toArray();

        $allowForceChange = $this->User->isContractorAssigned();
        if($this->User->isAdmin()) { $allowForceChange = true; }

        $aColumns = array('Contractors.company_name', 'Contractors', 'Users.active', 'Contractors.payment_status','Contractors.waiting_on','Contractors.data_submit','Contractors.data_read','Payments.canqualify_discount','Contractors.created', 'Payments.created','Contractors.modified','');
        if(isset($_GET['draw'])) { 
            $this->viewBuilder()->setLayout('ajax_content');
            
            /*
            * Paging
            */
         /*   $page = $_GET['start'] / $_GET['length'] + 1 ;

            $limit = 10;
            if($_GET['length'] != '-1') { // length != all
                $limit = $_GET['length'];
            }*/

            /*
            * Ordering
            */
           /* $orderArr = [];
            if(!empty($_GET['order'])){
                    $orderArr[] = $aColumns[$_GET['order'][0]['column']].' '.$_GET['order'][0]['dir'];
            }*/

            /*
            * Filtering
            */
           /* $sWhere = [];

            if ($_GET['search']['value'] != "") {
                // search on string fields
                $strCloumns = ['Contractors.company_name', 'Contractors', 'Users.active', 'Contractors.payment_status','Contractors.waiting_on','Contractors.data_submit','Contractors.data_read','Payments.canqualify_discount','Contractors.created', 'Payments.created','Contractors.modified',''];

                foreach($strCloumns as $cl) {
                    $sWhere['OR']['LOWER('.$cl.') LIKE'] = '%'.strtolower($_GET['search']['value']).'%';
                }
            }
*/
          //  print_r($client_id);die;


        //     $this->paginate = [
        //         'page' => $page,
        //         'limit' => $limit,
        //         'contain' => [
        //             'States', 'Countries', 'Users', 'Payments'
        //         ],
        //         'conditions' =>  $sWhere,
        //         'order' => $orderArr
        //     ];
        //     $contractors = $this->paginate($this->Contractors);

        //     //$totalCount = $this->Users->find('all')->count();
        //     $totalCount = $this->request->getParam('paging')['Contractors']['count'];

        //     $this->set(compact('contractors', 'totalCount'));
        // }

        // if ($this->request->is(['patch', 'post', 'put'])) {
        //     $this->viewBuilder()->setLayout('ajax');

            //$contractor = $this->Contractors->find()->where(['Users.username'=>$this->request->getData('user.username')])->contain(['Users','CustomerRepresentative','CustomerRepresentative.Users'])->first();
          /*  $contractor = $this->Contractors->find()->where(['Users.username'=>$this->request->getData('user.username')])->contain(['Users'])->first();
            $prevActive = $contractor->user->active;

            $contractor = $this->Contractors->patchEntity($contractor, $this->request->getData());*/

            // send email on active
            /*$cr_ids = $contractor->customer_representative_id['cr_ids'];
            if($contractor->registration_status == 1 && !$prevActive && $contractor->user->active) {
                    //if(isset($contractor->customer_representative) && !empty($contractor->customer_representative) ){
                    //  $cr_email =  $contractor->customer_representative->user->username;
                    //}
                    $cr_emails = $this->CustomerRepresentative->find('list', ['keyField'=>'id', 'valueField'=>'user.username' ])->where(['CustomerRepresentative.id IN'=>$cr_ids])->contain(['Users'])->toArray();
                    $this->getMailer('User')->send('register_approve', [$contractor->user, $contractor, $cr_emails]);
            }*/

            // set registration_status
           /* if(null !==$this->request->getData('payment_status')) {
                $contractor->registration_status = 1;
                if($contractor->payment_status) {
                    $contractor->registration_status = 3;
                }
            }
            if ($this->Contractors->save($contractor)) {
                echo '<div class="alert with-close alert-success alert-dismissible fade show" role="alert">The contractor has been saved.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
            }
            else {
                echo '<div class="alert with-close alert-danger alert-dismissible fade show" role="alert">The contractor could not be saved. Please, try again.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
            }
            exit;
        }
         $totalCount2 = $this->Contractors->find('all')->count();
        $this->paginate = [
                'contain'=>['States', 'Countries', 'Users', 'Payments'],
                'limit'=>$totalCount2,
                'maxLimit'=>$totalCount2
        ];
        $contractorsExport = $this->paginate($this->Contractors);

        if($export_type ==0) {
            $i =0;
            $data = array();
            if(!empty($contractorsExport)) {
                foreach ($contractorsExport as  $contractor) {
                    $getClients = $this->User->getClients($contractor->id);
                    $clients = [];
                    foreach ($getClients as $cid) { $clients[] = $allClients[$cid]; }
                    $data[$i]['company_name'] = $contractor['company_name'];
                    $data[$i]['username'] = $contractor->user['username'];
                    $data[$i]['no_of_clients'] = count($clients);
                    $data[$i]['waiting_on'] = $contractor['waiting_on'];
                    $data[$i]['registration_date'] = !empty($contractor->payments) ? $contractor->payments[0]->created : '';
                    $data[$i]['last_update'] = $contractor['modified'];
                    $i++;
                }
            }

            $headT = array('Contractor Company Name','Username','No.of Clients','Waiting On','Registration Date','Last Update');
            $title = 'Contractors';
            if($export_type == 'excel') {
                    $this->Export->XportToExcelData($data,$headT,$title);
                    exit;
            }
            if($export_type == 'csv') {
                    $this->Export->XportToCSVData($data,$headT,$title);
                    exit;
            }
        }
        $this->set(compact('allowForceChange','allClients'));
    }*/
    public function index($export_type=1)
    {
    	$totalCount = $this->Contractors->find('all')->count();
        $this->paginate = [
                'contain'=>['States', 'Countries', 'Users', 'Payments'],
                'limit'=>$totalCount,
                'maxLimit'=>$totalCount
        ];
    	$contractors = $this->paginate($this->Contractors);

    	$this->loadModel('Clients');
		$this->loadModel('CustomerRepresentative');
    	$allClients = $this->Clients->find('list', ['keyField'=>'id', 'valueField'=>'company_name' ])->toArray();

    	$allowForceChange = $this->User->isContractorAssigned();
    	if($this->User->isAdmin()) { $allowForceChange = true; }

        if ($this->request->is(['patch', 'post', 'put'])) {
    	    $this->viewBuilder()->setLayout('ajax');

            //$contractor = $this->Contractors->find()->where(['Users.username'=>$this->request->getData('user.username')])->contain(['Users','CustomerRepresentative','CustomerRepresentative.Users'])->first();
			$contractor = $this->Contractors->find()->where(['Users.username'=>$this->request->getData('user.username')])->contain(['Users'])->first();
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

            // set registration_status
            if(null !==$this->request->getData('payment_status')) {
            	$contractor->registration_status = 1;
            	if($contractor->payment_status) {
            		$contractor->registration_status = 3;
            	}
            }
            if ($this->Contractors->save($contractor)) {
        		echo '<div class="alert with-close alert-success alert-dismissible fade show" role="alert">The contractor has been saved.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
        	}
        	else {
        		echo '<div class="alert with-close alert-danger alert-dismissible fade show" role="alert">The contractor could not be saved. Please, try again.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
        	}
        	exit;
        }
        $role_id = $this->getRequest()->getSession()->read('Auth.User.role_id');
        if($export_type ==0) {
    		$i =0;
    		$data = array();
    		if(!empty($contractors)) {
    			foreach ($contractors as  $contractor) {
                    $getClients = $this->User->getClients($contractor->id);
                    $clients = [];
                    foreach ($getClients as $cid) { $clients[] = $allClients[$cid]; }
    				$data[$i]['company_name'] = $contractor['company_name'];
                    if($this->User->isAdmin()) {
                    $data[$i]['primary_contact_name'] = $contractor['pri_contact_fn'].' '.$contractor['pri_contact_ln'];
                    }
                    $data[$i]['username'] = $contractor->user['username'];
    				$data[$i]['no_of_clients'] = count($clients);
    				$data[$i]['waiting_on'] = $contractor['waiting_on'];
                    $data[$i]['registration_date'] = !empty($contractor->payments) ? $contractor->payments[0]->created : '';
                    $data[$i]['last_update'] = $contractor['modified'];
    				$i++;
    			}
    	    }
            if($this->User->isAdmin()) {
    	    $headT = array('Contractor Company Name','Primary Contact Name','Username','No.of Clients','Waiting On','Registration Date','Last Update');
            }else{
            $headT = array('Contractor Company Name','Username','No.of Clients','Waiting On','Registration Date','Last Update');
            }
            $title = 'Contractors';
        	if($export_type == 'excel') {
        			$this->Export->XportToExcelData($data,$headT,$title);
        			exit;
        	}
        	if($export_type == 'csv') {
        			$this->Export->XportToCSVData($data,$headT,$title);
        			exit;
        	}
    	}
        $this->set(compact('contractors', 'allowForceChange','allClients'));
    }
     public function supplierList($export_type=1)
    {
        $totalCount = $this->Contractors->find('all')->count();
        $this->paginate = [
                'contain'=>['States', 'Countries', 'Users', 'Payments'],
                'limit'=>$totalCount,
                'maxLimit'=>$totalCount
        ];
        $contractors = $this->paginate($this->Contractors);

        $this->loadModel('Clients');
        $this->loadModel('CustomerRepresentative');
        $allClients = $this->Clients->find('list', ['keyField'=>'id', 'valueField'=>'company_name' ])->toArray();

        $allowForceChange = $this->User->isContractorAssigned();
        if($this->User->isAdmin()) { $allowForceChange = true; }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->viewBuilder()->setLayout('ajax');

            //$contractor = $this->Contractors->find()->where(['Users.username'=>$this->request->getData('user.username')])->contain(['Users','CustomerRepresentative','CustomerRepresentative.Users'])->first();
            $contractor = $this->Contractors->find()->where(['Users.username'=>$this->request->getData('user.username')])->contain(['Users'])->first();
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

            // set registration_status
            /*if(null !==$this->request->getData('payment_status')) {
                $contractor->registration_status = 1;
                if($contractor->payment_status) {
                    $contractor->registration_status = 3;
                }
            }*/
            if ($this->Contractors->save($contractor)) {
                echo '<div class="alert with-close alert-success alert-dismissible fade show" role="alert">The contractor has been saved.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
            }
            else {
                echo '<div class="alert with-close alert-danger alert-dismissible fade show" role="alert">The contractor could not be saved. Please, try again.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
            }
            exit;
        }
        $role_id = $this->getRequest()->getSession()->read('Auth.User.role_id');
        if($export_type ==0) {
            $i =0;
            $data = array();
            if(!empty($contractors)) {
                foreach ($contractors as  $contractor) {
                    $getClients = $this->User->getClients($contractor->id);
                    $clients = [];
                    foreach ($getClients as $cid) { $clients[] = $allClients[$cid]; }
                    $data[$i]['company_name'] = $contractor['company_name'];
                    if($this->User->isAdmin()) {
                    $data[$i]['primary_contact_name'] = $contractor['pri_contact_fn'].' '.$contractor['pri_contact_ln'];
                    }
                    $data[$i]['username'] = $contractor->user['username'];
                    $data[$i]['no_of_clients'] = count($clients);
                    $data[$i]['waiting_on'] = $contractor['waiting_on'];
                    $data[$i]['registration_date'] = !empty($contractor->payments) ? $contractor->payments[0]->created : '';
                    $data[$i]['last_update'] = $contractor['modified'];
                    $i++;
                }
            }
            if($this->User->isAdmin()) {
            $headT = array('Contractor Company Name','Primary Contact Name','Username','No.of Clients','Waiting On','Registration Date','Last Update');
            }else{
            $headT = array('Contractor Company Name','Username','No.of Clients','Waiting On','Registration Date','Last Update');
            }
            $title = 'Contractors';
            if($export_type == 'excel') {
                    $this->Export->XportToExcelData($data,$headT,$title);
                    exit;
            }
            if($export_type == 'csv') {
                    $this->Export->XportToCSVData($data,$headT,$title);
                    exit;
            }
        }
        $this->set(compact('contractors', 'allowForceChange','allClients'));
    }
    /**
     * View method
     *
     * @param string|null $id Contractor id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $contractor = $this->Contractors->get($id, [
            'contain'=>['States', 'Countries', 'Users']
        ]);
        $gc_client =
        $this->set('contractor', $contractor);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
    $this->loadModel('Users');
    $this->loadModel('Countries');
    $this->loadModel('States');
	$this->loadModel('CustomerRepresentative');

        $contractor = $this->Contractors->newEntity();
		$waiting_on = $this->User->waiting_status();
		$customer_rep_ids = Configure::read('Contractor_CR');

        if ($this->request->is('post')) {
            if((($this->request->getData(['country_id']) != null) || ($this->request->getData(['state_id']) != null)) && ($this->request->getData(['country_id']) == 0)){
                $user_entered = true; // User entered Country and State

                /* User entered Country and State */
                $user = $this->Users->newEntity();
                $user = $this->Users->patchEntity($user, $this->request->getData(['user']));
                $user->role_id = CONTRACTOR;
                $user->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
                $user->active = true;

                if($user_result = $this->Users->save($user)) {

                    $country = $this->Countries->newEntity();
                    $country->name = $this->request->getData(['country']);
                    $country->created_by = $user_result->id;
                    $country->user_entered = $user_entered;
                    $country_result = $this->Countries->save($country);

                    $state = $this->States->newEntity();
                    $state->name = $this->request->getData(['state']);
                    $state->country_id = $country_result->id;
                    $state->user_entered = $user_entered;
                    $state->created_by = $user_result->id;
                    $state_result = $this->States->save($state);

                    $contractor = $this->Contractors->patchEntity($contractor, $this->request->getData());
                    unset($contractor['user']);

                    $contractor->registration_status = 1;
                    $contractor->waiting_on = $waiting_on['Contractor'];
                    $contractor->customer_representative_id = ['cr_ids' => array_values($customer_rep_ids)];
                    $contractor->user_id = $user_result->id;
                    $contractor->country_id = $country_result->id;
                    $contractor->state_id = $state_result->id;
                    /*format tin before save*/
                    if($contractor->company_tin) {
                        $contractor->company_tin = preg_replace("/[^0-9.]/", '', $contractor->company_tin);
                    }

                      /*if($this->request->getData('customer_representative_id')!=null) {
                        $contractor->customer_representative_id =  $this->request->getData('customer_representative_id');
                    } */

                    /*format tin before save*/
                    if($contractor->company_tin) {
                        $contractor->company_tin = preg_replace("/[^0-9.]/", '', $contractor->company_tin);
                    }
                      if ($result = $this->Contractors->save($contractor)) {
                        /*if($contractor->user->active==1 ) {
                            $this->getMailer('User')->send('register_approve', [$contractor->user,$contractor]);
                        }*/
                        $this->User->associateWithMarketplace($result['id']);
			            /* save contractor_answers */
			            $this->User->update_contractor_ans($this->request->getData(), $contractor->id, $user->id);

                        $this->Flash->success(__('The contractor has been saved.'));

                        return $this->redirect(['action'=>'index']);
                    }
                }
                $this->Flash->error(__('The contractor could not be saved. Please, try again.'));
                return $this->redirect(['controller' => 'Contractors', 'action' => 'add']);

            } else { // Normal add contractos

            $contractor = $this->Contractors->patchEntity($contractor, $this->request->getData());
            $contractor->user->role_id = CONTRACTOR;
            $contractor->user->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
			$contractor->user->active = true;
            $contractor->registration_status = 1;
            $contractor->waiting_on = $waiting_on['Contractor'];
			$contractor->customer_representative_id = ['cr_ids' => array_values($customer_rep_ids)];
            /*if($this->request->getData('customer_representative_id')!=null) {
                $contractor->customer_representative_id =  $this->request->getData('customer_representative_id');
            } */
			if ($result = $this->Contractors->save($contractor)) {
				/*if($contractor->user->active==1 ) {
					$this->getMailer('User')->send('register_approve', [$contractor->user,$contractor]);
				}*/
                $this->User->associateWithMarketplace($result['id']);
	            /* save contractor_answers */
	            $this->User->update_contractor_ans($this->request->getData(), $contractor->id, $contractor->user->id);

                $this->Flash->success(__('The contractor has been saved.'));

                return $this->redirect(['action'=>'index']);
            }
            $this->Flash->error(__('The contractor could not be saved. Please, try again.'));
         }
        }
        $states = $this->Contractors->States->find('list')->where(['user_entered'=>false])->toArray();
        $countries = $this->Contractors->Countries->find('list')->where(['user_entered'=>false])->toArray();
        $customer_rep = $this->CustomerRepresentative->find('list', ['keyField'=>'id', 'valueField'=>'user.username' ])->contain(['Users']);
        $this->set(compact('contractor', 'states', 'countries', 'customer_rep'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Contractor id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->loadModel('Clients');
        $contractor = $this->Contractors->get($id, [
            'contain'=>['Users']
        ]);
	    $prevActive = $contractor->user->active;

	    $this->loadModel('CustomerRepresentative');

        if ($this->request->is(['patch', 'post', 'put'])) {

            $contractor = $this->Contractors->patchEntity($contractor, $this->request->getData());
            /*if($this->request->getData('customer_representative_id')!=null) {
	        $contractor->customer_representative_id = implode(',', $this->request->getData('customer_representative_id'));
            }*/

            // send email on active
            /*if($contractor->registration_status == 1 && !$prevActive && $contractor->user->active) {
				$this->getMailer('User')->send('register_approve', [$contractor->user,$contractor]);
            }*/

            // set registration_status
            if($contractor->payment_status) {
		        $contractor->registration_status = 3;
            }
            elseif($contractor->registration_status==3) {
	        	$contractor->registration_status = 1;
            }
            /*format tin before save*/
            if(!empty($this->request->getData('company_tin'))) {
                $contractor->company_tin = preg_replace("/[^0-9.]/", '', $this->request->getData('company_tin'));
            }
            if ($this->Contractors->save($contractor)) {

	            /* save contractor_answers */
	            $this->User->update_contractor_ans($this->request->getData(), $contractor->id, $contractor->user->id);

                $this->Flash->success(__('The contractor has been saved.'));

                return $this->redirect(['action'=>'index']);
            }
            $this->Flash->error(__('The contractor could not be saved. Please, try again.'));
        }
        $where = ['OR'=>['user_entered IS NOT'=>true,'created_by'=>$contractor->user_id]];
        $states = $this->Contractors->States->find('list')->where(['country_id'=>$contractor->country_id,$where])->toArray();
        $countries = $this->Contractors->Countries->find('list')->where($where)->toArray();
        $customer_rep = $this->CustomerRepresentative->find('list', ['keyField'=>'id', 'valueField'=>'user.username' ])->contain(['Users']);
        $gc_clients = $this->Clients->find('list', ['keyField'=>'id', 'valueField'=>'company_name' ])->where(['is_gc' => true])->order(['company_name'])->toArray();

        $this->set(compact('contractor', 'states', 'countries', 'customer_rep', 'gc_clients'));
    }

    public function updateLocation($id = null)
    {
        $contractor = $this->Contractors->get($id, [
            'contain'=>['States', 'Countries', 'Users']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contractor = $this->Contractors->patchEntity($contractor, $this->request->getData());
            if ($this->Contractors->save($contractor)) {
                $this->Flash->success(__('The contractor has been saved.'));

                return $this->redirect(['action'=>'index']);
            }
            $this->Flash->error(__('The contractor could not be saved. Please, try again.'));
        }
        $this->set(compact('contractor'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Contractor id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $contractor = $this->Contractors->get($id);
        if ($this->Contractors->delete($contractor)) {
            $this->Flash->success(__('The contractor has been deleted.'));
        } else {
            $this->Flash->error(__('The contractor could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action'=>'index']);
    }

    public function myProfile()
    {
	$this->loadModel('Clients');

	$contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
	$contractor_clients = $this->User->getClients($contractor_id);
    $user_id = $this->getRequest()->getSession()->read('Auth.User.id');

	// $clients = array();
	// if(!empty($contractor_clients)) {
	// 	$clients = $this->Clients
	// 	->find('all', ['fields'=>['pri_contact_fn','pri_contact_ln', 'company_name']])
	// 	->distinct()
	// 	->where(['id IN'=>$contractor_clients])
	// 	->toArray();
	// }
    $contractor = $this->Contractors->get($contractor_id,
    ['contain'=>[
		'Users'=>['fields'=>['Users.id', 'Users.username', 'Users.profile_photo']],
		//'ContractorSites'=>['fields'=>['ContractorSites.id','ContractorSites.contractor_id'],'conditions'=>['ContractorSites.is_archived'=>false]],
		//'ContractorSites.Sites'=>['fields'=>['name']],
		//'ContractorSites.Sites.Clients'=>['fields'=>['pri_contact_fn','pri_contact_ln']],
		//'ContractorSites.Sites.Regions'=>['fields'=>['name']]
	] ]);

	if ($this->request->is(['patch', 'post', 'put'])) {
		$contractor = $this->Contractors->patchEntity($contractor, $this->request->getData());
        /*format tin before save*/
        if($contractor->company_tin) {
            $contractor->company_tin = preg_replace("/[^0-9.]/", '', $contractor->company_tin);
        }

		if ($result = $this->Contractors->save($contractor)) {

			/* save contractor_answers */
			$this->User->update_contractor_ans($this->request->getData(), $contractor_id, $user_id);
            if(null !== $this->request->getData('emp_req') ){
                $this->getRequest()->getSession()->write('Auth.User.emp_req', $contractor->emp_req);
            }
			if(null !== $this->request->getData('company_logo')){
				$this->getRequest()->getSession()->write('Auth.User.company_logo', $contractor->company_logo);
			}
			if(null !== $this->request->getData('user.profile_photo')){
				$this->getRequest()->getSession()->write('Auth.User.profile_photo', $contractor->user->profile_photo);
			}
			$this->set('activeUser', $this->getRequest()->getSession()->read('Auth.User'));

			$this->Flash->success(__('Profile has been saved.'));
			return $this->redirect(['action'=>'myProfile']);
		}

		$this->Flash->error(__('Profile could not be saved. Please, try again.'));
	}
	$where = ['OR'=>['user_entered IS NOT'=>true,'created_by'=>$contractor->user_id]];
	$states = $this->Contractors->States->find('list')->where(['country_id'=>$contractor->country_id,$where])->toArray();
	$countries = $this->Contractors->Countries->find('list')->where($where)->toArray();

	$this->set(compact('contractor', 'states', 'countries'));
    }

    public function dashboard($contractor_id=null)
    {
	$this->loadModel('CustomerRepresentative');
	$this->loadModel('ClientModules');
	$this->loadModel('Employees');
    $this->loadModel('BenchmarkCategories');
	$this->loadModel('ClientUsers');
    $this->loadModel('ContractorFeedbacks');
    $this->loadModel('ContractorClients');
	if($this->User->isContractor()) {
		$contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
	}
	else {
		$contractor = $this->Contractors->get($contractor_id);
		$this->getRequest()->getSession()->write('Auth.User.contractor_id', $contractor_id);
		$this->getRequest()->getSession()->write('Auth.User.contractor_company_name', $contractor->company_name);
		$this->set('activeUser', $this->getRequest()->getSession()->read('Auth.User'));
	}

	//unset employee
	$this->getRequest()->getSession()->delete('Auth.User.employee_id');
    $this->set('activeUser', $this->getRequest()->getSession()->read('Auth.User'));
	//$this->User->unsetUserSession();

	$client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
	$contractor_clients = $this->User->getClients($contractor_id);

	$enable_signedDoc = 0;
	$enable_clientManager = 0;
	$is_client = 0;
	if($this->User->isClient()) {
		$is_client = 1;
		$enable_signedDoc = $this->ClientModules->find('all')->where(['client_id'=>$client_id, 'module_id'=>1])->count();
		$enable_clientManager = $this->ClientModules->find('all')->where(['client_id'=>$client_id, 'module_id'=>2])->count();
	}
	elseif(!empty($contractor_clients)) {
		$enable_signedDoc = $this->ClientModules->find('all')->where(['client_id IN'=>$contractor_clients, 'module_id'=>1])->count();
		$enable_clientManager = $this->ClientModules->find('all')->where(['client_id IN'=>$contractor_clients, 'module_id'=>2])->count();
	}

	$enable_membershipBlock = true;
	if(!empty($contractor_clients) && in_array(3 , $contractor_clients)){
        $enable_membershipBlock = false;
    }

	$waiting_on = $this->User->waiting_status_ids();
	$allowForceChange = $this->User->isContractorAssigned();
	if($this->User->isAdmin()) { $allowForceChange = true; }

	$contractor = $this->Contractors->get($contractor_id, [
            'contain'=>['States', 'Countries', 'Users', 'Payments']
        ]);
	$company_name = $contractor->company_name;

	if ($this->request->is(['patch', 'post', 'put'])) {
            $prevActive = $contractor->user->active;
            $preWaitingStatus = $contractor->waiting_on;

            $contractor->is_locked = false;
            $contractor = $this->Contractors->patchEntity($contractor, $this->request->getData());
            if(!empty($this->request->getData('subscription_date'))){
                $contractor->subscription_date =  date('m/d/Y', strtotime($this->request->getData('subscription_date')));
            }

            // send email on active
            /*if($contractor->registration_status == 1 && !$prevActive && $contractor->user->active) {
			    $this->getMailer('User')->send('register_approve', [$contractor->user,$contractor]);
            }*/

            if($this->request->getData('category') != null){
                $overallIcon_id = $this->request->getData('o_id');
				$overallIcon = $this->Contractors->OverallIcons->find()->where(['contractor_id'=>$contractor_id,'id'=>$overallIcon_id])->first();
                $category = $this->request->getData('category');
                $overallIcon->category = $category;
                $this->Contractors->OverallIcons->save($overallIcon);
            }
			if($this->request->getData('client_id') != null){
			     $requestData = $this->request->getData();
				 $selected_managers[] = $requestData['client_manager'];

				 $contClients = $this->Contractors
				 ->ContractorClients->find()
				 ->where(['contractor_id'=>$contractor_id,'client_id'=>$requestData['client_id']])
				 ->first();
				 $contClients->client_manager = ['mg_ids' => array_values($selected_managers)];

				 $this->Contractors->ContractorClients->save($contClients);
			}
            if ($this->Contractors->save($contractor)) {
                $this->Flash->success(__('The contractor has been saved.'));
                //return $this->redirect(['action'=>'dashboard']);
            }
            //$this->Flash->error(__('The contractor could not be saved. Please, try again.'));
        }

        //contractor forms n docs
        $enable_conFND = 0;
        if($this->User->isClient()) {
            $enable_conFND = $this->ClientModules->find('all')->where(['client_id'=>$client_id, 'module_id'=>CONTRACTOR_FND])->count();
        }
        elseif(!empty($contractor_clients)) {
            $enable_conFND = $this->ClientModules->find('all')->where(['client_id IN'=>$contractor_clients, 'module_id'=>CONTRACTOR_FND])->count();
        }

        $formsNDocsContractor= array();
        if($enable_conFND){
            $formsNDocsContractor = $this->formsnDocs(null, null, $contractor_id);
        }
	//get Customer Representative
	$customer_rep =array();
	/*if($contractor->customer_representative_id !=null){
		$customer_rep = $this->CustomerRepresentative->find()->contain(['Users'=>['fields'=>['id', 'username']]])->where(['CustomerRepresentative.id'=>$contractor->customer_representative_id, 'Users.active IS'=>true])->toArray();
	}*/
	if($contractor->customer_representative_id['cr_ids'] !=null){
		$cr_ids = $contractor->customer_representative_id['cr_ids'];
		$customer_rep = $this->CustomerRepresentative->find()->contain(['Users'=>['fields'=>['id', 'username']]])->where(['CustomerRepresentative.id IN'=>$cr_ids, 'Users.active IS'=>true])->toArray();
	}
	// contractor Reviews
	$reviews = $this->getReview($contractor_id);

	// Client Matrix
    $matrix = array();
	$matrix = $this->clientMatrix($contractor_id,$client_id,$contractor_clients);
	//Assign Client Manager
	$cont_clients = $this->cont_clients($contractor_id,$client_id,$contractor_clients);

	$clientManagers = array();
	$i=0;
	foreach($cont_clients as $cont_client){
		$selected_manager=null;

        if( isset($cont_client->client_manager['mg_ids']) ) {
		    $managers = $cont_client->client_manager['mg_ids'];
        }
		$clientMangersList = $this->getClientMangerList($cont_client['client_id']);
		if(!empty($managers)){
		$selected_manager = $this->ClientUsers->find()->contain(['Users'=>['fields'=>['id', 'username']]])->where(['ClientUsers.id IN'=>$managers, 'Users.active IS'=>true])->first();
		}
		$clientManagers[$i]['id']=$cont_client['id'];
		$clientManagers[$i]['contractor_id']=$cont_client['contractor_id'];
		$clientManagers[$i]['client_id']=$cont_client['client_id'];
		$clientManagers[$i]['client_company_name']=$cont_client->client->company_name;
		$clientManagers[$i]['client_users']=$clientMangersList;
		$clientManagers[$i]['selected_manager']=$selected_manager;
		$i++;
	}

	//Rate and Write a Review
	$reviewRatearr = $this->reviewRate($contractor_id, $client_id);
	$overallReview = $this->overallReview($contractor_id);

    if(!empty($contractor_clients)) {
	    // Client Forms & Docs
	    $formsNDocs = $this->formsnDocs($client_id, $contractor_clients);

	    // signed documents
	    $getdocuments = $this->getDocuments($client_id, $contractor_clients,$contractor_id);
	    $documents = $getdocuments['documents'];
	    $acceptedDocuments = $getdocuments['acceptedDocuments'];

        $this->set(compact('documents', 'acceptedDocuments', 'formsNDocs'));
	}
    $cl_id= $this->User->getClients($contractor_id);
    if(!empty($cl_id)){
    $site_visit = $this->Clients->find('list',['valueField'=>'site_visited'])->where(['id IN'=>$cl_id])->enableHydration(false)->toArray();
    $this->set(compact('site_visit'));
	}
    $greenIcon = $this->iconCheck($contractor_id);
    $contFeedback = $this->ContractorFeedbacks->find('list')->where(['contractor_id'=>$contractor_id])->toArray();

	$contractorSites = $this->User->getContractorSites($contractor_id);
        $locationOpenTask = $this->User->checkContractorLocations($contractor_id);
    $contractorEmp = $this->User->getContractorEmp($contractor_id);
    //pr($contractorEmp);die;
    if(!empty($contractorEmp)){
    $employees = $this->Employees->find()->select(['id','pri_contact_fn','pri_contact_ln'])
        ->where(['id IN'=>$contractorEmp])->enableHydration(false)->toArray();
        $this->set(compact('employees'));
    }
        $showFinalSubmitData = true;
            if(!empty($matrix)){
                foreach ($matrix as $conCli){
                        if($conCli['waiting_on'] != 1){
                                $showFinalSubmitData = false;
                            }
        }
    }
    $this->set(compact('contractor', 'customer_rep', 'matrix', 'showFinalSubmitData', 'waiting_on', 'company_name','allowForceChange', 'reviews', 'reviewRatearr', 'overallReview','client_id',  'enable_signedDoc', 'enable_membershipBlock', 'is_client','enable_clientManager', 'contractorSites','clientManagers','greenIcon','contFeedback','locationOpenTask', 'enable_conFND', 'formsNDocsContractor'));
    }
	  public function iconCheck($contractor_id = null){
        if($this->User->isContractor()) {
            $contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
        }
        $getClients = $this->User->getClients($contractor_id);
        $icons = array();
        $greenIcon = false;
        $overallIcons = $this->Contractors->FinalOverallIcons->find()->where(['contractor_id'=>$contractor_id])->toArray();
        foreach ($overallIcons as $key => $overallIcon) {
                $icons[] = $overallIcon['icon'];     }
        if(in_array(3, $icons)){ $greenIcon = true;
        }
        return $greenIcon;
    }
    public function reviewRate($contractor_id=null,$client_id=null)
    {
	$this->loadModel('Reviews');

	$reviewcnt = 0 ;
	if($client_id!=null) {
		$reviewcnt = $this->Reviews->find('all')->where(['client_id'=>$client_id,'contractor_id'=>$contractor_id])->count();
	}
	$allReviewCnt = $this->Reviews->find('all')->where(['contractor_id'=>$contractor_id])->count();

	$reviewRate = array();
	$reviewRate = $this->Reviews
	->find('all')
	->where(['contractor_id'=> $contractor_id])
	->contain(['Clients'=> ['fields'=> ['id', 'company_name']] ])
	->limit(3)
	->order(['Reviews.id'=>'DESC'])
	->toArray();

	return array($reviewcnt, $allReviewCnt, $reviewRate);
    }

    public function overallReview($contractor_id=null)
    {
	$this->loadModel('Reviews');
	$rate = $this->Reviews
		->find('list', ['keyField'=>'id', 'valueField'=>'rating' ])
		->where(['contractor_id'=> $contractor_id])
		->toArray();
	$overallReview = array_sum($rate);
	return $overallReview;
    }

    public function formsnDocs($client_id=null, $contractor_clients=array(), $contractor_id=null)
    {
	$this->loadModel('FormsNDocs');

	if($client_id!=null) {
        $formsNDocsWhere['show_to_contractor'] = true;
        $formsNDocsWhere['client_id'] = $client_id;
    } elseif(!empty($contractor_clients)) {
        $formsNDocsWhere['show_to_contractor'] = true;
        $formsNDocsWhere['client_id IN']= $contractor_clients;
    }elseif($contractor_id != null){
        $formsNDocsWhere['contractor_id'] = $contractor_id;
    }
    if($contractor_id != null){
        $formsNDocs = $this->FormsNDocs
            ->find()
            ->where($formsNDocsWhere)
            ->toArray();
    }else{
        $formsNDocs = $this->FormsNDocs
            ->find()
            ->where($formsNDocsWhere)
            ->contain(['Clients'=> ['fields'=> ['id', 'company_name']] ])
            ->toArray();
    }

	return $formsNDocs;
    }
	public function cont_clients($contractor_id=null,$client_id=null,$contractor_clients=array())
    {
	$this->loadModel('ContractorClients');

	$cliManagerWhere['ContractorClients.contractor_id'] = $contractor_id;
	if($client_id!=null) {
        $cliManagerWhere['ContractorClients.client_id'] = $client_id;
    } elseif(!empty($contractor_clients)) {
        $cliManagerWhere['ContractorClients.client_id IN']= $contractor_clients;
    }

	$cont_clients = $this->ContractorClients
	->find('all')
	->distinct(['ContractorClients.client_id'])
	->contain(['Clients'=> ['fields'=> ['id', 'company_name']] ])
	->contain(['Clients.ClientUsers'=> ['fields'=> ['ClientUsers.id','ClientUsers.client_id', 'pri_contact_fn','pri_contact_ln','pri_contact_pn','user_id']]])
	->contain(['Clients.ClientUsers.Users'=>['fields'=> ['Users.id','username']]])
	->where($cliManagerWhere)
	->toArray();
	return $cont_clients;
    }
	public function getClientMangerList($client_id=null)
	{
		$this->loadModel('ClientUsers');
		$clientMangersList = $this->ClientUsers
		->find('list',['keyField'=>'id', 'valueField'=>function ($e) { return $e->pri_contact_fn.' '.$e->pri_contact_ln; }])
		->contain(['Clients'])
		->contain(['Users'])
		->where(['client_id'=> $client_id])
		->toArray();

		return $clientMangersList;
	}
    public function clientMatrix($contractor_id=null,$client_id=null,$contractor_clients=array())
    {
	/*$this->loadModel('OverallIcons');
	$matrixWhere['OverallIcons.contractor_id'] = $contractor_id;
	if($client_id!=null) {
        $matrixWhere['OverallIcons.client_id'] = $client_id;
    } elseif(!empty($contractor_clients)) {
        $matrixWhere['OverallIcons.client_id IN']= $contractor_clients;
    }


	$matrix = $this->OverallIcons
	->find('all')
	->distinct(['OverallIcons.client_id'])
	->where($matrixWhere)
	->contain(['Clients'=> ['fields'=> ['id', 'company_name']] ])
	->contain(['BenchmarkCategories' => ['fields'=> ['name']] ])
	->order(['OverallIcons.client_id', 'OverallIcons.created'=>'DESC'])
	->toArray();
	return $matrix;*/
        $conn = ConnectionManager::get('default');
        $matrix = array();

        $where = " where TRUE";
        if($contractor_id != null){
            $where .= " AND contractor_clients.contractor_id = ".$contractor_id;
        }
        if($client_id != null){
            $where .= " AND contractor_clients.client_id = ".$client_id;
        }
        if(!empty($contractor_clients)){
            $where .= " AND contractor_clients.client_id IN (".implode(',', $contractor_clients).")";
        }
	    $query = "SELECT contractor_clients.*, clients.company_name, clients.is_gc, final_overall_icons.icon  FROM contractor_clients LEFT JOIN clients ON (contractor_clients.client_id = clients.id) LEFT JOIN final_overall_icons ON (contractor_clients.contractor_id = final_overall_icons.contractor_id AND contractor_clients.client_id = final_overall_icons.client_id)". $where;
        $matrix = $conn->execute($query)->fetchAll('assoc');
        return $matrix;
    }

    public function getReview($contractor_id=null)
    {
	$this->loadModel('OverallIcons');
	$reviews = $this->OverallIcons
	->find('all')
	->where(['contractor_id'=>$contractor_id, 'review'=>1])
	->contain(['Clients'=> ['fields'=> ['id', 'company_name']] ])
	->contain(['BenchmarkCategories' => ['fields'=> ['name']] ])
	->order(['OverallIcons.client_id'])
	->toArray();
	return $reviews;
    }

   /* public function getDocuments($client_id=null, $contractor_clients=array(),$contractor_id=null)
    {
	$this->loadModel('Clients');

	$documents = array();
	$acceptedDocuments = array();
	$DocWhere = array();

	if($client_id!=null) { $DocWhere['id'] = $client_id; }
	else { $DocWhere['id IN']= $contractor_clients; }

	$parentDoc = $this->Clients
	->find('all')
	->contain(['Documents'=>['conditions'=>['contractor_id'=>$contractor_id, 'document_id IS'=>null],
		'queryBuilder' => function ($q) { return $q->order(['Documents.id' =>'ASC']);}
	]])
	->contain(['Documents.Users'=>['fields'=>['id', 'role_id']]])
	->contain(['Documents.Users.Roles'=>['fields'=>['id', 'role_title']]])
	->contain(['Documents.Users.Clients'=>['fields'=>['id', 'company_name']]])
	->contain(['Documents.Users.Contractors'=>['fields'=>['id', 'company_name']]])
	->where([$DocWhere])
	->enableHydration(false)
	->toArray();

	foreach ($parentDoc as $k => $client) {
	if(!empty($client['documents'])) {
		$documents[$k] = $client;
		$acceptedDocuments[$k] = $client;
		foreach ($client['documents'] as $key => $document) {
			$accepted = $this->Clients->Documents
			->find('all')
			->where(['document_id'=>$document['id'], 'status'=>2])
			->contain(['Users'=>['fields'=>['id', 'role_id']]])
			->contain(['Users.Clients'=>['fields'=>['id', 'company_name']]])
			->contain(['Users.Contractors'=>['fields'=>['id', 'company_name']]])
			->enableHydration(false)
			->toArray();

			if(count($accepted) > 0) {
				unset($documents[$k]['documents'][$key]);
				$acceptedDocuments[$k]['documents'][$key]['accepted']=$accepted;
			}
			else {
				unset($acceptedDocuments[$k]['documents'][$key]);
				$childrens = $this->Clients->Documents
				->find('all')
				->contain(['Users'=>['fields'=>['id', 'role_id']]])
				->contain(['Users.Roles'=>['fields'=>['id', 'role_title']]])
				->contain(['Users.Clients'=>['fields'=>['id', 'company_name']]])
				->contain(['Users.Contractors'=>['fields'=>['id', 'company_name']]])
				->where(['document_id'=>$document['id']])
				->order(['Documents.id' =>'ASC'])
				->enableHydration(false)
				->toArray();
				$documents[$k]['documents'][$key]['childrens'] =$childrens;
			}
		}
	}
	}

	return ['documents' => $documents, 'acceptedDocuments' => $acceptedDocuments];
    }*/
    public function getDocuments($client_id=null, $contractor_clients=array(),$contractor_id=null)
    {
    $this->loadModel('Clients');

    $documents = array();
    $acceptedDocuments = array();
    $DocWhere = array();

    if($client_id!=null) { $DocWhere['id'] = $client_id; }
    else { $DocWhere['id IN']= $contractor_clients; }

    $parentDoc = $this->Clients
    ->find('all')
    ->contain(['Documents'=>['conditions'=>['contractor_id'=>$contractor_id, 'document_id IS'=>null],
        'queryBuilder' => function ($q) { return $q->order(['Documents.id' =>'ASC']);}
    ]])
    ->contain(['Documents.Users'=>['fields'=>['id', 'role_id']]])
    ->contain(['Documents.Users.Roles'=>['fields'=>['id', 'role_title']]])
    ->contain(['Documents.Users.ClientUsers.Clients'=>['fields'=>['id', 'company_name'],'conditions'=>['Users.role_id'=>CLIENT]]])
    ->contain(['Documents.Users.Contractors'=>['fields'=>['id', 'company_name']]])
    ->where([$DocWhere])
    ->enableHydration(false)
    ->toArray();
    //pr($parentDoc);die;
    foreach ($parentDoc as $k => $client) {
    if(!empty($client['documents'])) {
        $documents[$k] = $client;
        $acceptedDocuments[$k] = $client;
        foreach ($client['documents'] as $key => $document) {
            $accepted = $this->Clients->Documents
            ->find('all')
            ->where(['document_id'=>$document['id'], 'status'=>2])
            ->contain(['Users'=>['fields'=>['id', 'role_id']]])
            ->contain(['Users.ClientUsers.Clients'=>['fields'=>['id', 'company_name'],'conditions'=>['Users.role_id'=>CLIENT]]])
            ->contain(['Users.Contractors'=>['fields'=>['id', 'company_name']]])
            ->enableHydration(false)
            ->toArray();

            if(count($accepted) > 0) {
                unset($documents[$k]['documents'][$key]);
                $acceptedDocuments[$k]['documents'][$key]['accepted']=$accepted;
            }
            else {
                unset($acceptedDocuments[$k]['documents'][$key]);
                $childrens = $this->Clients->Documents
                ->find('all')
                ->contain(['Users'=>['fields'=>['id', 'role_id']]])
                ->contain(['Users.Roles'=>['fields'=>['id', 'role_title']]])
                ->contain(['Users.ClientUsers.Clients'=>['fields'=>['id', 'company_name'],'conditions'=>['Users.role_id'=>CLIENT]]])
                ->contain(['Users.Contractors'=>['fields'=>['id', 'company_name']]])
                ->where(['document_id'=>$document['id']])
                ->order(['Documents.id' =>'ASC'])
                ->enableHydration(false)
                ->toArray();
                $documents[$k]['documents'][$key]['childrens'] =$childrens;
            }
        }
    }
    }

    return ['documents' => $documents, 'acceptedDocuments' => $acceptedDocuments];
    }

    public function notes()
    {
	$this->loadModel('OverallIcons');
	$client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
	$contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
	$notes = $this->OverallIcons->find('all')->where(['client_id'=>$client_id, 'contractor_id'=>$contractor_id, 'notes !='=>''])->toArray();

	$this->set(compact('notes'));
    }

    public function openTasks($contractor_id=null)
    {
	if($this->User->isContractor()) {
		$contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
	}
	else {
		if($this->User->isClient()) {
			$client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
		}
		$contractor = $this->Contractors->get($contractor_id);
		$this->getRequest()->getSession()->write('Auth.User.contractor_id', $contractor_id);
		$this->getRequest()->getSession()->write('Auth.User.contractor_company_name', $contractor->company_name);
		$this->set('activeUser', $this->getRequest()->getSession()->read('Auth.User'));
	}
	$contractor = $this->Contractors->get($contractor_id, [
            'contain'=>['States', 'Countries', 'Users']
        ]);
	$this->set(compact('contractor'));
    }

    public function importUsers()
    {
      if ($this->request->is('post')){
        $document = $this->request->getData('file');

        if($document['size']>0) {
            $fuConfig['upload_path'] = IMPORT_DOCS;
            $fuConfig['allowed_types']  = '*';
            $fuConfig['max_size']       = 0;
            $this->Fileupload->init($fuConfig);
            if (!$this->Fileupload->upload($document)) {
                $fError = $this->Fileupload->errors();
            } else {
                $contractor = $this->Fileupload->output('file_name');

            }
        }
        $this->loadModel('Contractors');
        $userId = $this->getRequest()->getSession()->read('Auth.User.id');
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load(IMPORT_DOCS.'demoCont.xlsx');
        $worksheet = $spreadsheet->getActiveSheet();
        $header=true;
        if ($header) {
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            $headingsArray = $worksheet->rangeToArray('A1:P1', null, true, true, true);
            $headingsArray = $headingsArray[1];
            $r = -1;
            $namedDataArray = array();
            for ($row = 2; $row <= $highestRow; ++$row) {
                $dataRow = $worksheet->rangeToArray('A' . $row . ':' . 'P' . $row, null, true, true, true);
                if ((isset($dataRow[$row]['A'])) && ($dataRow[$row]['A'] > '')) {
                    ++$r;
                    foreach ($headingsArray as $columnKey => $columnHeading) {
                        if($columnHeading=='username' || $columnHeading=='password') {
                                $namedDataArray[$r]['user'][$columnHeading] = $dataRow[$row][$columnKey];
                                continue;
                        }
                        $namedDataArray[$r][$columnHeading] = $dataRow[$row][$columnKey];
                    }

                    $namedDataArray[$r]['user']['role_id'] = CONTRACTOR;
                    $namedDataArray[$r]['user']['created_by'] = $userId;
                    $namedDataArray[$r]['registration_status'] = 1;
                    $namedDataArray[$r]['tnc'] = 1;
                    $namedDataArray[$r]['waiting_on'] = 'Contractor';
                    }
                    }
                } else {

                    $namedDataArray = $worksheet->toArray(null, true, true, true);
                }
                foreach ($namedDataArray as $key => $value) {
                    $contractor = $this->Contractors->newEntity();
                    $contractor = $this->Contractors->patchEntity($contractor,$value);
                    $this->Contractors->save($contractor);
                }
                $this->Flash->success(__('Database Updated Successfully!'));
		}
    }

    public function toCertify($id=null)
    {
            $this->loadModel('Contractors');
            $this->loadModel('Payments');
            $splitTimeStamp ="";
            $date = $this->Payments->find('all')->select('created')->where(['contractor_id'=>$id])->first();
            $dt = date('d M Y',strtotime($date->created));
            $contractor = $this->Contractors->find('all')->select('company_name')->where(['id'=>$id])->first();

            $pdf = new FPDI('Portrait','mm',array(215.9,279.4)); // Array sets the X, Y dimensions in mm
            $pdf->AddPage();

            //$pagecount = $pdf->setSourceFile(CERTIFICATE);  // Add pdf template

            $uploaded_path = Configure::read('uploaded_path');
		$url = $uploaded_path.'CanQualify+Certificate+of+Membership.pdf';

		$fileName = 'CanQualify_Certificate_'.str_replace(' ', '_', chop($contractor->company_name,'.')).'.pdf';
		$localfilePath = CERTIFICATE.'/'.$fileName;
		file_put_contents($localfilePath, file_get_contents($url));

            $pagecount = $pdf->setSourceFile($localfilePath);

            $tppl = $pdf->importPage(1);
            $pdf->useTemplate($tppl, 8, 9, 200);
            $pdf->AddFont('Allura-Regular','','Allura-Regular.php');// $pdf->Image($image,10,10,50,50); // X start, Y start, X width, Y width in mm
            $pdf->SetTitle($contractor->company_name);
            $pdf->SetFont('Allura-Regular','',40); // Font Name, Font Style (eg. 'B' for Bold), Font Size
            $pdf->SetTextColor(0,0,0); // RGB
             // X start, Y start in mm
            // $pdf->Write(1, $contractor->company_name);
            $width = $pdf->GetStringWidth($contractor->company_name);
            if($width < 102){
                $pdf->SetXY(58, 100.3);
            } else if($width < 125){
                $pdf->SetXY(45, 100.3);
            } else if($width  < 160){
                $pdf->SetXY(35, 100.3);
            } else{
                $pdf->SetFont('Allura-Regular','',36); // Font Name, Font Style (eg. 'B' for Bold), Font Size
                $pdf->SetTextColor(0,0,0); // RGB
             // X start, Y start in mm
                $pdf->SetXY(20, 100.3);
            }
            $height = 11.0;
            $border = 0;
            $ln = 1;
            $align = 'C';
            $fill = FALSE;
            $pdf->Cell($width, $height, $contractor->company_name, $border, $ln, $align, $fill);
            $pdf->SetFont('Helvetica','',10);
            $pdf->SetXY(29, 152);
            $pdf->Write(1, $dt);
            $pdf->Output('D', $fileName);
    }
    public function setRead($id =null){
        $contractor = $this->Contractors->get($id, [
            'contain'=>['Users']
        ]);

       if ($this->request->is(['patch', 'post', 'put'])) {
         $this->viewBuilder()->setLayout('ajax');
          $contractor = $this->Contractors->patchEntity($contractor,$this->request->getData());
         if($this->Contractors->save($contractor)){
           $this->Flash->success(__('Data Read set.'));
        }

       }

    }
	 public function getNotification($company_name=null, $cuser_id=null)
    {
	$this->loadModel('Notifications');

	/*$notification = $this->Notifications->newEntity();
	$waiting_status = $this->request->getData('waiting_on');
	$company_name = $company_name;
	$notification->notifications = "The ".$company_name." has Waiting status on the set to ".$waiting_status;
	$notification->from_notification = $this->getRequest()->getSession()->read('Auth.User.id');
	$notification->to_notification = $contractor->user_id;
	$notification->is_read = 0;
	$notification->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
	// pr($notification);
	/ $notification->links = ;
	 // $notification->type = ;
	$this->Notifications->save($notification);

	return notification; */
    }
    public function subscriptionsEndReport($waiting_on=0, $export_type=null, $site_index=null, $icon_index=null){
      $iconList = Configure::read('icons');
    $this->loadModel('Contractors');
    $this->loadModel('ContractorServices');
    $this->loadModel('ClientServices');
    $this->loadModel('Clients');
    $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
     $todaydate = date('m/d/Y');
    $hasEmployeeQual = false;
    $clientService = $this->Clients->ClientServices->find('list', ['keyField'=>'service_id', 'valueField'=>'service_id' ])->where(['client_id'=>$client_id])->toArray();
    $contractorService = $this->ContractorServices->find('list', ['keyField'=>'service_id', 'valueField'=>'service_id' ])->where(["client_ids->'c_ids' @> '[".$client_id."]'"])->toArray();
    if(!empty($clientService) && in_array(4, $clientService)) { $hasEmployeeQual = true; }
    $this->set('hasEmployeeQual', $hasEmployeeQual);

    if($this->getRequest()->getSession()->read('Auth.User.role_id') != CLIENT_VIEW) {
        $this->set('allowForceChange', true);
    }

    $contList = array();
    //$where=['Contractors.payment_status'=>true, 'Users.active'=>true];
    $where=[];
    $whereConCli =[];
    $order=array();
    if($waiting_on == 1) {
        $whereConCli['waiting_on']= 2;
        $whereConCli['client_id']= $client_id;
        $order['canqualify_date']='ASC';
    }
    $client_contractors = array();
    $sites = array();
    if(!empty($client_id)){
    //$client_contractors = $this->User->getContractors($client_id);
    //$client_contractors = $this->User->getContractors($client_id, null, true);

        if($this->User->isClientUser()){
            $locationFilter = $this->User->getClientUserSites();
        }
        if(!empty($locationFilter)){
            $client_contractors = $this->User->getContractors($client_id, array(), true, $locationFilter);
        }else{
            $client_contractors = $this->User->getContractors($client_id, null, true);
        }

    $whereContractorSites = array();
    $whereOverallIcons['OverallIcons.client_id']=$client_id;
    if($site_index!=null) {
        $sites = $this->User->getClientSites($client_id);
        $sitesIds = array_keys($sites);
        if(isset($sitesIds[$site_index])) {
            $whereContractorSites['site_id'] = $sitesIds[$site_index];
            $whereContractorSites['is_archived'] = false;
        }
    }
    if($icon_index!=null) {
        //$iconGreen, $iconYellow, $iconRed, $iconGray
        $icons = array('1'=>3, '2'=>2, '3'=>1, '4'=>0);
        $icon = $icons[$icon_index];
        $this->set('icon', $icon);
        //$whereOverallIcons['icon'] = $icons[$icon_index];
    }

    if(!empty($client_contractors)) {
        $where['Contractors.id IN']=$client_contractors;
        $where2 = ['CAST(subscription_date AS DATE) <='=>$todaydate];

    $contList = $this->Contractors
        ->find('all')
        ->contain(['ContractorSites'=> ['conditions'=> [$whereContractorSites]] ])
        ->contain(['OverallIcons' => [
            'fields'=>['icon','contractor_id'],
            'conditions'=> [$whereOverallIcons],
            'queryBuilder' => function ($q) { return $q->order(['OverallIcons.created'=>'DESC']); }
        ]])
        ->contain(['Payments'])
        ->contain(['States'=> ['fields'=>['name']]])
        ->contain(['Countries'=> ['fields'=>['name']]])
        ->contain(['Users'=>['fields'=>['username' ,'active']]])
        //->contain(['ContractorClients'=>['fields'=>['contractor_id', 'waiting_on'], 'conditions'=> [$whereConCli]]])
        ->where([$where,$where2])
        ->order($order)
        ->toArray();
    }
    if($export_type!='0') {
        $i =0;
        $data = array();
        if(!empty($contList)) {
        foreach ($contList as  $contractor) {
            if($icon_index!=null && empty($contractor['overall_icons'])) {
                continue;
            }
            if($site_index!=null && empty($contractor['contractor_sites'])) {
                continue;
            }
            if(isset($icon) && $contractor['overall_icons'][0]->icon != $icon) {
                continue;
            }
            $data[$i]['registration_status'] = '';
            if(!empty($contractor['overall_icons'])) {
                $data[$i]['registration_status'] = $iconList[$contractor['overall_icons'][0]->icon];
            }
            $data[$i]['active'] = $contractor->user['active'] == 1 ? 'Yes' : 'No'; ;
            $data[$i]['company_name'] = $contractor['company_name'];
            $data[$i]['pri_contact_fn'] = $contractor['pri_contact_fn']." ".$contractor['pri_contact_ln'];
            $data[$i]['pri_contact_pn'] = $contractor['pri_contact_pn'];
            $data[$i]['username'] = $contractor->user['username'];
            if($this->getRequest()->getSession()->read('Auth.User.role_id') == 1){
            $data[$i]['payment_status'] = ($contractor['payment_status'] == 1) ? 'YES' : 'NO';
            }
            $data[$i]['waiting_on'] = $contractor['waiting_on'];
            $data[$i]['member_since']= !empty($contractor->payments) ? date('m/d/Y', strtotime($contractor->payments[0]->created))  : '';
            $data[$i]['subscription_end_date']= !empty($contractor->subscription_date) ? date('m/d/Y', strtotime($contractor->subscription_date))  : '';
            $i++;
        }
        }
        $client_company_name = $this->getRequest()->getSession()->read('Auth.User.client_company_name');
        if($this->getRequest()->getSession()->read('Auth.User.role_id') == 1){
            if($client_id){
            $client_name = $this->Clients->find()->where(['id'=>$client_id])->first();
            $headT = array('Status','Contractor Company Name','Primary Contact','Phone','Email','Paid','Waiting On','Member Since','Subscription End Date',$client_name['company_name']);
            }
        }else{
        if($client_id){
            $client_name = $this->Clients->find()->where(['id'=>$client_id])->first();
            $headT = array('Status','Active','Contractor Company Name','Primary Contact','Phone','Email','Waiting On','Member Since','Subscription End Date',$client_name['company_name']);
        }else{
            $headT = array('Status','Active','Contractor Company Name','Primary Contact','Phone','Email','Paid','Waiting On','Member Since','Subscription End Date',$client_company_name);
        }
        }
        if($export_type == 'excel') {
            $this->Export->XportToExcel2($data,$headT);
            exit;
        }
        if($export_type == 'csv') {
            $this->Export->XportToCSV2($data,$headT);
            exit;
        }
    }
    }
    //$waiting_on_status = $this->User->waiting_status_ids();
    $site_visit = $this->Clients->find()->select('site_visited')->where(['id'=>$client_id])->enableHydration(false)->first();
    $this->set(compact('contList', 'client_id', 'site_index', 'icon_index','contractorService','site_visit'));
    }

    public function searchEmployee()
    {
    ini_set('memory_limit','-1');
    $this->loadModel('Employees');
    $this->loadModel('ContractorServices');

    $contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
    $contractor_emp = $this->User->getContractorEmp($contractor_id);

    $empList = array();
    $andConditions = array();

    $employee = $this->Employees->newEntity();

    //$andConditions[] = "contractors.payment_status=true";
    $andConditions[] = "users.active=true";
    $andConditions[] = "employees.is_login_enable=true";
    $andConditions[] = "employees.profile_search=true";
    $andConditions = implode(' AND ',$andConditions);
    $conn = ConnectionManager::get('default');

    $empList = $conn->execute("SELECT Employees.*, states.name as state_name, users.username, contractor_requests.status as requestStatus FROM employees 
            LEFT JOIN users ON users.id = (employees.user_id) 
            LEFT JOIN states ON states.id = (employees.state_id) 
            LEFT JOIN contractor_requests ON contractor_requests.employee_id=employees.id AND contractor_requests.contractor_id =$contractor_id         
            WHERE ".$andConditions." ")->fetchAll('assoc');

    if ($this->request->is(['patch', 'post', 'put'])) {
        $contactnm = $this->request->getData('contact_name');
        $email = $this->request->getData('username');
        $city = $this->request->getData('city');
        $state = $this->request->getData('state');
        $zip = $this->request->getData('zip');

        $andConditions = array();
        $orConditions = array();
        if($contactnm!='') {
            $contactnm = explode(' ',$contactnm);
            $count = count($contactnm);
            //pr($count);die;
            if($count==1){
                 $orConditions = ["LOWER(employees.pri_contact_fn) LIKE LOWER('%".$contactnm[0]."%')","LOWER(employees.pri_contact_ln) LIKE LOWER('%".$contactnm[0]."%')"];
            }else{
            $andConditions[]="LOWER(employees.pri_contact_fn) LIKE LOWER('%".$contactnm[0]."%')";
            if(isset($contactnm[1])) {
            $andConditions[]="LOWER(employees.pri_contact_ln) LIKE LOWER('%".$contactnm[1]."%')";
            }}
        }
        if($email!='') { $andConditions[]="users.username LIKE '%".$email."%'";  }
        if($city!='') { $andConditions[]="LOWER(employees.city) LIKE LOWER('%".$city."%')";  }
        if($state!='') { $andConditions[]="states.name LIKE '%".$state."%'";  }
        if($zip!='') { $andConditions[]="employees.zip LIKE '%".$zip."%'";  }


        $andConditions[] = "users.active=true";
        $andConditions[] = "employees.is_login_enable=true";
        $andConditions[] = "employees.profile_search=true";

        $andConditions = implode(' AND ',$andConditions);
        $orConditions = implode(' OR ',$orConditions);
        if(!empty($orConditions)){
            $orConditions = 'AND ('.$orConditions.')';
        }

        $conn = ConnectionManager::get('default');

        $empList = $conn->execute("SELECT employees.*, states.name as state_name, users.username , contractor_requests.status as requestStatus FROM employees 
            LEFT JOIN users ON users.id = (employees.user_id) 
            LEFT JOIN states ON states.id = (employees.state_id) 
            LEFT JOIN contractor_requests ON contractor_requests.employee_id=employees.id AND contractor_requests.contractor_id =$contractor_id
           
            WHERE ".$andConditions.' '.$orConditions)->fetchAll('assoc');

    }

    $states = $this->Employees->States->find('list', ['keyField'=>'name', 'valueField'=>'name' ])->toArray();
    $employeesSlot = $this->ContractorServices
        ->find('list', ['keyField'=>'id','valueField'=>'slot'])
        ->where(['contractor_id'=>$contractor_id, 'service_id'=>4])
        ->first();
    $employeesCount = 0;
   // $contractorEmp = $this->User->getContractorEmp($contractor_id);
    if(!empty($contractor_emp)){
       $employeesCount = $this->Employees
        ->find()
        ->where(['Employees.id IN'=>$contractor_emp])
        ->count();
    }
    $available = $employeesSlot - $employeesCount;

    $this->set(compact('employee', 'empList', 'states','contractor_emp','available'));
    }
    public function profile($contractor_id=null)
    {
      $this->loadModel('Questions');

      if(empty($contractor_id)){
        $contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
      }

      $contractor = $this->Contractors->get($contractor_id, ['contain'=>['Users','States','Countries']]);
      $contractor_clients = $this->User->getClients($contractor_id);
      if ($this->request->is(['patch', 'post', 'put'])) {
        $contractor = $this->Contractors->patchEntity($contractor, $this->request->getData());
        $contractor->profile_search = $this->request->getData('profile_search');
        $this->Contractors->save($contractor);
     }
      $questions = $this->Questions
        ->find()
        //->contain(['QuestionTypes'=>['fields'=>['id', 'name']] ])
        ->contain(['ClientQuestions'=>['fields'=>['id', 'client_id','question_id','is_compulsory','ques_order'], 'conditions'=>['ClientQuestions.client_id IN'=>$contractor_clients]] ])
        ->contain(['ClientQuestions.Clients'=>['fields'=>['id', 'company_name']]])
        ->contain(['ContractorAnswers'=>['conditions'=>['contractor_id'=>$contractor_id]] ])
        ->where(['active'=>true, 'category_id IN '=>[49]])
        ->order(['ques_order'=>'ASC','Questions.id'=>'ASC'])
        ->all();
      //  pr($questions);
     $this->set(compact('contractor','questions'));
    }
    public function addMarketplaceClient(){
    $this->loadModel('ContractorClients');
    $this->render(false);
    $allContractors = $this->Contractors->find('list', ['keyField'=>'id', 'valueField'=>'id' ])->toArray();
        foreach ($allContractors as $key => $contractor_id) {
        $contClients = $this->ContractorClients->find('list',['keyField' => 'id', 'valueField' => 'client_id'])->where(['contractor_id'=>$contractor_id])->toArray();
         if((empty($contClients) || (!in_array(4, $contClients)))) {
            $this->User->associateWithMarketplace($contractor_id);
        }
         }
         $this->Flash->success(__("The CanQualify Marketplace Client added Succesfully  ."));
    }
    public function clientContractorList($client_id = null){

        $this->loadModel('Clients');
        $this->loadModel('ContractorServices');
        if($client_id == null){
            $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
        }
        $conn = ConnectionManager::get('default');

        $clientService = $this->Clients->ClientServices->find('list', ['keyField'=>'service_id', 'valueField'=>'service_id' ])->where(['client_id'=>$client_id])->toArray();
        $hasEmployeeQual = (!empty($clientService) && in_array(4, $clientService)) ? true : false;

        $allowForceChange = ($this->getRequest()->getSession()->read('Auth.User.role_id') != CLIENT_VIEW) ? true : false;

        $where = "and true";
        /*check if client user is logged in*/
        $locationFilter = array();

        if($this->User->isClientUser()){
            $locationFilter = $this->User->getClientUserSites();
        }
        $client_contractors = array();
        if(!empty($locationFilter)){
            $client_contractors = $this->User->getContractors($client_id, array(), true, $locationFilter);
        }else{
            $client_contractors = $this->User->getContractors($client_id);
        }
        if(!empty($client_contractors)){
            $where .= " and contractors.id in (".implode(',',$client_contractors).")";
        }
        /*additional filters*/
        if ($this->request->is(['post'])) {
            $iconArray = array('Waiting On Contractor' => 0, 'Non-compliant' => 1, 'Conditional' => 2, 'Compliant' => 3);
            $iconArrayKeys = array_keys($iconArray);
            $postData = $this->request->getData();
            $postVariables = array_keys($postData);
            if(!empty($postData['filter1']) && empty($postData['filter2'])){
                /*chart filters are on*/

                $condition_1 = $postData['filter1'];
                if(in_array($condition_1, $iconArrayKeys)){
                    $filterIcon = -1;
                    $filterIcon = $iconArray[$condition_1];

                    if(in_array($filterIcon, array(0, 1, 2, 3))){
                        $complianceFilter = array();

                        $complianceFilter = $this->FinalOverallIcons
                            ->find('list', ['keyField'=>'contractor_id', 'valueField'=>'contractor_id' ])
                            ->where(['client_id' => $client_id,'icon' => $filterIcon, 'contractor_id IN '=> $client_contractors])
                            ->toArray();
                        if(!empty($complianceFilter)){
                            $where['Contractors.id IN'] = $complianceFilter;
                        }
                    }
                }
            }
            if(!empty($postData['filter1']) && !empty($postData['filter2'])){
                $condition_1 = $postData['filter1'];
                $condition_2 = $postData['filter2'];
                $complianceFilter = array();
                $locationFilter = array();

                if(in_array($condition_2, $iconArrayKeys)){
                    $filterIcon = -1;
                    $filterIcon = $iconArray[$condition_2];

                    if(in_array($filterIcon, array(0, 1, 2, 3))){

                        $complianceFilter = $this->FinalOverallIcons
                            ->find('list', ['keyField'=>'contractor_id', 'valueField'=>'contractor_id' ])
                            ->where(['client_id' => $client_id, 'icon' => $filterIcon, 'contractor_id IN '=> $client_contractors])
                            ->toArray();
                    }
                }
                if(strpos($condition_1, 'Location:') !== false){
                    $split_1 = explode(':', $condition_1);
                    $split_2 = explode('-', $split_1[1]);
                    if(is_numeric($split_2[0])){
                        $locationFilter = array();
                        $locationFilter = $this->ContractorSites
                            ->find('list', ['keyField'=>'contractor_id', 'valueField'=>'contractor_id' ])
                            ->where(['ContractorSites.site_id' => $split_2[0], 'contractor_id IN '=> $complianceFilter])
                            ->toArray();
                    }
                }
                if(!empty($locationFilter)){
                    $where['Contractors.id IN'] = $locationFilter;
                }
            }
        }

        $contList = $conn->execute("select contractors.id as contractor_id, contractors.company_name, contractors.pri_contact_fn as pri_contact_fn, contractors.pri_contact_ln as pri_contact_ln, contractors.pri_contact_pn as pri_contact_pn, contractors.created as registration_date,
 users.username as username, CASE when contractors.is_safety_sensitive then 'Safety Sensitive' else 'Non Safety Sensitive' end as risk_level, 
 final_overall_icons.client_id as client_id, final_overall_icons.icon as icon 
 from contractors
 left join final_overall_icons on (contractors.id = final_overall_icons.contractor_id)
 left join users on (contractors.user_id = users.id and users.active = true)
 where final_overall_icons.client_id != 4 and final_overall_icons.client_id = ".$client_id.$where)->fetchAll('assoc');
        $this->set(compact('contList', 'hasEmployeeQual', 'allowForceChange'));
    }
    public function contractorList($client_id = null)
    {

        $this->loadModel('Clients');
        $this->loadModel('ContractorServices');
        $this->loadModel('ClientServices');
        $this->loadModel('ContractorSites');
        $this->loadModel('ContractorClients');
        $this->loadModel('Sites');
        $this->loadModel('Icons');
        $this->loadModel('FinalOverallIcons');
        $this->loadModel('NaiscViews');
        $this->loadModel('ContractorTins');
        $this->loadModel('WaitingOn');

        $export_type = '';
        $hasEmployeeQual = false;
        $iconList = array();
        $formData = array();
        $contList = array();
        $WaitingOn = array();
        $suppliersOnWatch = array();
        $clientSites = array();
        $contractorService = array();
        $showFilters = true;

        $iconList = Configure::read('icons');
        if($client_id == null){
            $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
            $this->getRequest()->getSession()->delete('Auth.User.contractor_id');
            $this->getRequest()->getSession()->delete('Auth.User.contractor_company_name');
            $activeUser = $this->getRequest()->getSession()->read('Auth.User');
            $this->set('activeUser', $activeUser);
        }else{
            $gc_contractor_id = $this->Contractors->find()->select(['id','company_name'])->where(['gc_client_id' => $client_id])->first();

            if(!empty($gc_contractor_id['id'])){
                $this->getRequest()->getSession()->write('Auth.User.contractor_id', $gc_contractor_id['id']);
                $this->getRequest()->getSession()->write('Auth.User.contractor_company_name', $gc_contractor_id['company_name']);
                $activeUser = $this->getRequest()->getSession()->read('Auth.User');
                $this->set('activeUser', $activeUser);
                $showFilters = false;
            }
        }

        $WaitingOn = $this->WaitingOn->find('list', ['keyField'=>'id', 'valueField'=>'status' ])->toArray();
        if(!empty($client_id)){
            //employeeQual column
            $clientService = $this->Clients->ClientServices->find('list', ['keyField'=>'service_id', 'valueField'=>'service_id' ])->where(['client_id'=>$client_id])->toArray();
            $contractorService = $this->ContractorServices->find('list', ['keyField'=>'service_id', 'valueField'=>'service_id' ])->where(["client_ids->'c_ids' @> '[".$client_id."]'"])->toArray();
            if(!empty($clientService) && in_array(4, $clientService)) { $hasEmployeeQual = true; }

            //force icon action
            if($this->getRequest()->getSession()->read('Auth.User.role_id') != CLIENT_VIEW) {
                $this->set('allowForceChange', true);
            }

            /*check if client user is logged in*/
            if($this->User->isClientUser()){
                $locationFilter = $this->User->getClientUserSites();
                //if empty user has no location selected
                if(isset($locationFilter) && !empty($locationFilter)){
                    $client_contractors = $this->User->getContractors($client_id, array(), true, $locationFilter);
                }else{
                    $this->Flash->error(__('No location/s selected.'));
                }

            }else{
                $client_contractors = $this->User->getContractors($client_id);
            }

            if(isset($client_contractors) && !empty($client_contractors)){
                //$where['Contractors.id IN']=$client_contractors;
                $contractor_filter = $client_contractors;

                /*additional filters from post*/
                $postData = '';
                if ($this->request->is(['post'])) {
                    $iconArray = array('Waiting on Contractor' => 0, 'Non-compliant' => 1, 'Conditional' => 2, 'Compliant' => 3);
                    $iconArrayKeys = array_keys($iconArray);
                    $postData = $this->request->getData();

                    if(isset($postData['excel']) || isset($postData['csv'])){
                        if($postData['excel']){
                            $export_type = $postData['excel'];
                        }else if($postData['csv']){
                            $export_type = $postData['csv'];
                        }
                    }
                    //watchlist filter
                    if(!empty($postData['watch_list']) && $postData['watch_list'] == 1){
                        $suppliersOnWatch = $this->ContractorClients->find('list', ['keyField'=>'contractor_id', 'valueField'=>'contractor_id' ])->where(['client_id'=>$client_id, 'on_watch_list' => true])->toArray();
                        if(!empty($suppliersOnWatch) && count($suppliersOnWatch) > 0){
                            //$where['Contractors.id IN'] = $suppliersOnWatch;
                            $contractor_filter = $suppliersOnWatch;
                        }
                    }
                    $filterIcon = -1;
                    $filterSite = '';
                    if(isset($postData['formID']) && $postData['formID'] == 'contractor_list') {
                        //list filter is on
                        $filterIcon = (isset($postData['icon_value']) && $postData['icon_value'] >= 0 && $postData['icon_value'] != '') ? $postData['icon_value'] : -1;
                        $filterSite = (!empty($postData['site_id'])) ? $postData['site_id'] : '';
                        //debug($filterSite);
                        //die;

                    }
                    elseif(!empty($postData['site']) && !empty($postData['icon'])){
                        //chart filter is on
                        //complience by site: location and icon filter
                        $condition_icon = $postData['icon'];
                        $condition_site = $postData['site'];
                        if(in_array($condition_icon, $iconArrayKeys)){
                            $filterIcon = $iconArray[$condition_icon];
                        }

                        if(strpos($condition_site, 'ID') !== false){
                            $condition_site = str_replace(array('&lt;span style=&#034;display:none;&#034;&gt;', '&lt;/span&gt;'), array('',''), $condition_site );
                            $split = explode('ID', str_replace(' ', '', $condition_site));
                            if(is_numeric($split[1])) {
                                $filterSite = $split[1];
                            }

                        }

                    }
                    if(isset($filterIcon) && $filterIcon >= 0 && !empty($contractor_filter)) {
                        //filter by icon
                        $formData['icon_value'] = $filterIcon;
                        $complianceFilter = array();
                        if (in_array($filterIcon, array(0, 1, 2, 3))) {

                            $complianceFilter = $this->FinalOverallIcons
                                ->find('list', ['keyField' => 'contractor_id', 'valueField' => 'contractor_id'])
                                ->where(['client_id' => $client_id, 'icon' => $filterIcon, 'contractor_id in' => $contractor_filter])
                                ->toArray();
                            if(!empty($complianceFilter) && count($complianceFilter) > 0){
                                $contractor_filter = $complianceFilter;

                            }else{
                                $contractor_filter = array();
                            }
                        }
                    }
                    if(!empty($filterSite) && !empty($contractor_filter)){
                        $formData['site_id'] = $filterSite;
                        $locationFilter = array();
                        $locationFilter = $this->ContractorSites
                            ->find('list', ['keyField'=>'contractor_id', 'valueField'=>'contractor_id' ])
                            ->where(['ContractorSites.site_id in' => $filterSite, 'is_archived'=>false, 'contractor_id in' => $contractor_filter])
                            ->toArray();
                        if(!empty($locationFilter) && count($locationFilter) > 0){
                            $contractor_filter = $locationFilter;

                        }else{
                            $contractor_filter = array();
                        }
                    }
                }
                if(!empty($contractor_filter)){
                    $contList = $this->Contractors
                        ->find('all')
                        ->select(['id', 'company_name', 'pri_contact_fn', 'pri_contact_ln', 'pri_contact_pn', 'is_safety_sensitive', 'created', 'subscription_date', 'gc_client_id'])
                        ->contain(['FinalOverallIcons' => ['fields'=>['id', 'icon', 'contractor_id'],'conditions'=> ['client_id' => $client_id]]])
                        ->contain(['Users'=>['fields'=>['username' ,'active']]])
                        ->contain(['ContractorSiteLists'=>['fields'=>['contractor_id', 'sites']]])
                        ->contain(['ContractorClients'=>['fields'=>['contractor_id', 'waiting_on'], 'conditions' =>['client_id' => $client_id]]])
                        ->contain(['NaiscViews'=>['fields'=>['contractor_id','naisc_code' ,'title']]])
                        ->contain(['ContractorTins'=>['fields'=>['tin', 'contractor_id']]])
                        ->where(['Contractors.id IN' => $contractor_filter, 'expired' => false])
                        ->toArray();
                }

            }else{
                $this->Flash->error(__('No contractors associated with client.'));
            }
            if(!empty($export_type)) {
                $i =0;
                $data = array();
                $extras = array();
                $now = time();

                if(!empty($contList)) {
                    $clientSites = $this->Sites->find('list', ['keyField'=>'id', 'valueField'=>'id' ])->where(['client_id' => $client_id])->toArray();

                    foreach ($contList as  $contractor) {

                        $tmpBenchmarks = '';
                        $data[$i]['registration_status'] = '';

                        if(isset($contractor->final_overall_icons[0]->icon)) {
                            if(in_array($contractor->final_overall_icons[0]->icon, array_keys($iconList))){
                                $data[$i]['registration_status'] = $iconList[$contractor->final_overall_icons[0]->icon];
                            }
                            $benchmarks = $this->Icons->find()->where(['Icons.overall_icon_id' => $contractor->final_overall_icons[0]->id])->contain(['BenchmarkTypes'])->all()->toArray();
                            if (!empty($benchmarks)) {
                                foreach ($benchmarks as $b_key => $b_val) {
                                    if (is_object($b_val->benchmark_type) && !empty($b_val->benchmark_type->name))
                                        $tmpBenchmarks .= $b_val->benchmark_type->name . ': ' . $iconList[$b_val->icon] . ", \r\n";
                                }
                            }
                        }
                        $data[$i]['benchmarks'] = $tmpBenchmarks;

                        $data[$i]['waiting_on'] = '';
                        if(isset($contractor->contractor_clients[0]->waiting_on) && in_array($contractor->contractor_clients[0]->waiting_on, array_keys($WaitingOn))){
                            $data[$i]['waiting_on'] = $WaitingOn[$contractor->contractor_clients[0]->waiting_on];
                        }
                        $data[$i]['risk_level'] = (isset($contractor['is_safety_sensitive']) && $contractor['is_safety_sensitive'] ==  true) ? 'Safety Sensitive' : 'Non Safety Sensitive';
                        $data[$i]['company_name'] = (isset($contractor['company_name']) ? $contractor['company_name'] : '');

                        $tin = "";
                        $tin = (!empty($contractor->contractor_tins[0]->tin)) ? $contractor->contractor_tins[0]->tin : '';
                        $data[$i]['tin'] = $tin;

                        $naics_code = "";
                        $naics_code .= (!empty($contractor->naisc_views[0]->naisc_code)) ? $contractor->naisc_views[0]->naisc_code : '';
                        $naics_code .= (!empty($contractor->naisc_views[0]->title)) ? ' '.$contractor->naisc_views[0]->title : '';
                        $data[$i]['naics_code'] = $naics_code;

                        $data[$i]['pri_contact_fn'] = '';
                        $data[$i]['pri_contact_fn'] .= (isset($contractor['pri_contact_fn']) ? $contractor['pri_contact_fn'] : '');
                        $data[$i]['pri_contact_fn'] .= " ". (isset($contractor['pri_contact_ln']) ? $contractor['pri_contact_ln'] : '');

                        $data[$i]['pri_contact_pn'] = (isset($contractor['pri_contact_pn']) ? $contractor['pri_contact_pn'] : '');

                        $data[$i]['username'] = (isset($contractor->user['username']) ? $contractor->user['username'] : '');

                        if($this->getRequest()->getSession()->read('Auth.User.role_id') == 1){
                            if(strtotime($contractor->subscription_date) > $now) {
                                $data[$i]['active_subscription'] = "Active";
                            }else{
                                $data[$i]['active_subscription'] = "Expired";
                            }
                        }


                        $data[$i]['next_nenewal']= !empty($contractor['subscription_date']) ? date('m/d/Y', strtotime($contractor['subscription_date']))  : '';
                        $data[$i]['sites'] = (!empty($contractor->contractor_site_lists[0]->sites)) ? $contractor->contractor_site_lists[0]->sites : '';
                        $i++;
                    }
                }
                $extras['client_name'] = '';
                $extras['client_name'] = $this->getRequest()->getSession()->read('Auth.User.client_company_name');
                /*company logo*/
                if(!empty($client_id)){
                    $extras['client_logo'] = $client_id . '.jpg';
                }

                if($this->getRequest()->getSession()->read('Auth.User.role_id') == 1){
                    if($client_id){
                        $client_name = $this->Clients->find()->where(['id'=>$client_id])->first();
                        $extras['client_name'] = $client_name['company_name'];
                        $headT = array('Status','Benchmarks','Waiting On','Risk Level','Contractor Company Name','TIN','NAICS Code','Primary Contact','Phone','Email','Active Subscription','Next Renewal','Sites');
                    }
                }else{
                    if($client_id){
                        $client_name = $this->Clients->find()->where(['id'=>$client_id])->first();
                        $extras['client_name'] = $client_name['company_name'];
                        $headT = array('Status','Benchmarks','Waiting On','Risk Level','Contractor Company Name','TIN','NAICS Code','Primary Contact','Phone','Email','Next Renewal','Sites');
                    }else{
                        $headT = array('Status','Benchmarks','Waiting On','Risk Level','Contractor Company Name','TIN','NAICS Code','Primary Contact','Phone','Email','Active Subscription','Next Renewal','Sites');
                    }
                }
                //debug($data);die;
                if($export_type == 'excel') {
                    $this->Export->XportAsExcel($data,$headT, $extras);
                    exit;
                }
                if($export_type == 'csv') {
                    $this->Export->XportToCSV($data,$headT);
                    exit;
                }
            }

        }else{
            $this->Flash->error(__('Client ID not found. Please, try again.'));
        }
        $this->set('parentPage', 'Suppliers');
        $this->set('currentPage', 'My Suppliers');

        $suppliersOnWatch = $this->ContractorClients->find('list', ['keyField'=>'contractor_id', 'valueField'=>'contractor_id' ])->where(['client_id'=>$client_id, 'on_watch_list' => true])->toArray();

        $clientSites = $this->Sites->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['client_id' => $client_id])->toArray();
        $this->set(compact('contList', 'client_id', 'contractorService','formData', 'suppliersOnWatch', 'iconList','WaitingOn', 'clientSites', 'hasEmployeeQual', 'showFilters'));
    }
    public function addWatchList($client_id=null,$contractor_id=null)
    {
        $this->render(false);
        $this->loadModel('ContractorClients');
        $contClients = $this->ContractorClients->find('all')->where(['contractor_id'=>$contractor_id,'client_id'=>$client_id])->first();
        if($contClients['on_watch_list']){
            $contClients->on_watch_list = false;
        }else{
         $contClients->on_watch_list = true;   
        }
        $this->ContractorClients->save($contClients); 
        
        return $this->redirect(['controller'=>'Contractors', 'action' => 'contractor-list']);
        
    }

    public function pendingContractorList(){
        $conn = ConnectionManager::get('default');
        $waiting_on = array();
        $waiting_on = $this->User->waiting_status_ids();

        $query = "select contractors.id as contractor_id, contractors.company_name, contractor_clients.client_id as client_id, clients.company_name as client_company_name, contractor_clients.waiting_on from contractors left join contractor_clients on (contractors.id = contractor_clients.contractor_id)
                  left join clients on (clients.id = contractor_clients.client_id)
                  where contractor_clients.client_id != 4 and contractors.id != 502";
        $pendingContractors = $conn->execute($query)->fetchAll('assoc');
        $this->set(compact('pendingContractors', 'waiting_on'));
    }

    /*function to download certificate of completion*/
    public function certifyCompletion($contractor_id=null, $client_id=null)
    {
        $this->loadModel('Contractors');
        $this->loadModel('Clients');
        $this->loadModel('OverallIcons');

        $overallIcons = $this->Contractors->OverallIcons->find()->select('created')->where(['contractor_id'=>$contractor_id, 'client_id'=> $client_id])->order(['created DESC'])->first();

        $splitTimeStamp ="";
        $dt = date('d M Y', strtotime('+1 year', strtotime($overallIcons->created)) );
        $year = date('Y',strtotime($dt));
        $dt_expires = date('d M Y', strtotime('31 Mar '.$year));

        $contractor = $this->Contractors->find('all')->select('company_name')->where(['id'=>$contractor_id])->first();
        $client = $this->Clients->find('all')->select(['company_name', 'id'])->where(['id'=>$client_id])->first();

        $pdf = new FPDI('Portrait','mm',array(215.9,279.4)); // Array sets the X, Y dimensions in mm
        $pdf->AddPage();

        //$pagecount = $pdf->setSourceFile(CERTIFICATE);  // Add pdf template

        $uploaded_path = Configure::read('uploaded_path');
        //$url = $uploaded_path.'certificate_of_completion.pdf';
        $url = CERTIFICATE.'certificate_of_completion.pdf';

        $fileName = 'CanQualify_completion_Certificate_'.$contractor_id.'.pdf';
        $localfilePath = CERTIFICATE.'/'.$fileName;
        file_put_contents($localfilePath, file_get_contents($url));

        $pagecount = $pdf->setSourceFile($localfilePath);

        $tppl = $pdf->importPage(1);
        $pdf->useTemplate($tppl, 8, 9, 200);
        $pdf->AddFont('Allura-Regular','','Allura-Regular.php');// $pdf->Image($image,10,10,50,50); // X start, Y start, X width, Y width in mm
        $pdf->SetTitle($contractor->company_name);
        $pdf->SetFont('Helvetica','',16); // Font Name, Font Style (eg. 'B' for Bold), Font Size
        $pdf->SetTextColor(0,0,0); // RGB
        // X start, Y start in mm
        // $pdf->Write(1, $contractor->company_name);
        $width = $pdf->GetStringWidth($contractor->company_name);
        if($width < 102){
            $pdf->SetXY(58, 90.3);
        } else if($width < 125){
            $pdf->SetXY(45, 90.3);
        } else if($width  < 160){
            $pdf->SetXY(35, 90.3);
        } else{
            $pdf->SetFont('Allura-Regular','',30); // Font Name, Font Style (eg. 'B' for Bold), Font Size
            $pdf->SetTextColor(0,0,0); // RGB
            // X start, Y start in mm
            $pdf->SetXY(20, 90.3);
        }
        $pdf->SetXY(17, 70.3);
        $height = 11.0;
        $border = 0;
        $ln = 1;
        $align = 'C';
        $fill = FALSE;
        $pdf->Cell($width, $height, $contractor->company_name, $border, $ln, $align, $fill);

        $pageWidth = $pdf->GetPageWidth();

        $pdf->SetFont('Helvetica','',25);
        $pdf->SetTextColor(0,0,0); // RGB
        $certificateTitle = "Company Level";
        $pdf->SetXY(17, 30);
        $pdf->Write(1, $certificateTitle);


        $certificateTitle = "Certificate of Completion";
        $pdf->SetXY(17, 45);
        $pdf->SetFont('Helvetica','',32);
        $pdf->SetTextColor(56,181,74);
        $pdf->Write(1, $certificateTitle);




        $pdf->SetFont('Helvetica','',12);
        $pdf->SetTextColor(0,0,0); // RGB

        $pdf->SetXY(17, 93);
        $pdf->Write(1, $client->company_name);
        //if(isset($client->id) && $client->id == 3){
            $pdf->SetTextColor(0,0,0); // RGB
            $pdf->SetFont('Helvetica','',10);
            $pdf->SetXY(17, 140);
            $pdf->Write(1, "Valid Through: ".$dt_expires);
        //}

        //$pdf->SetFont('Helvetica','',10);
        //$pdf->SetXY(164, 152);
        //$pdf->Write(1, $dt_expires);
        $pdf->Output('D', $fileName);
    }
}
