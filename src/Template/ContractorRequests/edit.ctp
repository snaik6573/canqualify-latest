<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContractorRequest $contractorRequest
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $contractorRequest->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $contractorRequest->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Contractor Requests'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Contractors'), ['controller' => 'Contractors', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Contractor'), ['controller' => 'Contractors', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Employees'), ['controller' => 'Employees', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Employee'), ['controller' => 'Employees', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="contractorRequests form large-9 medium-8 columns content">
    <?= $this->Form->create($contractorRequest) ?>
    <fieldset>
        <legend><?= __('Edit Contractor Request') ?></legend>
        <?php
            echo $this->Form->control('contractor_id', ['options' => $contractors]);
            echo $this->Form->control('employee_id', ['options' => $employees]);
            echo $this->Form->control('status');
            echo $this->Form->control('created_by');
            echo $this->Form->control('modified_by');
            echo $this->Form->control('subject');
            echo $this->Form->control('message');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
