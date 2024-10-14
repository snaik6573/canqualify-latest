<?php
$question_options = json_decode($question['question_options']);
$defaultVal = '';
// $defaultVal = $question_options[1];
$question_options = array_combine(array_values($question_options), $question_options);
//!empty($question->employee_answers) ? $val=$question->employee_answers[0]->answer : $val='';
?>
<?php
if($question['client_based']) {
	foreach($question['client_employee_questions'] as $k => $v) { 
		$val = isset($answer[$v->client_id]) ? $answer[$v->client_id] : $defaultVal;
	?>
	<div class="col-sm-12 client_based_answers">
	<div class="row">
	<div class="col-sm-3 mb-2">
		<strong><?= h($v['client']['company_name']) ?></strong>
	</div>
	<div class="col-sm-6 mb-2">
		<?= $this->Form->radio('employee_answers.'.$key.'.'.$k.'.answer', $question_options, ['label'=>['class'=>'radio'], 'class'=>'', 'value'=>$val]) ?>
		<?= $this->Form->control('employee_answers.'.$key.'.'.$k.'.client_id', ['type'=>'hidden', 'value'=>$v->client_id]) ?>
		<?= $this->Form->control('employee_answers.'.$key.'.'.$k.'.employee_question_id', ['type'=>'hidden', 'value'=>$v->employee_question_id]) ?>
	</div>
	</div>
	</div>
	<?php
	}
}
else {
	$val = $answer[0]!='' ? $answer[0] : $defaultVal; 
?>
<div class="col-sm-9">
	<?= $this->Form->radio('employee_answers.'.$key.'.answer', $question_options, ['label'=>['class'=>'radio'], 'class'=>'', 'value'=>$val]) ?>
	<?= $this->Form->control('employee_answers.'.$key.'.employee_question_id', ['type'=>'hidden', 'value'=>$question->id]); ?>
</div>
<?php
}
?>
