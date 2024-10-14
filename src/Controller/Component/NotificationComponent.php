<?php
namespace App\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Controller\Component;
use Cake\Controller\Controller;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\I18n\Number;

class NotificationComponent extends Component 
{
	public $components = ['User'];
	
    public function addNotification($user_ids=array(),$type=null,$client_id=null,$c_service=array(),$dt=null){
		$this->controller = $this->_registry->getController();
		$this->Notifications = TableRegistry::get('Notifications');
		$this->Clients = TableRegistry::get('Clients');
	 
		$ContractorUsers = $this->User->getUserbyRoles($user_ids,CONTRACTOR);		
		if(!empty($client_id)){
		$clientUser = $this->User->getUserbyRoles($client_id,CLIENT);		
		$client = $this->Clients->get($client_id);	
		}		 
		foreach($ContractorUsers as $user_id){											
				$Notification = $this->Notifications->newEntity();  
				$Notification->user_id = $user_id;
				$Notification->notification_type_id = $type;
				$Notification->created_by = $this->controller->getRequest()->getSession()->read('Auth.User.id');
					if($type == 1){					
					$Notification->from_user_id = $this->controller->getRequest()->getSession()->read('Auth.User.id');
					$Notification->title = "Renew your subscription";	
					$Notification->description = "Your Subscription is going to expire on : <b>".$dt."</b>";
					$Notification->url = "/Payments/paymentHistory";					
					}elseif($type == 2){
					$cl_service = implode(', ', $c_service);
					$Notification->from_user_id = $clientUser[$client_id];
					$Notification->title = "New Service Added";	
					$Notification->description = "<b>".$cl_service ."</b> Service Added by ". $client['company_name'];
					$Notification->url = "/Payments/paymentHistory";					
					}elseif($type == 3){
					$rm_service = implode(', ', $c_service);
					$Notification->from_user_id = $clientUser[$client_id];
					$Notification->title = "Service Removed";	
					$Notification->description ="<b>".$rm_service ."</b> Service Removed by ". $client['company_name'];					
					}elseif($type == 4){					
					$Notification->from_user_id = $clientUser[$client_id];
					$Notification->title = "Force Icon Change";	
					$Notification->description = '<b>Force Icon : </b>'. $client['company_name'];
					}elseif($type == 5){					
					$Notification->from_user_id = $clientUser[$client_id];
					$Notification->title = "Canqualify Review";	
					$Notification->description = '<b>Review For  : </b>'. $client['company_name'];
					}					
				$this->Notifications->save($Notification);
					
				}
	}
	public function insureQualNoti($contData=array(),$type=null,$expired){		
		$this->controller = $this->_registry->getController();
		$this->Notifications = TableRegistry::get('Notifications');
		$todayDate = date('Y/m/d');
		$result = false;
		foreach($contData as $data){ 
				if($expired == true){	
					$title = "Your ".$data['category']." Policy has been Expired";
					$description = "Your ".$data['category']." Policy has been expired on: ".$data['answer'];
				}else{
					$title = "Your ".$data['category']." Policy will Expire soon";	
					$description = "Your ".$data['category']." Policy will be expire on: ".$data['answer'];										
				}
				$existNotification = $this->Notifications
							->find()
							->select(['id','user_id','notification_type_id','title','description'])						
							->where(['user_id'=>$data['user_id'],'notification_type_id'=>$type,'title'=>$title,'description'=>$description])
							->toArray();
				
				if(empty($existNotification)){
					$Notification = $this->Notifications->newEntity();  
					$Notification->user_id = $data['user_id'];
					$Notification->notification_type_id = $type;
					$Notification->created_by = $this->controller->getRequest()->getSession()->read('Auth.User.id');
					$Notification->title = $title;
					$Notification->description = $description;	
					
					if($this->Notifications->save($Notification)){
						$result = true;
					}	
					
				}
			}
		return $result;				
	}
	public function addNotificationAdmin($user_ids=array(),$type=null,$contractor_id=null){
		$this->controller = $this->_registry->getController();
		$this->Notifications = TableRegistry::get('Notifications');
		$this->Contractors = TableRegistry::get('Contractors');	 
				
		if(!empty($contractor_id)){
		$ContractorUser = $this->User->getUserbyRoles($contractor_id,CONTRACTOR);		
		$Contractor = $this->Contractors->get($contractor_id);	
		}		 
		foreach($user_ids as $user_id){											
				$Notification = $this->Notifications->newEntity();  
				$Notification->user_id = $user_id;
				$Notification->notification_type_id = $type;
				$Notification->created_by = $this->controller->getRequest()->getSession()->read('Auth.User.id');
				if($type == 6){					
					$Notification->from_user_id = $ContractorUser[$contractor_id];
					$Notification->title = "Final Submit with Data Submitted by ".$Contractor['company_name'];	
					$Notification->description = $Contractor['company_name']." has Submmited the data" ;									
				}				
				$this->Notifications->save($Notification);					
				}
	}
	public function getNotification($user_id=null,$role=null){
		$this->Notifications = TableRegistry::get('Notifications');
		//$user = $this->User->getUserbyRoles($user_id,$role);
			$allMsg = $this->Notifications
			->find('all')
			//->select(['id','title','description','state','url'])
			->contain(['NotificationTypes'])		
			->where(['user_id'=>$user_id,'is_completed'=> false])
			->toArray();   
			
			return $allMsg; 
	}
	// public function updateNotification($user_id=array(),$type=null,$role=null){
	// 	$this->Notifications = TableRegistry::get('Notifications');
	// 	$user = $this->User->getUserbyRoles($user_id,$role);

	// 	$this->Notifications->query()->update()
	// 			->set(['is_completed'=> true,'state'=>true])
	// 			->where(['notification_type_id'=>$type,'user_id' => $user[$user_id]])
	// 			->execute();
	// }
	public function updateNotification($user_id=array(),$type=null,$role=null){
		$this->Notifications = TableRegistry::get('Notifications');
		$user = $this->User->getUserbyRoles($user_id,$role);
		$existNotification  = $this->Notifications->find('all')				
				->where(['user_id'=>$user[$user_id],'notification_type_id'=> $type])
				->toArray(); 
		if(!empty($existNotification))  {
		$this->Notifications->query()->update()
				->set(['is_completed'=> true,'state'=>true])
				->where(['notification_type_id'=>$type,'user_id' => $user[$user_id]])
				->execute();
		}
	}
}
