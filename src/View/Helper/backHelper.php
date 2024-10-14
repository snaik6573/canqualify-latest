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
    public function getServices($contractor_id=null)
    {
	$conn = ConnectionManager::get('default');
	$query = $conn->execute('SELECT DISTINCT ON (services.id) services.id, services.name FROM services 
		LEFT JOIN client_services ON client_services.service_id = services.id
		LEFT JOIN clients ON clients.id = client_services.client_id
		LEFT JOIN sites ON sites.client_id = clients.id
		LEFT JOIN users ON users.id = clients.user_id
	  	LEFT JOIN contractor_sites ON contractor_sites.site_id = sites.id 
		where contractor_sites.contractor_id='.$contractor_id.' and users.active=true'
	);
	$contractorServices = $query->fetchAll('assoc');
	return $contractorServices;
    }	
    public function getCategoryqry($service_id=null, $parent_id=null)
    {
	$this->Categories = TableRegistry::get('Categories');
	$this->ContractorAnswers = TableRegistry::get('ContractorAnswers');

		$query = $this->Categories
		->find('all', ['fields'=>['id','name','year_based', 'category_id']])			
		->where(['service_id' => $service_id, 'active' => 1, 'category_id IS' => $parent_id])
		->order(['category_order' => 'ASC'])
		->enableHydration(false)
		->toArray();		
		return $query;
    }
	public function getCategories($service_id=null)
	{		
		$this->ContractorAnswers = TableRegistry::get('ContractorAnswers');
		$parentcat = $this->getCategoryqry($service_id);		
		$allCat = array();
		$contractor_id = $this->getView()->getRequest()->getSession()->read('Auth.User.contractor_id');
		$contractor_clients = $this->getView()->getRequest()->getSession()->read('Auth.User.contractor_clients');
		
		$i=0;
		foreach($parentcat as $parentcat1)
		{		
		$allCat[$parentcat1['id']] = $parentcat1;	
		if($this->getQuesCount($parentcat1['id']) > 0){
		$this->getView()->getRequest()->getSession()->write('Auth.User.Categories.'.$i, $service_id.'/'.$parentcat1['id']);
		$i++;
		}
		if($parentcat1['year_based'] == true) {
		$year_range = Configure::read('year_range');
			foreach($year_range as $year){			
			$allCat[$parentcat1['id']]['getPerc'] = $this->getPercentage($parentcat1['id'], $contractor_id, $contractor_clients, $year);			
				$childrens = $this->getCategoryqry($service_id, $parentcat1['id']);				
				if(!empty($childrens)) {
				$question_ids = array(36, 37, 38);
				$checkHidden = $this->checkHidden($year, $question_ids);
				foreach($childrens as $val) {
					if($val['name']=="General Information") { 					
					$ans_cnt = $this->ContractorAnswers
					->find('all')
					->contain(['Questions'])
					->where(['contractor_id' => $contractor_id, 'answer !='=> '', 'Questions.category_id' => $val['id']])
					->count();
					if($ans_cnt ==0) {	
					$val['getPerc'] = $this->getPercentage($val['id'], $contractor_id, $contractor_clients, $year);		$allCat[$parentcat1['id']]['childrens'][$year][] = $val;
					$val['qcount'] = $this->getQuesCount($val['id']);
					
					break;
					}
					}
					if($val['name']=="OSHA") { if(isset($checkHidden['36'])) continue; } // q_id 36
					elseif($val['name']=="EMR") { if(isset($checkHidden['37'])) continue; } // q_id 37
					elseif($val['name']=="Citations") { if(isset($checkHidden['38'])) continue; } // q_id 38
					if($val['name']=='Loss Run' && count($checkHidden)!=count($question_ids)) { continue; }
					$val['getPerc'] = $this->getPercentage($val['id'], $contractor_id, $contractor_clients, $year);	
					$val['qcount'] = $this->getQuesCount($val['id']);
					$allCat[$parentcat1['id']]['childrens'][$year][] = $val;
					if($this->getQuesCount($val['id']) > 0){
					$this->getView()->getRequest()->getSession()->write('Auth.User.Categories.'.$i, $service_id.'/'.$val['id'].'/'.$year);
					$i++; }				
				}				
				}
				
			}		
		}
		else{
			$allCat[$parentcat1['id']]['getPerc'] = $this->getPercentage($parentcat1['id'], $contractor_id, $contractor_clients);	
			$allCat[$parentcat1['id']]['qcount'] = $this->getQuesCount($parentcat1['id']);
		}		
	 }
	//echo "<pre style='background-color:#fff;'>"; print_r($allCat);echo "</pre>"; 
	return $allCat;
	 }
    public function checkHidden($year=null, $question_ids=null)
    {
	$this->ContractorAnswers = TableRegistry::get('ContractorAnswers');
	$query = $this->ContractorAnswers->find('list', ['keyField' => 'question_id', 'valueField' => 'answer'])->where(['question_id IN' =>$question_ids, 'year'=>$year, 'answer'=>'No'])->toArray();
	return $query;
    }
	public function getQuesCount($catid=null)
	{
	$this->ClientQuestions = TableRegistry::get('ClientQuestions');
	$get_questions = $this->ClientQuestions
	->find('all')
	->contain(['Questions'])
	->where(['Questions.category_id' => $catid, 'Questions.active' => true])
	->count();	
	return $get_questions;
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
	->find('list', ['keyField' => 'question_id', 'valueField' => 'client_id' ])
	->contain(['Questions'])
	->where(['Questions.category_id' => $cat_id, 'ClientQuestions.client_id IN' => $contractor_clients])
	->toArray();
	$questionIds = array_keys($get_questions);	
	$question_cnt = count($questionIds);		
	
	if(!empty($questionIds)) {
		$ans_cnt = $this->ContractorAnswers
		->find('all')
		->where(['contractor_id' => $contractor_id, 'answer !='=> '',  'question_id IN' => $questionIds, 'year IS' => null])
		->count();
	}
	
	if($question_cnt !=0) {
		$percent = ($ans_cnt * 100) / $question_cnt;
	}
	
	}
	return Number::toPercentage($percent, 0);
    }

    public function unreadNotes($contractor_id=null)
    {
	$this->Notes = TableRegistry::get('Notes');
	$query = $this->Notes->find('all')->where(['contractor_id' =>$contractor_id, 'is_read' => true])->count();
	return $query;
    }
}
?>
