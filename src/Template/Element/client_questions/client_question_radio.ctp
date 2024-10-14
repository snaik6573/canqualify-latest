<?php
$question_options = json_decode($question['question_options']);
$question_options = array_combine(array_values($question_options), $question_options); 
?>
<div class="col-sm-12">
	<?= $this->Form->radio('client_questions.'.$key.'.correct_answer', $question_options, ['class'=>'', 'value'=>$answer]) ?>
	<?= $this->Form->control('client_questions.'.$key.'.question_id', ['type'=>'hidden', 'value'=>$question->id]); ?>
</div>



