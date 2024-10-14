<?php
$question_options = json_decode($question['question_options']);
if(!empty($question_options)) {
$question_options = array_combine(array_values($question_options), $question_options);
$question_options = reset($question_options);
}
!empty($question->employee_answers) ? $val=$question->employee_answers[0]->answer : $val=null;

?>
<div class="col-sm-12">
	<?= $this->Form->checkbox('employee_answers.'.$key.'.answer', ['default'=>$val,'label'=>false]) ?>
	<?= $this->Form->control('employee_answers.'.$key.'.employee_question_id', ['type'=>'hidden', 'value'=>$question->id]); ?>
</div>
