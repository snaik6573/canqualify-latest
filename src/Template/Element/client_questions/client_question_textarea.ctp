<div class="col-sm-9">
	<?= $this->Form->textarea('client_questions.'.$key.'.correct_answer',['class'=>'form-control','label'=>false, 'value'=>$answer]) ?>
	<?= $this->Form->control('client_questions.'.$key.'.question_id', ['type'=>'hidden', 'value'=>$question->id]); ?>
</div>
