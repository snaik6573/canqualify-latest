<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

if( in_array($activeUser['role_id'], array(SUPER_ADMIN, ADMIN, CR)) ) {
?>
<div class="row roles">

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header clearfix">
                <strong>Login as</strong> Client
            </div>
            <div class="card-body card-block">
                <?= $this->Form->create() ?>
                <div class="form-group">
                    <?= $this->Form->select('username', $clientList, ['class' => 'form-control searchSelect']); ?>
                </div>
                <div class="form-group">
                    <?= $this->Form->control('role_id', ['type' => 'hidden', 'value' => CLIENT]) ?>
                    <?= $this->Form->button(__('Sign in'), ['class' => 'btn btn-sm btn-success btn-flat m-b-30 m-t-30']) ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header clearfix">
                <strong>Login as</strong> Contractor
            </div>
            <div class="card-body card-block">
                <?= $this->Form->create() ?>
                <div class="form-group">
                    <?= $this->Form->select('username', $contractorList, ['class' => 'form-control searchSelect']); ?>
                </div>
                <div class="form-group">
                    <?= $this->Form->control('role_id', ['type' => 'hidden', 'value' => CONTRACTOR]) ?>
                    <?= $this->Form->button(__('Sign in'), ['class' => 'btn btn-sm btn-success btn-flat m-b-30 m-t-30']) ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header clearfix">
                <strong>Login as</strong> Client User
            </div>
            <div class="card-body card-block">
                <?= $this->Form->create() ?>
                <div class="form-group">
                    <?= $this->Form->select('username', $clientUserList, ['class' => 'form-control searchSelect']); ?>
                </div>
                <div class="form-group">
                    <?= $this->Form->control('role_id', ['type' => 'hidden', 'value' => CLIENT_ADMIN . ',' . CLIENT_VIEW . ',' . CLIENT_BASIC]) ?>
                    <?= $this->Form->button(__('Sign in'), ['class' => 'btn btn-sm btn-success btn-flat m-b-30 m-t-30']) ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card">
            <div class="card-header clearfix">
                <strong>Login as</strong> Contractor User
            </div>
            <div class="card-body card-block">
                <?= $this->Form->create() ?>
                <div class="form-group">
                    <?= $this->Form->select('username', $contractorUserList, ['class' => 'form-control searchSelect']); ?>
                </div>
                <div class="form-group">
                    <?= $this->Form->control('role_id', ['type' => 'hidden', 'value' => CONTRACTOR_ADMIN]) ?>
                    <?= $this->Form->button(__('Sign in'), ['class' => 'btn btn-sm btn-success btn-flat m-b-30 m-t-30']) ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>


        <?php
        if( !in_array($activeUser['role_id'], array(CR))) {
        ?>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header clearfix">
                <strong>Login as</strong> Customer Representative
            </div>
            <div class="card-body card-block">
                <?= $this->Form->create() ?>
                <div class="form-group">
                    <?= $this->Form->select('username', $crList, ['class' => 'form-control searchSelect']); ?>
                </div>
                <div class="form-group">
                    <?= $this->Form->control('role_id', ['type' => 'hidden', 'value' => CR]) ?>
                    <?= $this->Form->button(__('Sign in'), ['class' => 'btn btn-sm btn-success btn-flat m-b-30 m-t-30']) ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
        <?php
        }
        ?>


<div class="col-lg-6">
<div class="card">
	<div class="card-header clearfix">
		<strong>Login as</strong> Employee With Email	
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create() ?>
	<div class="form-group">
		<?= $this->Form->select('username', $employeeList, ['class'=>'form-control searchSelect']); ?>
	</div>	
	<div class="form-group">
		<?= $this->Form->control('role_id', ['type'=>'hidden', 'value'=>EMPLOYEE]) ?>
		<?= $this->Form->button(__('Sign in'), ['class'=>'btn btn-sm btn-success btn-flat m-b-30 m-t-30']) ?>
	</div>
	<?= $this->Form->end() ?>
    </div>
</div>
</div>

<?php if($activeUser['role_id'] == SUPER_ADMIN ) {?>
<div class="col-lg-6">
<div class="card">
	<div class="card-header clearfix">
		<strong>Login as</strong> Admin		
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create() ?>
	<div class="form-group">
		<?= $this->Form->select('username', $adminList, ['class'=>'form-control searchSelect']); ?>
	</div>	
	<div class="form-group">
		<?= $this->Form->control('role_id', ['type'=>'hidden', 'value'=>ADMIN]) ?>
		<?= $this->Form->button(__('Sign in'), ['class'=>'btn btn-sm btn-success btn-flat m-b-30 m-t-30']) ?>
	</div>
	<?= $this->Form->end() ?>
    </div>
</div>
</div>
<?php
}
?>

<div class="col-lg-6">
<div class="card">
	<div class="card-header clearfix">
		<strong>Login as</strong> Employee With Username		
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create() ?>
	<div class="form-group">
		<?= $this->Form->select('id', $employeeList1, ['class'=>'form-control searchSelect']); ?>
	</div>	
	<div class="form-group">
		<?= $this->Form->control('role_id', ['type'=>'hidden', 'value'=>EMPLOYEE]) ?>
		<?= $this->Form->control('username', ['type'=>'hidden', 'value'=>'']) ?>
		<?= $this->Form->button(__('Sign in'), ['class'=>'btn btn-sm btn-success btn-flat m-b-30 m-t-30']) ?>
	</div>
	<?= $this->Form->end() ?>
    </div>
</div>
</div>

<?php
}
?>
</div><!-- end of row -->
