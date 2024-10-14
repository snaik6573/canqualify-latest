<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Core\Configure;

/**
 * LeadNotes Controller
 *
 * @property \App\Model\Table\LeadNotesTable $LeadNotes
 *
 * @method \App\Model\Entity\LeadNote[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LeadNotesController extends AppController
{
    public function isAuthorized($user)
    {
    $clientNav = false;
    if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN || $user['role_id'] == CLIENT || $user['role_id'] == CLIENT_ADMIN || $user['role_id'] == CLIENT_VIEW) {
        $clientNav = true;
    }
    $this->set('clientNav', $clientNav);

    if (isset($user['role_id']) && $user['active'] == 1) {
      return true;
    }
    // Default deny
    return false;
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Leads', 'CustomerRepresentative']
        ];
        $leadNotes = $this->paginate($this->LeadNotes);

        $this->set(compact('leadNotes'));
    }

    /**
     * View method
     *
     * @param string|null $id Lead Note id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $leadNote = $this->LeadNotes->get($id, [
            'contain' => ['Leads', 'CustomerRepresentative']
        ]);

        $this->set('leadNote', $leadNote);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($lead_id=null)
    {
        $this->loadModel('Leads');
        $this->loadModel('LeadStatus');        
        $this->loadModel('Contractors');
        $this->loadModel('NotesStatus');
        
	    $contractorList = $this->Contractors->find('list', ['keyField'=>'id', 'valueField'=>'company_name'])->toArray();
       
        $user_id = $this->getRequest()->getSession()->read('Auth.User.id');
	    $role_id = $this->getRequest()->getSession()->read('Auth.User.role_id');
        $status = $this->LeadStatus->find('list', ['id'=>'id', 'valueField'=>'status'])->order(['id'])->toArray();
	  
        $lead = $this->Leads->get($lead_id, [
            'contain' => ['LeadStatus']
        ]);
        $old_status = $lead->lead_status_id;
       
        $leadNote = $this->LeadNotes->newEntity();
        if ($this->request->is('post')) {   
            $requestData = $this->request->getData();         
            $leadNote = $this->LeadNotes->patchEntity($leadNote, $requestData);
            if($this->User->isClient()){ 
		        $leadNote->show_to_client = 1;
             }  
            $leadNote->lead_id=$lead_id;
            $leadNote->created_by = $user_id;
            $leadNote->role_id = $role_id;
            
            if($leadNote['note_type'] == 3){ 
                         $query = $this->Leads->query();
	                      $query->update()               
                            ->set(['email_count'=> $lead->email_count+1])
		                    ->where(['id' => $lead_id])
		                    ->execute();
                }else if($leadNote['note_type'] == 4){
                $query = $this->Leads->query();
	                      $query->update()               
                            ->set(['phone_count'=> $lead->phone_count+1])
		                    ->where(['id' => $lead_id])
		                    ->execute();
                }     
             if($leadNote->note_type == 5 ){ 
                $notesStatus = $this->NotesStatus->newEntity();
                $notesStatus->old_status = $old_status;            
                $notesStatus->new_status = $requestData['lead_status_id'];
                $notesStatus->user_id = $user_id;
                $notesStatus->contractor_id = $requestData['contractor_id'];
                $notesStatus->lead_id=$lead_id;
                $notesStatus->created_by = $this->getRequest()->getSession()->read('Auth.User.id');                                         
               
                if($this->NotesStatus->save($notesStatus)) {  
                    $lead->lead_status_id = $requestData['lead_status_id'];
					if($lead->lead_status_id!=9) { // if lead_status not updated
						$lead->updated_fields = [];
					}
                    $lead->contractor_id = $requestData['contractor_id'];
                    $this->Leads->save($lead);
                }
            }      
                
            if ($this->LeadNotes->save($leadNote)) {               
                $this->Flash->success(__('The lead note has been saved.'));

               return $this->redirect($this->request->getData('refererUrl'));
            }
            $this->Flash->error(__('The lead note could not be saved. Please, try again.'));
        }
          
        $leads = $this->LeadNotes->Leads->find('list', ['limit' => 200]);
        $customerRepresentative = $this->LeadNotes->CustomerRepresentative->find('list', ['limit' => 200]);
        $this->set(compact('leadNote', 'leads', 'customerRepresentative','lead','status','contractorList'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Lead Note id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->loadModel('Leads');
        $this->loadModel('LeadStatus');        
        $this->loadModel('Contractors');
        $this->loadModel('NotesStatus');     
	   	      
        $leadNote = $this->LeadNotes->get($id, [
            'contain' => []
        ]);
        $lead = $this->Leads->get($leadNote->lead_id, [
            'contain' => ['LeadStatus']
        ]);
        $old_status = $lead->lead_status_id;
        $contractorList = $this->Contractors->find('list', ['keyField'=>'id', 'valueField'=>'company_name'])->toArray();       
        $user_id = $this->getRequest()->getSession()->read('Auth.User.id');
	    $role_id = $this->getRequest()->getSession()->read('Auth.User.role_id');
        $status = $this->LeadStatus->find('list', ['id'=>'id', 'valueField'=>'status'])->order(['id'])->toArray();
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $requestData = $this->request->getData();  
            $leadNote = $this->LeadNotes->patchEntity($leadNote, $requestData);
            $leadNote->modified_by = $user_id;
            if($this->User->isClient()){ 
		        $leadNote->show_to_client = 1;
             }
            //$leadNote->lead_id=$lead_id;
            //$leadNote->created_by = $user_id;
            //$leadNote->role_id = $role_id;
            
            if($leadNote['note_type'] == 3){ 
                         $query = $this->Leads->query();
	                      $query->update()               
                            ->set(['email_count'=> $lead->email_count+1])
		                    ->where(['id' => $lead_id])
		                    ->execute();
                }else if($leadNote['note_type'] == 4){
                $query = $this->Leads->query();
	                      $query->update()               
                            ->set(['phone_count'=> $lead->phone_count+1])
		                    ->where(['id' => $lead_id])
		                    ->execute();
                }     
             if($leadNote->note_type == 5 ){ 
                $notesStatus = $this->NotesStatus->newEntity();
                $notesStatus->old_status = $old_status;            
                $notesStatus->new_status = $requestData['lead_status_id'];
                $notesStatus->user_id = $user_id;
                $notesStatus->contractor_id = $requestData['contractor_id'];
                $notesStatus->lead_id=$leadNote->lead_id;
                $notesStatus->created_by = $this->getRequest()->getSession()->read('Auth.User.id');                                         
               
                if($this->NotesStatus->save($notesStatus)) {  
                    $lead->lead_status_id = $requestData['lead_status_id'];
					if($lead->lead_status_id!=9) { // if lead_status not updated
						$lead->updated_fields = [];
					}
                    $lead->contractor_id = $requestData['contractor_id'];
                    $this->Leads->save($lead);
                }
            } 
        
            if ($this->LeadNotes->save($leadNote)) {
                $this->Flash->success(__('The lead note has been saved.'));

                return $this->redirect($this->request->getData('refererUrl'));
            }
            $this->Flash->error(__('The lead note could not be saved. Please, try again.'));
        }
        $leads = $this->LeadNotes->Leads->find('list', ['limit' => 200]);
        $customerRepresentative = $this->LeadNotes->CustomerRepresentative->find('list', ['limit' => 200]);
        $this->set(compact('leadNote', 'leads', 'customerRepresentative','lead','status','contractorList'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Lead Note id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $leadNote = $this->LeadNotes->get($id);
        if ($this->LeadNotes->delete($leadNote)) {
            $this->Flash->success(__('The lead note has been deleted.'));
        } else {
            $this->Flash->error(__('The lead note could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
     public function CrLeadNote($lead_id=null)
    {
	    $this->loadModel('Leads');
        $this->loadModel('LeadStatus');        
        $this->loadModel('Contractors');
        $this->loadModel('NotesStatus');  
        $this->loadModel('Clients');      

	    $CR_id = $this->getRequest()->getSession()->read('Auth.User.CR_id');
	    $user_id = $this->getRequest()->getSession()->read('Auth.User.id');
	    $role_id = $this->getRequest()->getSession()->read('Auth.User.role_id'); 
        $contractorList = $this->Contractors->find('list', ['keyField'=>'id', 'valueField'=>'company_name'])->toArray();   
        $status = $this->LeadStatus->find('list', ['id'=>'id', 'valueField'=>'status'])->order(['id'])->toArray();	        
        $lead = $this->Leads->get($lead_id);

            $old_status = $lead->lead_status_id;
            $leadNote = $this->LeadNotes->newEntity();
             if ($this->request->is(['patch', 'post', 'put'])) {
                $requestData = $this->request->getData();
                $leadNote = $this->LeadNotes->patchEntity($leadNote, $requestData);    
                  if($this->User->isClient()){ 
		            $leadNote->show_to_client = 1;
                    }             
                $leadNote->lead_id=$lead_id;
                $leadNote->created_by=$user_id;
                $leadNote->customer_representative_id = $CR_id;
                $leadNote->role_id = $role_id;

                if($leadNote['note_type'] == 3){ 
                         $query = $this->Leads->query();
	                      $query->update()               
                            ->set(['email_count'=> $lead->email_count+1])
		                    ->where(['id' => $lead_id])
		                    ->execute();
                }else if($leadNote['note_type'] == 4){
                $query = $this->Leads->query();
	                      $query->update()               
                            ->set(['phone_count'=> $lead->phone_count+1])
		                    ->where(['id' => $lead_id])
		                    ->execute();
                }       
                if($leadNote['note_type'] == 5){
                    $notesStatus = $this->NotesStatus->newEntity();
                    $notesStatus->old_status = $old_status;            
                    $notesStatus->new_status = $requestData['lead_status_id'];
                    $notesStatus->user_id = $user_id;
                    $notesStatus->contractor_id = $requestData['contractor_id'];
                    $notesStatus->lead_id=$lead_id;
                    $notesStatus->created_by = $this->getRequest()->getSession()->read('Auth.User.id');                                         

                    if($this->NotesStatus->save($notesStatus)) { 
                        $lead->lead_status_id = $requestData['lead_status_id'];
						if($lead->lead_status_id!=9) { // if lead_status not updated
							$lead->updated_fields = [];
						}
                        $lead->contractor_id = $requestData['contractor_id'];                  
						$this->Leads->save($lead);
                        }
                    }        
                   if ($this->LeadNotes->save($leadNote)) {
                    $this->Flash->success(__('The note has been saved.'));
                   //return $this->redirect(['controller'=> 'CustomerRepresentative', 'action' => 'contractor-list']);
                }
                else {
                    $this->Flash->error(__('The note could not be saved. Please, try again.'));
                }
            }

            $this->paginate = [
                'conditions' => ['lead_id'=>$lead_id]
            ];
            $leadNotes = $this->paginate($this->LeadNotes);

            $this->set(compact('leadNotes', 'leadNote','lead','status','contractorList'));
        }
}
