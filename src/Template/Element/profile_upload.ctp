<?php
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
?>
<div class="row form-group">
		<?php $fileCss = $user->profile_photo!='' ? "display:none;" : ""; ?>
		<?= $this->Form->label('Profile Photo', null, ['class'=>'col-sm-3']); ?><br />
		<div class="col-sm-9 uploadWraper uploadProfile">
		<?php echo $this->Form->control($fieldname, ['label'=>false, 'type'=>'hidden', 'class'=>'documentName']); ?>
		<?php echo $this->Form->file('uploadFile', ['label'=>false, 'class'=>"uploadPhoto", 'style'=>$fileCss]); ?>
		<div class="uploadResponse">
			<?php if($user->profile_photo!='') { ?>
			<div class="profile_photo uploadUrl" data-file="<?= $user->profile_photo ?>">
				<img src="<?= $uploaded_path.$user->profile_photo ?>" />
			</div>
			<?php
			echo $this->Html->link('Change', [], ['escape'=>false, 'title' => 'Change', 'class'=>'ajaxfileChange btn btn-sm btn-success']);
			echo $this->Html->link('Remove', ['controller'=>'Uploads', 'action' => 'deleteFile', $user->profile_photo], ['escape'=>false, 'title' => 'Remove', 'class'=>'ajaxfileDelete btn btn-sm btn-danger']);
			} ?>
		</div>
		</div>
</div>