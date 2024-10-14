<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClientEmployeeQuestion $clientEmployeeQuestion
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $clientEmployeeQuestion->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $clientEmployeeQuestion->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Client Employee Questions'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Clients'), ['controller' => 'Clients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client'), ['controller' => 'Clients', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Employee Questions'), ['controller' => 'EmployeeQuestions', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Employee Question'), ['controller' => 'EmployeeQuestions', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="clientEmployeeQuestions form large-9 medium-8 columns content">
    <?= $this->Form->create($clientEmployeeQuestion) ?>
    <fieldset>
        <legend><?= __('Edit Client Employee Question') ?></legend>
        <?php
            echo $this->Form->control('client_id', ['options' => $clients]);
            echo $this->Form->control('employee_question_id', ['options' => $employeeQuestions]);
            echo $this->Form->control('is_compulsory');
            echo $this->Form->control('correct_answer');
            echo $this->Form->control('created_by');
            echo $this->Form->control('modified_by');
            echo $this->Form->control('employee_category_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
