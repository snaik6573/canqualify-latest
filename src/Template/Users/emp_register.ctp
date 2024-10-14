<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$this->assign('title', 'register');
?>
<div class="row">
<div class="col-sm-12">

<?= $this->Form->create($employee) ?>
<div class="form-group row">
	<?= $this->Form->label('Email', null, ['class'=>'col-sm-3  col-form-label']); ?>
	<div class="col-sm-4"><?= $this->Form->control('user.username', ['class'=>'form-control', 'label'=>false, 'required'=>false,'oninput'=>'this.value=this.value.toLowerCase()']); ?></div>
</div>
<div class="form-group row">
	<?= $this->Form->label('Password', null, ['class'=>'col-sm-3  col-form-label']); ?>
	<div class="col-sm-4"><?= $this->Form->control('user.password', ['class'=>'form-control', 'label'=>false, 'required'=>false, 'value'=>'']); ?></div>
</div>
<div class="form-group row">
	<?= $this->Form->label('Confirm Password', null, ['class'=>'col-sm-3  col-form-label']); ?>
	<div class="col-sm-4"><?= $this->Form->control('user.confirm_password', ['type'=>'password','class'=>'form-control', 'label'=>false, 'required'=>false,'value'=>'']); ?></div>
</div>
<div class="form-group row">
	<?= $this->Form->label('Position', null, ['class'=>'col-sm-3  col-form-label']); ?>
	<div class="col-sm-4"><?php echo $this->Form->control('emp_position', ['class'=>'form-control','label' => false,'required' => false]); ?></div>
</div>
<div class="form-group row">
	<?= $this->Form->label('Address Line 1', null, ['class'=>'col-sm-3  col-form-label']); ?>
	<div class="col-sm-4"><?= $this->Form->control('addressline_1', ['class'=>'form-control', 'label'=>false, 'required'=>false]); ?></div>
</div>
<div class="form-group row">
	<?= $this->Form->label('Address Line 2', null, ['class'=>'col-sm-3  col-form-label']); ?>
	<div class="col-sm-4"><?= $this->Form->control('addressline_2', ['class'=>'form-control', 'label'=>false, 'required'=>false]); ?></div>
</div>
<div class="form-group row">
	<?= $this->Form->label('City', null, ['class'=>'col-sm-3  col-form-label']); ?>
	<div class="col-sm-4"><?= $this->Form->control('city', ['class'=>'form-control', 'label'=>false, 'required'=>false]); ?></div>
</div>
<div class="form-group row">
	<?= $this->Form->label('Country', null, ['class'=>'col-sm-3  col-form-label']); ?>
	<div class="col-sm-4">
	<?php  $otherOption = array('0' => "Other");
		$countries = $otherOption + $countries;
		   //$countries = array_merge($otherOption,$countries);
	    echo $this->Form->control('country_id',['class'=>'form-control ajaxChange otherCountrySelection searchSelect','id'=>'otherCountrySelection', 'options' =>$countries , 'empty' => 'Please select country', 'data-url'=>'/countries/getStates/true', 'data-responce'=>'.ajax-responce','label'=>false, 'required'=>false]); ?>
    </div>
</div>
<div class="form-group row userEnterCountry" style="display: none;">
<div class="col-sm-3"></div>
<div class="col-sm-4">
	<?= $this->Form->control('country', ['type'=>'text', 'class'=>'form-control userEnterCountry','id'=>'userEnterCountry','label'=>false, 'placeholder'=>'Please enter your country']) ?> 
</div>
</div>
<div class="form-group row userEnterCountry" style="display: none;">
<?= $this->Form->label('State', null, ['class'=>'col-sm-3  col-form-label']); ?>
<div class="col-sm-4">
	<?= $this->Form->control('state', ['type'=>'text', 'class'=>'form-control userEnterCountry','id'=>'userEnterCountry','label'=>false, 'placeholder'=>'Please enter your state']) ?>
