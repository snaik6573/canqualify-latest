<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Benchmark $benchmark
 */
?>
<div class="row benchmarks">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<strong>Edit Benchmark</strong>
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create($benchmark) ?>
		<div class="form-group">
			<?php echo $this->Form->control('benchmark_type_id', ['class'=>'form-control', 'options' => $benchmarkTypes, 'empty' => false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('benchmark_category_id', ['class'=>'form-control', 'required'=>false]); ?>
		</div>
		<!--<div class="form-group">
			<?php echo $this->Form->control('client_id', ['options' => $clients, 'class'=>'form-control', 'empty' => false]); ?>
		</div>-->
		<div class="form-group">
			<?php echo $this->Form->control('range_from', ['class'=>'form-control', 'required'=>false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('range_to', ['class'=>'form-control', 'required'=>false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('is_percentage'); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('icon', ['options'=>$icons, 'class'=>'form-control', 'required'=>false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('conclusion', ['class'=>'form-control', 'required'=>false]); ?>
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
