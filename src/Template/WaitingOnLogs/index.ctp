<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\WaitingOnLog[]|\Cake\Collection\CollectionInterface $waitingOnLogs
 */
?>
<div class="row waitingOnLogs">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Waiting On Change Logs') ?></strong>
	</div>
	
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table" class="table table-striped table-bordered" data-order="[ 0, &quot;desc&quot; ]">
        <thead>
            <tr>
                <th scope="col"><?= h('Id') ?></th>
                <th scope="col"><?= h('Contractor') ?></th>
                <th scope="col"><?= h('Form status') ?></th>
                <th scope="col"><?= h('To status') ?></th>
				  <th scope="col"><?= h('Saved from') ?></th>
                <th scope="col"><?= h('Created') ?></th>
                <th scope="col"><?= h('Created by') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($waitingOnLogs as $waitingOnLog): ?>
            <tr>
                <td><?= $this->Number->format($waitingOnLog->id) ?></td>
                <td><?= $waitingOnLog->has('contractor') ? $this->Html->link($waitingOnLog->contractor->company_name, ['controller' => 'Contractors', 'action' => 'view', $waitingOnLog->contractor->id]) : '' ?></td>
                <td><?= h($waitingOnLog->from_status) ?></td>
                <td><?= h($waitingOnLog->to_status) ?></td>
				  <td><?= h($waitingOnLog->saved_from) ?></td>
                <td><?= h($waitingOnLog->created) ?></td>
                <td><?= $this->Html->link($waitingOnLog->created_by, ['controller' => 'Users', 'action' => 'view', $waitingOnLog->created_by]) ?>
                <td class="actions">
                    <?= $this->Form->postLink(__('<i class="fa fa-trash-o"></i>'), ['action' => 'delete', $waitingOnLog->id], ['escape'=>false, 'confirm' => __('Are you sure you want to delete # {0}?', $waitingOnLog->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	</div>
</div>
</div>
</div>