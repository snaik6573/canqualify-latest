<?php
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
?>
<div class="row form-group">
		<?php $fileCss = $emailSignature->profile_photo!='' ? "display:none;" : ""; ?>
		<?= $this->Form->label('Profile Photo', null, ['class'=>'col-sm-3 font-weight-bold']); ?><br />
		<div class="col-sm-9 uploadWraper uploadProfile">
		<?php echo $this->Form->control($fieldname, ['label'=>false, 'type'=>'hidden', 'class'=>'documentName']); ?>
		<?php echo $this->Form->file('uploadFile', ['id'=>'profile_photo','label'=>false, 'class'=>"uploadPhoto", 'style'=>$fileCss]); ?>
		<div class="uploadResponse">
			<?php if($emailSignature->profile_photo!='') { ?>
			<div class="profile_photo uploadUrl" data-file="<?= $emailSignature->profile_photo ?>">
				<img src="<?= $uploaded_path.$emailSignature->profile_photo ?>" />
			</div>
			<?php
			echo $this->Html->link('Change', [], ['escape'=>false, 'title' => 'Change', 'class'=>'ajaxfileChange btn btn-sm btn-success']);
			echo $this->Html->link('Remove', ['controller'=>'Uploads', 'action' => 'deleteFile', $emailSignature->profile_photo], ['escape'=>false, 'title' => 'Remove', 'class'=>'ajaxfileDelete btn btn-sm btn-danger']);
			} ?>
		</div>
		</div>
</div>