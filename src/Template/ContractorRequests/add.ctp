<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContractorRequest $contractorRequest
 */
$subject = 'CanQualify - Request to connect with '.$contractor->company_name;
$message = '<p>Hello '.$employee->pri_contact_fn.' '.$employee->pri_contact_ln.'</p>';
$message .= '<p> '.$contractor->company_name. ' wants to work with you.</p>';

?>
<div class="row contractorRequests">
<div class="col-lg-12">
<div class="card">
    <div class="card-header">
        <strong>Employee : <?= $employee->pri_contact_fn; ?></strong> 
    </div>
    <div class="card-body card-block">
    <?= $this->Form->create($contractorRequest, ['class'=>'saveAjax', 'data-responce'=>'.modal-body', 'data-sendrequest'=>'true']) ?>
        <div class="form-group">
            <?php echo $this->Form->control('subject', ['type'=>'text', 'class'=>'form-control', 'value'=>$subject, 'required'=>true]); ?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->textarea('message', ['class'=>'form-control note', 'value'=>strip_tags($message), 'required'=>true]); ?>
        </div>
            <div class="form-actions form-group">
            <?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
            <?= $this->Form->button('<em><i class="fa fa-ban"></i></em> Reset', ['type' => 'reset', 'class'=>'btn btn-danger btn-sm']); ?>
        </div>
    <?= $this->Form->end(); ?>
    </div>
</div>
</div>
</div>

<!--
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Contractor Requests'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Contractors'), ['controller' => 'Contractors', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Contractor'), ['controller' => 'Contractors', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Employees'), ['controller' => 'Employees', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Employee'), ['controller' => 'Employees', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="contractorRequests form large-9 medium-8 columns content">
    <?= $this->Form->create($contractorRequest) ?>
    <fieldset>
        <legend><?= __('Add Contractor Request') ?></legend>
        <?php
            echo $this->Form->control('contractor_id', ['options' => $contractors]);
            echo $this->Form->control('employee_id', ['options' => $employees]);
            echo $this->Form->control('status');
            echo $this->Form->control('created_by');
            echo $this->Form->control('modified_by');
            echo $this->Form->control('subject');
            echo $this->Form->control('message');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>-->
