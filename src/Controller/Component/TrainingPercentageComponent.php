<?php
namespace App\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Controller\Component;
use Cake\Controller\Controller;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\I18n\Number;

/**
 * TrainingPercentage component
 */

class TrainingPercentageComponent extends Component
{
    public $components = ['Category','User'];

    public function getParentTrainings($activeUser= null,$training_id=null,$employee_id=null,$parent_id=null){
         $this->Employees = TableRegistry::get('Employees');
        $this->Trainings = TableRegistry::get('Trainings');
        $conn = ConnectionManager::get('default');

        if($employee_id==null) {
            $employee_id = $activeUser['employee_id'];
        }

        if(isset($activeUser['client_id'])) {
            $client_id = $activeUser['client_id'];
            $sites = $this->User->getClientSites($client_id);

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
            if($training_id != null){
                
            $getTrainings = $this->Trainings->find()->select(['id', 'name', 'site_ids'])->where(['id'=>$training_id,'active'=> true, 'category_id IS'=>$parent_id, "site_ids->'s_ids' @>"=>'["'.$site_id.'"]'])->order(['category_order'])->enableHydration(false)->toArray();
                foreach($getTrainings as $key => $val) {
                    $trainings[$val['id']] = $val;
                }
            }else{
                $getTrainings = $this->Trainings->find()->select(['id', 'name', 'site_ids'])->where(['active'=> true, 'category_id IS'=>$parent_id, "site_ids->'s_ids' @>"=>'["'.$site_id.'"]'])->order(['category_order'])->enableHydration(false)->toArray();
                foreach($getTrainings as $key => $val) {
                    $trainings[$val['id']] = $val;
                }
            }
         }
      
        return $trainings;
    }
    public function storePercentage($activeUser= array(), $training_id=null, $employee_id=null)
    {
        $this->Trainings = TableRegistry::get('Trainings');
        $training = $this->Trainings->find()->select(['id','is_parent','category_id'])->where(['id'=>$training_id])->enableHydration(false)->first();
        
     
        $getpTrainings = $this->getParentTrainings($activeUser,$training_id ,$employee_id, null);
    
    
       if($training['is_parent'] == true || !isset($training['category_id'])){

    // $clientId  = $this->User->getClients($activeUser['contractor_id']);
            $allTrain = array();
             $j=0;     
            foreach($getpTrainings as $key => $val) { 
                $allTrain[$key] = $val; 
                if($employee_id==null) {
                    $employee_id = $activeUser['employee_id'];
                }
                $getChildrens = $this->getParentTrainings($activeUser, null,$employee_id, $key);

                $i=0;
                $totalper=0; 
                 
                if(!empty($getChildrens)) {         
                    foreach($getChildrens as $k => $v) {
                            $allTrain[$key]['child'][$k] = $v;
                                $getPercent = $this->getPercentage($k, $employee_id);
                         
                            $totalper = $totalper + $getPercent;

                            $i++;
                            $j++; 
                            $allTrain[$key]['child'][$k]['getPerc'] = Number::toPercentage($getPercent, 0);
                            
                    }
                    $allTrain[$key]['getPerc'] = $totalper; 
                    $parentPercent = $this->getPercentage($key, $employee_id);
                    $allTrain[$key]['getPerc'] = $i==0 ? Number::toPercentage(0, 0) : Number::toPercentage((($totalper+$parentPercent)/($j)), 0);
                    $percentage = $allTrain[$key]['getPerc'];
                    // pr($allTrain[$key]['getPerc']);  // echo "Parent + child";
                     
                }
                else{       
                    $allTrain[$key]['getPerc'] = Number::toPercentage($this->getPercentage($key, $employee_id), 0);
                    $percentage = $allTrain[$key]['getPerc'];
                  // pr($allTrain[$key]['getPerc']); // only Parent 
                }
                      
            }
            $updateFlag =0;
            $this->savePercentage($percentage,$training_id,$employee_id,$activeUser,$updateFlag,null);

      }else{
        if(empty($getpTrainings)){
            $getchild = $this->Trainings->find()->select(['category_id'])->where(['active'=> true,'id'=>$training_id])->enableHydration(false)->first();
            $parentID = $getchild['category_id'];
            $getChildrens = $this->getParentTrainings($activeUser,$training_id,$employee_id, $parentID);
             $totalper=0;       
            if(!empty($getChildrens)) {         
                foreach($getChildrens as $k => $v) { 
                        $allTrain[$k]['child'][$k] = $v;
                            $getPercent = $this->getPercentage($k, $employee_id);
                        $totalper = $totalper + $getPercent;
                        $allTrain[$k]['child'][$k]['getPerc'] =$getPercent; // only child
                        // pr($allTrain[$k]['child'][$k]['getPerc']); 
                         $percentage = $allTrain[$k]['child'][$k]['getPerc']; 
                }
                $parent_per = $this->getPercentage($parentID, $employee_id);
                $updateFlag =1;
                $this->savePercentage($percentage,$training_id,$employee_id,$activeUser,$updateFlag,$parentID,$parent_per);
            }

        }
      }
       
    
    } 
    public function getPercentage($training_id=null, $employee_id=null)
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
    public function savePercentage($percentage=null,$training_id=null,$employee_id=null,$activeUser=array(),$updateFlag=null,$parentID=null,$parent_per=null)
    {
       $totalpercent = 0;
       $totalChild =0;
       $this->TrainingPercentages = TableRegistry::get('TrainingPercentages');
        if($updateFlag == 0){
          $tbl_percentage = $this->TrainingPercentages->find()->where(['employee_id'=>$employee_id,'training_id'=>$training_id,'client_id IS'=>$activeUser['client_id']])->first();
           if(!empty($tbl_percentage)) {
            $query = $this->TrainingPercentages->query();
            $query->update()->set(['percentage' => $percentage])->where(['training_id' => $training_id,'client_id'=>$activeUser['client_id'],'employee_id'=>$employee_id])->execute();
           }else{
              $trainingPercentage = $this->TrainingPercentages->newEntity();  
              $trainingPercentage->training_id = $training_id;
              $trainingPercentage->employee_id = $employee_id;
              $trainingPercentage->client_id = $activeUser['client_id'];
              $trainingPercentage->contractor_id = $activeUser['contractor_id'];
              $trainingPercentage->percentage =   $percentage;
              $this->TrainingPercentages->save($trainingPercentage);
           }
   
        }else{  // child percentage save and Parent percentage update
            $childcatall = $this->TrainingPercentages->find()->where(['training_id IS NOT'=>$training_id,'parent_id'=>$parentID])->enableHydration(false)->toArray();
            foreach ($childcatall as $key => $childs) {
                $totalChild  += $childs['percentage'];
                $key++;
            }
            $totalpercent = Number::toPercentage((($totalChild + $percentage + $parent_per) /(2+$key)),0);
           
            $query = $this->TrainingPercentages->query();
            $query->update()->set(['percentage' => $totalpercent])->where(['training_id' => $parentID,'client_id'=>$activeUser['client_id'],'employee_id'=>$employee_id])->execute();
           
           $tbl_percentage = $this->TrainingPercentages->find()->where(['employee_id'=>$employee_id,'training_id'=>$training_id,'client_id IS'=>$activeUser['client_id']])->first();
            if(!empty($tbl_percentage)) {
            $query = $this->TrainingPercentages->query();
            $query->update()->set(['percentage' => $percentage])->where(['training_id' => $training_id,'client_id'=>$activeUser['client_id'],'employee_id'=>$employee_id])->execute();
            }else{
              $trainingPercentage = $this->TrainingPercentages->newEntity();  
              $trainingPercentage->training_id = $training_id;
              $trainingPercentage->employee_id = $employee_id;
              $trainingPercentage->client_id = $activeUser['client_id'];
              $trainingPercentage->contractor_id = $activeUser['contractor_id'];
              $trainingPercentage->percentage =   $percentage;
              $trainingPercentage->parent_id =   $parentID;
              $this->TrainingPercentages->save($trainingPercentage);
            }
        }
    }

