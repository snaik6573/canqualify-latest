<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OverallIcon $overallIcon
 */
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
$userId = $this->getRequest()->getSession()->read('Auth.User.id');
$fileCss = $overallIcon->documents!='' ? "display:none;" : "";
?>
<div class="row overallIcons">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong>Edit Icon For CanQualify Client: <?= $client->has('company_name') ? $client->company_name : ''; ?></strong>
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create($overallIcon, ['type'=>'file', 'class'=>"saveAjax reloadpage", 'data-responce'=>'.modal-body']) ?>
    <?php $i=0; 
    if(!empty($overallIcon->icons)) {
    foreach($overallIcon->icons as $icn) { //pr($icn); ?>
    <div class="row form-group">
			<label class="col-sm-3">Update <?= $icn->bench_type ?> Status</label>
			<div class="col-sm-4">
			<?= $this->Form->control('icons.'.$i.'.icon', ['options'=>$icons, 'type'=>'radio', 'required'=>true, 'label'=>false]); ?>
			</div>
			<?php if($overallIcon->review!=0 && !empty($categories)) ?>
			<div class="col-sm-3">
			<?php echo $this->Form->control('icons.'.$i.'.category', ['options'=>$categories,'value'=>$icn->category, 'empty'=>[''=>'Select Category'], 'class'=>'form-control', 'label'=>false]); ?>
			</div>
			<?php } ?>				
            <?php echo $this->Form->control('icons.'.$i.'.id', ['type'=>'hidden']); ?> 
            <?php echo $this->Form->control('icons.'.$i.'.modified_by', ['value'=>$userId,'type'=>'hidden']); ?>             
       </div>
       <?php
		$i++;
		}
    }
	?>

	<div class="row form-group">
		<?= $this->Form->label('Document', null, ['class'=>'col-sm-3']); ?><br />
		<div class="col-sm-9 uploadWraper">
		<?php echo $this->Form->control('documents', ['label'=>false,'type'=>'hidden', 'class'=>'documentName']); ?>
		<?php echo $this->Form->file('uploadFile', ['label'=>false, 'accept' => '.images/*, .pdf,.xls, .xlsx', 'style'=> $fileCss]); ?>
		<div class="uploadResponse">
        <?php if($overallIcon->documents!='') { ?>
        <a href="<?= $uploaded_path.$overallIcon->documents ?>" class="uploadUrl" data-file="<?=$overallIcon->documents ?>" target="_Blank"><?= $overallIcon->documents ?></a>
        <?= $this->Html->link('<i class="fa fa-times-circle"></i>', ['controller'=>'Uploads', 'action' => 'deleteFile', $overallIcon->documents], ['escape'=>false, 'title' => 'Remove', 'class'=>'ajaxfileDelete btn btn-sm']);?>
        <?php
        }
        ?></div>
   		</div>
	</div>
	<div class="row form-group">
		<label class="col-sm-3">Note</label>
		<div class="col-sm-9"><?= $this->Form->control('notes', ['class'=>'form-control', 'required'=>false, 'label'=>false]); ?></div>
	</div>
    <div class="row form-group">
        <div class="col-sm-3"></div>
		<div class="col-sm-4">
			<?php echo $this->Form->control('show_to_contractor', ['label'=>'Show Note To Contractor']); ?>
		</div>
        <?php  if($activeUser['role_id']==CLIENT) { ?>
        <div class="col-sm-4">
			<?php echo $this->Form->control('show_to_clients',['type'=>'hidden','value'=>true]); ?>
		</div>
        <?php }else { ?>
		<div class="col-sm-4">
			<?php echo $this->Form->control('show_to_clients', ['label'=>'Show Note To Client']); ?>
		</div>
         <?php }?>
	</div>
	<div class="form-actions form-group">
		<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type'=>'submit', 'class'=>'btn btn-primary btn-sm']) ?>
	</div>
	<?= $this->Form->end() ?>
	</div>
</div>
</div>
</div>
