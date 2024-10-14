<?php
namespace App\View\Helper;
use Cake\View\Helper;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
/**
 * Notifications helper
 */
class NotificationHelper extends Helper
{
	public $helpers = ['User'];
    public function getAllNotificationCount($user_id = null,$role =null){
		//$user_id = $this->User->getUserbyRole($activeUser,$role);
   		$this->Notifications = TableRegistry::get('Notifications');
		$allCount = $this->Notifications
		->find('all')
		->contain(['NotificationTypes'])	
		->where(['user_id'=>$user_id,'is_completed'=> false])
		->count();       
        return $allCount; 
    }
	public function getNotification($user_id = null,$role =null){
		//$user_id = $this->User->getUserbyRole($activeUser,$role);
   		$this->Notifications = TableRegistry::get('Notifications');
		$allMsg = $this->Notifications
		->find('all')
		//->select(['id','title','description','url','state'])
		->contain(['NotificationTypes'])		
		->where(['user_id'=>$user_id,'is_completed'=> false])
		->order(['Notifications.created' =>'DESC'])
		->toArray();          
        return $allMsg; 
    }
	public function getUnreadCount($user_id = null,$role =null){   
		//$user_id = $this->User->getUserbyRole($activeUser,$role);
		$this->Notifications = TableRegistry::get('Notifications');
		$unreadCount = $this->Notifications
		->find('all')		
		->where(['state'=>false,'user_id'=>$user_id,'is_completed'=> false])
		->count();       
        return $unreadCount;  
    }
	/*public function getUnread($activeUser = null,$role =null){
		$user_id = $this->User->getUserbyRole($activeUser,$role);
		$this->Notifications = TableRegistry::get('Notifications');
		$unreadMsg = $this->Notifications
		->find('all')
		->select(['id','title','description','url'])
		->where(['state'=>false,'user_id'=>$user_id])
		->toArray();       
        return $unreadMsg;  
    }*/
	/*public function getReadCount($activeUser = null,$role =null){  
		$user_id = $this->User->getUserbyRole($activeUser,$role);
		$this->Notifications = TableRegistry::get('Notifications');
		$unreadCount = $this->Notifications
		->find('all')		
		->where(['state'=>true,'user_id'=>$user_id])
		->count();       
        return $readCount;
  
    }
	public function getRead($activeUser = null,$role =null){   
		$user_id = $this->User->getUserbyRole($activeUser,$role);
		$this->Notifications = TableRegistry::get('Notifications');
		$unreadCount = $this->Notifications
		->find('all')		
		->select(['id','title','description'])
		->where(['state'=>true,'user_id'=>$user_id])
		->toArray();        
        return $readMsg;
  
    }
	public function markAsRead($user_id = null){      	
		$this->Notifications = TableRegistry::get('Notifications');
		$markNotification = $this->Notifications
		->find('all')		
		->where(['state'=>true])
		->count();       
        return $readCount;
  
    }*/
    /* Dashboard Policy Expired count  */
    public function countPolicyExp($client_id=null){
       $this->ContractorClients = TableRegistry::get('ContractorClients');
       $this->ContractorAnswers = TableRegistry::get('ContractorAnswers');
       $contractors = $this->ContractorClients->find('list',['keyField'=>'contractor_id','valueField'=>'contractor_id'])->where(['client_id'=>$client_id])->toArray();
       $todaydate = date('m/d/Y');
       $nextdate  = date('m/d/Y', strtotime("+15 days"));
       $nextDate = (string) $nextdate;
       // pj(strtotime($nextdate));
       $ques_id = Configure::read('q_id');
       $exp_ques_id = array();
       $i =0;
  	   foreach ($ques_id as $key => $value) {
  	    $exp_ques_id[$i]  = ($value['p_expiration_qid']);
  	    $i++;
  	   }
  	    $where = [function($exp) use($todaydate,$nextdate) {
            return $exp->between('CAST(answer AS DATE)', $todaydate, $nextdate);
        }];
    	$ExpriedDate = $this->ContractorAnswers->find()
       				->where(['ContractorAnswers.question_id IN'=>$exp_ques_id,'answer NOT LIKE'=>"",'CAST(answer AS DATE) <='=>$nextDate,'ContractorAnswers.contractor_id IN'=>$contractors])
       				->contain(['Contractors','Questions.Categories'])
       				->count();

       	$ExpSoonDate = $this->ContractorAnswers->find()
       				->where(['ContractorAnswers.question_id IN'=>$exp_ques_id,$where,'ContractorAnswers.contractor_id IN'=>$contractors,'answer NOT LIKE'=>""])
       				->contain(['Contractors','Questions.Categories'])
       				->count();

       	$count = $ExpriedDate - $ExpSoonDate;
       	return $count;
    }

}
