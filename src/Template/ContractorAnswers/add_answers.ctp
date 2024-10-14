<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContractorAnswer $contractorAnswer
 */
use Cake\Core\Configure;
use Cake\Routing\Router;
$uploaded_path = Configure::read('uploaded_path');
if($service_id == 2){
   $categories = $this->Category->getInsServiceCategories($activeUser, $service_id); 
}else{
   $categories = $this->Category->getServiceCategories($activeUser, $service_id); 
}
$getNextcat = $this->Category->getNextcat($categories, $category_id,$service_id,$year,$activeUser['contractor_id']);
$btnText = $getNextcat == 'lastsubmit' ? 'Save' : 'Save and Continue';
if(isset($submit)) {
	$url='';
    if($getNextcat=='lastsubmit') {
       /* if($service_id==6) {
		    $url = Router::Url(['controller' => 'ContractorAnswers', 'action' => 'final-submit'], true) . '/' . $service_id;
	    }
        else {*/
            $services = $this->Category->getServices($activeUser['contractor_id']);
            $remove_services = ['AuditQual','EmployeeQual'];

            $services = array_diff($services,$remove_services);
           
            foreach ($services as $key=>$val) {    
                next($services);
                if($key==$service_id) { break; }
            }
            if(key($services) != $service_id) {
                $categories = $this->Category->getServiceCategories($activeUser, key($services)); 
                $getNextcat = $this->Category->getNextcat($categories, $category_id, key($services), $year);
                $url = Router::Url(['controller' => 'ContractorAnswers', 'action' => 'add-answers'], true) . '/' . $getNextcat;
               
                $total_complete = true;
                $inCompUrl = '';
                if(empty($getNextcat)){
                if(!empty($services)){
	 			foreach ($services as $serviceId => $service_name) {
	 				if($serviceId == 2){
					$categories = $this->Category->getInsCategories($activeUser, $serviceId, false);
					}else{
					$categories = $this->Category->getCategories($activeUser, $serviceId, false);
					}
				
					if(!empty($categories)) { 
					foreach($categories as $cat) {
					    if($cat['getPerc'] !='100%') {			   				
						    	if(!empty($cat['childrens'])) { // year_based
								foreach ($cat['childrens'] as $key=>$value) {
								foreach ($value['cat'] as $childcats) { 
									if($childcats['getPerc'] != '100%'){ 
									$total_complete = false;						
									$inCompUrl = Router::Url(['controller' => 'ContractorAnswers', 'action' => 'add-answers'], true) .'/'. $serviceId . '/' . $childcats['id'] .'/'. $key; break 3; } else{
										continue;
									}

								}}}elseif(!empty($cat['child'])) { // sub_cat
				   				 foreach ($cat['child'] as $key=>$value) { 
				   				 	if($value['getPerc'] != '100%') {
				   				 	$inCompUrl = '';
				   				 	$total_complete = false;
				   				 	$inCompUrl = Router::Url(['controller' => 'ContractorAnswers', 'action' => 'add-answers'], true) .'/'. $serviceId . '/' .$value['id'];break 3 ; } else{
										continue;
									}
				   				 }}else{
				   				 	if($cat['getPerc'] != '100%'){
				   				 	$inCompUrl = '';
				   				 	$total_complete = false;
				   				 	$inCompUrl = Router::Url(['controller' => 'ContractorAnswers', 'action' => 'add-answers'], true) .'/'. $serviceId . '/' . $cat['id']; break 2 ; } else{
										continue;
									}
				   				 }				   				
						    }
						   // break;
						}
					}else{
						$total_complete = false;
					}}
			 	}}
	//pr($total_complete); pr($inCompUrl);die;
                if(empty($getNextcat) && $total_complete == true){  $url = Router::Url(['controller' => 'ContractorAnswers', 'action' => 'final-submit'], true) . '/' . $service_id; }elseif(empty($getNextcat) && $total_complete == false){
                	$url = $inCompUrl;
                }
            }    		
        //}
    }
    else {
	    if($category_id=='2') { // if General Information
		    $url = Router::Url(['controller' => 'contractorUsers', 'action' => 'add'], true) . '/' . $getNextcat;
        }
        else {
    		$url = Router::Url(['controller' => 'ContractorAnswers', 'action' => 'add-answers'], true) . '/' . $getNextcat;
        }
    }

	header("Location: ". $url);
	exit;
}

