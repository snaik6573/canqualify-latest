<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CronQuestionUpdate $cronQuestionUpdate
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $cronQuestionUpdate->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $cronQuestionUpdate->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Cron Question Updates'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Clients'), ['controller' => 'Clients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client'), ['controller' => 'Clients', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="cronQuestionUpdates form large-9 medium-8 columns content">
    <?= $this->Form->create($cronQuestionUpdate) ?>
    <fieldset>
        <legend><?= __('Edit Cron Question Update') ?></legend>
        <?php
            echo $this->Form->control('client_id', ['options' => $clients, 'empty' => true]);
            echo $this->Form->control('category_id', ['options' => $categories, 'empty' => true]);
            echo $this->Form->control('created_by');
            echo $this->Form->control('modified_by');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
