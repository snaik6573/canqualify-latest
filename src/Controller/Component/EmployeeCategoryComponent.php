<?php
namespace App\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Controller\Component;
use Cake\Controller\Controller;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\I18n\Number;

class EmployeeCategoryComponent extends Component 
{  
	public $components = ['User'];

	public function getParentcat($parent_id=null,$contractor_id=null)
    {
	$this->EmployeeCategories = TableRegistry::get('EmployeeCategories');
	$this->ClientEmployeeQuestions = TableRegistry::get('ClientEmployeeQuestions');
	  $this->Employees = TableRegistry::get('Employees');
	$this->controller = $this->_registry->getController();		
	$activeUser = $this->controller->getRequest()->getSession()->read('Auth.User');
	if(!empty($contractor_id)){
		$contractorEmp = $this->User->getContractorEmp($contractor_id);
		if(!empty($contractorEmp)){
		$employees = $this->Employees->find()->select(['id','pri_contact_fn','pri_contact_ln'])
	        ->where(['id IN'=>$contractorEmp])->enableHydration(false)->toArray();
    }}
	/*$employees = $this->Employees->find()->select(['id','pri_contact_fn','pri_contact_ln'])
        ->where(['contractor_id'=>$contractor_id])->enableHydration(false)->toArray();*/
	if(!empty($activeUser['employee_id'])){
		$employee_id = $activeUser['employee_id'];
	}else{
		foreach ($employees as $key => $e) {
			$employee_id = $e['id'];
		}
	}

	if(isset($activeUser['client_id'])) {
		$contractor_clients[] = $activeUser['client_id'];
	}
	else {
		if(!empty($employee_id)){
		$contractor_clients = $this->User->getEmployeeClients($employee_id,$contractor_id); }
	}

	// get question EmployeeCategories
    $empCategories = [];
    if(!empty($contractor_clients)) {
	    $client_cat = $this->ClientEmployeeQuestions
		    ->find('list', ['keyField'=>'employee_question.id', 'valueField'=>'employee_question.employee_category_id' ])
		    ->contain(['EmployeeQuestions'])
		    ->where(['EmployeeQuestions.active'=>true, 'ClientEmployeeQuestions.client_id IN'=>$contractor_clients])
		    ->distinct('EmployeeQuestions.employee_category_id')
		    ->toArray();
			//pr($client_cat);
		if(!empty($client_cat)) {
	    $empCategories = $this->EmployeeCategories
	    ->find('all', ['fields'=>['id','name', 'employee_category_id', 'is_parent']])
	    ->where(['OR'=> ['AND'=> 
				['active'=>true, 'employee_category_id IS'=>$parent_id, 'id IN'=>$client_cat],
				['active'=>true, 'employee_category_id IS'=>$parent_id, 'is_parent IS'=>true]
         	 	]
		    ])
	    ->order(['employee_category_order'=>'ASC', 'EmployeeCategories.id'=>'ASC'])
	    ->enableHydration(false)
	    ->toArray();
		}
    }
	return $empCategories;	
    }

