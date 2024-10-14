<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\WaitingOnLog $waitingOnLog
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $waitingOnLog->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $waitingOnLog->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Waiting On Logs'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Contractors'), ['controller' => 'Contractors', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Contractor'), ['controller' => 'Contractors', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="waitingOnLogs form large-9 medium-8 columns content">
    <?= $this->Form->create($waitingOnLog) ?>
    <fieldset>
        <legend><?= __('Edit Waiting On Log') ?></legend>
        <?php
            echo $this->Form->control('contractor_id', ['options' => $contractors]);
            echo $this->Form->control('from_status');
            echo $this->Form->control('to_status');
            echo $this->Form->control('created_by');
            echo $this->Form->control('modified_by');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
