<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$startDate = date('Y/m/d', strtotime($invoice['payment_start']));
$endDate = date('Y/m/d', strtotime($invoice['payment_end']));
?>
<div class="row invoice">
<div class="col-lg-12">	
<div class="card">
<div class="pull-right text-right no-print">
		<span style="display:inline:block;">
		<!--<?= $this->Html->link(__('Back To Dashboard'), ['controller'=>'Contractors', 'action'=>'dashboard', $contractor->id], ['escape'=>false, 'title'=>'dashboard', 'class'=>'nav-link btn btn-secondary mr-2']) ?>-->
		</span>
		<a href="#" onclick="window.print();" class="nav-link btn btn-success mr-2"  style="display:inline:block;"><i class="fa fa-print"></i> Print</a>		
		<span style="display:inline:block;"><?= $this->Html->link(__('<i class="fa fa-envelope"></i> Email'), ['controller'=>'payments', 'action'=>'invoice', $payment_id, 1], ['escape'=>false, 'title'=>'dashboard', 'class'=>'nav-link btn btn-success mr-2']) ?></span>				
	</div>		
	<div class="card-header clearfix">
        <div class="row">
           <div class="col-lg-8 print_show"> 
              <h1>INVOICE</h1>
                <div class="pull-left"><span>INVOICE NUMBER</span><br><p><?= $payment_id ?></p></div>
                <div class="pull-left ml-4"><span>DATE OF ISSUE</span><br><p><?= $invoice->created ?></p></div>                
            </div>
        <div class="col-lg-4 print_show">                
		        <?= $this->Html->image('logo.png', ['url'=>['controller'=>'Contractors', 'action'=>'dashboard'], 'class'=>'navbar-brand mb-3', 'alt'=>'CanQualify', 'width'=>'200px'])?>
        </div>
        </div>
         <div class="row mt-4">
                 <div class="col-lg-5 print_show">
                    <span>Billed to</span>
                    <p><?= h($contractor->company_name) ?></p>
                    <p><?= h($contractor->addressline_1) ?></p>
                    <p><?= h($contractor->addressline_2) ?></p>
                    <p><?= h($contractor->city).','.h($contractor->state['name']).','.h($contractor->country['name']) ?></p>
                    <p><?= h($contractor->zip) ?></p>
                 </div>
                 <div class="col-lg-5 print_show">
                   <span>CanQualify</span>
                   <p>3450 Triumph Blvd, STE-102, Lehi, UT 84043</p>
                   <p>Phone: (801) 851-1810</p>
                   <p>Email: info@CanQualify.com</p>
                </div>
        </div>		
	</div>
	<div class="card-body">				
	<table class="table invoice">
	<thead>
	<tr>
	<th scope="col">SERVICE</th>
	<th scope="col">QTY.</th>
    <th scope="col" class="text-right">UNIT PRICE</th>
    <th scope="col" class="text-right">DISCOUNT</th>
		<th scope="col" class="text-right">TOTAL
		<?php if($invoice->payment_type == 3 || $invoice->payment_type == 4||$invoice->reactivation_fee == LATE_FEE) { 
		    if(!empty($invoice['payment_start'])&& !empty($invoice['payment_end'])){
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
    foreach ($invoice->payment_details as $pdatails){     
        $totalDiscount = $totalDiscount + $pdatails->discount;
        $Subtotal = $Subtotal + $pdatails->product_price;
     ?>
		    <tr>		
			    <td><?= h($pdatails->service->name) ?></td>
			    <td><?= count($pdatails->client_ids['c_ids']) ?></td>			
				<td class="text-right"><?= $pdatails->product_price != null ? h("$ ".$pdatails->product_price) : '$ 0'; ?></td>
				<td class="text-right"><?= $pdatails->discount != null ? h("$ ".$pdatails->discount) : '$ 0'; ?></td>
			    <td class="text-right"><?= $pdatails->price != null ? h("$ ".$pdatails->price) : '$ 0'; ?></td>			
		    </tr>
		<?php } ?>
		<tr>
			<td colspan="4">INVOICE TOTAL :
            <br><h2><?= h("$".$invoice->totalprice); ?></h2>
            </td>
			<td class="text-right">
               <p>Subtotal: &nbsp; <?= h("$ ".$Subtotal); ?></p>
			   <?php if(!empty($invoice['reactivation_fee'])){ ?>
			   <p>Reactivation Fee :
				<?= '$ '.$invoice['reactivation_fee']; ?>
			   </p><?php }?>
			   <?php if(!empty($invoice['canqualify_discount'])) { ?>
    			<p>CanQualify Discount:&nbsp;<?= '$ '.$invoice['canqualify_discount']; ?></p> 
    			<?php $totalDiscount = $totalDiscount + $invoice['canqualify_discount']; } ?>
               <p>Total Discount: &nbsp;<?= h("$ ".$totalDiscount); ?></p>			 
               <p>(Tax Rate): &nbsp; 0%</p>
               <p>Tax: &nbsp; $ 0</p>
               <p>Total Price: &nbsp; <?= h("$ ".$invoice->totalprice); ?></p>
     		</td>
		</tr>
	</tbody>
	</table>
	</div>
    <div class="card-footer">
    <p class="pull-right">canqualify.com</p>
    </div>
</div>
</div>
</div>
