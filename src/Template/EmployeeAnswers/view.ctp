<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmployeeAnswer $employeeAnswer
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Employee Answer'), ['action' => 'edit', $employeeAnswer->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Employee Answer'), ['action' => 'delete', $employeeAnswer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employeeAnswer->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Employee Answers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Employee Answer'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Employees'), ['controller' => 'Employees', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Employee'), ['controller' => 'Employees', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Employee Questions'), ['controller' => 'EmployeeQuestions', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Employee Question'), ['controller' => 'EmployeeQuestions', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Clients'), ['controller' => 'Clients', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Client'), ['controller' => 'Clients', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="employeeAnswers view large-9 medium-8 columns content">
    <h3><?= h($employeeAnswer->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Employee') ?></th>
            <td><?= $employeeAnswer->has('employee') ? $this->Html->link($employeeAnswer->employee->id, ['controller' => 'Employees', 'action' => 'view', $employeeAnswer->employee->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Employee Question') ?></th>
            <td><?= $employeeAnswer->has('employee_question') ? $this->Html->link($employeeAnswer->employee_question->id, ['controller' => 'EmployeeQuestions', 'action' => 'view', $employeeAnswer->employee_question->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Client') ?></th>
            <td><?= $employeeAnswer->has('client') ? $this->Html->link($employeeAnswer->client->id, ['controller' => 'Clients', 'action' => 'view', $employeeAnswer->client->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($employeeAnswer->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($employeeAnswer->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified By') ?></th>
            <td><?= $this->Number->format($employeeAnswer->modified_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($employeeAnswer->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($employeeAnswer->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Answer') ?></h4>
        <?= $this->Text->autoParagraph(h($employeeAnswer->answer)); ?>
    </div>
</div>
