<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FormsNDoc $formsNDoc
 */
$this->assign('title', 'Form and Docs');
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
$users = array(SUPER_ADMIN,CLIENT,CLIENT_ADMIN,CLIENT_BASIC);
?>
<div class="row formsNDocs">
<?php if($activeUser['role_id'] != CLIENT_VIEW) { ?>
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong>Form and Docs</strong>
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create($formsNDoc, array('type' => 'file')) ?>
		<div class="row appendDiv">
		<div class="col-lg-3">
			<div class="form-group">
				<?php echo $this->Form->control('forms-n-docs.0.name', ['label'=>'Document Name','class'=>'form-control docName', 'required'=>'true']); ?>
			</div>
		</div>
		<div class="col-lg-3">
			<div class="form-group uploadWraper">
			<?= $this->Form->label('Document', null, ['class'=>'col-form-label']); ?><br />
			<?php echo $this->Form->control('forms-n-docs.0.document', ['label'=>false, 'type'=>'hidden', 'class'=>'documentName']); ?>
			<?php echo $this->Form->file('forms-n-docs.0.uploadFile', ['label'=>false, 'accept'=>'.images/*, .pdf,.xls, .xlsx, .doc', 'required'=>'true']); ?>
			<div class="uploadResponse"></div>
			</div>
		</div>
		<div class="col-lg-2">
			<div class="form-group">
			<?= $this->Form->label('Show To Contractor', null, ['class'=>'col-form-label']); ?><br />
				<?php echo $this->Form->control('forms-n-docs.0.show_to_contractor',['label' => false]); ?>
			</div>
		</div>
        <div class="col-lg-2">
            <div class="form-group">
                <?= $this->Form->label('Show To Employees', null, ['class'=>'col-form-label']); ?><br />
                <?php echo $this->Form->control('forms-n-docs.0.show_to_employees',['label' => false]); ?>
            </div>
        </div>
		<div class="col-lg-3">
			<?= $this->Form->button('<em><i class="fa fa-plus-square"></i></em> Add More', ['type' => 'button', 'class'=>'addUploadBox btn btn-success','style'=>'margin:30px 0 0 0;', 'data-fieldname'=>'forms-n-docs', 'data-showto'=>'show_to_contractor', 'data-showto-employees'=>'show_to_employees']); ?>
		</div>
		</div>
		<?php //echo $this->Form->control('forms-n-docs.0.client_id', ['type' => 'hidden', 'value'=> $client_id]); ?>
		<?php //echo $this->Form->control('forms-n-docs.0.created_by', ['type' => 'hidden', 'value'=> $userId]); ?>
		<div class="form-actions form-group">
		<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary']); ?>
		</div>
	<?= $this->Form->end() ?>
	</div>
</div>
</div>
<?php }?>

<?php if(isset($formsNDocs) && !empty($formsNDocs)){ ?>
	<div class="col-lg-12">
	<div class="card">
	<div class="card-header"></div>
	<div class="card-body">
	<table id="bootstrap-data-table" class="table table-striped table-bordered">
	<thead>
	<tr>
		<th scope="col"><?= $this->Paginator->sort('name') ?></th>
		<th scope="col"><?= $this->Paginator->sort('Document') ?></th>
        <?php if($activeUser['role_id'] != CLIENT_VIEW) { ?>
            <th scope="col"><?= $this->Paginator->sort('Show to contractor') ?></th>
        <?php }?>
        <?php if($activeUser['role_id'] != CLIENT_VIEW) { ?>
            <th scope="col"><?= $this->Paginator->sort('Show to employees') ?></th>
        <?php }?>
		<th scope="col"><?= $this->Paginator->sort('Created') ?></th>
		<th scope="col" class="actions"><?= __('Actions') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php
	foreach ($formsNDocs as $formsNDoc): ?>
	<tr>
		<td><?= h($formsNDoc->name) ?></td>
		<td><a href="<?php echo $uploaded_path.$formsNDoc->document;?>" target="_Blank"><?= $formsNDoc->document ?></a></td>
		<?php if($activeUser['role_id'] != CLIENT_VIEW) { ?>
		<td>
		<?= $this->Form->create($formsNDoc) ?>
		    <?= $this->Form->control('show_to_contractor', ['required'=>false, 'label'=>false, 'onclick'=>"this.form.submit();"]) ?>
			<?= $this->Form->control('id', ['type'=>'hidden', 'value'=>$formsNDoc->id]) ?>
		<?= $this->Form->end() ?>
		</td>
        <td>
            <?= $this->Form->create($formsNDoc) ?>
            <?= $this->Form->control('show_to_employees', ['required'=>false, 'label'=>false, 'onclick'=>"this.form.submit();"]) ?>
            <?= $this->Form->control('id', ['type'=>'hidden', 'value'=>$formsNDoc->id]) ?>
            <?= $this->Form->end() ?>
        </td>
		<?php }?>
		<td><?= h($formsNDoc->created) ?></td>
		<td class="actions">
		<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $formsNDoc->id],['escape'=>false, 'title' => 'View']) ?>
		<?php if (in_array($activeUser['role_id'], $users)) { ?>
		<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $formsNDoc->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $formsNDoc->id)]) ?>
		<?php }?>
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