    public function getCategories($contractor_id=null,$employee_id = null) 
    {
    $this->Employees = TableRegistry::get('Employees');
	$this->controller = $this->_registry->getController();		
	$activeUser = $this->controller->getRequest()->getSession()->read('Auth.User');

    if(empty($contractor_id)&& isset($activeUser['contractor_id'])){
        $contractor_id = $activeUser['contractor_id'];
    }
    if(!empty($contractor_id)){
	    $contractorEmp = $this->User->getContractorEmp($contractor_id);
	    if(!empty($contractorEmp)){
		$employees = $this->Employees->find()->select(['id','pri_contact_fn','pri_contact_ln'])
	        ->where(['id IN'=>$contractorEmp])->enableHydration(false)->toArray();
    } }
	/*$employees = $this->Employees->find()->select(['id','pri_contact_fn','pri_contact_ln'])
        ->where(['contractor_id'=>$contractor_id])->enableHydration(false)->toArray();*/
	if(!empty($activeUser['employee_id'])){
		$employee_id = $activeUser['employee_id'];
	}elseif(!empty($employee_id)){
		$employee_id = $employee_id;
	}else{
		foreach ($employees as $key => $e) {
			$employee_id = $e['id'];
		}
	}
	$contractor_clients = array();
	if($activeUser['role_id'] == CLIENT || $activeUser['role_id'] == CLIENT_ADMIN || $activeUser['role_id'] == CLIENT_VIEW) {
		$contractor_clients[0] = $activeUser['client_id'];
	}
	else {
		if(!empty($employee_id)){
		$contractor_clients = $this->User->getEmployeeClients($employee_id,$contractor_id); }
	}
	$parentcatall = $this->getParentcat(null,$contractor_id);
	$allCat = array();
	foreach($parentcatall as $key => $parentcat) {
	$allCat[$parentcat['id']] = $parentcat;
	$getParentPercent = $this->getPercentage($parentcat['id'], $employee_id, $contractor_clients);
		
	if($parentcat['is_parent']) {
        $totalcper = $getParentPercent;
        $k = $getParentPercent==0 ? 0 : 1; // $k = 0;
		// get child EmployeeCategories
		$childrens = $this->getParentcat($parentcat['id'],$contractor_id);
        if(!empty($childrens)){
		foreach($childrens as $val) {
			$getPercent = $this->getPercentage($val['id'], $employee_id, $contractor_clients);
			
			$allCat[$parentcat['id']]['child'][$val['id']] = $val;
			$allCat[$parentcat['id']]['child'][$val['id']]['getPerc'] = Number::toPercentage($getPercent, 0);
            
			$totalcper = $totalcper + $getPercent;
			$k++;
		}
        // all parent EmployeeCategories		
		$allCat[$parentcat['id']]['getPerc'] = $k==0 ? Number::toPercentage(0, 0) : Number::toPercentage(($totalcper/$k), 0);
        }
        else { // if empty($childrens)
			$parentQuesCount = $this->getQuesCount($parentcat['id'],$contractor_id);
			if($parentQuesCount==0) { unset($allCat[$parentcat['id']]); }
			else { $allCat[$parentcat['id']]['getPerc'] = Number::toPercentage($getParentPercent, 0);}
        }
	}
	else {
        $allCat[$parentcat['id']]['getPerc'] = Number::toPercentage($getParentPercent, 0);	
	}
	}
	return $allCat;
    }
	
