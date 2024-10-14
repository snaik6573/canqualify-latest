<?php
$dtrole = "";
$cls = "";
if($question->safety_type == 'E') {$cls = 'float_only';}
if($question->allow_multiple_answers == true) {	$dtrole = "tagsinput"; }
?>

<div class="col-sm-9">
	<?= $this->Form->control('client_questions.'.$key.'.correct_answer',['type'=>'text', 'class'=>$cls.' form-control '.$question->safety_type, 'label'=>false, 'value'=>$answer, 'data-role'=>$dtrole]) ?>
	<?= $this->Form->control('client_questions.'.$key.'.question_id', ['type'=>'hidden', 'value'=>$question->id]); ?>
</div>




