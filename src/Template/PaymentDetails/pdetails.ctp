<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row contractors">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong>Subscription</strong>
	</div>
	<div class="card-body card-block">


	<table class="table">
	<tr>
		<th scope="row"><?= __('Client') ?></th>
		<th scope="row"><?= __('Service') ?></th>
		<th scope="row"><?= __('Paid Amount') ?></th>
		<th scope="row"><?= __('created') ?></th>
	</tr>

	<?php
    if(!empty($paymentDetails)){
     foreach ($paymentDetails as $paymentDetail) { ?>
	<tr>
    <?php foreach($paymentDetail->client_ids['c_ids'] as $client_id){ ?>
        <td><?= $clients[$client_id] ?></td>
		<td><?= h($paymentDetail->service->name) ?></td>
		<td><?= h("$ ".$paymentDetail->price) ?></td>
		<td><?= h($paymentDetail->created) ?></td>		
	<?php } } }	?>
	</table>
	</div>
</div>
</div>
</div>
