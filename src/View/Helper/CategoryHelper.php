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
	$client_id = $this->getView()->getRequest()->getSession()->read('Auth.User.client_id');

	$this->ContractorServices = TableRegistry::get('ContractorServices');
	$this->Services = TableRegistry::get('Services');

	$whereArr['contractor_id'] = $contractor_id;
	if($client_id!=null) { $whereArr["client_ids->'c_ids' @> "] = '['.$client_id.']'; }

	$contractorServices = $this->ContractorServices
		->find('list', ['keyField'=>'id','valueField'=>'service_id'])
		->where($whereArr)
		->toArray();
		

	$services = [];
	if(!empty($contractorServices)) {
	$services = $this->Services
		->find('list',['keyField'=>'id','valueField'=>'name'])       
		//->select(['id','name'])
		/*->contain(['Categories'=>[
			'fields'=>['id','name','service_id'],
			'conditions'=>['active'=>true],
			'queryBuilder' => function ($q) { return $q->order(['category_order'=>'ASC', 'id'=>'ASC']); }
		] ])*/
		->where(['active'=>true, 'id IN'=>$contractorServices])
		->enableHydration(false)
		->order(['service_order'=>'ASC'])
		->toArray();
	}
	return $services;
    }

    public function yearRange($allyears=false,$archive=false)
    {
	$this->CanqYears = TableRegistry::get('CanqYears');

	if($allyears==true){
		$year = $this->CanqYears
			->find('list', ['keyField'=>'year','valueField'=>'year'])
			->order(['id'=>'ASC'])
			->enableHydration(false)
			->toArray();
	}
	elseif($archive==true)
	{		
		$subquery1 = $this->CanqYears->find('all', ['fields'=>['id']])->where(['status' =>'start'])->first();	
		$year = $this->CanqYears
			->find('list', ['keyField'=>'year','valueField'=>'year'])			
			->where(['id < ' .$subquery1->id])	
			->order(['year'=>'ASC'])
			->enableHydration(false)
			->toArray();				
		
	}
	else {
		$subquery1 = $this->CanqYears->find('all', ['fields'=>['id']])->where(['status' =>'start'])->first();
		$subquery2 = $this->CanqYears->find('all', ['fields'=>['id']])->where(['status' =>'end'])->first();
		$year = $this->CanqYears
			->find('list', ['keyField'=>'year','valueField'=>'year'])			
			->where(['id BETWEEN ' .$subquery1->id. ' AND'=>$subquery2->id])	
			->order(['id'=>'ASC'])
			->enableHydration(false)
			->toArray();
	}
	return $year;
    }
    public function getParentcat($activeUser=array(), $service_id=null, $parent_id=null, $archive=false)
    {		
	$this->Categories = TableRegistry::get('Categories');
	$this->ClientQuestions = TableRegistry::get('ClientQuestions');
	$contractor_id = $activeUser['contractor_id'];
	$contractor_clients = array();
	if($activeUser['role_id'] == CLIENT || $activeUser['role_id'] == CLIENT_ADMIN || $activeUser['role_id'] == CLIENT_VIEW) {
		$contractor_clients[0] = $activeUser['client_id'];
	}
	else {
		$contractor_clients = $this->User->getClients($contractor_id);
	}
	// get question categories
    $client_cat = array();
    $query = array();
    if(!empty($contractor_clients)) {
	    $client_cat = $this->ClientQuestions
		    ->find('list', ['keyField'=>'question.id', 'valueField'=>'question.category_id' ])
		    ->contain(['Questions'])
		    ->where(['Questions.active'=>true, 'ClientQuestions.client_id IN'=>$contractor_clients])
		    ->distinct('Questions.category_id')
		    ->toArray();
        $query = array();
	    if(!empty($client_cat)){
            $andWhere = ['Categories.active'=>true, 'Categories.category_id IS'=>$parent_id,'Categories.service_id'=>$service_id, 'Categories.id IN'=>$client_cat];
            if($archive) {
                $andWhere['Categories.year_based IS'] = true;
            }
            $andWhere2 = ['Categories.active'=>true, 'Categories.category_id IS'=>$parent_id,'Categories.service_id'=>$service_id, 'Categories.year_based IS'=>true];
            $andWhere3 = ['Categories.active'=>true, 'Categories.category_id IS'=>$parent_id,'Categories.service_id'=>$service_id, 'Categories.is_parent IS'=>true];
            $query = $this->Categories
                ->find('all', ['fields'=>['id','name','year_based', 'category_id']])
                ->contain(['Services'])
                ->contain(['Services.ClientServices'=>['conditions'=>['ClientServices.client_id IN'=>$contractor_clients]] ])
                ->where(['OR'=> ['AND'=> $andWhere,
                        $andWhere2,
                        $andWhere3
                    ]
                    ]
                )
                ->order(['category_order'=>'ASC', 'Categories.id'=>'ASC'])
                ->enableHydration(false)
                ->toArray();
		}

		if($parent_id==null && !empty($query)){
		foreach ($query as $key => $value) {			
		$quesCount = $this->getParentQuesCount($value['id'],$contractor_clients);
        $sub_cat = $this->Categories
         ->find('all', ['fields'=>['id','name','year_based', 'category_id']]) 
         ->where(['category_id'=>$value['id'],'Categories.id IN'=>$client_cat])
         ->contain(['Services'])
         ->enableHydration(false)
         ->toArray();
		if(empty($quesCount) && $sub_cat ==null ) {
			 unset($query[$key]);
			}
		}}}
	//pr($query);die;
	return $query;	
    }
	public function getParentQuesCount($catid=null,$contractor_clients=array())
	{
		$this->ClientQuestions = TableRegistry::get('ClientQuestions');
		$get_questions = "";
		if(!empty($contractor_clients)){
		$get_questions = $this->ClientQuestions
		->find('all')
		->contain(['Questions'])
		->where(['Questions.category_id'=>$catid, 'Questions.active'=>true,'ClientQuestions.is_compulsory'=>true ,'ClientQuestions.client_id IN '=>$contractor_clients])
		->count();
		}
		return $get_questions;
	}
   /* public function getCategories($activeUser=array(), $service_id=null, $archive=false)
    {			
	$this->ContractorAnswers = TableRegistry::get('ContractorAnswers');
	$this->Clients = TableRegistry::get('Clients');
	$year_range = array_reverse($this->yearRange(false, $archive));
	$contractor_id = $activeUser['contractor_id'];
	
	if($archive==true && $activeUser['role_id'] == CONTRACTOR)
	{
		$cont_ans[] = '';
		$archive_year[] = '';
		$archive_year_range[] = array_reverse($this->yearRange(false, $archive));	
		foreach($archive_year_range as $archive_year)
		{
			foreach($archive_year as $year){
			$cont_ans = $this->ContractorAnswers
					->find('all')								
					->where(['contractor_id'=>$contractor_id, 'answer !='=>'','year IS'=>$year])
					->count();}
		}	
		if($cont_ans<=0)
		{
			$year_range = array_diff($year_range,$archive_year);
		}	
	}	

	$contractor_clients = array();
	if($activeUser['role_id'] == CLIENT || $activeUser['role_id'] == CLIENT_ADMIN || $activeUser['role_id'] == CLIENT_VIEW) {
		$contractor_clients[0] = $activeUser['client_id'];
	}
	else {
		$contractor_clients = $this->User->getClients($contractor_id);
	}
	$parentcatall = $this->getParentcat($activeUser, $service_id, null, $archive);
	$allCat = array();
	
	foreach($parentcatall as $parentcat) {	
	$allCat[$parentcat['id']] = $parentcat;	
	
	if($parentcat['year_based'] == true) {
		$totalper = 0;
		$i = 0;
		foreach($year_range as $year) {			
			$yearPer = 0;
			$y = 0;

			$allCat[$parentcat['id']]['getPerc'] = $this->setPercentage($parentcat['id'], $contractor_id, $contractor_clients, $year);

			$childrens = $this->getParentcat($activeUser, $service_id, $parentcat['id']);
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
						$getPercent = $this->setPercentage($val['id'], $contractor_id, $contractor_clients, $year);
						$val['getPerc'] = Number::toPercentage($getPercent, 0);
						$totalper = $totalper + $getPercent;

						$yearPer = $yearPer + $getPercent;
						//$val['name'] = $val['name'].' - '.$year;
						$allCat[$parentcat['id']]['childrens'][$year]['cat'][$val['id']] = $val;
					}
					$yearPercentage = Number::toPercentage(($yearPer/$y), 0);
					}
					else { // if General Information not submitted
						$childrens[0]['getPerc'] = Number::toPercentage(0, 0);
						$allCat[$parentcat['id']]['childrens'][$year]['cat'][$childrens[0]['id']] = $childrens[0];

						$yearPercentage = Number::toPercentage(0, 0);
						$i++;
					}

                    // year avg percentage
					$allCat[$parentcat['id']]['childrens'][$year]['getPerc'] = $yearPercentage;
				}				
			}
		}
        // SafetyQUAL Cat avg percentage
		$allCat[$parentcat['id']]['getPerc'] = $i==0 ? Number::toPercentage(0, 0) : Number::toPercentage(($totalper/$i), 0);

	}
	else {
        $totalcper = 0;
        $k = 0;
		// get child categories
		$childrens = $this->getParentcat($activeUser, $service_id, $parentcat['id']);	
        if(!empty($childrens)){
		foreach($childrens as $val) {
			$allCat[$parentcat['id']]['child'][$val['id']] = $val;
			$allCat[$parentcat['id']]['child'][$val['id']]['getPerc'] = Number::toPercentage($this->setPercentage($val['id'], $contractor_id, $contractor_clients), 0);
              $k++;
			  $getPercent = $this->setPercentage($val['id'], $contractor_id, $contractor_clients);
			  $totalcper = $totalcper + $getPercent;
		}
        // all parent categories		
		$allCat[$parentcat['id']]['getPerc'] = $k==0 ? Number::toPercentage(0, 0) : Number::toPercentage(($totalcper/$k), 0);
        }
        else {
        $allCat[$parentcat['id']]['getPerc'] = Number::toPercentage($this->setPercentage($parentcat['id'], $contractor_id, $contractor_clients),0);
        }        
	}
	}
	return $allCat;
    }
*/
    public function getCategories($activeUser=array(), $service_id=null, $archive=false)
    {			
	$this->ContractorAnswers = TableRegistry::get('ContractorAnswers');
	$this->Clients = TableRegistry::get('Clients');
	$year_range = array_reverse($this->yearRange(false, $archive));
	$contractor_id = $activeUser['contractor_id'];
	$current_year = date("Y"); 
	
	if($archive==true && $activeUser['role_id'] == CONTRACTOR)
	{
		$cont_ans[] = '';
		$archive_year[] = '';
		$archive_year_range[] = array_reverse($this->yearRange(false, $archive));	
		foreach($archive_year_range as $archive_year)
		{
			foreach($archive_year as $year){
			$cont_ans = $this->ContractorAnswers
					->find('all')								
					->where(['contractor_id'=>$contractor_id, 'answer !='=>'','year IS'=>$year])
					->count();}
		}	
		if($cont_ans<=0)
		{
			$year_range = array_diff($year_range,$archive_year);
		}	
	}	

	$contractor_clients = array();
	if($activeUser['role_id'] == CLIENT || $activeUser['role_id'] == CLIENT_ADMIN || $activeUser['role_id'] == CLIENT_VIEW) {
		$contractor_clients[0] = $activeUser['client_id'];
	}
	else {
		$contractor_clients = $this->User->getClients($contractor_id);
	}
	$parentcatall = $this->getParentcat($activeUser, $service_id, null, $archive);
	$allCat = array();
	
	foreach($parentcatall as $parentcat) {	
	$allCat[$parentcat['id']] = $parentcat;	
	
	if($parentcat['year_based'] == true) {
		$totalper = 0;
		$i = 0;
		foreach($year_range as $year) {			
			$yearPer = 0;
			$y = 0;
			$yearPercentage = Number::toPercentage(0, 0);

			$allCat[$parentcat['id']]['getPerc'] = $this->getPercentage($parentcat['id'], $contractor_id, $contractor_clients, $year);

			$childrens = $this->getParentcat($activeUser, $service_id, $parentcat['id']);
					
			if(!empty($childrens)) { 
				/* set to return General Information,OSHA,EMR,Citations,Loss Run Covid-19*/
				$depChildrens = array_slice($childrens,0,6);
				// set to return rest of above categories.
				$otherChildrens = array_slice($childrens,6);
				$question_ids = array(36, 37, 38,460);

				$checkHidden = $this->checkHidden($year, $question_ids,$contractor_id);
				
				/* Categories are Dependent on Genenral Information */
				if($childrens[0]['name']=="General Information") {
					$totalsubmit = $this->ContractorAnswers
					->find('all')
					->contain(['Questions'])				
					->where(['contractor_id'=>$contractor_id, 'answer !='=>'', 'Questions.category_id'=>$childrens[0]['id'],'year IS'=>$year])
					->count();

					if($totalsubmit > 0) {
					foreach($depChildrens as $val) { 
						if($val['name']=="OSHA") { if(!isset($checkHidden['36']) || $checkHidden['36']=='No') continue; } // q_id 36
						elseif($val['name']=="EMR") { if(!isset($checkHidden['37']) || $checkHidden['37']=='No')  continue; } // q_id 37
						elseif($val['name']=="Citations") { if(!isset($checkHidden['38']) || $checkHidden['38']=='No')  continue; } // q_id 38
						elseif($val['name']=="Covid-19") { if(!isset($checkHidden['460']) || $checkHidden['460']=='No')  continue; }
    					//if($val['name']=='Loss Run' && count($checkHidden)!=count($question_ids)) { continue; }
						if($val['name']=='Loss Run'){ if(!isset($checkHidden['37'])||$checkHidden['37']=='Yes' ) continue; }
						/* When Set Year Range for Year Based Categories */
						$getYearRange = $this->getYearRange($val['id'],$service_id);
						if(!empty($getYearRange['from_year'] && $getYearRange['to_year']) ){
							$get_Years = range($getYearRange['from_year'], $getYearRange['to_year']);
							if(!in_array($year, $get_Years)){ continue; }				
						}
						$y++;
						$i++;
						$getPercent = $this->getPercentage($val['id'], $contractor_id, $contractor_clients, $year);
						$val['getPerc'] = Number::toPercentage($getPercent, 0);
						$totalper = $totalper + $getPercent;

						$yearPer = $yearPer + $getPercent;
						//$val['name'] = $val['name'].' - '.$year;
						$allCat[$parentcat['id']]['childrens'][$year]['cat'][$val['id']] = $val;
					}
					//$yearPercentage = Number::toPercentage(($yearPer/$y), 0);
					}
					else { // if General Information not submitted
						$childrens[0]['getPerc'] = Number::toPercentage(0, 0);
						$allCat[$parentcat['id']]['childrens'][$year]['cat'][$childrens[0]['id']] = $childrens[0];
						$y++;
						//$yearPercentage = Number::toPercentage(0, 0);
						$i++;
					}

				}
				/* categories are not dependent on general information*/
				if(!empty($otherChildrens)){
					foreach($otherChildrens as $val) {					
						/* When Set Year Range for Year Based Categories */
						$getYearRange = $this->getYearRange($val['id'],$service_id);
						if(!empty($getYearRange['from_year'] && $getYearRange['to_year']) ){
							$get_Years = range($getYearRange['from_year'], $getYearRange['to_year']);
							if(!in_array($year, $get_Years)){ continue; }				
						}
						$y++;
						$i++;
						$getPercent = $this->getPercentage($val['id'], $contractor_id, $contractor_clients, $year);
						$val['getPerc'] = Number::toPercentage($getPercent, 0);
						$totalper = $totalper + $getPercent;

						$yearPer = $yearPer + $getPercent;
						//$val['name'] = $val['name'].' - '.$year;
						$allCat[$parentcat['id']]['childrens'][$year]['cat'][$val['id']] = $val;
					}
				}
				if($y !=0){
				$yearPercentage = Number::toPercentage(($yearPer/$y), 0);
				}
                 // year avg percentage
				$allCat[$parentcat['id']]['childrens'][$year]['getPerc'] = $yearPercentage;			
			}
		}
        // SafetyQUAL Cat avg percentage
		$allCat[$parentcat['id']]['getPerc'] = $i==0 ? Number::toPercentage(0, 0) : Number::toPercentage(($totalper/$i), 0);
	}
	else {
        $totalcper = 0;
        $k = 0;
		// get child categories
		$childrens = $this->getParentcat($activeUser, $service_id, $parentcat['id']);	
        if(!empty($childrens)){
         /* Calculate Parent Category Percentage + Children Categories Percentage*/
         $getParentPercent = $this->getPercentage($parentcat['id'], $contractor_id, $contractor_clients);         
        if(!empty($getParentPercent)){
        	$totalcper = $getParentPercent;
        	$k++;
    	}
		foreach($childrens as $val) {
			$allCat[$parentcat['id']]['child'][$val['id']] = $val;
			$allCat[$parentcat['id']]['child'][$val['id']]['getPerc'] = Number::toPercentage($this->getPercentage($val['id'], $contractor_id, $contractor_clients), 0);
              $k++;
			  $getPercent = $this->getPercentage($val['id'], $contractor_id, $contractor_clients);
			  $totalcper = $totalcper + $getPercent;
		}
        // all parent categories		
		$allCat[$parentcat['id']]['getPerc'] = $k==0 ? Number::toPercentage(0, 0) : Number::toPercentage(($totalcper/$k), 0);
        }
        else {
        $allCat[$parentcat['id']]['getPerc'] = Number::toPercentage($this->getPercentage($parentcat['id'], $contractor_id, $contractor_clients),0);
        }
	}
	}	
	return $allCat;
    }

    public function checkHidden($year=null, $question_ids=null,$contractor_id=null)
    {
	$this->ContractorAnswers = TableRegistry::get('ContractorAnswers');
	$query = $this->ContractorAnswers->find('list', ['keyField'=>'question_id', 'valueField'=>'answer'])->where(['question_id IN' =>$question_ids, 'year'=>$year,'contractor_id'=>$contractor_id])->toArray();

	return $query;
    }
    public function getYearRange($cat_id =null,$service_id=null){
    	$this->Categories = TableRegistry::get('Categories');
    	$year_range = $this->Categories
	    ->find('all', ['fields'=>['id','name','from_year','to_year']])	
	    ->where(['id'=>$cat_id,'service_id'=>$service_id])
	    ->first();

	    return $year_range;		
	   
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

	public function checkAns($question_id=null,$contractor_id=null,$curYear=null)
    {
	$this->ContractorAnswers = TableRegistry::get('ContractorAnswers');
	$ans=array();
	$conAns = $this->ContractorAnswers->find('list', ['keyField'=>'id', 'valueField'=>'answer'])
       				->where(['ContractorAnswers.question_id '=>$question_id,'answer NOT LIKE'=>"",'ContractorAnswers.contractor_id'=>$contractor_id,'year'=>$curYear])
       				//->contain(['Questions.Categories'])
					//->order(['ContractorAnswers.id'=>'ASC'])
       				->toArray();
	foreach ($conAns as $date) {
		$ans[] = date('Y-m-d', strtotime($date));
	}
	return $ans;
    }
  public function getPercentage($category_id=null, $contractor_id=null, $contractor_clients=array(), $year=null)
    {
	$this->ClientQuestions = TableRegistry::get('ClientQuestions');
    $this->ContractorAnswers = TableRegistry::get('ContractorAnswers');
    $this->Categories = TableRegistry::get('Categories');
	
	$percent = $ques_cnt = $ans_cnt = 0;

	if($year==0) { $year=null; }

    if($year ==null){
     // Regualar Quesiton 
    $questionIds  = $this->ClientQuestions
		    ->find('list', ['keyField'=>'question.id', 'valueField'=>'question.id'])
		    ->contain(['Questions'])
		    ->where(['Questions.active'=>true, 'ClientQuestions.client_id IN'=>$contractor_clients,'Questions.is_parent'=>false,'ClientQuestions.is_compulsory'=>true,'Questions.question_id IS'=>null,'Questions.client_based'=>false,'Questions.category_id'=>$category_id])
		    ->toArray();
			
       $ans_cnt += count($this->getAnswers($questionIds,$contractor_id));
       $ques_cnt += count($questionIds);

      // Client Based Quesiton 
      foreach ($contractor_clients as $key => $value) {
      	
       $questionIds2 = $this->ClientQuestions
		    ->find('list', ['keyField'=>'ClientQuestions.id', 'valueField'=>'question.id'])
		    ->contain(['Questions'])
		    ->where(['Questions.active'=>true, 'ClientQuestions.client_id'=>$value,'ClientQuestions.is_compulsory'=>true,'Questions.client_based'=>true,'Questions.category_id'=>$category_id])
		    ->toArray();

		   $ans_cnt += count($this->getAnswers($questionIds2,$contractor_id,$value));
		   $ques_cnt += count($questionIds2);
         }
         
        // Dependend Question
          $questionIds3  = $this->ClientQuestions            
		    ->find('list', ['keyField'=>'question.id', 'valueField'=>'question.id'])
		    ->contain(['Questions'])
		    ->where(['Questions.active'=>true,'ClientQuestions.is_compulsory'=>true ,'ClientQuestions.client_id IN'=>$contractor_clients,'Questions.category_id'=>$category_id,
		     'Questions.is_parent' => true,'Questions.question_id IS' => null])
		    ->toArray();

            $parent_ans = $this->getAnswers($questionIds3,$contractor_id);

            $ques_cnt += count($questionIds3); 
            $ans_cnt += count($parent_ans);
            foreach ($parent_ans as $key => $value) {
                $s = $this->getDependQues(array($key=>$value),$contractor_clients,$contractor_id);

                foreach ($s as $k => $v) {
                	$ans_cnt += count($v['ans']);
                	$ques_cnt += count($v['ques']);
                }
            }

        //Dependent without parent question
        $where = ['Questions.active'=>true, 'Questions.category_id'=>$category_id, 'Questions.is_parent' => true, 'Questions.question_id IS' => null];
        if(!empty($questionIds3)) {
            $where['Questions.id NOT IN'] = $questionIds3;
        }

          $questionIds5  = $this->ClientQuestions            
		    ->find('list', ['keyField'=>'question.id', 'valueField'=>'question.id'])
		    ->contain(['Questions'])
		    ->where([$where])
		    ->toArray();
           
            if(!empty($questionIds5)) {
            foreach ($questionIds5 as $key) {
                $s = $this->getDependQues(array($key=>null),$contractor_clients,$contractor_id);
               
                foreach ($s as $k => $v) {
                	$ans_cnt += count($v['ans']);
                	$ques_cnt += count($v['ques']);
                }
             } 
            }    

            if($ques_cnt == 0){
                $percent = 0;
            }else{
            	$percent =  $percent = ($ans_cnt * 100) / $ques_cnt;
            }
          
            
        } else{
    	//  Year based Question
			/*who are parent only*/
	       $questionIds4 = $this->ClientQuestions
			    ->find('list', ['keyField'=>'question.id', 'valueField'=>'question.id'])
			    ->contain(['Questions'])
			    ->where(['Questions.is_parent' => true, 'Questions.question_id is'=>null, 'Questions.active'=>true, 'ClientQuestions.client_id IN'=>$contractor_clients,'ClientQuestions.is_compulsory'=>true,'Questions.category_id'=>$category_id])
			    ->toArray();
			if(in_array(460, $questionIds4) && $year < 2020){   
				unset($questionIds4[460]); 
			} //safetyQual covid-19 question
        		$parent_ans_year = $this->getAnswers($questionIds4,$contractor_id,null,$year);
			   $ans_cnt += count($parent_ans_year);
			   $ques_cnt += count($questionIds4);

			   /*children*/
			foreach ($parent_ans_year as $key => $value) {
				$s = $this->getDependQues(array($key=>$value),$contractor_clients,$contractor_id);

				foreach ($s as $k => $v) {
					$ans_cnt += count($v['ans']);
					$ques_cnt += count($v['ques']);
				}
			}

        /*who are not parents and not children*/
        $questionIds_npnc = $this->ClientQuestions
            ->find('list', ['keyField'=>'question.id', 'valueField'=>'question.id'])
            ->contain(['Questions'])
            ->where(['Questions.is_parent' => false, 'Questions.question_id is'=>null, 'Questions.active'=>true, 'ClientQuestions.client_id IN'=>$contractor_clients,'ClientQuestions.is_compulsory'=>true,'Questions.category_id'=>$category_id])
            ->toArray();
        if(in_array(460, $questionIds_npnc) && $year < 2020){
            unset($questionIds_npnc[460]);
        } //safetyQual covid-19 question

        $ans_cnt += count($this->getAnswers($questionIds_npnc,$contractor_id,null,$year));
        $ques_cnt += count($questionIds_npnc);

			 /*final %*/
            if($ques_cnt == 0){
                $percent = -1;
            }else{
			$percent =  $percent = ($ans_cnt * 100) / $ques_cnt;
            }
     }
	return $percent;								
    }
    public function getDependQues($questionAns=array(),$client_ids=null,$contractor_id=null,&$dependend=array(),$i=0){
    	$i++;
	   $where = [];       
		foreach ($questionAns as $key => $value) {
         if(!empty($value)){
			$where['OR'][] = ['Questions.active'=>true,'ClientQuestions.is_compulsory'=>true ,'ClientQuestions.client_id IN'=>$client_ids,'Questions.parent_option'=>$value,'Questions.question_id'=>$key];
		}else{
            $where['OR'][] = ['Questions.active'=>true,'ClientQuestions.is_compulsory'=>true ,'ClientQuestions.client_id IN'=>$client_ids,'Questions.question_id'=>$key];}
        }
        
        $child_ques = $this->ClientQuestions            
		    ->find('list', ['keyField'=>'question.id', 'valueField'=>'question.id'])
		    ->contain(['Questions'])
		    ->where($where)
		    ->toArray();

	  	if(!empty($child_ques)){
			   	$child_ans = $this->getAnswers($child_ques,$contractor_id);
			   	$dependend[$i]['ques'] = $child_ques;
				$dependend[$i]['ans'] = $child_ans;
				if(!empty($child_ans)) {					
                	$this->getDependQues($child_ans,$client_ids,$contractor_id,$dependend, $i);
                }
                else {
                	//pr($dependend);
					return $dependend;
                }
                return $dependend;
	    }	
	    else {
	    	// pr($dependend);
	    	return $dependend;
        }        
    } 
    public function getAnswers($questionIds= array(),$contractor_id=null,$client_id=null,$year=null){
		     $answer = array();		    
		     if(!empty($questionIds)) {
						    $answer = $this->ContractorAnswers						    
						    ->find('list',['keyField'=>'question_id','valueField'=>'answer'])
						    ->where(['contractor_id'=>$contractor_id, 'answer !='=>'',  'question_id IN'=>$questionIds,'client_id IS'=>$client_id,'year IS'=>$year])
						    ->toArray();
						     //pr($answer);
		      }
		      return $answer;
        }
  public function getNextcat($categories=null, $category_id=null,$service_id=null,$year=null,$contractor_id=null)
    {
	$catNext ='';
	if($categories!=null) { 
		$catLoop = array();
		foreach($categories as $cats) {
			if(!empty($cats['child'])) { 
				$cats[]=array();
				$client = $this->User->getClients($contractor_id);
				$quesCount = $this->getParentQuesCount($cats['id'],$client);
				if($quesCount==0){
					$cats = array_values($cats['child']); 				
					if(!empty($cats)){
					foreach($cats as $cat) { 
						$quesCount = $this->getQuesCount($cat['id']);
						if($quesCount > 0){
						$catLoop[] = $service_id.'/'.$cat['id'];	
						}	
					}}continue;
				}
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
			}elseif(!empty($cats['clients'])) {
			foreach($cats['clients'] as $key=>$val) {				
				$cquesCount = $this->getQuesCount($val['id']);
				if($cquesCount > 0) {
					$catLoop[] = $service_id.'/'.$val['id'].'/'.$key;				
				}
			}
			}
			else{				
			$quesCount = $this->getQuesCount($cats['id']);
				if($quesCount > 0){
					$catLoop[] = $service_id.'/'.$cats['id'];	
				}
			}
			if(!empty($cats['child'])) {
			foreach($cats['child'] as $key=>$subcat) {
				$cquesCount = $this->getQuesCount($subcat['id']);
				if($cquesCount > 0) {
					$catLoop[] = $service_id.'/'.$key;				
				}
			}
			}
			
		}
        // pr($catLoop);
		$currentcatUrl = $service_id.'/'.$category_id;
		if($year!=null) { $currentcatUrl .= '/'.$year; }
		if(!in_array($currentcatUrl,$catLoop) && !empty($catLoop)) {
			$catNext = $catLoop[0];
		}
		else {
			$catNext = array_search($currentcatUrl, $catLoop)+1;
		}

		if(end($catLoop) == $currentcatUrl) {
			$catNext = 'lastsubmit'; 
		}
		else {
			if(!empty($catLoop[$catNext])) {$catNext = $catLoop[$catNext]; }
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
    public function getServiceCategories($activeUser=array(), $service_id=null, $archive=false)
    {
	$this->ContractorAnswers = TableRegistry::get('ContractorAnswers');
	$this->Clients = TableRegistry::get('Clients');
	$year_range = array_reverse($this->yearRange(false, $archive));

	$contractor_id = $activeUser['contractor_id'];
	$contractor_clients = array();
	if($activeUser['role_id'] == CLIENT || $activeUser['role_id'] == CLIENT_ADMIN || $activeUser['role_id'] == CLIENT_VIEW) {
		$contractor_clients[0] = $activeUser['client_id'];
	}
	else {
		$contractor_clients = $this->User->getClients($contractor_id);
	}
	$parentcatall = $this->getParentcat($activeUser, $service_id, null, $archive);
	$allCat = array();

	foreach($parentcatall as $parentcat) {	
	$allCat[$parentcat['id']] = $parentcat;	
	
	if($parentcat['year_based'] == true) {
		foreach($year_range as $year) {
			$childrens = $this->getParentcat($activeUser, $service_id, $parentcat['id']);
			if(!empty($childrens)) {
				$question_ids = array(36, 37, 38,460);

				$checkHidden = $this->checkHidden($year, $question_ids,$contractor_id);
				if($childrens[0]['name']=="General Information") {
					$totalsubmit = $this->ContractorAnswers
					->find('all')
					->contain(['Questions'])				
					->where(['contractor_id'=>$contractor_id, 'answer !='=>'', 'Questions.category_id'=>$childrens[0]['id'],'year IS'=>$year])
					->count();

					if($totalsubmit > 0) {
					foreach($childrens as $val) {
						if($val['name']=="OSHA") { if(!isset($checkHidden['36']) || $checkHidden['36']=='No') continue; } // q_id 36
						elseif($val['name']=="EMR") { if(!isset($checkHidden['37']) || $checkHidden['37']=='No')  continue; } // q_id 37
						elseif($val['name']=="Citations") { if(!isset($checkHidden['38']) || $checkHidden['38']=='No')  continue; } // q_id 38
						elseif($val['name']=="Covid-19") { if(!isset($checkHidden['460']) || $checkHidden['460']=='No')  continue; }
    					//if($val['name']=='Loss Run' && count($checkHidden)!=count($question_ids)) { continue; }
						if($val['name']=='Loss Run'){ if(!isset($checkHidden['37'])||$checkHidden['37']=='Yes' ) continue; }

						/* When Set Year Range for Year Based Categories */
						$getYearRange = $this->getYearRange($val['id'],$service_id);
						if(!empty($getYearRange['from_year'] && $getYearRange['to_year']) ){
							$get_Years = range($getYearRange['from_year'], $getYearRange['to_year']);
							if(!in_array($year, $get_Years)){ continue; }				
						}
						
						$allCat[$parentcat['id']]['childrens'][$year]['cat'][$val['id']] = $val;
					}
					}
					else { // if General Information not submitted
						$allCat[$parentcat['id']]['childrens'][$year]['cat'][$childrens[0]['id']] = $childrens[0];
					}
				}				
			}
		}
	}
	else {
		// get child categories
		$childrens = $this->getParentcat($activeUser, $service_id, $parentcat['id']);	
        if(!empty($childrens)){
		foreach($childrens as $val) {
			$allCat[$parentcat['id']]['child'][$val['id']] = $val;
		}
        }
	}
	}
	return $allCat;
    }
	
    public function getBenchmarkCategories($client_id=null){
    	$this->BenchmarkCategories = TableRegistry::get('BenchmarkCategories');
    	$benchmarkcategories = $this->BenchmarkCategories
    		->find('list',['keyField'=>'id','valueField'=>'name'])
			->where(['client_id'=>$client_id])
    		->toArray();
    	return $benchmarkcategories;
    }
    /*  public function getInsCategories($activeUser=array(), $service_id=null, $archive=false)
    {			
	$this->ContractorAnswers = TableRegistry::get('ContractorAnswers');
	$this->Clients = TableRegistry::get('Clients');
	$year_range = Configure::read('insure_years');
	$contractor_id = $activeUser['contractor_id'];
	
	if($archive==true && $activeUser['role_id'] == CONTRACTOR)
	{
		$cont_ans[] = '';
		$archive_year[] = '';
		$archive_year_range[] = array_reverse($this->yearRange(false, $archive));	
		foreach($archive_year_range as $archive_year)
		{
			foreach($archive_year as $year){
			$cont_ans = $this->ContractorAnswers
					->find('all')								
					->where(['contractor_id'=>$contractor_id, 'answer !='=>'','year IS'=>$year])
					->count();}
		}	
		if($cont_ans<=0)
		{
			$year_range = array_diff($year_range,$archive_year);
		}	
	}	

	$contractor_clients = array();
	if($activeUser['role_id'] == CLIENT || $activeUser['role_id'] == CLIENT_ADMIN || $activeUser['role_id'] == CLIENT_VIEW) {
		$contractor_clients[0] = $activeUser['client_id'];
	}
	else {
		$contractor_clients = $this->User->getClients($contractor_id);
	}
	$parentcatall = $this->getParentcat($activeUser, $service_id, null, $archive);
	$allCat = array();
	
	foreach($parentcatall as $parentcat) {	
	$allCat[$parentcat['id']] = $parentcat;	// add array for the insureQual
	
	if($parentcat['year_based'] == true) {
		$totalper = 0;
		$i = 0;
		foreach($year_range as $year) {			
			$yearPer = 0;
			$y = 0;

			$allCat[$parentcat['id']]['getPerc'] = $this->setPercentage($parentcat['id'], $contractor_id, $contractor_clients, $year);

			$childrens = $this->getParentcat($activeUser, $service_id, $parentcat['id']);
			if(!empty($childrens)) {
				$question_ids = array(36, 37, 38);

				if($childrens[0]['name']=="General Liability") {
					$totalsubmit = $this->ContractorAnswers
					->find('all')
					->contain(['Questions'])				
					->where(['contractor_id'=>$contractor_id, 'answer !='=>'', 'Questions.category_id'=>$childrens[0]['id'],'year IS'=>$year])
					->count();

					if($totalsubmit > 0) {
					foreach($childrens as $val) {
						$y++;
						$i++;
						$getPercent = $this->setPercentage($val['id'], $contractor_id, $contractor_clients, $year);
						$val['getPerc'] = Number::toPercentage($getPercent, 0);
						$totalper = $totalper + $getPercent;

						$yearPer = $yearPer + $getPercent;
						//$val['name'] = $val['name'].' - '.$year;
						$allCat[$parentcat['id']]['childrens'][$year]['cat'][$val['id']] = $val;
					}
					$yearPercentage = Number::toPercentage(($yearPer/$y), 0);
					}
					else { // if General Information not submitted
						// $childrens[0]['getPerc'] = Number::toPercentage(0, 0);
						// $allCat[$parentcat['id']]['childrens'][$year]['cat'][$childrens[0]['id']] = $childrens[0];

						// $yearPercentage = Number::toPercentage(0, 0);
						// $i++;
						foreach($childrens as $val) {
						$y++;
						$i++;
						$getPercent = $this->setPercentage($val['id'], $contractor_id, $contractor_clients, $year);
						$val['getPerc'] = Number::toPercentage($getPercent, 0);
						$totalper = $totalper + $getPercent;

						$yearPer = $yearPer + $getPercent;
						//$val['name'] = $val['name'].' - '.$year;
						$allCat[$parentcat['id']]['childrens'][$year]['cat'][$val['id']] = $val;
						}
						$yearPercentage = Number::toPercentage(($yearPer/$y), 0);
	
					}

                    // year avg percentage
					$allCat[$parentcat['id']]['childrens'][$year]['getPerc'] = $yearPercentage;
				}				
			}
		}
        // SafetyQUAL Cat avg percentage
		$allCat[$parentcat['id']]['getPerc'] = $i==0 ? Number::toPercentage(0, 0) : Number::toPercentage(($totalper/$i), 0);
	}
	else {
        $totalcper = 0;
        $k = 0;
		// get child categories
		$childrens = $this->getParentcat($activeUser, $service_id, $parentcat['id']);	
        if(!empty($childrens)){
		foreach($childrens as $val) {
			$allCat[$parentcat['id']]['child'][$val['id']] = $val;
			$allCat[$parentcat['id']]['child'][$val['id']]['getPerc'] = Number::toPercentage($this->setPercentage($val['id'], $contractor_id, $contractor_clients), 0);
              $k++;
			  $getPercent = $this->setPercentage($val['id'], $contractor_id, $contractor_clients);
			  $totalcper = $totalcper + $getPercent;
		}
        // all parent categories		
		$allCat[$parentcat['id']]['getPerc'] = $k==0 ? Number::toPercentage(0, 0) : Number::toPercentage(($totalcper/$k), 0);
        }
        else {
        $allCat[$parentcat['id']]['getPerc'] = Number::toPercentage($this->setPercentage($parentcat['id'], $contractor_id, $contractor_clients),0);
        }
	}
	}
	return $allCat;
    }
    */
    public function getInsCategories($activeUser=array(), $service_id=null, $archive=false)
    {			
	$this->ContractorAnswers = TableRegistry::get('ContractorAnswers');
	$this->Clients = TableRegistry::get('Clients');
	$year_range = Configure::read('insure_years');
	$contractor_id = $activeUser['contractor_id'];
	
	if($archive==true && $activeUser['role_id'] == CONTRACTOR)
	{
		$cont_ans[] = '';
		$archive_year[] = '';
		$archive_year_range[] = array_reverse($this->yearRange(false, $archive));	
		foreach($archive_year_range as $archive_year)
		{
			foreach($archive_year as $year){
			$cont_ans = $this->ContractorAnswers
					->find('all')								
					->where(['contractor_id'=>$contractor_id, 'answer !='=>'','year IS'=>$year])
					->count();}
		}	
		if($cont_ans<=0)
		{
			$year_range = array_diff($year_range,$archive_year);
		}	
	}
        $maxYear = (count($year_range) - 1);
        $addYear = $year_range[$maxYear];
        if($addYear <= date('Y'))
        {$year_range[] = $addYear;}

	$contractor_clients = array();
	if($activeUser['role_id'] == CLIENT || $activeUser['role_id'] == CLIENT_ADMIN || $activeUser['role_id'] == CLIENT_VIEW) {
		$contractor_clients[0] = $activeUser['client_id'];
	}
	else {
		$contractor_clients = $this->User->getClients($contractor_id);
	}
	$parentcatall = $this->getParentcat($activeUser, $service_id, null, $archive);
	$allCat = array();
	
	foreach($parentcatall as $parentcat) {	
	$allCat[$parentcat['id']] = $parentcat;	// add array for the insureQual
	
	if($parentcat['year_based'] == true) {
		$totalper = 0;
		$i = 0;
		foreach($year_range as $year) {			
			$yearPer = 0;
			$y = 0;

			$allCat[$parentcat['id']]['getPerc'] = $this->getPercentage($parentcat['id'], $contractor_id, $contractor_clients, $year);

			$childrens = $this->getParentcat($activeUser, $service_id, $parentcat['id']);
			if(!empty($childrens)) {
				$question_ids = array(36, 37, 38);

				if($childrens[0]['name']=="General Liability") {
					$totalsubmit = $this->ContractorAnswers
					->find('all')
					->contain(['Questions'])				
					->where(['contractor_id'=>$contractor_id, 'answer !='=>'', 'Questions.category_id'=>$childrens[0]['id'],'year IS'=>$year])
					->count();

					if($totalsubmit > 0) {
					foreach($childrens as $val) {
						$y++;
						$i++;
						$getPercent = $this->getPercentage($val['id'], $contractor_id, $contractor_clients, $year);
						$val['getPerc'] = Number::toPercentage($getPercent, 0);
						$totalper = $totalper + $getPercent;

						$yearPer = $yearPer + $getPercent;
						//$val['name'] = $val['name'].' - '.$year;
						$allCat[$parentcat['id']]['childrens'][$year]['cat'][$val['id']] = $val;
					}
					$yearPercentage = Number::toPercentage(($yearPer/$y), 0);
					}
					else { // if General Information not submitted
						// $childrens[0]['getPerc'] = Number::toPercentage(0, 0);
						// $allCat[$parentcat['id']]['childrens'][$year]['cat'][$childrens[0]['id']] = $childrens[0];

						// $yearPercentage = Number::toPercentage(0, 0);
						// $i++;
						foreach($childrens as $val) {
						$y++;
						$i++;
						$getPercent = $this->getPercentage($val['id'], $contractor_id, $contractor_clients, $year);
						$val['getPerc'] = Number::toPercentage($getPercent, 0);
						$totalper = $totalper + $getPercent;

						$yearPer = $yearPer + $getPercent;
						//$val['name'] = $val['name'].' - '.$year;
						$allCat[$parentcat['id']]['childrens'][$year]['cat'][$val['id']] = $val;
						}
						$yearPercentage = Number::toPercentage(($yearPer/$y), 0);
	
					}

                    // year avg percentage
					$allCat[$parentcat['id']]['childrens'][$year]['getPerc'] = $yearPercentage;
				}				
			}
		}
        // SafetyQUAL Cat avg percentage
		$allCat[$parentcat['id']]['getPerc'] = $i==0 ? Number::toPercentage(0, 0) : Number::toPercentage(($totalper/$i), 0);
	}
	else {
        $totalcper = 0;
        $k = 0;
		// get child categories
		$childrens = $this->getParentcat($activeUser, $service_id, $parentcat['id']);	
        if(!empty($childrens)){
		foreach($childrens as $val) {
			$allCat[$parentcat['id']]['child'][$val['id']] = $val;
			$allCat[$parentcat['id']]['child'][$val['id']]['getPerc'] = Number::toPercentage($this->getPercentage($val['id'], $contractor_id, $contractor_clients), 0);
              $k++;
			  $getPercent = $this->getPercentage($val['id'], $contractor_id, $contractor_clients);
			  $totalcper = $totalcper + $getPercent;
		}
        // all parent categories		
		$allCat[$parentcat['id']]['getPerc'] = $k==0 ? Number::toPercentage(0, 0) : Number::toPercentage(($totalcper/$k), 0);
        }
        else {
        $allCat[$parentcat['id']]['getPerc'] = Number::toPercentage($this->getPercentage($parentcat['id'], $contractor_id, $contractor_clients),0);
        }
	}
	}
	return $allCat;
    }

    public function getInsServiceCategories($activeUser=array(), $service_id=null, $archive=false)
    {
	$this->ContractorAnswers = TableRegistry::get('ContractorAnswers');
	$this->Clients = TableRegistry::get('Clients');
	$year_range = Configure::read('insure_years');

	$contractor_id = $activeUser['contractor_id'];
	$contractor_clients = array();
	if($activeUser['role_id'] == CLIENT || $activeUser['role_id'] == CLIENT_ADMIN || $activeUser['role_id'] == CLIENT_VIEW) {
		$contractor_clients[0] = $activeUser['client_id'];
	}
	else {
		$contractor_clients = $this->User->getClients($contractor_id);
	}
	$parentcatall = $this->getParentcat($activeUser, $service_id, null, $archive);
	$allCat = array();

	foreach($parentcatall as $parentcat) {	
	$allCat[$parentcat['id']] = $parentcat;	
	
	if($parentcat['year_based'] == true) {
		foreach($year_range as $year) {
			$childrens = $this->getParentcat($activeUser, $service_id, $parentcat['id']);
			if(!empty($childrens)) {
				
				if($childrens[0]['name']=="General Liability") {
					$totalsubmit = $this->ContractorAnswers
					->find('all')
					->contain(['Questions'])				
					->where(['contractor_id'=>$contractor_id, 'answer !='=>'', 'Questions.category_id'=>$childrens[0]['id'],'year IS'=>$year])
					->count();

					if($totalsubmit > 0) {
					foreach($childrens as $val) {
						$allCat[$parentcat['id']]['childrens'][$year]['cat'][$val['id']] = $val;
					}
					}
					else { // if General Information not submitted
						foreach($childrens as $val) {
						$allCat[$parentcat['id']]['childrens'][$year]['cat'][$val['id']] = $val;
					}

					}
				}				
			}
		}
	}
	else {
		// get child categories
		$childrens = $this->getParentcat($activeUser, $service_id, $parentcat['id']);	
        if(!empty($childrens)){
		foreach($childrens as $val) {
			$allCat[$parentcat['id']]['child'][$val['id']] = $val;
		}
        }
	}
	}
	return $allCat;
    }
    /*public function setPercentage($category_id=null, $contractor_id=null, $contractor_clients= array(), $year=null){
    	$this->percentage = TableRegistry::get('PercentageDetails');
		$client_id = $this->getView()->getRequest()->getSession()->read('Auth.User.client_id');
		$percent = 0;	
		$percent = $this->percentage
    	->find('list',['valueField'=>'percentage'])
    	->where(['category_id'=>$category_id,'contractor_id'=>$contractor_id,'client_id IS'=>$client_id,'year IS'=>$year])->first();
    	return $percent;
    }*/
    public function siteVisit($client_id=null){
    	$this->Clients = TableRegistry::get('Clients');
    	$siteVisit = array();
        if(!empty($client_id)){
    	$siteVisit = $this->Clients 
    	->find('list',['id'])
    	->where(['id IN'=>$client_id,'site_visited'=>true])
    	->toArray();
       }

    	return $siteVisit;
    }
}
?>
