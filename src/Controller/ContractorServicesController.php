<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
/**
 * ContractorServices Controller
 *
 * @property \App\Model\Table\ContractorServicesTable $ContractorServices
 *
 * @method \App\Model\Entity\ContractorService[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ContractorServicesController extends AppController
{
     public function isAuthorized($user)
    {
	$contractorNav = false;
	if($user['role_id'] == CR) {
		$contractorNav = true;
	}
	$this->set('contractorNav', $contractorNav);
	
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
        $this->paginate = [
            'contain' => ['Contractors', 'Services']
        ];
        $contractorServices = $this->paginate($this->ContractorServices);

        $this->set(compact('contractorServices'));
    }

    /**
     * View method
     *
     * @param string|null $id Contractor Service id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $contractorService = $this->ContractorServices->get($id, [
            'contain' => ['Contractors', 'Services']
        ]);

        $this->set('contractorService', $contractorService);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $contractorService = $this->ContractorServices->newEntity();
        if ($this->request->is('post')) {
            $contractorService = $this->ContractorServices->patchEntity($contractorService, $this->request->getData());
            if ($this->ContractorServices->save($contractorService)) {
                $this->Flash->success(__('The contractor service has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The contractor service could not be saved. Please, try again.'));
        }
        $contractors = $this->ContractorServices->Contractors->find('list', ['limit' => 200]);
        $services = $this->ContractorServices->Services->find('list', ['limit' => 200]);
        $this->set(compact('contractorService', 'contractors', 'services'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Contractor Service id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $contractorService = $this->ContractorServices->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contractorService = $this->ContractorServices->patchEntity($contractorService, $this->request->getData());
            if ($this->ContractorServices->save($contractorService)) {
                $this->Flash->success(__('The contractor service has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The contractor service could not be saved. Please, try again.'));
        }
        $contractors = $this->ContractorServices->Contractors->find('list', ['limit' => 200]);
        $services = $this->ContractorServices->Services->find('list', ['limit' => 200]);
        $this->set(compact('contractorService', 'contractors', 'services'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Contractor Service id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $contractorService = $this->ContractorServices->get($id);
        if ($this->ContractorServices->delete($contractorService)) {
            $this->Flash->success(__('The contractor service has been deleted.'));
        } else {
            $this->Flash->error(__('The contractor service could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function subscription()
    {
    $this->loadModel('Clients');
    $this->loadModel('Products');

	$contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
    $contractor = $this->ContractorServices->Contractors->get($contractor_id);

    $clients = $this->Clients->find('list', ['keyField'=>'id', 'valueField'=>'company_name'])->toArray();

    $subscriptions = $this->ContractorServices
                    ->find('all')
                    ->contain(['Services'=>['fields'=>['id','name']] ])
                    ->where(['contractor_id'=>$contractor_id])
                    ->enableHydration(false)
                    ->toArray();

        $employeeslot = Configure::read('EmployeeQual');

        foreach($subscriptions as $key => $cs) {
            $client_cnt = count($cs['client_ids']['c_ids']);
		    $product = $this->Products->find('all')->where(['service_id' => $cs['service_id'], 'range_from <= ' => $client_cnt, 'range_to >= ' => $client_cnt])->first();
			$product_price = 0;
            if($cs['service_id']==4) {
                $product_price = $employeeslot['base'] * $cs['slot'];
            }
			elseif(!empty($product)) {
				$product_price = $product->pricing;
			}
            $subscriptions[$key]['price'] = $product_price;
         }
    $this->set(compact('subscriptions', 'clients', 'contractor'));
    }

    function servicesCorrection()
    {
        $this->loadModel('ContractorClients');
        $this->loadModel('ContractorServices');

        $marketPlaceContractors = $this->ContractorClients->find('all')->where(['client_id' => 4])->toArray();
        if(!empty($marketPlaceContractors)) {
            foreach ($marketPlaceContractors as $contractor) {
                $contractorService = $this->ContractorServices->find('all')->where(['contractor_id' => $contractor->contractor_id, 'service_id' => 1])->first();
                if (!empty($contractorService)) { // Update
                    // Merge new clients with old
                    if(isset($contractorService->client_ids['c_ids']) && !empty($contractorService->client_ids['c_ids'])){
                        $client_ids = array_unique(array_merge($contractorService->client_ids['c_ids'], array(4)));
                    }else{
                        $client_ids = array(4);
                    }
                    $contractorService = $this->ContractorServices->patchEntity($contractorService, array('service_id' => 1));
                    $contractorService->client_ids = ['c_ids' => array_values($client_ids)];
                    $contractorService->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');
                    $this->ContractorServices->save($contractorService);
                } else { // New
                    $contractorService = $this->ContractorServices->newEntity();
                    $contractorService = $this->ContractorServices->patchEntity($contractorService, array('service_id' => 1));
                    $contractorService->client_ids = ['c_ids' => array(4)];
                    $contractorService->contractor_id = $contractor->contractor_id;
                    $contractorService->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
                    $this->ContractorServices->save($contractorService);
                }
                $contractorService = $this->ContractorServices->find('all')->where(['contractor_id' => $contractor->contractor_id, 'service_id' => 6])->first();
                if (!empty($contractorService)) { // Update
                    // Merge new clients with old
                    if(isset($contractorService->client_ids['c_ids']) && !empty($contractorService->client_ids['c_ids'])){
                        $client_ids = array_unique(array_merge($contractorService->client_ids['c_ids'], array(4)));
                    }else{
                        $client_ids = array(4);
                    }

                    $contractorService = $this->ContractorServices->patchEntity($contractorService, array('service_id' => 6));
                    $contractorService->client_ids = ['c_ids' => array_values($client_ids)];
                    $contractorService->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');
                    $this->ContractorServices->save($contractorService);
                } else { // New
                    $contractorService = $this->ContractorServices->newEntity();
                    $contractorService = $this->ContractorServices->patchEntity($contractorService, array('service_id' => 6));
                    $contractorService->client_ids = ['c_ids' => array(4)];
                    $contractorService->contractor_id = $contractor->contractor_id;
                    $contractorService->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
                    $this->ContractorServices->save($contractorService);
                }
            }
        }
    }
}
