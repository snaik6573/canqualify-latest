<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Employee $employee
*/
//pr($employee);
 ?>
<div class="row employees">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<strong>Edit</strong> Employee
		<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
		<span class="pull-right"><?= $this->Form->postLink(__('Delete'), ['action'=>'delete', $employee->id], ['class'=>'btn btn-danger btn-sm', 'confirm'=>__('Are you sure you want to delete # {0}?', $employee->id)]) ?></span>
		<?php } ?>
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create($employee) ?>
		<?php 
		$emailid = $employee->user_entered_email ? $employee->user->username : ''; ?>		
		<div class="form-group">
			<?php echo $this->Form->control('user.username', ['type'=>'email','class'=>'form-control','label' => 'Email','required' => false, 'value' => $emailid ,'oninput'=>'this.value=this.value.toLowerCase()']); ?>
		</div>		
		<div class="form-group">
			<?= $this->Form->checkbox('user.has_email',['id'=>'has-email','class'=>'has_email']); ?> 			
			<?= $this->Form->label('has_email', 'Use your E-mail address as a username'); ?>
		</div>	
		<div class="form-group login-cls" style="display: none;">
			<?php echo $this->Form->control('user.login_username', ['class'=>'form-control use-email','label' => 'Username','required' => false,'value'=>$employee->user->login_username,'oninput'=>'this.value=this.value.toLowerCase()']); ?>
		</div>		
		<div class="form-group">
			<?php echo $this->Form->control('emp_position', ['class'=>'form-control','label' => 'Position','required' => false]); ?>
		</div>
		<div class="form-group">
			<?= $this->Form->checkbox('addr_sameas_company',['id'=>'isaddressEnabled']); ?>
			<?= $this->Form->label('addr_sameas_company', 'Same As Company Adresses '); ?>
		</div>
		<?php $colloseShow = 'collapse';
			 if($employee['addr_sameas_company'] == false){ 
			 $colloseShow .= ' show';
		} ?>
       <div id="empAddress" class="form-group <?php echo $colloseShow; ?>">
		<div class="form-group">
			<?php echo $this->Form->control('addressline_1', ['class'=>'form-control', 'required'=>false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('addressline_2', ['class'=>'form-control', 'required'=>false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('city', ['class'=>'form-control', 'required'=>false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('country_id',['class'=>'form-control ajaxChange searchSelect', 'options' => $countries, 'data-url'=>'/countries/getStates/false', 'data-responce'=>'.ajax-responce','required' => false,'style'=>'width:500px;height:38;']); ?>
		</div>
		<div class="form-group ajax-responce">
		<?= $this->Form->label('State'); ?>
         <?php $state = [];
          if(empty($states)) {  
        	echo $this->Form->control('state_id', ['class'=>'form-control searchSelect', 'options' => $state, 'empty' => true,'label'=>false,'required' => false,'style'=>'width:500px;height:38;']); 
            }else{ 
            echo $this->Form->control('state_id', ['class'=>'form-control searchSelect', 'options' => $states,'empty' => true, 'label'=>false,'required' => false,'style'=>'width:500px;height:38;']); 
          } ?>
          <small id="countryHelp" class="form-text text-muted">States will be auto populated on country selection.</small>
		</div>		
		<div class="form-group">
			<?php echo $this->Form->control('zip', ['class'=>'form-control', 'required'=>false]); ?>
		</div>
	   </div>

		<div class="form-group">
			<?php echo $this->Form->control('pri_contact_fn', ['label'=>'First Name','class'=>'form-control', 'required'=>false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('pri_contact_ln', ['label'=>'Last Name','class'=>'form-control', 'required'=>false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('pri_contact_pn', ['label'=>'Phone Number','class'=>'form-control', 'required'=>false]); ?>
		</div>
        <hr>
        <div class="form-group">
            <?php echo $this->Form->control('emergency_contact_name', ['class'=>'form-control', 'required'=>false]); ?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->control('emergency_contact_number', ['class'=>'form-control', 'required'=>false,'placeholder'=>'(321) 654-0987','id'=>'txtPhone1']); ?>
        </div>
        <hr>
		<div class="form-group">
            <label for="site_id">Select Sites</label>
			<?= $this->Form->select('site_id', ['Select Sites' => $contractorSites], ['multiple' => true, 'class'=>'form-control selectwithcheckbox'] ); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('user.active', ['required'=>false]); ?>
		</div>
		<div class="form-actions form-group">
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
			<?= $this->Form->button('<em><i class="fa fa-ban"></i></em> Reset', ['type' => 'reset', 'class'=>'btn btn-danger btn-sm']); ?>
		</div>
	<?= $this->Form->end() ?>
	</div>
</div>
</div>

<div class="col-lg-6">
<div class="card">
    <div class="card-header">
        <strong>Locations</strong>
    </div>
    <div class="card-body card-block">
    
    <table id="bootstrap-data-table" class="table table-striped table-bordered">
    <thead>
    <tr>
        <!-- <th scope="col"><?= __('Employee Name') ?></th> -->
        <!-- <th scope="col"><?= __('Region') ?></th> -->
        <th scope="col"><?= __('Site') ?></th>
    </tr>
    </thead>
    <tbody>
    <?php  
    foreach ($selectedSites as $csite):     
    if(!empty($csite->site)){
    ?>
    <tr>
        <!-- <td><?= h($csite['employee']['pri_contact_fn']." ".$csite['employee']['pri_contact_ln']) ?></td> -->
        <td><?= h($csite->site->name) ?></td>
    </tr>
    <?php  } endforeach; ?>
    </tbody>
    </table>
    
    </div>
</div>
</div>



</div>
