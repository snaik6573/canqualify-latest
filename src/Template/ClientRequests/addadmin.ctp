<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClientRequest $clientRequest
 */
?>
<div class="row clientRequests">
<div class="col-lg-12">
<div class="card">
	<!-- <div class="card-header">
		<strong></strong> 
	</div> -->
	<div class="card-body card-block">
	<?= $this->Form->create(null, ['class'=>'saveAjax reloadpage', 'data-responce'=>'.modal-body', 'data-sendrequest'=>'true']) ?>
		<div class="form-group">
			<?php echo $this->Form->control('subject', ['type'=>'text', 'class'=>'form-control', 'required'=>false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('message', ['type'=>'textarea', 'class'=>'form-control', 'required'=>false]); ?>
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
