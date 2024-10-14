<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Mailer\MailerAwareTrait;       //  Built in function use for sending multiple email
use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Security;
use Cake\ORM\TableRegistry;
require_once(ROOT."/vendor/aws/aws-autoloader.php"); 
use Aws\S3\S3Client;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DevelopersController extends AppController
{
    use MailerAwareTrait;

    public function isAuthorized($user)
    {
	if($this->request->getParam('action')=='dashboard' || $this->request->getParam('action')=='contractor_list' ) {
		if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == DEVELOPER) {
			return true; 
		}
	}
	if (isset($user['role_id']) && $user['active'] == 1) {
		return true;
	}
	// Default deny
	return false;
    }

    public function dashboard() //admin dashboard
    {
	$this->loadModel('Contractors');
	$this->loadModel('Clients');
	$this->loadModel('OverallIcons');

	//unset contractor & client
	$this->getRequest()->getSession()->delete('Auth.User.contractor_id');
	$this->getRequest()->getSession()->delete('Auth.User.contractor_company_name');

	$this->getRequest()->getSession()->delete('Auth.User.client_id');
	$this->getRequest()->getSession()->delete('Auth.User.client_company_name');
	//$this->User->unsetUserSession();	

	$contractors = $this->Contractors
		->find()
		->select(['company_name', 'addressline_1', 'addressline_2', 'city', 'state_id', 'country_id', 'zip', 'latitude', 'longitude'])
		->contain(['States'=> ['fields'=>['name']]])
		->contain(['Countries'=> ['fields'=>['name']]])
		->all();

	$clients = $this->Clients
		->find()
		->select(['id', 'company_name'])
		->contain(['Sites'=> ['fields'=>['client_id', 'addressline_1', 'addressline_2', 'city', 'state_id', 'country_id', 'zip', 'latitude', 'longitude']]])
		->contain(['Sites.States'=> ['fields'=>['name']]])
		->contain(['Sites.Countries'=> ['fields'=>['name']]])
		->all();

        $matrix = $this->OverallIcons
		->find()
		->select('icon')
		->distinct('contractor_id')
		->order(['contractor_id', 'OverallIcons.created'=>'DESC'])
		->enableHydration(false)
		->toArray();

		$iconGray = 0;
		$iconGreen = 0;
		$iconRed = 0;
		$iconYellow = 0;
		foreach($matrix as $chart) {
			if ($chart['icon']==0) { $iconGray++;  }
			elseif ($chart['icon']==1) { $iconRed++;  }
			elseif ($chart['icon']==2) { $iconYellow++; }
			else { $iconGreen++; }
		}
		$pieChart = array($iconGreen, $iconYellow, $iconRed, $iconGray);

		$this->set(compact('contractors', 'clients', 'pieChart'));
    }    
    public function contractorList()
    {
       ini_set('memory_limit','-1');
        $this->loadModel('Contractors');
        $this->loadModel('Clients');
		$this->loadModel('Users');
        $contractor = $this->Contractors->newEntity();

        $users = $this->Users->newEntity();
        $contList = array();

        $allClients = $this->Clients->find('list', ['keyField'=>'id', 'valueField'=>'company_name' ])->toArray();
       
        $conn = ConnectionManager::get('default');
        $filterDate = '';
        $dt = date('Y-m-d', strtotime("+90 days"));

        $where = ' 1 = 1';

        if ($this->request->is(['patch', 'post', 'put'])) {
            if($this->request->getData('sub_date')!='')
            {
                $filterDate = $this->request->getData('sub_date');
                $dt = date('Y-m-d', strtotime("+".$filterDate." days"));

                $where .=" AND subscription_date <= '".$dt."'";
            }

            if(is_array($this->request->getData('user'))) {
                $this->viewBuilder()->setLayout('ajax');
          
                 $contractor = $this->Contractors->get($this->request->getData('id'), [
                    'contain'=>['Users']
                ]);
                $prevActive = $contractor->user->active;
                $contractor = $this->Contractors->patchEntity($contractor, $this->request->getData());              

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
            // pr($contList);die;
       $this->set(compact('contList', 'users','contractor', 'filterDate','allClients'));
    }
    public function generateKey($contractor_id)
    {
        $this->loadModel('Contractors');
        $this->viewBuilder()->setLayout('ajax');   

        $contractor = $this->Contractors->get($contractor_id, ['contain'=>['Users']]);      
        $user = $this->Users->find()->where(['id' => $contractor['user_id']])->first();      
        
        if(isset($user) && empty($user['login_secret_key']))
        {
            $hasher = new DefaultPasswordHasher();
            $secret_key = Security::hash(Security::randomBytes(32), 'sha256', false);   
            $user->login_secret_key = $secret_key; 
            $this->Users->save($user);  
            $contractor = $this->Contractors->get($contractor_id, ['contain'=>['Users']]);  
            
            $this->set(compact('contractor'));
        }       
        $this->set(compact('contractor'));
    }
	 /*public function renewSubContList()
	 {
		$this->loadModel('Contractors');
		$this->loadModel('Users');
		
		$dt = date('Y-m-d', strtotime("+15 days"));
		$contList = $this->Contractors
		->find('list', ['keyField'=>'id', 'valueField'=>'id'])		
		->where(['subscription_date' => $dt])->toArray();
		if(!empty($contList)){
		//$this->Notification->addNotification($contList,1,null,null,$dt);
		$this->Flash->success(__('The Notification has been sent to the contractor.'));
		}
		
		$dt1 = date('Y-m-d', strtotime("+8 days"));
		$contList1 = $this->Contractors
		->find('list', ['keyField'=>'id', 'valueField'=>'id'])			
		->where(['subscription_date' => $dt1])->toArray();
		if(!empty($contList1)){
		$this->Notification->addNotification($contList1,1,null,null,$dt1);
		$this->Flash->success(__('The Notification has been sent to the contractor.'));
		}
		
		$dt2 = date('Y-m-d', strtotime("+1 days"));
		$contList2 = $this->Contractors
		->find('list', ['keyField'=>'id', 'valueField'=>'id'])			
		->where(['subscription_date' => $dt2])->toArray();
		if(!empty($contList2)){
		$this->Notification->addNotification($contList2,1,null,null,$dt2);
		$this->Flash->success(__('The Notification has been sent to the contractor.'));
		}
		//pr($contList);
	 }*/
	 
	  public function contPolicyExp($date = null){
		   $this->loadModel('ContractorAnswers');
		   $this->loadModel('Contractors');
		  
		   $newDate = date('m/d/Y');
		   if(!empty($date))
		   {
			 $newDate  = date('m/d/Y', strtotime($newDate. "-".$date."days"));
		   }		  
		   $nextDate  = date('m/d/Y', strtotime($newDate. "+15 days"));		 
		   $previousDate  = date('m/d/Y', strtotime($newDate. "-1 days"));
		
		   $ques_id = Configure::read('q_id');
		   $exp_ques_id = array();
		   $i =0;
		   foreach ($ques_id as $key => $value) {
			$exp_ques_id[$i]  = ($value['p_expiration_qid']);
			$i++;
		   }		
			$cont_list = $this->ContractorAnswers->find()
       			->where(['ContractorAnswers.question_id IN'=>$exp_ques_id,'CAST(answer AS DATE)='=>$nextDate])
       			->contain(['Contractors','Questions.Categories'])
       			->toArray(); 
			
				$expsoon = array();
				$i=0;
				foreach($cont_list as $key=>$cont){					
					$expsoon[$i]['user_id'] = $cont['contractor']->user_id;
					$expsoon[$i]['answer'] = $cont->answer;
					$expsoon[$i]['category'] = $cont['question']['category']->name;
					$i++;
				}
				$result = $this->Notification->insureQualNoti($expsoon,7,false);
				
				$cont_list1 = $this->ContractorAnswers->find()
       			->where(['ContractorAnswers.question_id IN'=>$exp_ques_id,'CAST(answer AS DATE)='=>$previousDate])
       			->contain(['Contractors','Questions.Categories'])
       			->toArray(); 
				
				$expire = array();
				$i=0;
				foreach($cont_list1 as $key=>$cont1){					
					$expire[$i]['user_id'] = $cont1['contractor']->user_id;
					$expire[$i]['answer'] = $cont1->answer;
					$expire[$i]['category'] = $cont1['question']['category']->name;
					$i++;
				}				
				$result1 = $this->Notification->insureQualNoti($expire,7,true);
				
				if($result == true){
				$this->Flash->success(__('The Notification has been sent to the contractor.'));	
				}
				if($result1 == true){
				$this->Flash->success(__('The Notification has been sent to the contractor.'));	
				}	
			$this->set(compact('result','result1','newDate', 'nextDate','previousDate'));
		  }

		  /*generate training percentage records as per new code: CQ-75*/
            public function generateTrainingPercentages(){
                ini_set('memory_limit', '-1');
                ini_set('max_execution_time', '300');
                $this->loadModel('EmployeeSites');
                $this->loadModel('Trainings');
                $this->loadModel('TrainingPercentages');
                $conn = ConnectionManager::get('default');

                $allEmployees = $this->EmployeeSites->find('all')->select(['employee_id','site_id']);
                if(!empty($allEmployees)){
                    foreach ($allEmployees as $employee){
                        if(!empty($employee->site_id)){
                            $qry = "select trainings.id, trainings.site_ids from trainings where trainings.site_ids @> '{\"s_ids\": [\"".$employee->site_id."\"]}'";
                            $trainings = $conn->execute($qry)->fetchAll('assoc');
                            if(!empty($trainings)){
                                foreach ($trainings as $training){
                                    /*update training percentage*/
                                    if(!empty($training['id']) && !empty($employee->employee_id)){
                                        $exists = 0;
                                        $exists = $this->TrainingPercentages->find()->where(['training_id'=>$training['id'], 'employee_id' => $employee->employee_id])->count();
                                        if($exists == 0){
                                            $this->TrainingPercentage->saveTrainingPercentage($training['id'], $employee->employee_id);
                                        }
                                    }

                                }
                            }
                        }
                    }
                }
                echo "<br/>loop finished";
            die;
            }
		
}
