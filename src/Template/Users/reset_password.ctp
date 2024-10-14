<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<?= $setnew==1 ? '<h4>Set Password</h4>' : '<h4>Reset Your Password</h4>' ?>
<?= $this->Form->create($user) ?>
	<div class="form-group">
		<?php echo $this->Form->control('password', ['class'=>'form-control', 'label'=>'New Password', 'required' => false, 'value' => '']); ?>
	</div>
	<div class="form-group">
		<?php echo $this->Form->control('confirm_password', ['type'=>'password', 'class'=>'form-control', 'required' => false, 'value' => '']); ?>
	</div>
	<div class="form-actions form-group">
		<?php echo $this->Form->control('username', ['type'=>'hidden']); ?>
		<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Reset Password', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
	</div>
<?= $this->Form->end() ?>
</div>
