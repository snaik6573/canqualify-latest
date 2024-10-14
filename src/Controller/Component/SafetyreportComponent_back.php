<?php
namespace App\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Controller\Component;
use Cake\Controller\Controller;
use Cake\ORM\TableRegistry;
use Cake\I18n\Number;

class SafetyreportComponent extends Component {

	public $components = ['User', 'Category'];	

	public function getFatalities($contractor_id=null)
	{
	
	}

	public function getCitations($contractor_id=null)
	{

	}

	public function getEMR($contractor_id=null)
	{
		$this->ContractorAnswers = TableRegistry::get('ContractorAnswers');
		$year_range = $this->Category->yearRange();
	    $year = end($year_range) - 1;

		$contractorAnswers = $this->ContractorAnswers
		->find('list',['keyField'=>'year', 'valueField'=>'answer'])
		->where(['contractor_id'=>$contractor_id, 'Questions.safety_type'=>'E', 'year'=>$year])
		->contain(['Questions'])
		->toArray();

        $emr = 0;
        if(!empty($contractorAnswers)) {
            $emr = $contractorAnswers[$year];
        }
		return $emr;
	}

	public function getTRIR($contractor_id=null)
	{
		$this->ContractorAnswers = TableRegistry::get('ContractorAnswers');
		$year_range = $this->Category->yearRange();
	    $year = end($year_range) - 1;

		$contractorAnswers = $this->ContractorAnswers
		->find()
		->select(['year', 'answer', 'Questions.safety_type'])
		->where(['contractor_id'=>$contractor_id, 'Questions.safety_type IN'=>['M','W'], 'year'=>$year])
		->contain(['Questions'])
		->enableHydration(false)
		->toArray();

		$arr = array();
		foreach($contractorAnswers as $ans) {
			$ans['answer'] = $ans['answer']!='' ? $ans['answer'] : 0; 
			$arr[$ans['year']][$ans['question']['safety_type']] = $ans['answer'];
		}

		$trir = 0;
		foreach($arr as $year=>$val) {
			$ans = 0;
			if(isset($val['W']) && isset($val['M'])) { 
			if($val['W']!=0 && $val['W']!='') {
				$ans = ($val['M'] * 200000) / $val['W'];
			}
			}
			$trir = Number::precision($ans, 2);
		}
		return $trir;
	}

	public function getLWCR($contractor_id=null)
	{
		$this->ContractorAnswers = TableRegistry::get('ContractorAnswers');
		$year_range = $this->Category->yearRange();
	    $year = end($year_range) - 1;

		$contractorAnswers = $this->ContractorAnswers
		->find()
		->select(['year', 'answer', 'Questions.safety_type'])
		->where(['contractor_id'=>$contractor_id, 'Questions.safety_type IN'=>['H','W'], 'year'=>$year])
		->contain(['Questions'])
		->enableHydration(false)
		->toArray();
		
		$arr = array();
		foreach($contractorAnswers as $ans) {
			$ans['answer'] = $ans['answer']!='' ? $ans['answer'] : 0; 
			$arr[$ans['year']][$ans['question']['safety_type']] = $ans['answer'];
		}
		$lwcr = 0;
		foreach($arr as $year=>$val) {
			$ans = 0;
			if(isset($val['W']) && isset($val['H'])) { 
			if($val['W']!=0 && $val['W']!='') {
				$ans = ($val['H'] * 200000) / $val['W'];
			}
			}
			$lwcr = Number::precision($ans, 2);
		}
		return $lwcr;
	}

	public function getDART($contractor_id=null)
	{
	
	}

	public function getNaicsCode($contractor_id=null) {

		$this->ContractorAnswers = TableRegistry::get('ContractorAnswers');

		$naics_code = $this->ContractorAnswers
		->find('list', ['keyField'=>'question_id', 'valueField'=>'answer'])
		->where(['contractor_id'=>$contractor_id, 'Questions.safety_type'=>'primary_naics_code'])
		->contain(['Questions'])
		->first();

        return $naics_code;
    }

	public function getIA($naics_code=null) {

		$this->IndustryAverages = TableRegistry::get('IndustryAverages');

		$year_range = $this->Category->yearRange();
	    $year = end($year_range) - 1;

        $getIA = array();
        if(!empty($naics_code)) {
		    $industryAverage = $this->IndustryAverages
		    ->find()
		    ->where(['NaiscCodes.naisc_code'=>$naics_code, 'year'=>$year])
		    ->contain(['NaiscCodes'])
		    ->enableHydration(false)
		    ->first();
            if(!empty($industryAverage)) {
                $getIA['IA_DART'] = $industryAverage['cases_with_days_away_from_work'] + $industryAverage['cases_with_job_transfer_or_restriction'];
                $getIA['IA_TRIR'] = $industryAverage['total_recordable_cases'];
                $getIA['IA_LWCR'] = $industryAverage['cases_with_days_away_from_work'];
            }
        }
        return $getIA;
    }

