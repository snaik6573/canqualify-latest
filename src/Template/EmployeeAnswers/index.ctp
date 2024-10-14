<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmployeeAnswer[]|\Cake\Collection\CollectionInterface $employeeAnswers
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Employee Answer'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Employees'), ['controller' => 'Employees', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Employee'), ['controller' => 'Employees', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Employee Questions'), ['controller' => 'EmployeeQuestions', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Employee Question'), ['controller' => 'EmployeeQuestions', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Clients'), ['controller' => 'Clients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client'), ['controller' => 'Clients', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="employeeAnswers index large-9 medium-8 columns content">
    <h3><?= __('Employee Answers') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('employee_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('employee_question_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('client_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_by') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified_by') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employeeAnswers as $employeeAnswer): ?>
            <tr>
                <td><?= $this->Number->format($employeeAnswer->id) ?></td>
                <td><?= $employeeAnswer->has('employee') ? $this->Html->link($employeeAnswer->employee->id, ['controller' => 'Employees', 'action' => 'view', $employeeAnswer->employee->id]) : '' ?></td>
                <td><?= $employeeAnswer->has('employee_question') ? $this->Html->link($employeeAnswer->employee_question->id, ['controller' => 'EmployeeQuestions', 'action' => 'view', $employeeAnswer->employee_question->id]) : '' ?></td>
                <td><?= $employeeAnswer->has('client') ? $this->Html->link($employeeAnswer->client->id, ['controller' => 'Clients', 'action' => 'view', $employeeAnswer->client->id]) : '' ?></td>
                <td><?= h($employeeAnswer->created) ?></td>
                <td><?= h($employeeAnswer->modified) ?></td>
                <td><?= $this->Number->format($employeeAnswer->created_by) ?></td>
                <td><?= $this->Number->format($employeeAnswer->modified_by) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $employeeAnswer->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $employeeAnswer->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $employeeAnswer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employeeAnswer->id)]) ?>
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
