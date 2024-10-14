<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\NaicCode $naicCode
 */
?>
<div class="row naicCodes">
<div class="col-lg-6">
<div class="card">
    <div class="card-header clearfix">
        <strong>Edit</strong> NAIC Code
        <?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
        <span class="pull-right"><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $naicCode->id], ['class'=>'btn btn-danger btn-sm', 'confirm' => __('Are you sure you want to delete # {0}?', $naicCode->id)]) ?></span>
        <?php } ?>
    </div>
    <div class="card-body card-block">
    <?= $this->Form->create($naicCode) ?>
        <div class="form-group">
            <?php echo $this->Form->control('naic_code', ['class'=>'form-control']); ?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->control('title', ['class'=>'form-control']); ?>
        </div>
        <div class="form-actions form-group">
            <?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
        </div>
    <?= $this->Form->end() ?>
    </div>
</div>
</div>
</div>
