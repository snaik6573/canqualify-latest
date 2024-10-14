<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SiteVisit $siteVisit
 */
?>

<div class="row sites">
<div class="col-lg-6">
<div class="card">

    <div class="card-header">
        <?= h($siteVisit['client']->company_name); ?>
    </div>
    <div class="card-body card-block">
    <table class="table">
        <tr>
            <th scope="row"><?= __('Site Id') ?></th>
            <td><?= h($siteVisit->id); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Site Name') ?></th>
            <td><?= h($siteVisit['site']->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Start Time') ?></th>
            <td><?= h($siteVisit->start_time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('End Time') ?></th>
            <td><?= h($siteVisit->end_time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Description') ?></th>
            <td><?= h($siteVisit->description) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($siteVisit->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Html->link($siteVisit->created_by, ['controller' => 'Users', 'action' => 'view', $siteVisit->created_by]) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified By') ?></th>
            <td><?= $this->Html->link($siteVisit->modified_by, ['controller' => 'Users', 'action' => 'view', $siteVisit->modified_by]) ?></td>
        </tr>
    </table>
    </div>

</div>
</div>
</div>
