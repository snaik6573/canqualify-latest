<?php
$val = explode(',',$answer); 
?>
<div class="col-sm-12">
    <div class="col-sm-6">
	<?= $this->Form->label('Range From ', null, ['class'=>'col-form-label']); ?>
	<?= $this->Form->control('client_questions.'.$key.'.correct_answer[]',['type'=>'number', 'class'=>'form-control '.$question->safety_type, 'label'=>false, 'value'=>$val[0]]) ?>
    </div>
	<div class="col-sm-6">
	<?= $this->Form->label('Range To ', null, ['class'=>'col-form-label']); ?>
	<?= $this->Form->control('client_questions.'.$key.'.correct_answer[]',['type'=>'number', 'class'=>'form-control '.$question->safety_type, 'label'=>false, 'value'=>$val[1]]) ?>
    </div>
</div>