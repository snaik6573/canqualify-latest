<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;
/**
 * Questions Controller
 *
 * @property \App\Model\Table\QuestionsTable $Questions
 *
 * @method \App\Model\Entity\Question[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class QuestionsController extends AppController
{
    public function isAuthorized($user)
    {
	// Admin can access every action
	if (isset($user['role_id']) && $user['active'] == 1) {
		if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN){		
			return true;
		}
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
	$totalCount = $this->Questions->find('all')->count();		
	$this->paginate = [
	    'contain' => ['QuestionTypes', 'Categories.Services', 'Clients'],
	    'limit' => $totalCount,
	    'maxLimit'=> $totalCount
	];
	$questions = $this->paginate($this->Questions);

	if ($this->request->is(['patch', 'post', 'put'])) {
		$this->viewBuilder()->setLayout('ajax');
		$question = $this->Questions->get($this->request->getData('id'));
		if(!empty($question)) {
			$question = $this->Questions->patchEntity($question, $this->request->getData());
			$question->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');
			if ($save=$this->Questions->save($question)) {
				echo '<div class="alert with-close alert-success alert-dismissible fade show" role="alert">The Questions has been saved.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
			}
			else {
				echo '<div class="alert with-close alert-danger alert-dismissible fade show" role="alert">The question could not be saved. Please, try again.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
			}
		}
		exit;
	}
        $this->set(compact('questions'));
    }

    /**
     * View method
     *
     * @param string|null $id Question id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $question = $this->Questions->get($id, [
            'contain' => ['QuestionTypes', 'Categories', 'Clients']
        ]);
	    $question->question_options = implode("\r\n",json_decode($question['question_options']));

	    $this->paginate = [
	        'contain' => ['QuestionTypes', 'Categories.Services', 'Clients'],
	        'conditions'=> ['question_id'=>$id]
	    ];
	    $subQuestions = $this->paginate($this->Questions);
        $this->set(compact('question', 'subQuestions'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
	    $this->loadModel('Clients');
	    $this->loadModel('Services');

        $question = $this->Questions->newEntity();
        if ($this->request->is('post')) {
            //debug($this->request->getData());die;
            $postData = $this->request->getData();
            /*If document for help then save it*/
            if(!empty($postData['document'])){
                $document = $this->request->getData('document');
                //debug($document);die;
                if($document['size']>0) {
                    $fuConfig['upload_path'] = UPLOAD_HELP_FILES;
                    $fuConfig['allowed_types'] = array('pdf', 'xls', 'xlsx', 'doc', 'docx', 'png', 'jpg', 'jpeg');
                    $fuConfig['max_size'] = 0;
                    $this->Fileupload->init($fuConfig);

                    if (!$this->Fileupload->upload($document)) {
                        $fError = $this->Fileupload->errors();
                        $fError_str = implode(', ',$fError);
                        $this->Flash->error(__($fError . ' The question help file could not be uploaded. Please, try again.'));
                        $postData['document'] = '';
                    }else{
                        $uploaded_file = $this->Fileupload->output();
                        //debug($fError);die;
                        $question = $this->Questions->patchEntity($question, $postData);
                        $question->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
                        $question->document = $uploaded_file['file_name'];
                        $question->question_options = json_encode(explode("\r\n", $this->request->getData('question_options')));

                        if ($this->Questions->save($question)) {
                            $this->Flash->success(__('The question has been saved.'));

                            return $this->redirect(['action' => 'index']);
                        }
                        $this->Flash->error(__('The question could not be saved. Please, try again.'));
                    }
                }
            }

        }
        $questionTypes = $this->Questions->QuestionTypes->find('list');
	    $categories = $this->Category->getServiceCatgories();
	    $clients = $this->Clients->find('list', ['keyField' => 'id', 'valueField' => 'company_name']);
        //$questions = $this->Questions->find('list', ['keyField' => 'id', 'valueField' => 'question']);

        $this->set(compact('question', 'questionTypes', 'categories', 'clients'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Question id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
	    $this->loadModel('Clients');
        $question = $this->Questions->get($id, [
            'contain' => []
        ]);
        $question->question_options =  implode("\r\n",json_decode($question['question_options']));

        if ($this->request->is(['patch', 'post', 'put'])) {
            $postData = $this->request->getData();
            //debug($postData);die;
            /*If document for help then save it*/
            if($postData['document']['error'] == 0){
                $document = $this->request->getData('document');
                //debug($document);die;
                if($document['size']>0) {
                    $fuConfig['upload_path'] = UPLOAD_HELP_FILES;
                    $fuConfig['allowed_types'] = '*';
                    $this->Fileupload->init($fuConfig);
                    if (!$this->Fileupload->upload($document)) {
                        $fError = $this->Fileupload->errors();
                        $fError_str = implode(', ', $fError);
                        $this->Flash->error(__($fError_str . ' The question help file could not be uploaded. Please, try again.'));
                        $postData['document'] = '';
                    }else{
                        $uploaded_file = $this->Fileupload->output();
                        $replaced_filename = $uploaded_file['file_name'];
                        /*Delete old file*/
                        if (!empty($postData['old_document']) && file_exists(UPLOAD_HELP_FILES.$postData['old_document'])) {
                            unlink(UPLOAD_HELP_FILES.$postData['old_document']);
                        }
                    }
                }
            }
            if(isset($replaced_filename) && $replaced_filename != ''){
            }else{
                unset($postData['document']);
            }
            $question = $this->Questions->patchEntity($question, $postData);
            $question->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');

            if(isset($replaced_filename) && $replaced_filename != ''){
                $question->document = $replaced_filename;
            }
            $question->question_options = json_encode(explode("\r\n", $this->request->getData('question_options') ));

            if ($this->Questions->save($question)) {
                $this->Flash->success(__('The question has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The question could not be saved. Please, try again.'));
        }
        $questionTypes = $this->Questions->QuestionTypes->find('list');        
		$categories = $this->Category->getServiceCatgories();
		$clients = $this->Clients->find('list', ['keyField' => 'id', 'valueField' => 'company_name']);
        $questions = $this->Questions->find('list', ['keyField' => 'id', 'valueField' => 'question'])->where(['category_id'=>$question->category_id, 'is_parent'=>true]);

        $questionOptions = [];
        if ($question->question_id != '') {
            $questionOptions = $this->Questions->find('list', ['keyField'=>'question_options', 'valueField'=>'question_options'])->where(['id'=>$question->question_id])->first();
            $questionOptions = json_decode($questionOptions, true);
            $questionOptions = array_combine($questionOptions, $questionOptions);
        }

		$this->set(compact('question', 'questionTypes', 'categories', 'clients', 'questions', 'questionOptions'));
	}

    /**
     * Delete method
     *
     * @param string|null $id Question id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $question = $this->Questions->get($id);
        if ($this->Questions->delete($question)) {
            $this->Flash->success(__('The question has been deleted.'));
        } else {
            $this->Flash->error(__('The question could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getQuestions($category_id=null)
    {
    	$this->viewBuilder()->setLayout('ajax');

        $questions = [];
        if ($category_id!==null) {
            $questions = $this->Questions->find('list', ['keyField' => 'id', 'valueField' => 'question'])->where(['category_id'=>$category_id, 'is_parent'=>true]);
        }

		$this->set(compact('questions'));
	}

    public function getOptions($id=null)
    {
    	$this->viewBuilder()->setLayout('ajax');

        $questionOptions = [];
        if ($id!==null) {
            $questionOptions = $this->Questions->find('list', ['keyField'=>'question_options', 'valueField'=>'question_options'])->where(['id'=>$id])->first();
            
            $questionOptions = json_decode($questionOptions, true);
            $questionOptions = array_combine($questionOptions, $questionOptions);
        }

		$this->set(compact('questionOptions'));
	}
}
