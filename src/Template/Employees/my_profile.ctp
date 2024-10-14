<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
?>
<div class="row employees">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong>Login </strong> Details
	</div>

	<div class="card-body card-block">
	<?= $this->Form->create($employee) ?>
	<div class="form-group row">
		<?php $emailid = $employee->user_entered_email ? $employee->user->username : ''; ?>
		<?= $this->Form->label('Email', null, ['class'=>'col-sm-3  col-form-label']); ?>
		<div class="col-sm-4"><?php echo $this->Form->control('user.username', ['class'=>'form-control', 'label'=>false, 'required'=>false,'oninput'=>'this.value=this.value.toLowerCase()','value' => $emailid ,]); ?></div>	
	</div>
	<div class="form-group row">
	<?php $login_username = !empty($employee->user->login_username) ? $employee->user->login_username : ''; ?>	
		<?= $this->Form->label('Username', null, ['class'=>'col-sm-3  col-form-label']); ?>
		<div class="col-sm-4"><?php echo $this->Form->control('user.login_username', ['class'=>'form-control','label' => false,'required' => false,'value'=>$employee->user->login_username,'oninput'=>'this.value=this.value.toLowerCase()']);   ?></div>
	</div>
	<div class="form-actions form-group row">
		<div class="offset-sm-3 col-sm-9">
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
			<?= $this->Html->link(__('<em><i class="fa fa-dot-circle-o"></i></em> Change Password'), ['controller' => 'Users','action' => 'changePassword'], ['escape' => false, 'class'=>'btn btn-success btn-sm']) ?>
		</div>
	</div>
	<?= $this->Form->end() ?>
	</div>
</div>
</div>

<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong>Profile</strong>
	</div>

	<div class="card-body card-block">
	<?= $this->Form->create($employee) ?>
	<?= $this->element('profile_upload', ["user" => $employee->user, "fieldname" => 'user.profile_photo']) ?>
   	<div class="form-actions form-group">
   		<?php if($employee->user_entered_email){ ?>
		<?= $this->Form->control('user.username', ['type'=>'hidden']); ?>
		<?php }else{ ?>
			<?= $this->Form->control('user.login_username', ['type'=>'hidden']); ?>
		<?php } ?>
		<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
	</div>
	<?= $this->Form->end() ?>
	</div>
</div>
</div>

