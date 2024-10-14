<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmployeeAnswer $employeeAnswer
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Employee Answers'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Employees'), ['controller' => 'Employees', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Employee'), ['controller' => 'Employees', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Employee Questions'), ['controller' => 'EmployeeQuestions', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Employee Question'), ['controller' => 'EmployeeQuestions', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Clients'), ['controller' => 'Clients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client'), ['controller' => 'Clients', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="employeeAnswers form large-9 medium-8 columns content">
    <?= $this->Form->create($employeeAnswer) ?>
    <fieldset>
        <legend><?= __('Add Employee Answer') ?></legend>
        <?php
            echo $this->Form->control('employee_id', ['options' => $employees]);
            echo $this->Form->control('employee_question_id', ['options' => $employeeQuestions]);
            echo $this->Form->control('answer');
            echo $this->Form->control('client_id', ['options' => $clients, 'empty' => true]);
            echo $this->Form->control('created_by');
            echo $this->Form->control('modified_by');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
