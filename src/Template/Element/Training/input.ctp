<?php
$question->safety_type!='' ? $defaultVal=0 : $defaultVal='';
//!empty($question->contractor_answers) ? $val=$question->contractor_answers[0]->answer : $val=$defaultVal;
$is_video = '';
$complete = '';
if($question->is_video){ 
	$is_video = 'isVideo' ;
	$complete = 'isComplete';
}
$dtrole = "";
$cls = "";
if($question->safety_type == 'E') {$cls = 'float_only';}

if($question->allow_multiple_answers == true) {	$dtrole = "tagsinput"; }
?>
<?php    if(empty($answer[0])){ $answer[0] = array('','','',''); }
		$val = implode(',', $answer[0]);
    	$labelCls = '';
		if($val!='') {
			if($question->correct_answer == $answer[0]) {
				$labelCls = 'ans-valid';
			}
			/*elseif($val == $opt) {
				$labelCls = 'ans-invalid';
			}*/
		}
		if($val == ',,,'){ $val =''; }
?>
<div class="col-sm-9">
<?php  $videoQuestion = "Are you sure, watched your training video complete ? (Need to watch video complete this Question)";
	if(strcmp($videoQuestion, $question->question) !== 0){ 	
	?>
<?= $this->Form->control('training_answers.'.$key.'.answer',['type'=>'text', 'class'=>$cls. $labelCls.' form-control '.$question->safety_type, 'label'=>false, 'value'=>$val, 'data-role'=>$dtrole]) ?>	
<?= $this->Form->control('training_answers.'.$key.'.training_questions_id', ['type'=>'hidden', 'value'=>$question->id]);  $hide= true; ?>

<?php }else{
echo $this->Form->control('training_answers.'.$key.'.answer',['type'=>'hidden', 'class'=>$cls. $labelCls.' form-control '.$question->safety_type .$complete, 'label'=>false, 'value'=>$val, 'data-role'=>$dtrole,'disabled'=>true]);	
echo $this->Form->control('training_answers.'.$key.'.training_questions_id', ['class'=>$is_video,'type'=>'hidden', 'value'=>$question->id]);?>
<!-- 	<span>Play status: </span>
	<span class="status complete"><?= $val ?></span> -->
<?php	$hide= false;
}
?>
<!--
<?php if($val!='' && $hide ==true) { ?>
	<div style="padding-top: 5px;"><b>Answer : </b> <?= $question->correct_answer; ?></div>
<?php } ?>-->

</div>
