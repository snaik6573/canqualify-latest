<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FeedbackAnswer $feedbackAnswer
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Feedback Answer'), ['action' => 'edit', $feedbackAnswer->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Feedback Answer'), ['action' => 'delete', $feedbackAnswer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $feedbackAnswer->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Feedback Answers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Feedback Answer'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Contractors'), ['controller' => 'Contractors', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Contractor'), ['controller' => 'Contractors', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Feedback Questions'), ['controller' => 'FeedbackQuestions', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Feedback Question'), ['controller' => 'FeedbackQuestions', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="feedbackAnswers view large-9 medium-8 columns content">
    <h3><?= h($feedbackAnswer->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Contractor') ?></th>
            <td><?= $feedbackAnswer->has('contractor') ? $this->Html->link($feedbackAnswer->contractor->id, ['controller' => 'Contractors', 'action' => 'view', $feedbackAnswer->contractor->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Feedback Question') ?></th>
            <td><?= $feedbackAnswer->has('feedback_question') ? $this->Html->link($feedbackAnswer->feedback_question->id, ['controller' => 'FeedbackQuestions', 'action' => 'view', $feedbackAnswer->feedback_question->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($feedbackAnswer->id) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Answer') ?></h4>
        <?= $this->Text->autoParagraph(h($feedbackAnswer->answer)); ?>
    </div>
</div>
