<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\IndustryAverage $industryAverage
 */
?>
<div class="row industryAverages">
<div class="col-lg-12">
<div class="card">
    <div class="card-header clearfix">
        <strong>Edit</strong> Industry Average
        <?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
        <span class="pull-right"><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $industryAverage->id], ['class'=>'btn btn-danger btn-sm', 'confirm' => __('Are you sure you want to delete # {0}?', $industryAverage->id)]) ?></span>
        <?php } ?>
    </div>
    <div class="card-body card-block">
    <?= $this->Form->create($industryAverage) ?>
        <div class="form-group">
            <?= $this->Form->label('Naisc Title', null, ['class'=>' col-form-label']); ?>
            <?php echo $this->Form->control('naisc_code_id', ['options' => $naiscCodes, 'empty' => true,'class'=>'form-control', 'required'=>false,'label'=>false]); ?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->control('total_recordable_cases', ['class'=>'form-control', 'required'=>false]); ?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->control('total', ['class'=>'form-control', 'required'=>false]); ?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->control('cases_with_days_away_from_work', ['class'=>'form-control', 'required'=>false]); ?>
        </div>
          <div class="form-group">
            <?php echo $this->Form->control('cases_with_days_of_job_transfer_or_restriction', ['class'=>'form-control', 'required'=>false]); ?>
        </div>
          <div class="form-group">
            <?php echo $this->Form->control('other_recordable_cases', ['class'=>'form-control', 'required'=>false]); ?>
        </div>
        <!--<div class="form-group">
            <?php echo $this->Form->control('industry_average', ['class'=>'form-control', 'required'=>false]); ?>
        </div>-->
         <div class="form-group">
            <?php echo $this->Form->control('year', ['class'=>'form-control', 'required'=>false]); ?>
        </div>
        <div class="form-actions form-group">
            <?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
        </div>
    <?= $this->Form->end() ?>   
    </div>
</div>
</div>
</div>