<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong>Primary Contact</strong> Details
	</div>

	<div class="card-body card-block">
	<?= $this->Form->create($employee) ?>
	<div class="form-group row">
		<?= $this->Form->label('First Name', null, ['class'=>'col-sm-3  col-form-label']); ?>
		<div class="col-sm-4"><?= $this->Form->control('pri_contact_fn', ['class'=>'form-control','label'=>false, 'required'=>false]); ?></div>
	</div>
	<div class="form-group row">
		<?= $this->Form->label('Last Name', null, ['class'=>'col-sm-3  col-form-label']); ?>
		<div class="col-sm-4"><?= $this->Form->control('pri_contact_ln', ['class'=>'form-control','label'=>false, 'required'=>false]); ?></div>
	</div>
	<div class="form-group row">
		<?= $this->Form->label('Phone No', null, ['class'=>'col-sm-3  col-form-label']); ?>
		<div class="col-sm-4"><?= $this->Form->control('pri_contact_pn', ['class'=>'form-control','label'=>false, 'required'=>false]); ?></div>
	</div>
	<div class="form-group row">
		<?= $this->Form->label('Position', null, ['class'=>'col-sm-3  col-form-label']); ?>
		<div class="col-sm-4"><?= $this->Form->control('emp_position', ['class'=>'form-control','label'=>false, 'required'=>false]); ?></div>
	</div>
	<div class="form-group row">
		<?= $this->Form->label('Addressline 1', null, ['class'=>'col-sm-3  col-form-label']); ?>
		<div class="col-sm-6"><?= $this->Form->control('addressline_1', ['class'=>'form-control', 'label'=>false, 'required'=>false]); ?></div>
	</div>
	<div class="form-group row">
		<?= $this->Form->label('Addressline 2', null, ['class'=>'col-sm-3  col-form-label']); ?>
		<div class="col-sm-6"><?= $this->Form->control('addressline_2', ['class'=>'form-control', 'label'=>false, 'required'=>false]); ?></div>
	</div>
	<div class="form-group row">
		<?= $this->Form->label('City', null, ['class'=>'col-sm-3  col-form-label']); ?>
		<div class="col-sm-4"><?= $this->Form->control('city', ['class'=>'form-control', 'label'=>false, 'required'=>false]); ?></div>
	</div>
	<div class="form-group row">
	<?= $this->Form->label('Country', null, ['class'=>'col-sm-3  col-form-label']); ?>
	<div class="col-sm-4"><?php echo $this->Form->control('country_id',['class'=>'form-control ajaxChange searchSelect', 'options' => $countries,'data-url'=>'/countries/getStates/true', 'data-responce'=>'.ajax-responce','label'=>false,'required' => false]); ?>
	</div>
	</div>
	<div class="form-group  row">
	<?= $this->Form->label('State', null, ['class'=>'col-sm-3  col-form-label']); ?>
	<div class="col-sm-4 ajax-responce">
	   <?php $state = [];
          if(empty($states)) {  
        	echo $this->Form->control('state_id', ['class'=>'form-control searchSelect', 'options' => $state, 'empty' => true,'label'=>false,'required' => false]); 
            }else{ 
            echo $this->Form->control('state_id', ['class'=>'form-control searchSelect', 'options' => $states,'empty' => true, 'label'=>false,'required' => false]); 
          } ?>
      <small id="countryHelp" class="form-text text-muted">States will be auto populated on country selection.</small>          	
      </div>
	</div>
	<div class="form-group row">
		<?= $this->Form->label('Zip', null, ['class'=>'col-sm-3  col-form-label']); ?>
		<div class="col-sm-2"><?= $this->Form->control('zip', ['class'=>'form-control', 'label'=>false, 'type'=>'text']); ?></div>
	</div>
    <div class="form-group row">
            <?= $this->Form->label('About', null, ['class'=>'col-sm-3  col-form-label']); ?>
            <div class="col-sm-9"><?= $this->Form->control('about', ['class'=>'form-control note', 'label'=>false, 'type'=>'textarea']); ?></div>
    </div>
     <div class="form-group row">
            <?= $this->Form->label('Skills', null, ['class'=>'col-sm-3  col-form-label']); ?>
            <div class="col-sm-9"><?= $this->Form->control('skills', ['class'=>'form-control note', 'label'=>false, 'type'=>'textarea']); ?></div>
     </div>
     <div class="form-group row">
            <?= $this->Form->label('Work Experience', null, ['class'=>'col-sm-3  col-form-label']); ?>
            <div class="col-sm-9"><?= $this->Form->control('work_experience', ['class'=>'form-control note', 'label'=>false, 'type'=>'textarea']); ?></div>
     </div>
	<div class="form-group row">
            <?= $this->Form->label('Make My Profile searchable by Suppliers and Clients', null, ['class'=>'col-sm-3  col-form-label']); ?> 
            <div class="col-sm-9">       
            <?= $this->Form->control('profile_search',['label'=>false,'default'=>'1']); ?>
            </div> 
	</div>
	<div class="form-actions form-group">
		<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
	</div>
	<?php echo $this->Form->control('registration_status', ['label'=>false, 'type'=>'hidden', 'value'=>'1']); ?>
	<?php if($employee->user_entered_email){ ?>
		<?= $this->Form->control('user.username', ['type'=>'hidden','value' => $employee->user->username]); ?>
		<?php }else{ ?>
			<?= $this->Form->control('user.login_username', ['type'=>'hidden','value' => $employee->user->login_username]); ?>
		<?php } ?>
	<?= $this->Form->end() ?>
	</div>
</div>
</div>
</div>
