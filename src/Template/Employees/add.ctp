<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Employee $employee
 */
?>
<div class="row employees">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<strong>Add Employee</strong> 
	</div>
	<div class="card-body card-block contractorSites">
	<?= $this->Form->create($employee) ?>
	 	<div class="form-group">
			<?= $this->Form->checkbox('is_login_enable',['id'=>'isLoginEnabled']); ?>
			<?= $this->Form->label('is_login_enable', 'Setup employee with user login credentials'); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('user.username', ['type'=>'email','class'=>'form-control','label' => 'Email','required' => false,'oninput'=>'this.value=this.value.toLowerCase()']); ?>
		</div>
		<div class="form-group">
			<?= $this->Form->checkbox('user.has_email',['id'=>'has-email','class'=>'has_email','checked'=>'checked']); ?>
			<?= $this->Form->label('has_email', 'Use E-mail address as a username'); ?>
		</div>		
		<div class="form-group login-cls" style="display: none;">
			<?php echo $this->Form->control('login_username', ['class'=>'form-control','label' => 'Username','required' => false,'oninput'=>'this.value=this.value.toLowerCase()']); ?>
		</div>
	
		<div class="form-group login-cls" style="display: none;">
			<?php echo $this->Form->control('password', ['class'=>'form-control','required' => false, 'value'=> '']); ?>
		</div>	
		<div class="form-group login-cls" style="display: none;">
			<?php echo $this->Form->control('confirm_password', ['type'=>'password','class'=>'form-control','required' => false, 'value'=> '']); ?>
		</div>
		 <?php $colloseShow = 'collapse';
		if(empty($isLoginEnabled)){ $colloseShow ='collapse show'; }
       	?>
		<div id="uname" class="form-group <?php echo $colloseShow; ?>">
			<?php echo $this->Form->control('password', ['class'=>'form-control','label' => 'Password','required' => false]); ?>
		</div> 
		<div class="form-group">
			<?php echo $this->Form->control('emp_position', ['class'=>'form-control','label' => 'Position','required' => false]); ?>
		</div>
		<div class="form-group">
			<?= $this->Form->checkbox('addr_sameas_company',['id'=>'isaddressEnabled']); ?>
			<?= $this->Form->label('addr_sameas_company', 'Same As Company Adresses '); ?>
		</div>
		<?php $colloseShow = 'collapse show'; 
		 if($employee['addr_sameas_company']){   $colloseShow = 'collapse'; }?>
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
		<?= $this->Form->label('Country'); ?>
		<div class="form-group">
		<?php  $otherOption = array('0' => "Other");
				$countries = $otherOption + $countries;
			   //$countries = array_merge($otherOption,$countries);
		    echo $this->Form->control('country_id',['class'=>'form-control ajaxChange otherCountrySelection searchSelect','id'=>'otherCountrySelection', 'options' =>$countries , 'empty' => 'Please select country', 'data-url'=> '/' . basename(ROOT) . '/countries/getStates/false', 'data-responce'=>'.ajax-responce','label'=>false, 'required'=>false,'style'=>'width:500px;height:38;']); ?>
	    </div>
		</div>
		<div class="form-group userEnterCountry" style="display: none;">
		<?= $this->Form->control('country', ['type'=>'text', 'class'=>'form-control userEnterCountry','id'=>'userEnterCountry', 'placeholder'=>'Please enter your country']); ?> 
		</div>
		<div class="form-group userEnterCountry" style="display: none;">
		<?= $this->Form->control('state', ['type'=>'text', 'class'=>'form-control userEnterCountry','id'=>'userEnterCountry','placeholder'=>'Please enter your state']); ?>
		</div>
		<div class="form-group ajax-responce statelist">
			<?= $this->Form->label('State'); ?>
            <?php if(!empty($stateOptions)) {
        	echo $this->Form->control('state_id', ['class'=>'form-control searchSelect', 'options' => $stateOptions, 'label'=>false,'required' => false,'style'=>'width:500.5px;height:38;']);
            }else{ 
            echo $this->Form->control('state_id', ['class'=>'form-control searchSelect', 'options' => [], 'label'=>false, 'required' => false,'style'=>'width:500px;height:38;']);
            } ?>
            <small id="countryHelp" class="form-text text-muted">States will be auto populated on Country Selection.</small>
		</div>	
		<div class="form-group">
			<?php echo $this->Form->control('zip', ['class'=>'form-control', 'required'=>false]); ?>
		</div>
		</div>
		<div class="form-group">
			<?= $this->Form->label('Employee First Name'); ?>
			<?php echo $this->Form->control('pri_contact_fn', ['class'=>'form-control', 'required'=>false,'label'=>false]); ?>
		</div>
		<div class="form-group">
			<?= $this->Form->label('Employee Last Name'); ?>
			<?php echo $this->Form->control('pri_contact_ln', ['class'=>'form-control', 'required'=>false,'label'=>false]); ?>
		</div>
		<div class="form-group">
			<?= $this->Form->label('Employee Phone Number'); ?>
			<?php echo $this->Form->control('pri_contact_pn', ['class'=>'form-control', 'required'=>false,'placeholder'=>'(123) 456-7890','id'=>'txtPhone','label'=>false]); ?>
		</div>
		<hr>
		<div class="form-group">
			<?php echo $this->Form->control('emergency_contact_name', ['class'=>'form-control', 'required'=>false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('emergency_contact_number', ['class'=>'form-control', 'required'=>false,'placeholder'=>'(321) 654-0987','id'=>'txtPhone1']); ?>
		</div>
		<hr>			
		<!--<div class="form-group">
            <label for="site_id">Select Sites</label>
            <?= $this->Form->select('site_id', ['Select Sites' => $contractorSites], ['multiple' => true, 'class'=>'form-control selectwithcheckbox'] ); ?>
		</div>-->
		<div class="form-group">
			<?php echo $this->Form->control('user.active', ['class'=>'form-control', 'required'=>false, 'checked'=>'checked']); ?>
			<?php echo $this->Form->control('user.role_id', ['type'=>'hidden', 'value'=>7 ]); ?>
			<?php echo $this->Form->control('registration_status', ['type'=>'hidden', 'value'=>2 ]); ?>
		</div>
		<div class="form-actions form-group">
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Send Request', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>			
		</div>
	<?= $this->Form->end() ?>
	</div>
</div>
</div>
</div>
