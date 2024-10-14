<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContractorFeedback $contractorFeedback
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Contractor Feedbacks'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Contractors'), ['controller' => 'Contractors', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Contractor'), ['controller' => 'Contractors', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="contractorFeedbacks form large-9 medium-8 columns content">
    <?= $this->Form->create($contractorFeedback) ?>
    <fieldset>
        <legend><?= __('Add Contractor Feedback') ?></legend>
        <?php
            echo $this->Form->control('contractor_id', ['options' => $contractors, 'empty' => true]);
            echo $this->Form->control('rating');
            echo $this->Form->control('comment');
            echo $this->Form->control('year');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
