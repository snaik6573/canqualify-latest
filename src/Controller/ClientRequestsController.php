<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\MailerAwareTrait;       //  Built in function use for sending multiple email
/**
 * ClientRequests Controller
 *
 * @property \App\Model\Table\ClientRequestsTable $ClientRequests
 *
 * @method \App\Model\Entity\ClientRequest[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ClientRequestsController extends AppController
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
        $contractorNav = false;
        if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN || $user['role_id'] == CR) {
            $contractorNav = true;
        }
        $this->set('contractorNav', $contractorNav);
    }
   // if (isset($user['role_id']) && $user['active'] == 1) {
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
    $this->loadModel('ClientRequestsLeads');  

    $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
    $contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
    $totalCount = $this->ClientRequests->find('all')->count();                              
    
    $ClientRequestLead = $this->ClientRequestsLeads->find("all")->contain(['Leads'])->where(['ClientRequestsLeads.client_id'=>$client_id])->toArray();

        $this->paginate = [
	    'conditions' => ['OR'=>['client_id'=>$client_id,'contractor_id'=>$contractor_id]],
            'contain' => ['Clients', 'Contractors'],
			'limit'=>$totalCount,
            'maxLimit'=>$totalCount
        ];
        $clientRequests = $this->paginate($this->ClientRequests);

        $this->set(compact('ClientRequestLead','clientRequests'));
    }

    /**
     * View method
     *
     * @param string|null $id Client Request id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $clientRequest = $this->ClientRequests->get($id, [
            'contain' => ['Clients', 'Contractors']
        ]);
        
        $this->set('clientRequest', $clientRequest);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
     /* send request to contractor */
    public function add($contractor_id=null, $client_id=null)
    {
    	$this->loadModel('Clients');
        $this->loadModel('ContractorClients');
    	$this->viewBuilder()->setLayout('ajax');

        /*$clientRequest = $this->ClientRequests->newEntity();
        if ($this->request->is('post')) {
            $clientRequest = $this->ClientRequests->patchEntity($clientRequest, $this->request->getData());
            if ($this->ClientRequests->save($clientRequest)) {
                $this->Flash->success(__('The client request has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The client request could not be saved. Please, try again.'));
        }
        $clients = $this->ClientRequests->Clients->find('list', ['limit' => 200]);
        $contractors = $this->ClientRequests->Contractors->find('list', ['limit' => 200]);
        $this->set(compact('clientRequest', 'clients', 'contractors'));*/
	
	    if($client_id == null)	{
		    $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
	    }
	    $client = $this->Clients->get($client_id, [
               'contain'=>[]
        ]);
        $contractor = $this->ClientRequests->Contractors->get($contractor_id, [
                'contain'=>['Users']
        ]);

        $clientRequest = $this->ClientRequests->newEntity();
        if ($this->request->is('post')) {
            $clientRequest = $this->ClientRequests->patchEntity($clientRequest, $this->request->getData());
            $clientRequest->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
            $clientRequest->client_id = $client_id;
            $clientRequest->contractor_id = $contractor_id;
            $clientRequest->status = 1;

            if ($this->ClientRequests->save($clientRequest)) {
                $this->Flash->success(__('The client request has been sent.'));

				//$contractor_client = $this->User->getClients($contractor_id);
                $contractor_client = $this->ContractorClients->find('list', ['valueField'=>'client_id'])->where(['contractor_id'=>$contractor_id])->toArray();	      	
            
				if(count($contractor_client) == 1){
                    $contractor_client = array_values($contractor_client);
					$getClientRequest = $this->ClientRequests->Clients->find("all")->select(['id','company_name'])->where(['id'=>$contractor_client[0]])->order(['company_name'=>'ASC'])->enableHydration(false)->toArray();                        
					$client_name = $getClientRequest[0]['company_name'];
					if($client_name!='CanQualify Marketplace Listing') {
						$this->getMailer('User')->send('send_request', [$contractor, $this->request->getData(), $client]);
					}
				}
				else {
					$this->getMailer('User')->send('send_request', [$contractor, $this->request->getData(), $client]);
				}
            }
            else {
			    $this->Flash->error(__('The client request could not be saved. Please, try again.'));
		    }
        }
       
        $this->set(compact('clientRequest','contractor','client'));
    }

    /* send request to Leads  */
    public function addadmin($lead_id=null,$client_id=null) {

        $this->loadModel('ClientRequestsLeads');    
        $this->viewBuilder()->setLayout('ajax');

        if($client_id == null) {
            $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
        }

        $clientLead_Request = $this->ClientRequestsLeads->newEntity();
        if ($this->request->is('post')) {
            $clientLead_Request = $this->ClientRequestsLeads->patchEntity($clientLead_Request, $this->request->getData());
            $clientLead_Request->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
            $clientLead_Request->client_id = $client_id;
            $clientLead_Request->lead_id = $lead_id;
            $clientLead_Request->status = 1;         

            if ($this->ClientRequestsLeads->save($clientLead_Request)) {
                $this->Flash->success(__('The client request has been sent.'));
                $this->getMailer('User')->send('send_request_admin', [$this->request->getData()]);
            }
            else {
               $this->Flash->error(__('The client request could not be saved. Please, try again.'));
            }
        }  
    }

    /**
     * Edit method
     *
     * @param string|null $id Client Request id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function edit($id = null)
    {
        $clientRequest = $this->ClientRequests->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $clientRequest = $this->ClientRequests->patchEntity($clientRequest, $this->request->getData());
            if ($this->ClientRequests->save($clientRequest)) {
                $this->Flash->success(__('The client request has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The client request could not be saved. Please, try again.'));
        }
        $clients = $this->ClientRequests->Clients->find('list', ['limit' => 200]);
        $contractors = $this->ClientRequests->Contractors->find('list', ['limit' => 200]);
        $this->set(compact('clientRequest', 'clients', 'contractors'));
    }*/

    /**
     * Delete method
     *
     * @param string|null $id Client Request id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $clientRequest = $this->ClientRequests->get($id);
        if ($this->ClientRequests->delete($clientRequest)) {
            $this->Flash->success(__('The client request has been deleted.'));
        } else {
            $this->Flash->error(__('The client request could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    /*public function accept($id = null)
    {
        $clientRequest = $this->ClientRequests->get($id, [
            'contain' => []
        ]);

        $clientRequest->status = 2;
        if ($this->ClientRequests->save($clientRequest)) {
            $this->Flash->success(__('The client request has been saved.'));
	    return $this->redirect(['controller'=>'ContractorSites', 'action' => 'siteAdd']);
        }
	
        $this->Flash->error(__('The client request could not be saved. Please, try again.'));
		return $this->redirect(['controller'=>'ContractorSites', 'action' => 'siteAdd']);

        //$this->set(compact('clientRequest'));
    }*/

   /* public function display(){
    $this->loadModel('ClientRequestsLeads');  

    $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
    $totalCount = $this->ClientRequests->find('all')->count();                              
    
    $ClientRequestLead = $this->ClientRequestsLeads->find("all")->contain(['Leads'])->where(['ClientRequestsLeads.client_id'=>$client_id])->toArray();

    $ClientRequest = $this->ClientRequests->find("all")->contain(['Contractors'])->where(['ClientRequests.client_id'=>$client_id])->toArray();
                 
        $this->set(compact('ClientRequestLead','ClientRequest'));
    }   */
    
}
