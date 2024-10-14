<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContractorSite $contractorSite
 */
?>
<div class="row contractorSites">
<div class="col-lg-12 invoice-responce">

</div>
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong>Add Contractor</strong> Site
	</div>
	<div class="card-body card-block" style="position:relative;">
	<?= $this->Form->create($contractorSite,['url'=> ['action'=>'add',1]]) ?>
	<div class="row form-group">	
	<div class="col-lg-12" style="position:relative;">		
		<?php echo $this->Form->control('site_id', ['options' => $clientSites, 'value' => $selectedSites, 'multiple' => true, 'class'=>'form-control selectwithcheckbox', 'required'=>false]); ?>		
	</div>		
	</div>
	<div class="form-actions form-group">
		<?php echo $this->Form->control('contractor_id', ['type'=>'hidden', 'value' => $contractor_id]); ?>
		<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
		<?= $this->Form->button('<em><i class="fa fa-ban"></i></em> Reset', ['type' => 'reset', 'class'=>'btn btn-danger btn-sm']); ?>
	</div>
	<?= $this->Form->end() ?>
	</div>
</div>
</div>
</div>
