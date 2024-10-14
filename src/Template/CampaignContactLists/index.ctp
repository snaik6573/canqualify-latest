<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CampaignContactList[]|\Cake\Collection\CollectionInterface $campaignContactLists
 */
?>
<div class="row campaignContactLists">
    <div class="col-lg-12">
        <div class="card shadow  bg-white rounded">
            <div class="card-header clearfix">
                <strong class="card-title pull-left">
                    <?= __('Campaign Contact List') ?></strong>
                    <span class="pull-right">
                        <?= $this->Html->link(__('Create Contact List'), ['controller'=>'EmailWizards', 'action'=>'searchSuppliers'],['class'=>'btn btn-success']) ?>  
                    </span>
            </div>
            <div class="card-body table-responsive">
                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                  
                    <thead>
                        <tr>
                            <th scope="col">
                                <?= h('Name') ?>
                            </th>
                            <th scope="col">
                                <?= h('Suppliers Ids') ?>
                            </th>
                            <th scope="col">
                                <?= h('Actions') ?>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($campaignContactLists as $key => $list) { ?>
                        <tr>
                            <td><?= h($list->name);  ?> </td>
                            <td style="word-wrap: break-word;min-width: 160px;max-width: 160px;">
                                <?= h(implode(",",$list['suppliers_ids']['supplier_ids'] ))  ?> </td>
                            <td class="actions">
                            <?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $list->id],['escape'=>false, 'title' => 'View']) ?>
                            <?php if($activeUser['role_id'] == SUPER_ADMIN || $activeUser['role_id'] == ADMIN || $activeUser['role_id'] == CLIENT) { ?>
                            <?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $list->id],['escape'=>false, 'title' => 'Edit']) ?>
                            <?php } ?>
                           
                        </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
