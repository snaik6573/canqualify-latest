<?php
$question_options = json_decode($question['question_options']);
$question_options = array_combine(array_values($question_options), $question_options); 
// !empty($question->training_answers) ? $val=implode(',',json_decode($question->training_answers[0]->answer)) : $val='';
if(empty($question->training_answers)){ $val = array('',''); }
!empty($question->training_answers) ? $val= implode(',',json_decode($question->training_answers[0]->answer)) : $val='';

?>
<div class="col-sm-4">
<div class="form-check">
	<?php
	foreach($question_options as $opt) {
		$labelCls = '';
		if($val!='') {
			if($question->correct_answer == $opt) {
				$labelCls = 'ans-valid';
			}
			/*elseif($val == $opt) {
				$labelCls = 'ans-invalid';
			}*/
		}

		echo '<div class="radio">';
		echo $this->Form->radio('training_answers.'.$key.'.answer', [$opt=>$opt], ['value'=>$val, 'hiddenField'=>false,  'label'=>['class'=>$labelCls, 'data-val'=>$opt]]);
		echo '</div>';
	}
	?>
	<?php //echo $this->Form->radio('training_answers.'.$key.'.answer', $question_options, ['class'=>'', 'value'=>$val]) ?>
	<?= $this->Form->control('training_answers.'.$key.'.training_questions_id', ['type'=>'hidden', 'value'=>$question->id]); ?>
</div>
<!--<?php if($val!='') { ?>
	<div><b>Answer : </b> <?= $question->correct_answer; ?></div>
<?php } ?>-->
</div>
