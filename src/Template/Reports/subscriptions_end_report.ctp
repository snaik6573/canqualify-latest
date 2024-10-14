<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Client[]|\Cake\Collection\CollectionInterface $clients
 */ 
use Cake\Core\Configure;
$iconList = Configure::read('icons'); //, array('0'=>'Grey','1'=>'Red','2'=>'Yellow','3'=>'Green')
$users = array(CLIENT_VIEW, CLIENT_BASIC);
?>
<div class="row clients">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Subscription Expired Suppliers') ?></strong>		
		<span class="pull-right"><?= $this->Html->link(__('Export to Excel'), ['controller' => 'Contractors', 'action' => 'subscriptionsEndReport/excel'],['class'=>'mr-2']) ?> </span>
		<span class="pull-right"><?= $this->Html->link(__('Export to CSV'), ['controller' => 'Contractors', 'action' => 'subscriptionsEndReport/csv'],['class'=>'mr-2']) ?>&nbsp;&nbsp;|&nbsp;&nbsp;</span>

	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table" class="table table-striped table-bordered" data-order="[[ 1, &quot;asc&quot; ]]">
	<thead>
	<tr>
		<th scope="col"><?= h('Contractor Name') ?></th>
		<th scope="col"><?= h('Active') ?></th>
		<th scope="col"><?= h('Primary Contact') ?></th>
		<th scope="col"><?= h('Phone') ?></th>
		<th scope="col"><?= h('Email') ?></th>
		<th scope="col"><?= h('Subscription End Date') ?></th>
		<?php // if (!in_array($activeUser['role_id'], $users)) { ?>
		<!-- <th scope="col" class="noExport"><?= h('Actions') ?></th> -->
		<?php //}?>
		<th scope="col"><?= h('Marked Expired') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php
	foreach ($contList as $contractor):
        //debug($contractor);die;
	?>
	<tr>
		<td><?= $this->Html->link($contractor->company_name, ['controller' => 'Contractors','action' => 'dashboard', $contractor->id],['escape'=>false, 'title' => 'View']) ?></td>
		<td><?= h($contractor->user->active) == 1 ? 'Yes' : 'No'; ?></td>
		<td><?= h($contractor->pri_contact_fn.' '.$contractor->pri_contact_ln); ?></td>
		<td><?= h($contractor->pri_contact_pn) ?></td>
		<td><?= h($contractor->user->username); ?></td>
        <td><?= !empty($contractor->subscription_date) ? date('m/d/Y', strtotime($contractor->subscription_date))  : '' ?></td>
		<td>
            <span style="display:none;"><?= $contractor->expired ? '1' : '0' ?></span>
            <?= $this->Form->create($contractor,['class'=>'saveAjax', 'data-responce'=>'.alert-wrap']) ?>
            <?php echo $this->Form->control('contractor.expired', ['required'=>false, 'label'=>false, 'class'=>'ajaxClick', 'checked' => ($contractor->expired == 1) ? 'checked' : '']); ?>
            <?php echo $this->Form->control('contractor.id', ['type'=>'hidden', 'value' => $contractor->id]); ?>
            <?= $this->Form->end() ?>
        </td>
		<?php //}?>
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	</div>
</div>
</div>
</div>


<div class="modal fade" id="scrollmodal" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-title">Safety Report</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="modal-body">
	</div>
</div>
</div>
</div>

<div class="modal fade" id="scrollmodal1" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-title">Review</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="modal-body">
	</div>
</div>
</div>
</div>

<div class="modal fade" id="scrollmodal2" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-title">Force Change Icon Status</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="modal-body">
	</div>
</div>
</div>
</div>
