<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FeedbackQuestion $feedbackQuestion
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Feedback Question'), ['action' => 'edit', $feedbackQuestion->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Feedback Question'), ['action' => 'delete', $feedbackQuestion->id], ['confirm' => __('Are you sure you want to delete # {0}?', $feedbackQuestion->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Feedback Questions'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Feedback Question'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Feedback Answers'), ['controller' => 'FeedbackAnswers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Feedback Answer'), ['controller' => 'FeedbackAnswers', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="feedbackQuestions view large-9 medium-8 columns content">
    <h3><?= h($feedbackQuestion->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($feedbackQuestion->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($feedbackQuestion->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($feedbackQuestion->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Question') ?></h4>
        <?= $this->Text->autoParagraph(h($feedbackQuestion->question)); ?>
    </div>
    <div class="row">
        <h4><?= __('Question Options') ?></h4>
        <?= $this->Text->autoParagraph(h($feedbackQuestion->question_options)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Feedback Answers') ?></h4>
        <?php if (!empty($feedbackQuestion->feedback_answers)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Contractor Id') ?></th>
                <th scope="col"><?= __('Feedback Question Id') ?></th>
                <th scope="col"><?= __('Answer') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($feedbackQuestion->feedback_answers as $feedbackAnswers): ?>
            <tr>
                <td><?= h($feedbackAnswers->id) ?></td>
                <td><?= h($feedbackAnswers->contractor_id) ?></td>
                <td><?= h($feedbackAnswers->feedback_question_id) ?></td>
                <td><?= h($feedbackAnswers->answer) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'FeedbackAnswers', 'action' => 'view', $feedbackAnswers->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'FeedbackAnswers', 'action' => 'edit', $feedbackAnswers->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'FeedbackAnswers', 'action' => 'delete', $feedbackAnswers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $feedbackAnswers->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
