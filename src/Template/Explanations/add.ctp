<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Explanation $explanation
 */
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
$users = array(SUPER_ADMIN,CONTRACTOR,CONTRACTOR_ADMIN);
?>
<div class="row explanations">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong>Add Explanation</strong>
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create($explanation, array('type'=>'file')) ?>
		<div class="row appendDiv">
		<div class="col-lg-3">
			<div class="form-group">					
				<?php echo $this->Form->control('explanations.0.name', ['label'=>'Document Name','class'=>'form-control docName', 'required'=>'true']); ?>
			</div>
		</div>		
		<div class="col-lg-3">
			<div class="form-group uploadWraper">
			<?= $this->Form->label('Document', null, ['class'=>'col-form-label']); ?><br />
			<?php echo $this->Form->control('explanations.0.document', ['label'=>false, 'type'=>'hidden', 'class'=>'documentName']); ?>
			<?php echo $this->Form->file('explanations.0.uploadFile', ['label'=>false, 'accept'=>'.images/*, .pdf,.xls, .xlsx, .doc', 'required'=>'true']); ?>
			<div class="uploadResponse"></div>
			</div>
		</div>		
		
		<div class="col-lg-2">
			<div class="form-group">
			<?= $this->Form->label('Show To Client', null, ['class'=>'col-form-label']); ?><br />
				<?php echo $this->Form->control('explanations.0.show_to_client', ['label'=>false]); ?>
			</div>
		</div>
		
		
		<div class="col-lg-2">
			<?= $this->Form->button('<em><i class="fa fa-plus-square"></i></em> Add More', ['type'=>'button', 'class'=>'addUploadBox btn btn-success', 'style'=>'margin:30px 0 0 0;', 'data-fieldname'=>'explanations', 'data-showto'=>'show_to_client']); ?>
		</div>
		</div>
		<!--<div class="form-group">
			<?php //echo $this->Form->control('contractor_id', ['options' => $contractors, 'empty' => true]); ?>
		</div>-->
		<div class="form-actions form-group">			
		<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary']); ?>
		</div>
	<?= $this->Form->end() ?>
	</div>
</div>
</div>
<?php if(isset($explanations) && !empty($explanations)) { ?>
	<div class="col-lg-12">
	<div class="card">
	<div class="card-header"><strong>Explainations</strong></div>
	<div class="card-body">
	<table id="bootstrap-data-table" class="table table-striped table-bordered">
	<thead>
	<tr>
		<th scope="col"><?= $this->Paginator->sort('name') ?></th>
		<th scope="col"><?= $this->Paginator->sort('Document') ?></th>
		<th scope="col"><?= $this->Paginator->sort('Created') ?></th>
		<th scope="col"><?= $this->Paginator->sort('Show to Client') ?></th>
		<th scope="col" class="actions"><?= __('Actions') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($explanations as $explanation): ?>
	<tr>
		<td><?= h($explanation->name) ?></td>
		<td><a href="<?php echo $uploaded_path.$explanation->document;?>" target="_Blank"><?= $explanation->document ?></a></td>
		<td><?= h($explanation->created) ?></td>
		<td>
			<?= $this->Form->create($explanation) ?>
			<?php echo $this->Form->control('show_to_client', ['required'=>false, 'label'=>false, 'onclick'=>"this.form.submit();"]); ?>
			<?php echo $this->Form->control('id', ['type'=>'hidden', 'value'=>$explanation->id]); ?>
			<?= $this->Form->end() ?>
		</td>
		<td class="actions">
		<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $explanation->id],['escape'=>false, 'title' => 'View']) ?>
		<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $explanation->id],['escape'=>false, 'title' => 'Edit']) ?>
		<?php if (in_array($activeUser['role_id'], $users)) { ?>
		<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $explanation->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $explanation->id)]) ?>
		<?php } ?>
		</td>
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	</div>
	</div>
	</div>
	<?php } ?>
</div>
