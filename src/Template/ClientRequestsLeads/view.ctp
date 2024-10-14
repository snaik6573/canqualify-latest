<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClientRequestsLead $clientRequestsLead
 */
?>
<div class="row clientRequestsLeads">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= h('Client Request Lead') ?>
	</div>
	<div class="card-body card-block">
	<table class="table">
            <th scope="row"><?= __('Client') ?></th>
            <td><?= $clientRequestsLead->has('client') ? $this->Html->link($clientRequestsLead->client->id, ['controller' => 'Clients', 'action' => 'view', $clientRequestsLead->client->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Lead') ?></th>
            <td><?= $clientRequestsLead->has('lead') ? $this->Html->link($clientRequestsLead->lead->id, ['controller' => 'Leads', 'action' => 'view', $clientRequestsLead->lead->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Subject') ?></th>
            <td><?= h($clientRequestsLead->subject) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($clientRequestsLead->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $this->Number->format($clientRequestsLead->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($clientRequestsLead->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified By') ?></th>
            <td><?= $this->Number->format($clientRequestsLead->modified_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($clientRequestsLead->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($clientRequestsLead->modified) ?></td>
        </tr>
    </table>
	</div>
</div>
</div>
    <div class="col-lg-6">
    <div class="card">
	<div class="card-header">
		<?= __('Subject') ?>
	</div>
	<div class="card-body card-block">
		<?= h($clientRequestsLead->subject) ?>
	</div>

	<div class="card-header">
		<?= __('Message') ?>
	</div>
	<div class="card-body card-block">
		<?= h($clientRequestsLead->message) ?>
	</div>
</div>
</div>

</div>

