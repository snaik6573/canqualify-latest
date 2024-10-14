<?php
$question->safety_type!='' ? $defaultVal=0 : $defaultVal='';
?>
<div class="col-sm-9">
	<?= $this->Form->control('client_questions.'.$key.'.correct_answer',['type'=>'text','id'=>'', 'class'=>'form-control datepicker'.$question->safety_type , 'label'=>false, 'value'=>$answer]) ?>
	<?= $this->Form->control('client_questions.'.$key.'.question_id', ['type'=>'hidden', 'value'=>$question->id]); ?>
</div>
