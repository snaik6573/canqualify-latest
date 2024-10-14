<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Lead $lead
 */
?>
<div class="row leads-Manually">
<div class="col-lg-8">
<div class="card">
    <div class="card-header">
    <strong>Add Supplier </strong>
    </div>
    <div class="card-body card-block">  
         <?= $this->Form->create($lead) ?>
        <div class="form-group">
        <?=  $this->Form->control('company_name', ['class'=>'form-control'],['label' => 'Company Name','required' => true]); ?>
        </div>
         <div class="form-group">
        <?=  $this->Form->control('contact_name_first', ['class'=>'form-control','label' => ' First Name ','required' => false]); ?>
        <div class="form-group">
        <?=  $this->Form->control('contact_name_last', ['class'=>'form-control','label' => ' Last Name ','required' => false]); ?>
        </div>
         <div class="form-group">
        <?= $this->Form->control('phone_no', ['class'=>'form-control','label' => 'Phone','required' =>false,'id'=>'txtPhone']); ?>
        </div>
         <div class="form-group">
        <?=  $this->Form->control('email', ['class'=>'form-control','label' => 'Email','required' =>false]); ?>
        </div>
         <div class="form-group">
        <?=  $this->Form->control('city', ['class'=>'form-control','label' => 'City','required' => false]); ?>
        </div>
         <div class="form-group">
        <?=  $this->Form->control('state', ['class'=>'form-control','label' => 'State','required' => false]); ?>
        </div>
         <div class="form-group"> 
        <?=  $this->Form->control('zip_code', ['class'=>'form-control','label' => 'Zip Code','required' => false]); ?>
        </div>
        <div class="form-group">
        <?= $this->Form->control('description_of_work', ['class'=>'form-control','label' => 'Description Of Work','required' => false]); ?>
        </div>
        <?php if(isset($clients)) { ?>
        <div class="form-group">
        <?= $this->Form->control('client_id', ['options' => $clients, 'empty' => true, 'class'=>' form-control']) ?> 
        </div>
        <?php } ?>
    <?= $this->Form->button(__('Submit'),['class'=>'btn btn-success']) ?>
    <?= $this->Form->end() ?>
    </div>
</div>
</div>
</div>

