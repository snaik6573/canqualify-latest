<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TrainingAnswer $trainingAnswer
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Training Answer'), ['action' => 'edit', $trainingAnswer->id]) ?> </li>
		<?php if($activeUser['role_id'] != ADMIN) { ?>
        <li><?= $this->Form->postLink(__('Delete Training Answer'), ['action' => 'delete', $trainingAnswer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $trainingAnswer->id)]) ?> </li>
        <?php } ?>
		<li><?= $this->Html->link(__('List Training Answers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Training Answer'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Employees'), ['controller' => 'Employees', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Employee'), ['controller' => 'Employees', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Training Questions'), ['controller' => 'TrainingQuestions', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Training Question'), ['controller' => 'TrainingQuestions', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="trainingAnswers view large-9 medium-8 columns content">
    <h3><?= h($trainingAnswer->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Employee') ?></th>
            <td><?= $trainingAnswer->has('employee') ? $this->Html->link($trainingAnswer->employee->id, ['controller' => 'Employees', 'action' => 'view', $trainingAnswer->employee->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Training Question') ?></th>
            <td><?= $trainingAnswer->has('training_question') ? $this->Html->link($trainingAnswer->training_question->id, ['controller' => 'TrainingQuestions', 'action' => 'view', $trainingAnswer->training_question->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($trainingAnswer->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($trainingAnswer->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified By') ?></th>
            <td><?= $this->Number->format($trainingAnswer->modified_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($trainingAnswer->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($trainingAnswer->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Answer') ?></h4>
        <?= $this->Text->autoParagraph(h($trainingAnswer->answer)); ?>
    </div>
</div>
