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
		<strong class="card-title"><?= __('Search For New Contractor') ?></strong>		
	</div>
	<div class="card-body">
	<?= $this->Form->create($contractor, ['class'=> 'searchAjax1']) ?>
		<div class="row">
		<div class="col-lg-6">
			<div class="form-group">
			<?php echo $this->Form->control('contact_name', ['class'=>'form-control','label'=>'Contact Name', 'empty' => true, 'required' => false]); ?>
			<!-- <?php echo $this->Form->control('contact_name', ['options'=>$customersByname, 'class'=>'form-control','label'=>'Contact Name', 'empty' => true, 'required' => false]); ?> -->
			</div>	
		</div>
		<div class="col-lg-6">
			<div class="form-group">
			<?php echo $this->Form->control('company_name', ['class'=>'form-control','label'=>'Company Name', 'empty' => true, 'required' => false]); ?>
			<script>
				var customersByCname = `<?php echo json_encode(array_values($customersByCname)) ?>`;
			</script>
			</div>
		</div>
		</div>
	
		<div class="row">
		<div class="col-lg-6">
			<div class="form-group">
				<?php echo $this->Form->control('username', ['class'=>'form-control','label' => 'Email','required' => false]); ?>
			</div>	
		</div>
		<div class="col-lg-6">
			<div class="form-group">
				<?php echo $this->Form->control('city', ['class'=>'form-control', 'required' => false]); ?>
			</div>
		</div>
		</div>
		
		<div class="row">
		<div class="col-lg-3">
			<div class="form-group">
				<?php echo $this->Form->control('state', ['options'=>$states, 'empty'=>true, 'class'=>'form-control', 'required' => false]); ?>
			</div>
		</div>
		<div class="col-lg-3">
			<div class="form-group">
				<?php echo $this->Form->control('zip', ['empty'=>true, 'class'=>'form-control', 'required' => false]); ?>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="form-group">
				<?php echo $this->Form->label('Industry Type / NAICS code', null, ['class'=>'']); ?>
				<?php echo $this->Form->control('naics_codes', ['options'=>$naisccodes, 'empty'=>false, 'class'=>'form-control searchSelect', 'multiple'=>true, 'required' => false, 'label'=>false]); ?>
				<script>
				//var industrytype = <?php echo json_encode(array_values($industrytype)) ?>;
			</script>
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
	<div class="card-header">Search For New Contractor</div>

	<div class="card-body table-responsive">
	<table id="bootstrap-data-table" class="table table-striped table-bordered">
	<thead>
	<tr>
		
		<!-- <th scope="col"><?= h('Company Name') ?></th> -->
		<th scope="col"><?= h('Contractor Name') ?></th>
		<th scope="col"><?= h('Profile') ?></th>
		<th scope="col"><?= h('Primary Contact') ?></th>
		<!--<th scope="col"><?= h('Email') ?></th>-->
		<th scope="col"><?= h('City') ?></th>
		<th scope="col"><?= h('State') ?></th>
		<th scope="col"><?= h('Zip') ?></th>
		<th scope="col"><?= h('NAICS Code') ?></th>
		<!--<th scope="col"><?= h('Safety') ?></th>-->
		<th scope="col"><?= h('Action') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php  foreach ($contList as $contractor): 
		if(!isset($contractor['naics_code'])){
		$naics_code = $this->User->getNaicsCode($contractor['id']);
	    isset($naics_code['naisc_code']) ? $contractor['naics_code'] = $naics_code['naisc_code'] : '';}	
	 ?>

	<tr>
        <td>
            <?php
            if(!empty($isClientUser) && $isClientUser == true){
                if(in_array($contractor['id'], $clientUserContractors))  {
                    echo $this->Html->link($contractor['company_name'], ['controller' => 'Contractors', 'action' => 'dashboard', $contractor['id']]);
                }else
                {
                    echo $contractor['company_name'];
                }
            }
            else{
                if(in_array($contractor['id'], $client_contractors))  {
                    echo $this->Html->link($contractor['company_name'], ['controller' => 'Contractors', 'action' => 'dashboard', $contractor['id']]);
                }else
                {
                    echo $contractor['company_name'];
                }
            }
        ?>
        </td>
        <td><?php echo $this->Html->link('View', ['controller'=>'Contractors', 'action'=>'profile',$contractor['id']], ['escape'=>false]);?></td>
        <!-- <td><?= $contractor['company_name'] ?></td> -->
		<td><?= h($contractor['pri_contact_fn'].' '.$contractor['pri_contact_ln']); ?></td>
		<!--<td><?= h($contractor['username']) ?></td>-->
		<!-- <td><?= h($contractor['pri_contact_pn']); ?></td> -->
		<td><?= h($contractor['city']); ?></td>
		<td><?= h($contractor['state_name']); ?></td>
		<td><?= h($contractor['zip']); ?></td>
		<td><?= isset($contractor['naics_code']) ? h($contractor['naics_code']): ''; ?></td>
		<!--<td class="text-center"><?= $this->Html->link(__('<i class="fa fa-eye"></i>'), ['controller'=>'ContractorAnswers', 'action'=>'safety_report/', 0, $contractor['id']], ['class'=>'ajaxmodal', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal', 'escape'=>false, 'title'=>'Safety Report']) ?></td>-->
		<td>
		<?php if(in_array($contractor['id'], $client_contractors))  {
			   echo '<span class="">Already associated</span>';
		}else 
		{
		  if($contractor['requeststatus'] == "")  {
			   echo $this->Html->link(__('Send Request'), ['controller'=>'ClientRequests', 'action'=>'add',$contractor['id']], ['class'=>'btn-link ajaxmodal', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal']);
			} 
			else {
				echo '<span class="">Request Sent</span>';
			}
		}
		?>
		</td>
	</tr>
	<?php endforeach;  ?>
 
 
	<?php  foreach ($leads as $lead): ?>
	<tr>
		<!--<td><?= $this->Html->link($contractor['company_name'], ['controller' => 'Contractors', 'action' => 'dashboard', $contractor['id']]) ?></td>-->
		<td><?= $lead['company_name'] ?></td>
		<td></td>
		<td><?= h($lead['contact_name_first'].' '.$lead['contact_name_last']); ?></td>
		<!-- <td><?= h($lead['phone_no']) ?></td> -->
		<td><?= h($lead['city']); ?></td>
		<td><?= h($lead['state']); ?></td>
		<td><?= h($lead['zip_code']); ?></td>
		<td></td>
		<!--<td class="text-center"><?= $this->Html->link(__('<i class="fa fa-eye"></i>'), ['controller'=>'ContractorAnswers', 'action'=>'safety_report/', 0, $contractor['id']], ['class'=>'ajaxmodal', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal', 'escape'=>false, 'title'=>'Safety Report']) ?></td>-->
		<td>
		<?php if($lead['requeststatus'] == "")  {
			echo $this->Html->link(__('Send Request'), ['controller'=>'ClientRequests', 'action'=>'addadmin',$lead['id']], ['class'=>'btn-link ajaxmodal', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal']);
		} 
		else {
			echo '<span class="">Request Sent</span>';
		}
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
		<h5 class="modal-title" id="scrollmodalLabel">Send Request to Contractor</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="modal-body">
	</div>
</div>
</div>
</div>
