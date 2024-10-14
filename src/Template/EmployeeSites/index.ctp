<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmployeeSite[]|\Cake\Collection\CollectionInterface $employeeSites
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Employee Site'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Employees'), ['controller' => 'Employees', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Employee'), ['controller' => 'Employees', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sites'), ['controller' => 'Sites', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Site'), ['controller' => 'Sites', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="employeeSites index large-9 medium-8 columns content">
    <h3><?= __('Employee Sites') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('employee_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('site_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_by') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified_by') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employeeSites as $employeeSite): ?>
            <tr>
                <td><?= $this->Number->format($employeeSite->id) ?></td>
                <td><?= $employeeSite->has('employee') ? $this->Html->link($employeeSite->employee->id, ['controller' => 'Employees', 'action' => 'view', $employeeSite->employee->id]) : '' ?></td>
                <td><?= $employeeSite->has('site') ? $this->Html->link($employeeSite->site->name, ['controller' => 'Sites', 'action' => 'view', $employeeSite->site->id]) : '' ?></td>
                <td><?= h($employeeSite->created) ?></td>
                <td><?= h($employeeSite->modified) ?></td>
                <td><?= $this->Number->format($employeeSite->created_by) ?></td>
                <td><?= $this->Number->format($employeeSite->modified_by) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $employeeSite->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $employeeSite->id]) ?>
					<?php if($activeUser['role_id'] != ADMIN) { ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $employeeSite->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employeeSite->id)]) ?>
					<?php } ?>
			   </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
