<?php
namespace App\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Controller\Component;
use Cake\Controller\Controller;
use Cake\ORM\TableRegistry;
use Cake\I18n\Number;

class BenchmarkBAEComponent extends Component {

	public $components = ['User', 'Category', 'Safetyreport'];	

	public function getIcons($contractor_id=null, $client_id=null)
	{
		$this->ContractorAnswers = TableRegistry::get('ContractorAnswers');
		$this->Benchmarks = TableRegistry::get('Benchmarks');
		$this->controller = $this->_registry->getController();

		$user_id = $this->controller->getRequest()->getSession()->read('Auth.User.id');
		//$contractor_clients = $this->User->getClients($contractor_id);
		//foreach($contractor_clients as $client_id) {
	        $emrVal = $this->Safetyreport->getEMR($contractor_id);
		    $dartVal = $this->Safetyreport->getDART($contractor_id);

		    $setEMR = count(array_filter($emrVal['year']));
		    $setDART = count(array_filter($dartVal['year']));

		    //$maxEmr = max(array_values($emrVal['year']));
		    $maxDart = max(array_values($dartVal['year']));

		    $maxEmr = end($emrVal['year']);
		    //$maxDart = end($dartVal['year']);

		    $result = array();
		    $year_range = $this->Category->yearRange();
		    $year = end($year_range);

		    //$query = $this->ContractorAnswers->find('list', ['keyField'=>'question_id', 'valueField'=>'answer'])->where(['question_id' =>36, 'year'=>$year, 'answer'=>'No', 'contractor_id'=>$contractor_id])->toArray();
		    $query = $this->ContractorAnswers->find('list', ['keyField'=>'question_id', 'valueField'=>'answer'])->where(['question_id'=>37, 'year'=>$year, 'answer'=>'No', 'contractor_id'=>$contractor_id])->toArray();

		    $totalEmp = 0;
		    if(!empty($query)){	
			    $contractorAnswers = $this->ContractorAnswers
			    ->find('list',['keyField'=>'id', 'valueField'=>'answer'])
			    ->where(['contractor_id'=>$contractor_id, 'Questions.safety_type IN'=>['FTEMP','STEMP'], 'year IN'=>$year])
			    ->contain(['Questions'])
			    ->order(['year'=>'ASC'])
			    ->toArray();
			    $totalEmp = array_sum($contractorAnswers);
		    }

			if(!empty($query)){
				$setEMR =1;
				if($totalEmp <= 10) {
					$benchmarkEmr = $this->Benchmarks->find()->where(['client_id IN'=>$client_id, 'icon'=>3])->first();
				} else {
					$benchmarkEmr = $this->Benchmarks->find()->where(['client_id IN'=>$client_id, 'icon'=>1])->first();
				}
			}
			else {
			$benchmarkEmr = $this->Benchmarks->find()
			->where(['OR'=>['AND'=>
					 ['client_id IN'=>$client_id, 'benchmark_type_id'=>1, 'range_to !='=> 0, 'range_from <='=>$maxEmr, 'range_to >'=>$maxEmr],
					 ['client_id IN'=>$client_id, 'benchmark_type_id'=>1, 'range_to'=> 0, 'range_from <='=>$maxEmr]
				       ]
				]
			)->first();
			}			

			$benchmarkDart = $this->Benchmarks->find()
			->where(['OR'=>['AND'=>
					 ['client_id IN'=>$client_id, 'benchmark_type_id'=>2, 'range_to !='=> 0, 'range_from <='=>$maxDart, 'range_to >'=>$maxDart],
				 	 ['client_id IN'=>$client_id, 'benchmark_type_id'=>2, 'range_to'=> 0, 'range_from <='=>$maxDart]
				       ]
				]
			)->first();

			if(!empty($benchmarkEmr && $setEMR!=0)) {
				$result['suggested_icons'][0]['category'] = $benchmarkEmr['benchmark_category_id'];
				$result['suggested_icons'][0]['icon'] = $benchmarkEmr['icon'];
				$result['suggested_icons'][0]['benchmark_type_id'] = 1;
				$result['suggested_icons'][0]['client_id'] = $client_id;
				$result['suggested_icons'][0]['contractor_id'] = $contractor_id;
				$result['suggested_icons'][0]['created_by'] = $user_id;
			}
			if(!empty($benchmarkDart && $setDART!=0)) {
				$result['suggested_icons'][1]['category'] = $benchmarkDart['benchmark_category_id'];
				$result['suggested_icons'][1]['icon'] = $benchmarkDart['icon'];
				$result['suggested_icons'][1]['benchmark_type_id'] = 2;
				$result['suggested_icons'][1]['client_id'] = $client_id;
				$result['suggested_icons'][1]['contractor_id'] = $contractor_id;
				$result['suggested_icons'][1]['created_by'] = $user_id;
			}

			if(!empty($result)) {
				$result['category'] = $result['suggested_icons'][0]['category'];
				$result['icon'] = $result['suggested_icons'][0]['icon'];

				if(isset($result['suggested_icons'][1]) && $result['suggested_icons'][1]['icon']<$result['suggested_icons'][0]['icon']) {
					$result['category'] = $result['suggested_icons'][1]['category'];
					$result['icon'] = $result['suggested_icons'][1]['icon'];
				}

				//$result['bench_type'] = 'OVERALL';
				$result['client_id'] = $client_id;
				$result['contractor_id'] = $contractor_id;
				$result['created_by'] = $user_id;
			}
			//$i++;
		//}
		return $result;
	}

	

