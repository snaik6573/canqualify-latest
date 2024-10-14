<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TrainingAnswer[]|\Cake\Collection\CollectionInterface $trainingAnswers
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Training Answer'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Employees'), ['controller' => 'Employees', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Employee'), ['controller' => 'Employees', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Training Questions'), ['controller' => 'TrainingQuestions', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Training Question'), ['controller' => 'TrainingQuestions', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="trainingAnswers index large-9 medium-8 columns content">
    <h3><?= __('Training Answers') ?></h3>
    <table class="bootstrap-data-table-export" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('employee_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('training_questions_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_by') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified_by') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($trainingAnswers as $trainingAnswer): ?>
            <tr>
                <td><?= $this->Number->format($trainingAnswer->id) ?></td>
                <td><?= $trainingAnswer->has('employee') ? $this->Html->link($trainingAnswer->employee->id, ['controller' => 'Employees', 'action' => 'view', $trainingAnswer->employee->id]) : '' ?></td>
                <td><?= $trainingAnswer->has('training_question') ? $this->Html->link($trainingAnswer->training_question->id, ['controller' => 'TrainingQuestions', 'action' => 'view', $trainingAnswer->training_question->id]) : '' ?></td>
                <td><?= h($trainingAnswer->created) ?></td>
                <td><?= h($trainingAnswer->modified) ?></td>
                <td><?= $this->Number->format($trainingAnswer->created_by) ?></td>
                <td><?= $this->Number->format($trainingAnswer->modified_by) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $trainingAnswer->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $trainingAnswer->id]) ?>
					<?php if($activeUser['role_id'] != ADMIN) { ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $trainingAnswer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $trainingAnswer->id)]) ?>
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
