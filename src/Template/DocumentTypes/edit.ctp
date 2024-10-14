<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DocumentType $documentType
 */
?>
<!-- <nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $documentType->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $documentType->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Document Types'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="documentTypes form large-9 medium-8 columns content">
    <?= $this->Form->create($documentType) ?>
    <fieldset>
        <legend><?= __('Edit Document Type') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('created_by');
            echo $this->Form->control('modified_by');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div> -->

<div class="row documentTypes">
<div class="col-lg-6">
<div class="card">
    <div class="card-header clearfix">
        <strong>Edit</strong> Document Type
        <?php if($activeUser['role_id'] != ADMIN) { ?>
        <span class="pull-right"><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $documentType->id], ['class'=>'btn btn-danger btn-sm', 'confirm' => __('Are you sure you want to delete # {0}?', $documentType->id)]) ?></span>
        <?php } ?>
    </div>
    <div class="card-body card-block">
    <?= $this->Form->create($documentType) ?>
        <div class="form-group">
            <?php echo $this->Form->control('name', ['class'=>'form-control', 'required'=>false]); ?>
        </div>
        <div class="form-actions form-group">
            <?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
        </div>
    <?= $this->Form->end() ?>
    </div>
</div>
</div>
</div>