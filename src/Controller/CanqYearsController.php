<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;
/**
 * CanqYears Controller
 *
 * @property \App\Model\Table\CanqYearsTable $CanqYears
 *
 * @method \App\Model\Entity\CanqYear[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CanqYearsController extends AppController
{  
    public function isAuthorized($user)
    {
	// Admin can access every action
	if (isset($user['role_id']) && $user['active'] == 1) {
		if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN){		
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
    public function index()
    {
	$this->loadModel('Contractors');	
	$conn = ConnectionManager::get('default');

	$canqYear = $this->CanqYears->newEntity();
        if ($this->request->is(['patch', 'post', 'put'])) {
		// Archive Previous year	
		if($this->request->getData('status') == 'start') {
			$existrd = $this->CanqYears->find()->select(['id'])->where(['status' => 'start'])->first();

			$newStart = $existrd->id+1;
			$yearupdate = $this->CanqYears->get($newStart);

			if($yearupdate->status!='end') {
				// add archive
				$existupdate = $this->CanqYears->get($existrd->id);
				$existupdate->status = 'archive';
				$existupdate->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');
				$this->CanqYears->save($existupdate);

				// add start to next year 
				$yearupdate->status = 'start';
				$yearupdate->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');
				$this->CanqYears->save($yearupdate);
			}
			return $this->redirect(['action' => 'index']);	
		}

		// else Rollout new year

		// remove curent end
		//$existrd = $this->CanqYears->find()->select(['id'])->where(['status' => 'end'])->first();
		//$yearupdate = $this->CanqYears->get($existrd->id);

		$yearupdate = $this->CanqYears->get($this->request->getData('current_year'));
		$yearupdate->status = '';
		$yearupdate->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');
		$this->CanqYears->save($yearupdate);
		
		$canqYear->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
		$canqYear = $this->CanqYears->patchEntity($canqYear, $this->request->getData());
		if ($this->CanqYears->save($canqYear)) {
		    $this->Flash->success(__('The canq year has been saved.'));
			
		/*$contractorIds = $this->Contractors->find('list', ['keyField'=>'id', 'valueField'=>'id' ])->where(['payment_status'=>1])->enableHydration(false)->toArray();
		foreach($contractorIds as $contractor_id) {
			$client_ids = $this->User->getClients($contractor_id);
			foreach($client_ids as $client_id) {
				$overallIcon = $this->Contractors->OverallIcons->newEntity();
				$overallIcon->client_id = $client_id;
				$overallIcon->contractor_id = $contractor_id;
				$overallIcon->bench_type = 'OVERALL';
				$overallIcon->icon = 0;
				$overallIcon->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
				$this->Contractors->OverallIcons->save($overallIcon);					
			}	
		}*/
		
		$contractorUpdate = $conn->execute("update contractors set is_locked=false where payment_status=true");
		$contractorClients = $conn->execute("update contractor_clients set waiting_on= 1");
		return $this->redirect(['action' => 'index']);
		}
		$this->Flash->error(__('The canq year could not be saved. Please, try again.'));
        }
		
		$canqYears = $this->paginate($this->CanqYears);
        $this->set(compact('canqYear', 'canqYears'));
    }
}