if($category!=null) {
?>
<?php if($is_locked==0): //&& $is_archived==0 ?>
<div class="row contractorAnswers">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong><?= h($category->name). ' - '.$year ?></strong> Add Answers
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create($contractorAnswer, array('type' => 'file', 'class'=>'contractoeAnswer')) ?>

	<?php 
    $parent_questions = [];
    foreach($questions as $key => $question) : //pr($question);
	if(empty($question->client_questions)) { continue; }
	if($question->id ==460 && $year < 2020){ continue; } //safetyQual covid-19 question hide for 2015-2019
    if($question->is_parent) { $parent_questions[] = $question->id;  }

	$answer = array();
	if($question->client_based == true) {
		foreach($question->contractor_answers as $ans) {
			$answer[$ans->client_id] = $ans->answer;
		}
	}
	else {
		$answer[] = !empty($question->contractor_answers) ? $question->contractor_answers[0]->answer : '';
	}
	?>
	<div class="form-group row <?= $question->is_parent ? 'parent-question' : '' ?><?= in_array($question->question_id, $parent_questions) && $question->question_id != '' ? ' sub-question' : '' ?>" data-questionId="<?= $question->id?>" <?= $question->parent_option!= '' ? 'data-parentqId="'.$question->question_id.'" data-parent="'.$question->question_id.'-'.$question->parent_option.'"' : ''?> >
		<div class="col-sm-12"><label class="form-control-label"><?= htmlspecialchars_decode(h($question->question)) ?></label>
		<!-- <p class="hint <?= $question->help ? "fa fa-question-circle" : '' ?>" ><?= $question->help ?></p> -->
		<?php if($question->help){ echo '<a href="javascript:void();" data-toggle="popover" title="" data-content="'.htmlentities($question->help).'" style="margin-left: 15px;"><i class="fa fa-info-circle"></i></a>'; } ?>		
		</div>
		<?php if($question->document){ ?>
		<div class="col-sm-12" style="padding-left:0px;">
            <div class="alert alert-info" role="alert">
                <span><?php if($question->help){echo $question->help; }?></span>
                <?php !empty($question->document) ? $val=$question->document : $val='' ; ?>
                <?php if($val!='') {
                    if($question->id == 793){
                        echo $this->Html->link($val, 'https://data-canqualifyer.s3.amazonaws.com/help_files/Supplier-Upload-Template.xlsx',array('download'=>'https://data-canqualifyer.s3.amazonaws.com/help_files/Supplier-Upload-Template.xlsx', 'target' => '_blank'));
                    }else{
                        echo $this->Html->link($val, 'help_files/'.$val,array('download'=>$val, 'target' => '_blank'));
                    }
                }	?>
            </div>
		</div>
	   <?php } ?>
		<?= $this->element('Question_Type/'.$question->question_type->name, ["key" => $key, "question" => $question, "answer" => $answer]) ?>
		<div class="col-sm-12"><hr/></div>
	</div>	
	<?php endforeach; ?>
	<div class="form-actions form-group">
		<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> '.$btnText, ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']) ?>
		<?php if($contractor->data_submit) {
			echo $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Save and Exit', ['type' => 'submit', 'name'=>'save_n_exit', 'class'=>'btn btn-primary btn-sm']);
		} ?>
	</div>
	</div>
	<?= $this->Form->end() ?>
	</div>
</div>
</div>
</div>
<?php else: ?>
<div class="row contractorAnswers">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong><?= h($category->name). ' - '.$year ?></strong> Answers
	</div>
	<div class="card-body card-block">

	<?php foreach($questions as $key => $question):
	if(empty($question['client_questions'])) { continue; }
	if($question->id ==460 && $year < 2020){ continue; } //safetyQual covid-19 question hide for 2015-2019
	?>
	<div class="card">
		<div class="card-header">
			<?= htmlspecialchars_decode(h($question->question)) ?></td>
		</div>
		<div class="card-body card-block">
			<?php
			$question_type = $question->question_type->name;
			$contractor_answers = $question->contractor_answers;			
			if($question_type == 'file') {
				foreach($contractor_answers as $answer) {
					$answer->answer = explode(',',$answer->answer);
					foreach($answer->answer as $answer) {
						echo '<a href="'.$uploaded_path.$answer.'" target="_Blank">'.$answer.'</a>';
					}
				}
			}
			elseif($question_type == 'select' || $question_type == 'checkbox') {
				foreach($contractor_answers as $answer) {
					$answer->answer = explode(',',$answer->answer);
					foreach($answer->answer as $answer) {
						echo $this->Text->autoParagraph(h($answer));
					}
				}
			}
            elseif($question_type == 'select_naics_code') {
				foreach($contractor_answers as $answer) {
					$answer->answer = explode(',',$answer->answer);
					foreach($answer->answer as $answer) {                   
						echo $this->Text->autoParagraph(h($answer).' - '.$allnaisccode[$answer]);
					}
				}
			}
			elseif($question_type == 'select_naic_code') {
				foreach($contractor_answers as $answer) {
					$answer->answer = explode(',',$answer->answer);
					foreach($answer->answer as $answer) {                   
						echo $this->Text->autoParagraph(h($answer).' - '.$allnaiccode[$answer]);
					}
				}
			}
			else {
				foreach($contractor_answers as $answer) {
					echo $this->Text->autoParagraph(h($answer->answer));
				}
			}
			?>
		</div>
	</div>
	<?php endforeach; ?>
	</div>
</div>
</div>
</div>
<?php endif; 
}
?>
<div class="modal fade" id="scrollmodal2" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-title">Force Change Icon Status</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="modal-body">
	</div>
</div>
</div>
</div>