    public function getPercentage($employee_category_id=null, $employee_id=null, $contractor_clients=array()) 
    {
	$this->ClientEmployeeQuestions = TableRegistry::get('ClientEmployeeQuestions');
    $this->EmployeeAnswers = TableRegistry::get('EmployeeAnswers');
    $this->EmployeeCategories = TableRegistry::get('EmployeeCategories');

	$percent = $ques_cnt = $ans_cnt = 0;
    // Regualar Quesiton 
    $questionIds  = $this->ClientEmployeeQuestions
		->find('list', ['keyField'=>'employee_question.id', 'valueField'=>'employee_question.id'])
		->contain(['EmployeeQuestions'])
		->where(['EmployeeQuestions.active'=>true, 'EmployeeQuestions.is_parent'=>false, 'EmployeeQuestions.client_based'=>false, 
		'EmployeeQuestions.employee_category_id'=>$employee_category_id,'EmployeeQuestions.employee_question_id IS'=>null,
		'ClientEmployeeQuestions.client_id IN'=>$contractor_clients, 'ClientEmployeeQuestions.is_compulsory'=>true
		])
		->toArray();
    $ans_cnt += count($this->getAnswers($questionIds,$employee_id));
    $ques_cnt += count($questionIds);

    // Client based Quesiton
    foreach ($contractor_clients as $key => $client_id) {  	
       $questionIds2 = $this->ClientEmployeeQuestions
		    ->find('list', ['keyField'=>'employee_question.id', 'valueField'=>'employee_question.id'])
		    ->contain(['EmployeeQuestions'])
		    ->where(['EmployeeQuestions.active'=>true, 'EmployeeQuestions.client_based'=>true, 
			'EmployeeQuestions.employee_category_id'=>$employee_category_id,
			'ClientEmployeeQuestions.client_id'=>$client_id,'ClientEmployeeQuestions.is_compulsory'=>true])
		    ->toArray();

		   $ans_cnt += count($this->getAnswers($questionIds2,$employee_id,$client_id));
		   $ques_cnt += count($questionIds2);
	}
         
    // Dependend Question
    $questionIds3  = $this->ClientEmployeeQuestions            
		->find('list', ['keyField'=>'employee_question.id', 'valueField'=>'employee_question.id'])
		->contain(['EmployeeQuestions'])
		->where(['EmployeeQuestions.active'=>true, 'EmployeeQuestions.is_parent'=>true, 
		'EmployeeQuestions.employee_category_id'=>$employee_category_id,'EmployeeQuestions.employee_question_id IS'=>null,
		'ClientEmployeeQuestions.client_id IN'=>$contractor_clients, 'ClientEmployeeQuestions.is_compulsory'=>true])
		->toArray();

    $parent_ans = $this->getAnswers($questionIds3,$employee_id);
    $ques_cnt += count($questionIds3); 
    $ans_cnt += count($parent_ans);

    foreach ($parent_ans as $key => $value) {
        $s = $this->getDependQues(array($key=>$value),$contractor_clients,$employee_id);
		foreach ($s as $k => $v) {
            $ans_cnt += count($v['ans']);
            $ques_cnt += count($v['ques']);
        }
    }

    //Dependent without parent question
    $where = ['EmployeeQuestions.active'=>true, 'EmployeeQuestions.is_parent' => true,
	'EmployeeQuestions.employee_category_id'=>$employee_category_id, 'EmployeeQuestions.employee_question_id IS' => null];
    if(!empty($questionIds3)) {
		$where['EmployeeQuestions.id NOT IN'] = $questionIds3;
    }
    $questionIds5  = $this->ClientEmployeeQuestions
		->find('list', ['keyField'=>'employee_question.id', 'valueField'=>'employee_question.id'])
		->contain(['EmployeeQuestions'])
		->where([$where])
		->toArray();
           
    if(!empty($questionIds5)) {
    foreach ($questionIds5 as $key) {
        $s = $this->getDependQues(array($key=>null),$contractor_clients,$employee_id);   
        foreach ($s as $k => $v) {
			$ans_cnt += count($v['ans']);
			$ques_cnt += count($v['ques']);
        }
    } 
    }    

    if($ques_cnt == 0){
        $percent = 0;
    } else {
        $percent =  $percent = ($ans_cnt * 100) / $ques_cnt;
    }

	return $percent;								
    }
	
    public function getDependQues($questionAns=array(),$client_ids=null,$employee_id=null,&$dependend=array(),$i=0){
		$i++;
		$where = [];       
		foreach ($questionAns as $key => $value) {
         if(!empty($value)){
			$where['OR'][] = ['EmployeeQuestions.active'=>true,'ClientEmployeeQuestions.is_compulsory'=>true ,'ClientEmployeeQuestions.client_id IN'=>$client_ids,'EmployeeQuestions.parent_option'=>$value,'EmployeeQuestions.employee_question_id'=>$key];
		}else{
            $where['OR'][] = ['EmployeeQuestions.active'=>true,'ClientEmployeeQuestions.is_compulsory'=>true ,'ClientEmployeeQuestions.client_id IN'=>$client_ids,'EmployeeQuestions.employee_question_id'=>$key];}
        }
        
        $child_ques = $this->ClientEmployeeQuestions            
		    ->find('list', ['keyField'=>'question.id', 'valueField'=>'question.id'])
		    ->contain(['EmployeeQuestions'])
		    ->where($where)
		    ->toArray();

	  	if(!empty($child_ques)){
			   	$child_ans = $this->getAnswers($child_ques,$employee_id);
			   	$dependend[$i]['ques'] = $child_ques;
				$dependend[$i]['ans'] = $child_ans;
				if(!empty($child_ans)) {					
                	$this->getDependQues($child_ans,$client_ids,$employee_id,$dependend, $i);
                }
                else {
					return $dependend;
                }
                return $dependend;
	    }	
	    else {
	    	return $dependend;
        }
    }
		
