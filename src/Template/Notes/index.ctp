<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Note[]|\Cake\Collection\CollectionInterface $notes
 */
  $filter_options = array('0'=>'All', '1'=>'Notes','2'=>'Follow Ups');
?>

<div class="row notes">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Notes') ?></strong>
		<div class="">
		<?= $this->Form->create('', ['class'=>'form-inline']) ?>
		<div class="form-group"><?= $this->Form->text('from_date', ['class'=>'form-control from_date','placeholder'=>'Created From']) ?></div>
		<div class="form-group"><?= $this->Form->text('to_date', ['class'=>'form-control to_date','placeholder'=>'Created to']) ?></div>
		<div class="form-group"><?= $this->Form->select('follow_up_range', $filter_options, ['class'=>'form-control','label'=>false]) ?></div>
		<div class="form-actions form-group"><?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type'=>'submit', 'class'=>'btn btn-primary btn-sm']); ?></div>	
		<?= $this->Form->end() ?>
        <p style="font-size:14px;margin:10px 0px;">(For notes date filter will work on notes created date and for follow ups notes filter will work on date which actual follow up set.)</p>
		</div>
	</div>
	
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered" data-order="[ 5, &quot;asc&quot; ]">
	<thead>
	<tr>
		<th scope="col"><?= h('Contractor') ?></th>
		<th scope="col"><?= h('Subject') ?></th>
		<th scope="col"><?= h('Note By') ?></th>
		<th scope="col"><?= h('Follow Up Date') ?></th>
		<th scope="col"><?= h('Created')  ?></th>
		<th scope="col" class="actions"><?= h('Actions') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($notes as $note): ?>
	<tr>
		<td><?= $note->has('contractor') ? $this->Html->link($note->contractor->company_name, ['controller' => 'Contractors', 'action' => 'dashboard', $note->contractor->id]) : '' ?></td>
		<td><?= h($note->subject) ?></td>
		<td>
		<?php if($note->user->has('client')) {
			echo '<b>Client</b> - '. $note->user->client->company_name;
		} elseif($note->user->has('customer_representative')) {
			echo '<b>CR</b> - '.$note->user->customer_representative->pri_contact_fn.' '.$note->user->customer_representative->pri_contact_ln;
		} else {
			if($note->role_id==SUPER_ADMIN || $note->role_id==ADMIN) { echo 'CanQualify'; }
		}
		?>
		</td>
        <td><?= h($note->feature_date) ?></td>
        <td><?= h($note->created) ?></td>
        <td class="actions">
		<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $note->id],['escape'=>false, 'title' => 'View']) ?>

		<?php if($note->created_by == $activeUser['id'] || $activeUser['role_id'] == SUPER_ADMIN || $activeUser['role_id'] == ADMIN) { ?>
		<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $note->id],['escape'=>false, 'title' => 'Edit']) ?>
		<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $note->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $note->id)]) ?>
		<?php } ?>
		</td>		
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	</div>
</div>
</div>
</div>
