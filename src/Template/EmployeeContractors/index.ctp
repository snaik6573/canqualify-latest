<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmployeeContractor[]|\Cake\Collection\CollectionInterface $employeeContractors
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Employee Contractor'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Employees'), ['controller' => 'Employees', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Employee'), ['controller' => 'Employees', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Contractors'), ['controller' => 'Contractors', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Contractor'), ['controller' => 'Contractors', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="employeeContractors index large-9 medium-8 columns content">
    <h3><?= __('Employee Contractors') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('employee_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('contractor_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_by') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified_by') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employeeContractors as $employeeContractor): ?>
            <tr>
                <td><?= $this->Number->format($employeeContractor->id) ?></td>
                <td><?= $employeeContractor->has('employee') ? $this->Html->link($employeeContractor->employee->id, ['controller' => 'Employees', 'action' => 'view', $employeeContractor->employee->id]) : '' ?></td>
                <td><?= $employeeContractor->has('contractor') ? $this->Html->link($employeeContractor->contractor->id, ['controller' => 'Contractors', 'action' => 'view', $employeeContractor->contractor->id]) : '' ?></td>
                <td><?= h($employeeContractor->created) ?></td>
                <td><?= h($employeeContractor->modified) ?></td>
                <td><?= $this->Number->format($employeeContractor->created_by) ?></td>
                <td><?= $this->Number->format($employeeContractor->modified_by) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $employeeContractor->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $employeeContractor->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $employeeContractor->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employeeContractor->id)]) ?>
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