	public function getIcons($contractor_id=null, $client_id=null)
	{
		$this->controller = $this->_registry->getController();
		$this->ContractorAnswers = TableRegistry::get('ContractorAnswers');
		$this->Benchmarks = TableRegistry::get('Benchmarks');

		$result = array();
		$year_range = $this->Category->yearRange();
	    $user_id = $this->controller->getRequest()->getSession()->read('Auth.User.id');

        $trirVal = $this->getTRIR($contractor_id);
        $lwcrVal = $this->getLWCR($contractor_id);
        $emrVal = $this->getEMR($contractor_id);
        
        // OSHA available 
        $maintainOSHA = 0;
	    $oshaAvailable = $this->ContractorAnswers->find()->where(['question_id'=>36, 'year IN'=>$year_range, 'answer'=>'Yes', 'contractor_id'=>$contractor_id])->count();
		if($oshaAvailable == count($year_range)) {
		    $result['suggested_icons'][0]['icon'] = 0; // red
		    $result['suggested_icons'][0]['benchmark_type_id'] = 5;
		    $result['suggested_icons'][0]['client_id'] = $client_id;
		    $result['suggested_icons'][0]['contractor_id'] = $contractor_id;
		    $result['suggested_icons'][0]['created_by'] = $user_id;

            // OSHA 300/300A Summary Logs
	        $maintainOSHA = $this->ContractorAnswers->find()->where(['question_id'=>21, 'year IN'=>$year_range, 'answer !='=>'', 'contractor_id'=>$contractor_id])->count();
		    if($maintainOSHA == count($year_range)) {
			    $result['suggested_icons'][0]['icon'] = 2; // green
	        }
        }

        // EMR available 
	    $emrAvailable = $this->ContractorAnswers->find()->where(['question_id'=>37, 'year IN'=>$year_range, 'answer'=>'Yes', 'contractor_id'=>$contractor_id])->count();
		if($maintainOSHA == count($year_range)) {
       		$result['suggested_icons'][2]['benchmark_type_id'] = 7;
		    $result['suggested_icons'][2]['icon'] = 0; // red
		    $result['suggested_icons'][2]['client_id'] = $client_id;
		    $result['suggested_icons'][2]['contractor_id'] = $contractor_id;
		    $result['suggested_icons'][2]['created_by'] = $user_id;

            // EMR Documents
	        $emrDocument = $this->ContractorAnswers->find()->where(['question_id'=>32, 'year IN'=>$year_range, 'answer !='=>'', 'contractor_id'=>$contractor_id])->count();
		    if($emrDocument == count($year_range)) {
			    $result['suggested_icons'][2]['icon'] = 2; // green
	        }
        }
        // Loss Run if EMR not available
        else {
       		$result['suggested_icons'][2]['benchmark_type_id'] = 8;
		    $result['suggested_icons'][2]['icon'] = 0; // red
		    $result['suggested_icons'][2]['client_id'] = $client_id;
		    $result['suggested_icons'][2]['contractor_id'] = $contractor_id;
		    $result['suggested_icons'][2]['created_by'] = $user_id;

	        $emrDocument = $this->ContractorAnswers->find()->where(['question_id'=>40, 'year IN'=>$year_range, 'answer !='=>'', 'contractor_id'=>$contractor_id])->count();
		    if($emrDocument == count($year_range)) {
			    $result['suggested_icons'][2]['icon'] = 2; // green
	        }
        }

        // Citation available 
	    $citationAvailable = $this->ContractorAnswers->find()->where(['question_id'=>38, 'year IN'=>$year_range, 'answer'=>'Yes', 'contractor_id'=>$contractor_id])->count();
		if($citationAvailable == count($year_range)) {
       		$result['suggested_icons'][3]['benchmark_type_id'] = 9;
		    $result['suggested_icons'][3]['icon'] = 0; // red
		    $result['suggested_icons'][3]['client_id'] = $client_id;
		    $result['suggested_icons'][3]['contractor_id'] = $contractor_id;
		    $result['suggested_icons'][3]['created_by'] = $user_id;

            // Citation/Violation History
	        $emrDocument = $this->ContractorAnswers->find()->where(['question_id'=>34, 'year IN'=>$year_range, 'answer !='=>'', 'contractor_id'=>$contractor_id])->count();
		    if($emrDocument == count($year_range)) {
			    $result['suggested_icons'][3]['icon'] = 2; // green
	        }
        }

        // EMR
		$benchmarkEmr = $this->Benchmarks->find()
		->where(['OR'=>['AND'=>
				 ['client_id IN'=>$client_id, 'benchmark_type_id'=>1, 'range_to !='=> 0, 'range_from <='=>$emrVal, 'range_to >'=>$emrVal],
				 ['client_id IN'=>$client_id, 'benchmark_type_id'=>1, 'range_to'=> 0, 'range_from <='=>$emrVal]
			       ]
			]
		)->first();
		if(!empty($benchmarkEmr)) {
			$result['suggested_icons'][4]['category'] = $benchmarkEmr['benchmark_category_id'];
			$result['suggested_icons'][4]['icon'] = $benchmarkEmr['icon'];
			$result['suggested_icons'][4]['benchmark_type_id'] = $benchmarkEmr['benchmark_type_id'];
			$result['suggested_icons'][4]['client_id'] = $client_id;
			$result['suggested_icons'][4]['contractor_id'] = $contractor_id;
			$result['suggested_icons'][4]['created_by'] = $user_id;
		}

        // get naics_code
        $naicsCode = $this->getNaicsCode($contractor_id);
        if(empty($naicsCode)) {
            $result['info'] = 'Please provide company\'s NAICS code';
        }
        else {
        // get Industry Averages
        $getIA = $this->getIA($naicsCode);

        if(!empty($getIA)) {
        // TRIR
        $trirIAVal = $getIA['IA_TRIR'];
        $average_trir =  $trirIAVal != 0 ? $trirVal * 100 / $trirIAVal : 0;

		$benchmarkTRIR = $this->Benchmarks->find()
		->where(['OR'=>['AND'=>
				 ['client_id IN'=>$client_id, 'benchmark_type_id'=>3, 'range_to !='=> 0, 'range_from <='=>$average_trir, 'range_to >'=>$average_trir],
				 ['client_id IN'=>$client_id, 'benchmark_type_id'=>3, 'range_to'=> 0, 'range_from <='=>$average_trir]
			       ]
			]
		)->first();
		if(!empty($benchmarkTRIR)) {
			$result['suggested_icons'][5]['category'] = $benchmarkTRIR['benchmark_category_id'];
			$result['suggested_icons'][5]['icon'] = $benchmarkTRIR['icon'];
			$result['suggested_icons'][5]['benchmark_type_id'] = $benchmarkTRIR['benchmark_type_id'];
			$result['suggested_icons'][5]['client_id'] = $client_id;
			$result['suggested_icons'][5]['contractor_id'] = $contractor_id;
			$result['suggested_icons'][5]['created_by'] = $user_id;
		}

        // LWCR
        $lwcrIAVal = $getIA['IA_LWCR'];
        $average_lwcr =  $lwcrIAVal != 0 ? $lwcrVal * 100 / $lwcrIAVal : 0;
        
		$benchmarkLWCR = $this->Benchmarks->find()
		->where(['OR'=>['AND'=>
				 ['client_id IN'=>$client_id, 'benchmark_type_id'=>4, 'range_to !='=> 0, 'range_from <='=>$average_lwcr, 'range_to >'=>$average_lwcr],
				 ['client_id IN'=>$client_id, 'benchmark_type_id'=>4, 'range_to'=> 0, 'range_from <='=>$average_lwcr]
			       ]
			]
		)->first();
		if(!empty($benchmarkLWCR)) {
			$result['suggested_icons'][6]['category'] = $benchmarkLWCR['benchmark_category_id'];
			$result['suggested_icons'][6]['icon'] = $benchmarkLWCR['icon'];
			$result['suggested_icons'][6]['benchmark_type_id'] = $benchmarkLWCR['benchmark_type_id'];
			$result['suggested_icons'][6]['client_id'] = $client_id;
			$result['suggested_icons'][6]['contractor_id'] = $contractor_id;
			$result['suggested_icons'][6]['created_by'] = $user_id;
		}
        }
        }

        // set suggested icon
		if(!empty($result)) {
		    $result['category'] = isset($result['suggested_icons'][0]['category']) ? $result['suggested_icons'][0]['category'] : null;
            $firstSuggestedIcon = reset($result['suggested_icons']);
		    $result['icon'] = $firstSuggestedIcon['icon'];
            foreach($result['suggested_icons'] as $r) {
			    if($r['icon']<$result['icon']) {
				    $result['category'] = isset($r['category']) ? $r['category'] : null;
				    $result['icon'] = $r['icon'];
			    }
			    $result['client_id'] = $client_id;
			    $result['contractor_id'] = $contractor_id;
			    $result['created_by'] = $user_id;
		    }
        }
        return $result;
	}
}
