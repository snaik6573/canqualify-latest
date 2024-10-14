<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClientService $clientService
 */
?>
<div class="row clientServices">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<strong>Edit</strong> Client Service
	</div>
	<div class="card-body card-block">
		<?= $this->Form->create($clientService) ?>
		<div class="form-group">
			<?php echo $this->Form->control('service_id', ['options' => $services, 'class'=>'form-control', 'required'=>false, 'disabled'=>true]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('discount', ['class'=>'form-control']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('is_percentage', ['class'=>'']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('is_safety_sensitive', ['class'=>'']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('is_safety_nonsensitive', ['class'=>'']); ?>
		</div>
		<div class="form-actions form-group">
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
		</div>
	<?= $this->Form->end() ?>
	</div>
</div>
</div>
</div>
