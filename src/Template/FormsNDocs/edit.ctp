<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FormsNDoc $formsNDoc
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $formsNDoc->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $formsNDoc->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Forms N Docs'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Clients'), ['controller' => 'Clients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client'), ['controller' => 'Clients', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="formsNDocs form large-9 medium-8 columns content">
    <?= $this->Form->create($formsNDoc) ?>
    <fieldset>
        <legend><?= __('Edit Forms N Doc') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('document');
            echo $this->Form->control('created_by');
            echo $this->Form->control('modified_by');
            echo $this->Form->control('client_id', ['options' => $clients, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
