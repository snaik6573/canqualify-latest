<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * EmailCampaigns Controller
 *
 * @property \App\Model\Table\EmailCampaignsTable $EmailCampaigns
 *
 * @method \App\Model\Entity\EmailCampaign[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmailCampaignsController extends AppController
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
        $emailCampaigns = $this->paginate($this->EmailCampaigns);

        $this->set(compact('emailCampaigns'));
    }

    /**
     * View method
     *
     * @param string|null $id Email Campaign id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $emailCampaign = $this->EmailCampaigns->get($id, [
            'contain' => []
        ]);

        $this->set('emailCampaign', $emailCampaign);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $emailCampaign = $this->EmailCampaigns->newEntity();
        if ($this->request->is('post')) {
            $emailCampaign = $this->EmailCampaigns->patchEntity($emailCampaign, $this->request->getData());
            if ($this->EmailCampaigns->save($emailCampaign)) {
                $this->Flash->success(__('The email campaign has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The email campaign could not be saved. Please, try again.'));
        }
        $this->set(compact('emailCampaign'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Email Campaign id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->loadModel('Users');
        $this->loadModel('Contractors');
        $this->loadModel('CanqualifyMails');
        $this->loadModel('EmailTemplates');
        $this->loadModel('EmailSignatures');
        $this->loadModel('CustomerRepresentative');
        $this->loadModel('CampaignContactLists');
        $this->loadModel('EmailTemplates');
        $emailCampaign = $this->EmailCampaigns->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $to_mail = $this->request->getData('to_mail');
            $cc_mail = $this->request->getData('cc_mail');
            $bcc_mail = $this->request->getData('bcc_mail');
            $from_mail = $this->request->getData('from_mail');
            $subject = $this->request->getData('subject');
            $emailCampaign = $this->EmailCampaigns->patchEntity($emailCampaign, $this->request->getData());
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
            // pr($emailCampaign); die();
            if ($this->EmailCampaigns->save($emailCampaign)) {
                $this->Flash->success(__('The email campaign has been saved.'));

                return $this->redirect(['controller'=>'EmailWizards', 'action' => 'index']);
            }
            $this->Flash->error(__('The email campaign could not be saved. Please, try again.'));
        }

        $supplierList = $this->CampaignContactLists->find('list',['keyField'=>'id','valueField'=>'name'])->toArray();
        $canq_mails=  $this->CanqualifyMails->find('list',['keyField'=>'email','valueField'=>'email'])->toArray();
        $templateTypes = $this->EmailTemplates->find('list',['keyField'=>'id','valueField'=>'name'])->toArray();
        $emailSignatures = $this->EmailSignatures->find('list',['keyField'=>'template','valueField'=>'signature_name'])->toArray();
        $canq_cr = $this->CustomerRepresentative->find('list', ['keyField'=>'user.username', 'valueField'=>'user.username' ])->contain(['Users']);
   
        $this->set(compact('emailCampaign','supplierList','canq_mails','templateTypes','emailSignatures','canq_cr'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Email Campaign id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $emailCampaign = $this->EmailCampaigns->get($id);
        if ($this->EmailCampaigns->delete($emailCampaign)) {
            $this->Flash->success(__('The email campaign has been deleted.'));
        } else {
            $this->Flash->error(__('The email campaign could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function launchCampaign($id=null){  // Mail included into queue
        $this->loadModel('EmailQueues');
        $this->loadModel('Contractors');
        $this->loadModel('CampaignContactLists');
        $campaign = $this->EmailCampaigns->find()->where(['id'=>$id])->toArray();
        foreach ($campaign as  $c) {
           
        $suppliersList  = $this->CampaignContactLists->find()->where(['id IN'=>$c['to_mail']['to_mail_ids']])->toArray();
          foreach ($suppliersList as $key => $v) {
             $con = $this->Contractors->find()->select(['pri_contact_fn','pri_contact_ln','company_name'])->where(['contractors.id IN'=>$v['suppliers_ids']['supplier_ids']])->contain(['Users'=>['fields'=>['username']]])->enableHydration(false)->toArray();
            }  
           
        }
        foreach ($con as $key => $contractor) {

            $emailQueues = $this->EmailQueues->newEntity();
            foreach ($campaign as $value) {

                if($value['cc_mail']['cc_mails']){    
               
                  $emailQueues->cc_mail =  ['cc_mail' => array_values($value['cc_mail']['cc_mails'])];
              
                }
               $emailQueues->from_mail = ['from_mail' => array_values($value['from_mail']['from_mails'])];
               $emailQueues->pri_contact_fn =$contractor['pri_contact_fn'];
               $emailQueues->pri_contact_ln =$contractor['pri_contact_ln'];
               $emailQueues->supplier_name =$contractor['company_name'];
               $emailQueues->to_mail = $contractor['user']['username'];
               $emailQueues->campaign_name =  $value['campaign_name'];
               $emailQueues->subject =  $value['subject'];
               if($contractor['company_name'] != null ){
                    $patterns = array($contractor['pri_contact_fn'],$contractor['pri_contact_ln'],$contractor['company_name']);
               }else{
                    $patterns = array($contractor['pri_contact_fn'],$contractor['pri_contact_ln']);
               }
               $htmlbody = $this->replcaePlaceholder($value['template_content'],$patterns);
               $emailQueues->template_content=  $htmlbody;
               $emailQueues->email_signature_content=  $value['email_signature_content'];
               $emailQueues->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
               if($value['attachments']['mail_attach'] != null){   
               $emailQueues->mail_attachment =  ['mail_attachments' => array_values($value['attachments']['mail_attach'])];
               }
               // pr($emailQueues); die();
               if ($this->EmailQueues->save($emailQueues)) {
               }
            }
        }
      
         $this->Flash->success(__('The email Campaign has been Launch!.'));
         return $this->redirect(['controller'=>'EmailWizards','action' => 'index']);
    }
    public function startCampaign(){   // Send Emails
        $this->loadModel('EmailQueues');
      
        $mails = $this->EmailQueues->find()->where(['response_id IS '=>null])->limit(50)->toArray();

        foreach ($mails as  $mail) {
            $htmlbody = $mail['template_content'];
            $singature = $mail['email_signature_content'];
            $htmlbody .= $singature;
            // pr($htmlbody);
            $subject  =$mail['subject'];
            $to = $mail['to_mail'];
            $from = $mail['from_mail']['from_mail'];
            $cc = $mail['cc_mail']['cc_mail'];
            $id = $mail['id'];
            $mail_attach = $mail['mail_attachment']['mail_attachments'];
            /* Mail send  function */

            $this->Email->beginEmail($id,$to,$from,$cc,$subject,$htmlbody,$mail_attach);
        }
    }
     public function replcaePlaceholder($template= null,$replacements=null){
        $patterns = ['/{pri_contact_fname}/','/{pri_contact_lname}/','/{supplier_name}/'];
        $alter_content = preg_replace($patterns, $replacements, $template);
        return $alter_content;
    }
    public function saveAsNote($id=null){
        $this->loadModel('Notes');
        $this->loadModel('Contractors');
        $this->loadModel('CampaignContactLists');
        $htmlbody = array();

        $user_id = $this->getRequest()->getSession()->read('Auth.User.id');
        $role_id = $this->getRequest()->getSession()->read('Auth.User.role_id');

        $campaign = $this->EmailCampaigns->find()->where(['id'=>$id])->toArray();
        foreach ($campaign as $key => $c) {
            // pr($c['to_mail']['to_mail_ids']);
            $suppliersList  = $this->CampaignContactLists->find()->where(['id IN'=>$c['to_mail']['to_mail_ids']])->toArray();
            foreach ($suppliersList as $key => $v) {
            $con = $this->Contractors->find()->select(['id','pri_contact_fn','pri_contact_ln','company_name'])->where(['contractors.id IN'=>$v['suppliers_ids']['supplier_ids']])->contain(['Users'=>['fields'=>['username']]])->enableHydration(false)->toArray();
            $htmlbody = $c['template_content'];
            $htmlbody .= $c['email_signature_content'];
            $subject  =$c['subject'];
            $created_by  =$c['created_by'];
        }
        }
        foreach ($con as $key => $contractor) {
           
            $patterns = array($contractor['pri_contact_fn'],$contractor['pri_contact_ln']);
            $mailContent = $this->replcaePlaceholder($htmlbody,$patterns);
            $note = $this->Notes->newEntity();
            $note->subject = $subject;
            $note->notes = $mailContent;
            $note->contractor_id = $contractor['id'];
          
            if($this->User->isClient()){
            $note->show_to_client = 1;
            } 
            $note->created_by = $user_id;
            $note->role_id = $role_id;
            if ($this->Notes->save($note)) {
                
            }
           
           
        }
        $this->Flash->success(__('The note has been saved.'));
        return $this->redirect(['controller'=>'EmailWizards','action' => 'index']);
    }
    
}
