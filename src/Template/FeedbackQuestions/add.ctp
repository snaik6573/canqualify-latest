<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FeedbackQuestion $feedbackQuestion
 */
?>
<div class="row FeedbackQuestion">
<div class="col-lg-8">
<div class="card">
    <div class="card-header">
        <strong>Add New</strong> Question
    </div>
    <div class="card-body card-block">
    <?= $this->Form->create($feedbackQuestion) ?>
        <div class="form-group">            
            <?= $this->Form->control('question', ['class'=>'form-control', 'required' => false]) ?>
        </div>        
        <div class="form-group">
            <?= $this->Form->control('question_options', ['class'=>'form-control']) ?>
        </div>        
        <div class="form-actions form-group">
            <?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']) ?>
            <?= $this->Form->button('<em><i class="fa fa-ban"></i></em> Reset', ['type' => 'reset', 'class'=>'btn btn-danger btn-sm']) ?>
        </div>
    <?= $this->Form->end() ?>
    </div>
</div>
</div>
</div>
