<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * EmailSignatures Controller
 *
 * @property \App\Model\Table\EmailSignaturesTable $EmailSignatures
 *
 * @method \App\Model\Entity\EmailSignature[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmailSignaturesController extends AppController
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
        $loggedUser = $this->getRequest()->getSession()->read('Auth.User.id');
        $activeUser = $this->getRequest()->getSession()->read('Auth.User');
        if($this->User->isClient()){
            if($activeUser['role_id']== CLIENT || $activeUser['role_id'] == CLIENT_ADMIN) {
            $EmailSignatures = $this->EmailSignatures->find()->where(['created_by'=>$loggedUser]);
            }
            if($activeUser['role_id'] == CLIENT_VIEW || $activeUser['role_id'] == CLIENT_BASIC) {
             $EmailSignatures = $this->EmailSignatures->find()->where(['created_by'=>$loggedUser]);
            }
        }elseif($this->User->isCR()){
             $EmailSignatures = $this->EmailSignatures->find()->where(['created_by'=>$loggedUser]);
        }else{
             $EmailSignatures = $this->EmailSignatures->find();
        }
        $emailSignatures = $this->paginate($EmailSignatures);
        $templates = array('1'=>'Classic','2'=>'Horizontal','3'=>'Wide','4'=>'Compact');
        $this->set(compact('emailSignatures','templates'));
    }

    /**
     * View method
     *
     * @param string|null $id Email Signature id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
         $emailSignature = $this->EmailSignatures->get($id, [
            'contain' => []
        ]);

        $this->set('emailSignature', $emailSignature);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
       $templates = array('1'=>'Classic','2'=>'Horizontal','3'=>'Wide','4'=>'Compact');
        $emailSignature = $this->EmailSignatures->newEntity();
        if ($this->request->is('post')) {
            $emailSignature = $this->EmailSignatures->patchEntity($emailSignature, $this->request->getData());
            $emailSignature->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
            if ($this->EmailSignatures->save($emailSignature)) {
                $this->Flash->success(__('The email signature has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The email signature could not be saved. Please, try again.'));
        }
        $this->set(compact('emailSignature','templates'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Email Signature id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $emailSignature = $this->EmailSignatures->get($id, [
            'contain' => []
        ]);
        $templates = array('1'=>'Classic','2'=>'Horizontal','3'=>'Wide','4'=>'Compact');
        if ($this->request->is(['patch', 'post', 'put'])) {
            $emailSignature = $this->EmailSignatures->patchEntity($emailSignature, $this->request->getData());
            $emailSignature->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');
            if ($this->EmailSignatures->save($emailSignature)) {
                $this->Flash->success(__('The email signature has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The email signature could not be saved. Please, try again.'));
        }
        $this->set(compact('emailSignature','templates'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Email Signature id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $emailSignature = $this->EmailSignatures->get($id);
        if ($this->EmailSignatures->delete($emailSignature)) {
            $this->Flash->success(__('The email signature has been deleted.'));
        } else {
            $this->Flash->error(__('The email signature could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
