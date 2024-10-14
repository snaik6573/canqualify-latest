<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Training $training
 */
 use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
$users = array(SUPER_ADMIN,CLIENT,CLIENT_ADMIN);

?>
<div class="row trainings">
<div class="col-lg-8">
<div class="card">
	<div class="card-header clearfix">
		<strong>Edit</strong> Orientations
		<?php if (in_array($activeUser['role_id'], $users)) { ?>
		<span class="pull-right"><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $training->id], ['class'=>'btn btn-danger btn-sm', 'confirm' => __('Are you sure you want to delete # {0}?', $training->id)]) ?></span>
		<?php } ?>
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create($training) ?>
		<div class="form-group">
			<?php echo $this->Form->control('name', ['class'=>'form-control', 'required'=>false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('description', ['class'=>'form-control']); ?>
		</div>
		<div class="form-group">
			<?= $this->Form->label('Select Sites', null, ['class'=>'col-form-label']); ?><br />
            <?= $this->Form->select('site_ids', ['Select Sites' => $sites], ['value'=>$training->site_ids['s_ids'],'multiple' => true, 'class'=>'form-control selectwithcheckbox'] ); ?>
		</div>
        <hr>
		<!--<div class="form-group">
			<?php //echo $this->Form->control('is_training', ['label'=>'Is Training Category']); ?>
		</div>-->
		<?php if($training->traning_video != ""){ ?>
		 <div class="row">
		 <div class="col-sm">
		<div class="form-group uploadWraper">
			<?php $fileCss = $training->traning_video!='' ? "display:none;" : ""; ?>
			<?= $this->Form->label('Traning Video', null, ['class'=>'col-form-label']); ?><br />
			<?php echo $this->Form->control('traning_video', ['label'=>false, 'type'=>'hidden', 'class'=>'documentName']); ?>
			<?php echo $this->Form->file('uploadFile', ['label'=>false, 'accept'=>'', 'style'=>$fileCss]); ?>
			<div class="uploadResponse">
			 <?php if($training->traning_video!='') { ?>
				<a href="<?= $uploaded_path.$training->traning_video ?>" class="uploadUrl" data-file="<?= $training->traning_video ?>" target="_Blank"><?= $training->traning_video ?></a>
				<!-- <?= $this->Html->link('<i class="fa fa-times-circle"></i>', ['controller'=>'TrainingQuestions', 'action' => 'delete', $training['training_questions'][0]->id], ['escape'=>false, 'title' => 'Remove', 'class'=>'ajaxfileDelete btn btn-sm']);?> -->
				 <?= $this->Html->link('<i class="fa fa-times-circle"></i>', ['controller'=>'Uploads', 'action' => 'deleteFile', $training->traning_video], ['escape'=>false, 'title' => 'Remove', 'class'=>'ajaxfileDelete btn btn-sm']);?>
				<?php }  ?>
			</div>
		</div>
			</div>
			<div class="col-sm-6">
			<div id="overlay" onclick="off()" style="display: none;">
				<div class="text"><br>
				<div style="margin-left: -121px;">
					<?php echo $this->Html->image('loader.gif',['style'=>'width:50px;display:block']); ?>
				</div>
				<span style="margin-left: -121px;font-size:15px; font-weight:8px;color:Black">Please wait...</span>
				</div>
			</div>
			</div>
		</div>
		 <?php }else{ ?>
		 <div class="row">
		 <div class="col-sm">
		 <div class="form-group uploadWraper">
			<?= $this->Form->label('Traning Video', null, ['class'=>'col-form-label']); ?><br />
			<?php echo $this->Form->control('traning_video', ['label'=>false, 'type'=>'hidden', 'class'=>'documentName']); ?>
			<?php echo $this->Form->file('uploadFile', ['label'=>false, 'accept'=>'.mp4, .3gp, .ogg, .webm']); ?>
			<div class="uploadResponse"></div>
		</div>
			</div>
			<div class="col-sm-6">
			<div id="overlay" onclick="off()" style="display: none;">
				<div class="text"><br>
				<div style="margin-left: -121px;">
					<?php echo $this->Html->image('loader.gif',['style'=>'width:50px;display:block']); ?>
				</div>
				<span style="margin-left: -121px;font-size:15px; font-weight:8px;color:Black">Please wait...</span>
				</div>
			</div>
			</div>
		</div>
		 <div class="form-group">
			<?php echo $this->Form->control('traning_video_link', ['class'=>'form-control', 'required'=>false,'label'=>'Your training video link']); ?>
		</div>
		<?php } ?>
		<div class="form-group">
			<?php echo $this->Form->control('category_order', ['class'=>'form-control']); ?>		
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('active'); ?>
		</div>
        <hr>
        <b>For Nested Trainings :</b><br/>
        <b>If Parent Training :</b>
		<div class="form-group">
			<?php echo $this->Form->control('is_parent', ['label'=>'Is Parent Category']); ?>
		</div>
        <hr />
        <b>If Sub Training :</b>
		<div class="form-group">
			<?php echo $this->Form->control('category_id', ['label'=>'Select Parent Category', 'class'=>'form-control', 'options' => $trainings, 'empty' => true]); ?>
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
