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
		$this->ContractorAnswers = TableRegistry::get('ContractorAnswers');
		$year_range = $this->Category->yearRange();

		$contractorAnswers = $this->ContractorAnswers
		->find('list',['keyField'=>'year', 'valueField'=>'answer'])
		->where(['contractor_id'=>$contractor_id, 'Questions.safety_type'=>'G', 'year IN'=>$year_range])
		->contain(['Questions'])
		->order(['year'=>'ASC'])
		->toArray();

		$sumAns = 0;
		$fatalities = ['year'=>array_fill_keys($year_range, ''), 'avg'=>0];
		foreach($contractorAnswers  as $year=>$ans) {
			//$ans = !empty($ans) ? $ans : 0;
			$fatalities['year'][$year] = $ans;
			$sumAns = $sumAns + $ans;
		}
		$fatalities['avg'] = !empty($sumAns) ? Number::precision($sumAns / count($contractorAnswers), 2) : Number::precision(0, 2);

		return $fatalities;
	}

	public function getCitations($contractor_id=null)
	{
		$this->ContractorAnswers = TableRegistry::get('ContractorAnswers');
		$year_range = $this->Category->yearRange();

		$year_skip = $this->ContractorAnswers->find('list', ['keyField'=>'year', 'valueField'=>'year'])->where(['question_id'=>38, 'answer'=>'No', 'year IN'=>$year_range, 'contractor_id'=>$contractor_id])->order('year')->toArray();
		//$year_skip = array_fill_keys(array_diff($year_range, $year_skip), 0);

		$year_skip = array_fill_keys($year_skip, '0'); // default '0'
		$year_rem = array_fill_keys($year_range, ''); // default ''
		$finalYears = array_replace($year_rem, $year_skip); // merge

		$citations = ['year'=>$finalYears, 'avg'=>0];
		$contractorAnswers = $this->ContractorAnswers
		->find('list',['keyField'=>'year', 'valueField'=>'answer'])
		->where(['contractor_id'=>$contractor_id, 'Questions.safety_type'=>'C', 'year IN'=>array_keys($year_range)])
		->contain(['Questions'])
		->order(['year'=>'ASC'])
		->toArray();

		$sumAns = 0;
		//$citations = ['year'=>array_fill_keys($year_range, ''), 'avg'=>0];
		foreach($contractorAnswers as $year=>$ans) {
			//$ans = $ans!='' ? $ans : 0; 
			$citations['year'][$year] = $ans;
			$sumAns = $sumAns + $ans;
		}
		$citations['avg'] = !empty($sumAns) ? Number::precision($sumAns / count($contractorAnswers), 2) : Number::precision(0, 2);
		
		return $citations;
	}

	public function getEMR($contractor_id=null)
	{
		$this->ContractorAnswers = TableRegistry::get('ContractorAnswers');
		$year_range = $this->Category->yearRange();

		$contractorAnswers = $this->ContractorAnswers
		->find('list',['keyField'=>'year', 'valueField'=>'answer'])
		->where(['contractor_id'=>$contractor_id, 'Questions.safety_type'=>'E', 'year IN'=>$year_range])
		->contain(['Questions'])
		->order(['year'=>'ASC'])
		->toArray();

		$sumAns = 0;
		$emr = ['year'=>array_fill_keys($year_range, ''), 'avg'=>'0'];
		foreach($contractorAnswers as $year=>$ans) {
			//$ans = $ans!='' ? $ans : 0;
			$emr['year'][$year] = $ans;
			$sumAns = $sumAns + $ans;
		}
		$emr['avg'] = !empty($contractorAnswers) ? Number::precision($sumAns / count($contractorAnswers), 2) : Number::precision(0, 2);

		return $emr;
	}

	public function getTRIR($contractor_id=null)
	{
		$this->ContractorAnswers = TableRegistry::get('ContractorAnswers');
		$year_range = $this->Category->yearRange();

		$contractorAnswers = $this->ContractorAnswers
		->find()
		->select(['year', 'answer', 'Questions.safety_type'])
		->where(['contractor_id'=>$contractor_id, 'Questions.safety_type IN'=>['M','W'], 'year IN'=>$year_range])
		->contain(['Questions'])
		->order(['year'=>'ASC'])
		->enableHydration(false)
		->toArray();

		$arr = array();
		foreach($contractorAnswers as $ans) {
			$ans['answer'] = $ans['answer']!='' ? $ans['answer'] : 0; 
			$arr[$ans['year']][$ans['question']['safety_type']] = $ans['answer'];
		}

		$sumAns = 0;
		$trir = ['year'=>array_fill_keys($year_range, ''), 'avg'=>0];
		foreach($arr as $year=>$val) {
			$ans = 0;
			if(isset($val['W']) && isset($val['M'])) { 
			if($val['W']!=0 && $val['W']!='') {
				$ans = ($val['M'] * 200000) / $val['W'];
				//echo $val['M'].' * 200000 / '.$val['W']." :: ans: ".$ans.'<br/>';
			}
			}
			$trir['year'][$year] = Number::precision($ans, 2);
			$sumAns = $sumAns + $ans;
		}
		$trir['avg'] = !empty($arr) ? Number::precision($sumAns / count($arr), 2) : Number::precision(0, 2);		

		return $trir;
	}

	public function getLWCR($contractor_id=null)
	{
		$this->ContractorAnswers = TableRegistry::get('ContractorAnswers');
		$year_range = $this->Category->yearRange();

		$contractorAnswers = $this->ContractorAnswers
		->find()
		->select(['year', 'answer', 'Questions.safety_type'])
		->where(['contractor_id'=>$contractor_id, 'Questions.safety_type IN'=>['H','W'], 'year IN'=>$year_range])
		->contain(['Questions'])
		->order(['year'=>'ASC'])
		->enableHydration(false)
		->toArray();
		
		$arr = array();
		foreach($contractorAnswers as $ans) {
			$ans['answer'] = $ans['answer']!='' ? $ans['answer'] : 0; 
			$arr[$ans['year']][$ans['question']['safety_type']] = $ans['answer'];
		}

		$sumAns = 0;
		$lwcr = ['year'=>array_fill_keys($year_range, ''), 'avg'=>0];
		foreach($arr as $year=>$val) {
			$ans = 0;
			if(isset($val['W']) && isset($val['H'])) { 
			if($val['W']!=0 && $val['W']!='') {
				$ans = ($val['H'] * 200000) / $val['W'];
			}
			}
			$lwcr['year'][$year] = Number::precision($ans, 2);
			$sumAns = $sumAns + $ans;
		}
		$lwcr['avg'] = !empty($arr) ? Number::precision($sumAns / count($arr), 2) : Number::precision(0, 2);		

		return $lwcr;
	}

	public function getDART($contractor_id=null)
	{
		$this->ContractorAnswers = TableRegistry::get('ContractorAnswers');
		$year_range = $this->Category->yearRange();

		$contractorAnswers = $this->ContractorAnswers
		->find()
		->select(['year', 'answer', 'Questions.safety_type'])
		->where(['contractor_id'=>$contractor_id, 'Questions.safety_type IN'=>['H', 'I', 'W'], 'year IN'=>$year_range])
		->contain(['Questions'])
		->order(['year'=>'ASC'])
		->enableHydration(false)
		->toArray();

		$arr = array();
		foreach($contractorAnswers as $ans) {
			$ans['answer'] = $ans['answer']!='' ? $ans['answer'] : 0; 
			$arr[$ans['year']][$ans['question']['safety_type']] = $ans['answer'];
		}

		$sumAns = 0;
		$dart = ['year'=>array_fill_keys($year_range, ''), 'avg'=>0];
		foreach($arr as $year=>$val) {
			$ans = 0;
			if(isset($val['W']) && isset($val['H']) && isset($val['I'])) { 
			if($val['W']!=0 && $val['W']!='') {
				$ans = (($val['H'] + $val['I']) * 200000) / $val['W'];
			}
			}
			$dart['year'][$year] = Number::precision($ans, 2);
			$sumAns = $sumAns + $ans;
		}		
		$dart['avg'] = !empty($arr) ? Number::precision($sumAns / count($arr), 2) : Number::precision(0, 2);
		return $dart;
	}

	/* Client Reports */
	public function getFatalitiesReport($client_id=null, $contractor_ids=array(), $year_range=array())
	{
		$this->ContractorAnswers = TableRegistry::get('ContractorAnswers');

		$waiting_on = $this->User->waiting_status_ids();
		array_shift($waiting_on); // skips 1st status
		$fatalities = array();
		if(empty($contractor_ids)) { $contractor_ids = $this->User->getContractors($client_id, $waiting_on); }

		$contractorAnswers = $this->ContractorAnswers
		->find()
		->select(['year', 'answer', 'contractor_id'])
		->where(['contractor_id IN'=>$contractor_ids, 'Questions.safety_type'=>'G', 'year IN'=>$year_range])
		->contain(['Contractors'=>['fields'=>['company_name']]])
		->contain(['Questions'])
		->order(['year'=>'ASC'])
		->enableHydration(false)
		->toArray();

		foreach($contractorAnswers as $ans) {
			if(!isset($fatalities[$ans['contractor_id']])) {
				$fatalities[$ans['contractor_id']]['year'] = array_fill_keys($year_range, '');
				$fatalities[$ans['contractor_id']]['company_name'] = $ans['contractor']['company_name'];
			}
			//$ans = $ans!='' ? $ans : 0;
			$fatalities[$ans['contractor_id']]['year'][$ans['year']] = $ans['answer'];
		}
		return $fatalities;
	}

	public function getCitationsReport($client_id=null, $contractor_ids=array(), $year_range=array())
	{
		$this->ContractorAnswers = TableRegistry::get('ContractorAnswers');

		$waiting_on = $this->User->waiting_status_ids();
		array_shift($waiting_on); // skips 1st status

		if(empty($contractor_ids)) { $contractor_ids = $this->User->getContractors($client_id, $waiting_on); }

		$contractorAnswers = $this->ContractorAnswers
		->find()
		->select(['year', 'answer', 'contractor_id'])
		->where(['contractor_id IN'=>$contractor_ids, 'Questions.safety_type'=>'C', 'year IN'=>$year_range])
		->contain(['Contractors'=>['fields'=>['company_name']]])
		->contain(['Questions'])
		->order(['year'=>'ASC'])
		->enableHydration(false)
		->toArray();

		$citations = array();
		foreach($contractorAnswers as $ans) {
			if(!isset($citations[$ans['contractor_id']])) {
				$citations[$ans['contractor_id']]['year'] = array_fill_keys($year_range, '');
				$citations[$ans['contractor_id']]['company_name'] = $ans['contractor']['company_name'];
			}
			//$ans = $ans!='' ? $ans : 0;
			$citations[$ans['contractor_id']]['year'][$ans['year']] = $ans['answer'];
		}
		return $citations;
	}

	public function getEMRReport($client_id=null, $contractor_ids=array(), $year_range=array())
	{
		$waiting_on = $this->User->waiting_status_ids();
		array_shift($waiting_on); // skips 1st status

		$this->ContractorAnswers = TableRegistry::get('ContractorAnswers');
		if(empty($contractor_ids)) { $contractor_ids = $this->User->getContractors($client_id, $waiting_on); }

		$contractorAnswers = $this->ContractorAnswers
		->find()
		->select(['year', 'answer', 'contractor_id'])
		->where(['contractor_id IN'=>$contractor_ids, 'Questions.safety_type'=>'E', 'year IN'=>$year_range])
		->contain(['Contractors'=>['fields'=>['company_name']]])
		->contain(['Questions'])
		->order(['year'=>'ASC'])
		->enableHydration(false)
		->toArray();

		$emr = array();
		foreach($contractorAnswers as $ans) {
			if(!isset($emr[$ans['contractor_id']])) {
				$emr[$ans['contractor_id']]['year'] = array_fill_keys($year_range, '');
				$emr[$ans['contractor_id']]['company_name'] = $ans['contractor']['company_name'];
			}
			//$ans = $ans!='' ? $ans : 0;
			$emr[$ans['contractor_id']]['year'][$ans['year']] = $ans['answer'];
		}
		return $emr;
	}

	public function getSafetyStatisticsReport($client_id=null, $contractor_ids=array(), $year_range=array(), $categoriesSelected=array())
	{
		$this->ContractorAnswers = TableRegistry::get('ContractorAnswers');

		$waiting_on = $this->User->waiting_status_ids();
		array_shift($waiting_on); // skips 1st status

		if(empty($contractor_ids)) { $contractor_ids = $this->User->getContractors($client_id, $waiting_on); }

		$contractors = $this->ContractorAnswers->Contractors->find('list', ['keyField'=>'id', 'valueField'=>'company_name'])->where(['id IN'=>$contractor_ids])->toArray();


		// TRIR
		$trir = array();
		if(in_array('TRIR', $categoriesSelected)) {
			$contractorAnswers = $this->ContractorAnswers
			->find()
			->select(['year', 'answer', 'Questions.safety_type', 'contractor_id'])
			->where(['contractor_id IN'=>$contractor_ids, 'Questions.safety_type IN'=>['M','W'], 'year IN'=>$year_range])
			->contain(['Questions'])
			->order(['year'=>'asc'])
			->enableHydration(false)
			->toArray();



			$arr = array();
			foreach($contractorAnswers as $ans) {
				$ans['answer'] = $ans['answer']!='' ? $ans['answer'] : 0; 
				$arr[$ans['contractor_id']][$ans['year']][$ans['question']['safety_type']] = $ans['answer'];
			}

			foreach($arr as $cId=>$v) {
				$trir[$cId] = array_fill_keys($year_range, '');
				foreach($v as $key=>$val) { 
					if(!empty($val)){
					$ans = 0;
					if(isset($val['M']) && isset($val['W'])) { 
					if($val['W']!=0 && $val['W']!='') {
						$ans = ($val['M'] * 200000) / $val['W'];
					}
					}
				   }
					$trir[$cId][$key] = Number::precision($ans, 2);
				}
			}
		}
		//echo '<pre>'; print_r($contractorAnswers); echo '</pre>';

		// lwcr
		$lwcr = array();
		if(in_array('LWCR', $categoriesSelected)) {
			$contractorAnswers = $this->ContractorAnswers
			->find()
			->select(['year', 'answer', 'Questions.safety_type', 'contractor_id'])
			->where(['contractor_id IN'=>$contractor_ids, 'Questions.safety_type IN'=>['H','W'], 'year IN'=>$year_range])
			->contain(['Questions'])
			->order(['year'=>'asc'])
			->enableHydration(false)
			->toArray();

			$arr = array();
			foreach($contractorAnswers as $ans) {
				$ans['answer'] = $ans['answer']!='' ? $ans['answer'] : 0;
				$arr[$ans['contractor_id']][$ans['year']][$ans['question']['safety_type']] = $ans['answer'];
			}
			foreach($arr as $cId=>$v) {
				$lwcr[$cId] = array_fill_keys($year_range, '');
				foreach($v as $key=>$val) {
					$ans = 0;
					if(isset($val['W']) && isset($val['H'])) { 
					if($val['W']!=0 && $val['W']!='' && $val['H'] !=0) {
						$ans = ($val['H'] * 200000) / $val['W'];
					}
					}
					$lwcr[$cId][$key] = Number::precision($ans, 2);
				}
			}
		}

		// dart
		$dart = array();
		if(in_array('DART', $categoriesSelected)) {
			$contractorAnswers = $this->ContractorAnswers
			->find()
			->select(['year', 'answer', 'Questions.safety_type', 'contractor_id'])
			->where(['contractor_id IN'=>$contractor_ids, 'Questions.safety_type IN'=>['H', 'I', 'W'], 'year IN'=>$year_range])		
			->contain(['Questions'])
			->order(['year'=>'asc'])
			->enableHydration(false)
			->toArray();

			$arr = array();
			foreach($contractorAnswers as $ans) {
				$ans['answer'] = $ans['answer']!='' ? $ans['answer'] : 0;
				$arr[$ans['contractor_id']][$ans['year']][$ans['question']['safety_type']] = $ans['answer'];
			}

			foreach($arr as $cId=>$v) {
				$dart[$cId] = array_fill_keys($year_range, '');
				foreach($v as $key=>$val) {
					$ans = 0;
					if(isset($val['W']) && isset($val['H']) && isset($val['I'])) { 
					if($val['W']!=0 && $val['W']!='' && $val['I']!=0) {
						$ans = (($val['H'] + $val['I']) * 200000) / $val['W'];
					}
					}
					$dart[$cId][$key] = Number::precision($ans, 2);
				}
			}
		}

		$result = array();
		foreach($contractors as $id=>$c_name) {			
			if(isset($trir[$id])) {$result[$id]['categories']['TRIR'] = $trir[$id]; }
			if(isset($lwcr[$id])) { $result[$id]['categories']['LWCR'] = $lwcr[$id]; }
			if(isset($dart[$id])) { $result[$id]['categories']['DART'] = $dart[$id]; }
			if(isset($result[$id])) { $result[$id]['company_name'] = $c_name; }
		}
		return $result;
	}
}