<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
require_once("../vendor/aws/aws-autoloader.php");
use Aws\S3\S3Client;

/**
 * FormsNDocs Controller
 *
 * @property \App\Model\Table\FormsNDocsTable $FormsNDocs
 *
 * @method \App\Model\Entity\FormsNDoc[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FormsNDocsController extends AppController
{
    public function isAuthorized($user)
    {
	$clientNav = false;
	if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN) {
		$clientNav = true;
	}
	$this->set('clientNav', $clientNav);

	if (isset($user['role_id']) && $user['active']== 1) {
		if(in_array($user['role_id'], array(SUPER_ADMIN, ADMIN, CLIENT, CLIENT_ADMIN, CLIENT_VIEW, CLIENT_BASIC, CONTRACTOR, CONTRACTOR_ADMIN, CR))) {
			return true;
		}
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
	$client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
        $this->paginate = [
            'contain' => ['Clients'],
            'conditions' => ['client_id'=>$client_id]
        ];
        $formsNDocs = $this->paginate($this->FormsNDocs);

        $this->set(compact('formsNDocs'));
    }*/

    /**
     * View method
     *
     * @param string|null $id Forms N Doc id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
	$client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');

        $formsNDoc = $this->FormsNDocs->get($id, [
        'contain' => ['Clients', 'ContractorDocs', 'ContractorDocs.Contractors'],
	    'conditions' => ['client_id'=>$client_id]
        ]);

        $this->set(compact('formsNDoc'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
	$client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
	$userId = $this->getRequest()->getSession()->read('Auth.User.id');

	$formsNDoc = $this->FormsNDocs->newEntity();
	if ($this->request->is(['patch', 'post', 'put'])) {
		if(null !==$this->request->getData('id'))
		{
			$formsNDoc = $this->FormsNDocs->get($this->request->getData('id'), [
			    'contain' => []
			]);

			$formsNDoc = $this->FormsNDocs->patchEntity($formsNDoc, $this->request->getData());
			if ($this->FormsNDocs->save($formsNDoc)) {
				$this->Flash->success(__('The FormsNDocs has been saved.'));
				return $this->redirect(['action' => 'add']);
			}
		}

		$requestDt = $this->request->getData('forms-n-docs');
		foreach($requestDt as $key => $val) {
			if($val['document']!='') {
				$formsNDoc = $this->FormsNDocs->newEntity();
				$formsNDoc = $this->FormsNDocs->patchEntity($formsNDoc, $val);
				$formsNDoc->client_id = $client_id;
				$formsNDoc->created_by = $userId;
				if($this->FormsNDocs->save($formsNDoc)) {
					//$this->Flash->success(__('The forms n doc has been saved.'));
				}
				/*else {
					$this->Flash->error(__('The forms n doc could not be saved. Please, try again.'));
				}*/
			}
			else {
				$this->Flash->error(__('The forms n doc could not be saved. Please, try again.'));
			}
		}
		$this->Flash->success(__('The forms n doc has been saved.'));
	}

	$totalCount = $this->FormsNDocs->find('all')->count();
        $this->paginate = [
        'contain' => ['Clients', 'ContractorDocs'],
	    'conditions' => ['client_id'=>$client_id, 'contractor_id is' => null],
	    'limit'  => $totalCount,
      	    'maxLimit'=> $totalCount
        ];

        $formsNDocs = $this->paginate($this->FormsNDocs);

        $clients = $this->FormsNDocs->Clients->find('list');
        $this->set(compact('formsNDoc', 'clients', 'formsNDocs','client_id','userId'));
    }


    public function addContractorDocs()
    {
        $contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
        $userId = $this->getRequest()->getSession()->read('Auth.User.id');

        $formsNDoc = $this->FormsNDocs->newEntity();
        if ($this->request->is(['patch', 'post', 'put'])) {

            $requestDt = $this->request->getData('forms-n-docs');

            foreach($requestDt as $key => $val) {
                if($val['document']!='') {
                    $formsNDoc = $this->FormsNDocs->newEntity();
                    $formsNDoc = $this->FormsNDocs->patchEntity($formsNDoc, $val);
                    $formsNDoc->created_by = $userId;
                    $formsNDoc->client_id = 26;
                    if($this->FormsNDocs->save($formsNDoc)) {
                        $this->Flash->success(__('The forms n doc has been saved.'));
                    }
                    else {
                        $this->Flash->error(__('The forms n doc could not be saved. Please, try again.'));
                    }
                }
                else {
                    $this->Flash->error(__('The forms n doc could not be saved. Please, try again.'));
                }
            }
            $this->Flash->success(__('The forms n doc has been saved.'));
        }

        $totalCount = $this->FormsNDocs->find('all')->count();
        $this->paginate = [
            'conditions' => ['contractor_id'=>$contractor_id],
            'limit'  => $totalCount,
            'maxLimit'=> $totalCount
        ];
        $formsNDocs = $this->paginate($this->FormsNDocs);

        $clients = $this->FormsNDocs->Clients->find('list');
        $this->set(compact('formsNDoc', 'clients', 'formsNDocs','contractor_id','userId'));
    }
    /**
     * Edit method
     *
     * @param string|null $id Forms N Doc id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*public function edit($id = null)
    {
        $formsNDoc = $this->FormsNDocs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $formsNDoc = $this->FormsNDocs->patchEntity($formsNDoc, $this->request->getData());
            if ($this->FormsNDocs->save($formsNDoc)) {
                $this->Flash->success(__('The forms n doc has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The forms n doc could not be saved. Please, try again.'));
        }
        $clients = $this->FormsNDocs->Clients->find('list');
        $this->set(compact('formsNDoc', 'clients'));
    }*/

    /**
     * Delete method
     *
     * @param string|null $id Forms N Doc id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $formsNDoc = $this->FormsNDocs->get($id);
        if ($this->FormsNDocs->delete($formsNDoc)) {
            $this->Flash->success(__('The forms n doc has been deleted.'));
        } else {
            $this->Flash->error(__('The forms n doc could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'add']);
    }
}
