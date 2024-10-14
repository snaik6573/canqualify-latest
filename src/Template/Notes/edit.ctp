<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Note $note
 */
 $users = array(SUPER_ADMIN,ADMIN,CR);
?>
<div class="row notes">
<div class="col-lg-12">
<div class="card">
	<div class="card-header clearfix">
		<strong>Edit</strong> Note
		<?php /*if($note->created_by == $activeUser['id'] || $activeUser['role_id'] == SUPER_ADMIN) { ?>
		<span class="pull-right"><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $note->id], ['class'=>'btn btn-danger btn-sm', 'confirm' => __('Are you sure you want to delete # {0}?', $note->id)]) ?></span>
		<?php }*/ ?>
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create($note) ?>
		<div class="form-group row">
			<?= $this->Form->label('Subject', null, ['class'=>'col-sm-2 col-form-label']); ?>
            <div class="col-sm-10">
	    		<?php echo $this->Form->control('subject', ['class'=>'form-control','label'=>false]); ?>
            </div>
		</div>
		<div class="form-group row">
			<?= $this->Form->label('Notes', null, ['class'=>'col-sm-2 col-form-label']); ?>
            <div class="col-sm-10">
    			<?php echo $this->Form->control('notes', ['class'=>'form-control', 'id'=>'notes','label'=>false]); ?>
            </div>
		</div>
		<div class="form-group row">
			<div class="col-sm-2"></div>
		    <div class="col-sm-3">
				<?php echo $this->Form->control('show_to_contractor'); ?>
		    </div>
		    <?php if(in_array($activeUser['role_id'], $users)) { ?>
			<div class="col-sm-3">
				<?php echo $this->Form->control('show_to_client'); ?>
			</div>
			<?php } ?>
		</div>
		<div class="form-group row">
			<div class="col-sm-2"></div>
			<div class="col-sm-3">
				<?php echo $this->Form->control('follow_up'); ?>
		    </div>
		    <div class="col-sm-4">
			<?= $this->Form->control('feature_date', ['type'=>'text', 'class'=>'form-control datetimepicker','label'=>false, 'placeholder'=>'Follow up date']) ?>
		    </div>
		    <div class="col-sm-3">
				<?php echo $this->Form->control('is_completed'); ?>
			</div>
		</div>
		<div class="form-actions form-group">
			<?php echo $this->Form->control('refererUrl', ['type'=>'hidden', 'value'=>$refererUrl]); ?>
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
		</div>
	<?= $this->Form->end() ?>	
	</div>
</div>
</div>
</div>
