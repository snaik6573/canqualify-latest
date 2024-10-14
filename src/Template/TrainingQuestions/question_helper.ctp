<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Training $training_helper
 */
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
$users = array(SUPER_ADMIN,CLIENT,CLIENT_ADMIN);

$da =  empty(json_decode($trainingQuestion->data_attribute)) ? (empty($trainingQuestion->question_options)) ? json_decode($trainingQuestion->question_options) : (count(json_decode($trainingQuestion->question_options)) >= 4 ? array("","","","") : array("",""))  : json_decode($trainingQuestion->data_attribute);
$qo =  empty(json_decode($trainingQuestion->question_options)) ? (empty($trainingQuestion->question_options)) ? json_decode($trainingQuestion->question_options) :(count(json_decode($trainingQuestion->question_options)) >= 4 ? array("","","","") : array("","")) : json_decode($trainingQuestion->question_options);

if($qo != null && $da != null){
$final = array_combine($qo, $da);
}else{
	if($da != null){
		
		$final = array_combine(array(""),$da);
	}else{
		$final = array_combine(array("",""),array("",""));
	}
// $final = array_combine(array("",""),array("",""));
}
?>
<div class="row trainings">
<div class="col-lg-12">
<div class="card">
	<?= $this->Form->create($trainingQuestion) ?>
	<div class="card-header">
	<?= __('Question') ?>
	</div>
	<div class="card-body card-block">
	<?= $this->Text->autoParagraph(h($trainingQuestion->question)); ?>
	</div>

	<div class="card-header">
	<?= __('Question Options') ?>
	</div>
	<div class="card-body card-block">
     	<?php if(!empty($final)){  
     	foreach ($final as $key => $value) { 
     	?>
		<div class="row">
     	<div class="col-sm-3">
		<?= $this->Form->label('question_options', $key, ['class'=>'col-form-label'])."<br />"; ?>
		</div>
		<div class="col-sm-9">
			<input name='data_attribute[]' value="<?= $value ?>" type="text" class="form-control mt-1" label=false>
		</div>
	</div>
    <?php }}  ?>
	</div>

	<div class="card-header">
	<?= __('Help') ?>
	</div>
	<div class="card-body card-block">
	<?= html_entity_decode($trainingQuestion->help)?>	
	</div>
	<div class="card-body card-block">
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
	</div>
	<?php $this->Form->end(); ?>
</div>
</div>
</div>