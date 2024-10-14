<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Module[]|\Cake\Collection\CollectionInterface $modules
 */
?>
<?php
require_once(ROOT . DS . 'vendor' . DS . "fusion-charts" . DS . "fusioncharts.php");
?>
<div class="row leads">
<div class="col-lg-12">
<div class="card">
    <div class="card-header clearfix">        
      	  <strong class="card-title"><?= __('Supplier Status') ?></strong>
          <div class="pull-right">
            <span>Implementaion Registration Status<span> | 
            <?= $this->Html->link(__('New Supplier Registration Status'), ['controller'=>'ClientRequests', 'action'=>'index'], ['title'=>'Requests and Status']) ?>
          </div>
	    </div>    
	<div class="card-body card-block pieChartBlock">        
		<div id="pieChart" ></div>
		<div id="pieChartLabelOverlay">
		    <div>Supplier</div><div>Status</div>		
		</div>
	</div>
</div>

<div class="card">
    <div class="card-header">
        <div class="col-lg-12">
        <strong class="card-title"><?= __('Supplier') ?></strong>
	    <span class="pull-right">
        <?= $this->Html->link(__('Add New Supplier'), ['controller' => 'Leads', 'action' => 'manuallyAdd'],['class'=>'btn btn-success btn-sm']) ?> 
		<?= $this->Html->link(__('Upload Suppliers'), ['controller' => 'Leads', 'action' => 'add'],['class'=>'btn btn-success btn-sm']) ?>
        <span class="pull-left"><?= $this->Html->link(__('Export to Excel'), ['controller' => 'leads', 'action' => 'index/0/excel',$client_id],['class'=>'mr-2']) ?>&nbsp;</span>
        <span class="pull-left"><?= $this->Html->link(__('Export to CSV'), ['controller' => 'leads', 'action' => 'index/0/csv',$client_id],['class'=>'mr-2']) ?>&nbsp;</span>
		<!--<?= $this->Html->link(__('View All'), ['controller' => 'Leads', 'action' => 'pendingLeads'],['class'=>'btn btn-success btn-sm']) ?>-->		
	    </span>
	</div>        
    </div>
    <div class="card-body table-responsive">
    <table id="bootstrap-data-table" class="table table-striped table-bordered" data-order="[[ 7, &quot;desc&quot; ]]">
    <thead>
    <tr>
                <th scope="col"><?= h('Company Name') ?></th>                
                <th scope="col"><?= h('Name') ?></th>                
                <th scope="col"><?= h('Phone No') ?></th>
                <th scope="col"><?= h('Email') ?></th> 
                <th scope="col"><?= h('Emails Sent') ?></th>
                <th scope="col"><?= h('Phone Call Made') ?></th>                
                <th scope="col"><?= h('Status') ?></th>
				<th scope="col"><?= h('Date Added') ?></th>
                <th scope="col"><?= h('Action') ?></th>                 
    </tr>
    </thead>
    <tbody>
    <?php 
   if(!empty($leads)){
    foreach ($leads as $lead): ?>
            <tr>                
                <td><?= h($lead->company_name) ?></td>                
                <td><?= h($lead->contact_name_first).' '.h($lead->contact_name_last) ?></td>           
                <td><?= h($lead->phone_no) ?></td>
                <td><?= h($lead->email) ?></td> 
                <td><?= h($lead->email_count) ?></td>
                <td><?= h($lead->phone_count) ?></td>              
				<td><?= h($lead->lead_status->status) ?></td>
				<td data-order="<?= !empty($lead->created) ? date('Ymd', strtotime($lead->created))  : '' ?>">
                    <?= !empty($lead->created) ? date('m/d/Y', strtotime($lead->created))  : '' ?><br/>
                </td>
				<td><!--
                    &ensp;<?= $this->Html->link(__('Add'), ['controller' => 'LeadNotes','action'=>'add', $lead->id],['class'=>'btn btn btn-success', 'target'=>'_BLANK']) ; ?>
                </br> -->  &emsp;             
                    <?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $lead->id],['escape'=>false, 'title' => 'View']) ?>
                    <?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $lead->id],['escape'=>false, 'title' => 'Edit']) ?>
                </td>                                
				</tr>
            <?php endforeach; } ?> 
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
<?php
/*supplier registration*/
$donutSupplierRegistration = new FusionCharts("doughnut2d", "supplier-registration", "100%", 400, "pieChart", "json", json_encode($supplierRegistrationChart) );
$donutSupplierRegistration->render();
?>

