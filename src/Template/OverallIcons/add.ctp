<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OverallIcon $overallIcon
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Overall Icons'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Clients'), ['controller' => 'Clients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client'), ['controller' => 'Clients', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Contractors'), ['controller' => 'Contractors', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Contractor'), ['controller' => 'Contractors', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="overallIcons form large-9 medium-8 columns content">
    <?= $this->Form->create($overallIcon) ?>
    <fieldset>
        <legend><?= __('Add Overall Icon') ?></legend>
        <?php
            echo $this->Form->control('client_id', ['options' => $clients, 'empty' => true]);
            echo $this->Form->control('contractor_id', ['options' => $contractors, 'empty' => true]);
            echo $this->Form->control('bench_type');
            echo $this->Form->control('icon');
            echo $this->Form->control('category');
            echo $this->Form->control('created_by');
            echo $this->Form->control('modified_by');
            echo $this->Form->control('is_forced');
            echo $this->Form->control('documents', ['required' => false]);
            echo $this->Form->control('notes', ['required' => false]);
            echo $this->Form->control('show_to_contractor');
            echo $this->Form->control('show_to_clients');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
