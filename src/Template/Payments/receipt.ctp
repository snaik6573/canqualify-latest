<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$startDate = date('Y/m/d', strtotime($payment['payment_start']));
$endDate = date('Y/m/d', strtotime($payment['payment_end']));
?>
<div class="card">
	<div class="card-header clearfix">
		<strong>#<?= $payment->id ?></strong>		
	</div>
	<div class="card-body">
	<table class="table table-bordered invoice">
	<thead>
	<tr>
		<th scope="col">Service</th>
		<th scope="col">Qty.</th>
		<th scope="col" class="text-right">Unit Price</th>	
		<th scope="col" class="text-right">Discount</th>	
		<th scope="col" class="text-right">Total
		<?php if($payment->payment_type == 3 || $payment->payment_type == 4||$payment->reactivation_fee == LATE_FEE) { 
		    if(!empty($payment['payment_start'])&& !empty($payment['payment_end'])){
		?>
		 <p>Charges for the Period </br>( <?= h($startDate); ?> to <?= h($endDate); ?> )</p>
			<?php }} ?>
		</th>		
	</tr>
	</thead>
	<tbody>
		<?php 
		$totalDiscount = 0;
    	$Subtotal = 0;
		foreach ($payment->payment_details as $payment_details): 
		$totalDiscount = $totalDiscount + $payment_details->discount;
        $Subtotal = $Subtotal + $payment_details->product_price;
		?>
		<tr>		
			<td><?= h($payment_details->service->name) ?></td>
			<td><?= count($payment_details->client_ids['c_ids']) ?></td>			
			<td class="text-right"><?= $payment_details->product_price != null ? h("$ ".$payment_details->product_price) : '$ 0'; ?></td>
            <td class="text-right"><?= $payment_details->discount != null ? h("$ ".$payment_details->discount) : '$ 0'; ?></td>
			<td class="text-right"><?= $payment_details->price != null ? h("$ ".$payment_details->price) : '$ 0'; ?></td>	
		</tr>
		<?php endforeach; ?>
		<tr>
			<th colspan="4" class="text-right">Subtotal :</th>
			<td class="text-right"><?= h("$ ".$Subtotal); ?></td>
		</tr>
		<?php if(!empty($payment['reactivation_fee'])){ ?>
		<tr>
	        <th colspan="4" class="text-right">Reactivation Fee :</th>
			<td class="text-right"><?= '$ '.$payment['reactivation_fee']; ?></td>
	    </tr>
		<?php }?>
		<tr>
		<?php if(!empty($payment['canqualify_discount'])) { ?>
    		<th colspan="4" class="text-right">CanQualify Discount :</th>
    		<td class="text-right"><?= '$ '.$payment['canqualify_discount']; ?></td> 
    		<?php $totalDiscount = $totalDiscount + $payment['canqualify_discount']; } ?>
		</tr>
		<tr>
			<th colspan="4" class="text-right">Total Discount :</th>
			<td class="text-right"><?= h("$ ".$totalDiscount); ?></td>
		</tr>		
		<tr>
			<th colspan="4" class="text-right">Total Price:</th>
			<td class="text-right"><?= h("$ ".$payment->totalprice); ?></td>
		</tr>
	</tbody>
	</table>
	<!--<p><b>DocuQUAL</b> – A risk-based prequalification form that includes the annual collection & validation of safety stats and data such as incidence reports EMR certs, citation history, client policy documents and more.</p>-->
	</div>
</div>