    /*calculate and save after each training answer save*/
    public function saveTrainingPercentage($training_id=null, $employee_id=null)
    {
        $conn = ConnectionManager::get('default');
        $this->TrainingQuestions = TableRegistry::get('TrainingQuestions');
        $this->TrainingAnswers = TableRegistry::get('TrainingAnswers');
        $this->EmployeeSites = TableRegistry::get('EmployeeSites');
        $this->Sites = TableRegistry::get('Sites');

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
        $getCorrectAns = $conn->execute("SELECT DISTINCT(training_questions.id),training_answers.created FROM training_questions LEFT JOIN training_answers ON training_answers.training_questions_id = training_questions.id WHERE (active = true AND training_id = $training_id AND employee_id =$employee_id  AND (training_questions.correct_answer = training_answers.answer OR training_questions.correct_answer = '' )) order by training_answers.created DESC")->fetchAll('assoc');
        $question_cnt = count($getQuestion);
        // pr($question_cnt);
        $correct_ans_cnt = count($getCorrectAns);
        // pr($correct_ans_cnt);
        $result = 0;
        if($question_cnt != 0) {
            $correctAns = ($correct_ans_cnt * 100) / $question_cnt;
            $result = round($correctAns);

        }
        /*save to database*/
        $this->TrainingPercentages = TableRegistry::get('TrainingPercentages');
        $this->Trainings = TableRegistry::get('Trainings');
        $this->EmployeeContractors = TableRegistry::get('EmployeeContractors');

        $ifExists = $this->TrainingPercentages->find()->select(['id'])->where(['employee_id' => $employee_id, 'training_id' => $training_id])->first();
        if(!empty($ifExists->id)){
            $trainingPercentage = $this->TrainingPercentages->get($ifExists['id']);
        }else{
            $trainingPercentage = $this->TrainingPercentages->newEntity();
        }

        /*fetch client_id*/
        $getClient = $this->Trainings->find()->select(['client_id'])->where(['id' => $training_id])->first();
        if(!empty($getClient->client_id)){
            $data['client_id'] = $getClient->client_id;
        }
        /*fetch contractor_id*/
        $getContractor = $this->EmployeeContractors->find()->select(['contractor_id'])->where(['employee_id' => $employee_id])->first();
        if(!empty($getContractor->contractor_id)){
            $data['contractor_id'] = $getContractor->contractor_id;
        }
        /*completion date*/
        if(!empty($getCorrectAns[0]))
        {
            //debug($getCorrectAns[0]);
            $data['completion_date'] = $getCorrectAns[0]['created'];
        }
        if(!empty($data['completion_date'])){
            $data['expiration_date'] = strtotime(date('m/d/Y', strtotime('+1 year', strtotime($data['completion_date'])) ));
        }
        $getEmpSiteNamesStr = '';
        $getEmpSites = $this->EmployeeSites->find('list', ['keyField' => 'site_id', 'valueField' => 'site_id'])->where(['employee_id' => $employee_id])->toArray();
        if(!empty($getEmpSites)){
            $getEmpSiteNames = $this->Sites->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['id in' => $getEmpSites])->toArray();

            if(!empty($getEmpSiteNames)){
                $getEmpSiteNamesStr = implode(' | ',$getEmpSiteNames);
            }
        }
        $data['work_locations'] = $getEmpSiteNamesStr;

