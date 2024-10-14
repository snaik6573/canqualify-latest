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
		<?= $this->Form->control('contractor_answers.'.$key.'.'.$k.'.answer',['type'=>'text', 'class'=>$cls.' form-control dollars '.$question->safety_type, 'label'=>false, 'value'=>$val, 'data-role'=>$dtrole]) ?>      
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
<?= $this->Form->control('contractor_answers.'.$key.'.answer',['type'=>'text', 'class'=>$cls.' form-control dollars '.$question->safety_type, 'label'=>false, 'value'=>$val, 'data-role'=>$dtrole,'placeholder'=>'$1,000,000.00']) ?>	

<?= $this->Form->control('contractor_answers.'.$key.'.question_id', ['type'=>'hidden', 'value'=>$question->id]); ?>
</div>
<?php
}
?>
<script type="text/javascript">
jQuery(document).ready(function () {
/* Question Type input_price */    
	jQuery('.dollars').on('keypress keyup blur', formatDollars); //when keypress keyup blur event occurs then formatDollars function call

    formatDollars(); //onload formatDollers function call

	function formatDollars(event) {
        var dollars = jQuery(".dollars").val();       
        	dollars = dollars.replace(/[^0-9\.|\,]/g,'');
        	var parts = dollars.toString().split('.');
        	//console.log(parts);
        	if(parts[0]){	
			dollars = '$' + parts.join('.');
		}else{
			dollars = null;	
		}
        jQuery(".dollars").val(dollars);
      }
  });
   /* End Question Type input_price */
</script>

