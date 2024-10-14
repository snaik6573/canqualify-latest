<?php 
?>
<div class="row payments">
<div class="col-lg-12">
	<div class="card">
		<div class="card-header">
			<strong>Manage</strong>  Cards
		</div>
		    <div class="card-body table-responsive">
			<table id="bootstrap-data-table" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th scope="col"><?= h('id') ?></th>
						<th scope="col"><?= h('Card Type') ?></th>
						<th scope="col"><?= h('Card Number') ?></th>
						<th scope="col"><?= h('Card Month') ?></th>
						<th scope="col"><?= h('Card Year') ?></th>
						<th scope="col" class="actions"><?= __('Actions') ?></th>
					</tr>
				</thead>
			<tbody>
			<?php
			foreach ($card_details as $id => $card) { ?>
			<tr>
			<td><?= h($id) ?></td>
			<td><?= h($card['card_type']) ?></td>
			<td><?= h($card['card_number']) ?></td>
			<td><?= h($card['card_expiration_month']) ?></td>
			<td><?= h($card['card_expiration_year']) ?></td>
			<td class="actions">
			<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['controller'=>'BillingDetails','action' => 'edit', $id],['escape'=>false, 'title' => 'Edit']) ?>
	
			<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $id)]) ?>
			</td>
			</tr>
			<?php } ?>
			</tbody>
			</table>
		</div>
	</div>
</div>
</div>
