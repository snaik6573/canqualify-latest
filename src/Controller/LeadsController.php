<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;
use Cake\Routing\Router;
use Cake\Mailer\MailerAwareTrait;       //  Built in function use for sending multiple email
use Cake\Auth\DefaultPasswordHasher;
use Cake\Core\Configure;
/**
 * Leads Controller
 *
 * @property \App\Model\Table\LeadsTable $Leads
 *
 * @method \App\Model\Entity\Lead[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LeadsController extends AppController
{
    use MailerAwareTrait;
    public function isAuthorized($user)
    {
	$clientNav = false;
	if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN || $user['role_id'] == CLIENT || $user['role_id'] == CLIENT_ADMIN || $user['role_id'] == CLIENT_VIEW) {
		$clientNav = true;
	}
	$this->set('clientNav', $clientNav);

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
   
  /* public function index($foundlead=null,$export_type=1,$client_id=null)
    {	

        ini_set('memory_limit','-1');	
       
        $this->loadModel('LeadStatus');
        $this->loadModel('Contractors');
        $this->loadModel('LeadNotes');

	$status = $this->LeadStatus->find('list', ['id'=>'id', 'valueField'=>'status'])->order(['id'])->toArray();
	if ($this->request->is(['patch', 'post', 'put'])) {     
		if(null !== $this->request->getData('lead_status_id') || null !== $this->request->getData('email_count') || null !== $this->request->getData('phone_count'))
		{
			$this->viewBuilder()->setLayout('ajax');
			$leads = $this->Leads->get($this->request->getData('id'));
			$leads = $this->Leads->patchEntity($leads, $this->request->getData());
			$leads->created_by = $this->getRequest()->getSession()->read('Auth.User.id');	

			if ($this->Leads->save($leads)) {
				echo '<div class="alert with-close alert-success alert-dismissible fade show" role="alert">The leads has been saved.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
			}
			else {
				echo '<div class="alert with-close alert-danger alert-dismissible fade show" role="alert">The leads could not be saved. Please, try again.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
			}
			exit;
		}
		if(null != $this->request->getData('client_id')) {
			$client_id = $this->request->getData('client_id');
        }
	}
    $leads = [];
    $wherePag = [];
    $clients = [];
    $dropedData = [];
    
    if($this->User->isCR()) { // if CR
            $cr_id = $this->getRequest()->getSession()->read('Auth.User.CR_id');
            //$wherePag = ['Leads.customer_representative_id'=> $cr_id];
			$wherePag = ["Leads.customer_representative_id->'cr_ids' @> " => '['.$cr_id.']'];			
            if(isset($client_id)) {
            $wherePag = ['client_id'=>$client_id];
            }
            $totalCount = $this->Leads->find('all')->count();
            $this->paginate = [
                'contain' => ['Clients','LeadNotes','LeadStatus'],
                'conditions' => $wherePag,
                'limit'   => $totalCount,
                'maxLimit'=> $totalCount
                ];
            $leads = $this->paginate($this->Leads);

            $filtered_clients = $this->Leads
			->find('list', ['keyField'=>'client_id', 'valueField'=>'client_id'])
			->where(["customer_representative_id->'cr_ids' @> " => '['.$cr_id.']'])
			->distinct(['client_id'])
			->toArray();

            if(!empty($filtered_clients)) {
            	$clients = $this->Leads->Clients->find('list', ['keyField'=>'id', 'valueField'=>'company_name'])->where(['id IN'=>$filtered_clients])->toArray();   
            }
    } else { // if admin
        if(isset($client_id)) {
                $wherePag = ['client_id'=>$client_id];
        }
        $totalCount = $this->Leads->find('all')->count();
        $this->paginate = [
            'contain' => ['Clients','LeadNotes','LeadStatus'],
            'conditions' => $wherePag,
            'limit'   => $totalCount,
            'maxLimit'=> $totalCount
            ];
        $leads = $this->paginate($this->Leads);
    	$clients = $this->Leads->Clients->find('list', ['keyField'=>'id', 'valueField'=>'company_name'])->toArray();   
        $dropedData[] = $leads;
        
    }


	if($foundlead == 1) {
	    foreach ($leads->first() as $key => $value) {
	      $findexist = $this->Contractors->find('all')->where(['company_name'=>$value->company_name])->first();
	       if(empty($findexist)){
	          $value->contractorExist = false;
	       }
	       else {
	         $value->contractorExist = true;
	       }
	    }
    }

    /* Export Leads  */
   /* if($export_type ==0) {
        $i =0;
        $data = array();        
        if(!empty($dropedData)) { 
  
            foreach ($dropedData[0] as $lead) {
                $data[$i]['company_name'] = $lead['company_name'];
                $data[$i]['lead_name'] = $lead['contact_name_first']." ".$lead['contact_name_last'];
                $data[$i]['phone_no'] = $lead['phone_no'];
                $data[$i]['email'] = $lead['email'];
                $data[$i]['client'] = $lead->client['company_name'];
                $data[$i]['email_count'] = $lead['email_count'];
                $data[$i]['phone_count'] = $lead['phone_count'];
                $data[$i]['status'] = $lead->lead_status['status'];
                $i++;

            }
        }
    
        $headT = array('Company Name','Leads Name','Phone No','Email','Client','Emails Sent','Phone Call Made','Status');      
        if($export_type == 'excel') { 
            $this->Export->XportLeadExcel($data,$headT); 
            exit;
        }
        if($export_type == 'csv') {
            $this->Export->XportToCSVLead($data,$headT);
            exit;
        }
    }


	//leads piechart
	$whereleads = '';
	if(isset($client_id) && $client_id!='') { $whereleads = " AND leads.client_id = $client_id"; }
	$conn = ConnectionManager::get('default');
	$leadsChart = $conn->execute("SELECT lead_status.status, COUNT(leads.lead_status_id) as leads_count
		FROM lead_status 
		LEFT JOIN leads ON leads.lead_status_id = lead_status.id $whereleads		
		GROUP BY leads.lead_status_id, lead_status.status, lead_status.id
		ORDER BY lead_status.id asc")->fetchAll('assoc');

        $this->set(compact('leads', 'clients','client_id', 'status', 'leadsChart','foundlead' ));

    }
*/  
    public function index($foundlead = null,$export_type=1,$client_id=null)
    {   

        ini_set('memory_limit','-1');   
       
        $this->loadModel('LeadStatus');
        $this->loadModel('Contractors');
        $this->loadModel('LeadNotes');
        $this->loadModel('Sites');

        $status = $this->LeadStatus->find('list', ['id'=>'id', 'valueField'=>'status'])->order(['id'])->toArray();
        if ($this->request->is(['patch', 'post', 'put'])) {      
            if(null != $this->request->getData('client_id')) {
                $client_id = $this->request->getData('client_id');
                return $this->redirect(['action' => 'index',0,0,$client_id]);
            }else{
                return $this->redirect(['action' => 'index']);
            }
        }
    //print_r($client_id);die;
    
    //$aColumn= array();s = array('Users.id', 'Users.username', 'company_name', 'pri_contact', 'Roles.role_title', 'Users.active');
        $aColumns = array('Leads.company_name', 'Leads.contact_name_first', 'Leads.phone_no', 'Leads.email','Clients.company_name','Sites.name','Leads.email_count','Leads.phone_count','LeadStatus.status','Leads.created','');
        if(isset($_GET['draw'])) { 
            $this->viewBuilder()->setLayout('ajax_content');
            
            /*
            * Paging
            */
            $page = $_GET['start'] / $_GET['length'] + 1 ;
            
            $limit = 10;
            if($_GET['length'] != '-1') { // length != all
                $limit = $_GET['length'];
            }
            
            /*
            * Ordering
            */
            $orderArr = [];
            if(!empty($_GET['order'])){              
                    $orderArr[] = $aColumns[$_GET['order'][0]['column']].' '.$_GET['order'][0]['dir'];               
            }

            /*
            * Filtering
            */
            $sWhere = [];

            if ($_GET['search']['value'] != "") {
                // search on string fields
                $strCloumns = ['Leads.company_name', 'Leads.contact_name_first','Leads.email','Clients.company_name','Sites.name','LeadStatus.status'];
                
                foreach($strCloumns as $cl) {
                    $sWhere['OR']['LOWER('.$cl.') LIKE'] = '%'.strtolower($_GET['search']['value']).'%';
                }              
            }

          //  print_r($client_id);die;
            if(isset($client_id) && $client_id!='') 
            { 
                $sWhere[] = ['Leads.client_id' => $client_id];
            }
            $this->paginate = [
                'page' => $page,
                'limit' => $limit,
                'contain' => [
                    'Clients', 
                    'LeadNotes', 
                    'LeadStatus',
                    'Sites'
                ],
                'conditions' =>  $sWhere,
                'order' => $orderArr                
            ];
            $leads = $this->paginate($this->Leads);
            //$totalCount = $this->Users->find('all')->count();
            $totalCount = $this->request->getParam('paging')['Leads']['count'];

            $this->set(compact('leads', 'totalCount'));
        }
      $clients = $this->Leads->Clients->find('list', ['keyField'=>'id', 'valueField'=>'company_name'])->toArray();   
     /* dropedata */
     $leads = [];
    $wherePag = [];
    $clients = [];
    $dropedData = [];
    
    if($this->User->isCR()) { // if CR
            $cr_id = $this->getRequest()->getSession()->read('Auth.User.CR_id');
            //$wherePag = ['Leads.customer_representative_id'=> $cr_id];
            $wherePag = ["Leads.customer_representative_id->'cr_ids' @> " => '['.$cr_id.']'];           
            if(isset($client_id)) {
            $wherePag = ['client_id'=>$client_id];
            }
            $totalCount = $this->Leads->find('all')->count();
            $this->paginate = [
                'contain' => ['Clients','LeadNotes','LeadStatus'],
                'conditions' => $wherePag,
                'limit'   => $totalCount,
                'maxLimit'=> $totalCount
                ];
            $leads = $this->paginate($this->Leads);

            $filtered_clients = $this->Leads
            ->find('list', ['keyField'=>'client_id', 'valueField'=>'client_id'])
            ->where(["customer_representative_id->'cr_ids' @> " => '['.$cr_id.']'])
            ->distinct(['client_id'])
            ->toArray();

            if(!empty($filtered_clients)) {
                $clients = $this->Leads->Clients->find('list', ['keyField'=>'id', 'valueField'=>'company_name'])->where(['id IN'=>$filtered_clients])->toArray();   
            }
    } else { // if admin
        if(isset($client_id)) {
                $wherePag = ['client_id'=>$client_id];
        }
        $totalCount = $this->Leads->find('all')->count();
        $this->paginate = [
            'contain' => ['Clients','LeadNotes','LeadStatus'],
            'conditions' => $wherePag,
            'limit'   => $totalCount,
            'maxLimit'=> $totalCount
            ];
        $leads = $this->paginate($this->Leads);
        $clients = $this->Leads->Clients->find('list', ['keyField'=>'id', 'valueField'=>'company_name'])->toArray();   
        $dropedData[] = $leads;
        
    }
      /* end of dropedata */  

    // if($foundlead == 1) {
    //     foreach ($leads->first() as $key => $value) {
    //       $findexist = $this->Contractors->find('all')->where(['company_name'=>$value->company_name])->first();
    //        if(empty($findexist)){
    //           $value->contractorExist = false;
    //        }
    //        else {
    //          $value->contractorExist = true;
    //        }
    //     }
    // } 

     if($export_type ==0) {
        $i =0;
        $data = array();        
        if(!empty($dropedData)) { 
  
            foreach ($dropedData[0] as $lead) {
                $data[$i]['company_name'] = $lead['company_name'];
                $data[$i]['lead_name'] = $lead['contact_name_first']." ".$lead['contact_name_last'];
                $data[$i]['phone_no'] = $lead['phone_no'];
                $data[$i]['email'] = $lead['email'];
                $data[$i]['client'] = $lead->client['company_name'];
                $data[$i]['email_count'] = $lead['email_count'];
                $data[$i]['phone_count'] = $lead['phone_count'];
                $data[$i]['status'] = $lead->lead_status['status'];
                $i++;

            }
        }
    
        $headT = array('Company Name','Leads Name','Phone No','Email','Client','Emails Sent','Phone Call Made','Status');      
        if($export_type == 'excel') { 
            $this->Export->XportLeadExcel($data,$headT); 
            exit;
        }
        if($export_type == 'csv') {
            $this->Export->XportToCSVLead($data,$headT);
            exit;
        }
    }  

    // //leads piechart
    $whereleads = '';
    if(isset($client_id) && $client_id!='') { $whereleads = " AND leads.client_id = $client_id"; }
    $conn = ConnectionManager::get('default');
    $leadsChart = $conn->execute("SELECT lead_status.status, COUNT(leads.lead_status_id) as leads_count
        FROM lead_status 
        LEFT JOIN leads ON leads.lead_status_id = lead_status.id $whereleads        
        GROUP BY leads.lead_status_id, lead_status.status, lead_status.id
        ORDER BY lead_status.id asc")->fetchAll('assoc');

        $this->set(compact('clients','leadsChart','status','client_id'));

    }


    /**
     * View method
     *
     * @param string|null $id Lead id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $lead = $this->Leads->get($id, [
            'contain' => ['Clients','LeadStatus','LeadNotes','LeadNotes.CustomerRepresentative']
        ]);

		if($this->User->isClient()){
		$lead = $this->Leads->get($id, [
            'contain' => ['Clients','LeadStatus','LeadNotes'=>['conditions'=>['show_to_client'=>1]],'LeadNotes.CustomerRepresentative']
        ]);
		
        /*$lead = $this->Leads
                ->find('all')            
                ->contain(['Clients'])
                ->contain(['LeadStatus']) 
                ->contain(['LeadNotes'=>['conditions'=>['show_to_client'=>1]]]) 
                ->contain(['LeadNotes.CustomerRepresentative']) 
                ->where(['Leads.id '=> $id])            
                ->first();
            
             $this->set('lead', $lead); */
        }
		
		if ($this->request->is(['patch', 'post', 'put'])) { 
			$lead = $this->Leads->patchEntity($lead, $this->request->getData());
			$lead->updated_fields = null;
			$lead->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');
			
			if ($this->Leads->save($lead)) {
				$this->Flash->success(__('The lead has been saved.'));
			} else {
				$this->Flash->error(__('The lead could not be saved. Please, try again.'));
			}
		}	
		
         $this->set('lead', $lead); 
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
    $this->loadModel('Clients');
    $this->loadModel('Users');
    $this->loadModel('States');
    $this->loadModel('Sites');
    $lead_CR = Configure::read('Lead_CR');

    $clients = array();
    $loggedAsClient = $this->getRequest()->getSession()->read('Auth.User.id');
    if($this->User->isClient()){
         $client = $this->Clients->ClientUsers->find('list',['keyField'=>'id','valueField'=>'client_id'])->contain(['Clients'])->where(['Users.role_id'=>CLIENT, 'Users.active'=>true,'user_id'=>$loggedAsClient])->contain(['Users'])->first();
         $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
    }else{
        $clients = $this->User->getClientList();
    }
    $client_ids = array();
    $client_ids = array_keys($clients);
    $locations = array();

        if ($this->request->is('post')) {
            if(!empty($this->request->getData('client_id'))){
                $cid = $this->request->getData('client_id');
                $locations = $this->Sites->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['client_id' => $client_id])->toArray();
            }
        }elseif(isset($client_ids[0]) && $client_ids[0] > 0 )
        {
            $cid = $client_ids[0];
        }elseif(!empty($client_id) && $client_id > 0){
            $cid = $client_id;
        }
        $locations = $this->Sites->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['client_id' => $cid])->toArray();

    $lead = $this->Leads->newEntity();
    
    if ($this->request->is('post')) {  
    if(!empty($this->request->getData('client_id'))){
        $client_id = $this->request->getData('client_id');
    }
        $site_id = null;
    if(!empty($this->request->getData('site_id'))){
       $site_id = $this->request->getData('site_id');
    }


    $lead_custrep = $this->Clients->find()->where(['id'=>$client_id])->first(); 
    $created_by = $this->getRequest()->getSession()->read('Auth.User.id');
    $document = $this->request->getData('file');

    
        if($document['size']>0) {
            $fuConfig['upload_path'] = UPLOAD_LEADS;
            $fuConfig['allowed_types']  = '*';
            $fuConfig['max_size']       = 0;
            $this->Fileupload->init($fuConfig);

            if (!$this->Fileupload->upload($document)) {
                $fError = $this->Fileupload->errors();
                $this->Flash->error(__('The lead could not be saved. Please, try again.'));
            } else {
                $fileName = $this->Fileupload->output('file_name');
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile(UPLOAD_LEADS.$fileName);
                $reader->setReadDataOnly(true);
                        
                $spreadsheet = $reader->load(UPLOAD_LEADS.$fileName);
                $worksheet = $spreadsheet->getActiveSheet();
                $header=true;

		if ($header) {
		    $highestRow = $worksheet->getHighestRow();
		    $highestColumn = $worksheet->getHighestColumn();
		    $headingsArray = $worksheet->rangeToArray('A1:H1', null, true, true, true);
		    $headingsArray = $headingsArray[1];
		    $r = -1;
		    $namedDataArray = array();          
		    
		    for ($row = 2; $row <= $highestRow; ++$row) {
		        $dataRow = $worksheet->rangeToArray('A' . $row . ':' . 'H' . $row, null, true, true, true);
		       
		        if ((isset($dataRow[$row]['A'])) && ($dataRow[$row]['A'] > '')) {
		            ++$r;
		            foreach ($headingsArray as $columnKey=>$columnHeading) {
		               $columnHeading = strtolower(str_replace(' ', '_', $columnHeading));
		                if($columnHeading=='primary_contact') {
		                    $parts = explode(' ', $dataRow[$row][$columnKey]);
		                    $t = array( 'firstname' => array_shift($parts),'lastname' => array_pop($parts),       'middlename' => join(' ', $parts));
		                    $namedDataArray[$r]['contact_name_first'] = $t['firstname'];
		                    $namedDataArray[$r]['contact_name_last'] = $t['lastname'];
		                  
		                }
		               $namedDataArray[$r][$columnHeading] = $dataRow[$row][$columnKey];
		            }
		        }
		   }
		}
		else {
		    $namedDataArray = $worksheet->toArray(null, true, true, true);
		}
      
		foreach ($namedDataArray as $key=>$value) {
            $lead = $this->Leads->newEntity();
		    $lead = $this->Leads->patchEntity($lead,$value);
            // if(($value['company_name'] !='' && $value['email'] != "") || ($value['company_name'] !='' && $value['phone_no'] != "")){

            if($value['email'] == "" && $value['phone_no'] == ""){
                $lead->lead_status_id = 7;
            }elseif($value['email'] == ""){

                $lead->lead_status_id = 3;                
            }else if ($value['phone_no'] == ""){
                $lead->lead_status_id = 5;
            }else{
                $lead->lead_status_id = 1;
            }                
		       if($this->User->isClient()){
                $lead->client_id = $client;
               }else{
                $lead->client_id =$client_id;
               }
                $lead->site_id =$site_id;
                // $lead->customer_representative_id  = $lead_custrep['lead_custrep_id'];
                $lead->customer_representative_id  = ['cr_ids' => array_values($lead_CR)];
		        $lead->created_by = $created_by;
                //pr($lead);die;
		        $this->Leads->save($lead);
		  }
          $this->Flash->success(__('The lead has been saved.'));
     	}   
      		
      }
    }

    $this->set(compact('lead','clients', 'locations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Lead id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->loadModel('Clients');
        $this->loadModel('CustomerRepresentative');

        $user_id = $this->getRequest()->getSession()->read('Auth.User.id');

        $lead = $this->Leads->get($id, [
            'contain' => ['LeadStatus']
        ]);
      
    	if($this->User->isAdmin()) {
        	$updateBy = 'CanQualify Admin';
        }
        else {
        	$client = $this->Clients->find()->select(['id','company_name'])->where(['id' => $lead['client_id']])->first();
            $updateBy = $client['company_name'];
        }

		// $lead_cr = $this->CustomerRepresentative->find()->select(['Users.username'])->where(['CustomerRepresentative.id' => $lead['customer_representative_id']])->contain(['Users'])->first();
        $lead_cr = $this->CustomerRepresentative->find()->select(['pri_contact_fn','pri_contact_ln','Users.username'])->where(['CustomerRepresentative.id' => $lead->customer_representative_id['cr_ids'][0]])->contain(['Users'])->first();
        

        $lead_cr_email = null;
        if(!empty($lead_cr)) { $lead_cr_email = $lead_cr->user->username; }
        $lead_cr_fullname = null;
        if(!empty($cr_fullname)) { $lead_cr_fullname = $lead_cr->pri_contact_fn." ".$lead_cr->pri_contact_ln; }
        $status = $this->Leads->LeadStatus->find('list', ['keyField'=>'id', 'valueField'=>'status'])->order(['id'])->toArray();
        //$prevleadStatus = $status[$lead['lead_status_id']];

        if ($this->request->is(['patch', 'post', 'put'])) { 
            //$newleadStatus = $status[$this->request->getData('lead_status_id')];	
            $lead = $this->Leads->patchEntity($lead, $this->request->getData());
			
           /* if($this->User->isClient()) { 
				$lead->lead_status_id = 9;  // updated 
				// if lead edited by client set updated_fields to hightlight
				if($this->User->isClient() && $lead->isDirty() ) {
					$updated_fields = [];
					foreach($lead->getDirty() as $field) {
						if($lead->$field != $lead->getOriginal($field)) {
							$updated_fields[] = $field;
						}
					}
					if(!empty($lead->updated_fields)) {
						$updated_fields = array_unique(array_merge($lead->updated_fields, $updated_fields));
					}
					$lead->updated_fields = $updated_fields;
				}
			}
			else {
				if($lead->lead_status_id!=9) {  // if lead_status not updated
					$lead->updated_fields = [];
				}
			}*/			
			$lead->modified_by = $user_id;
       
            if ($this->Leads->save($lead)) {
                /*if($newleadStatus!=$prevleadStatus && $lead_cr_email!='') { */
				if($this->User->isClient()) {
					$leadurl = Router::Url(['controller' => 'leads', 'action' => 'view'], true) . '/' . $lead->id;                
					 $this->getMailer('User')->send('lead_update', [$lead, $leadurl, $lead_cr_email,$lead_cr_fullname, $updateBy]);
				}
                $this->Flash->success(__('The lead has been saved.'));
                if($this->User->isClient()) {
					return $this->redirect(['action' => 'pending-leads']);
                } else {
					return $this->redirect(['action' => 'index']);
				}
            }
            $this->Flash->error(__('The lead could not be saved. Please, try again.'));
        }
        $clients = $this->Leads->Clients->find('list', ['limit' => 200]);
        //$states = $this->Leads->States->find('list',['keyField'=>'name', 'valueField'=>'name']);
        $this->set(compact('lead', 'clients','status'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Lead id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $lead = $this->Leads->get($id);
        if ($this->Leads->delete($lead)) {
            $this->Flash->success(__('The lead has been deleted.'));
        } else {
            $this->Flash->error(__('The lead could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function addContractor($id=null)
    {
	$this->viewBuilder()->setLayout('ajax');
	$this->loadModel('Contractors');
	$contractorList = $this->Contractors->find('list', ['keyField'=>'id', 'valueField'=>'company_name'])->toArray();
	
	$lead = $this->Leads->get($id, [
            'contain' => []
        ]);		
        if ($this->request->is(['patch', 'post', 'put'])) {
            $lead = $this->Leads->patchEntity($lead, $this->request->getData());
            $lead->lead_status_id = 3;
            if ($this->Leads->save($lead)) {
                $this->Flash->success(__('The lead has been saved.'));
                
                //return $this->redirect(['action' => 'index']);
            }else {
            $this->Flash->error(__('The lead could not be saved. Please, try again.'));
        }
        }
        $clients = $this->Leads->Clients->find('list', ['limit' => 200]);
        $this->set(compact('lead', 'clients', 'contractorList'));
    }

    public function findLeads()  // find Leads
    {
        ini_set('memory_limit','-1');
        $list1 = array();
        $list2 = array();
        $this->loadModel('Contractors');
        if ($this->request->is('post')) 
        { 
           
                   
            $document1 = $this->request->getData('file1');
           
            $document2 = $this->request->getData('file2');
            
            if($document1['size']>0) 
            {
                $fuConfig['upload_path'] = UPLOAD_LEADS;
                $fuConfig['allowed_types']  = '*';
                $fuConfig['max_size']       = 0;
                $this->Fileupload->init($fuConfig);
                if ($this->Fileupload->upload($document1))              /// File 1 Upload 
                {

                    $fileName = $this->Fileupload->output('file_name');
                    $worksheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(UPLOAD_LEADS.$fileName);
                    $worksheet = $worksheet->getActiveSheet();
                        $header=true;
                        if ($header) 
                        {          
                            $highestRow = $worksheet->getHighestRow();
                            $highestColumn = $worksheet->getHighestColumn();
                            $headingsArray = $worksheet->rangeToArray('A1', null, true, true, true);
                            $headingsArray = $headingsArray[1];
                            $r = 1;
                            $namedDataArray = array();          
                            
                            for ($row = 2; $row <= $highestRow; ++$row) {
                                $dataRow = $worksheet->rangeToArray('A' . $row, null, true, true, true);
                              
                                    foreach ($headingsArray as $columnKey=>$columnHeading) {
                                       $namedDataArray[$row] = $dataRow[$row][$columnKey];
                                 
                                    }
                           }
                        } else {                   
                            $namedDataArray = $worksheet->toArray(null, true, true, true);
                        }
                        $list1 = $namedDataArray;
                    if($document2['size']>0) 
                    {
                            $fuConfig['upload_path'] = UPLOAD_LEADS;
                            $fuConfig['allowed_types']  = '*';
                            $fuConfig['max_size']       = 0;
                            // $this->Fileupload->init($fuConfig);
                            if($this->Fileupload->upload($document2))   /// File 2 Upload 
                            {     
                                $fileName2 = $this->Fileupload->output('file_name');
                                $worksheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(UPLOAD_LEADS.$fileName2);
                                $worksheet = $worksheet->getActiveSheet();
                                $header=true;
                                if ($header) 
                                {          
                                    $highestRow = $worksheet->getHighestRow();
                                    $highestColumn = $worksheet->getHighestColumn();
                                    $headingsArray = $worksheet->rangeToArray('A1', null, true, true, true);
                                    $headingsArray = $headingsArray[1];
                                    $r = 1;
                                    $namedDataArray = array();          
                                    
                                    for ($row = 2; $row <= $highestRow; ++$row) {
                                        $dataRow = $worksheet->rangeToArray('A' . $row, null, true, true, true);
                                      
                                            foreach ($headingsArray as $columnKey=>$columnHeading) {
                                               $namedDataArray[$row] = $dataRow[$row][$columnKey];
                                         
                                            }
                                   }
                                } else {                   
                                    $namedDataArray = $worksheet->toArray(null, true, true, true);
                                }  
                                $list2 = $namedDataArray;
                               
                            }
                            
                    }else  /* Compare file 1 with database */
                    {
                        $list2 = $this->Contractors->find('list', ['keyField'=>'id', 'valueField'=>'company_name'])->limit(20000)->toArray();

                        
                    }
                     /* Compare file 1 amd file 2*/
                    $list1 = array_map('strtolower',$list1);
                    $list2 = array_map('strtolower',$list2);
                    $list2 = array_intersect($list2,$list1);
                    $list2 = array_map('strtoupper',$list2);
                       
                }

           }
    
        } ///  End Of post 
        $this->set(compact('list2'));
    } //end of function  
    
    public function pendingLeads($client_id=null)
    {
        ini_set('memory_limit','-1');	
        $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
       
        $this->loadModel('LeadStatus');
        $this->loadModel('Contractors');

        $totalCount = $this->Leads->find('all')->count();
        $where = array(['client_id'=>$client_id]);
        if ($this->request->is(['post'])) {

            //$iconArray = array('Waiting On Contractor' => 0, 'Non-compliant' => 1, 'Conditional' => 2, 'Compliant' => 3);
            //$iconArrayKeys = array_keys($iconArray);
            $postData = $this->request->getData();
            $postVariables = array_keys($postData);
            if(in_array('leadsfilter1',$postVariables)){
                /*chart filters are on*/
                $condition_1 = $postData['leadsfilter1'];
                switch($condition_1){
                    case 'Pending':
                        $where[] = ['leads.lead_status_id !=' => 6];
                        break;
                    case 'Registered':
                        $where[] = ['leads.lead_status_id' => 6];
                        break;

                }
            }
        }

    //leads piechart
        $whereleads = '';
	if(isset($client_id) && $client_id!='') { $whereleads .= " AND leads.client_id = $client_id "; }
	$conn = ConnectionManager::get('default');
	$leadsChart = $conn->execute("SELECT lead_status.status, COUNT(leads.lead_status_id) as leads_count
		FROM lead_status 
		LEFT JOIN leads ON leads.lead_status_id = lead_status.id $whereleads	
		GROUP BY leads.lead_status_id, lead_status.status, lead_status.id
		ORDER BY lead_status.id asc")->fetchAll('assoc');


if(isset($client_id)){
        $this->paginate = [
            'contain' => ['Clients', 'LeadStatus'],
            'conditions' => $where,
            'order' => ['Leads.created' => 'DESC'],
            'limit'   => $totalCount,
            'maxLimit'=> $totalCount
            ];
        $leads = $this->paginate($this->Leads);
}
$newdata = array();
foreach ($leadsChart as $k=>$val){
    array_push($newdata, array("label" => $val['status'], "value" => $val['leads_count']));
}
        $supplierRegistrationChart = array(
            "chart" => array("enablesmartlabels" => "1",
                "exportEnabled" => "1",
                "showlabels" => "0",
                "plottooltext"=> "\$label, <b>\$value</b>",
                "showPercentInTooltip" => "1",
                "valuePosition" => "inside",
                "valueFontColor" => "#FFFFFF",
                "canvasPadding" => "0",
                "chartLeftMargin" => "0",
                "chartTopMargin" => "0",
                "chartRightMargin" => "0",
                "chartBottomMargin" => "10",
                "doughnutRadius" => "60",
                "pieRadius" => "140",
                "startingAngle" => "0",
                "theme" => "fusion"),
            "data" => $newdata
        );
$this->set('supplierRegistrationChart', $supplierRegistrationChart);
        $this->set(compact('leads','client_id', 'leadsChart'));
    }

    public function manuallyAdd(){

    $this->loadModel('Clients');
     $this->loadModel('Users');
    $this->loadModel('States');
    $lead_CR = Configure::read('Lead_CR');    

    $leads = [];
    $wherePag = [];
    $clients = [];
    if($this->User->isCR()) { // if CR
            $cr_id = $this->getRequest()->getSession()->read('Auth.User.CR_id');

            $wherePag = ['Leads.customer_representative_id'=> $cr_id];
             if(isset($client_id)) {
                $wherePag = ['client_id'=>$client_id];
             }

             $totalCount = $this->Leads->find('all')->count();
             $this->paginate = [
                'contain' => ['Clients','LeadNotes','LeadStatus'],
                'conditions' => $wherePag,
                'limit'   => $totalCount,
                'maxLimit'=> $totalCount
                ];

            $leads = $this->paginate($this->Leads);

        $filtered_clients = $this->Leads->find('list', ['keyField'=>'client_id', 'valueField'=>'client_id'])->where(["Leads.customer_representative_id->'cr_ids' @> " => '['.$cr_id.']'])->distinct(['client_id'])->toArray();

        if(!empty($filtered_clients)) {
            $clients = $this->Leads->Clients->find('list', ['keyField'=>'id', 'valueField'=>'company_name'])->where(['id IN'=>$filtered_clients])->toArray(); 
             $this->set(compact('clients'));  
        }
    } else { // if admin
        // if(isset($client_id)) {
        //         $wherePag = ['client_id'=>$client_id];
        // }
        // $totalCount = $this->Leads->find('all')->count();
        // $this->paginate = [
        //     'contain' => ['Clients','LeadNotes','LeadStatus'],
        //     'conditions' => $wherePag,
        //     'limit'   => $totalCount,
        //     'maxLimit'=> $totalCount
        //     ];
        // $leads = $this->paginate($this->Leads);

        // $clients = $this->Leads->Clients->find('list', ['keyField'=>'id', 'valueField'=>'company_name'])->toArray();  
        if($this->User->isClient()) {
             $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
        }
        else {
            // $clients = $this->Clients->find('list', ['keyField'=>'id', 'valueField'=>'company_name'])->where(['Users.role_id'=>CLIENT, 'Users.active'=>true])->contain(['Users'])->toArray();

            // $userList = $this->Users
            //     ->find('all')
            //     ->select(['Users.id','Users.active'])
            //     ->contain(['ClientUsers'=>['fields'=>['id','client_id','user_id']]])
            //     ->contain(['ClientUsers.Clients'=>['fields'=>['id','company_name']]])               
            //     ->where(['role_id'=>CLIENT,'Users.active'=>true])
            //     ->toArray();
     
            // $clients = array();
            // foreach ($userList as $key => $user) {
            //     $client = $user['client_user']['client'];
            //     //if(!empty($client)){
            //      $clients[$client['id']] = $client['company_name'];
            //     //}
            // }
            $clients = $this->User->getClientList();
     
             $this->set(compact('clients'));
        } 
    }

        $lead = $this->Leads->newEntity();
        if ($this->request->is('post')) {
            $created_by = $this->getRequest()->getSession()->read('Auth.User.id');
        	if(!$this->User->isClient()) {

                $client_id = $this->request->getData('client_id');

            }
            //$lead_custrep = $this->Clients->find()->where(['id'=>$client_id])->first(); 
            $getData = $this->request->getData();
           if(!empty($getData)) { 
            $lead = $this->Leads->patchEntity($lead, $getData);          
             if($lead['email'] == "" && $lead['phone_no'] == ""){
                $lead->lead_status_id = 7;
            }elseif($lead['email'] == ""){
                $lead->lead_status_id = 3;                
            }else if ($lead['phone_no'] == ""){
                $lead->lead_status_id = 5;
            }else{
                $lead->lead_status_id = 1;
            }            
            $lead->client_id = $client_id;
            //$lead->customer_representative_id  = $lead_custrep['lead_custrep_id'];
            $lead->customer_representative_id  = ['cr_ids' => array_values($lead_CR)];
            $lead->created_by = $created_by; 
            
            if($this->Leads->save($lead)) {
                $this->Flash->success(__('The lead has been saved.'));
                if($this->User->isClient()) {return $this->redirect(['action' => 'pendingLeads']);}
                else { return $this->redirect(['action' => 'index']);} 
              }}            
            $this->Flash->error(__('The lead could not be saved. Please, try again.'));
        }
        $this->set(compact('lead'));
    }
}