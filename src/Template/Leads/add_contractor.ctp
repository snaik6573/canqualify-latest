<?php
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
?>
<div class="row leads">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong>Select Existing </strong> Contractor
	</div>
	<div class="card-body card-block">
       <?= $this->Form->create($lead,['class'=>"saveAjax", 'data-responce'=>'.modal-body']);?>
		<div class="form-group">
			<?= $this->Form->control('contractor_id', ['options'=>$contractorList, 'class'=>'form-control']); ?>
		</div>		
		<div class="form-actions form-group">		
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Save', ['type'=>'submit', 'class'=>'btn btn-primary btn-sm']); ?>
		</div>	
	<?= $this->Form->end() ?>
	</div>
</div>
</div>
</div>
