<?php
namespace App\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Controller\Component;
use Cake\Controller\Controller;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\I18n\Number;

class CategoryComponent extends Component {

    public function getArchivedYears()
    {
	$this->CanqYears = TableRegistry::get('CanqYears');
	
	$subquery1 = $this->CanqYears->find('all', ['fields'=>['id']])->where(['status' =>'start'])->first();	
	$year = $this->CanqYears
		->find('list', ['keyField'=>'year','valueField'=>'year'])			
		->where(['id < ' .$subquery1->id])	
		->order(['year'=>'ASC'])
		->enableHydration(false)
		->toArray();	
			
			
	/*$year = $this->CanqYears
	->find('list', ['keyField'=>'year','valueField'=>'year'])			
	->where(['status'=>'archive'])
	->order(['id'=>'ASC'])
	->enableHydration(false)
	->toArray();*/
	return $year;
    }

    public function yearRange($all=null)
    {
	$this->CanqYears = TableRegistry::get('CanqYears');
	
	$subquery1 = $this->CanqYears->find('all', ['fields'=>['id']])->where(['status' =>'start'])->first();
	$subquery2 = $this->CanqYears->find('all', ['fields'=>['id']])->where(['status' =>'end'])->first();
	
	if($all == null)
	{
	$year = $this->CanqYears
			->find('list', ['keyField'=>'year','valueField'=>'year'])			
			->where(['id BETWEEN ' .$subquery1->id. ' AND'=>$subquery2->id])	
			->order(['id'=>'ASC'])
			->enableHydration(false)
			->toArray();		
	}
	else{
	$year = $this->CanqYears
			->find('list', ['keyField'=>'year','valueField'=>'year'])
			->order(['id'=>'ASC'])
			->enableHydration(false)
			->toArray();						
	}	
	return $year;
    }

    public function getServiceCatgories()
    {
	$this->Services = TableRegistry::get('Services');

       	$cateServices = $this->Services
	->find('all')
	->select(['id', 'name'])
	->contain(['Categories'=>['conditions'=>['Categories.active'=>true], 'fields'=>['id', 'name', 'category_id', 'service_id'], 'sort'=>['id'=>'ASC']]])
	->order('id')
	->enableHydration(false)
	->toArray();

	$categories = array();
	foreach($cateServices as $s) {
		foreach($s['categories'] as $cat){
			if($cat['category_id'] == null) {
				$categories[$s['name']][$cat['id']] = $cat['name'];
			}
		}
		foreach($s['categories'] as $cat){
			if($cat['category_id'] !== null) {
				$parentCat = $categories[$s['name']][$cat['category_id']];
				$categories[$s['name']][$cat['id']] = $parentCat.' - '.$cat['name'];
			}
		}
	}
	return $categories;
    }
}
