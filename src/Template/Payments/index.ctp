<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payment[]|\Cake\Collection\CollectionInterface $payments
 */
?>
<div class="row payments">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Payments') ?></strong>
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered" data-order="[[ 0, &quot;desc&quot; ]]">
	<thead>
	<tr>
		<th scope="col"><?= h('ID') ?></th>
		<th scope="col"><?= h('Contractor Name') ?></th>
		<th scope="col"><?= h('Paypal Transaction ID') ?></th>
		<th scope="col"><?= h('Total Price') ?></th>
		<th scope="col"><?= h('Transaction status') ?></th>	
		<th scope="col"><?= h('Short Error Message') ?></th>
		<th scope="col"><?= h('Long Error Message') ?></th>
		<th scope="col"><?= h('Refunded') ?></th>	
		<th scope="col"><?= h('Payment Type') ?></th>	
		<th scope="col"><?= h('Payment Date') ?></th>
		<!--<th scope="col" class="actions"><?= __('Actions') ?></th>-->
	</tr>
	</thead>
	<tbody>
	<?php foreach ($payments as $payment): 	?>
	<?php if($payment->totalprice != 0) { ?>
	<tr>
		<td><?= $this->Number->format($payment->id) ?></td>
		<td><?= $payment->has('contractor') ? $this->Html->link($payment->contractor->company_name, ['controller' => 'Contractors', 'action' => 'dashboard', $payment->contractor->id]) : '' ?></td>
		<td><?= h($payment->p_transactionid) ?></td>		
		<td><?= $this->Number->format($payment->totalprice) ?></td>
		<td><?= h($payment->transaction_status) ?></td>
		<td><?= h($payment->p_shortmessage0) ?></td>
		<td><?php  
			$string = $payment->p_longmessage0;
			if (strlen($string) > 20) {
			$trimstring = substr($string, 0,20).$this->Html->link(__('  Read More..'), ['controller'=>'Payments', 'action'=>'view',$payment->id], ['class'=>'ajaxmodal', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal', 'escape'=>false, 'title'=>'Payment']);
			} else {
			$trimstring = $string;
			}
			echo $trimstring;
			?>		
		</td>
		<td><?= $payment->is_refunded ? __('Yes') : __(''); ?></td>	
		<td><?= array_search($payment['payment_type'], $payment_types);?></td>			
		<td><?= date('Y/m/d', strtotime($payment->created))  ?></td>
		<!--<td class="actions">
		<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $payment->id],['escape'=>false, 'title' => 'View']) ?>
		<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $payment->id],['escape'=>false, 'title' => 'Edit']) ?>
		<?php if($activeUser['role_id'] != ADMIN) { ?>
		<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $payment->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $payment->id)]) ?>
		<?php } ?>
		</td>-->
	</tr>
	<?php } ?>
	<?php  endforeach; ?>
	</tbody>
	</table>
	</div>
</div>
</div>
</div>

<div class="modal fade" id="scrollmodal" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="scrollmodalLabel"></h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		</div>
		<div class="modal-body">
		</div>
	</div>
	</div>
</div>
