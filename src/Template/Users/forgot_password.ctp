<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<h4>Request Password Reset</h4>

<?= $this->Form->create() ?>
	<div class="form-group">
		<?php echo $this->Form->control('username', ['label'=>'Email address', 'type'=>'email', 'class'=>'form-control', 'required' => true,'oninput'=>'this.value=this.value.toLowerCase()']); ?>
	</div>
	<div class="form-group">
		<?= $this->Form->button(__('Submit'), ['class'=>'btn btn-success btn-flat m-b-30 m-t-30']) ?>
	</div>
<?= $this->Form->end() ?>
