<?php
namespace App\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Controller\Component;
use Cake\Controller\Controller;
use Cake\ORM\TableRegistry;
use Cake\I18n\Number;

class BenchmarkComponent extends Component {

	public $components = ['Category', 'Safetyreport'];	

	public function getNaicsCode($contractor_id=null)
	{
		$this->ContractorAnswers = TableRegistry::get('ContractorAnswers');

		$naics_code = $this->ContractorAnswers
		->find('list', ['keyField'=>'question_id', 'valueField'=>'answer'])
		->where(['contractor_id'=>$contractor_id, 'Questions.safety_type'=>'primary_naics_code'])
		->contain(['Questions'])
		->first();

        return $naics_code;
    }

	public function getIA($naics_code=null, $year=null)
	{
		$this->IndustryAverages = TableRegistry::get('IndustryAverages');

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
		$year = end($year_range) - 1;

	    $user_id = $this->controller->getRequest()->getSession()->read('Auth.User.id');

	    $getTRIR = $this->Safetyreport->getTRIR($contractor_id);
        $trirVal = $getTRIR['year'][$year]!=null ? $getTRIR['year'][$year] : 0;

        $getLWCR = $this->Safetyreport->getLWCR($contractor_id);
        $lwcrVal = $getLWCR['year'][$year]!=null ? $getLWCR['year'][$year] : 0;

        $getEMR = $this->Safetyreport->getEMR($contractor_id);
        $emrVal = $getEMR['year'][$year]!=null ? $getEMR['year'][$year] : 0;
		$i=0;
        // OSHA available 
        $maintainOSHA = 0;
	    $oshaAvailable = $this->ContractorAnswers->find()->where(['question_id'=>36, 'year IN'=>$year_range, 'answer'=>'Yes', 'contractor_id'=>$contractor_id])->count();
		if($oshaAvailable == count($year_range)) {
		    $result['suggested_icons'][$i]['icon'] = 1; // red
		    $result['suggested_icons'][$i]['benchmark_type_id'] = 5;
		    $result['suggested_icons'][$i]['client_id'] = $client_id;
		    $result['suggested_icons'][$i]['contractor_id'] = $contractor_id;
		    $result['suggested_icons'][$i]['created_by'] = $user_id;

            // OSHA 300/300A Summary Logs
	        $maintainOSHA = $this->ContractorAnswers->find()->where(['question_id'=>21, 'year IN'=>$year_range, 'answer !='=>'', 'contractor_id'=>$contractor_id])->count();
		    if($maintainOSHA == count($year_range)) {
			    $result['suggested_icons'][$i]['icon'] = 3; // green
	        }

			$i++;
        }

        // EMR available 
	    $emrAvailable = $this->ContractorAnswers->find()->where(['question_id'=>37, 'year IN'=>$year_range, 'answer'=>'Yes', 'contractor_id'=>$contractor_id])->count();
		if($maintainOSHA == count($year_range)) {
       		$result['suggested_icons'][$i]['benchmark_type_id'] = 7;
		    $result['suggested_icons'][$i]['icon'] = 1; // red
		    $result['suggested_icons'][$i]['client_id'] = $client_id;
		    $result['suggested_icons'][$i]['contractor_id'] = $contractor_id;
		    $result['suggested_icons'][$i]['created_by'] = $user_id;

            // EMR Documents
	        $emrDocument = $this->ContractorAnswers->find()->where(['question_id'=>32, 'year IN'=>$year_range, 'answer !='=>'', 'contractor_id'=>$contractor_id])->count();
		    if($emrDocument == count($year_range)) {
			    $result['suggested_icons'][$i]['icon'] = 3; // green
	        }

			$i++;
        }
        // Loss Run if EMR not available
        else {
       		$result['suggested_icons'][$i]['benchmark_type_id'] = 8;
		    $result['suggested_icons'][$i]['icon'] = 1; // red
		    $result['suggested_icons'][$i]['client_id'] = $client_id;
		    $result['suggested_icons'][$i]['contractor_id'] = $contractor_id;
		    $result['suggested_icons'][$i]['created_by'] = $user_id;

	        $emrDocument = $this->ContractorAnswers->find()->where(['question_id'=>40, 'year IN'=>$year_range, 'answer !='=>'', 'contractor_id'=>$contractor_id])->count();
		    if($emrDocument == count($year_range)) {
			    $result['suggested_icons'][$i]['icon'] = 3; // green
	        }

			$i++;
        }

        // Citation available 
	    $citationAvailable = $this->ContractorAnswers->find()->where(['question_id'=>38, 'year IN'=>$year_range, 'answer'=>'Yes', 'contractor_id'=>$contractor_id])->count();
		if($citationAvailable == count($year_range)) {
       		$result['suggested_icons'][$i]['benchmark_type_id'] = 9;
		    $result['suggested_icons'][$i]['icon'] = 1; // red
		    $result['suggested_icons'][$i]['client_id'] = $client_id;
		    $result['suggested_icons'][$i]['contractor_id'] = $contractor_id;
		    $result['suggested_icons'][$i]['created_by'] = $user_id;

            // Citation/Violation History
	        $emrDocument = $this->ContractorAnswers->find()->where(['question_id'=>34, 'year IN'=>$year_range, 'answer !='=>'', 'contractor_id'=>$contractor_id])->count();
		    if($emrDocument == count($year_range)) {
			    $result['suggested_icons'][$i]['icon'] = 3; // green
	        }

			$i++;
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
			$result['suggested_icons'][$i]['category'] = $benchmarkEmr['benchmark_category_id'];
			$result['suggested_icons'][$i]['icon'] = $benchmarkEmr['icon'];
			$result['suggested_icons'][$i]['benchmark_type_id'] = $benchmarkEmr['benchmark_type_id'];
			$result['suggested_icons'][$i]['client_id'] = $client_id;
			$result['suggested_icons'][$i]['contractor_id'] = $contractor_id;
			$result['suggested_icons'][$i]['created_by'] = $user_id;

			$i++;
		}

        // get naics_code
        $naicsCode = $this->getNaicsCode($contractor_id);
        if(empty($naicsCode)) {
            $result['info'] = 'Please provide company\'s NAICS code';
        }
        else {
        // get Industry Averages
        $getIA = $this->getIA($naicsCode, $year);

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
			$result['suggested_icons'][$i]['category'] = $benchmarkTRIR['benchmark_category_id'];
			$result['suggested_icons'][$i]['icon'] = $benchmarkTRIR['icon'];
			$result['suggested_icons'][$i]['benchmark_type_id'] = $benchmarkTRIR['benchmark_type_id'];
			$result['suggested_icons'][$i]['client_id'] = $client_id;
			$result['suggested_icons'][$i]['contractor_id'] = $contractor_id;
			$result['suggested_icons'][$i]['created_by'] = $user_id;
			$i++;
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
			$result['suggested_icons'][$i]['category'] = $benchmarkLWCR['benchmark_category_id'];
			$result['suggested_icons'][$i]['icon'] = $benchmarkLWCR['icon'];
			$result['suggested_icons'][$i]['benchmark_type_id'] = $benchmarkLWCR['benchmark_type_id'];
			$result['suggested_icons'][$i]['client_id'] = $client_id;
			$result['suggested_icons'][$i]['contractor_id'] = $contractor_id;
			$result['suggested_icons'][$i]['created_by'] = $user_id;
			$i++;
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