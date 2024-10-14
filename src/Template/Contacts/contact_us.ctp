<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="">
	<h6>If you are a contractor or a supplier, please <?= $this->Html->link('Click', ['controller'=>'Users', 'action'=>'register'], ['class'=>'register_link']);?> here to register</h6><br />
	<h6>If you are a Employee, please <?= $this->Html->link('Click', ['controller'=>'Users', 'action'=>'emp_register'], ['class'=>'register_link']);?> here to register</h6><br />
	<h6>If you would like more information please complete the form below.</h6><br />
	<!--<h6>Or contact us using following form.</h6><br />-->
</div>

<div class="contact-us">
	<?= $this->Form->create($contact) ?>
	<div class="form-group">
		<?= $this->Form->control('company_name', ['label'=>'Company Name', 'class'=>'form-control', 'required'=>false, 'placeholder'=>'Company Name']); ?>
	</div>
	<div class="form-group">
		<?= $this->Form->control('fname', ['label'=>'First Name', 'class'=>'form-control', 'required'=>false, 'placeholder'=>'First Name']); ?>
	</div>
	<div class="form-group">
		<?= $this->Form->control('lname', ['label'=>'Last Name', 'class'=>'form-control', 'required'=>false, 'placeholder'=>'Last Name']); ?>
	</div>
	<div class="form-group">
		<?= $this->Form->control('email', ['label'=>'Email address', 'class'=>'form-control', 'required'=>false, 'placeholder'=>'Email']); ?>
	</div>
	<div class="form-group">
		<?= $this->Form->control('phone_no', ['label'=>'Phone no.', 'id'=>'txtPhone', 'class'=>'form-control', 'placeholder'=>'(123)-456-7890']); ?>
	</div>
	<div class="form-group captcha-dv">	
	<?php if($usecaptcha==1) { ?>
              <div class="g-recaptcha" data-sitekey="6LdSbpEUAAAAAAClEHMCzO7-2kG2bu808r-ReUHB"></div>
        <?php } ?>
	</div>
	<div class="form-actions form-group">
	<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type'=>'submit', 'class'=>'btn btn-primary btn-sm']); ?>
	</div>
	 <?= $this->Form->end() ?>
</div>
