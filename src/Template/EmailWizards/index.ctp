<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $emailWizards
 */
?>
<!--    Table of Campaingns --->
<div class="row emailWizards">
    <div class="col-lg-12">
        <div class="card shadow  bg-white rounded">
            <div class="card-header clearfix">
                <strong class="card-title pull-left">
                    <?= __('Email Campaigns List') ?></strong>
                 <?= $this->Html->link(__('Create Campaign'), ['controller'=>'EmailWizards', 'action'=>'emailCampaign'],['class'=>'btn btn-success btn-flat btn-sm pull-right']) ?>
            </div>
            <div class="card-body table-responsive">
                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                  
                    <thead>
                        <tr>
                            <th scope="col">
                                <?= h('Campaign Name') ?>
                            </th>
                            <th scope="col">
                                <?= h('To (Contact List)') ?>
                            </th>
                            <th scope="col">
                                <?= h('From') ?>
                            </th>
                             <th scope="col">
                                <?= h('CC') ?>
                            </th>
                             <th scope="col">
                                <?= h('Subject') ?>
                            </th>
                             <th scope="col">
                                <?= h('Created By') ?>
                            </th>
                             <th scope="col">
                                <?= h('Actions') ?>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($emailCampaigns as $email) {  ?>
                        <tr>
                            <td><?= h($email->campaign_name);  ?> </td>
                            <td><?= h($campaignContactList[implode(",", $email->to_mail['to_mail_ids'])])  ?> </td>
                            <td style="word-wrap: break-word;min-width: 160px;max-width: 160px;"><?= h(implode(",", $email->from_mail['from_mails']))  ?> </td>
                            <td style="word-wrap: break-word;min-width: 160px;max-width: 160px;"><?= ($email->cc_mail['cc_mails'] != null) ?  h(implode(",",$email->cc_mail['cc_mails'])) :''  ?> </td>
                            <td><?= h($email->subject)  ?> </td>
                            <td><?= h($email->created_by)  ?> </td>
                            <td class="actions">
                            <?= $this->Html->link('<i class="fa fa-pencil" aria-hidden="true"></i>', ['controller'=>'EmailCampaigns','action' => 'edit', $email->id],['escape'=>false, 'title' => 'Edit Campaign']) ?>
                            <?= $this->Html->link('<i class="fa fa-rocket" aria-hidden="true"></i>', ['controller'=>'EmailCampaigns','action' => 'launchCampaign', $email->id],['escape'=>false, 'title' => 'Launch Campaign']) ?>
                            <?php if($activeUser['role_id'] == SUPER_ADMIN || $activeUser['role_id'] == ADMIN ) { ?>
                            <?= $this->Html->link('<i class="fa fa-sticky-note" aria-hidden="true"></i>', ['controller'=>'EmailCampaigns','action' => 'saveAsNote', $email->id],['escape'=>false, 'title' => 'Save As Notes']) ?>
                        <?php } ?>
                            <!-- <?= $this->Html->link('<i class="fa fa-calendar" aria-hidden="true"></i>', ['controller'=>'EmailCampaigns','action' => 'scheduledCampaign', $email->id],['escape'=>false, 'title' => 'Schedule Campaign']) ?> -->
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
