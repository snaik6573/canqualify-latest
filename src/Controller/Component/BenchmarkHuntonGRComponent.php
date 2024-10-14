<?php
namespace App\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Controller\Component;
use Cake\Controller\Controller;
use Cake\ORM\TableRegistry;
use Cake\I18n\Number;

class BenchmarkHuntonGRComponent extends Component {

	public $components = ['User', 'Category', 'Safetyreport','Benchmark'];	

	public function getIcons($contractor_id=null, $client_id=null)
	{
		$this->ContractorAnswers = TableRegistry::get('ContractorAnswers');
		$this->Benchmarks = TableRegistry::get('Benchmarks');
		$this->controller = $this->_registry->getController();

		$user_id = $this->controller->getRequest()->getSession()->read('Auth.User.id');		
		    
		    $year_range = $this->Category->yearRange();
		    $year = end($year_range);
		    $result = array();			

			$getEMR = $this->Safetyreport->getEMR($contractor_id);
        	$emrVal = $getEMR['year'][$year]!=null ? $getEMR['year'][$year] : 0;

        	$getDART = $this->Safetyreport->getDART($contractor_id);
        	$dartVal = $getDART['year'][$year]!=null ? $getDART['year'][$year] : 0;

        	$getTRIR = $this->Safetyreport->getTRIR($contractor_id);
        	$trirVal = $getTRIR['year'][$year]!=null ? $getTRIR['year'][$year] : 0;

        	$getLWCR = $this->Safetyreport->getLWCR($contractor_id);
        	$lwcrVal = $getLWCR['year'][$year]!=null ? $getLWCR['year'][$year] : 0;

		    $totalEmp = 0;
		    $totalEmp = $this->ContractorAnswers->find('list', ['keyField'=>'question_id', 'valueField'=>'answer'])->where(['question_id'=>24, 'year'=>$year,'contractor_id'=>$contractor_id])->first();
		    $que_ids = [313,316];
		 	$que = $this->ContractorAnswers->find('list', ['keyField'=>'question_id', 'valueField'=>'answer'])->where(['question_id IN'=>$que_ids,'contractor_id'=>$contractor_id])->toArray();
		 	$getEmpExpCount = $this->User->getCraftCertificate($contractor_id);
		 	$benchmarkSM = $this->Benchmarks->find()->where(['client_id IN'=>$client_id, 'benchmark_type_id'=>10])->first();
		 	$benchmarkCC = $this->Benchmarks->find()->where(['client_id IN'=>$client_id, 'benchmark_type_id'=>11])->first();
		 	
		 		if($totalEmp != 0){
		 			if($que[313] == 'Yes'){		
						$result['suggested_icons'][0]['icon'] = 3;		
					}elseif ($que[313] == 'No') { 
						$result['suggested_icons'][0]['icon'] = 1;
					}	

					if($getEmpExpCount >= 1) {				
		 				$result['suggested_icons'][1]['icon'] = 3;	 				
		 			}else{
		 				$result['suggested_icons'][1]['icon'] = 1;	
		 			}		 				
							 			
		 			$result['suggested_icons'][0]['benchmark_type_id'] = 10;
		 			$result['suggested_icons'][0]['client_id'] = $client_id;
					$result['suggested_icons'][0]['contractor_id'] = $contractor_id;
					$result['suggested_icons'][0]['created_by'] = $user_id;

					$result['suggested_icons'][1]['benchmark_type_id'] = 11;
					$result['suggested_icons'][1]['client_id'] = $client_id;
					$result['suggested_icons'][1]['contractor_id'] = $contractor_id;
					$result['suggested_icons'][1]['created_by'] = $user_id;
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
					$result['suggested_icons'][2]['icon'] = $benchmarkEmr['icon'];
					$result['suggested_icons'][2]['benchmark_type_id'] = $benchmarkEmr['benchmark_type_id'];
					$result['suggested_icons'][2]['client_id'] = $client_id;
					$result['suggested_icons'][2]['contractor_id'] = $contractor_id;
					$result['suggested_icons'][2]['created_by'] = $user_id;					
				}


		// get naics_code
        $naicsCode = $this->Benchmark->getNaicsCode($contractor_id);
        
        if(empty($naicsCode)) {
            $result['info'] = 'Please provide company\'s NAICS code';
        }
        else {
        // get Industry Averages
        $yearIA = end($year_range) - 1;
        $getIA = $this->Benchmark->getIA($naicsCode, $yearIA);

        if(!empty($getIA)) {
        $result['msg'] = null;
        // DART
        $dartIAVal = $getIA['IA_DART'];
        $average_dart =  $dartIAVal != 0 ? $dartVal * 100 / $dartIAVal : 0;
	
		$benchmarkDART = $this->Benchmarks->find()
		->where(['OR'=>['AND'=>
				 ['client_id IN'=>$client_id, 'benchmark_type_id'=>2, 'range_to !='=> 0, 'range_from <='=>$average_dart, 'range_to >'=>$average_dart],
				 ['client_id IN'=>$client_id, 'benchmark_type_id'=>2, 'range_to'=> 0, 'range_from <='=>$average_dart]
			       ]
			]
		)->first();
		if(!empty($benchmarkDART)) {			
			$result['suggested_icons'][3]['icon'] = $benchmarkDART['icon'];
			$result['suggested_icons'][3]['benchmark_type_id'] = $benchmarkDART['benchmark_type_id'];
			$result['suggested_icons'][3]['client_id'] = $client_id;
			$result['suggested_icons'][3]['contractor_id'] = $contractor_id;
			$result['suggested_icons'][3]['created_by'] = $user_id;			
		}

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
			$result['suggested_icons'][4]['icon'] = $benchmarkTRIR['icon'];
			$result['suggested_icons'][4]['benchmark_type_id'] = $benchmarkTRIR['benchmark_type_id'];
			$result['suggested_icons'][4]['client_id'] = $client_id;
			$result['suggested_icons'][4]['contractor_id'] = $contractor_id;
			$result['suggested_icons'][4]['created_by'] = $user_id;
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
			$result['suggested_icons'][5]['icon'] = $benchmarkLWCR['icon'];
			$result['suggested_icons'][5]['benchmark_type_id'] = $benchmarkLWCR['benchmark_type_id'];
			$result['suggested_icons'][5]['client_id'] = $client_id;
			$result['suggested_icons'][5]['contractor_id'] = $contractor_id;
			$result['suggested_icons'][5]['created_by'] = $user_id;			
		}
        }else{
        	 $result['msg'] = 'Records Not Found in Industry Average';
        }
        }	

