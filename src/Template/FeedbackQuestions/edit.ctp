<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FeedbackQuestion $feedbackQuestion
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $feedbackQuestion->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $feedbackQuestion->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Feedback Questions'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Feedback Answers'), ['controller' => 'FeedbackAnswers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Feedback Answer'), ['controller' => 'FeedbackAnswers', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="feedbackQuestions form large-9 medium-8 columns content">
    <?= $this->Form->create($feedbackQuestion) ?>
    <fieldset>
        <legend><?= __('Edit Feedback Question') ?></legend>
        <?php
            echo $this->Form->control('question');
            echo $this->Form->control('question_options');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
