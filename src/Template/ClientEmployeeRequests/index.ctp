<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClientEmployeeRequest[]|\Cake\Collection\CollectionInterface $clientEmployeeRequests
 */
$users = array(SUPER_ADMIN,EMPLOYEE);
?>
<div class="row clientEmployeeRequests">
<div class="col-lg-12">
<div class="card">
    <div class="card-header clearfix">
        <strong class="card-title"><?= __('Client Requests') ?></strong>      
    </div>
    <div class="card-body table-responsive">
    <table id="bootstrap-data-table" class="table table-striped table-bordered">
    <thead>
    <tr>
        <th scope="col"><?= h('Subject') ?></th>
        <th scope="col"><?= h('Client Name') ?></th>
        <th scope="col"><?= h('Status') ?></th>
        <th scope="col"><?= h('Created') ?></th>
        <th scope="col" class="actions"><?= h('View') ?></th>
        <?php if($activeUser['role_id'] != SUPER_ADMIN) { ?>
        <th scope="col" class="actions"><?= h('Actions') ?></th>
        <?php } ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($clientEmployeeRequests as $clientEmployeeRequest): ?>
    <tr>
        <td><?= h($clientEmployeeRequest->subject) ?></td>
        <td><?= $clientEmployeeRequest->has('client') ? $clientEmployeeRequest->client->company_name : '' ?></td>
        <td><?= $clientEmployeeRequest->status==1 ? h('Pending') : h('Accepted') ?></td>
        <td><?= h($clientEmployeeRequest->created) ?></td>
        <td class="actions">
        <?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $clientEmployeeRequest->id],['escape'=>false, 'title' => 'View']) ?>
        </td>
        <?php if($activeUser['role_id'] != SUPER_ADMIN) { ?>
        <td class="actions">
        <?php if($clientEmployeeRequest->status==2)
        {
            echo 'Accepted';
        }
        else { 
            /*echo $this->Html->link(__('Accept'), ['action'=>'accept', $clientRequest->id], ['escape'=>false, 'title' => 'Accept', 'class'=>'btn btn-sm btn-success']);*/

            echo $this->Html->link(__('Accept'), ['#'], ['escape'=>false, 'title' => 'Accept', 'class'=>'btn btn-sm btn-success']);

            if(in_array($activeUser['role_id'], $users)) {
                echo $this->Form->postLink('Reject', ['action' => 'delete', $clientEmployeeRequest->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to reject request from # {0}?', $clientEmployeeRequest->id), 'class'=>'btn btn-sm btn-danger']);
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

