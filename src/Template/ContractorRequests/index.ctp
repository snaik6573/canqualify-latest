<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContractorRequest[]|\Cake\Collection\CollectionInterface $contractorRequests
 */
$users = array(SUPER_ADMIN,EMPLOYEE);
?>
<div class="row contractorRequests">
<div class="col-lg-12">
<div class="card">
    <div class="card-header clearfix">
        <strong class="card-title"><?= __('Contractor Requests') ?></strong>      
    </div>
    <div class="card-body table-responsive">
    <table id="bootstrap-data-table" class="table table-striped table-bordered">
    <thead>
    <tr>
        <th scope="col"><?= h('Subject') ?></th>
        <th scope="col"><?= h('Contractor Name') ?></th>
        <th scope="col"><?= h('Status') ?></th>
        <th scope="col"><?= h('Created') ?></th>
        <th scope="col" class="actions"><?= h('View') ?></th>
        <?php if($activeUser['role_id'] != SUPER_ADMIN) { ?>
        <th scope="col" class="actions"><?= h('Actions') ?></th>
        <?php } ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($contractorRequests as $contractorRequest): ?>
    <tr>
        <td><?= h($contractorRequest->subject) ?></td>
        <td><?= $contractorRequest->has('contractor') ? $contractorRequest->contractor->company_name : '' ?></td>
        <td><?= $contractorRequest->status==1 ? h('Pending') : h('Accepted') ?></td>
        <td><?= h($contractorRequest->created) ?></td>
        <td class="actions">
        <?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $contractorRequest->id],['escape'=>false, 'title' => 'View']) ?>
        </td>
        <?php if($activeUser['role_id'] != SUPER_ADMIN) { ?>
        <td class="actions">
        <?php if($contractorRequest->status==2)
        {
            echo 'Accepted';
        }
        else { 
            /*echo $this->Html->link(__('Accept'), ['action'=>'accept', $clientRequest->id], ['escape'=>false, 'title' => 'Accept', 'class'=>'btn btn-sm btn-success']);*/

            echo $this->Html->link(__('Accept'), ['controller'=> 'EmployeeContractors', 'action'=>'acceptRequest', $contractorRequest->contractor_id], ['escape'=>false, 'title' => 'Accept', 'class'=>'btn btn-sm btn-success']);

            if(in_array($activeUser['role_id'], $users)) {
                echo $this->Form->postLink('Reject', ['action' => 'delete', $contractorRequest->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to reject request from # {0}?', $contractorRequest->id), 'class'=>'btn btn-sm btn-danger']);
            }
        }
        ?>
        </td>
    <?php } ?>
    </tr>
    <?php endforeach; ?>
    </tbody>
    </table>
    </div>
</div>
</div>
</div>


