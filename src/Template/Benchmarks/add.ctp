<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Benchmark $benchmark
 */
?>
<div class="row benchmarks">
<div class="col-lg-12">
<div class="card">
	<?php if(!empty($client)) : ?>		
	<div class="card-header">
		<strong>Add New</strong> Benchmark

		<span class="pull-right"><?= $this->Html->link(__('Add New Category'), ['controller' => 'BenchmarkCategories', 'action' => 'add', $client->id],['class'=>'ajaxmodal btn btn-sm btn-success', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal']) ?> </span>
	</div>
		<div class="card-body card-block">
		<?= $this->Form->create($benchmark) ?>
		<div class="row form-group">
		<label class="col-sm-3">Benchmark Type</label>
		<div class="col-sm-3"><?php echo $this->Form->control('benchmark_type_id', ['class'=>'form-control', 'options' => $benchmarkTypes, 'empty' => false,'label' =>false]); ?></div>
		</div>
		<div class="row form-group">
		<label class="col-sm-3">Benchmark Category</label>
		<div class="col-sm-3"><?php echo $this->Form->control('benchmark_category_id', ['class'=>'form-control', 'empty'=>false,'label' =>false]); ?></div>
		</div>
		<div class="row form-group">
		<label class="col-sm-3">Range From</label>
		<div class="col-sm-3"><?php echo $this->Form->control('range_from', ['class'=>'form-control', 'required'=>false,'label'=>false]); ?></div>
		</div>
		<div class="row form-group">
		<label class="col-sm-3">Range To</label>
		<div class="col-sm-3"><?php echo $this->Form->control('range_to', ['class'=>'form-control', 'required'=>false,'label'=>false]); ?></div>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('is_percentage'); ?>
		</div>
		<div class="row form-group">
		<label class="col-sm-3">Icon</label>
		<div class="col-sm-3"><?php echo $this->Form->control('icon', ['options'=>$icons, 'class'=>'form-control', 'required'=>false,'label'=>false]); ?></div>
		</div>
		<div class="row form-group">
		<label class="col-sm-3">Conclusion</label>
		<div class="col-sm-6"><?php echo $this->Form->control('conclusion', ['class'=>'form-control', 'required'=>false,'label'=>false]); ?></div>
		</div>
		<div class="form-actions form-group">
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
			<?= $this->Form->button('<em><i class="fa fa-ban"></i></em> Reset', ['type' => 'reset', 'class'=>'btn btn-danger btn-sm']); ?>
		</div>
		<?= $this->Form->end() ?>
		</div>
<?php endif; ?>
</div>
</div>
</div>


<div class="modal fade" id="scrollmodal" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-title">Add Benchmark Category</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="modal-body">
	</div>
</div>
</div>
</div>