</div>
</div>
<div class="form-group  row statelist">
	<?= $this->Form->label('State', null, ['class'=>'col-sm-3  col-form-label']); ?>
	<div class="col-sm-4 ajax-responce"> 
		<?php if(!empty($statesOptions)) { 
        	 echo $this->Form->control('state_id', ['class'=>'form-control searchSelect', 'options' => $stateOptions, 'label'=>'State','label'=>false,'required'=>false]); 
            }else{ 
             echo $this->Form->control('state_id', ['class'=>'form-control searchSelect', 'options' => [], 'label'=>'State','label'=>false, 'required'=>false]);
            } ?>
        <small id="countryHelp" class="form-text text-muted">States will be auto populated on country selection.</small>
    </div>
</div>
<div class="form-group row">
	<?= $this->Form->label('Zip', null, ['class'=>'col-sm-3  col-form-label']); ?>
	<div class="col-sm-4"><?= $this->Form->control('zip', ['class'=>'form-control', 'label'=>false, 'type'=>'text']); ?></div>
</div>
<div class="form-group row">
	<?= $this->Form->label('Primary Contact First Name', null, ['class'=>'col-sm-3  col-form-label']); ?>
	<div class="col-sm-4"><?= $this->Form->control('pri_contact_fn', ['class'=>'form-control','label'=>false, 'required'=>false]); ?></div>
</div>
<div class="form-group row">
	<?= $this->Form->label('Primary Contact Last Name', null, ['class'=>'col-sm-3  col-form-label']); ?>
	<div class="col-sm-4"><?= $this->Form->control('pri_contact_ln', ['class'=>'form-control','label'=>false, 'required'=>false]); ?></div>
</div>
<div class="form-group row">
	<?= $this->Form->label('Phone No', null, ['class'=>'col-sm-3  col-form-label']); ?>
	<div class="col-sm-4"><?= $this->Form->control('pri_contact_pn', ['id'=>'txtPhone', 'class'=>'form-control','label'=>false, 'required'=>false, 'placeholder'=>'(123)-456-7890']); ?></div>
</div>
<div class="form-group row">
	<?= $this->Form->label('Emergency Contact Name', null, ['class'=>'col-sm-3  col-form-label']); ?>
		<div class="col-sm-4"><?php echo $this->Form->control('emergency_contact_name', ['class'=>'form-control', 'required'=>false,'label'=>false]); ?></div>
</div>
<div class="form-group row">
	<?= $this->Form->label('Emergency Contact No', null, ['class'=>'col-sm-3  col-form-label']); ?>
		<div class="col-sm-4"><?php echo $this->Form->control('emergency_contact_number', ['class'=>'form-control', 'required'=>false,'placeholder'=>'(321) 654-0987','id'=>'txtPhone1','label'=>false]); ?></div>
</div>
<div class="form-group row">
            <?= $this->Form->label('Make My Profile searchable by Suppliers and Clients', null, ['class'=>'col-sm-3  col-form-label']); ?> 
            <div class="col-sm-9">       
            <?= $this->Form->control('profile_search',['label'=>false,'default'=>'1']); ?>
            </div> 
</div>
<div class="form-group row">
        <label class="col-sm-3  col-form-label" for="acknowledge-canqualify-terms-conditions">Acknowledge CanQualify Terms &amp; Conditions</label>
        <div class="col-sm-9">
            <?= $this->Form->checkbox('tnc',array('required' => 'required', 'oninvalid' => "this.setCustomValidity('Please read and accept Terms and Conditions')", 'oninput' => "this.setCustomValidity('')")); ?>
            <?= $this->Html->link(__('Terms & Conditions'), '/pages/terms-and-conditions', ['target'=>'_BLANK']) ?>
        </div>
</div>
<div class="form-group row captcha-dv">
	<?php if($usecaptcha==1) { ?>
              <div class="offset-sm-3 col-sm-6 g-recaptcha" data-sitekey="6Ld9UaMUAAAAAJyl_uFaaAh6EXCvbvWjjoVBGAtC"></div>
        <?php } ?>
</div>
<div class="form-actions form-group row">
	<div class="offset-sm-3  col-sm-6">
	<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type'=>'submit', 'class'=>'btn btn-primary']); ?>
	</div>
</div>
<?= $this->Form->end() ?>

</div>
</div>
<?php 

$data = '+11234567890';
if(  preg_match( '/^\+\d(\d{3})(\d{3})(\d{4})$/', $data,  $matches ) )
{
    $result = '('.$matches[1].')'. '-' .$matches[2] . '-' . $matches[3]; 
}
?>

