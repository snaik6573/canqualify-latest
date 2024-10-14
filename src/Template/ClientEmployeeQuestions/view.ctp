<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClientEmployeeQuestion $clientEmployeeQuestion
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Client Employee Question'), ['action' => 'edit', $clientEmployeeQuestion->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Client Employee Question'), ['action' => 'delete', $clientEmployeeQuestion->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientEmployeeQuestion->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Client Employee Questions'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Client Employee Question'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Clients'), ['controller' => 'Clients', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Client'), ['controller' => 'Clients', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Employee Questions'), ['controller' => 'EmployeeQuestions', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Employee Question'), ['controller' => 'EmployeeQuestions', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="clientEmployeeQuestions view large-9 medium-8 columns content">
    <h3><?= h($clientEmployeeQuestion->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Client') ?></th>
            <td><?= $clientEmployeeQuestion->has('client') ? $this->Html->link($clientEmployeeQuestion->client->id, ['controller' => 'Clients', 'action' => 'view', $clientEmployeeQuestion->client->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Employee Question') ?></th>
            <td><?= $clientEmployeeQuestion->has('employee_question') ? $this->Html->link($clientEmployeeQuestion->employee_question->id, ['controller' => 'EmployeeQuestions', 'action' => 'view', $clientEmployeeQuestion->employee_question->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Correct Answer') ?></th>
            <td><?= h($clientEmployeeQuestion->correct_answer) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($clientEmployeeQuestion->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($clientEmployeeQuestion->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified By') ?></th>
            <td><?= $this->Number->format($clientEmployeeQuestion->modified_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Employee Category Id') ?></th>
            <td><?= $this->Number->format($clientEmployeeQuestion->employee_category_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($clientEmployeeQuestion->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($clientEmployeeQuestion->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Compulsory') ?></th>
            <td><?= $clientEmployeeQuestion->is_compulsory ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
