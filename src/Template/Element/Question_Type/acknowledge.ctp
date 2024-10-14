<?php
if($question['client_based']) {
	foreach($question['client_questions'] as $k => $v) { //pr($answer[$v->client_id]);
		$val[1]='';
		$val1[1] ='';
		$val2[1] ='';
        if(!empty($question->contractor_answers[0]->answer))
        {
            $valother = explode(',', $answer[$v->client_id]);			
			$val= explode(':', $valother[0]);				
			$val1= explode(':', $valother[1]);	
			$val2= explode(':', $valother[2]);
        }      
?>
	<div class="col-sm-12 client_based_answers">
	<div class="row">
	<div class="col-sm-3 mb-2">
		<strong><?= h($v['client']['company_name']) ?></strong>
	</div>
	<div class="col-sm-12 mb-2">
		<?= $this->Form->checkbox('contractor_answers.'.$key.'.'.$k.'.answer', ['default'=>$val[1],'label'=>false]) ?>
		<?= $this->Form->control('contractor_answers.'.$key.'.'.$k.'.client_id', ['type'=>'hidden', 'value'=>$v->client_id]) ?>
		<?= $this->Form->control('contractor_answers.'.$key.'.'.$k.'.question_id', ['type'=>'hidden', 'value'=>$v->question_id]) ?>
	</div>
	<div class="col-sm-12" style="padding-left:0px;" >
		<div class="col-sm-2" >
			<?= $this->Form->label('Date', null); ?>
		</div>
		<div class="col-sm-9" >
			<?= $this->Form->control('contractor_answers.'.$key.'.'.$k.'.date',['type'=>'text', 'class'=>'form-control datepicker '.$question->safety_type, 'label'=>false, 'value'=>$val1[1]]) ?><br>
		</div>
		<div class="col-sm-2" >
			<?= $this->Form->label('Authorized Company Representative', null); ?>
		</div>
		<div class="col-sm-9" >
			<?= $this->Form->control('contractor_answers.'.$key.'.'.$k.'.initials', ['class'=>"form-control", 'empty'=>true, 'label'=>false,'value'=>$val2[1]]) ?>
		</div>
	</div>
	</div>
	</div>	
<?php } }
else {
	$val[1]='';
	$val1[1] ='';
	$val2[1] ='';
	
	if(!empty($question->contractor_answers[0]->answer))
	{
		$valother = explode(',', $question->contractor_answers[0]->answer);		
		$val= explode(':', $valother[0]);				
		$val1= explode(':', $valother[1]);	
		$val2= explode(':', $valother[2]);	
	}
	?>
	<div class="col-sm-12">
		<?= $this->Form->checkbox('contractor_answers.'.$key.'.answer',['default'=>$val[1],'label'=>false]) ?>
		<?= $this->Form->control('contractor_answers.'.$key.'.question_id', ['type'=>'hidden', 'value'=>$question->id]); ?>
	</div>
	<div class="col-sm-12" style="padding-left:0px;" >
		<div class="col-sm-2" >
			<?= $this->Form->label('Date', null); ?>
		</div>
		<div class="col-sm-9" >
			<?= $this->Form->control('contractor_answers.'.$key.'.date',['type'=>'text', 'class'=>'form-control datepicker '.$question->safety_type, 'label'=>false, 'value'=>$val1[1]]) ?><br>
		</div>
		<div class="col-sm-2" >
			<?= $this->Form->label('Authorized Company Representative', null); ?>
		</div>
		<div class="col-sm-9" >
			<?= $this->Form->control('contractor_answers.'.$key.'.initials', ['class'=>"form-control", 'empty'=>true, 'label'=>false,'value'=>$val2[1]]) ?>
		</div>
	</div>
<?php } ?>
