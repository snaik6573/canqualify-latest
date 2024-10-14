<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>
<div class="row products">
<div class="col-lg-6">
<div class="card">
	<div class="card-header clearfix">
		<strong>Edit</strong> Product
		<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
		<span class="pull-right"><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $product->id], ['class'=>'btn btn-danger btn-sm', 'confirm' => __('Are you sure you want to delete # {0}?', $product->id)]) ?></span>
		<?php } ?>
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create($product) ?>
   		<div class="form-group">
			<?php echo $this->Form->control('name', ['class'=>'form-control', 'required'=>false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('range_from', ['class'=>'form-control', 'required'=>false, 'min'=>'0']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('range_to', ['class'=>'form-control', 'required'=>false, 'min'=>'0']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('pricing', ['class'=>'form-control', 'required'=>false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('service_id', ['class'=>'form-control', 'options' => $services, 'empty' => false]); ?>
		</div>
		<div class="form-actions form-group">
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
		</div>
	<?= $this->Form->end() ?>
	</div>
</div>
</div>
</div>
