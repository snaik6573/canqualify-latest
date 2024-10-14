<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmailCampaign $emailCampaign
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Email Campaign'), ['action' => 'edit', $emailCampaign->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Email Campaign'), ['action' => 'delete', $emailCampaign->id], ['confirm' => __('Are you sure you want to delete # {0}?', $emailCampaign->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Email Campaigns'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Email Campaign'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="emailCampaigns view large-9 medium-8 columns content">
    <h3><?= h($emailCampaign->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Campaign Name') ?></th>
            <td><?= h($emailCampaign->campaign_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Subject') ?></th>
            <td><?= h($emailCampaign->subject) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($emailCampaign->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('To Mail') ?></th>
            <td><?= $this->Number->format($emailCampaign->to_mail) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('From Mail') ?></th>
            <td><?= $this->Number->format($emailCampaign->from_mail) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($emailCampaign->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified By') ?></th>
            <td><?= $this->Number->format($emailCampaign->modified_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($emailCampaign->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($emailCampaign->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Template Content') ?></h4>
        <?= $this->Text->autoParagraph(h($emailCampaign->template_content)); ?>
    </div>
    <div class="row">
        <h4><?= __('Email Signature Content') ?></h4>
        <?= $this->Text->autoParagraph(h($emailCampaign->email_signature_content)); ?>
    </div>
</div>
