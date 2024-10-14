<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClientRequest $clientRequest
 */

$subject = 'CanQualify - New Client Request  '.$client->company_name;
$message = '<p>Hello '.$contractor->company_name.'</p>';

$message .= '<p> '.$client->company_name. ' I would like to work with your company.</p>';

?>
<div class="row clientRequests">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong>Contractor : <?= $contractor->company_name; ?></strong> 
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create($clientRequest, ['class'=>'saveAjax', 'data-responce'=>'.modal-body', 'data-sendrequest'=>'true']) ?>
		<div class="form-group">
			<?php echo $this->Form->control('subject', ['type'=>'text', 'class'=>'form-control', 'value'=>$subject, 'required'=>true]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->textarea('message', ['class'=>'form-control note', 'value'=>strip_tags($message), 'required'=>true]); ?>
		</div>
    		<div class="form-actions form-group">
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
			<?= $this->Form->button('<em><i class="fa fa-ban"></i></em> Reset', ['type' => 'reset', 'class'=>'btn btn-danger btn-sm']); ?>
		</div>
	<?= $this->Form->end(); ?>
	</div>
</div>
</div>
</div>
