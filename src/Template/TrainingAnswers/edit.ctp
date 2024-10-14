<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TrainingAnswer $trainingAnswer
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
		<?php if($activeUser['role_id'] != ADMIN) { ?>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $trainingAnswer->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $trainingAnswer->id)]
            )
        ?></li>
		<?php } ?>
        <li><?= $this->Html->link(__('List Training Answers'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Employees'), ['controller' => 'Employees', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Employee'), ['controller' => 'Employees', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Training Questions'), ['controller' => 'TrainingQuestions', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Training Question'), ['controller' => 'TrainingQuestions', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="trainingAnswers form large-9 medium-8 columns content">
    <?= $this->Form->create($trainingAnswer) ?>
    <fieldset>
        <legend><?= __('Edit Training Answer') ?></legend>
        <?php
            echo $this->Form->control('employee_id', ['options' => $employees]);
            echo $this->Form->control('training_questions_id', ['options' => $trainingQuestions]);
            echo $this->Form->control('answer');
            echo $this->Form->control('created_by');
            echo $this->Form->control('modified_by');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
