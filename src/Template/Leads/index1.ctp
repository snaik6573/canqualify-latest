<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Module[]|\Cake\Collection\CollectionInterface $modules
 */
 $users = array(SUPER_ADMIN,ADMIN,CLIENT); 
?>
<div class="row leads">
<div class="col-lg-12">
<div class="card">
    <div class="card-header">
        <div class="col-lg-12">
      	  <strong class="card-title"><?= __('Leads Status') ?></strong>
	    </div>
    </div>
	<div class="card-body card-block pieChartBlock">
		<?php 
		if(!empty($leadsChart)) {
            $leadsChartData[] = array('Status', 'Number');
            
           for ($i=0; $i < count($leadsChart); $i++) { 
              $leadsChartData[] = array($leadsChart[$i]['status'], $leadsChart[$i]['leads_count']);
           }
		?>
		<script>
			var leadsChartData = <?php echo json_encode($leadsChartData) ?>;
		</script>
		<div id="pieChart" style="height: 450px;"></div>
		<div id="pieChartLabelOverlay">
		    <div>Leads</div><div>Status</div>		
		</div>
		<?php
		}
		?>
	</div>
</div>

<div class="leads-alert-wrap"></div>

<div class="card">
    <div class="card-header">
        <div class="col-lg-12">
        <strong class="card-title"><?= __('Leads') ?></strong>
		<span class="pull-right">
			<?= $this->Html->link(__('Add New Supplier'), ['controller' => 'Leads', 'action' => 'manuallyAdd'],['class'=>'btn btn-success btn-sm']) ?> 
			<?= $this->Html->link(__('Upload Suppliers'), ['controller' => 'Leads', 'action' => 'add'],['class'=>'btn btn-success btn-sm']) ?>

			<?= $this->Html->link(__('View All'), ['controller' => 'Leads', 'action' => 'index'],['class'=>'btn btn-success btn-sm']) ?>
			<?php if(in_array($activeUser['role_id'], $users)) { ?>
			<span class="pull-left"><?= $this->Html->link(__('Export to Excel'), ['controller' => 'leads', 'action' => 'index/0/excel',$client_id],['class'=>'mr-2']) ?> </span>
			<span class="pull-left"><?= $this->Html->link(__('Export to CSV'), ['controller' => 'leads', 'action' => 'index/0/csv',$client_id],['class'=>'mr-2']) ?> </span>
			<?php } ?>
			<!-- <?= $this->Html->link(__('Find Existing Contractors'), ['controller' => 'Leads', 'action' => 'index/1'],['class'=>'btn btn-success btn-sm']); ?> -->
		</span>
	</div>
	<div class="col-lg-6 mt-2">
		<?= $this->Form->create(null, ['class'=>'form-inline']) ?>
		<label for="client-id">Select Client : </label>
		<?= $this->Form->control('client_id', ['options'=>$clients,'empty'=>true,'class'=>'form-control', 'label'=>false, 'onChange'=>"this.form.submit();"]) ?>
		<?= $this->Form->end() ?>       
	</div>
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table" class="table table-striped table-bordered" data-order="[[ 1, &quot;asc&quot; ]]">
	<thead>
	<tr>
		<th scope="col"><?= h('Company Name') ?></th>                
		<th scope="col"><?= h('Leads Name') ?></th>                
		<th scope="col"><?= h('Phone No') ?></th>
		<th scope="col"><?= h('Email') ?></th>                
		<th scope="col"><?= h('Client') ?></th>   
		<th scope="col"><?= h('Emails Sent') ?></th>
		<th scope="col"><?= h('Phone Call Made') ?></th>       
		<th scope="col"><?= h('Status') ?></th>
		<th scope="col"><?= h('Date Added') ?></th>
		<?php if($foundlead == 1) { ?>
		<th scope="col"><?= h('Contractor Exist') ?></th>
		<?php } ?>
		<th scope="col"><?= h('Actions') ?></th>  
    </tr>
	</thead>
	<tbody>
	<?php foreach ($leads as $lead): ?>
	<tr class="<?= !empty($lead->updated_fields) ? implode(' ', $lead->updated_fields). ' hightlight_lead' : '' ?>">                
		<td class="company_name"><?= h($lead->company_name) ?></td>                
		<td class="contact_name_first contact_name_last"><?= h($lead->contact_name_first).' '.h($lead->contact_name_last) ?></td>         
		<td class="phone_no"><?= h($lead->phone_no) ?></td>
		<td class="email"><?= h($lead->email) ?></td>          
		<td><?= $lead->has('client') ? $this->Html->link($lead->client->company_name, ['controller' => 'Clients', 'action' => 'view', $lead->client->id]) : '' ?></td>
		<td><?= h($lead->email_count) ?></td>
		<td><?= h($lead->phone_count) ?></td>	
		<td class="status"><?= h($lead->lead_status->status) ?></td>
		<td><?= h($lead->created) ?></td>
		<?php if($foundlead == 1) { ?>
		<td><?= $lead->contractorExist ? 'true' : 'false'  ?></td>	
		<?php } ?> 
		<td>
		<?php if($activeUser['role_id'] == CR) { ?>        
			<?= $this->Html->link(__('Add'), ['controller' => 'LeadNotes','action'=>'CrLeadNote', $lead->id],['class'=>'btn btn btn-success', 'target'=>'_BLANK']) ; ?>
			</br>&emsp;
			<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $lead->id],['escape'=>false, 'title' => 'View']) ?>
			<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $lead->id],['escape'=>false, 'title' => 'Edit']) ?>
			<?php } else { ?>
			<?= $this->Html->link(__('Add'), ['controller' => 'LeadNotes','action'=>'add', $lead->id],['class'=>'btn btn btn-success', 'target'=>'_BLANK', 'escape'=>false, 'title' => 'Add Note']) ; ?>
			</br>&nbsp;        
			<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $lead->id],['escape'=>false, 'title' => 'View']) ?>
			<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $lead->id],['escape'=>false, 'title' => 'Edit']) ?>
			<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $lead->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete Lead # {0}?', $lead->id)]) ?>
		<?php } ?>
		</td>  
		<!--</td><?php 
		/*if($lead->status == 3 ) {					
			echo $this->Html->link(__('Send Request'), ['controller'=>'ClientRequests', 'action'=>'add', $lead->contractor_id,  $lead->client_id], ['class'=>'btn-link ajaxmodal', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal']);
		}else {  ?>
			<?= $this->Form->create($lead,['class'=>'saveAjax', 'data-responce'=>'.leads-alert-wrap']) ?>
			<?= $this->Form->control('lead_status_id', ['empty'=>false, 'options'=>$status, 'required'=>false, 'label'=>false, 'class'=>'updateLeadStatus', 'url'=>'/leads/addContractor/'.$lead->id]);?>
			<?= $this->Form->control('id', ['required'=>false, 'label'=>false, 'type'=>'hidden','value'=>$lead->id]);?>
			<?= $this->Form->end() ?>
			<?php 
		}*/
		?></td>-->	                 
	</tr>
	<?php endforeach; ?> 
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
		<h5 class="modal-title" id="scrollmodalLabel">Set Contractor </h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="modal-body">
	</div>
</div>
</div>
</div>