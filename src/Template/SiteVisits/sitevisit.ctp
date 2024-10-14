<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SiteVisit[]|\Cake\Collection\CollectionInterface $siteVisits
 */
$users = array(SUPER_ADMIN,ADMIN,CONTRACTOR,CONTRACTOR_ADMIN);
?>
<div class="row site-visits">
<div class="col-lg-12">
<div class="card">
    <div class="card-header">
        <strong class="card-title"><?= __('Site Visits') ?></strong>
        <!--<?php if(in_array($activeUser['role_id'], $users)) { ?>
        <span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller' => 'SiteVisits', 'action' => 'add'],['class'=>'btn btn-success btn-sm']) ?> </span>
        <?php } ?>  -->   
    </div>
    <div class="card-body table-responsive">
    <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
    <thead>
    <tr>
        <th scope="col"><?= h('id') ?></th>
        <th scope="col"><?= h('Contractor Name') ?></th>
        <th scope="col"><?= h('Site Name') ?></th>
        <th scope="col"><?= h('Start Time') ?></th>
        <th scope="col"><?= h('End Time') ?></th>
        <th scope="col"><?= h('Description') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
    </tr>
    </thead>
    <tbody>
    <?php  

    foreach ($siteVisits as $siteVisit) { 

        ?>
    <tr>
        <td><?= $this->Number->format($siteVisit->id); ?></td>
        <td><?= h($siteVisit['contractor']->company_name); ?> </td>
        <td><?= h($siteVisit['site']->name); ?></td>
        <td><?= h($siteVisit->start_time); ?></td>
        <td><?= h($siteVisit->end_time); ?></td>
        <td><?= h($siteVisit->description); ?></td>
        <td class="actions">
        <?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $siteVisit->id],['escape'=>false, 'title' => 'View']) ?>
       <!-- <?php if(in_array($activeUser['role_id'], $users)) { ?>
        <?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $siteVisit->id],['escape'=>false, 'title' => 'Edit']) ?>
        <?php $yesterdate = date('d.m.Y',strtotime("-1 days"));
             if($yesterdate < $siteVisit->start_time) {   ?>
        <?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $siteVisit->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $siteVisit->id)]) ?>
         <?php } } ?>   -->   
        </td>     
    <?php } ?>
    </tbody>
    </table>
    </div>
</div>
</div>
</div>
