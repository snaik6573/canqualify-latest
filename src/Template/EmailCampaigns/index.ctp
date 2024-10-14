<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmailCampaign[]|\Cake\Collection\CollectionInterface $emailCampaigns
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Email Campaign'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="emailCampaigns index large-9 medium-8 columns content">
    <h3><?= __('Email Campaigns') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('campaign_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('to_mail') ?></th>
                <th scope="col"><?= $this->Paginator->sort('from_mail') ?></th>
                <th scope="col"><?= $this->Paginator->sort('subject') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_by') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified_by') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($emailCampaigns as $emailCampaign): ?>
            <tr>
                <td><?= $this->Number->format($emailCampaign->id) ?></td>
                <td><?= h($emailCampaign->campaign_name) ?></td>
                <td><?= $this->Number->format($emailCampaign->to_mail) ?></td>
                <td><?= $this->Number->format($emailCampaign->from_mail) ?></td>
                <td><?= h($emailCampaign->subject) ?></td>
                <td><?= h($emailCampaign->created) ?></td>
                <td><?= h($emailCampaign->modified) ?></td>
                <td><?= $this->Number->format($emailCampaign->created_by) ?></td>
                <td><?= $this->Number->format($emailCampaign->modified_by) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $emailCampaign->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $emailCampaign->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $emailCampaign->id], ['confirm' => __('Are you sure you want to delete # {0}?', $emailCampaign->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