			if(!empty($result)) {	
			if($totalEmp > 10){			
				if ($result['suggested_icons'][0]['icon'] == 3 && $result['suggested_icons'][1]['icon'] == 3) {
					$result['icon'] = 3;				
				}else{
					$result['icon'] = 1;
				}	
			}elseif ($totalEmp <= 10) {				
				if ($result['suggested_icons'][0]['icon'] == 1 && $result['suggested_icons'][1]['icon'] == 3 && $getEmpExpCount > 1) {
					$result['icon'] = 3;				
				}elseif ($result['suggested_icons'][0]['icon'] == 3 && $result['suggested_icons'][1]['icon'] == 3) {
					$result['icon'] = 3;				
				}else{
					$result['icon'] = 1;
				}
			}	
			$resultData = $result;
			unset($resultData['suggested_icons'][0]);
			unset($resultData['suggested_icons'][1]);
			if(!empty($resultData['suggested_icons'])){
			foreach($resultData['suggested_icons'] as $r) {
			    if($r['icon']<$result['icon']) {				   
				    $result['icon'] = $r['icon'];
			    } } 
			}
 //if(isset($result['suggested_icons'][2]) && $result['suggested_icons'][2]['icon']< $result['icon']) { $result['icon'] = $result['suggested_icons'][2]['icon']; }
				    $result['client_id'] = $client_id;
				    $result['contractor_id'] = $contractor_id;
				    $result['created_by'] = $user_id;
			    
	        } 	

// pr($result);die;
		return $result;
	}

}	