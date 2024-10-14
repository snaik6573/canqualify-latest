<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmployeeContractor $employeeContractor
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Employee Contractor'), ['action' => 'edit', $employeeContractor->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Employee Contractor'), ['action' => 'delete', $employeeContractor->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employeeContractor->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Employee Contractors'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Employee Contractor'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Employees'), ['controller' => 'Employees', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Employee'), ['controller' => 'Employees', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Contractors'), ['controller' => 'Contractors', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Contractor'), ['controller' => 'Contractors', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="employeeContractors view large-9 medium-8 columns content">
    <h3><?= h($employeeContractor->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Employee') ?></th>
            <td><?= $employeeContractor->has('employee') ? $this->Html->link($employeeContractor->employee->id, ['controller' => 'Employees', 'action' => 'view', $employeeContractor->employee->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Contractor') ?></th>
            <td><?= $employeeContractor->has('contractor') ? $this->Html->link($employeeContractor->contractor->id, ['controller' => 'Contractors', 'action' => 'view', $employeeContractor->contractor->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($employeeContractor->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($employeeContractor->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified By') ?></th>
            <td><?= $this->Number->format($employeeContractor->modified_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($employeeContractor->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($employeeContractor->modified) ?></td>
        </tr>
    </table>
</div>
