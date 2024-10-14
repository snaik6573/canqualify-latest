<?php
namespace App\View\Helper;
use Cake\ORM\TableRegistry;
use Cake\View\Helper;
use Cake\View\View;
use Cake\View\StringTemplateTrait;
use Cake\ORM\Behavior\TreeBehavior;
use Cake\I18n\Number;
use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\SessionHelper;
use Cake\Core\Configure;

class CategoryHelper extends Helper
{
    public $helpers = ['User'];

    public function getServices($contractor_id=null)
    {
	$contractor_clients = $this->User->getClients($contractor_id);
	$this->ClientServices = TableRegistry::get('ClientServices');
	$this->ContractorInvoices = TableRegistry::get('ContractorInvoices');

	$services = $this->ContractorInvoices
		->find('list', ['keyField'=>'id','valueField'=>'service_id'])			
		->where(['contractor_id'=>$contractor_id])
		->toArray();
	
	$contractorServices = array();
	if(!empty($contractor_clients) && !empty($services)) {
	$contractorServices = $this->ClientServices
		->find()
		->select(['client_id','service_id'])
		->contain(['Services'=>['fields'=>['id', 'name']]])
		->contain(['Services.Categories'=>[
			'fields'=>['id','name','service_id'],
			'conditions'=>['active'=>true], 
			'queryBuilder'=>function ($q) { return $q->order(['Categories.category_order' =>'ASC']); }
		] ])
		->where(['client_id IN'=>$contractor_clients, 'service_id IN'=>$services])
		->distinct(['service_id'])
		->toArray();
	}
	return $contractorServices;
    }

    public function yearRange()
    {
	$this->CanqYears = TableRegistry::get('CanqYears');
	
	$subquery1 = $this->CanqYears->find('all', ['fields'=>['id']])->where(['status' =>'start'])->first();
	$subquery2 = $this->CanqYears->find('all', ['fields'=>['id']])->where(['status' =>'end'])->first();
	$year = $this->CanqYears
		->find('list', ['keyField'=>'year','valueField'=>'year'])			
		->where(['id BETWEEN ' .$subquery1->id. ' AND'=>$subquery2->id])	
		->order(['id'=>'ASC'])
		->enableHydration(false)
		->toArray();			
	return $year;
    }

    public function getParentcat($service_id=null,$parent_id=null,$archive=null)
    {		
	$this->Categories = TableRegistry::get('Categories');
	$contractor_clients = $this->User->getClients($parent_id);
	$andWhere[] = ['Categories.active'=>true, 'Categories.category_id IS'=>$parent_id,'Categories.service_id'=>$service_id ];
	if($archive !== null)
	{
	$andWhere[] = ['Categories.year_based IS'=>true];
	}

	$query = $this->Categories
	->find('all', ['fields'=>['id','name','year_based', 'category_id']])			
	->contain(['Services'])
	->contain(['Services.ClientServices'=>['conditions'=>['ClientServices.client_id IN'=>$contractor_clients]] ])
	->where([$andWhere])
	->order(['category_order'=>'ASC', 'Categories.id'=>'ASC'])
	->enableHydration(false)
	->toArray();				
	return $query;	
    }

    public function getCategories($contractor_id=null,$service_id=null,$archive=null)
    {			
	$this->ContractorAnswers = TableRegistry::get('ContractorAnswers');
	$year_range = array_reverse($this->yearRange());
	
	if($archive !== null) {
	$this->CanqYears = TableRegistry::get('CanqYears');	
	$subquery1 = $this->CanqYears->find('all', ['fields'=>['id']])->where(['status' =>'start'])->first();	
	$year_range = $this->CanqYears
		->find('list', ['keyField'=>'year','valueField'=>'year'])			
		->where(['id < ' .$subquery1->id])	
		->order(['year'=>'ASC'])
		->enableHydration(false)
		->toArray();				
	}

	$contractor_clients = $this->User->getClients($contractor_id);

	$parentcatall = $this->getParentcat($service_id,null,$archive);
	$allCat = array();	
	foreach($parentcatall as $parentcat) {
	$allCat[$parentcat['id']] = $parentcat;

	if($parentcat['year_based'] == true) {
		$totalper=0;
		$i =0;
		foreach($year_range as $year) {			
			$yearPer =0;
			$y =0;
			$allCat[$parentcat['id']]['getPerc'] = $this->getPercentage($parentcat['id'], $contractor_id, $contractor_clients, $year);
			$childrens = $this->getParentcat($service_id, $parentcat['id']);
			if(!empty($childrens)) {
				$question_ids = array(36, 37, 38);

				$checkHidden = $this->checkHidden($year, $question_ids,$contractor_id);
				if($childrens[0]['name']=="General Information") {
					$totalsubmit = $this->ContractorAnswers
					->find('all')
					->contain(['Questions'])
					->where(['contractor_id'=>$contractor_id, 'answer !='=>'', 'Questions.category_id'=>$childrens[0]['id'],'year IS'=>$year])
					->count();

					if($totalsubmit > 0) {
					foreach($childrens as $val) {
						if($val['name']=="OSHA") { if(isset($checkHidden['36'])) continue; } // q_id 36
						elseif($val['name']=="EMR") { if(isset($checkHidden['37'])) continue; } // q_id 37
						elseif($val['name']=="Citations") { if(isset($checkHidden['38'])) continue; } // q_id 38

						//if($val['name']=='Loss Run' && count($checkHidden)!=count($question_ids)) { continue; }
						if($val['name']=='Loss Run' && !isset($checkHidden['37']) ) { continue; }

						$y++;
						$i++;
						$getPercent = $this->getPercentage($val['id'], $contractor_id, $contractor_clients, $year);
						$val['getPerc'] = Number::toPercentage($getPercent, 0);
						$totalper = $totalper + $getPercent;
						$yearPer = $yearPer + $getPercent;
						$val['name'] = $val['name'].' - '.$year;
						$allCat[$parentcat['id']]['childrens'][$year]['cat'][] = $val;
					}
					$allCat[$parentcat['id']]['childrens'][$year]['getPerc'] =Number::toPercentage(($yearPer/$y), 0);
					}
					else {
						$childrens[0]['getPerc'] = Number::toPercentage(0, 0);
						$childrens[0]['name'] = $childrens[0]['name'].' - '.$year;
						$allCat[$parentcat['id']]['childrens'][$year]['cat'][] = $childrens[0];
						$allCat[$parentcat['id']]['childrens'][$year]['getPerc'] =Number::toPercentage(0, 0);
					}
				}
			}
		}				
		$allCat[$parentcat['id']]['getPerc'] = $i==0 ? Number::toPercentage(0, 0) : Number::toPercentage(($totalper/$i), 0); //safetly stat percentage		
		if($archive !== null) { // archived safety stat
			if($allCat[$parentcat['id']]['getPerc'] == '0%')
			{
				unset($allCat[$parentcat['id']]);
			}
		}
		
	}
	else {		
		$allCat[$parentcat['id']]['getPerc'] = Number::toPercentage($this->getPercentage($parentcat['id'], $contractor_id, $contractor_clients),0);		
	}	
	}	
	return $allCat;
    }

