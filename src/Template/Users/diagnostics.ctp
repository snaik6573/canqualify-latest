<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row users">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong>Diagnostics</strong>
	</div>
	<div class="card-body">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
	<thead>
	<tr>
		<th scope="col"><?= h('id') ?></th>
		<th scope="col"><?= h('username') ?></th>
		<th scope="col"><?= h('role') ?></th>
        <?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>		
		<th scope="col" class="actions"><?= __('Actions') ?></th>
		<?php } ?>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($users as $user): ?>
	<tr>
		<td><?= $this->Number->format($user->id) ?></td>
		<td><?= h($user->username) ?></td>
		<td><?= $user->has('role_id') ? $user->role->name : $user->role_id ?></td>		
		<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
		<td class="actions">
		<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'deleteDiagnostics', $user->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
		</td>
		<?php } ?>
	</tr>
	<?php endforeach; ?>
	</tbody>
   	</table>
	</div>
</div>
</div>
</div>
