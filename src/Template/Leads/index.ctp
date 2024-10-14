<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
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
			<!-- <?= $this->Html->link(__('Find Existing Contractors'), ['controller' => 'Leads', 'action' => 'index/1'],['class'=>'btn btn-success btn-sm']); ?>  -->
		</span> 
	</div>
	<div class="col-lg-6 mt-2">
		<?= $this->Form->create(null, ['class'=>'form-inline']) ?>
		<label for="client-id">Select Client : </label>
		<?= $this->Form->control('client_id', ['options'=>$clients,'empty'=>true,'class'=>'form-control', 'value'=>$client_id,'label'=>false, 'onChange'=>"this.form.submit();"]) ?>
		<?= $this->Form->end() ?>       
	</div>
	</div> 
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export1" class="table table-striped table-bordered data-table-ajax" data-order="[[ 1, &quot;asc&quot; ]]">
	<thead>
	<tr>
		<th scope="col"><?= h('Company Name') ?></th>
		<th scope="col"><?= h('Leads Name') ?></th>
		<th scope="col"><?= h('Phone No') ?></th>
		<th scope="col"><?= h('Email') ?></th>
		<th scope="col"><?= h('Client') ?></th>
		<th scope="col"><?= h('Location') ?></th>
		<th scope="col"><?= h('Emails Sent') ?></th>
		<th scope="col"><?= h('Phone Call Made') ?></th>
		<th scope="col"><?= h('Status') ?></th>
		<th scope="col"><?= h('Date Added') ?></th>
		<!-- <?php if($foundlead == 1) { ?>
		<th scope="col"><?= h('Contractor Exist') ?></th>
		<?php } ?>	 -->	 
		<th scope="col" class="actions" data-orderable="false"><?= __('Actions') ?></th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td colspan="9" class="dataTables_empty">Loading data from server...</td>
	</tr>
	</tbody>
   	</table>
	</div>
</div>
</div>
</div>

<script>
	var dtAjaxUrl = "<?= $this->request->getRequestTarget(); ?>";
	console.log(dtAjaxUrl);
</script>
