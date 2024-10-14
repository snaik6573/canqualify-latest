<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Module $module
 */
?>

<div class="row roles">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= h($module->name) ?>
	</div>
	<div class="card-body card-block">
	<table class="table">
		<tr>
			<th scope="row"><?= __('Name') ?></th>
			<td><?= h($module->name) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Id') ?></th>
			<td><?= $this->Number->format($module->id) ?></td>
		</tr>		
		<tr>
			<th scope="row"><?= __('Created By') ?></th>
			<td><?= $this->Html->link($module->created_by, ['controller' => 'Users', 'action' => 'view', $module->created_by]) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Modified By') ?></th>
			<td><?= $this->Html->link($module->modified_by, ['controller' => 'Users', 'action' => 'view', $module->modified_by]) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Created') ?></th>
			<td><?= h($module->created) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Modified') ?></th>
			<td><?= h($module->modified) ?></td>
		</tr>
	</table>
	</div>
</div>
</div>
</div>
<div class="row related">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<?= __('Related Client Modules') ?>
<span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller' => 'ClientModules', 'action' => 'add', $module->id],['class'=>'btn btn-success btn-sm']) ?> </span>
	</div>
	<div class="card-body card-block">
	<?php if (!empty($training->training_questions)): ?>
	<table class="bootstrap-data-table-export table table-striped table-bordered">
	<thead>
		<tr>
			<th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Client Id') ?></th>
                <th scope="col"><?= __('Module Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col"><?= __('Created By') ?></th>
                <th scope="col"><?= __('Modified By') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
		</tr>
		</thead>
        <tbody>
            <?php foreach ($module->client_modules as $clientModules): ?>
            <tr>
                <td><?= h($clientModules->id) ?></td>
                <td><?= h($clientModules->client_id) ?></td>
                <td><?= h($clientModules->module_id) ?></td>
                <td><?= h($clientModules->created) ?></td>
                <td><?= h($clientModules->modified) ?></td>
                <td><?= h($clientModules->created_by) ?></td>
                <td><?= h($clientModules->modified_by) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ClientModules', 'action' => 'view', $clientModules->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ClientModules', 'action' => 'edit', $clientModules->id]) ?>
                    <?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
				    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ClientModules', 'action' => 'delete', $clientModules->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientModules->id)]) ?>
					<?php } ?>
				</td>
            </tr>
            <?php endforeach; ?>
			</tbody>
        </table>
        <?php endif; ?>
	</div>
</div>
</div>
</div>