        $data['employee_id'] = $employee_id;
        $data['training_id'] = $training_id;
        $data['percentage'] = $result;
        $trainingPercentage = $this->TrainingPercentages->patchEntity($trainingPercentage, $data);


        if ($this->TrainingPercentages->save($trainingPercentage)) {
            return true;
        }else{
            return false;
        }
        return false;
    }

    public function saveTrainingCompletion($employee_id = null, $training_id = null){
        if(empty($employee_id) || empty($training_id)){
            return false;
        }else{
            $this->Trainings = TableRegistry::get('Trainings');
            $this->Sites = TableRegistry::get('Sites');
            $this->EmployeeContractors = TableRegistry::get('EmployeeContractors');
            $this->TrainingQuestions = TableRegistry::get('TrainingQuestions');
            $this->TrainingAnswers = TableRegistry::get('TrainingAnswers');
            $this->TrainingPercentages = TableRegistry::get('TrainingPercentages');

            $work_locations = '';
            $percentage = 0;
            $client_id = null;
            $contractor_id = null;

            $employee = $this->EmployeeContractors->find()->select(['contractor_id'])->where(['employee_id' => $employee_id])->first()->toArray();

            if(!empty($employee['contractor_id'])){
                $contractor_id = $employee['contractor_id'];
            }

            $training = $this->Trainings->find()->select(['client_id', 'site_ids'])->where(['id'=> $training_id])->first()->toArray();

            if(!empty($training['client_id'])){
                $client_id = $training['client_id'];
            }

            if(!empty($training['site_ids']['s_ids'])){
                $work_locations =$this->Sites->find('list', ['keyField'=>'id', 'valueField'=>'name'])->where(['id in' => $training['site_ids']['s_ids']])->toArray();
                if(!empty($work_locations)){
                    $work_locations = implode(', ',$work_locations);
                }
            }
            $t_question_list = $this->TrainingQuestions->find('list', ['keyField'=>'id', 'valueField'=>'id'])
                ->where(['training_id'=> $training_id, 'active' => true])
                ->toArray();

            $getCompletionDate = $this->TrainingAnswers->find()
                ->select('created')
                ->where(['employee_id'=> $employee_id, 'answer !=' => '','training_questions_id IN' => $t_question_list])
                ->order(['created' => 'DESC'])
                ->limit(1)
                ->toArray();

            $completion_date = null;
            $expiration_date = null;

            if(!empty($getCompletionDate[0]['created'])){
                $completion_date = $getCompletionDate[0]['created'];
            }
            if($completion_date != null){
                $expiration_date = strtotime(date('m/d/Y', strtotime('+1 year', strtotime($completion_date)) ));
            }


            $percentage = $this->getPercentage($training_id, $employee_id);

            $getPercentageRecordCnt = 0;
            $getPercentageRecordCnt = $this->TrainingPercentages->find('all')->where(['training_id' => $training_id, 'employee_id' => $employee_id, 'archieved' => false])->count();
            if($getPercentageRecordCnt == 0){
                $trainingPercentage = $this->TrainingPercentages->newEntity();
            }else if($getPercentageRecordCnt == 1){
                /*update record*/
                $getPercentageRecord = $this->TrainingPercentages->find('all')->where(['training_id' => $training_id, 'employee_id' => $employee_id, 'archieved' => false])->first()->toArray();
                if(!empty($getPercentageRecord['id'])){
                    $trainingPercentage = $this->TrainingPercentages->get($getPercentageRecord['id']);
                }
            }else if($getPercentageRecordCnt > 1){
                /*delete and save*/
                if($this->TrainingPercentages->deleteAll(['training_id' => $training_id, 'employee_id' => $employee_id, 'archieved' => false])){
                    //debug('deleted');
                }
                $trainingPercentage = $this->TrainingPercentages->newEntity();
            }
            $trainingPercentage->training_id = $training_id;
            $trainingPercentage->employee_id = $employee_id;
            $trainingPercentage->client_id = $client_id;
            $trainingPercentage->contractor_id = $contractor_id;
            $trainingPercentage->work_locations = $work_locations;
            $trainingPercentage->completion_date = $completion_date;
            $trainingPercentage->expiration_date = $expiration_date;
            $trainingPercentage->percentage = $percentage;
            if($this->TrainingPercentages->save($trainingPercentage))
            {
                return true;
            }
        }
    }
}
