<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FeedbackAnswer $feedbackAnswer
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Feedback Answers'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Contractors'), ['controller' => 'Contractors', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Contractor'), ['controller' => 'Contractors', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Feedback Questions'), ['controller' => 'FeedbackQuestions', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Feedback Question'), ['controller' => 'FeedbackQuestions', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="feedbackAnswers form large-9 medium-8 columns content">
    <?= $this->Form->create($feedbackAnswer) ?>
    <fieldset>
        <legend><?= __('Add Feedback Answer') ?></legend>
        <?php
            echo $this->Form->control('contractor_id', ['options' => $contractors, 'empty' => true]);
            echo $this->Form->control('feedback_question_id', ['options' => $feedbackQuestions, 'empty' => true]);
            echo $this->Form->control('answer');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
