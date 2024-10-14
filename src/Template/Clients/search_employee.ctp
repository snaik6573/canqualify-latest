<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Client[]|\Cake\Collection\CollectionInterface $clients
 */
?>
<div class="row clients">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Search For New Employee') ?></strong>		
	</div>
	<div class="card-body">
	<?= $this->Form->create($employee, ['class'=> 'searchAjax1']) ?>
		<div class="row">
		<div class="col-lg-6">
			<div class="form-group">
			<?php echo $this->Form->control('contact_name', ['class'=>'form-control','label'=>'Contact Name', 'empty' => true, 'required' => false]); ?>	
			</div>	
		</div>	
		<div class="col-lg-6">
			<div class="form-group">
				<?php echo $this->Form->control('username', ['class'=>'form-control','label' => 'Email','required' => false]); ?>
			</div>	
		</div>	
		</div>
	
		<div class="row">	
		<div class="col-lg-4">
			<div class="form-group">
				<?php echo $this->Form->control('city', ['class'=>'form-control', 'required' => false]); ?>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="form-group">
				<?php echo $this->Form->control('state', ['options'=>$states, 'empty'=>true, 'class'=>'form-control', 'required' => false]); ?>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="form-group">
				<?php echo $this->Form->control('zip', ['empty'=>true, 'class'=>'form-control', 'required' => false]); ?>
			</div>
		</div>
		</div>
		
		<div class="form-actions form-group">			
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary pull-right']); ?>
		</div>
	<?= $this->Form->end() ?>		
	</div>

</div>
</div>
<div class="col-lg-12">
<div class="card">
	<div class="card-header">Search For New Employee</div>

	<div class="card-body table-responsive">
	<table id="bootstrap-data-table" class="table table-striped table-bordered">
	<thead>
	<tr>		
		<th scope="col"><?= h('Employee Name') ?></th>
		<th scope="col"><?= h('Email') ?></th>
		<th scope="col"><?= h('City') ?></th>
		<th scope="col"><?= h('State') ?></th>
		<th scope="col"><?= h('Zip') ?></th>
		<th scope="col"><?= h('Action') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php  foreach ($empList as $employee):  ?>

	<tr>		
		<!-- <td><?= h($employee['pri_contact_fn'].' '.$employee['pri_contact_ln']); ?></td> -->
		<td><?php echo $this->Html->link(__($employee['pri_contact_fn'].' '.$employee['pri_contact_ln']), ['controller'=>'Employees', 'action'=>'profile',$employee['id']], ['escape'=>false]);?></td>
		<td><?= h($employee['username']) ?></td>
		<td><?= h($employee['username']) ?></td>
		<td><?= h($employee['city']); ?></td>
		<td><?= h($employee['state_name']); ?></td>
		<td><?= h($employee['zip']); ?></td>
		</td>
		
		<td>
		<?php 
		// if(in_array($employee['id'], $contractor_emp))  {
		// 	   echo '<span class="">Already associated</span>';
		// }else 
		// {
		  if($employee['requeststatus'] == "")  {		  
			   echo $this->Html->link(__('Send Request'), ['controller'=>'ClientEmployeeRequests', 'action'=>'add',$employee['id']], ['class'=>'btn-link ajaxmodal', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal']);		  	
			} 
			else {
				echo '<span class="">Request Sent</span>';
			}
		//}
		?>
		</td>
	</tr>
	<?php endforeach;  ?>
 
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
		<h5 class="modal-title" id="scrollmodalLabel">Send Request to Employee</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="modal-body">
	</div>
</div>
</div>
</div>
