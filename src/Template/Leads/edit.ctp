<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */
$users = array(SUPER_ADMIN,ADMIN,CR,CLIENT,CLIENT_ADMIN);
?>
<div class="row categories">
<div class="col-lg-6">
<div class="card">
	<div class="card-header clearfix">
		<strong>Edit</strong> Supplier
		<?php if($activeUser['role_id'] == SUPER_ADMIN ) { ?>
		<span class="pull-right"><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $lead->id], ['class'=>'btn btn-danger btn-sm', 'confirm' => __('Are you sure you want to delete # {0}?', $lead->id)]) ?></span>
		<?php } ?>
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create($lead) ?>      
		<div class="form-group">            
			<?php echo $this->Form->control('company_name', ['class'=>'form-control', 'required'=>false]); ?>
		</div>	
        <?php if(in_array($activeUser['role_id'], $users)) { ?>	
        <div class="form-group">
			<?php echo $this->Form->control('lead_status_id', ['options'=>$status, 'empty'=>false, 'class'=>'form-control','value'=> $lead->lead_status_id]); ?>
		</div>
        <?php } ?>
		<div class="form-group">
			<?php echo $this->Form->control('contact_name_first', ['class'=>'form-control', 'required'=>false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('contact_name_last',  ['class'=>'form-control', 'required'=>false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('phone_no', ['class'=>'form-control','label'=>'Phone No.', 'required'=>false, 'placeholder'=>'(123)-456-7890','id'=>'txtPhone']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('email', ['class'=>'form-control', 'required'=>false]); ?>
		</div>
        <div class="form-group">
			<?php echo $this->Form->control('state', ['class'=>'form-control', 'required'=>false]); ?>
		</div>
		<!--<div class="form-group">
			<?php echo $this->Form->control('state', ['options'=>$states, 'empty'=>false, 'class'=>'form-control','value'=> $lead->state]); ?>
		</div>-->	
		<div class="form-group">
			<?php echo $this->Form->control('zip_code', ['class'=>'form-control', 'required'=>false]); ?>
		</div>		
        <div class="form-group">
			<?php echo $this->Form->control('description_of_work', ['class'=>'form-control', 'required'=>false]); ?>
		</div>	        
		<div class="form-actions form-group">
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
		</div>
	<?= $this->Form->end() ?>	
	</div>
</div>
</div>
</div>

