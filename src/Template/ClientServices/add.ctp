<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClientService $clientService
 */
?>
<div class="row ManageClient clientServices">
<div class="col-md-12">
<div class="card">
	<div class="card-header">
		<strong>Manage</strong> Client Services
	</div>
	<div class="card-body card-block">	
	    <?= $this->Form->create(null) ?>	
	    <div class="row form-group">
	    <?php $selectedClient = !empty($client) ? $client->id : reset($clients); ?>
		    <label class="col-sm-3">Select Client</label>
		    <div class="col-sm-6"><?= $this->Form->control('current_client_id', ['options'=>$clients, 'default'=>$selectedClient, 'required'=>true,'empty'=>false, 'label'=>false, 'class'=>'form-control']); ?></div>
		    <div class="col-sm-3"><?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type'=>'submit', 'class'=>'btn btn-primary btn-sm']) ?></div>
	    </div>
	    <?= $this->Form->end() ?>
	</div>
	<div class="card-body card-block">
	<!-- Client services section -->
	<?php if(!empty($client)) { ?>
	<div class="row">
	<div class="col-md-12">
		<?=  $this->Form->create($client, ['url'=> ['controller'=>'ClientServices','action'=>'add'], 'class'=>'clients_add']);?>
		<table class="table table-responsive">
		<tr>
			<th scope="col"><?= __('Service') ?></th>
			<th scope="col"><?= __('Is Safety Sensitive') ?></th>
			<th scope="col"><?= __('Is Safety Non-sensitive') ?></th>
			<th scope="col"><?= __('Discount') ?></th>
			<th scope="col" class="actions"><?= __('Is Percentage?') ?></th>
		</tr>
		<?php 
		$i =0;
		if(!empty($client->client_services)) {
		foreach ($client->client_services as $key=>$val){ ?>
		<tr>
			<td><?= $this->Form->checkbox('client_services.'.$i.'.service_id', ['value'=>$val->service_id]); ?><label><?= $val->service->name; ?></label></td>
			<td><?= $this->Form->checkbox('client_services.'.$i.'.is_safety_sensitive', ['label'=>false]); ?></td>
			<td><?= $this->Form->checkbox('client_services.'.$i.'.is_safety_nonsensitive', ['label'=>false]); ?></td>
			<td><?= $this->Form->control('client_services.'.$i.'.discount', ['class'=>'form-control', 'min'=>'0', 'label'=>false]); ?></td>
			<td><?= $this->Form->checkbox('client_services.'.$i.'.is_percentage', ['label'=>false]); ?>
			<?= $this->Form->control('client_services.'.$i.'.created_by', ['type'=>'hidden', 'value'=>$user_id]); ?>
			<?= $this->Form->control('client_id', ['type'=>'hidden', 'value'=>$client->id]) ?>
			<?= $this->Form->control('client_services.'.$i.'.id'); ?>
			</td>
		</tr>
		<?php 
		$i++; 
		}
		}
		foreach ($services as $key=>$val) {
		if(!in_array($key, $clids)) {
		?>
		<tr>		
			<td><?= $this->Form->checkbox('client_services.'.$i.'.service_id', ['value'=>$key]); ?><label><?= $val; ?></label></td>
			<td><?= $this->Form->checkbox('client_services.'.$i.'.is_safety_sensitive', ['label'=>false]); ?></td>
			<td><?= $this->Form->checkbox('client_services.'.$i.'.is_safety_nonsensitive', ['label'=>false]); ?></td>
			<td><?= $this->Form->control('client_services.'.$i.'.discount', ['class'=>'form-control', 'min'=>'0', 'label'=>false]); ?></td>
			<td><?= $this->Form->checkbox('client_services.'.$i.'.is_percentage', ['label'=>false]); ?>
			<?= $this->Form->control('client_services.'.$i.'.created_by', ['type'=>'hidden', 'value'=>$user_id]); ?>
			<?= $this->Form->control('client_id', ['type'=>'hidden', 'value'=>$client->id]) ?>
			
			</td>
		</tr>
		<?php
		}
		$i++;
		}
		?>
		</table>
		<br/><br/>

		<table class="table table-responsive">
		<tr><th>Please select Modules : </th></tr>
		<?php
		$i = 0;
		if(!empty($client->client_modules)) {		
		foreach ($client->client_modules as $key=>$val){ ?>
		<tr><td>
		<?= $this->Form->checkbox('client_modules.'.$i.'.module_id', ['value'=>$val->module_id]); ?><label><?= $val->module->name; ?></label>
		<?= $this->Form->control('client_modules.'.$i.'.created_by', ['type'=>'hidden', 'value'=>$user_id]); ?></td>
		<?= $this->Form->control('client_modules.'.$i.'.id', ['type'=>'hidden']); ?>
		</td></tr>
		<?php
		$i++;
		}
		}

		foreach($modules as $key=>$val) { 
		if(!in_array($key, $modclids)) {
		?>
		<tr>
		<td><?= $this->Form->checkbox('client_modules.'.$i.'.module_id', ['value'=>$key, 'label'=>false, 'required'=>false]);?><?= $val;?>
		<?= $this->Form->control('client_modules.'.$i.'.client_id', ['type'=>'hidden', 'value'=>$client->id]) ?>
		<?= $this->Form->control('client_modules.'.$i.'.created_by', ['type'=>'hidden', 'value'=>$user_id]); ?></td>
		</tr>
		<?php 
		}
		$i++;
		}
		?>
		</table>

		<div class="form-actions form-group">
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Save', ['type'=>'submit', 'class'=>'btn btn-success nextBtn']); ?>
		</div>		
		<?= $this->Form->end() ?>
	</div>
	</div><!-- .setup-content -->
    <?php } ?>
</div>
</div>
</div>
</div>