<?php
$question_options = json_decode($question['question_options']);
$question_options = array_combine(array_values($question_options), $question_options);
//!empty($question->contractor_answers) ? $val=explode(',',$question->contractor_answers[0]->answer) : $val='' ;
?>
<?php
	   if(empty($answer[0])){ $answer[0] = array('','','',''); }
       $val = explode(',', implode(',', $answer[0])); 
	   // $val = explode(',',$answer[0]);
?>
<div class="col-sm-9">
	<?= $this->Form->select('training_answers.'.$key.'.answer', $question_options, ['multiple'=>'checkbox', 'default'=>$val]) ?>
	<?= $this->Form->control('training_answers.'.$key.'.training_questions_id', ['type'=>'hidden', 'value'=>$question->id]); ?>
</div>
<!--<?php if($val[0]!='') { ?>
	<div><b>Answer : </b> <?= $question->correct_answer; ?></div>
<?php } ?>-->

