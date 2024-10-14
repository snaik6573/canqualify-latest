<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClientEmployeeQuestion[]|\Cake\Collection\CollectionInterface $clientEmployeeQuestions
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Client Employee Question'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Clients'), ['controller' => 'Clients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client'), ['controller' => 'Clients', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Employee Questions'), ['controller' => 'EmployeeQuestions', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Employee Question'), ['controller' => 'EmployeeQuestions', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="clientEmployeeQuestions index large-9 medium-8 columns content">
    <h3><?= __('Client Employee Questions') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('client_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('employee_question_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_compulsory') ?></th>
                <th scope="col"><?= $this->Paginator->sort('correct_answer') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_by') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified_by') ?></th>
                <th scope="col"><?= $this->Paginator->sort('employee_category_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientEmployeeQuestions as $clientEmployeeQuestion): ?>
            <tr>
                <td><?= $this->Number->format($clientEmployeeQuestion->id) ?></td>
                <td><?= $clientEmployeeQuestion->has('client') ? $this->Html->link($clientEmployeeQuestion->client->id, ['controller' => 'Clients', 'action' => 'view', $clientEmployeeQuestion->client->id]) : '' ?></td>
                <td><?= $clientEmployeeQuestion->has('employee_question') ? $this->Html->link($clientEmployeeQuestion->employee_question->id, ['controller' => 'EmployeeQuestions', 'action' => 'view', $clientEmployeeQuestion->employee_question->id]) : '' ?></td>
                <td><?= h($clientEmployeeQuestion->is_compulsory) ?></td>
                <td><?= h($clientEmployeeQuestion->correct_answer) ?></td>
                <td><?= h($clientEmployeeQuestion->created) ?></td>
                <td><?= h($clientEmployeeQuestion->modified) ?></td>
                <td><?= $this->Number->format($clientEmployeeQuestion->created_by) ?></td>
                <td><?= $this->Number->format($clientEmployeeQuestion->modified_by) ?></td>
                <td><?= $this->Number->format($clientEmployeeQuestion->employee_category_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $clientEmployeeQuestion->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $clientEmployeeQuestion->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $clientEmployeeQuestion->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientEmployeeQuestion->id)]) ?>
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
