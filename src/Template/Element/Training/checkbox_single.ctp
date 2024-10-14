<?php
$question_options = json_decode($question['question_options']);
if(!empty($question_options)) {
$question_options = array_combine(array_values($question_options), $question_options);
$question_options = reset($question_options);
}
!empty($question->training_answers) ? $val=explode(',',$question->training_answers[0]->answer) : $val='' ;
?>
<div class="col-sm-12">
	<?= $this->Form->checkbox('training_answers.'.$key.'.answer', ['value'=>$question_options,'label'=>false]) ?>
	<span class=""><?= h($question->question) ?></span>
	<?= $this->Form->control('training_answers.'.$key.'.training_questions_id', ['type'=>'hidden', 'value'=>$question->id]); ?>
</div>
