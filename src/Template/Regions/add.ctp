<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Region $region
 */
?>
<div class="row regions">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<strong>Add New</strong> Region
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create($region) ?>
		<div class="form-group">
			<?php echo $this->Form->control('name', ['class'=>'form-control', 'required'=>false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('client_id', ['options' => $clients, 'empty' => false, 'class'=>'form-control']); ?>
		</div>
		<div class="form-actions form-group">
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
			<?= $this->Form->button('<em><i class="fa fa-ban"></i></em> Reset', ['type' => 'reset', 'class'=>'btn btn-danger btn-sm']); ?>
		</div>
	<?= $this->Form->end() ?>
	</div>
</div>
</div>
</div>
