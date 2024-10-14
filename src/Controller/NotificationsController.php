<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Mailer\MailerAwareTrait;      //  Built in function use for sending multiple email


/**
 * Notifications Controller
 *
 * @property \App\Model\Table\NotificationsTable $Notifications
 *
 * @method \App\Model\Entity\Notification[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class NotificationsController extends AppController
{
    use MailerAwareTrait;
	public function isAuthorized($user)
    {	
	// Admin can access every action
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
    /*public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'NotificationTypes']
        ];
        $notifications = $this->paginate($this->Notifications);
	
        $this->set(compact('notifications'));
    }

    /**
     * View method
     *
     * @param string|null $id Notification id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {		
        $notification = $this->Notifications->get($id, [
            'contain' => ['Users', 'NotificationTypes']
        ]);

        $this->set('notification', $notification);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    /*public function add()
    {
        $notification = $this->Notifications->newEntity();
        if ($this->request->is('post')) {
            $notification = $this->Notifications->patchEntity($notification, $this->request->getData());
            if ($this->Notifications->save($notification)) {
                $this->Flash->success(__('The notification has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The notification could not be saved. Please, try again.'));
        }
        $users = $this->Notifications->Users->find('list', ['limit' => 200]);
        $notificationTypes = $this->Notifications->NotificationTypes->find('list', ['limit' => 200]);
        $this->set(compact('notification', 'users', 'notificationTypes'));
    }*/

    /**
     * Edit method
     *
     * @param string|null $id Notification id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
   /* public function edit($id = null)
    {
        $notification = $this->Notifications->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $notification = $this->Notifications->patchEntity($notification, $this->request->getData());
            if ($this->Notifications->save($notification)) {
                $this->Flash->success(__('The notification has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The notification could not be saved. Please, try again.'));
        }
        $users = $this->Notifications->Users->find('list', ['limit' => 200]);
        $notificationTypes = $this->Notifications->NotificationTypes->find('list', ['limit' => 200]);
        $this->set(compact('notification', 'users', 'notificationTypes'));
    }*/

    /**
     * Delete method
     *
     * @param string|null $id Notification id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
   /* public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $notification = $this->Notifications->get($id);
        if ($this->Notifications->delete($notification)) {
            $this->Flash->success(__('The notification has been deleted.'));
        } else {
            $this->Flash->error(__('The notification could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }*/
	public function getAllNotifymsg($user_id = null){
    if($user_id !== 'undefined'){
    $list = $this->Notification->getNotification($user_id,CONTRACTOR); 
     return $this->response
          ->withType('application/json')
          ->withStringBody(json_encode($list          
        ));
    }
    }
	 public function isRead($id=null){        
      $notify = $this->Notifications->newEntity();  
      $notification = $this->Notifications->get($id, [
            'contain' => []
        ]);
      $notification->state = true;
      $notification->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
      $this->Notifications->save($notification);

    }	
	public function getAllNotification($user_id = null,$role=null){
	$this->paginate = [
            'contain' => ['Users', 'NotificationTypes']
        ];       
	$notifications = $this->Notification->getNotification($user_id,$role);
	//pr($notifications);
        $this->set(compact('notifications'));
	}

	/*cron for account expiring soon*/

    public function accountExpiring(){

        $this->loadModel('Contractors');

        $today = date('Y-m-d');
        $expiring = $this->Contractors
            ->find('all')
            ->select(['pri_contact_fn', 'company_name', 'subscription_date'])
            ->contain(['Users'=>['fields'=>['username']]])
            ->where(['OR' => [['subscription_date' => strtotime('+1 day',strtotime($today))], ['subscription_date' => strtotime('+7 days',strtotime($today))], ['subscription_date' => strtotime('+15 days',strtotime($today))], ['subscription_date' => strtotime('+30 days',strtotime($today))], ['subscription_date' => strtotime('+60 days',strtotime($today))]]])
            ->toArray();

        if(!empty($expiring)){
            foreach($expiring as $contractor){

                $to_emails = array();
                if(isset($contractor->user->username)){
                    array_push($to_emails, $contractor->user->username);
                }
                $contractor_company_name = (isset($contractor->company_name)) ? $contractor->company_name : '';
                $pri_contact_fn = (isset($contractor->pri_contact_fn)) ? $contractor->pri_contact_fn : '';
                $days = '';

                if(isset($contractor->subscription_date)){
                    if(strtotime('+1 day',strtotime($today)) == strtotime($contractor->subscription_date)){
                        $days = '1 day';
                    }elseif(strtotime('+7 days',strtotime($today)) == strtotime($contractor->subscription_date)){
                        $days = '7 days';
                    }elseif (strtotime('+15 days',strtotime($today)) == strtotime($contractor->subscription_date)){
                        $days = '15 days';
                    }elseif (strtotime('+30 days',strtotime($today)) == strtotime($contractor->subscription_date)){
                        $days = '30 days';
                    }elseif (strtotime('+60 days',strtotime($today)) == strtotime($contractor->subscription_date)){
                        $days = '60 days';
                    }
                }

                $args = array();
                $args['to_emails'] = $to_emails;
                $args['contractor_company_name'] = $contractor_company_name;
                $args['contractor_fname'] =  $pri_contact_fn;
                $args['days'] =  $days;
                //debug($args);
                $this->getMailer('User')->send('accountExpiring', [$args]);
            }
        }

        die;



    }

    public function accountExpiringToday(){
            $this->loadModel('Contractors');
            $today = date('Y-m-d');
            $expiringToday = $this->Contractors
                                ->find('all')
                                ->select(['pri_contact_fn', 'company_name'])
                                ->contain(['Users'=>['fields'=>['username']]])
                                ->where(['subscription_date' => strtotime($today)])
                                ->toArray();

        //debug($expiringToday);die;
        if(!empty($expiringToday)){
                    foreach($expiringToday as $contractor){

                        $to_emails = array();
                        if(isset($contractor->user->username)){
                            array_push($to_emails, $contractor->user->username);
                        }
                        $contractor_company_name = (isset($contractor->company_name)) ? $contractor->company_name : '';
                        $pri_contact_fn = (isset($contractor->pri_contact_fn)) ? $contractor->pri_contact_fn : '';

                        $args = array();
                        $args['to_emails'] = $to_emails;
                        $args['contractor_company_name'] = $contractor_company_name;
                        $args['contractor_fname'] =  $pri_contact_fn;
                        $this->getMailer('User')->send('accountExpiringToday', [$args]);
                    }
        }
        die;
    }

}
