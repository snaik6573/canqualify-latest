<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Contractor $contractor
 */
?>
<div class="row contractors">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<strong>Add New</strong> Contractor
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create($contractor) ?>
		<div class="form-group">
			<?php echo $this->Form->control('user.username', ['class'=>'form-control','label' => 'Email','required' => false,'oninput'=>'this.value=this.value.toLowerCase()']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('user.password', ['class'=>'form-control','required' => false, 'value'=> '']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('user.confirm_password', ['type'=>'password','class'=>'form-control','required' => false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('company_name', ['class'=>'form-control', 'required' => false]); ?>
		</div>
		<div class="row form-group">
		   <?= $this->Form->label('Company Logo', null, ['class'=>'col-sm-3']); ?><br />
		   <div class="col-sm-9 uploadWraper">
		   <?php echo $this->Form->control('company_logo', ['label'=>false, 'type'=>'hidden', 'class'=>'documentName']); ?>
		   <?php echo $this->Form->file('uploadFile', ['label'=>false ]); ?>
		   <div class="uploadResponse"></div>
		   </div>
		</div>
        <div class="form-group">
			<?php echo $this->Form->control('company_tin', ['id'=>'txtTIN','class'=>'form-control', 'label'=>'Company TIN', 'required' => false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('addressline_1', ['class'=>'form-control', 'label'=>'Address Line 1', 'required' => false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('addressline_2', ['class'=>'form-control', 'label'=>'Address Line 2', 'required' => false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('city', ['class'=>'form-control', 'required' => false]); ?>
		</div>
		<div class="form-group">
		<?= $this->Form->label('Country'); ?>
		<div class="form-group">
		<?php  $otherOption = array('0' => "Other");
				$countries = $otherOption + $countries;
			   //$countries = array_merge($otherOption,$countries);
		    echo $this->Form->control('country_id',['class'=>'form-control ajaxChange otherCountrySelection searchSelect','id'=>'otherCountrySelection', 'options' =>$countries , 'empty' => 'Please select country', 'data-url'=>'/countries/getStates/false', 'data-responce'=>'.ajax-responce','label'=>false, 'required'=>false]); ?>
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
        	     echo $this->Form->control('state_id', ['class'=>'form-control searchSelect', 'options' => $stateOptions, 'label'=>false,'required' => false]);
             }else{ 
                 echo $this->Form->control('state_id', ['class'=>'form-control searchSelect', 'options' => [], 'label'=>false, 'required' => false]);
            } ?>
         <small id="countryHelp" class="form-text text-muted">States will be auto populated on country selection.</small>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('zip', ['class'=>'form-control', 'type'=>'text']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('pri_contact_fn', ['class'=>'form-control','label'=>'First Name', 'required' => false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('pri_contact_ln', ['class'=>'form-control','label'=>'Last Name', 'required' => false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('pri_contact_pn', ['class'=>'form-control','label'=>'Phone No.', 'required' => false,'placeholder'=>'(123) 456-7890','id'=>'txtPhone']); ?>
		</div>
        <div class="form-group">
			<?php echo $this->Form->control('is_safety_contact', ['class'=>'', 'label'=>'Is safety Contact']); ?>
		</div>
		<div class="form-group">
			<label>Are you safety sensitive? </label><br />
			<?php echo $this->Form->radio('is_safety_sensitive', ['No', 'Yes'], ['default' => '0']); ?>
		</div>
		<!--<div class="form-group">
			<?php echo $this->Form->control('customer_representative_id', ['options'=>$customer_rep, 'empty'=>true, 'class'=>'form-control']); ?>
		</div>    -->    

		<?php //echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]); ?>
		<!--<div class="form-group captcha-dv">
		<?php
			/*echo $this->Captcha->create('captchacode', [
			'reload_txt'=>'reload',
			'type'=>'image',
			'theme'=>'default', //two themes, "default" and "random",
			'width'=>200,
			'height'=>60,
			]);*/
			?>
		</div>-->
		<div class="form-actions form-group">
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
		</div>
		<?= $this->Form->end() ?>
	</div>
</div>
</div>
</div>
