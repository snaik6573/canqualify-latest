<?php if(!isset($ajaxtrue)) {
	$selectedSlot = !empty($slot) ? $slot['slot'] : '';
?>
<div class="row">
<div class="col-lg-6">
	<div class="card">
		<div class="card-header">
		<strong>Add </strong> Slot
		</div>
	<div class="card-body card-block" style="min-height:250px;">
	<?= $this->Form->create(null,['class'=>'saveAjax']) ?>
    <div class="row form-group">
    <div class="col-lg-12">
		<br />
		<div class="alert alert-info">
	  	<span>You need to buy EmployeeQual service in batch of 5 employees. Price is $25.</span>
	</div>
	
		<label for="emp_slot">How many Employees you want to add  : </label>
	    <?= $this->Form->control('select slot', ['class'=>'emp_slot form-control', 'label'=>false, 'required'=>false, 'value' => $selectedSlot]); ?>
	</div>
	
	</div>

	<div class="form-group">
		<?= $this->Form->control('contractor_id', ['type'=>'hidden', 'value' => $contractor_id]) ?>	
		<?= $this->Html->link('Continue To Checkout', ['controller'=>'Payments', 'action'=>'slotPurchase'],['class'=>'btn btn-success btn-sm', 'escape'=>false]) ?>
	</div>
	
	<?= $this->Form->end() ?>
	</div>
	</div>
</div>

<!--  Invoice Card --->
<div class="col-lg-6 invoice-responce">
<?php } ?>

<div class="card">
	<div class="card-header clearfix">
		<strong>Invoice </strong>		
	</div>
	<div class="card-body">
	<table class="table table-bordered">
	<thead>
	<tr>
		<th scope="col">Employee Slot</th>
		<th scope="col">Pricing</th>
	</tr>
	</thead>
	<tbody>
		<?php if(!empty($slot)) { ?>
		<tr>
			<td><?= $slot['slot']; ?></td>
			<td>$ <?= $slot['price']; ?></td>
		</tr>
		<?php if(isset($slot['canqualify_discount'])) {
	    	$slot['price'] = $slot['price']-$slot['canqualify_discount']; ?>	    	 
	    <tr>
			<th>Canqualify Discount :</th>
			<td>$ <?= $slot['canqualify_discount']; ?> </td>
		</tr>	
		<?php }} ?>
		<tr>
			<th>Total :</th>
			<td><?= !empty($slot) ? '$ '. $slot['price'] : '' ?> </td>
		</tr>		
	</tbody>
	</table>
	</div>
</div>
</div>
<?php if(!isset($ajaxtrue)) { ?>
</div>
<?php 
}
?>
