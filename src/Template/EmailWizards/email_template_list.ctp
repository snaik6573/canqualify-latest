<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmailWizard[]|\Cake\Collection\CollectionInterface $emailWizards
 */
?>
<div class="row emailWizards">
    <div class="col-lg-12">
        <div class="card shadow  bg-white rounded">
            <div class="card-header clearfix">
                <strong class="card-title pull-left">
                    <?= __('Email Template List') ?></strong>
                <span class="pull-right">
                    <?= $this->Html->link(__('Add New'), ['controller'=>'EmailWizards', 'action'=>'createTemplate'],['class'=>'btn btn-success']) ?>
                </span>
            </div>
            <div class="card-body table-responsive">
                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                  
                    <thead>
                        <tr>
                            <th scope="col">
                                <?= h('Email Subject') ?>
                            </th>
                            <th scope="col">
                                <?= h('Content') ?>
                            </th>
                            <th scope="col">
                                <?= h('Actions') ?>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($emailTemplates as $key => $email) { ?>
                        <tr>
                            <td><?= h($email->name);  ?> </td>
                            <td><?= htmlspecialchars_decode(($email->template_content));  ?> </td>
                            <td class="actions">
                            <?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'viewTemplate', $email->id],['escape'=>false, 'title' => 'View']) ?>
                            <?php if($activeUser['role_id'] == SUPER_ADMIN || $activeUser['role_id'] == ADMIN || $activeUser['role_id'] == CLIENT) { ?>
                            <?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'editTemplate', $email->id],['escape'=>false, 'title' => 'Edit']) ?>
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
