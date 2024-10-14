<?php
$question->safety_type!='' ? $defaultVal=0 : $defaultVal='';
//!empty($question->contractor_answers) ? $val=$question->contractor_answers[0]->answer : $val=$defaultVal;
$dtrole = "";
$cls = "";
if($question->safety_type == 'E') {$cls = 'float_only';}

if($question->allow_multiple_answers == true) {	$dtrole = "tagsinput"; }
?>
<?php
if($question['client_based']) {
	foreach($question['client_questions'] as $k => $v) { 
		$val = isset($answer[$v->client_id]) ? $answer[$v->client_id] : '';
	?>
	<div class="col-sm-12 client_based_answers">
	<div class="row">
	<div class="col-sm-3 mb-2">
		<strong><?= h($v['client']['company_name']) ?></strong>
	</div>
	<div class="col-sm-4 mb-2">
        <?php if($question->id == 10 ) { ?>
	    <?= $this->Form->control('contractor_answers.'.$key.'.'.$k.'.answer',['type'=>'text', 'class'=>$cls.' form-control '.$question->safety_type, 'label'=>false, 'value'=>$val, 'data-role'=>$dtrole ,'id'=>'txtPhone']) ?>		
        <?php } elseif($question->id == 11 ) { ?>         
	    <?= $this->Form->control('contractor_answers.'.$key.'.'.$k.'.answer',['type'=>'text', 'class'=>$cls.' form-control '.$question->safety_type, 'label'=>false, 'value'=>$val, 'data-role'=>$dtrole ,'id'=>'txtTIN']) ?>		
        <?php } else { ?>
		<?= $this->Form->control('contractor_answers.'.$key.'.'.$k.'.answer',['type'=>'text', 'class'=>$cls.' form-control '.$question->safety_type, 'label'=>false, 'value'=>$val, 'data-role'=>$dtrole]) ?>		
        <?php } ?>
        <?= $this->Form->control('contractor_answers.'.$key.'.'.$k.'.client_id', ['type'=>'hidden', 'value'=>$v->client_id]) ?>
		<?= $this->Form->control('contractor_answers.'.$key.'.'.$k.'.question_id', ['type'=>'hidden', 'value'=>$v->question_id]) ?>
	</div>
	</div>
	</div>
	<?php
	}
}
else {
	$val = $answer[0];
?>
<div class="col-sm-9">
<?php if($question->id == 10 ) { ?>
	<?= $this->Form->control('contractor_answers.'.$key.'.answer',['type'=>'text', 'class'=>$cls.' form-control '.$question->safety_type, 'label'=>false, 'value'=>$val, 'data-role'=>$dtrole,'id'=>'txtPhone']) ?>	
<?php } elseif($question->id == 11 ) { ?>
	<?= $this->Form->control('contractor_answers.'.$key.'.answer',['type'=>'text', 'class'=>$cls.' form-control '.$question->safety_type, 'label'=>false, 'value'=>$val, 'data-role'=>$dtrole,'id'=>'txtTIN']) ?>	
<?php } else { ?>
<?= $this->Form->control('contractor_answers.'.$key.'.answer',['type'=>'text', 'class'=>$cls.' form-control '.$question->safety_type, 'label'=>false, 'value'=>$val, 'data-role'=>$dtrole]) ?>	
<?php } ?>
<?= $this->Form->control('contractor_answers.'.$key.'.question_id', ['type'=>'hidden', 'value'=>$question->id]); ?>
</div>
<?php
}
?>
