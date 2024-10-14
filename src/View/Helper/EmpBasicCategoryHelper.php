<?php
namespace App\View\Helper;
use Cake\ORM\TableRegistry;
use Cake\View\Helper;
use Cake\View\View;
use Cake\I18n\Number;
use Cake\View\Helper\SessionHelper;

class EmpBasicCategoryHelper extends Helper
{
    public $helpers = ['User'];

    public function getParentcat($parent_id=null)
    {
	$this->EmployeeCategories = TableRegistry::get('EmployeeCategories');
	//$this->ClientEmployeeQuestions = TableRegistry::get('ClientEmployeeQuestions');
	$this->Employees = TableRegistry::get('Employees');
	$activeUser = $this->_View->get('activeUser');

	if(!empty($activeUser['employee_id'])){
		$employee_id = $activeUser['employee_id'];
	}


	// get question EmployeeCategories
    $empCategories = [];
    
	    $empCategories = $this->EmployeeCategories
	    ->find('all', ['fields'=>['id','name', 'employee_category_id', 'is_parent']])
	    ->where(['active'=>true, 'EmployeeCategories.id IN'=>[19,20]])	
	    ->order(['employee_category_order'=>'ASC', 'EmployeeCategories.id'=>'ASC'])
	    ->enableHydration(false)
	    ->toArray();
		
	return $empCategories;	
    }

    public function getCategories($employee_id = null) 
    {
    $this->Employees = TableRegistry::get('Employees');
	$activeUser = $this->_View->get('activeUser');
 
	if(!empty($employee_id)){
		$employee_id = $employee_id;
	}else{
		$employee_id = $activeUser['employee_id'];
	}
	
	$parentcatall = $this->getParentcat(null);
	$allCat = array();
	foreach($parentcatall as $key => $parentcat) {
	$allCat[$parentcat['id']] = $parentcat;
	$getParentPercent = $this->getPercentage($parentcat['id'], $employee_id);
		
	if($parentcat['is_parent']) {
        $totalcper = $getParentPercent;
        $k = $getParentPercent==0 ? 0 : 1; // $k = 0;
		// get child EmployeeCategories
		$childrens = $this->getParentcat($parentcat['id']);
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
	
    public function getPercentage($employee_category_id=null, $employee_id=null) 
    {
	$this->EmployeeQuestions = TableRegistry::get('EmployeeQuestions');
    $this->EmployeeAnswers = TableRegistry::get('EmployeeAnswers');
    $this->EmployeeCategories = TableRegistry::get('EmployeeCategories');

	$percent = $ques_cnt = $ans_cnt = 0;
    // Regualar Quesiton 
    $questionIds  = $this->EmployeeQuestions
		->find('list', ['keyField'=>'id', 'valueField'=>'id'])		
		->where(['EmployeeQuestions.active'=>true, 'EmployeeQuestions.is_parent'=>false, 'EmployeeQuestions.client_based'=>false, 
		'EmployeeQuestions.employee_category_id'=>$employee_category_id,'EmployeeQuestions.employee_question_id IS'=>null
		])
		->toArray();
    $ans_cnt += count($this->getAnswers($questionIds,$employee_id));
    $ques_cnt += count($questionIds);
  
    // Dependend Question
    /*$questionIds3  = $this->EmployeeQuestions            
		->find('list', ['keyField'=>'id', 'valueField'=>'id'])		
		->where(['EmployeeQuestions.active'=>true, 'EmployeeQuestions.is_parent'=>true, 
		'EmployeeQuestions.employee_category_id'=>$employee_category_id,'EmployeeQuestions.employee_question_id IS'=>null])
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
    }*/

    //Dependent without parent question
    /*$where = ['EmployeeQuestions.active'=>true, 'EmployeeQuestions.is_parent' => true,
	'EmployeeQuestions.employee_category_id'=>$employee_category_id, 'EmployeeQuestions.employee_question_id IS' => null];
    if(!empty($questionIds3)) {
		$where['EmployeeQuestions.id NOT IN'] = $questionIds3;
    }
    $questionIds5  = $this->EmployeeQuestions
		->find('list', ['keyField'=>'id', 'valueField'=>'id'])		
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
	*/
    if($ques_cnt == 0){
        $percent = 0;
    } else {
        $percent =  $percent = ($ans_cnt * 100) / $ques_cnt;
    }

	return $percent;								
    }
	
    /*public function getDependQues($questionAns=array(),$client_ids=null,$employee_id=null,&$dependend=array(),$i=0){
		$i++;
		$where = [];       
		foreach ($questionAns as $key => $value) {
         if(!empty($value)){
			$where['OR'][] = ['EmployeeQuestions.active'=>true,'EmployeeQuestions.parent_option'=>$value,'EmployeeQuestions.employee_question_id'=>$key];
		}else{
            $where['OR'][] = ['EmployeeQuestions.active'=>true,'EmployeeQuestions.employee_question_id'=>$key];}
        }
        
        $child_ques = $this->EmployeeQuestions            
		    ->find('list', ['keyField'=>'id', 'valueField'=>'id'])	   
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
    }*/
		
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
	
	public function getQuesCount($catid=null)
    {
		$this->EmployeeQuestions = TableRegistry::get('EmployeeQuestions');

		$activeUser = $this->_View->get('activeUser');
		
		if(!empty($activeUser['employee_id'])){
			$employee_id = $activeUser['employee_id'];
		}
				
		$get_questions = $this->EmployeeQuestions
		->find('all')		
		->where(['EmployeeQuestions.employee_category_id'=>$catid, 'EmployeeQuestions.active'=>true])
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
