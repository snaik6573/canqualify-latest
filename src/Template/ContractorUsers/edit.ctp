<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContractorUser $contractorUser
 */
$users = array(SUPER_ADMIN,CONTRACTOR,CONTRACTOR_ADMIN);
?>
<div class="row contractorUsers">
<?php if(!empty($service_id && $cat_id)){ ?>
<div class="col-lg-12">
<?php }else{ ?>
<div class="col-lg-6">
<?php } ?>
<div class="card">
	<div class="card-header">
		<strong>Edit Contractor User</strong>
		<?php if (in_array($activeUser['role_id'], $users)) { ?>
		<span class="pull-right"><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $contractorUser->id], ['class'=>'btn btn-danger btn-sm', 'confirm' => __('Are you sure you want to delete # {0}?', $contractorUser->id)]) ?></span>
		<?php } ?>
	</div>
	<div class="card-body card-block">
    <?= $this->Form->create($contractorUser) ?>
		<div class="form-group">
			<?php echo $this->Form->control('user.username', ['class'=>'form-control','label' => 'Email','required' => false,'oninput'=>'this.value=this.value.toLowerCase()']); ?>
		</div>	
        <div class="form-group">
			<?= $this->Form->control('title', ['class'=>'form-control','label'=>'Title', 'required'=>false]); ?>
		</div>	
		<div class="form-group">
			<?= $this->Form->control('pri_contact_fn', ['class'=>'form-control','label'=>'First Name', 'required'=>false]); ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('pri_contact_ln', ['class'=>'form-control','label'=>'Last Name', 'required'=>false]); ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('pri_contact_pn', ['id'=>'txtPhone', 'class'=>'form-control','label'=>'Phone No.', 'required'=>false, 'placeholder'=>'(123)-456-7890']); ?>
		</div>	
        <div class="form-group">
			<?php echo $this->Form->control('is_safety_contact', ['class'=>'', 'label'=>'Is safety Contact']); ?>
		</div>	
		<div class="form-group">
			<?php echo $this->Form->control('user.role_id', ['value' => 8, 'type'=>'hidden']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('user.active', ['class'=>'']); ?>
		</div>        
        <div class="form-group">
			<?= $this->Form->control('user.under_configuration',['type'=>'hidden','default'=>false]); ?>
        </div>
		<div class="form-actions form-group">
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
			<?= $this->Form->button('<em><i class="fa fa-ban"></i></em> Reset', ['type' => 'reset', 'class'=>'btn btn-danger btn-sm']); ?>
		</div>
    <?= $this->Form->end() ?>
	</div>
</div>
</div>
</div>
