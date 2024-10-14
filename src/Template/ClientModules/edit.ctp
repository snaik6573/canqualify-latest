<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClientModule $clientModule
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
		<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $clientModule->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $clientModule->id)]
            )
        ?></li>
		<?php } ?>
        <li><?= $this->Html->link(__('List Client Modules'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Clients'), ['controller' => 'Clients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client'), ['controller' => 'Clients', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Modules'), ['controller' => 'Modules', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Module'), ['controller' => 'Modules', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="clientModules form large-9 medium-8 columns content">
    <?= $this->Form->create($clientModule) ?>
    <fieldset>
        <legend><?= __('Edit Client Module') ?></legend>
        <?php
            echo $this->Form->control('client_id', ['options' => $clients, 'empty' => true]);
            echo $this->Form->control('module_id', ['options' => $modules, 'empty' => true]);
            echo $this->Form->control('created_by');
            echo $this->Form->control('modified_by');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
