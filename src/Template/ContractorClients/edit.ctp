<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContractorClient $contractorClient
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $contractorClient->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $contractorClient->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Contractor Clients'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Contractors'), ['controller' => 'Contractors', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Contractor'), ['controller' => 'Contractors', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Clients'), ['controller' => 'Clients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client'), ['controller' => 'Clients', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="contractorClients form large-9 medium-8 columns content">
    <?= $this->Form->create($contractorClient) ?>
    <fieldset>
        <legend><?= __('Edit Contractor Client') ?></legend>
        <?php
            echo $this->Form->control('contractor_id', ['options' => $contractors]);
            echo $this->Form->control('client_id', ['options' => $clients]);
            echo $this->Form->control('created_by');
            echo $this->Form->control('modified_by');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
