<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\IndustryAverage $industryAverage
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Industry Average'), ['action' => 'edit', $industryAverage->id]) ?> </li>
        <?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
		<li><?= $this->Form->postLink(__('Delete Industry Average'), ['action' => 'delete', $industryAverage->id], ['confirm' => __('Are you sure you want to delete # {0}?', $industryAverage->id)]) ?> </li>
        <?php } ?>
		<li><?= $this->Html->link(__('List Industry Averages'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Industry Average'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Naisc Codes'), ['controller' => 'NaiscCodes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Naisc Code'), ['controller' => 'NaiscCodes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="industryAverages view large-9 medium-8 columns content">
    <h3><?= h($industryAverage->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Naisc Code') ?></th>
            <td><?= $industryAverage->has('naisc_code') ? $this->Html->link($industryAverage->naisc_code->title, ['controller' => 'NaiscCodes', 'action' => 'view', $industryAverage->naisc_code->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($industryAverage->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Total Recordable Cases') ?></th>
            <td><?= $this->Number->format($industryAverage->total_recordable_cases) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Total') ?></th>
            <td><?= $this->Number->format($industryAverage->total) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cases With Days Away From Work') ?></th>
            <td><?= $this->Number->format($industryAverage->cases_with_days_away_from_work) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cases With Days Of Job Transfer Or Restriction') ?></th>
            <td><?= $this->Number->format($industryAverage->cases_with_days_of_job_transfer_or_restriction) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Other Recordable Cases') ?></th>
            <td><?= $this->Number->format($industryAverage->other_recordable_cases) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Industry Average') ?></th>
            <td><?= $this->Number->format($industryAverage->industry_average) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Year') ?></th>
            <td><?= $this->Number->format($industryAverage->year) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($industryAverage->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified By') ?></th>
            <td><?= $this->Number->format($industryAverage->modified_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($industryAverage->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($industryAverage->modified) ?></td>
        </tr>
    </table>
</div>
