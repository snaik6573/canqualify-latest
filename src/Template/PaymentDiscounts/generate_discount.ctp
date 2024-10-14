<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PaymentDiscount $paymentDiscount
 */
//echo $this->Html->script('custom.js'); 
$discount = '';
$valid_date='';
$discount_id='';
if(!empty($updateDiscount)){
    $discount_id= $updateDiscount['id'];
    $discount= $updateDiscount['discount_price'];
    $valid_date =  date('Y/m/d', strtotime($updateDiscount['valid_date']));
}
?>
<div class="row PaymentDiscount">
<div class="col-lg-9">
<div class="card">
    <div class="card-header">
        <strong>Add</strong> Discount
    </div>
    <div class="card-body card-block">
    <?= $this->Form->create($paymentDiscount) ?>       
        <div class="form-group row">
        <?= $this->Form->label('Discount', null, ['class'=>'col-sm-3  col-form-label']); ?>
        <div class="col-sm-4"><?= $this->Form->control('discount_price', ['type'=>'text','class'=>'form-control', 'label'=>false, 'required'=>false,'value'=>$discount]); ?></div>
        </div>       
        <div class="form-group row" >
        <?= $this->Form->label('Valid Date', null, ['class'=>'col-sm-3  col-form-label']); ?>
        <div class="col-sm-4"><?= $this->Form->control('valid_date', ['type'=>'text','class'=>'setDate form-control','label'=>false, 'placeholder'=>'Valid Date','value'=>$valid_date]) ?>
        </div> </div> 
        <?= $this->Form->control('id', ['type'=>'hidden', 'value'=>$discount_id]) ?>      
        <div class="form-actions form-group">
            <?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
            <?= $this->Form->button('<em><i class="fa fa-ban"></i></em> Reset', ['type' => 'reset', 'class'=>'btn btn-danger btn-sm']); ?>
        </div>
    <?= $this->Form->end() ?>
    </div>
</div>
</div>
</div>
