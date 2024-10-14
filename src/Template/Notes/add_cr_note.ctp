<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CustomerrNote $customerrNote
 */
?>
<div class="row notes" >
<div class="col-lg-12">
<div class="card">

	<!-- table -->
	
	<div class="card-body table-responsive" style="overflow-y: scroll; height: 250px;">
	<table id="" class="table table-striped table-bordered" data-order="[[ 2, &quot;desc&quot; ]]">
	<thead>
	<tr>
		<th scope="col"><?= h('Subject') ?></th>
		<th scope="col"><?= h('Notes') ?></th>
		<th scope="col"><?= h('Follow Up Date') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($notes as $n): ?>
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


<div class="row">
<div class="col-lg-12">
<div class="card">
	<!--  Form  -->
	<div class="card-header">
		<strong>Contractor : </strong><?= $contractor->company_name ?>
	</div>
	<div class="card-body card-block">

	<?= $this->Form->create($note,['type'=>'file']) ?>
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
		    <div class="col-sm-3">
				<?php echo $this->Form->control('show_to_contractor'); ?>
		    </div>
			<div class="col-sm-3">
				<?php echo $this->Form->control('show_to_client'); ?>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-2"></div>
			<div class="col-sm-3">
				<?php echo $this->Form->control('follow_up'); ?>
		    </div>
		    <div class="col-sm-4">
			<?= $this->Form->control('feature_date', ['type'=>'text', 'class'=>'form-control datetimepicker','label'=>false, 'placeholder'=>'Follow up date']) ?>
		    </div>
		    <div class="col-sm-3">
				<?php echo $this->Form->control('is_completed'); ?>
			</div>
		</div>
		<div class="form-actions form-group">			
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
			<?= $this->Form->button('<em><i class="fa fa-ban"></i></em> Reset', ['type' => 'reset', 'class'=>'btn btn-danger btn-sm']); ?>
		</div>
	<?= $this->Form->end() ?>
	</div>
</div>
</div>
</div>
