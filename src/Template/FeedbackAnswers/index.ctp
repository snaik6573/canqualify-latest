<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FeedbackAnswer[]|\Cake\Collection\CollectionInterface $feedbackAnswers
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Feedback Answer'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Contractors'), ['controller' => 'Contractors', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Contractor'), ['controller' => 'Contractors', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Feedback Questions'), ['controller' => 'FeedbackQuestions', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Feedback Question'), ['controller' => 'FeedbackQuestions', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="feedbackAnswers index large-9 medium-8 columns content">
    <h3><?= __('Feedback Answers') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('contractor_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('feedback_question_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($feedbackAnswers as $feedbackAnswer): ?>
            <tr>
                <td><?= $this->Number->format($feedbackAnswer->id) ?></td>
                <td><?= $feedbackAnswer->has('contractor') ? $this->Html->link($feedbackAnswer->contractor->id, ['controller' => 'Contractors', 'action' => 'view', $feedbackAnswer->contractor->id]) : '' ?></td>
                <td><?= $feedbackAnswer->has('feedback_question') ? $this->Html->link($feedbackAnswer->feedback_question->id, ['controller' => 'FeedbackQuestions', 'action' => 'view', $feedbackAnswer->feedback_question->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $feedbackAnswer->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $feedbackAnswer->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $feedbackAnswer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $feedbackAnswer->id)]) ?>
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
