<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SiteVisit $siteVisit
 */
?>

<div class="row siteVisits">
<div class="col-lg-8">
<div class="card">
    <div class="card-header">
        <strong>Edit Site</strong> Visits
    </div>
   
    <div class="card-body card-block">  
        <?= $this->Form->create(null) ?>    
        <div class="row form-group">
        <?php $selectedClient = !empty($client) ? $client->id : reset($clients); ?>
            <label class="col-sm-3">Select Client</label>
            <div class="col-sm-6"><?= $this->Form->control('current_client_id', ['options'=>$clients, 'required'=>true, 'label'=>false, 'class'=>'form-control','disabled']); ?></div>
        </div>
        <?= $this->Form->end() ?>
    </div>
    <div class="card-body card-block"> 
      <?php if($siteVisit){ ?>
        <?= $this->Form->create($siteVisit) ?>
        <div class="form-group">
            <?php echo $this->Form->control('site_id', ['options' => $sites, 'empty' => true,'class'=>'form-control']); ?>
         </div>
         <div class="form-group"><?= $this->Form->control('start_time', ['type'=>'text', 'class'=>'form-control datetimepicker','label'=>false, 'placeholder'=>'Start Time']) ?> </div>
        <div class="form-group"><?= $this->Form->control('end_time', ['type'=>'text', 'class'=>'form-control datetimepicker','label'=>false, 'placeholder'=>'End Time']) ?> </div>
         
         <div class="form-group">
            <?php echo $this->Form->control('description',['class'=>'form-control','required'=>true,]); ?>
         </div>
       <div class="form-actions form-group">
            <?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
            <?= $this->Form->button('<em><i class="fa fa-ban"></i></em> Reset', ['type' => 'reset', 'class'=>'btn btn-danger btn-sm']); ?>
        </div>
    <?= $this->Form->end() ?>
   <?php } ?> 
    </div>
</div>
</div>
</div>
