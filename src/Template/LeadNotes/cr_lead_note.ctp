<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CustomerrNote $customerrNote
 */
$users = array(SUPER_ADMIN,ADMIN,CR);
$noteTypes = ['1'=>'Normal','2'=>'Follow Up','3'=>'Emails Sent','4'=>'Phone Call made','5'=>'Status'];
?>
<div class="row notes" >
<div class="col-lg-12">
<div class="card">	
	<div class="card-body table-responsive" style="overflow-y: scroll; height: 250px;">
	<table id="" class="table table-striped table-bordered" data-order="[[ 2, &quot;desc&quot; ]]">
	<thead>
	<tr>
		<th scope="col"><?= h('subject') ?></th>
		<th scope="col"><?= h('Notes') ?></th>
		<th scope="col"><?= h('Follow Up Date') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($leadNotes as $n): ?>
	<tr>
		<td><?= h($n->subject) ?></td>
		<td><?= strlen($n->notes) >= 200 ? '<div class="notes_short_cnt">'.strip_tags(substr($n->notes, 0, 190)) . ' <a href="#" class="read_more">more >></a></div> <div class="notes_cnt" style="display:none;">'.$n->notes.'  <a href="#" class="read_less"> << less</a></div>' : $n->notes; ?></td>
        <td><?= h($n->feature_date) ?></td>
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	</div>

</div>
</div>
</div>


<div class="row notes">
<div class="col-lg-12">
<div class="card">
	<!--  Form  -->
	<div class="card-header">
		<strong>Contractor : </strong><?= $lead->company_name ?>
	</div>
	<div class="card-body card-block">

	<?= $this->Form->create($leadNote) ?>
        
		<div class="form-group row">
			<?= $this->Form->label('Subject', null, ['class'=>'col-sm-2 col-form-label']); ?>
            <div class="col-sm-10">
	    		<?php echo $this->Form->control('subject', ['class'=>'form-control','label'=>false]); ?>
            </div>
		</div>        
		<div class="form-group row">
			<?= $this->Form->label('Notes', null, ['class'=>'col-sm-2 col-form-label']); ?>
            <div class="col-sm-10">
    			<?php echo $this->Form->control('notes', ['class'=>'form-control', 'id'=>'notes','label'=>false]); ?>
            </div>
		</div>       	
        <div class="form-group row">          
	        <div class="col-sm-2"></div>
	        <?php if(in_array($activeUser['role_id'], $users)) { ?>
            <div class="col-sm-2">
				    <?php echo $this->Form->control('show_to_client'); ?>
		    </div> 
            <?php } ?>
		    <?= $this->Form->label('Note Type :'); ?>
		    <div class="col-sm-3"><?= $this->Form->control('note_type', ['options'=>$noteTypes,'id'=>'noteTypeSelection', 'empty'=>false, 'class'=>'form-control noteTypeSelection', 'label'=>false]); ?></div>       
	        <div>
	        <div class="col-sm-10 Follow_up" style='display:none;'><?= $this->Form->control('feature_date', ['type'=>'text', 'class'=>'form-control datetimepicker','label'=>false, 'placeholder'=>'Follow up date']) ?> </div> 
	        <div class="col-sm-2 Follow_up" style='display:none;'><?php echo $this->Form->control('is_completed',['type'=>'checkbox']); ?></div>       
	        <div class="status " style='display:none;'>        
	        <?= $this->Form->control('lead_status_id', ['options'=>$status,'default'=>$lead['lead_status_id'],'id'=>'statusSelection','class'=>'statusSelection','empty'=>false,'required'=>false, 'label'=>false]);?>
	        </div>   
	        </div> 
        </div>
        <div class="form-group row">
	        <div class="col-sm-2"></div>
	        <div class="col-sm-10 contSelect" style='display:none;'>            
	            <label class="col-sm-4  ">Select Existing Contractor:</label>
				<?= $this->Form->control('contractor_id', ['options'=>$contractorList,'default'=>$lead->contractor_id,'empty'=>true,'label'=>false,'class'=>'form-control col-sm-6']); ?>
			</div> 
        </div>                          
      
		<div class="form-actions form-group">
			<!--<?php echo $this->Form->control('refererUrl', ['type'=>'hidden', 'value'=>$refererUrl]); ?>-->
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
			<?= $this->Form->button('<em><i class="fa fa-ban"></i></em> Reset', ['type' => 'reset', 'class'=>'btn btn-danger btn-sm']); ?>
		</div>
</div>
</div>
</div>