    public function getQuesCount($catid=null)
    {
	$this->ClientQuestions = TableRegistry::get('ClientQuestions');
	$get_questions = $this->ClientQuestions
	->find('all')
	->contain(['Questions'])
	->where(['Questions.category_id'=>$catid, 'Questions.active'=>true])
	->count();

	return $get_questions;
    }

    public function checkHidden($year=null, $question_ids=null,$contractor_id=null)
    {
	$this->ContractorAnswers = TableRegistry::get('ContractorAnswers');
	$query = $this->ContractorAnswers->find('list', ['keyField'=>'question_id', 'valueField'=>'answer'])->where(['question_id IN' =>$question_ids, 'year'=>$year, 'answer'=>'No', 'contractor_id'=>$contractor_id])->toArray();

	return $query;
    }

    public function getPercentage($cat_id=null, $contractor_id=null, $contractor_clients=null, $year=null) 
    {
	$this->ClientQuestions = TableRegistry::get('ClientQuestions');
	$this->ContractorAnswers = TableRegistry::get('ContractorAnswers');
	
	$ans_cnt = 0;
	$percent = 0;
		
	if($contractor_clients!=null)
	{
		$get_questions = $this->ClientQuestions
		->find('list', ['keyField'=>'question_id', 'valueField'=>'client_id' ])
		->contain(['Questions'])
		->where(['Questions.category_id'=>$cat_id, 'Questions.active'=>true,'ClientQuestions.client_id IN'=>$contractor_clients])
		->toArray();

		$questionIds = array_keys($get_questions);
		$question_cnt = count($questionIds);
		if(!empty($questionIds)) {
			$ans_cnt = $this->ContractorAnswers
			->find('all')
			->where(['contractor_id'=>$contractor_id, 'answer !='=>'',  'question_id IN'=>$questionIds, 'year IS'=>$year])
			->count();
		}

		if($question_cnt !=0) { 
		$percent = ($ans_cnt * 100) / $question_cnt;
		}
		if($cat_id == 4) {
		$ans_cnt = $this->ContractorAnswers->find('all')->where(['contractor_id'=>$contractor_id, 'answer'=>'No', 'question_id'=>17])->count();
		if($ans_cnt>0) { $percent = 100; }
		}
		elseif($cat_id == 5)  {
		$ans_cnt = $this->ContractorAnswers->find('all')->where(['contractor_id'=>$contractor_id, 'answer'=>'No', 'question_id'=>19])->count();
		if($ans_cnt>0) { $percent = 100; }
		}		
	}

	//return Number::toPercentage($percent, 0);								
	return $percent;								
    }

    public function getNextcat($categories=null, $category_id=null,$service_id=null,$year=null)
    {
	$catNext ='';
	if($categories!=null) {
		$catLoop = array();
		foreach($categories as $cats) {
			$quesCount = $this->getQuesCount($cats['id']);
			if($quesCount > 0){
				$catLoop[] = $service_id.'/'.$cats['id'];	
			}
			if(!empty($cats['childrens'])) {
			foreach($cats['childrens'] as $key=>$val) {
				foreach($val['cat'] as $subcat) {
				$cquesCount = $this->getQuesCount($subcat['id']);
				if($cquesCount > 0) {
					$catLoop[] = $service_id.'/'.$subcat['id'].'/'.$key;
				}
				}
			}
			}
		}

		$currentcatUrl = $service_id.'/'.$category_id;
		if($year!=null) { $currentcatUrl .= '/'.$year; }
		
		$catNext = array_search($currentcatUrl, $catLoop)+1;				
		if(end($catLoop) === $currentcatUrl) {
			$catNext = 'lastsubmit'; 
		}
		else {
			if(!empty($catLoop)) {$catNext = $catLoop[$catNext]; }
		}
	}
	return $catNext;
    }

    public function getExplanationsCount($contractor_id=null, $client_id=null) {
	$this->Explanations = TableRegistry::get('Explanations');

	$whereArr['contractor_id'] = $contractor_id;
	if($client_id!=null) { $whereArr['show_to_client'] = true; }

	$getcnt = $this->Explanations
	->find('all')
	->where($whereArr)
	->count();

	return $getcnt;
    }
}
?>
