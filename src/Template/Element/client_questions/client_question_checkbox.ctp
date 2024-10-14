<?php
$question_options = json_decode($question['question_options']);
$question_options = array_combine(array_values($question_options), $question_options);
$val = explode(',',$answer);
?>
<div class="col-sm-9">
	<?= $this->Form->select('client_questions.'.$key.'.correct_answer', $question_options, ['multiple'=>'checkbox', 'default'=>$val]) ?>
	<?= $this->Form->control('client_questions.'.$key.'.question_id', ['type'=>'hidden', 'value'=>$question->id]); ?>
</div>

