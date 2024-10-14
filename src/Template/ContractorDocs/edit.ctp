<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContractorDoc $contractorDoc
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
		<li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $contractorDoc->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $contractorDoc->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Contractor Docs'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Forms N Docs'), ['controller' => 'FormsNDocs', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Forms N Doc'), ['controller' => 'FormsNDocs', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Clients'), ['controller' => 'Clients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client'), ['controller' => 'Clients', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Contractors'), ['controller' => 'Contractors', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Contractor'), ['controller' => 'Contractors', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="contractorDocs form large-9 medium-8 columns content">
    <?= $this->Form->create($contractorDoc) ?>
    <fieldset>
        <legend><?= __('Edit Contractor Doc') ?></legend>
        <?php
            echo $this->Form->control('document');
            echo $this->Form->control('fndocs_id', ['options' => $formsNDocs, 'empty' => true]);
            echo $this->Form->control('client_id', ['options' => $clients, 'empty' => true]);
            echo $this->Form->control('contractor_id', ['options' => $contractors, 'empty' => true]);
            echo $this->Form->control('created_by');
            echo $this->Form->control('modified_by');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
