<?php
$this->assign('title', 'Dashboard');
?>
<div class="row">
<!--<div class="col-lg-4 col-6">
<div class="card text-white bg-flat-color-1">
    <div class="card-body pb-0">
	<h4 class="mb-0">
        <span class="count"><?= $this->Html->link(__( $clients ), ['controller'=>'CustomerRepresentative', 'action'=>'clientList'], ['escape'=>false, 'title'=>'Clients Assigned', 'class' => 'clickable-div']) ?></span>
	</h4>
	<p class="text-light"><?= $this->Html->link(__( 'Clients' ), ['controller'=>'CustomerRepresentative', 'action'=>'clientList'], ['escape'=>false, 'title'=>'Clients Assigned', 'class' => 'clickable-div']) ?></p>
    </div>
</div>
</div>-->
<div class="col-lg-4 col-4">
<div class="card text-white bg-flat-color-4">
    <div class="card-body pb-0">
	<h4 class="mb-0">
		<span class="count"><?= $this->Html->link(__( $contractors ), ['controller'=>'CustomerRepresentative', 'action'=>'contractorList'], ['escape'=>false, 'title'=>'Contractors Assigned', 'class' => 'clickable-div']) ?></span>
	</h4>
	<p class="text-light"><?= $this->Html->link(__( 'Contractors' ), ['controller'=>'CustomerRepresentative', 'action'=>'contractorList'], ['escape'=>false, 'title'=>'Contractors Assigned', 'class' => 'clickable-div']) ?></p>
    </div>
</div>
</div>
<div class="col-lg-4 col-4">
<div class="card text-white bg-flat-color-3">
    <div class="card-body pb-0">
	<h4 class="mb-0">
		<span class="count"><?= $this->Html->link(__( $followup ), ['controller'=>'Notes', 'action'=>'index', 1], ['escape'=>false, 'title'=>'Follows Up', 'class' => 'clickable-div']) ?></span>
	</h4>
	<p class="text-light"><?= $this->Html->link(__( 'Follow Ups' ), ['controller'=>'Notes', 'action'=>'index', 1], ['escape'=>false, 'title'=>'Follows Up', 'class' => 'clickable-div']) ?></p>
    </div>
</div>
</div>
<div class="col-lg-3 col-4">
        <div class="card text-white bg-flat-color-4">
            <div class="card-body pb-0">
                <h4 class="mb-0">
	<span class="count">
		<?php $userCnt = $this->User->getWaitingonCnt();?>
        <?= $this->Html->link($userCnt, ['controller'=>'Contractors', 'action' => 'pendingContractorList',1],['escape'=>false, 'title' => 'View']) ?>
	</span>
                </h4>
                <p class="text-light">Pending Reviews</p>
            </div>
        </div>
</div>
<div class="col-lg-12">
	<div class="card">
	<div class="card-header">
		<strong>Upcoming Follow Ups</strong>
	</div>
	<div class="card-body card-block table-responsive">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered" data-order="[[ 1, &quot;desc&quot; ]]">
	<thead>
	<tr>
		<th scope="col"><?= h('Contractor') ?></th>
		<th scope="col"><?= h('Subject') ?></th>
		<th scope="col" class="noExport"></th>
		<th scope="col" class="noExport"><?= h('Actions') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php	
	foreach ($todaysfollowup as $follow) { ?>
	<tr>
		<td><?= $this->Html->link($follow['company_name'], ['controller' => 'Contractors','action' => 'dashboard', $follow['contractor_id']],['escape'=>false, 'title' => 'View']) ?></td>
		<td><?= $follow['subject'] ?></td>
        <td>
		<?= $this->Html->link(__('Add Note / Follow up'), ['controller' => 'Notes', 'action'=>'addCrNote', $follow['contractor_id']], ['class'=>'btn btn-sm btn-success mt-2', 'target'=>'_BLANK']) ; ?><br />
		<?= $follow['renew_subscription'] && !$follow['send_invoice'] ? $this->Html->link(__('Send Invoice'), ['action'=>'sendInvoice', $follow['contractor_id']], ['class'=>'ajaxmodal btn btn-sm btn-success mt-2', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal2']) : '' ?>
		</td>
        <td class="actions">
		<?= $this->Html->link('<i class="fa fa-eye"></i>', ['controller' => 'Notes', 'action' => 'view', $follow['id']],['escape'=>false, 'title' => 'View']) ?>
		<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['controller' => 'Notes', 'action' => 'edit', $follow['id']],['escape'=>false, 'title' => 'Edit']) ?>
		<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['controller' => 'Notes', 'action' => 'delete', $follow['id']], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $follow['id'])]) ?>
		</td>
	</tr>
	<?php
	}
	?>
	</tbody>
	</table>
	</div>
	</div><!-- card -->

</div>
</div>
<!--
<div class="modal fade" id="scrollmodal" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-title">Add Note / Follow up</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="modal-body">
	</div>
</div>
</div>
</div>-->

<div class="modal fade" id="scrollmodal2" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-title">Send Invoice</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="modal-body">
	</div>
</div>
</div>
</div>



