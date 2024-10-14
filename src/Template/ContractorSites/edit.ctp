<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContractorSite $contractorSite
 */
$users = array(SUPER_ADMIN, CONTRACTOR,CONTRACTOR_ADMIN);
?>
<div class="row contractorSites">
<div class="col-lg-6">
<div class="card">
	<div class="card-header clearfix">
		<strong>Edit</strong> Contractor Site
		<?php if (in_array($activeUser['role_id'], $users)) { ?>
		<span class="pull-right">
		<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $contractorSite->id], ['class'=>'btn btn-danger btn-sm', 'confirm' => __('Are you sure you want to delete # {0}?', $contractorSite->id)]) ?></span>
		<?php } ?>
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create($contractorSite) ?>
		<div class="form-group">
			<?php echo $this->Form->control('site_id', ['options' => $sites, 'class'=>'form-control', 'empty' => false]); ?>
		</div>
		<div class="form-actions form-group">
			<?php echo $this->Form->control('contractor_id', ['type'=>'hidden', 'value' => $contractor_id]); ?>
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
		</div>
	<?= $this->Form->end() ?>
	</div>
</div>
</div>
</div>
