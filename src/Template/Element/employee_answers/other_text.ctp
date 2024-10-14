<?php
$question_options = json_decode($question['question_options']);
$question_options = array_combine(array_values($question_options), $question_options); 

if($question['allow_multiselect']){ $multiselect = true; } else { $multiselect = false; }
!empty($question->employee_answers) ? $val=explode(',',$question->employee_answers[0]->answer) : $val='' ;
?>
<div class="col-sm-4">
	<?= $this->Form->select('employee_answers.'.$key.'.answer', $question_options, ['class'=>"form-control other_textfield", 'empty'=>true, 'multiple'=>$multiselect, 'default'=>$val]) ?>
<div class="answer_others">
<?= $this->Form->control('employee_answers.'.$key.'.answer_other', $question_options, ['class'=>"form-control", 'empty'=>true, 'value'=>$val]) ?>
</div>
<?= $this->Form->control('employee_answers.'.$key.'.employee_question_id', ['type'=>'hidden', 'value'=>$question->id]); ?>
</div>
