<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContractorAnswer $contractorAnswer
 */
?>
<div class="row contractorAnswers">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong>Final Submit</strong>
	</div>
	<div class="card-body card-block">
	<div class="form-actions form-group">
	
	<h4>Please Note</h4><br>
	
	<p>By pressing "Final Submit", you will be submitting your data / answers to be verified / qualified by CanQualify.</p>
	<!--During the process of qualification, your account will be locked and you cannot update your data / answers. 
	If you still need to change it, please contact your customer care representative.-->
	<br>
		<!--<?= $this->Html->link('Final Submit', ['controller' => 'OverallIcons', 'action' => 'setIcons', $service_id], ['class'=>'btn btn-success btn-sm']); ?>-->
		<?= $this->Html->link('Final Submit', ['action' => 'finalSubmit', $service_id, 1], ['class'=>'btn btn-success btn-sm']); ?>
	</div>
	</div>
	
</div>
</div>
</div>
