<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContractorDoc $contractorDoc
 */
?>
<div class="row contractorDocs">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong>Upload Document</strong>
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create($contractorDoc, ['type' => 'file', 'class'=>'saveAjax reloadpage', 'data-responce'=>'.modal-body']) ?>
		<div class="form-group uploadWraper">
			<?= $this->Form->label('Document', null, ['class'=>'col-form-label']); ?><br />
			<?php echo $this->Form->control('document', ['label'=>false, 'type'=>'hidden', 'class'=>'documentName']); ?>
			<?php echo $this->Form->file('uploadFile', ['label'=>false, 'accept' => '.images/*, .pdf,.xls, .xlsx, .doc']); ?>
			<div class="uploadResponse"></div>
		</div>
		<div class="form-actions form-group">			
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary']); ?>
		</div>
   	<?= $this->Form->end() ?>
	</div>
</div>
</div>
</div>
