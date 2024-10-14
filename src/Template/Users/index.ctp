<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="row users">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('All Users') ?></strong>
		<span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller' => 'Users', 'action' => 'add'],['class'=>'btn btn-success btn-sm']) ?> </span>
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export1" class="table table-striped table-bordered data-table-ajax" data-order="[[ 1, &quot;asc&quot; ]]">
	<thead>
	<tr>
		<th scope="col"><?= h('Id') ?></th>
		<th scope="col"><?= h('Username') ?></th>
		<!--<th scope="col"><?= h('Company Name') ?></th>
		<th scope="col"><?= h('Primary Contact') ?></th>-->
		<th scope="col"><?= h('Role') ?></th>
		<th scope="col"><?= h('Active') ?></th>
		<th scope="col" class="actions" data-orderable="false"><?= __('Actions') ?></th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td colspan="7" class="dataTables_empty">Loading data from server...</td>
	</tr>
	<?php /*foreach ($users as $user): ?>
	<tr>
		<td><?= $this->Number->format($user->id) ?></td>
		<td><?= h($user->username) ?></td>
		<td>Canqualify</td>
        <td></td>
		<td><?= $this->Html->link($user->role->role_title, ['controller' => 'Roles', 'action' => 'view', $user->role_id]) ?></td>
		<td>
            <span style="display:none;"><?= $user->active ? '1' : '0' ?></span>
			<?= $this->Form->create($user,['class'=>'saveAjax', 'data-responce'=>'.alert-wrap']) ?>
			<?php echo $this->Form->control('active', ['required' => false, 'label'=> false, 'class'=>'ajaxClick']); ?>
			<?php echo $this->Form->control('id', ['type'=>'hidden']); ?>
			<?php echo $this->Form->control('role_id', ['type'=>'hidden']); ?>
			<?php echo $this->Form->control('username', ['type'=>'hidden']); ?>
			<?= $this->Form->end() ?>
		</td>
		<td class="actions">
		<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $user->id],['escape'=>false, 'title' => 'View']) ?>
		<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $user->id],['escape'=>false, 'title' => 'Edit']) ?>
		<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
		<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $user->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
		<?php } ?>
		</td>
	</tr>
	<?php endforeach; ?>

	<?php foreach ($cr as $user): ?>
	<tr>
		<td><?= $this->Number->format($user->id) ?></td>
		<td><?= h($user->username) ?></td>
		<td>Canqualify</td>
		<td><?= $user->has('customer_representative') ? h($user->customer_representative->pri_contact_fn . ' ' .$user->customer_representative->pri_contact_ln) : '' ?></td>
		<td><?= $this->Html->link($user->role->role_title, ['controller' => 'Roles', 'action' => 'view', $user->role_id]) ?></td>
		<td>
            <span style="display:none;"><?= $user->active ? '1' : '0' ?></span>
			<?= $this->Form->create($user,['class'=>'saveAjax', 'data-responce'=>'.alert-wrap']) ?>
			<?php echo $this->Form->control('active', ['required' => false, 'label'=> false, 'class'=>'ajaxClick']); ?>
			<?php echo $this->Form->control('id', ['type'=>'hidden']); ?>
			<?php echo $this->Form->control('role_id', ['type'=>'hidden']); ?>
			<?php echo $this->Form->control('username', ['type'=>'hidden']); ?>
			<?= $this->Form->end() ?>
		</td>
		<td class="actions">
		<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $user->id],['escape'=>false, 'title' => 'View']) ?>
		<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $user->id],['escape'=>false, 'title' => 'Edit']) ?>
		<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
		<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $user->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
		<?php } ?>
		</td>
	</tr>
	<?php endforeach; ?>

	<?php foreach ($clients as $user): ?>
	<tr>
		<td><?= $this->Number->format($user->id) ?></td>
		<td><?= h($user->username) ?></td>
		<td><?= $user->has('client') ? h($user->client->company_name) : '' ?></td>
		<td><?= $user->has('client') ? h($user->client->pri_contact_fn . ' ' .$user->client->pri_contact_ln) : '' ?></td>
		<td><?= $this->Html->link($user->role->role_title, ['controller' => 'Roles', 'action' => 'view', $user->role_id]) ?></td>
		<td>
            <span style="display:none;"><?= $user->active ? '1' : '0' ?></span>
			<?= $this->Form->create($user,['class'=>'saveAjax', 'data-responce'=>'.alert-wrap']) ?>
			<?php echo $this->Form->control('active', ['required' => false, 'label'=> false, 'class'=>'ajaxClick']); ?>
			<?php echo $this->Form->control('id', ['type'=>'hidden']); ?>
			<?php echo $this->Form->control('role_id', ['type'=>'hidden']); ?>
			<?php echo $this->Form->control('username', ['type'=>'hidden']); ?>
			<?= $this->Form->end() ?>
		</td>
		<td class="actions">
		<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $user->id],['escape'=>false, 'title' => 'View']) ?>
		<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $user->id],['escape'=>false, 'title' => 'Edit']) ?>
		<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
		<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $user->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
		<?php } ?>
		</td>
	</tr>
	<?php endforeach; ?>

	<?php foreach ($contractors as $user): ?>
	<tr>
		<td><?= $this->Number->format($user->id) ?></td>
		<td><?= h($user->username) ?></td>
		<td><?= $user->has('contractor') ? h($user->contractor->company_name) : '' ?></td>
		<td><?= $user->has('contractor') ? h($user->contractor->pri_contact_fn . ' ' .$user->contractor->pri_contact_ln) : '' ?></td>
		<td><?= $this->Html->link($user->role->role_title, ['controller' => 'Roles', 'action' => 'view', $user->role_id]) ?></td>
		<td>
            <span style="display:none;"><?= $user->active ? '1' : '0' ?></span>
			<?= $this->Form->create($user,['class'=>'saveAjax', 'data-responce'=>'.alert-wrap']) ?>
			<?php echo $this->Form->control('active', ['required' => false, 'label'=> false, 'class'=>'ajaxClick']); ?>
			<?php echo $this->Form->control('id', ['type'=>'hidden']); ?>
			<?php echo $this->Form->control('role_id', ['type'=>'hidden']); ?>
			<?php echo $this->Form->control('username', ['type'=>'hidden']); ?>
			<?= $this->Form->end() ?>
		</td>
		<td class="actions">
		<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $user->id],['escape'=>false, 'title' => 'View']) ?>
		<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $user->id],['escape'=>false, 'title' => 'Edit']) ?>
		<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
		<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $user->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
		<?php } ?>
		</td>
	</tr>
	<?php endforeach; ?>

	<?php foreach ($employees as $user): ?>
	<tr>
		<td><?= $this->Number->format($user->id) ?></td>
		<td><?= h($user->username) ?></td>
		<td><?= $user->has('employee') ? h($user->employee->contractor->company_name) : '' ?></td>
		<td><?= $user->has('employee') ? h($user->employee->pri_contact_fn . ' ' .$user->employee->pri_contact_ln) : '' ?></td>
		<td><?= $this->Html->link($user->role->role_title, ['controller' => 'Roles', 'action' => 'view', $user->role_id]) ?></td>
		<td>
            <span style="display:none;"><?= $user->active ? '1' : '0' ?></span>
			<?= $this->Form->create($user,['class'=>'saveAjax', 'data-responce'=>'.alert-wrap']) ?>
			<?php echo $this->Form->control('active', ['required' => false, 'label'=> false, 'class'=>'ajaxClick']); ?>
			<?php echo $this->Form->control('id', ['type'=>'hidden']); ?>
			<?php echo $this->Form->control('role_id', ['type'=>'hidden']); ?>
			<?php echo $this->Form->control('username', ['type'=>'hidden']); ?>
			<?= $this->Form->end() ?>
		</td>
		<td class="actions">
		<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $user->id],['escape'=>false, 'title' => 'View']) ?>
		<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $user->id],['escape'=>false, 'title' => 'Edit']) ?>
		<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
		<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $user->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
		<?php } ?>
		</td>
	</tr>
	<?php endforeach; ?>

	<?php foreach ($clientUsers as $user): ?>
	<tr>
		<td><?= $this->Number->format($user->id) ?></td>
		<td><?= h($user->username) ?></td>
		<td><?= $user->has('client_user') ? h($user->client_user->client->company_name) : '' ?></td>
		<td><?= $user->has('client_user') ? h($user->client_user->pri_contact_fn . ' ' .$user->client_user->pri_contact_ln) : '' ?></td>
		<td><?= $this->Html->link($user->role->role_title, ['controller' => 'Roles', 'action' => 'view', $user->role_id]) ?></td>
		<td>
            <span style="display:none;"><?= $user->active ? '1' : '0' ?></span>
			<?= $this->Form->create($user,['class'=>'saveAjax', 'data-responce'=>'.alert-wrap']) ?>
			<?php echo $this->Form->control('active', ['required' => false, 'label'=> false, 'class'=>'ajaxClick']); ?>
			<?php echo $this->Form->control('id', ['type'=>'hidden']); ?>
			<?php echo $this->Form->control('role_id', ['type'=>'hidden']); ?>
			<?php echo $this->Form->control('username', ['type'=>'hidden']); ?>
			<?= $this->Form->end() ?>
		</td>
		<td class="actions">
		<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $user->id],['escape'=>false, 'title' => 'View']) ?>
		<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $user->id],['escape'=>false, 'title' => 'Edit']) ?>
		<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
		<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $user->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
		<?php } ?>
		</td>
	</tr>
	<?php endforeach; ?>

	<?php foreach ($contractorUsers as $user): ?>
	<tr>
		<td><?= $this->Number->format($user->id) ?></td>
		<td><?= h($user->username) ?></td>
		<td><?= $user->has('contractor_user') ? h($user->contractor_user->contractor->company_name) : '' ?></td>
		<td><?= $user->has('contractor_user') ? h($user->contractor_user->pri_contact_fn . ' ' .$user->contractor_user->pri_contact_ln) : '' ?></td>
		<td><?= $this->Html->link($user->role->role_title, ['controller' => 'Roles', 'action' => 'view', $user->role_id]) ?></td>
		<td>
            <span style="display:none;"><?= $user->active ? '1' : '0' ?></span>
			<?= $this->Form->create($user,['class'=>'saveAjax', 'data-responce'=>'.alert-wrap']) ?>
			<?php echo $this->Form->control('active', ['required' => false, 'label'=> false, 'class'=>'ajaxClick']); ?>
			<?php echo $this->Form->control('id', ['type'=>'hidden']); ?>
			<?php echo $this->Form->control('role_id', ['type'=>'hidden']); ?>
			<?php echo $this->Form->control('username', ['type'=>'hidden']); ?>
			<?= $this->Form->end() ?>
		</td>
		<td class="actions">
		<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $user->id],['escape'=>false, 'title' => 'View']) ?>
		<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $user->id],['escape'=>false, 'title' => 'Edit']) ?>
		<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
		<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $user->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
		<?php } ?>
		</td>
	</tr>
	<?php endforeach;*/ ?>
	</tbody>
   	</table>
	</div>
</div>
</div>
</div>

<script>
	var dtAjaxUrl = "<?= $this->request->getRequestTarget(); ?>";
</script>
