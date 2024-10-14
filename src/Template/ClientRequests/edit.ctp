<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClientRequest $clientRequest
 */
$users = array(SUPER_ADMIN,CONTRACTOR,CONTRACTOR_ADMIN);
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
		<?php if(in_array($activeUser['role_id'], $users)) { ?>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $clientRequest->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $clientRequest->id)]
            )
        ?></li>
		<?php } ?>
        <li><?= $this->Html->link(__('List Client Requests'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Clients'), ['controller' => 'Clients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client'), ['controller' => 'Clients', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Contractors'), ['controller' => 'Contractors', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Contractor'), ['controller' => 'Contractors', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="clientRequests form large-9 medium-8 columns content">
    <?= $this->Form->create($clientRequest) ?>
    <fieldset>
        <legend><?= __('Edit Client Request') ?></legend>
        <?php
            echo $this->Form->control('client_id', ['options' => $clients]);
            echo $this->Form->control('contractor_id', ['options' => $contractors]);
            echo $this->Form->control('status');
            echo $this->Form->control('created_by');
            echo $this->Form->control('modified_by');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
