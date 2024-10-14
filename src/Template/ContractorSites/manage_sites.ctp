<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Contractor $contractor
 */
$users = array(SUPER_ADMIN, ADMIN, CLIENT, CLIENT_ADMIN);
?>
<div class="row roles contractors">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong>Your </strong>  Clients and Sites
		<?php if(!empty($contractor_clients)) { ?>
		<span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller'=>'ContractorSites', 'action'=>'add'],['class'=>'btn btn-success btn-sm']) ?> </span>
		<?php } ?>
	</div>

	<div class="card-body card-block">
	<?php if (!empty($contractor->contractor_sites)): ?>
	<table id="bootstrap-data-table" class="table table-striped table-bordered">
	<thead>
	<tr>
		<th scope="col"><?= __('Client Name') ?></th>
		<th scope="col"><?= __('Region') ?></th>
		<th scope="col"><?= __('Site') ?></th>
		<th scope="col"><?= __('SHE Contact') ?></th>
		<th scope="col"><?= __('Facility Contact') ?></th>
        <?php if (in_array($activeUser['role_id'], $users)) { ?>
		<th scope="col" class="actions"><?= __('Actions') ?></th>
        <?php } ?>
	</tr>
	</thead>
	<tbody>
	<?php 
	foreach ($contractor->contractor_sites as $contractor_sites): 	
	if(!empty($contractor_sites->site)){
	?>
	<tr>
		<td><?= h($contractor_sites->site->client->company_name) ?></td>
		<td><?= $contractor_sites->site->has('region') ? h($contractor_sites->site->region->name) : '' ?></td>			
		<td><?= h($contractor_sites->site->name) ?></td>
		<td>
            <?php
                if(!empty($contractor_sites->site->she_fname)){echo $contractor_sites->site->she_fname.' ';}
                if(!empty($contractor_sites->site->she_lname)){echo $contractor_sites->site->she_lname;}
                if(!empty($contractor_sites->site->she_title)){echo '<br>'.$contractor_sites->site->she_title;}
                if(!empty($contractor_sites->site->she_phone)){echo '<br>Phone: '.$contractor_sites->site->she_phone;}
                if(!empty($contractor_sites->site->she_email)){echo '<br>Email: '.$contractor_sites->site->she_email;}
            ?>
        </td>
        <td>
            <?php
            if(!empty($contractor_sites->site->facility_fname)){echo $contractor_sites->site->facility_fname.' ';}
            if(!empty($contractor_sites->site->facility_lname)){echo $contractor_sites->site->facility_lname;}
            if(!empty($contractor_sites->site->facility_title)){echo '<br>'.$contractor_sites->site->facility_title;}
            if(!empty($contractor_sites->site->facility_phone)){echo '<br>Phone: '.$contractor_sites->site->facility_phone;}
            if(!empty($contractor_sites->site->facility_email)){echo '<br>Email: '.$contractor_sites->site->facility_email;}
            ?>
        </td>
        <?php if (in_array($activeUser['role_id'], $users)) { ?>
		<td class="actions">	 
		 	<?php $client_id = $contractor_sites->site->client->id;?>
		 	<?= $this->Form->create($contractor_sites, ['url' => ['action'=>'delete','type'=>'POST']]) ?> 
		    <?php echo $this->Form->control('id', ['type'=>'hidden','value' => $contractor_sites->id]); ?> 
   		    <?php echo $this->Form->control('client_id', ['type'=>'hidden','value' => $client_id]); ?> 
			<?= $this->Form->button('delete',['type' => 'submit', 'class'=>'siteDelete btn btn-success btn-danger btn-sm']); ?>	
			 <?= $this->Form->end() ?> 
		<?php } ?>
		</td>
	</tr>
	<?php  } endforeach; ?>
	</tbody>
	</table>
	<?php endif; ?>
	</div>
</div>
</div>
</div>
