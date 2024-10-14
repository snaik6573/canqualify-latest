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

class TrainingHelper extends Helper
{
    public $helpers = ['User'];

	public function getParentTrainings($activeUser=array(), $employee_id=null, $parent_id=null)	
    {
	    $this->Employees = TableRegistry::get('Employees');
	    $this->Trainings = TableRegistry::get('Trainings');
	    $conn = ConnectionManager::get('default');

	    if($employee_id==null) {
		    $employee_id = $activeUser['employee_id'];
	    }

		if(isset($activeUser['client_id'])) {
			$client_id = $activeUser['client_id'];
			$sites = $this->User->getClientSites($client_id, $activeUser);

			$employeeSites = $this->Employees->EmployeeSites
				->find('list', ['keyField'=>'site_id', 'valueField'=>'site_id'])
				->where(['site_id IN'=>array_keys($sites), 'employee_id' =>$employee_id])		
				->toArray();

		}
		else {
			$employeeSites = $this->Employees->EmployeeSites
				->find('list', ['keyField'=>'site_id', 'valueField'=>'site_id'])
				->where(['employee_id' =>$employee_id])		
				->toArray();
		}
     $trainings = [];
     foreach($employeeSites as $site_id) {
        $getTrainings = $this->Trainings->find()->select(['id', 'name', 'site_ids'])->where(['active'=> true, 'category_id IS'=>$parent_id, "site_ids->'s_ids' @>"=>'["'.$site_id.'"]'])->order(['category_order'])->enableHydration(false)->toArray();
            foreach($getTrainings as $key => $val) {
                $trainings[$val['id']] = $val;
            }

		    /*$getTrainings = $this->Trainings->find('list', ['keyField'=>'id', 'valueField'=>'name' ])->where(['active'=> true, 'category_id IS'=>$parent_id, "site_ids->'s_ids' @>"=>'["'.$site_id.'"]'])->order(['category_order'])->toArray();
            foreach($getTrainings as $key => $val) {
                $trainings[$key] = $val;
            }*/
     }
    /*
    if($parent_id==null) {
		$getTrainings = $conn->execute("SELECT id, name FROM trainings WHERE active=true and trainings.category_id IS null and site_ids in ".explode(',',$employeeSites)." order by category_order ASC, id ASC")->fetchAll('assoc'); 
	 }
	else { // sub training
		foreach($employeeSites as $site_id) {
$getTrainings = $conn->execute("SELECT id, name FROM trainings WHERE active=true and '".$employeeSites."' = ANY (string_to_array(site_ids,',')) and trainings.category_id=".$parent_id." order by category_order ASC, id ASC")->fetchAll('assoc');
		}	
	}	*/			
	//pr($trainings);
	return $trainings;		
	}
	
    public function getTrainings($activeUser=array(), $employee_id=null)	
    {
	$getpTrainings = $this->getParentTrainings($activeUser, $employee_id, null);
	// $clientId  = $this->User->getClients($activeUser['contractor_id']);
	$allTrain = array();
	$j=1;
	foreach($getpTrainings as $key => $val) {		
	    $allTrain[$key] = $val;	
	    if($employee_id==null) {
		    $employee_id = $activeUser['employee_id'];
	    }
	    $getChildrens = $this->getParentTrainings($activeUser, $employee_id, $key);
	    $i=0;
	    $totalper=0;

	    if(!empty($getChildrens)) {	
	    		
			foreach($getChildrens as $k => $v) {
				    $allTrain[$key]['child'][$k] = $v;
				    // if(in_array(3, $clientId)){
				    	$getPercent = $this->getPercentageBAE($k, $employee_id);
				 //    }else{
				 //    $getPercent = $this->getPercentage($k, $employee_id);
					// }
				    $totalper = $totalper + $getPercent;
				    $i++;
				    $j++;
				    $allTrain[$key]['child'][$k]['getPerc'] = Number::toPercentage($getPercent, 0);
			}
			
		    $allTrain[$key]['getPerc'] = $totalper;	
		    $parentPercent = $this->getPercentageBAE($key, $employee_id);
		    $allTrain[$key]['getPerc'] = $i==0 ? Number::toPercentage(0, 0) : Number::toPercentage((($totalper+$parentPercent)/$j), 0);
	    }
	    else{		
		 // if(in_array(3, $clientId)){
			$allTrain[$key]['getPerc'] = Number::toPercentage($this->getPercentageBAE($key, $employee_id), 0);
	  //    }else{
		 //    $allTrain[$key]['getPerc'] = Number::toPercentage($this->getPercentage($key, $employee_id), 0);
		 // }	
	    }
	   		
	}		
	// }	
	 //echo "<pre>"; print_r($allTrain);	
	return 	$allTrain;
    }

