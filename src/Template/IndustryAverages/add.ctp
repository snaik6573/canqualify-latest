<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\IndustryAverage $industryAverage
 */
?>
<div class="row industryAverages">
<div class="col-lg-12">
<div class="card">
    <div class="card-header">
        <strong>Add </strong> Industry Average
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
        <!-- <div class="form-group">
            <?php echo $this->Form->control('industry_average', ['class'=>'form-control', 'required'=>false]); ?>
        </div>-->
         <div class="form-group">
            <?php echo $this->Form->control('year', ['class'=>'form-control', 'required'=>false]); ?>
        </div>      
        <div class="form-actions form-group">
            <?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
            <?= $this->Form->button('<em><i class="fa fa-ban"></i></em> Reset', ['type' => 'reset', 'class'=>'btn btn-danger btn-sm']); ?>
        </div>
    <?= $this->Form->end() ?>
    </div>
</div>
</div>
</div>
