<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmployeeAnswer $employeeAnswer
 */
use Cake\Core\Configure;
use Cake\Routing\Router;
$uploaded_path = Configure::read('uploaded_path');
if($is_locked==false) {
?>
<div class="row employeeAnswers">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong><?= h($category->name) ?></strong> Add Answers
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create($employeeAnswer, array('type' => 'file', 'class'=>'employeeAnswer')) ?>

	<?php 
    $parent_questions = [];
    foreach($questions as $key => $question) :
	if(empty($question->client_employee_questions)) { continue; }

    if($question->is_parent) { $parent_questions[] = $question->id;  }

	$answer = array();
	if($question->client_based == true) {
		foreach($question->employee_answers as $ans) {
			$answer[$ans->client_id] = $ans->answer;
		}
	}
	else {
		$answer[] = !empty($question->employee_answers) ? $question->employee_answers[0]->answer : '';
	}
	?>
	<div class="form-group row <?= $question->is_parent ? 'parent-question' : '' ?><?= in_array($question->employee_question_id, $parent_questions) && $question->employee_question_id != '' ? ' sub-question' : '' ?>" data-questionId="<?= $question->id?>" <?= $question->parent_option!= '' ? 'data-parentqId="'.$question->employee_question_id.'" data-parent="'.$question->employee_question_id.'-'.$question->parent_option.'"' : ''?> >
		<div class="col-sm-12"><label class="form-control-label"><?= $question->question ?></label>
		<!-- <p class="hint <?= $question->help ? "fa fa-question-circle" : '' ?>" ><?= $question->help ?></p> -->
		<?php if($question->help){ echo '<a href="javascript:void();" data-toggle="popover" title="" data-toggle="popover" data-content="'.htmlentities($question->help).'" style="margin-left: 15px;"><i class="fa fa-info-circle"></i></a>'; } ?>		
		</div>        
		<?= $this->element('employee_answers/'.$question->question_type->name, ["key" => $key, "question" => $question, "answer" => $answer]) ?>
        <div class="col-sm-12"><hr/></div>
	</div>	
	<?php endforeach; ?>
	<div class="form-actions form-group">
		<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Save', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']) ?>
		<?php 
		$getNextcat = $this->EmployeeCategory->getNextcat($category_id);
		if($getNextcat != 'lastsubmit'){
		echo $this->Html->link('Continue', ['action' => 'add/'.$getNextcat], ['class'=>'btn btn-success btn-sm']); 
		} ?>
	</div>
	</div>
	<?= $this->Form->end() ?>
	</div>
</div>
</div>
</div>
<?php
}
else { // readonly if client 
?>
<div class="row employeeAnswers">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong><?= h($category->name) ?></strong> Answers
	</div>
	<div class="card-body card-block">
	<?php foreach($questions as $key => $question):
	if(empty($question['client_employee_questions'])) { continue; }
	?>
	<div class="card">
		<div class="card-header">
			<?= h($question->question) ?></td>
		</div>
		<div class="card-body card-block">
			<?php
			$question_type = $question->question_type->name;
			$employee_answers = $question->employee_answers;			
			if($question_type == 'file') {
				foreach($employee_answers as $answer) {
				if($question->client_based && isset($client_id)) {
					if($answer->client_id !=$client_id) { continue;	}
				}
				$answer->answer = explode(',',$answer->answer);
				foreach($answer->answer as $answer) {
					echo '<a href="'.$uploaded_path.$answer.'" target="_Blank">'.$answer.'</a>';
				}
				}
			}
			elseif($question_type == 'select' || $question_type == 'checkbox') {
				foreach($employee_answers as $answer) {
				if($question->client_based && isset($client_id)) {
					if($answer->client_id !=$client_id) { continue;	}
				}
				$answer->answer = explode(',',$answer->answer);
				foreach($answer->answer as $answer) {
					echo $this->Text->autoParagraph(h($answer));
				}
				}
			}
            elseif($question_type == 'select_naics_code') {
				foreach($employee_answers as $answer) {
				if($question->client_based && isset($client_id)) {
					if($answer->client_id !=$client_id) { continue;	}
				}
				$answer->answer = explode(',',$answer->answer);
				foreach($answer->answer as $answer) {                   
					echo $this->Text->autoParagraph(h($answer).' - '.$allnaisccode[$answer]);
				}
				}
			}
			else {
				foreach($employee_answers as $answer) {
				if($question->client_based && isset($client_id)) {
					if($answer->client_id !=$client_id) { continue;	}
				}
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
<?php
}
?>