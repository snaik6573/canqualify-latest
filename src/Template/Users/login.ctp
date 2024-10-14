<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<?= $this->Form->create() ?>
	<div class="form-group">
		<?= $this->Form->control('username', ['label'=>'Username', 'type'=>'', 'class'=>'form-control', 'required' => true, 'value' => $cookie['username'], 'placeholder'=>'Username','oninput'=>'this.value=this.value.toLowerCase()']); ?>
	</div>
	<div class="form-group">
		<?= $this->Form->control('password', ['class'=>'form-control', 'value' => $cookie['password'], 'placeholder'=>'Password']); ?>
	</div>
	<div class="checkbox">
		<?= $this->Form->checkbox('remember_me', ['checked' => $cookie['remember_me']]); ?> Remember Me
		<span class="pull-right"><?= $this->Html->link(__('Forgot Password?'), ['action' => 'forgotPassword']) ?></span>
	</div>
	<div class="form-group">
		<?= $this->Form->button(__('Sign in'), ['class'=>'btn btn-success btn-flat m-b-30 m-t-30']) ?>
	</div>
	<div class="register-link m-t-15 text-center">
		<p>Don't have an account ? <?= $this->Html->link(__('Sign Up Here'), ['controller'=>'Contacts', 'action' => 'contact-us']) ?></p>
	</div>
<?= $this->Form->end() ?>
