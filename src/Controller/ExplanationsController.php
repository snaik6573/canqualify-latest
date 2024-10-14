<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
/**
 * Explanations Controller
 *
 * @property \App\Model\Table\ExplanationsTable $Explanations
 *
 * @method \App\Model\Entity\Explanation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ExplanationsController extends AppController
{
    public function isAuthorized($user)
    {
	$contractorNav = false;	
	if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN || $user['role_id'] == CLIENT || $user['role_id'] == CONTRACTOR_ADMIN || $user['role_id'] == CR) {
	$contractorNav = true;
	}
	$this->set('contractorNav', $contractorNav);

	/*if($this->request->getParam('action')=='index') {
		if($user['role'] == 'Admin' || $user['role'] == 'Client' || $user['role'] == 'Client-Admin') {
			return true; 
		}
		return false;
	}*/
    //if (isset($user['role_id']) && $user['active'] == 1) {
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
    public function index($service_id=null)
    {
	$contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
	$allowForceChange = $this->User->isContractorAssigned();
	$totalCount = $this->Explanations->find('all')->count();	
	$this->paginate = [
	    'contain' => ['Contractors'],
	    'conditions' => ['contractor_id'=>$contractor_id, 'show_to_client'=>true],
	    'limit'  => $totalCount,
	    'maxLimit'=> $totalCount
	];
	$explanations = $this->paginate($this->Explanations);
	$this->set(compact('explanations', 'allowForceChange', 'service_id'));
    }

    /**
     * View method
     *
     * @param string|null $id Explanation id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $explanation = $this->Explanations->get($id, [
            'contain' => ['Contractors']
        ]);

        $this->set('explanation', $explanation);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($service_id=null)
    {
	$contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
	$userId = $this->getRequest()->getSession()->read('Auth.User.id');

	$explanation = $this->Explanations->newEntity();
	if ($this->request->is(['patch', 'post', 'put'])) {
		if(null !==$this->request->getData('id'))
		{
			$explanation = $this->Explanations->get($this->request->getData('id'), [
			    'contain' => []
			]);
			$explanation = $this->Explanations->patchEntity($explanation, $this->request->getData());			
			if ($this->Explanations->save($explanation)) {
		            $this->Flash->success(__('The explanation has been saved.'));
		            return $this->redirect(['action' => 'add']);
			}
		}

		$requestDt = $this->request->getData('explanations');
		foreach($requestDt as $key => $val) {
			if($val['document']!='') {
				$explanation = $this->Explanations->newEntity();
				$explanation = $this->Explanations->patchEntity($explanation, $val);
				$explanation->contractor_id = $contractor_id;
				$explanation->created_by = $userId;

				if($this->Explanations->save($explanation)) {
					//$this->Flash->success(__('The Explanations has been saved.'));
				}
				/*else {
					$this->Flash->error(__('The explanation could not be saved. Please, try again.'));
				}*/
			}
			/*else {
				$this->Flash->error(__('The explanation could not be saved. Please, try again.'));
			}*/
		}
		$this->Flash->success(__('The Explanations has been saved.'));
	}	
		
	$this->paginate = [
            'contain' => ['Contractors'],
	    'conditions' => ['contractor_id'=>$contractor_id]
        ];
        $explanations = $this->paginate($this->Explanations);

        $this->set(compact('explanation', 'explanations', 'service_id'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Explanation id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $userId = $this->getRequest()->getSession()->read('Auth.User.id');
        $explanation = $this->Explanations->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $explanation = $this->Explanations->patchEntity($explanation, $this->request->getData());
            $explanation->modified_by = $userId;

            if ($this->Explanations->save($explanation)) {
                $this->Flash->success(__('The explanation has been saved.'));

                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('The explanation could not be saved. Please, try again.'));
        }
        $contractors = $this->Explanations->Contractors->find('list', ['limit' => 200]);
        $this->set(compact('explanation', 'contractors'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Explanation id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $explanation = $this->Explanations->get($id);

        if ($this->Explanations->delete($explanation)) {
            $this->Flash->success(__('The explanation has been deleted.'));
        } else {
            $this->Flash->error(__('The explanation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'add']);
    }
}
