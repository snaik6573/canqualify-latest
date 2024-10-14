<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BillingDetail $billingDetail
 */
?>
<div class="row card-manage">
<div class="col-lg-8">
<div class="card">
    <div class="card-header clearfix">
        <strong>Edit</strong> Cards Detail
        <?php $card = $billingDetail['card_details']; ?>
        
        <span class="pull-right"><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $billingDetail->id], ['class'=>'btn btn-danger btn-sm', 'confirm' => __('Are you sure you want to delete # {0}?', $billingDetail->id)]) ?></span>
       
    </div>
    <div class="card-body card-block">
    <?= $this->Form->create() ?>
            <div class="form-group">
                    <?= $this->Form->control('ccname', ['class'=>'form-control','label'=>'Name on Card','required' => false,'value'=>$card['name_on_card']]); ?>
            </div>
            <div class="form-group">
                <?php echo $this->Form->control('cctype', ['class'=>'form-control','label'=>'Credit Card Type', 'required'=>false,'value'=>$card['card_type']]); ?>
            </div>
       
           <div class="form-group">
            <?= $this->Form->control('ccnumber', ['class'=>'form-control','label'=>'Credit Card Number' ,'required' => false,'value'=>$card['card_number']]); ?>
           </div>
            <div class="form-group">
               <label for="cc-expiration">Expiration Month</label>
               <?= $this->Form->month('ccexpirationmonth', array('class'=>'form-control', 'empty'=>'Please select month','required' => false,'value'=>$card['card_expiration_month'])); ?>
            </div>
            <div class="form-group">
                <label for="ccexpirationyear">Expiration Year</label>
                <?= $this->Form->year('ccexpirationyear', array('class'=>'form-control', 'empty'=>'Please select year','required' => false,'value'=>$card['card_expiration_year'] , 'minYear'=>date('Y'), 'maxYear'=>date('Y')+20));?>
            </div>
        
            <div class="form-actions form-group">
                <?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
            </div>
            <?= $this->Form->end() ?>  

            
    </div>
</div>
</div>
</div>
