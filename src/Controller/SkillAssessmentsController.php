<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * SkillAssessments Controller
 *
 * @property \App\Model\Table\SkillAssessmentsTable $SkillAssessments
 *
 * @method \App\Model\Entity\SkillAssessment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SkillAssessmentsController extends AppController
{   
    public function isAuthorized($user)
    {
    $contractorNav = false;
    $employeeNav = false;
    
    if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN || $user['role_id'] == CLIENT || $user['role_id'] == CONTRACTOR_ADMIN || $user['role_id'] == CR) {
    $contractorNav = true;
    }
    $this->set('contractorNav', $contractorNav);
    
    // if($user['role_id'] != EMPLOYEE) {
    //     $employeeNav = true;
    //     $this->set('service_id', 4);
    // }
    if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN) {
        $clientNav = true;
        $this->set('clientNav', $clientNav);
    }
    //$this->set('employeeNav', $employeeNav);

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
        $contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
        $totalCount = $this->SkillAssessments->find('all')->count();
        $this->paginate = [
            'contain' => ['Contractors'],
            'conditions' => ['contractor_id'=>$contractor_id],
            'limit'  => $totalCount,
            'maxLimit'=> $totalCount
        ];
        $skillAssessments = $this->paginate($this->SkillAssessments);

        $this->set(compact('skillAssessments'));
    }

    /**
     * View method
     *
     * @param string|null $id Skill Assessment id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
        $skillAssessment = $this->SkillAssessments->get($id, [
            'contain' => ['Contractors']
        ]);
        $contractor = $this->SkillAssessments->Contractors->get($contractor_id, [
            'contain' => ['Users']
        ]);

        $this->set(compact('skillAssessment','contractor'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
  /*  public function add()
    {
        $skillAssessment = $this->SkillAssessments->newEntity();
        if ($this->request->is('post')) {
            $skillAssessment = $this->SkillAssessments->patchEntity($skillAssessment, $this->request->getData());
            if ($this->SkillAssessments->save($skillAssessment)) {
                $this->Flash->success(__('The skill assessment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The skill assessment could not be saved. Please, try again.'));
        }
        $contractors = $this->SkillAssessments->Contractors->find('list', ['limit' => 200]);
        $this->set(compact('skillAssessment', 'contractors'));
    }*/
    public function add($contractor_id =null)
    {
    if(empty($contractor_id)){
    $contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
    }
    $contractor = $this->SkillAssessments->Contractors->get($contractor_id, [
            'contain' => ['Users']
    ]);
    
    $userId = $this->getRequest()->getSession()->read('Auth.User.id');

    $skillAssessment = $this->SkillAssessments->newEntity();
    if ($this->request->is(['patch', 'post', 'put'])) {
        $requestDt = $this->request->getData('skillAssessments');

        foreach($requestDt as $key => $val) {
            if($val['document']!='') {
                $skillAssessment = $this->SkillAssessments->newEntity();
                $skillAssessment = $this->SkillAssessments->patchEntity($skillAssessment, $val);
                $skillAssessment->contractor_id = $contractor_id;
                $skillAssessment->created_by = $userId;
                 // pr($skillAssessment);die;
                if($this->SkillAssessments->save($skillAssessment)) {
                    //$this->Flash->success(__('The EmployeeExplanations has been saved.'));
                }
                /*else {
                    $this->Flash->error(__('The EmployeeExplanations could not be saved. Please, try again.'));
                }*/
            }
            /*else {
                $this->Flash->error(__('The EmployeeExplanations could not be saved. Please, try again.'));
            }*/
        }
        $this->Flash->success(__('The Document has been Uploaded.'));
    }   
        
    $this->paginate = [
            'contain' => ['Contractors'],
        'conditions' => ['contractor_id'=>$contractor_id]
    ];
    $skillAssessments = $this->paginate($this->SkillAssessments);

    $this->set(compact('skillAssessment', 'skillAssessments', 'contractor'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Skill Assessment id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
        $skillAssessment = $this->SkillAssessments->get($id, [
            'contain' => []
        ]);     
        $contractor = $this->SkillAssessments->Contractors->get($contractor_id, [
            'contain' => ['Users']
    ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $skillAssessment = $this->SkillAssessments->patchEntity($skillAssessment, $this->request->getData());
            if ($this->SkillAssessments->save($skillAssessment)) {
                $this->Flash->success(__('The Document has been Uploaded.'));

                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('The Document could not be Uploaded. Please, try again.'));
        }
        $Contractors = $this->SkillAssessments->Contractors->find('list', ['limit' => 200]);
        $this->set(compact('skillAssessment', 'contractors','contractor'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Skill Assessment id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $skillAssessment = $this->SkillAssessments->get($id);
        if ($this->SkillAssessments->delete($skillAssessment)) {
            $this->Flash->success(__('The skill assessment has been deleted.'));
        } else {
            $this->Flash->error(__('The skill assessment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'add']);
        
    }
    public function expList($contractor_id = null)
    {
        $this->loadModel('Contractors-');
        if(empty($contractor_id)){
            $contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
        }              
           

             $employees = $this->Contractors
            ->find('all')          
            ->contain(['EmployeeExplanations'])        
            ->where(['Employees.contractor_id'=>$contractor_id])      
            ->toArray();
           // pr($employees);die;
           

        $this->set(compact('employees'));
    }    
}
