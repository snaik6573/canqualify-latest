<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmployeeSite $employeeSite
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
		<?php if($activeUser['role_id'] != ADMIN) { ?>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $employeeSite->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $employeeSite->id)]
            )
        ?></li>
		<?php } ?>
        <li><?= $this->Html->link(__('List Employee Sites'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Employees'), ['controller' => 'Employees', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Employee'), ['controller' => 'Employees', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Sites'), ['controller' => 'Sites', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Site'), ['controller' => 'Sites', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="employeeSites form large-9 medium-8 columns content">
    <?= $this->Form->create($employeeSite) ?>
    <fieldset>
        <legend><?= __('Edit Employee Site') ?></legend>
        <?php
            echo $this->Form->control('employee_id', ['options' => $employees]);
            echo $this->Form->control('site_id', ['options' => $sites]);
            echo $this->Form->control('created_by');
            echo $this->Form->control('modified_by');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