    public function getNextcat($trainings=null, $training_id=null, $service_id=null)
    {

	$catNext ='';	
	if($trainings!=null) {
		$catLoop = array();		
		foreach($trainings as $key=>$val) {			
			if(!empty($val['child'])) {
			foreach($val['child'] as $k=>$v) {				
						$catLoop[] = $service_id.'/'.$key;									
				}
			}
			else{
				$catLoop[] = $service_id.'/'.$key;
			}
		}
		$currentcatUrl = $service_id.'/'.$training_id;		
		if(!in_array($currentcatUrl,$catLoop)) {
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

    public function getQuesCount($traning_id=null)
    {
		$this->TrainingQuestions = TableRegistry::get('TrainingQuestions');
		$get_questions = $this->TrainingQuestions
		->find('all')		
		->where(['training_id'=>$traning_id, 'active'=>true])
		->count();

		return $get_questions;
    }

    public function getPercentage($training_id=null, $employee_id=null) 
    {
	$this->TrainingQuestions = TableRegistry::get('TrainingQuestions');
	$this->TrainingAnswers = TableRegistry::get('TrainingAnswers');
		
	$ans_cnt = 0;
	$percent = 0;

	$get_questions = $this->TrainingQuestions
		->find('list', ['keyField'=>'id', 'valueField'=>'training_id' ])		
		->where(['training_id'=>$training_id, 'active'=>true])
		->toArray();
		
		$questionIds = array_keys($get_questions);
		$question_cnt = count($questionIds);
		if(!empty($questionIds)) {
			$ans_cnt = $this->TrainingAnswers
			->find('all')
			->where(['employee_id'=>$employee_id,'answer !='=>'','training_questions_id IN'=>$questionIds])
			->count();
		}		
		if($question_cnt !=0) { 
		$percent = ($ans_cnt * 100) / $question_cnt;		
		}
		return $percent;
    }
    public function getPercentageBAE($training_id=null, $employee_id=null) 
    {
	$conn = ConnectionManager::get('default');
	$this->TrainingQuestions = TableRegistry::get('TrainingQuestions');
	$this->TrainingAnswers = TableRegistry::get('TrainingAnswers');

	$getQuestion = $this->TrainingQuestions
		->find('list', ['keyField'=>'id', 'valueField'=>'training_id' ])		
		->where(['training_id'=>$training_id, 'active'=>true])
		->toArray();

	$questionIds = array_keys($getQuestion);
	$ans_cnt = 0;
	$answered_qid= 0;
	if(!empty($questionIds)) {
	$ans_cnt = $this->TrainingQuestions->TrainingAnswers
		->find()
		->where(['employee_id'=>$employee_id,'answer !='=>'','training_questions_id IN'=>$questionIds])
		->count();
	}
    $getCorrectAns = $conn->execute("SELECT DISTINCT(training_questions.id) FROM training_questions LEFT JOIN training_answers ON training_answers.training_questions_id = training_questions.id WHERE (active = true AND training_id = $training_id AND employee_id =$employee_id  AND (training_questions.correct_answer = training_answers.answer OR training_questions.correct_answer = '' ))")->fetchAll('assoc');
	$question_cnt = count($getQuestion);
	// pr($question_cnt);
	$correct_ans_cnt = count($getCorrectAns);
	// pr($correct_ans_cnt);
	$result = 0;
	if($question_cnt != 0) {
		$correctAns = ($correct_ans_cnt * 100) / $question_cnt;
		$result = round($correctAns);
		
	}
	return $result;
    }


    public function getAnsPercentage($training_id=null, $employee_id=null) 
    {
	$conn = ConnectionManager::get('default');
	$this->TrainingQuestions = TableRegistry::get('TrainingQuestions');

	$getQuestion = $this->TrainingQuestions
		->find('list', ['keyField'=>'id', 'valueField'=>'training_id' ])		
		->where(['training_id'=>$training_id, 'active'=>true])
		->toArray();

	$questionIds = array_keys($getQuestion);

	$ans_cnt = 0;
	if(!empty($questionIds)) {
	$ans_cnt = $this->TrainingQuestions->TrainingAnswers
		->find()
		->where(['employee_id'=>$employee_id,'answer !='=>'','training_questions_id IN'=>$questionIds])
		->count();
	}
    $getCorrectAns = $conn->execute("SELECT DISTINCT(training_questions.id) FROM training_questions LEFT JOIN training_answers ON training_answers.training_questions_id = training_questions.id WHERE (active = true AND training_id = $training_id AND employee_id =$employee_id  AND training_questions.correct_answer = training_answers.answer)")->fetchAll('assoc');
	$question_cnt = count($getQuestion);
	// pr($question_cnt);
	$correct_ans_cnt = count($getCorrectAns);
	// pr($correct_ans_cnt);

	$result = array();
	if($question_cnt != 0) {
		$ans = ($ans_cnt * 100) / $question_cnt;
		$result['total'] = round($ans);

		$correctAns = ($correct_ans_cnt * 100) / $question_cnt;
		$result['correctAns'] = round($correctAns);

		$inCorrectAns = $ans - $correctAns;
		$result['incorrectAns'] = round($inCorrectAns);
	}
	return $result;
    }
	public function getTrainingSites($employee_id=null){
   	$this->EmployeeSites = TableRegistry::get('EmployeeSites');
   	$this->Trainings = TableRegistry::get('Trainings');
     
    $allsitesTrain = array();
    $allSites = $this->EmployeeSites
		->find('list', ['keyField'=>'site_id', 'valueField'=>'site.name'])
		->contain(['Sites'])		
		->where(['employee_id'=>$employee_id])
		->toArray();

     foreach($allSites as $key => $val ) {   	     	     	
        $getTrainings = $this->Trainings->find()->select(['id', 'name', 'site_ids'])->where(['active'=> true, "site_ids->'s_ids' @>"=>'["'.$key.'"]'])->order(['category_order'])
        ->enableHydration(false)
        ->toArray();
        foreach($getTrainings as $traning) {
         	$traning['getPerc'] = Number::toPercentage($this->getPercentageBAE($traning['id'], $employee_id), 0);
           	$allsitesTrain[$val][] = $traning;                
        }    
     }
	return $allsitesTrain;
    }
	
	public function getEmpExplanationsCount($employee_id=null) {
	$this->EmployeeExplanations = TableRegistry::get('EmployeeExplanations');
	
	$getcnt = $this->EmployeeExplanations
	->find('all')
	->where(['employee_id'=>$employee_id])
	->count();

	return $getcnt;
    }
   /* public function checkTrainings($employee_id=null){ 
    	$trainings_sites = $this->getTrainingSites($employee_id);
    	$trainingShow = '';
    	
    	if(!empty($trainings_sites)){
    	$trainingShow = false;
    	foreach($trainings_sites as $key => $trainings) {  
			foreach($trainings as $training) {									
				if($training['getPerc'] != '100%') { 
                    $trainingShow = true;
                    continue;
				}
			}
		}}
		return $trainingShow;
    }*/
    public function getTrainingDate($employee_id=null){
    $conn = ConnectionManager::get('default');
	$this->TrainingAnswers = TableRegistry::get('TrainingAnswers');

	$getAnswers = $this->TrainingAnswers
		->find('list', ['keyField'=>'id', 'valueField'=>'created' ])		
		->where(['employee_id'=>$employee_id])
		->order(['id'=>'DESC'])
		->first();
	return $getAnswers;
		// pr($getAnswers);
	}

}
?>
