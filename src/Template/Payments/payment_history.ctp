<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row contractors">
<div class="col-lg-9">
<div class="card">
	<div class="card-header">
		<strong>Invoice</strong>
	</div>
	<div class="card-body card-block">


	<table class="table">
	<tr>
		<th scope="row"><?= __('Payment Created') ?></th>
		<th scope="row"><?= __('Payment Type') ?></th>
		<th scope="row"><?= __('Transaction Status') ?></th>
		<th scope="row"><?= __('Invoice') ?></th>
		<th scope="row"><?= __('Payment') ?></th>
		<th scope="row"><?= __('Balance') ?></th>
	</tr>

	<?php 
    foreach ($payments as $payment) {
    	if($payment->totalprice != 0){ ?>
	<tr>
		<td><?= h($payment->created) ?></td>
		<td><?php 
            if($payment->payment_type == 1) {
                echo 'Canqualify Register';
            }
            elseif($payment->payment_type == 2) {
                echo 'Renew Subscription';
            }
            elseif($payment->payment_type == 3) {
				/*$newClients = array();
				foreach($payment->payment_details as $pd) {					
					$newClients = array_unique(array_merge($newClients, $pd['client_ids']['c_ids']));
				}			
				$clientsArr = array();
				foreach($newClients as $cId) { //$clientsArr = $allClients[$cId]. ', '; 
					array_push($clientsArr, $allClients[$cId]);
				}
				$clients = implode(', ', $clientsArr);
                echo 'New Client Added <br/> <b>'. $clients.'</b>';*/
				echo 'New Client Added';
			}
            elseif($payment->payment_type == 4) { 
                echo 'New Service Added';
            }
            elseif($payment->payment_type == 5) { 
                echo 'New Employee slot Added';
            }
         ?>            
        </td>
        <td>
            <?php
            if(!empty($payment->transaction_status)){
                echo $payment->transaction_status;
            }
            ?>
        </td>
		<td>
            <?= $this->Html->link(h("#".$payment->id), ['controller'=>'Payments','action'=>'invoice', $payment->id], []) ?>
        </td>
		<td>
            <?= $this->Html->link(h("$ ".$payment->totalprice), ['controller'=>'Payments','action'=>'receipt', $payment->id], ['class'=>'ajaxmodal', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal']) ?>
        </td>
		<td>
            $ 0
        </td>
        <td><?= ($payment->is_refunded == 1) ? "<h4><span class='badge badge-warning'>Refunded</span></h4>" : "" ?></td>
    </tr>
	<?php }
	 } ?>

   <?php 
	if($renew_subscription) { ?>
		<tr>
		<td></td>
		<td>Renew Subscription</td>
        <td></td>
		<td>###</td>

		<td><?= h("$ ".$calculatePayment['final_price']) ?></td>
		<td>
          <?= h("$ ".$calculatePayment['final_price']) ?>
          <?= $this->Html->link('<em><i class="fa fa-dot-circle-o"></i></em> Pay Now', ['controller'=>'Payments','action'=>'checkout',1], ['class'=>'btn btn-success btn-sm pull-right', 'escape'=>false]) ?>
        </td>       
    </tr>
	<?php		
	}
	else {
    if($contractor->payment_status == 1) {
    foreach ($calculatePayment['services'] as $service) { 
	    if(!isset($service['price'])) { continue; }

		//
		$clientsArr = array();
        foreach($service['client_ids'] as $cId) { //$clientsArr = $allClients[$cId]. ', '; 
            array_push($clientsArr, $allClients[$cId]);
        }
        $clients = implode(', ', $clientsArr);
        
		$payMsg = '';
		if($calculatePayment['new_client']==true) {
			$payMsg = 'New Client Added <br /><b>'.$clients.'</b>';
		}
		elseif($calculatePayment['new_service']==true) {
			$payMsg = 'Service Upgrade <b>'. $service['name'] .'</b>';
			if(!empty($clients)){ $payMsg .= '<br /> For '.$clients; }
		}
	?>
	<tr>
		<td></td>
		<td><?= $payMsg; ?></td>
		<td>###</td>

		<td><?= h("$ ".$service['final_price']) ?></td>
		<td>
            <?= h("$ ".$service['final_price']) ?>
            <?= $this->Html->link('<em><i class="fa fa-dot-circle-o"></i></em> Pay Now', ['controller'=>'Payments','action'=>'checkout'], ['class'=>'btn btn-success btn-sm pull-right', 'escape'=>false]) ?>
        </td>       
    </tr>
    <?php 
	} 
	}
	}
	?>
	</table>
	</div>
</div>
</div>
<div class="col-lg-3">
<div class="card">
	<div class="card-header">
		<strong></strong>
	</div>
	<div class="card-body card-block">
    <ul class="list-group list-group-flush">
        <!--<li class="list-group-item">
            <?= $this->Html->link('<i class="fa fa-credit-card"></i> Manage Cards', ['controller'=>'billingDetails','action'=>'manageCards'], ['escape'=>false, 'title'=>__('Manage Cards'), 'class'=>'']) ?>
        </li>-->
        <li class="list-group-item">
        <?= $this->Html->link('<i class="fa fa-user"></i> My Subscription', ['controller'=>'ContractorServices','action'=>'subscription'], ['escape'=>false, 'title'=>__('My Subscription'), 'class'=>'']) ?>
        </li>
    </ul>
    </div>
</div>
</div>
</div>



<div class="modal fade" id="scrollmodal" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-title">Receipt</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="modal-body">
	</div>
</div>
</div>
</div>
