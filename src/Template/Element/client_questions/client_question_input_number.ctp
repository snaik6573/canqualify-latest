<div class="col-sm-9">
	<?= $this->Form->control('client_questions.'.$key.'.correct_answer',['type'=>'number', 'class'=>'form-control '.$question->safety_type, 'label'=>false, 'value'=>$answer]) ?>
	<?= $this->Form->control('client_questions.'.$key.'.question_id', ['type'=>'hidden', 'value'=>$question->id]); ?>
</div>