    public function getNextcat($current_category=null)
    {
	$categories = $this->getCategories();
	if($categories!=null) {
		$catLoop = array();
		foreach($categories as $category) {	
			if(!empty($category['child'])) {
			$pQuesCount = $this->getQuesCount($category['id']);
			if($pQuesCount > 0) {
				$catLoop[] = $category['id'];
			}
			foreach($category['child'] as $subcat) {
				$cQuesCount = $this->getQuesCount($subcat['id']);
				if($cQuesCount > 0) {
					$catLoop[] = $subcat['id'];
				}
			}
			}
			else{				
			$quesCount = $this->getQuesCount($category['id']);
				if($quesCount > 0){
					$catLoop[] = $category['id'];
				}
			}
		}

		$catNext = 'lastsubmit';
		if(in_array($current_category, $catLoop)) {
			$currentKey = array_search($current_category, $catLoop);						
			$nextKey = $currentKey + 1;
					
			if(array_key_exists($nextKey,$catLoop)) {
				$catNext = $catLoop[$nextKey];
			}		
		}
	}
	return $catNext;
    }
	
	public function getQuesCount($catid=null,$contractor_id=null)
    {
		$this->ClientEmployeeQuestions = TableRegistry::get('ClientEmployeeQuestions');

		$this->controller = $this->_registry->getController();		
		$activeUser = $this->controller->getRequest()->getSession()->read('Auth.User');
		
		if(empty($contractor_id)&& isset($activeUser['contractor_id'])){
       		$contractor_id = $activeUser['contractor_id'];
   		}
   		if(!empty($contractor_id)){
		    $contractorEmp = $this->User->getContractorEmp($contractor_id);
		    if(!empty($contractorEmp)){
			$employees = $this->Employees->find()->select(['id','pri_contact_fn','pri_contact_ln'])
		        ->where(['id IN'=>$contractorEmp])->enableHydration(false)->toArray();
		} }  
		/*$employees = $this->Employees->find()->select(['id','pri_contact_fn','pri_contact_ln'])
        ->where(['contractor_id'=>$contractor_id])->enableHydration(false)->toArray();*/
		if(!empty($activeUser['employee_id'])){
			$employee_id = $activeUser['employee_id'];
		}else{
			foreach ($employees as $key => $e) {
				$employee_id = $e['id'];
			}
		}
		
		$contractor_clients = array();
		if(isset($activeUser['client_id'])) {
			$contractor_clients[0] = $activeUser['client_id'];
		}
		else {
			$contractor_clients = $this->User->getEmployeeClients($employee_id,$contractor_id);
		}
		
		$get_questions = $this->ClientEmployeeQuestions
		->find('all')
		->contain(['EmployeeQuestions'])
		->where(['ClientEmployeeQuestions.client_id IN'=>$contractor_clients, 'EmployeeQuestions.employee_category_id'=>$catid, 'EmployeeQuestions.active'=>true])
		->count();

		return $get_questions;
    }
	
    public function getAnswers($questionIds= array(),$employee_id=null,$client_id=null){
		$answer = array();		    
		if(!empty($questionIds)) {
			$answer = $this->EmployeeAnswers						    
				->find('list',['keyField'=>'employee_question_id','valueField'=>'answer'])
				->where(['employee_id'=>$employee_id, 'answer !='=>'',  'employee_question_id IN'=>$questionIds,'client_id IS'=>$client_id])
				->toArray();
		}
		return $answer;
    }
   /* public function checkCatogories($employee_id=null){
    	$catShow = '';
    	$categories = $this->getCategories(null,$employee_id);
    	if(!empty($categories)){
    	$catShow = false;
    	foreach ($categories as $cat) {
		if($cat['getPerc'] != '100%') {
			$catShow = true;
			continue;
		}
		}
		return $catShow;
    }}*/
}
?>

