<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CustomerRepresentative $customerRepresentative
 */
use Cake\Routing\Router;
$url = Router::Url(['controller' => 'payments', 'action' => 'checkout/1'], true);

$startDate =  date('Y/m/d');	
$endDate = date('Y/m/d', strtotime($contractor['subscription_date']));
if($endDate < $startDate) {	
	$subscription_date=strtotime($contractor['subscription_date']);
	$endDate = date('Y/m/d', strtotime('+ 1 year', $subscription_date));
}
$title = '';
if($invoice['reactivation_fee'] == 99) { 		    
			//$title = '<p>Charges for the Period &nbsp'.h($startDate).' to' .h($endDate).'</p>';
}
$lateFee = '';
 if(!empty($invoice['reactivation_fee'])){ 
	/*if($invoice['reactivation_fee']== 99){ $lateFee = 'Late Fee :';
		}elseif($invoice['reactivation_fee']== 199) { $lateFee ='Reactivation Fee :'; 	 } */
	$lateFee ='Reactivation Fee :';
	$lateFee .= '$ '.$invoice['reactivation_fee']; 			
}
?>
<?php 
$subject = 'CanQualify - Subscription Renewal Reminder';

$message = '<p>Dear '.$contractor->pri_contact_fn.' '.$contractor->pri_contact_ln.'</p>
 <p style="font-size: 18px;"><b>'.$contractor->company_name.'</b></p>
<p>We thank you for your continued relationship with Canqualify. It is a privilege to have you as our valued customer.</p>
<p>Your Subscription is going to expire on : <b>'.date('n/d/Y', strtotime($contractor->subscription_date)).'</b></p>
<p>Your Invoice Details are: </p>';
$message .= '<table class="table table-bordered"  border="1" style="border-collapse:collapse;margin:1px;">
	<thead>
	<tr>
		<th scope="col" style="text-align: center;padding:2px;">Service</th>
		<th scope="col" style="text-align: center;padding:2px;">Qty.</th> 
		<th scope="col" style="text-align: right;padding:2px;">Unit Price</th>
		<th scope="col" style="text-align: right;padding:2px;">Discount</th>
		<th scope="col" style="text-align: right;padding:2px;">Total '.$title.'</th>
	</tr>
	</thead>
	<tbody>';	
	$totalDiscount = 0;
	foreach ($invoice['services'] as $payment): 
	if(!isset($payment['price'])) { continue; }
	if(!isset($payment['discount'])) { $payment['discount']= 0; }
	if(!isset($payment['final_price'])) { $payment['final_price']= 0; }
	$totalDiscount = $totalDiscount + $payment['discount'];	

	$message .= '<tr>
			<td style="text-align: center;padding:2px;">'.$payment['name'].'</td>
			<td style="text-align: center;padding:2px;">'.count($payment['client_ids']).'</td>
			<td style="text-align: right;padding:2px;">'.h('$ '.$payment['price']).'</td>
			<td style="text-align: right;padding:2px;">'.h('$ '.$payment['discount']).'</td>
			<td style="text-align: right;padding:2px;">'.h('$ '.$payment['final_price']).'</td>
		</tr>';
	endforeach;
	$canqualify_discount='';
	 if(!empty($invoice['canqualify_discount'])) { 
	    			$canqualify_discount = 'CanQualify Discount : $ '.$invoice['canqualify_discount'];
	    			 $totalDiscount = $totalDiscount + $invoice['canqualify_discount']; } 
	$message .= '<tr>
			<td colspan="4" style="padding:3px;"><b>INVOICE TOTAL :
			'.h("$".$invoice['final_price']).'</b></td>
			<td style="text-align: right;padding-right:5px;">
               <p>Subtotal :'.h("$ ".$invoice['totalPrice']).'</p>
			   <p>'.$lateFee.'</p>
			   <p>'.$canqualify_discount.'</p>
               <p>Total Discount : '. h("$ ".$totalDiscount).'</p>
               <p>(Tax Rate):  0%</p>
               <p>Tax :$ 0</p>
               <p>Total Price :  '.h("$ ".$invoice['final_price']).'</p>
			</td>			
		</tr>';		
	$message .= '</tbody>
</table>
<p>Renew your subscription by clicking the button below.</p>
<p><a class="btn btn-renew" href="'.$url.'">Renew your subscription</a></p>
<p>Kindly ignore this email, if you have already renewed your subscription.</p>';

$message .= '<style>
table {
  border-collapse: collapse;
}

 td,th {
  border: 1px solid #999;
  padding: 0.5rem;
  text-align: left;
}
.btn.btn-renew
{
  background-color: #4CAF50;
  border: none;
  color: white;
  padding: 10px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 14px;
}
</style>';
?>

<div class="row customerRepresentative">
<div class="col-sm-12 alert-wrap">
	<?= $this->Flash->render() ?>
</div>
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong>Company Name :</strong> <?= $contractor->company_name; ?>
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create('', ['class'=>"saveAjax", 'data-responce'=>'.modal-body']) ?>
		<div class="form-group">
			<?php echo $this->Form->control('subject', ['class'=>'form-control','label' => 'Email Subject', 'value'=>$subject, 'required' => true]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->textarea('message', ['class'=>'form-control note', 'label'=>'Email Message', 'value'=>$message, 'required' => true]); ?>
		</div>
		<div class="form-actions form-group">
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
		</div>
	<?= $this->Form->end() ?>
	</div>
</div>
</div>
</div>
