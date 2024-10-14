<?php
$question_options = json_decode($question['question_options']);
$question_options = array_combine(array_values($question_options), $question_options); 
if($question['allow_multiselect']){ $multiselect = true; } else { $multiselect = false; } ?>
<?php
if($question['client_based']) {
	foreach($question['client_questions'] as $k => $v) { 
		//$val = isset($answer[$v->client_id]) ? explode(',',$answer[$v->client_id]) : '';
        $val='';
        $val1 ='';
        if(!empty($question->contractor_answers))
        {
            if ( strstr( $answer[$v->client_id], 'other:' ) ) {
            $valother = isset($answer[$v->client_id]) ? explode(':', $answer[$v->client_id]): '';
            $val = $valother[0];
            $val1 = $valother[1];
            } else {
            $val= isset($answer[$v->client_id]) ? explode(',',$answer[$v->client_id]): '';           
            }
        }
        $css='display:none';
        if($val1!='') { $css="display:block"; }
?>
	<div class="col-sm-12 client_based_answers">
	<div class="row">
	<div class="col-sm-3 mb-2">
		<strong><?= h($v['client']['company_name']) ?></strong>
	</div>
	<div class="col-sm-9 mb-2">
		<div class="row">
        <?= $this->Form->select('contractor_answers.'.$key.'.'.$k.'.answer', $question_options, ['class'=>"col-sm-4 form-control other_textfield", 'empty'=>true, 'multiple'=>$multiselect, 'default'=>$val]) ?>
        <div class="answer_others col-sm-6" style=<?= $css ?>>
        <?= $this->Form->control('contractor_answers.'.$key.'.'.$k.'.answer_other', ['class'=>"form-control", 'empty'=>true, 'value'=>$val1, 'label'=>false]) ?>
        </div>
        </div>
		<?= $this->Form->control('contractor_answers.'.$key.'.'.$k.'.client_id', ['type'=>'hidden', 'value'=>$v->client_id]) ?>
		<?= $this->Form->control('contractor_answers.'.$key.'.'.$k.'.question_id', ['type'=>'hidden', 'value'=>$v->question_id]) ?>
	</div>
	</div>
	</div>
	<?php
	}
}
else {
$val='';
$val1 ='';
if(!empty($question->contractor_answers))
{
    if ( strstr( $question->contractor_answers[0]->answer, 'other:' ) ) {
    $valother = explode(':', $question->contractor_answers[0]->answer);
    $val = $valother[0];
    $val1 = $valother[1];
    } else {
    $val=explode(',',$question->contractor_answers[0]->answer);
    }
}
$css='display:none';
if($val1!='') { $css="display:block"; }
?>
<div class="col-sm-9 ml-2">
<div class="row">
<?= $this->Form->select('contractor_answers.'.$key.'.answer', $question_options, ['class'=>"col-sm-4 form-control other_textfield", 'empty'=>true, 'multiple'=>$multiselect, 'default'=>$val]) ?>
<div class="answer_others col-sm-6" style=<?= $css ?>>
<?= $this->Form->control('contractor_answers.'.$key.'.answer_other', ['class'=>"form-control", 'empty'=>true, 'value'=>$val1, 'label'=>false]) ?>
</div>
</div>
<?= $this->Form->control('contractor_answers.'.$key.'.question_id', ['type'=>'hidden', 'value'=>$question->id]); ?>
</div>
<?php
}
?>
