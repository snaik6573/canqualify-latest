<?php
namespace App\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Controller\Component;
use Cake\Controller\Controller;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\I18n\Number;

class PercentageComponent extends Component {

	public $components = ['Category','User'];

    // Set Percentage Category 
    public function setPercentage($service_id,$contractor_id,$contractor_clients){
        
        $this->Categories = TableRegistry::get('Categories');
    	$categories = $this->Categories
			->find()			
			->where(['category_id IS'=>null,'active'=>true,'service_id'=>$service_id])
			->toArray();

        foreach ($categories as $category) {

        	// Year based  category
        	if($category['year_based'] == true) {

        	} 
        	// Regular child category
        	else{
               
        	}


        }
		// pr($categories);
    }  
   
    public function getPercentage($category_id=null,$contractor_id=null,$year =null,$client_id=null)
    {    
    $this->ClientQuestions = TableRegistry::get('ClientQuestions');
    $this->ContractorAnswers = TableRegistry::get('ContractorAnswers');
    $this->Categories = TableRegistry::get('Categories');    
    $this->PercentageDetails = TableRegistry::get('PercentageDetails');
	
	$percent  =0;
	if(!empty($contractor_id)){
    $contractor_clients = $this->User->getClients($contractor_id);  

		if(!empty($contractor_clients)){
		//Overall percentage Calculation.
		$percent = $this->calPercentage($category_id,$contractor_id,$contractor_clients,$year); 
		$this->savePercentage($percent,$category_id,$contractor_id,null,$year); 
	  
		//Client Wise Calculation.
		foreach($contractor_clients as $key => $client_id){
		$contractor_client[]= $client_id; 
		$percent = $this->calPercentage($category_id,$contractor_id,$contractor_client,$year);  
		$this->savePercentage($percent,$category_id,$contractor_id,$client_id,$year);   
		unset($contractor_client); 
		}}
	}
	elseif(!empty($client_id)){
	  $client_contractors = $this->User->getContractors($client_id);
	    foreach($client_contractors as $key => $contractor_id)
		{
			$contractor_clients = $this->User->getClients($contractor_id);	
			$percent = $this->calPercentage($category_id,$contractor_id,$contractor_clients,null); 
			$this->savePercentage($percent,$category_id,$contractor_id,null,null);

			$contractor_client[]= $client_id; 
			$percent = $this->calPercentage($category_id,$contractor_id,$contractor_client,null);  
			$this->savePercentage($percent,$category_id,$contractor_id,$client_id,null); 
		}
		return true;
		}
    }
  public function calPercentage($category_id=null,$contractor_id=null,$client_ids=array(),$year =null)
  {
    $ans_cnt  =0;
    $ques_cnt =0;
    $percent  =0;
    if($year ==null){
    // Regualar Quesiton 
    $questionIds  = $this->ClientQuestions
        ->find('list', ['keyField'=>'question.id', 'valueField'=>'question.id'])
        ->contain(['Questions'])
        ->where(['Questions.active'=>true, 'ClientQuestions.client_id IN'=>$client_ids,'Questions.is_parent'=>false,'ClientQuestions.is_compulsory'=>true,'Questions.question_id IS'=>null,'Questions.client_based'=>false,'Questions.category_id'=>$category_id])
        ->toArray();
        
      $ans_cnt += count($this->getAnswers($questionIds,$contractor_id));
      $ques_cnt += count($questionIds);
      

      // Client Based Quesiton 
        foreach ($client_ids as $key => $value) {     
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
        ->where(['Questions.active'=>true,'ClientQuestions.is_compulsory'=>true ,'ClientQuestions.client_id IN'=>$client_ids,'Questions.category_id'=>$category_id,
         'Questions.is_parent' => true,'Questions.question_id IS' => null])
        ->toArray();      

        $parent_ans = $this->getAnswers($questionIds3,$contractor_id);

        $ques_cnt += count($questionIds3); 
        $ans_cnt += count($parent_ans);
        foreach ($parent_ans as $key => $value) {
          $s = $this->getDependQues(array($key=>$value),$client_ids,$contractor_id);
          
          foreach ($s as $k => $v) {
            $ans_cnt += count($v['ans']);
            $ques_cnt += count($v['ques']);
          }
        }
      
        if($ques_cnt == 0){
          return $percent = 0;
        }else{
          return $percent =  Number::toPercentage(($percent = ($ans_cnt * 100) / $ques_cnt), 0);// $percent = ($ans_cnt * 100) / count($questionIds);
        }
    
    } else{
    //  Year based Question        
         $questionIds4 = $this->ClientQuestions
          ->find('list', ['keyField'=>'question.id', 'valueField'=>'question.id'])
          ->contain(['Questions'])
          ->where(['Questions.active'=>true, 'ClientQuestions.client_id IN'=>$client_ids,'ClientQuestions.is_compulsory'=>true,'Questions.category_id'=>$category_id])
          ->toArray();

         // pr($questionIds4);
           $ans_cnt += count($this->getAnswers($questionIds4,$contractor_id,null,$year));
           $ques_cnt += count($questionIds4);

      if($ques_cnt == 0){
          return $percent = 0;
        }else{
        return $percent =  Number::toPercentage(($percent = ($ans_cnt * 100) / $ques_cnt), 0);
      }

     }
	}
	  public function savePercentage($percent = null,$category_id=null,$contractor_id=null,$client_id=null,$year =null)
	{ 
		$tbl_percentage = $this->PercentageDetails->find()->where(['contractor_id'=>$contractor_id,'category_id'=>$category_id,'year IS'=>$year,'client_id IS'=>$client_id])->first();
        if(!empty($tbl_percentage)) {
        $category_id == $tbl_percentage->category_id;
        $contractor_id == $tbl_percentage->contractor_id; 
        $client_id == $tbl_percentage->client_id; 
                
            $PercentageDetail = TableRegistry::get('PercentageDetails');
            $query = $PercentageDetail->query();
            $query->update()->set(['percentage' => $percent])->where(['category_id' => $category_id,'contractor_id'=>$contractor_id,'year IS'=>$year,'client_id IS'=>$client_id])->execute();
                      
        } else{
                
          $percentageDetail = $this->PercentageDetails->newEntity();         
          $percentageDetail->category_id = $category_id;
          $percentageDetail->contractor_id = $contractor_id;
          $percentageDetail->client_id = $client_id;
          $percentageDetail->percentage =   $percent;
          $percentageDetail->year = $year;
          $this->PercentageDetails->save($percentageDetail);

        }
	}
    public function getAnswers($questionIds= array(),$contractor_id=null,$client_id=null,$year=null){
		 $answer = array();
		
		 if(!empty($questionIds)) {
						$answer = $this->ContractorAnswers
						// ->find('all')
						->find('list',['keyField'=>'question_id','valueField'=>'answer'])
						->where(['contractor_id'=>$contractor_id, 'answer !='=>'',  'question_id IN'=>$questionIds,'client_id IS'=>$client_id,'year IS'=>$year])
						 ->toArray();
						 // pr($answer);
		  }
		  return $answer;
    }


    public function getDependQues($questionAns=array(),$client_ids=null,$contractor_id=null,&$dependend=array(),$i=0){
    	$i++;
	   $where = [];
		foreach ($questionAns as $key => $value) {
			$where['OR'][] = ['Questions.active'=>true,'ClientQuestions.is_compulsory'=>true ,'ClientQuestions.client_id IN'=>$client_ids,'Questions.parent_option'=>$value,'Questions.question_id'=>$key];
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
	   /* public function getPercentage($category_id=null,$contractor_id=null,$client_ids=array(),$year =null)
    {
    
    $this->ClientQuestions = TableRegistry::get('ClientQuestions');
    $this->ContractorAnswers = TableRegistry::get('ContractorAnswers');
    $this->Categories = TableRegistry::get('Categories');
    $this->PercentageDetails = TableRegistry::get('PercentageDetails');
    
    $ans_cnt  =0;
    $ques_cnt =0;
    $percent  =0;

    if($year ==null){

     // Regualar Quesiton 
    $questionIds  = $this->ClientQuestions
		    ->find('list', ['keyField'=>'question.id', 'valueField'=>'question.id'])
		    ->contain(['Questions'])
		    ->where(['Questions.active'=>true, 'ClientQuestions.client_id IN'=>$client_ids,'Questions.is_parent'=>false,'ClientQuestions.is_compulsory'=>true,'Questions.question_id IS'=>null,'Questions.client_based'=>false,'Questions.category_id'=>$category_id])
		    ->toArray();
			
			$ans_cnt += count($this->getAnswers($questionIds,$contractor_id));
           $ques_cnt += count($questionIds);
          //  pr($ques_cnt);
          // pr($ans_cnt);

      // Client Based Quesiton 
      foreach ($client_ids as $key => $value) {
      	
       $questionIds2 = $this->ClientQuestions
		    ->find('list', ['keyField'=>'ClientQuestions.id', 'valueField'=>'question.id'])
		    ->contain(['Questions'])
		    ->where(['Questions.active'=>true, 'ClientQuestions.client_id'=>$value,'ClientQuestions.is_compulsory'=>true,'Questions.client_based'=>true,'Questions.category_id'=>$category_id])
		    ->toArray();

		   $ans_cnt += count($this->getAnswers($questionIds2,$contractor_id,$value));
		   $ques_cnt += count($questionIds2);
         }
         // pr($ques_cnt);
         //  pr($ans_cnt);   
       // Dependend Question
          $questionIds3  = $this->ClientQuestions
            
		    ->find('list', ['keyField'=>'question.id', 'valueField'=>'question.id'])
		    ->contain(['Questions'])
		    ->where(['Questions.active'=>true,'ClientQuestions.is_compulsory'=>true ,'ClientQuestions.client_id IN'=>$client_ids,'Questions.category_id'=>$category_id,
		     'Questions.is_parent' => true,'Questions.question_id IS' => null])
		    ->toArray();
  
        

            $parent_ans = $this->getAnswers($questionIds3,$contractor_id);

            $ques_cnt += count($questionIds3); 
            $ans_cnt += count($parent_ans);
            foreach ($parent_ans as $key => $value) {
                $s = $this->getDependQues(array($key=>$value),$client_ids,$contractor_id);
                // pr($s);
                foreach ($s as $k => $v) {
                	$ans_cnt += count($v['ans']);
                	$ques_cnt += count($v['ques']);
                }
            }
          // pr($ques_cnt);
          // pr($ans_cnt); 
            if($ques_cnt == 0){
                $percent = 0;
            }else{
            	$percent =  Number::toPercentage(($percent = ($ans_cnt * 100) / $ques_cnt), 0);
            }
    
    } else{
    	//  Year based Question    
       
	       $questionIds4 = $this->ClientQuestions
			    ->find('list', ['keyField'=>'question.id', 'valueField'=>'question.id'])
			    ->contain(['Questions'])
			    ->where(['Questions.active'=>true, 'ClientQuestions.client_id IN'=>$client_ids,'ClientQuestions.is_compulsory'=>true,'Questions.category_id'=>$category_id])
			    ->toArray();


             // pr($questionIds4);
			   $ans_cnt += count($this->getAnswers($questionIds4,$contractor_id,null,$year));
			   $ques_cnt += count($questionIds4);


			$percent =  Number::toPercentage(($percent = ($ans_cnt * 100) / $ques_cnt), 0);

	    

     }
        $tbl_percentage = $this->PercentageDetails->find()->where(['contractor_id'=>$contractor_id,'category_id'=>$category_id,'year IS'=>$year])->first();
        if(!empty($tbl_percentage)) {
        $category_id == $tbl_percentage->category_id;
        $contractor_id == $tbl_percentage->contractor_id; 
                
            $PercentageDetail = TableRegistry::get('PercentageDetails');
            $query = $PercentageDetail->query();
            $query->update()->set(['percentage' => $percent])->where(['category_id' => $category_id,'contractor_id'=>$contractor_id,'year IS'=>$year])->execute();
                      
        } else{
                
          $percentageDetail = $this->PercentageDetails->newEntity();         
          $percentageDetail->category_id = $category_id;
          $percentageDetail->contractor_id = $contractor_id;
          $percentageDetail->percentage =   $percent;
          $percentageDetail->year = $year;
          $this->PercentageDetails->save($percentageDetail);

        }
        // $percent = ($ans_cnt * 100) / count($questionIds);

    }*/
}