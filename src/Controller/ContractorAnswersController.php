<?php
namespace App\Controller;
use App\Controller\AppController;
use App\Controller\CommandPool;
use Cake\Event\Event;
use Cake\View\Helper\BreadcrumbsHelper;
use Cake\Core\Configure;
use Cake\Utility\Hash;
use Cake\ORM\TableRegistry;

/**
 * ContractorAnswers Controller
 *
 * @property \App\Model\Table\ContractorAnswersTable $ContractorAnswers
 *
 * @method \App\Model\Entity\ContractorAnswer[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ContractorAnswersController extends AppController
{
    public function isAuthorized($user)
    {
	$contractorNav = false;
	if(in_array($user['role_id'], array(SUPER_ADMIN, ADMIN, CLIENT, CR, CLIENT_ADMIN, CLIENT_VIEW, CLIENT_BASIC))) {
		$contractorNav = true;
	}
	$this->set('contractorNav', $contractorNav);

	if($this->request->getParam('action')=='getPolicyExpDate') {
        $clientNav = true;
       $this->set('clientNav', $clientNav);
    }
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
    public function index($service_id=null)
    {
	$this->loadModel('Services');

	$contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
	$contractor_clients = $this->User->getClients($contractor_id);
	$totalCount = $this->ContractorAnswers->find('all')->count();								
	$this->paginate = [
	    'conditions'=>['contractor_id'=>$contractor_id],
	    'contain'=>['Contractors', 'Questions'],
        'limit'=>$totalCount,
        'maxLimit'=>$totalCount
	];
	$contractorAnswers = $this->paginate($this->ContractorAnswers);	
	$categories = $this->Category->getCategories($contractor_clients, $contractor_id, $service_id);

	$this->set(compact('contractorAnswers', 'service_id', 'categories'));
    }

    /**
     * View method
     *
     * @param string|null $id Contractor Answer id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
	$contractorAnswer = $this->ContractorAnswers->get($id, [
	    'contain'=>['Contractors', 'Questions', 'Questions.QuestionTypes']
	]);
	$contractorAnswer->question->question_options = implode("\r\n",json_decode($contractorAnswer->question->question_options));

	$this->set('contractorAnswer', $contractorAnswer);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    /*public function add()
    {
	$contractorAnswer = $this->ContractorAnswers->newEntity();
	if ($this->request->is('post')) {
	    $contractorAnswer = $this->ContractorAnswers->patchEntity($contractorAnswer, $this->request->getData());

	    if ($this->ContractorAnswers->save($contractorAnswer)) {
		$this->Flash->success(__('The contractor answer has been saved.'));

		return $this->redirect(['action'=>'index']);
	    }
	    $this->Flash->error(__('The contractor answer could not be saved. Please, try again.'));
	}
	$contractors = $this->ContractorAnswers->Contractors->find('list');
	$questions = $this->ContractorAnswers->Questions->find('list');
	$this->set(compact('contractorAnswer', 'contractors', 'questions'));
    }*/

    /**
     * Delete method
     *
     * @param string|null $id Contractor Answer id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
	$this->request->allowMethod(['post', 'delete']);
	$contractorAnswer = $this->ContractorAnswers->get($id);
	if ($this->ContractorAnswers->delete($contractorAnswer)) {
	    $this->Flash->success(__('The contractor answer has been deleted.'));
	} else {
	    $this->Flash->error(__('The contractor answer could not be deleted. Please, try again.'));
	}

	return $this->redirect(['action'=>'index']);
    }

    public function saveAnswer($val=array(), $year=null) {
    $this->loadModel('Questions');
	$contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');

	$val['contractor_id'] = $contractor_id;
	if( isset($val['answer']) && is_array($val['answer']) ) {
		$val['answer'] = implode(',',$val['answer']);
	}
	$client_id = isset($val['client_id']) ? $val['client_id'] : null;

	$saveDt = $this->ContractorAnswers->find('all', ['conditions'=>['contractor_id'=>$contractor_id, 'question_id'=>$val['question_id'], 'year IS'=>$year, 'client_id IS'=>$client_id]])->first();       

    $questiondt = $this->Questions
                ->find('all')
                ->where(['Questions.id'=>$val['question_id']])
                ->contain(['QuestionTypes'=>['fields'=>['id', 'name']] ])
                ->first();

	if(empty($saveDt)) { // new answer
		if(isset($val['answer']) && $val['answer']!='' ) {                       
			if($val['answer']== 'other' && $questiondt->question_type->name == 'select_with_input') {
                $val['answer']='other: '.$val['answer_other'];
			}
			if($questiondt->question_type->name == 'acknowledge') {
			if($val['answer']== '0' && $val['date']=='' && $val['initials']==''){  
				$val['answer']='';
			}else{
				$val['answer']='value:'.$val['answer'].', date:'.$val['date']. ', initials:'.$val['initials'];
				}
			}
			if($val['answer']== '0' && $questiondt->question_type->name == 'checkbox_single') {
                $val['answer']='';
			}
			if($questiondt->question_type->name =='input_price'){
				$ans = $val['answer'];
				$val['answer'] = substr($ans, 1);
			}
			$val['created_by'] = $this->getRequest()->getSession()->read('Auth.User.id');
			$saveDt = $this->ContractorAnswers->newEntity();
			//pr($val);die;
			$saveDt = $this->ContractorAnswers->patchEntity($saveDt, $val);
			$saveDt->year = $year;			
            $this->ContractorAnswers->save($saveDt);					
		}
	}
	else { // update answer
        if($val['answer']== 'other' && $questiondt->question_type->name == 'select_with_input') {
            $val['answer']='other: '.$val['answer_other'];
        }
		if($questiondt->question_type->name == 'acknowledge') {
			if($val['answer']== '0' && $val['date']=='' && $val['initials']==''){  
				$val['answer']='';
			}else{
				$val['answer']='value:'.$val['answer'].', date:'.$val['date']. ', initials:'.$val['initials'];
			}
		}
        if($val['answer']== '0' && $questiondt->question_type->name == 'checkbox_single') {
            $val['answer']='';
        }
        if($questiondt->question_type->name =='input_price'){
				$ans = $val['answer'];
				$val['answer'] = substr($ans, 1);
		}
		$val['modified_by'] = $this->getRequest()->getSession()->read('Auth.User.id');
		$saveDt = $this->ContractorAnswers->patchEntity($saveDt, $val);
		$saveDt->year = $year; 		
		$this->ContractorAnswers->save($saveDt);
	}
    }

    public function addAnswers($service_id=null, $category_id=null, $year=null)
    {
	$this->loadModel('ClientQuestions');
	$this->loadModel('Categories');
	$this->loadModel('Questions');
	$this->loadModel('NaiscCodes');
	$this->loadModel('NaicCodes');
	$this->loadModel('PercentageDetails');

	$contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
	$contractor = $this->ContractorAnswers->Contractors->get($contractor_id);
	
	$allowForceChange = $this->User->isContractorAssigned();
	if($this->User->isAdmin()) { $allowForceChange = true; }

	if($year == 0) { $year=null; }
	$is_locked = 1;
	$is_archived = 0;

	if($this->User->isAdmin() || $this->User->isCR()) {
		$is_locked = 0;
	}
	elseif($this->User->isContractor()) {
		//$is_locked = $this->ContractorAnswers->Contractors->find('list', ['keyField'=>'id', 'valueField'=>'is_locked'])->where(['id'=>$contractor_id, 'is_locked'=>true])->count();
		$is_locked = $contractor->is_locked;
		$archivedYears = $this->Category->getArchivedYears();
		$is_archived = in_array($year, $archivedYears) ? 1 : 0;
	}

	if($this->User->isClient()) {
		$client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
		$contractor_clients[] = $client_id;
	}
	else {
		$contractor_clients = $this->User->getClients($contractor_id);
	}

	$questions = $this->Questions
		->find()
		->contain(['QuestionTypes'=>['fields'=>['id', 'name']] ])
		->contain(['ClientQuestions'=>['fields'=>['id', 'client_id','question_id','is_compulsory','ques_order'], 'conditions'=>['ClientQuestions.client_id IN'=>$contractor_clients]] ])
		->contain(['ClientQuestions.Clients'=>['fields'=>['id', 'company_name']]])
		->contain(['ContractorAnswers'=>['conditions'=>['contractor_id'=>$contractor_id, 'year IS'=>$year]] ])
		->where(['active'=>true, 'category_id'=>$category_id])
		->order(['ques_order'=>'ASC','Questions.id'=>'ASC'])
		->all(); 

	$contractorAnswer = $this->ContractorAnswers->find('all', ['conditions'=>['contractor_id'=>$contractor_id]])->toArray();
	if(empty($contractorAnswer)) {
		$contractorAnswer = $this->ContractorAnswers->newEntity();
	}

	if ($this->request->is(['patch', 'post', 'put'])) {
		$requestDt = $this->request->getData('contractor_answers');

		foreach($requestDt as $key=>$val) {

		if(isset($val['question_id'])) {
            if(isset($val['question_id']) && intval($val['question_id']) == 11){
                //process tin before saving
                $val['answer'] = preg_replace("/[^0-9.]/", '', $val['answer']);
            }
				$this->saveAnswer($val, $year);
		}
		else {  // client_based questions save
			foreach($val as $key=>$v) {
				$this->saveAnswer($v, $year);
			}
		}
		}

		/* save contractor */
		if($category_id==2) { // update contractor info if category = General Information
			$this->User->update_contractor($this->request->getData('contractor_answers'), $contractor_id);
		}

        // Get Percentage Category (save percentage in the database)
        $this->Percentage->getPercentage($category_id,$contractor_id,$year); 
		
		$this->Flash->success(__('Answers has been saved.'));

		if($this->request->getData('save_n_exit')!== null)  {
			return $this->redirect(['action' => 'finalSubmit', $service_id]);
		}
		
		$this->set('submit', 1);
	}

	$states = $this->ContractorAnswers->Contractors->States->find('list', ['keyField'=>'name', 'valueField'=>'name'])->where(['country_id'=>$contractor->country_id])->toArray();

	$naisccodes = $this->NaiscCodes->find('list', ['keyField'=>'naisc_code', 'valueField'=> function ($e) { return $e->naisc_code.' - '.$e->title; }])->limit(4000);
	$allnaisccode = $this->NaiscCodes->find('list', ['keyField'=>'naisc_code', 'valueField'=>'title' ])->toArray();
	$naiccodes = $this->NaicCodes->find('list', ['keyField'=>'naic_code', 'valueField'=> function ($e) { return $e->naic_code.' - '.$e->title; }])->limit(4000);
	$allnaiccode = $this->NaicCodes->find('list', ['keyField'=>'naic_code', 'valueField'=>'title' ])->toArray();

	$category = $this->Categories->find('all', ['conditions'=>['id'=>$category_id]])->select(['name'])->first();

	$this->set(compact('contractorAnswer', 'category', 'questions', 'contractor_id', 'service_id', 'year', 'is_locked', 'is_archived', 'category_id','allowForceChange','naisccodes','states','allnaisccode', 'contractor','naiccodes','allnaiccode'));
    }

    public function getQuesAnswerForPqf($client_id=null, $cat_id=null, $year=null) {
        $this->loadModel('Questions');
        $contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');

            $questions = $this->Questions
            ->find()
            ->select(['id','question','category_id','question_type_id'])
            ->contain(['QuestionTypes'=>['fields'=>['id', 'name']] ])
            ->contain(['ClientQuestions'=>['fields'=>['id', 'client_id','question_id'], 'conditions'=>['ClientQuestions.client_id'=>$client_id]] ])
            ->contain(['ContractorAnswers'=>['fields'=>['id', 'question_id', 'answer'], 'conditions'=>['contractor_id'=>$contractor_id, 'year IS'=>$year]] ])
            ->where(['active'=>true, 'category_id'=>$cat_id])
            ->order(['ques_order'=>'ASC','Questions.id'=>'ASC'])
            ->enableHydration(false)
            ->toArray();
        return $questions;
    }			

    public function downloadPqf($client_id=null)
    {
        $this->viewBuilder()->setLayout('ajax');
        $this->loadModel('Questions');
        $this->loadModel('Clients');
        $this->loadModel('Contractors');	    
       		
        $contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
        $uploaded_path = Configure::read('uploaded_path');
        $company_logo = $this->ContractorAnswers->Contractors->find()->select(['company_logo','company_name'])->where(['id'=>$contractor_id])->first();
       

          if ($this->request->is(['patch', 'post', 'put'])) {

            $cnt = 0;
            $format_array = array();
            $data = array();
            $bold_cells = array();
            $service_cells = array();
            $category_cells = array();
            $pull_right = array();
	        $img = null;
	        /*if($company_logo->company_logo != '') {
		        $url =$uploaded_path.$company_logo->company_logo;
		        $img = DOWNLOAD_PQF.'/'.$company_logo->company_logo;
		        file_put_contents($img, file_get_contents($url));		
	        }*/
            $data[] = "Supplier: ". $company_logo->company_name; $cnt++; array_push($bold_cells, $cnt); array_push($pull_right, $cnt);
            $data[] = 'Date Downloaded : '.date("d/m/Y"); $cnt++; array_push($bold_cells, $cnt); array_push($pull_right, $cnt);
	        $data[] = "\n"; $cnt++;

            $requestDt = $this->request->getData();
		    $services =  json_decode($this->request->getData('services'), true);
    
            foreach($services as $key => $service) { 
                $quesAnswers = array();
                $service_name = $service['name'];
                $data[] = "Service:  ".$service_name;  $cnt++; array_push($bold_cells, $cnt); array_push($service_cells, $cnt);
                $data[] = "\n"; $cnt++;

                $i = 0;
                if(!empty($service['categories'])) {
                    foreach($service['categories'] as $cat_id => $cat_name) {
                        $quesAnswers[$i]['category'] = $cat_name;
                        $quesAnswers[$i]['quesions'] = $this->getQuesAnswerForPqf($client_id, $cat_id);
                        $i++;
                    }
                }
                elseif(!empty($service['year'])) {
                    foreach($service['year'] as $year => $categories) {
                    foreach($categories as $cat_id => $cat_name) {
                        $quesAnswers[$i]['category'] = $year. ' : ' .$cat_name;
                        $quesAnswers[$i]['quesions'] = $this->getQuesAnswerForPqf($client_id, $cat_id, $year);
                        $i++;
                    }
                    }
                }
               
                foreach($quesAnswers as $val){
                $data[] = "\n"; $cnt++;
                $data[] = "Category:  ".$val['category'];  $cnt++; array_push($bold_cells, $cnt); array_push($category_cells, $cnt);
                $data[] = "\n"; $cnt++;
                foreach($val['quesions'] as $question){
                    if(empty($question['client_questions'])) { continue; }

                    $data[] = 'Question: ' . strip_tags($question['question']); $cnt++;

                    $question_type = $question['question_type']['name'];
                    $contractor_answers = $question['contractor_answers'];

                    $ans = '';
                    if($question_type == 'file') {
                        foreach($contractor_answers as $answer) {
                            $answer['answer'] = explode(',',$answer['answer']);
                            $tmpCnt = 0;
                            foreach($answer['answer'] as $answer) {
                                if(!empty($answer)){$ans = 'Uploaded'; break;}
                                //$ans .=$uploaded_path.$answer;
                            }
                        }
                        $data[] = 'Answer: ' . strip_tags($ans); $cnt++;
                        $data[] = "\n"; $cnt++;
                    }
                    elseif($question_type == 'select' || $question_type == 'checkbox') {
                        foreach($contractor_answers as $answer) {
                            $answer['answer'] = explode(',',$answer['answer']);
                            foreach($answer['answer'] as $answer) {
                                $ans .= $answer;
                            }
                        }
                        $data[] = 'Answer: ' . strip_tags($ans); $cnt++;
                        $data[] = "\n"; $cnt++;

                    }
                    else {
                        foreach($contractor_answers as $answer) {
                            $data[] = 'Answer: ' . strip_tags($answer['answer']); $cnt++;
                            $data[] = "\n"; $cnt++;
                        }
                    }

                }
                }

            } // foreach services
            //pr($data);
              $file_name = 'PQF';
            if(!empty($contractor_id)){$file_name .= '_' . $contractor_id;}
            $file_name .= '.pdf';
           $format_array = array('bold_cells' => $bold_cells, 'service_cells' => $service_cells, 'category_cells' => $category_cells, 'pull_right' => $pull_right);
           $this->Export->XportToPQF($data, $cnt, $format_array, $file_name );
        
        } // $this->set(compact('contractorAnswer','client_id'));
    }

    /*public function archiveAnswers($service_id=null, $category_id=null, $year=null)
    {
	$this->loadModel('ClientQuestions');
	$this->loadModel('Categories');
	$this->loadModel('Questions');

	$contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');

	$is_locked = 1;
	if($this->User->isAdmin()) {
		$is_locked = 0;
	}
	
	$contractor_clients = $this->User->getClients($contractor_id);	
	$category = $this->Categories->find('all', ['conditions'=>['id'=>$category_id]])->select(['name'])->first();

	$questions = $this->ClientQuestions
	->find()
	->contain(['Questions'])
	->contain(['Questions.QuestionTypes'=>['fields'=>['id', 'name']] ])
	->contain(['Questions.ContractorAnswers'=>['conditions'=>['contractor_id'=>$contractor_id, 'year IS'=>$year]] ])
	->where(['Questions.active'=>true, 'Questions.category_id'=>$category_id, 'ClientQuestions.client_id IN'=>$contractor_clients])
	->distinct('Questions.id')
	->order(['Questions.id'=>'ASC'])
	->all();

	$contractorAnswer = $this->ContractorAnswers->find('all', ['conditions'=>['contractor_id'=>$contractor_id]])->toArray();	
	
		if ($this->request->is(['patch', 'post', 'put'])) {
		$requestDt = $this->request->getData('contractor_answers');
		foreach($requestDt as $key=>$val) {
			$val['contractor_id'] = $contractor_id;
			$val['created_by'] = $this->getRequest()->getSession()->read('Auth.User.id');
			if( isset($val['answer']) && is_array($val['answer']) ) {
				$val['answer'] = implode(',',$val['answer']);
			}

			$saveDt = $this->ContractorAnswers->find('all', ['conditions'=>['contractor_id'=>$contractor_id, 'question_id'=>$val['question_id'], 'year IS'=>$year]])->first();		
			if(empty($saveDt)) { // new answer
				if(isset($val['answer']) && $val['answer']!='' ) {
					$saveDt = $this->ContractorAnswers->newEntity();
					$saveDt = $this->ContractorAnswers->patchEntity($saveDt, $val);
					$saveDt->year = $year;
					$this->ContractorAnswers->save($saveDt);					
				}
			}
			else { // update answer
				$saveDt = $this->ContractorAnswers->patchEntity($saveDt, $val);
				$saveDt->year = $year;
				$this->ContractorAnswers->save($saveDt);
			}
		}			
		

		$this->Flash->success(__('Answers has been saved.'));
		$catnext = $this->request->getData('nextCat');					
		if($catnext!='lastsubmit') {
			return $this->redirect(['action'=>'archiveAnswers/'.$catnext]);
		}
		//return $this->redirect(['action'=>'archiveAnswers/'.$service_id]);
			
	}
	$this->set(compact('contractorAnswer', 'category', 'questions', 'contractor_id', 'service_id', 'year', 'is_locked', 'category_id'));
    }*/

    public function safetyReport($service_id=null, $contractor_id=null)
    {
	$this->loadModel('Contractors');
	$year_range = $this->Category->yearRange();
	$allowForceChange = $this->User->isContractorAssigned();

	if($contractor_id!==null) {
		$this->viewBuilder()->setLayout('ajax');
	}
	else {
		$contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
	}

	$company_name = $this->Contractors->find('all', ['conditions'=>['id'=>$contractor_id]])->select(['company_name'])->first();

	$safetyreport = array();
	$safetyreport['Fatalities'] = $this->Safetyreport->getFatalities($contractor_id);
	$safetyreport['Citations'] = $this->Safetyreport->getCitations($contractor_id);
	$safetyreport['EMR'] = $this->Safetyreport->getEMR($contractor_id);
	$safetyreport['TRIR'] = $this->Safetyreport->getTRIR($contractor_id);
	$safetyreport['LWCR'] = $this->Safetyreport->getLWCR($contractor_id);
	$safetyreport['DART'] = $this->Safetyreport->getDART($contractor_id);
  
	$this->set(compact('contractor_id', 'service_id', 'safetyreport', 'year_range','allowForceChange', 'company_name'));
    }

    public function finalSubmit($service_id=null, $submit=null) {
	$this->loadModel('Users');	
	$this->loadModel('Contractors');
	$contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
	$activeUser = $this->getRequest()->getSession()->read('Auth.User');
   // pr($activeUser);
	$users = $this->Users
		->find('list', ['keyField'=>'id', 'valueField'=> 'id'])
        ->where(['Users.role_id IN'=>ADMIN_ALL])->contain(['Roles'])->toArray();	
		
	if($submit!=null) {
		$contractor = $this->Contractors->get($contractor_id);
		$contractor->data_submit = 1;
		$contractor->data_read = 0;
		//$contractor->is_locked = true;
		if ($this->Contractors->save($contractor)) {
			$this->Notification->addNotificationAdmin($users,6,$contractor_id);
            $this->Flash->success(__('The contractor has been saved.'));
            if($this->User->isContractor()) {
				return $this->redirect(['controller'=>'Contractors', 'action' => 'dashboard']);
			}
			else {
				return $this->redirect(['controller'=>'Contractors', 'action' => 'dashboard', $contractor_id]);
			}
        }
	}
	
	$this->set(compact('service_id'));
    }

    public function download($filename=null) { 
	$uploaded_path = Configure::read('uploaded_path');
	$file_path = $uploaded_path.$filename;

	$response = $this->response->withFile(
	    $uploaded_path,
	    ['download' => true, 'name' => $filename]
	);
	$response = $response->withDownload($filename);

	return $this->redirect($response);
    }

    public function deleteFiles($id = null)
    {		
	$this->viewBuilder()->setLayout('ajax');
	$contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');	
        $contractoranswer = $this->ContractorAnswers->get($id, ['conditions'=>['contractor_id'=>$contractor_id]]);		
		/*$sourceBucket = 'data-canqualifyer';
		$sourceKeyname = $contractoranswer->answer;
		$targetBucket = 'data-canqualifyer-backup';	
		$s3 = $this->Fileuploads3->fileuploadcredential();		
		// Copy an object.
		$s3->copyObject([
			'Bucket'     => $targetBucket,
			'Key'        => "$sourceKeyname-copy",
			'CopySource' => "$sourceBucket/$sourceKeyname",
		]);

		// Perform a batch of CopyObject operations.
		$batch = array();
		for ($i = 1; $i <= 3; $i++) {
			$batch[] = $s3->getCommand('CopyObject', [
				'Bucket'     => $targetBucket,
				'Key'        => "targetKeyname-$i",
				'CopySource' => "$sourceBucket/$sourceKeyname",
			]);
		}
		try {
			$results = CommandPool::batch($s3, $batch);			
			foreach($results as $result) {
				if ($result instanceof ResultInterface) {
					// Result handling here
					print_r($result);
				}
				if ($result instanceof AwsException) {
					// AwsException handling here
					print_r($result);
				}
			}
		} catch (\Exception $e) {
			// General error handling here
			print_r($e);
		}*/
	$contractoranswer->answer='';
        if ($this->ContractorAnswers->save($contractoranswer)) {
            $this->Flash->success(__('The contractoranswer has been deleted.'));
        } else {
            $this->Flash->error(__('The contractoranswer could not be deleted. Please, try again.'));
        }
    }
    public function getPolicyExpDate(){
    	$this->loadModel('ContractorClients');
       $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
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
        //$eff_ques_id = array(43,55,65); // Policy Expiration Question
       //$eff_ques_id = array(42,54,64,72);  // Policy Effective Question
        $where = [function($exp) use($todaydate,$nextdate) {
            return $exp->between('CAST(answer AS DATE)', $todaydate, $nextdate);
        }];
        if($contractors){
        	$ExpriedDate = $this->ContractorAnswers->find()
       				//->where(['ContractorAnswers.question_id IN'=>$exp_ques_id,'CAST(answer AS DATE) <='=>$nextDate])
       				->where(['ContractorAnswers.question_id IN'=>$exp_ques_id,'CAST(answer AS DATE) <='=>$nextDate,'ContractorAnswers.contractor_id IN'=>$contractors])
       				->contain(['Contractors','Questions.Categories'])
       				->order(['CAST(ContractorAnswers.answer AS DATE)'=>'ASC'])
       				->toArray();
        }else{
        	$ExpriedDate = $this->ContractorAnswers->find()
       				//->where(['ContractorAnswers.question_id IN'=>$exp_ques_id,'CAST(answer AS DATE) <='=>$nextDate])
       				->where(['ContractorAnswers.question_id IN'=>$exp_ques_id])
       				->contain(['Contractors','Questions.Categories'])
       				->order(['CAST(ContractorAnswers.answer AS DATE)'=>'ASC'])
       				->toArray();
        } 
        
       if($this->User->isAdmin()) {
       	$nxtDate = '06/01/2021';
       $where = [function($exp) use($todaydate,$nxtDate) {
            return $exp->between('CAST(answer AS DATE)', $todaydate,$nxtDate);
        }];
       $ExpSoonDate = $this->ContractorAnswers->find()
       				->where(['ContractorAnswers.question_id IN'=>$exp_ques_id,$where])
       				->contain(['Contractors','Questions.Categories'])
       				->toArray();
       }else{
       	$ExpSoonDate = $this->ContractorAnswers->find()
       				->where(['ContractorAnswers.question_id IN'=>$exp_ques_id,$where])
       				->contain(['Contractors','Questions.Categories'])
       				->toArray();
       }
     
       $expsoonDate = array();
       foreach ($ExpSoonDate as $key => $value) {
       		$expsoonDate[] = $value->answer;
       }
              // $EffDate = $this->ContractorAnswers->find()
       // 				->where(['ContractorAnswers.question_id IN'=>$eff_ques_id])
       // 				->contain(['Contractors','Questions.Categories'])
       // 				->toArray();
      	$this->set(compact('ExpriedDate','expsoonDate'));
    	
    }
    public function updateInsurDates(){
       $this->loadModel('Questions');
       $ques_id = Configure::read('q_id');
       $category_id = array();
       $i =0;
  	   foreach ($ques_id as $key => $value) {
  	   $category_id[$i]  = ($value['cat_id']);
  	   $exp_ques_id[$i]  = ($value['p_expiration_qid']);
  	    $i++;
  	   }
  	   unset($category_id[3]);
  	   foreach ($category_id as $cat_id) {

  	  // new to change category_id 14,15,16 so that update records
  	   $question_id = $this->Questions->find()->where(['category_id'=>$cat_id])
  	   				 ->toArray();  
		
  	   $contractor = $this->ContractorAnswers->find()->where(['CAST(answer AS DATE) <='=>'03/31/2020','question_id IN'=>$exp_ques_id])->toArray();
  	   // $contractorafter = $this->ContractorAnswers->find()->where(['CAST(answer AS DATE) >='=>'03/31/2020','question_id IN'=>$exp_ques_id])->toArray();
  	   $contractor_ids = array();
  	   $contractor_ids_after  =array();
  	    $j =0;
  	   foreach ($contractor as  $value) {
  	   	  $contractor_ids[$j] = $value->contractor_id;
  	   	  $j++;
  	   }
  	   //  $k =0;
  	   // foreach ($contractorafter as  $v) {
  	   // 		$contractor_ids_after[$k]= $v->contractor_id;
  	   // 		$k++;
  	   // }

  	   foreach ($question_id as $q) { 
  	   	     $query = $this->ContractorAnswers->query();
	         $query->update()
	                ->set(['year' => 2020])
	                ->where(['question_id'=>$q->id])
	                ->execute();
	         // $query = $this->ContractorAnswers->query();
	         // $query->update()
	         //        ->set(['year' => 2020])
	         //        ->where(['question_id'=>$q->id,'contractor_id IN'=>$contractor_ids_after])
	         //        ->execute();
  	   }
  	 }
  	   $this->Flash->success(__('The contractoranswer has been Updated.'));
    	
    }
    public function genratePercentage(){
    	ini_set('memory_limit','-1');	
    	$this->loadModel("Contractors");

    	$contractors = $this->Contractors->find('list',['keyField'=>'id'])->toArray();
    	$category_id =0;
    	$contractor_id=0;
    	$year= 0;
       	 foreach ($contractors as $key => $cont) { 
   		    $category = $this->ContractorAnswers->find()
		        ->select(['id','year'])
		        ->contain(['questions'=> ['fields'=> ['id', 'category_id']] ])
		        ->where(['contractor_id'=>$contractor_id])
		        ->enableHydration(false)
		        ->toArray();  
   		    	$contractor_id = $cont;
   		    foreach ($category as $key => $cat) { 	   		    
   		    	$category_id = $cat['Questions']['category_id'];
   		    	$year = $cat['year'];
   		        //$this->Percentage->getPercentage($category_id,$contractor_id,$year);
   		    }
    	 }
    	
    	$this->Flash->success(__('The Generate Percentage successfully !!!'));
    }
}
