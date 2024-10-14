<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Training $training
 */
?>
<div class="row trainings">
<div class="col-lg-8">
<div class="card">
	<div class="card-header">
		<strong>Add New</strong> Orientations
	</div>
    <?php if($activeUser['role_id'] == SUPER_ADMIN || $activeUser['role_id'] == ADMIN) { ?>
	<div class="card-body card-block">	
	    <?= $this->Form->create($training) ?>	
	    <div class="row form-group">
	    <?php $selectedClient = !empty($client) ? $client->id : reset($clients); ?>
		    <label class="col-sm-3">Select Client</label>
		    <div class="col-sm-6"><?= $this->Form->control('current_client_id', ['options'=>$clients, 'default'=>$selectedClient, 'required'=>true, 'label'=>false, 'class'=>'form-control']); ?></div>
		    <div class="col-sm-3"><?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type'=>'submit', 'class'=>'btn btn-primary btn-sm']) ?></div>
	    </div>
	    <?= $this->Form->end() ?>
	</div>
<?php } ?>
    <?php if(!empty($client)) : ?>
    <?php if($activeUser['role_id'] == SUPER_ADMIN || $activeUser['role_id'] == ADMIN) { ?>
	<div class="card-header">
		<strong>CanQualify Client: <?= $client->has('company_name') ? $client->company_name : ''; ?></strong>
	</div>
    <?php } ?>
	<div class="card-body card-block">	
	<?= $this->Form->create($training, ['type'=>'file']) ?>
		<div class="form-group">
			<?php echo $this->Form->control('name', ['class'=>'form-control', 'required'=>false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('description', ['class'=>'form-control']); ?>
		</div>	
		<div class="form-group">
			<?= $this->Form->label('Select Sites', null, ['class'=>'col-form-label']); ?><br />
            <?= $this->Form->select('site_ids', ['Select Sites' => $sites], ['multiple' => true, 'class'=>'form-control selectwithcheckbox'] ); ?>
		</div>
        <hr>
		<!--<div class="form-group">
			<?php //echo $this->Form->control('is_training', ['label'=>'Is Training Category']); ?>
		</div>-->
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
		<div class="form-group">
			<?php echo $this->Form->control('category_order', ['class'=>'form-control']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('active', ['checked'=>'checked']); ?>
		</div>
        <hr>
        <b>For Nested Trainings :</b><br/>
        <b>If Parent Training :</b>
		<div class="form-group">
			<?php echo $this->Form->control('is_parent', ['label'=>'Is Parent Training']); ?>
		</div>
        <hr />
        <b>If Sub Training :</b>
		<div class="form-group">
			<?php echo $this->Form->control('category_id', ['label'=>'Select Parent Training', 'class'=>'form-control', 'options' => $trainings, 'empty' => true]); ?>
		</div>
		<div class="form-actions form-group">
			<?= $this->Form->control('client_id', ['type'=>'hidden','value'=>$client->id]); ?>
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
			<?= $this->Form->button('<em><i class="fa fa-ban"></i></em> Reset', ['type' => 'reset', 'class'=>'btn btn-danger btn-sm']); ?>
		</div>
	<?= $this->Form->end() ?>	
	</div>
	<?php endif; ?>
</div>
</div>
</div>
