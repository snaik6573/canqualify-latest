<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContractorClient $contractorClient
 */
$startDate =  date('Y/m/d');    
$endDate = date('Y/m/d', strtotime($contractor['subscription_date']));
?>
<?php if(!isset($ajaxtrue)) {  ?>
<div class="row contractorClient">
<div class="col-lg-6">
<div class="card">
    <div class="card-header">
        <strong>Add </strong> Clients
    </div>
    <div class="card-body card-block contractorClient" style="min-height:250px;">

    <?= $this->Form->create(null,['class'=>'saveAjax', 'data-responce'=>'.invoice-responce']) ?>

    <div class="row form-group">    
    <div class="col-lg-12">
    <select multiple="multiple" class="form-control clientAddchk" name="client_id[]">
    <?php 
        foreach($clientSelection as $key=>$val) {
            foreach($val as $ky=>$vl){
                $selected = '';
                if(in_array($ky, $tempClient)) {$selected = 'selected="selected"';}
                echo '<option value="'.$ky.'" '.$selected.'>'.$vl.'</option>';
            }
        }
    ?>
    </select>
    </div>      
    </div>

    <div class="form-actions form-group">
        <?= $this->Form->control('contractor_id', ['type'=>'hidden', 'value' => $contractor_id]) ?> 
        <?= $this->Html->link('Continue To Checkout', ['controller'=>'Payments', 'action'=>'checkout'],['class'=>'btn btn-success btn-sm', 'escape'=>false]) ?>
        <?php if(count($clients) < 1) { ?>
        <?= $this->Html->link('Skip', ['controller'=>'Payments', 'action'=>'checkout'],['class'=>'btn btn-success btn-sm', 'escape'=>false]) ?>
        <?php }?>
    </div>
    
    <?= $this->Form->end() ?>
    </div>
</div>
</div>

<div class="col-lg-6 invoice-responce">
<?php } 
// else {
//if(!empty($paymentInfo['services'])) { ?>
<div class="card">
    <div class="card-header clearfix">
        <strong>Invoice </strong>       
    </div>
    <div class="card-body">
    <table class="table table-bordered invoice">
    <thead>
    <tr>
        <th scope="col">Service</th>
        <th scope="col">Qty.</th>
        <th scope="col">Unit Price</th>
        <th scope="col">Discount</th>
        <th scope="col">Total       
        <?php if(($endDate > $startDate) && ($paymentInfo['new_client']||$paymentInfo['new_service']) && count($clients) > 1){?>
        <p>Charges for the Period </br>( <?= h($startDate); ?> to <?= h($endDate); ?> )</p>
        <?php } ?>      
        </th>
    </tr>
    </thead>
    <tbody>
    <?php
    $totalDiscount = 0; 
    foreach ($paymentInfo['services'] as $payment):    
        if(!isset($payment['price'])) { continue; }
        $totalDiscount = $totalDiscount + $payment['discount'];
    ?>
    <tr>
        <td><?= $payment['name']; ?>
            <?= isset($payment['slot']) ? '<br/ ><b>Slot : </b>'.$payment['slot'] : '' ; ?>
        </td>
        <td><?= count($payment['client_ids']); ?></td>
        <td><?= $payment['price'] !=null ? h('$ '.$payment['price']) : '$ 0'; ?></td>
        <td><?= $payment['discount'] !=null ? h('$ '.$payment['discount']) : '$ 0'; ?></td>
        <td><?= $payment['final_price'] !=null ? h('$ '.$payment['final_price']) : '$ 0'; ?></td>  
    </tr>
    <?php endforeach; ?>
    <tr>
        <th colspan="4">Subtotal :</th>
        <td><?= '$ '.$paymentInfo['totalPrice']; ?></td>
    </tr>
    <?php if(!empty($paymentInfo['canqualify_discount'])) { ?>
    <tr>
        <th colspan="4">CanQualify Discount  :</th>
        <td><?= '$ '.$paymentInfo['canqualify_discount']; ?></td>
    </tr>
    <?php $totalDiscount = $totalDiscount + $paymentInfo['canqualify_discount'];?>
    <?php } ?>
    <tr>        
        <th colspan="4">Total Discount  :</th>        
        <td><?= '$ '.$totalDiscount; ?></td>
    </tr>
    <tr>
        <th colspan="4">Total Price  :</th>
        <td><?= '$ '.$paymentInfo['final_price']; ?></td>
    </tr>
    </tbody>
    </table>
    </div>
</div><!-- .card -->
<?php //} ?>
<?php if(!isset($ajaxtrue)) { ?>
</div><!-- .invoice-responce -->

<div class="col-lg-12">
<div class="card">
    <div class="card-header">
        <strong>Associated </strong> Clients
    </div>
    <div class="card-body card-block">
    <?php if (!empty($contractorClients)): ?>
    <table id="bootstrap-data-table" class="table table-striped table-bordered">
    <thead>
    <tr>
        <!-- <th scope="col"><?= __('Contractor') ?></th> -->
        <th scope="col"><?= __('Client Company Name') ?></th>
    </tr>
    </thead>
    <tbody>
    <?php   
    foreach ($contractorClients as $contClients):   

    if(!empty($contClients)){
    ?>
    <tr>
        <!-- <td><?= h($contClients->contractor['company_name']) ?></td> -->
        <td><?= h($contClients->client['company_name']) ?></td> 
    </tr>
    <?php  } endforeach; ?>
    </tbody>
    </table>
    <?php endif; ?>
    </div>
</div>
</div>

</div><!-- .contractorClients -->
<?php } ?>