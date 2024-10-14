<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClientModule $clientModule
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Client Module'), ['action' => 'edit', $clientModule->id]) ?> </li>
		<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
        <li><?= $this->Form->postLink(__('Delete Client Module'), ['action' => 'delete', $clientModule->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientModule->id)]) ?> </li>
        <?php } ?>
		<li><?= $this->Html->link(__('List Client Modules'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Client Module'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Clients'), ['controller' => 'Clients', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Client'), ['controller' => 'Clients', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Modules'), ['controller' => 'Modules', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Module'), ['controller' => 'Modules', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="clientModules view large-9 medium-8 columns content">
    <h3><?= h($clientModule->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Client') ?></th>
            <td><?= $clientModule->has('client') ? $this->Html->link($clientModule->client->id, ['controller' => 'Clients', 'action' => 'view', $clientModule->client->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Module') ?></th>
            <td><?= $clientModule->has('module') ? $this->Html->link($clientModule->module->name, ['controller' => 'Modules', 'action' => 'view', $clientModule->module->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($clientModule->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($clientModule->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified By') ?></th>
            <td><?= $this->Number->format($clientModule->modified_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($clientModule->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($clientModule->modified) ?></td>
        </tr>
    </table>
</div>
