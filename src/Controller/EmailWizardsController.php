<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;

/**
 * EmailWizards Controller
 *
 *
 * @method \App\Model\Entity\EmailWizard[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmailWizardsController extends AppController
{
   public function isAuthorized($user)
    {
      $contractorNav = false;
      if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN || $user['role_id'] == CLIENT || $user['role_id'] == CONTRACTOR_ADMIN || $user['role_id'] == CR) {
        $contractorNav = true;
      }
      $this->set('contractorNav', $contractorNav);
      $clientCenterNav = false;
        if(isset($user['client_id']) && ($user['role_id'] == SUPER_ADMIN  || $user['role_id'] == ADMIN )){
            $clientCenterNav = true;
           $this->set('clientCenterNav', $clientCenterNav);
        }
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
    public function index()
    {
      
        $this->loadModel('EmailCampaigns');
        $this->loadModel('CampaignContactLists');
        $campaignContactList = array();
        $loggedUser = $this->getRequest()->getSession()->read('Auth.User.id');
        $activeUser = $this->getRequest()->getSession()->read('Auth.User');
        if($this->User->isClient()){
            if($activeUser['role_id']== CLIENT || $activeUser['role_id'] == CLIENT_ADMIN) {
                $EmailCampaigns = $this->EmailCampaigns->find()->where(['created_by'=>$loggedUser]);
            }
            if($activeUser['role_id'] == CLIENT_VIEW || $activeUser['role_id'] == CLIENT_BASIC) {
                 $EmailCampaigns = $this->EmailCampaigns->find()->where(['created_by'=>$loggedUser]);
            }
        }elseif($this->User->isCR()){
                $EmailCampaigns = $this->EmailCampaigns->find()->where(['created_by'=>$loggedUser]);
        }
        else{
            $EmailCampaigns = $this->EmailCampaigns->find();
        }
        $emailCampaigns = $this->paginate($EmailCampaigns);
        foreach ($emailCampaigns as  $c) {
        $campaignContactList = $this->CampaignContactLists->find('list',['keyField'=>'id','valueField'=>'name'])->toArray();    
        }
   
        $this->set(compact('emailCampaigns','campaignContactList'));
        
    }

    /**
     * View method
     *
     * @param string|null $id Email Wizard id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
  

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    // public function add()
    // {
    //     $emailWizard = $this->EmailWizards->newEntity();
    //     if ($this->request->is('post')) {
    //         $emailWizard = $this->EmailWizards->patchEntity($emailWizard, $this->request->getData());
    //         if ($this->EmailWizards->save($emailWizard)) {
    //             $this->Flash->success(__('The email wizard has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The email wizard could not be saved. Please, try again.'));
    //     }
    //     $this->set(compact('emailWizard'));
    // }

    /**
     * Edit method
     *
     * @param string|null $id Email Wizard id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */


    /**
     * Delete method
     *
     * @param string|null $id Email Wizard id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    // public function delete($id = null)
    // {
    //     $this->request->allowMethod(['post', 'delete']);
    //     $emailWizard = $this->EmailWizards->get($id);
    //     if ($this->EmailWizards->delete($emailWizard)) {
    //         $this->Flash->success(__('The email wizard has been deleted.'));
    //     } else {
    //         $this->Flash->error(__('The email wizard could not be deleted. Please, try again.'));
    //     }

    //     return $this->redirect(['action' => 'index']);
    // }
     public function getContractorInfo($contractor_id=null){
    $this->loadModel('Contractors');
  
    if($contractor_id != "undefined"){
        $contractor = $this->Contractors->find()->select(['pri_contact_fn','pri_contact_ln','company_name'])->where(['id' =>$contractor_id])->first();
    
      echo json_encode($contractor); die();

    }
    echo json_encode('de-select'); die();
    }
    public function searchSuppliers($waiting_on=0, $site_index=null, $icon_index=null){
        ini_set('memory_limit','-1'); 
        $this->loadModel('Leads');  
        $this->loadModel('Clients');
        $this->loadModel('NaiscCodes');
        $this->loadModel('Contractors');
        $this->loadModel('Categories');
        $this->loadModel("ContractorAnswers");
        $this->loadModel('ContractorServices');


        $loggedClient  = $this->getRequest()->getSession()->read('Auth.User.client_id');

        /* Init Variables */
        $andConditions = array();
        $orConditions = array();
        $expsoonDate = array();
        $AlreadyExpriredDate = array();
        $ExpriedDate = array();
        $where2 = array();
        $contList = array();
        $whereNaicscode= array();
        $where = array();
       
        $todaydate = date('m/d/Y');  // Today's date 
        $nextdate  = date('m/d/Y', strtotime("+15 days"));  // upcomming 15 day's
        $nextDate = (string) $nextdate;
        


   
 
    if ($this->request->is(['patch', 'post', 'put'])) { 
         /* Policy Expired','Policy Expriration Soon','Membership Expired','Membership expiration soon','Insurance Ceritficate Expired filter */
        $policy_type = $this->request->getData('policy_type');
        if(!empty($policy_type)){
           
        $start_date = $this->request->getData('start_date');
        $end_date = $this->request->getData('end_date');
        
        if($policy_type == 14){                     //  General Liability
            $exp_ques_id = 43;
        }elseif ($policy_type == 15) {              //  Automobile Liability
           $exp_ques_id = 55;
        }elseif ($policy_type == 16) {              //  Excess/Umbrella Liability
            $exp_ques_id = 65;
        }elseif ($policy_type == 17) {              //  Workers Compensation
            $exp_ques_id = 456;
        }else{                                      //  All Policies 
            $exp_ques_id = [43,55,65,456];
        }

        if($start_date ==null && $end_date){
        $where = ['CAST(answer AS DATE) <='=>$end_date];
        }

        if($start_date && $end_date){
        $where = [function($exp) use($start_date,$end_date) {
                return $exp->between('CAST(answer AS DATE)', $start_date, $end_date);
        }];
        }

        $ExpriedDate = $this->ContractorAnswers->find()
                //->where(['ContractorAnswers.question_id IN'=>$exp_ques_id,'CAST(answer AS DATE) <='=>$nextDate])
                ->where(['ContractorAnswers.question_id IN'=>$exp_ques_id,$where])
                ->contain(['Contractors','Questions.Categories'])
                ->order(['CAST(ContractorAnswers.answer AS DATE)'=>'ASC'])
                ->toArray();
      
        if($this->User->isClient()){
           $client_contractors = $this->User->getContractors($loggedClient); 
             $ywhere = ['Contractors.id IN'=> $client_contractors];
            $ExpriedDate = $this->ContractorAnswers->find()
                //->where(['ContractorAnswers.question_id IN'=>$exp_ques_id,'CAST(answer AS DATE) <='=>$nextDate])
                ->where(['ContractorAnswers.question_id IN'=>$exp_ques_id,$where,$ywhere])
                ->contain(['Questions.Categories'])
                ->contain(['Contractors'])
                ->order(['CAST(ContractorAnswers.answer AS DATE)'=>'ASC'])
                ->toArray();
        }
  
       
        $qWhere = [function($exp) use($todaydate,$nextdate) {
                return $exp->between('CAST(answer AS DATE)', $todaydate, $nextdate);
        }];
        

        $ExpSoonDate = $this->ContractorAnswers->find()
                     // ->where(['ContractorAnswers.question_id IN'=>$exp_ques_id,'CAST(answer AS DATE) <='=>$nextDate])
                    ->where(['ContractorAnswers.question_id IN'=>$exp_ques_id,$qWhere])
                    ->contain(['Contractors','Questions.Categories'])
                    ->toArray();
        $XpiredDate = $this->ContractorAnswers->find()
                     ->where(['ContractorAnswers.question_id IN'=>$exp_ques_id,'CAST(answer AS DATE) <='=>$todaydate])
                    ->contain(['Contractors','Questions.Categories'])
                    ->toArray();
        
            foreach ($XpiredDate as $key => $value) {
                $AlreadyExpriredDate[] = $value->answer;
            }
            
         
            foreach ($ExpSoonDate as $key => $value) {
                $expsoonDate[] = $value->answer;
            }
        }else{



        $contactnm = $this->request->getData('contact_name');
        $companynm = $this->request->getData('company_name');
        $email = $this->request->getData('username');
        $naics_codes = $this->request->getData('naics_codes');
        $start_date = $this->request->getData('start_date');
        $end_date = $this->request->getData('end_date');

        
        $policy_type = $this->request->getData('policy_type');
        $start_date = $this->request->getData('start_date');
        $end_date = $this->request->getData('end_date');

      

        $naics_code ='';
        $joinIndustry ='';
        $selectIndustry='';
        $andConditions = array();
            if($this->User->isClient()){
                if($this->User->isClientUser()){
                    $userSites = $this->User->getClientUserSites();
                }
                if(!empty($userSites)){
                    $myContractors = $this->User->getContractors($loggedClient, array(), true, $userSites);
                }else{
                    $myContractors = $this->User->getContractors($loggedClient);
                }
            }
            if(!empty($myContractors)){
                $myContractorsList = "'".implode ("', '", $myContractors)."'";
                //$andConditions[] = ['Contractors.id IN' => $myContractors];
                $andConditions[]= "Contractors.id IN(".$myContractorsList.")";
            }

        $orConditions = array();
        $exp_ques_id = array();
        $where = array();
        if($contactnm!='') { 
            $contactnm = explode(' ',$contactnm);
            $count = count($contactnm);
            //pr($count);die;   
            if($count==1){
                 $orConditions = ["LOWER(contractors.pri_contact_fn) LIKE LOWER('%".$contactnm[0]."%')","LOWER(contractors.pri_contact_ln) LIKE LOWER('%".$contactnm[0]."%')"];             
            }else{
            $andConditions[]="LOWER(contractors.pri_contact_fn) LIKE LOWER('%".$contactnm[0]."%')"; 
            if(isset($contactnm[1])) {
            $andConditions[]="LOWER(contractors.pri_contact_ln) LIKE LOWER('%".$contactnm[1]."%')";
            }}
        }
        if($companynm!='') { $andConditions[]="LOWER(contractors.company_name) LIKE LOWER ('%".$companynm."%')"; }
        if($email!='') { $andConditions[]="users.username LIKE '%".$email."%'";  }


        if(!empty($naics_codes)) { 
            $naics_codes = "'".implode ("', '", $naics_codes)."'";
            $selectIndustry = ', contractor_answers.*';
            $joinIndustry = 'LEFT JOIN contractor_answers ON contractor_answers.contractor_id=contractors.id';
            $andConditions[]= "contractor_answers.answer IN(".$naics_codes.")";
            $andConditions[] = "contractor_answers.question_id = ".Naisc_Question;
        }
        
   
        $andConditions[] = "users.active=true";
      
      
        $andConditions = implode(' AND ',$andConditions);
        $orConditions = implode(' OR ',$orConditions);
        if(!empty($orConditions)){
            $orConditions = 'AND ('.$orConditions.')';
        }
     
       
        $conn = ConnectionManager::get('default');
         
        $contList = $conn->execute("SELECT contractors.*, states.name as state_name, users.username, users.active as active ".$selectIndustry." FROM contractors 
            LEFT JOIN users ON users.id = (contractors.user_id) 
            LEFT JOIN states ON states.id = (contractors.state_id) 
            
            ".$joinIndustry."
            WHERE ".$andConditions.' '.$orConditions)->fetchAll('assoc'); 
   
     }
    } 
      
     $naisccodes = $this->NaiscCodes->find('list', ['keyField'=>'naisc_code', 'valueField'=> function ($e) { return $e->naisc_code.' - '.$e->title; }])->limit(4000);
     $policyTypes = $this->Categories->find('list',['keyField'=>'id','valueField'=>'name'])
                                     ->where(['category_id'=>98])
                                     ->order(['id'=>'asc'])
                                     ->toArray();
    $this->set(compact('contList','naisccodes','todaydate','policyTypes','ExpriedDate','expsoonDate','AlreadyExpriredDate'));

   }


   public function emailTemplateList(){
        $this->loadModel('EmailTemplates');
        $loggedUser = $this->getRequest()->getSession()->read('Auth.User.id');
        $activeUser = $this->getRequest()->getSession()->read('Auth.User');
         if($this->User->isClient()){
            if($activeUser['role_id']== CLIENT || $activeUser['role_id'] == CLIENT_ADMIN) {
                $emailTemplates = $this->EmailTemplates->find()->where(['created_by'=>$loggedUser]);
            }
            if($activeUser['role_id'] == CLIENT_VIEW || $activeUser['role_id'] == CLIENT_BASIC) {
                $emailTemplates = $this->EmailTemplates->find()->where(['created_by'=>$loggedUser]);
            }
        }elseif($this->User->isCR()){
            $emailTemplates = $this->EmailTemplates->find()->where(['created_by'=>$loggedUser]);
        }
        else{
            $emailTemplates = $this->EmailTemplates->find();
        }
        $emailTemplates = $this->paginate($emailTemplates);
        $this->set(compact('emailTemplates'));
   }


    public function createTemplate(){
      $this->loadModel('EmailTemplates');
      $emailTemplates = $this->EmailTemplates->newEntity();
        if ($this->request->is('post')) {
          
            $emailTemplates= $this->EmailTemplates->patchEntity($emailTemplates, $this->request->getData());
            $emailTemplates->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
            if ($this->EmailTemplates->save($emailTemplates)) {
                $this->Flash->success(__('The email template has been saved.'));

                return $this->redirect(['action' => 'emailTemplateList']);
            }
            $this->Flash->error(__('The email template could not be saved. Please, try again.'));
        }
        $this->set(compact('emailTemplates'));
    
   }
    public function editTemplate($id = null)
    {
        $this->loadModel('EmailTemplates');
        $emailTemplates = $this->EmailTemplates->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
                    // pr($this->request->getData()); die();
            $emailTemplates = $this->EmailTemplates->patchEntity($emailTemplates, $this->request->getData());
            $emailTemplates->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');
            if ($this->EmailTemplates->save($emailTemplates)) {
                $this->Flash->success(__('The email template has been saved.'));

                return $this->redirect(['action' => 'emailTemplateList']);
            }
            $this->Flash->error(__('The email template could not be saved. Please, try again.'));
        }
        
        $this->set(compact('emailTemplates'));
    }
    public function viewTemplate($id = null)
    {
        $this->loadModel('EmailTemplates');
        $emailTemplates = $this->EmailTemplates->get($id, [
            'contain' => []
        ]);

        $this->set('emailTemplates', $emailTemplates);
    }
     public function emailCampaign(){
    $this->loadModel('Users');
    $this->loadModel('Clients');
    $this->loadModel('Contractors');
    $this->loadModel('CanqualifyMails');
    $this->loadModel('EmailTemplates');
    $this->loadModel('EmailSignatures');
    $this->loadModel('EmailCampaigns');
    $this->loadModel('CustomerRepresentative');
    $this->loadModel('CampaignContactLists');

    
    $files = array();
    $loggedClient = $this->getRequest()->getSession()->read('Auth.User.client_id');
    if ($this->request->is(['patch', 'post', 'put'])) {
 
          $campaign_name = $this->request->getData('campaign_name');
          $to_mail = $this->request->getData('to_mail');
          $cc_mail = $this->request->getData('cc_mail');
          $bcc_mail = $this->request->getData('bcc_mail');
          $from_mail = $this->request->getData('from_mail');
          $subject = $this->request->getData('subject');

          if(isset($campaign_name) && isset($to_mail) && isset($from_mail) && isset($subject)){
                    $emailCampaign = $this->EmailCampaigns->newEntity();
                    $emailCampaign = $this->EmailCampaigns->patchEntity($emailCampaign,$this->request->getData());
                    $emailCampaign->to_mail = ['to_mail_ids' => array_values($to_mail)];
                    $emailCampaign->from_mail = ['from_mails' => array_values($from_mail)];
                    if($cc_mail != null){
                    $emailCampaign->cc_mail = ['cc_mails' => array_values($cc_mail)];
                    }
                    if($bcc_mail !=null){
                         $emailCampaign->bcc_mail = ['bcc_mails' => array_values($bcc_mail)];
                    }                
                    $emailCampaign->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
                    $attachments = $this->request->getData('mail-attachment');
                    if($attachments !=null){
                        foreach ($attachments as  $file) {
                            $files[] = $file['document'];
                        }
                      $emailCampaign->attachments = ['mail_attach' => array_values($files)];
                    }

                    if ($this->EmailCampaigns->save($emailCampaign)) {
                        // $this->Flash->success(__('The email Campaign has been saved.'));
                        // return $this->redirect(['action' => 'searchMembership']);
                        // return $this->redirect(['action' => 'index']);
                    }
                 
            
             $this->Flash->success(__('The email Campaign has been saved.'));
             return $this->redirect(['action' => 'index']);
           
       }
            // $this->Flash->error(__('The email campaign could not be launched. Please, try again.'));
    }
    $supplierList = $this->CampaignContactLists->find('list',['keyField'=>'id','valueField'=>'name'])->toArray();
    if($this->User->isClient()){
        $canq_mails=  $this->CanqualifyMails->find('list',['keyField'=>'email','valueField'=>'email'])->where(['id'=>3])->toArray();
    }else{
        $canq_mails=  $this->CanqualifyMails->find('list',['keyField'=>'email','valueField'=>'email'])->toArray();
    }
   
    $templateTypes = $this->EmailTemplates->find('list',['keyField'=>'id','valueField'=>'name'])->toArray();
    $emailSignatures = $this->EmailSignatures->find('list',['keyField'=>'template','valueField'=>'signature_name'])->toArray();
    if($this->User->isClient()){
        // $loggedClient
        $client = $this->Clients->find()->select('client_service_rep')->where(['id'=>$loggedClient])->first();
        $canq_cr = $this->CustomerRepresentative->find('list', ['keyField'=>'user.username', 'valueField'=>'user.username' ])->contain(['Users'])->where(['Users.id'=>$client['client_service_rep']]);
    }else{
        $canq_cr = $this->CustomerRepresentative->find('list', ['keyField'=>'user.username', 'valueField'=>'user.username' ])->contain(['Users']);
    }  
    // pr($canq_cr); die;
    $this->set(compact('supplierList','canq_mails','templateTypes','emailSignatures','canq_cr'));
   }
   public function testEmail(){
    $this->Email->testTemplate();
    // $this->Email->startEmail();
   }
   public function getTemplateData(){
    $this->loadModel('EmailTemplates');
    $tId = $this->request->getData(['id']);
    $temp_data = $this->EmailTemplates->find()->select('quill_delta')->where(['id'=>$tId])->enableHydration(false)->first();
    echo $temp_data['quill_delta'];
    die();
   }
   public function deleteAttachment(){
    $this->loadModel('EmailCampaigns');
    $id =$this->request->getData('id');
    $file =$this->request->getData('name');
    $emailCm = $this->EmailCampaigns->find()->where(['id'=>$id])->toArray();
    $val = array();
    foreach ($emailCm as $key => $cm) {
            pr($cm['attachments']['mail_attach']);
            $to_remove = array($file);
            $result['mail_attach'] = array_diff($cm['attachments']['mail_attach'], $to_remove);

    }
    $this->EmailCampaigns->query()
            ->update()
            ->set(['attachments'=>$result])
            ->where(['id'=>$id])
            ->execute();
   }
 
}
