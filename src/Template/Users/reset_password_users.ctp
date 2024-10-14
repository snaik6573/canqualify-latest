<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row users">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong>Change</strong> Password
	</div>

	<div class="card-body card-block">
	<?= $this->Form->create() ?>
	<div class="form-group row">
		<?= $this->Form->label('Select User Email', null, ['class'=>'col-sm-3  col-form-label']); ?>
		<div class="col-sm-5"><?= $this->Form->control('username', ['options'=>$users,'empty'=>true,'class'=>'form-control', 'label'=>false ,"required"=>true]) ?></div>
	</div>
	<div class="form-group row">
		<?= $this->Form->label('Generate New Password', null, ['class'=>'col-sm-3  col-form-label', 'label'=>false]); ?>
		<div class="col-sm-5"><input type="text" name="password" id="password" class="form-control" required="true"></div>
		<?= $this->Form->button('<em><i class="fa fa-key"></i></em> Generate Password', ['type' => 'button','id'=>'genPassword', 'class'=>'btn btn-primary btn-sm']); ?>
	</div>
	
	<div class="form-actions form-group">
		<!-- <?= $this->Form->control('username', ['type'=>'hidden', 'value'=>$user['username']]); ?> -->
		<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
	</div>
	<?= $this->Form->end() ?>
	</div>
</div>
</div>
</div>