    // Update SuggestedOverallIcons category, OverallIcons category for BAE contractors
	// One time database update
	/*public function setIconCat()
	{
		$this->controller = $this->_registry->getController();
		$this->SuggestedIcons = TableRegistry::get('SuggestedIcons');
		$this->SuggestedOverallIcons = TableRegistry::get('SuggestedOverallIcons');

		$user_id = $this->controller->getRequest()->getSession()->read('Auth.User.id');


		$contractors = $this->SuggestedIcons->find('list', ['keyField'=>'id', 'valueField'=>'contractor_id'])->distinct(['contractor_id'])->toArray();
		foreach($contractors as $contractor_id) {
		$contractor_clients = $this->User->getClients($contractor_id);

		$emrVal = $this->Safetyreport->getEMR($contractor_id);
		$dartVal = $this->Safetyreport->getDART($contractor_id);

		$setEMR = count(array_filter($emrVal['year']));
		$setDART = count(array_filter($dartVal['year']));

		//$maxEmr = max(array_values($emrVal['year']));
		$maxDart = max(array_values($dartVal['year']));

		$maxEmr = end($emrVal['year']);
		//$maxDart = end($dartVal['year']);

		$result = array();
		$i=0;
		$year_range = $this->Category->yearRange();
		$year = end($year_range);

		//$query = $this->ContractorAnswers->find('list', ['keyField'=>'question_id', 'valueField'=>'answer'])->where(['question_id' =>36, 'year'=>$year, 'answer'=>'No', 'contractor_id'=>$contractor_id])->toArray();
		$query = $this->ContractorAnswers->find('list', ['keyField'=>'question_id', 'valueField'=>'answer'])->where(['question_id'=>37, 'year'=>$year, 'answer'=>'No', 'contractor_id'=>$contractor_id])->toArray();

		$totalEmp = 0;
		if(!empty($query)){	
			$contractorAnswers = $this->ContractorAnswers
			->find('list',['keyField'=>'id', 'valueField'=>'answer'])
			->where(['contractor_id'=>$contractor_id, 'Questions.safety_type IN'=>['FTEMP','STEMP'], 'year IN'=>$year])
			->contain(['Questions'])
			->order(['year'=>'ASC'])
			->toArray();
			$totalEmp = array_sum($contractorAnswers);
		}

		foreach($contractor_clients as $client_id) {
			$this->Benchmarks = TableRegistry::get('Benchmarks');
			if(!empty($query)){
				$setEMR =1;
				if($totalEmp <= 10) {
					$benchmarkEmr = $this->Benchmarks->find()->where(['client_id IN'=>$client_id, 'icon'=>3])->first();
				} else {
					$benchmarkEmr = $this->Benchmarks->find()->where(['client_id IN'=>$client_id, 'icon'=>1])->first();
				}			
			}
			else {
			$benchmarkEmr = $this->Benchmarks->find()
			->where(['OR'=>['AND'=>
					 ['client_id IN'=>$client_id, 'benchmark_type_id'=>1, 'range_to !='=> 0, 'range_from <='=>$maxEmr, 'range_to >'=>$maxEmr],
					 ['client_id IN'=>$client_id, 'benchmark_type_id'=>1, 'range_to'=> 0, 'range_from <='=>$maxEmr]
				       ]
				]
			)->first();
			}			

			$benchmarkDart = $this->Benchmarks->find()
			->where(['OR'=>['AND'=>
					 ['client_id IN'=>$client_id, 'benchmark_type_id'=>2, 'range_to !='=> 0, 'range_from <='=>$maxDart, 'range_to >'=>$maxDart],
				 	 ['client_id IN'=>$client_id, 'benchmark_type_id'=>2, 'range_to'=> 0, 'range_from <='=>$maxDart]
				       ]
				]
			)->first();

			if(!empty($benchmarkEmr && $setEMR!=0)) {
				$result[$i]['suggested_icons'][0]['category'] = $benchmarkEmr['benchmark_category_id'];
				$result[$i]['suggested_icons'][0]['icon'] = $benchmarkEmr['icon'];
				$result[$i]['suggested_icons'][0]['bench_type'] = 'EMR';
				$result[$i]['suggested_icons'][0]['client_id'] = $client_id;
				$result[$i]['suggested_icons'][0]['contractor_id'] = $contractor_id;
				$result[$i]['suggested_icons'][0]['created_by'] = $user_id;
			}
			if(!empty($benchmarkDart && $setDART!=0)) {
				$result[$i]['suggested_icons'][1]['category'] = $benchmarkDart['benchmark_category_id'];
				$result[$i]['suggested_icons'][1]['icon'] = $benchmarkDart['icon'];
				$result[$i]['suggested_icons'][1]['bench_type'] = 'DART';
				$result[$i]['suggested_icons'][1]['client_id'] = $client_id;
				$result[$i]['suggested_icons'][1]['contractor_id'] = $contractor_id;
				$result[$i]['suggested_icons'][1]['created_by'] = $user_id;

				// update dart category
				$this->SuggestedIcons->query()
					->update()
					->set(['category' => $benchmarkDart['benchmark_category_id']])
					->where(['bench_type'=>'DART','client_id'=>$client_id,'contractor_id'=>$contractor_id])
					->execute();
			}

			if(isset($result[$i])) {
				$result[$i]['category'] = $result[$i]['suggested_icons'][0]['category'];
				$result[$i]['icon'] = $result[$i]['suggested_icons'][0]['icon'];

				if(isset($result[$i]['suggested_icons'][1]) && $result[$i]['suggested_icons'][1]['icon']<$result[$i]['suggested_icons'][0]['icon']) {
					$result[$i]['category'] = $result[$i]['suggested_icons'][1]['category'];
					$result[$i]['icon'] = $result[$i]['suggested_icons'][1]['icon'];
				}

				$result[$i]['bench_type'] = 'OVERALL';
				$result[$i]['client_id'] = $client_id;
				$result[$i]['contractor_id'] = $contractor_id;
				$result[$i]['created_by'] = $user_id;

				// update overall category
				$this->SuggestedOverallIcons->query()
					->update()
					->set(['category' => $result[$i]['category']])
					->where(['client_id'=>$client_id,'contractor_id'=>$contractor_id])
					->execute();
			}
			$i++;
		}
		pr($result);
		}
	}*/
}