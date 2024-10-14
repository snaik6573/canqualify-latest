<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmailSignature[]|\Cake\Collection\CollectionInterface $emailSignatures
 */
?>
<div class="row emailSignatures">
    <div class="col-lg-12">
        <div class="card shadow  bg-white rounded">
            <div class="card-header clearfix">
                <strong class="card-title pull-left">
                    <?= __('Email Signatures') ?></strong>
                <span class="pull-right">
                    <?= $this->Html->link(__('Create Signature Template'), ['controller'=>'EmailSignatures', 'action'=>'add'],['class'=>'btn btn-success']) ?>
                </span>
            </div>
            <div class="card-body table-responsive">
                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                  
                    <thead>
                        <tr>
                            <th scope="col">
                                <?= h('Email Signature Name') ?>
                            </th>
                            <th scope="col">
                                <?= h('Name') ?>
                            </th>
                             <th scope="col">
                                <?= h('Title') ?>
                            </th>
                             <th scope="col">
                                <?= h('Company Name') ?>
                            </th>
                             <th scope="col">
                                <?= h('Phone') ?>
                            </th>
                             <th scope="col">
                                <?= h('Mobile') ?>
                            </th>
                             <th scope="col">
                                <?= h('Website') ?>
                            </th>
                            <th scope="col">
                                <?= h('Email') ?>
                            </th>
                             <th scope="col">
                                <?= h('Address') ?>
                            </th>
                             <th scope="col">
                                <?= h('Template Type') ?>
                            </th>
                            <th scope="col">
                                <?= h('Actions') ?>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($emailSignatures as $key => $email) { ?>
                        <tr>
                            <td><?= h($email->signature_name);  ?> </td>
                            <td><?= h($email->name);  ?> </td>
                            <td><?= h($email->title);  ?> </td>
                            <td><?= h($email->company_name);  ?> </td>
                            <td><?= h($email->phone);  ?> </td>
                            <td><?= h($email->mobile);  ?> </td>
                            <td><?= h($email->website);  ?> </td>
                            <td><?= h($email->signature_email);  ?> </td>
                            <td><?= h($email->address);  ?> </td>
                            <?php  foreach ($templates as $key => $value) {
                                if($email->template_id  == $key){ ?>
                                   <td><?= h($value);  ?> </td>
                                
                            <?php } } ?>
                            
                            <td class="actions">
                            <?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $email->id],['escape'=>false, 'title' => 'View']) ?>
                            <?php if($activeUser['role_id'] == SUPER_ADMIN || $activeUser['role_id'] == ADMIN || $activeUser['role_id'] == CLIENT) { ?>
                            <?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $email->id],['escape'=>false, 'title' => 'Edit']) ?>
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
