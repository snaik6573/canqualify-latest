<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmailCampaign $emailCampaign
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Email Campaigns'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="emailCampaigns form large-9 medium-8 columns content">
    <?= $this->Form->create($emailCampaign) ?>
    <fieldset>
        <legend><?= __('Add Email Campaign') ?></legend>
        <?php
            echo $this->Form->control('campaign_name');
            echo $this->Form->control('to_mail');
            echo $this->Form->control('from_mail');
            echo $this->Form->control('subject');
            echo $this->Form->control('template_content');
            echo $this->Form->control('email_signature_content');
            echo $this->Form->control('created_by');
            echo $this->Form->control('modified_by');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
