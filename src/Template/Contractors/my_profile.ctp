<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
?>
<div class="row contractors">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong>Login </strong> Details
	</div>

	<div class="card-body card-block">
	<?= $this->Form->create($contractor) ?>
	<div class="form-group row">
		<?= $this->Form->label('Email', null, ['class'=>'col-sm-3  col-form-label']); ?>
		<div class="col-sm-4"><?php echo $this->Form->control('user.username', ['class'=>'form-control', 'label'=>false, 'required'=>false ,'oninput'=>'this.value=this.value.toLowerCase()']); ?></div>
	</div>
	<div class="form-actions form-group row">
		<div class="offset-sm-3 col-sm-9">
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
			<?= $this->Html->link(__('<em><i class="fa fa-dot-circle-o"></i></em> Change Password'), ['controller' => 'Users','action' => 'changePassword'], ['escape' => false, 'class'=>'btn btn-success btn-sm']) ?>
		</div>
	</div>
	<?= $this->Form->end() ?>
	</div>
</div>
</div>

<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong>Profile</strong>
	</div>

	<div class="card-body card-block">
	<?= $this->Form->create($contractor) ?>
	<?= $this->element('profile_upload', ["user" => $contractor->user, "fieldname" => 'user.profile_photo']) ?>
   	<div class="form-actions form-group">
		<?= $this->Form->control('user.username', ['type'=>'hidden']); ?>
		<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
	</div>
	<?= $this->Form->end() ?>
	</div>
</div>
</div>

<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong>Company </strong> Information
	</div>

	<div class="card-body card-block">
	<?= $this->Form->create($contractor) ?>
	<div class="form-group row">
		<?= $this->Form->label('Company Name', null, ['class'=>'col-sm-3  col-form-label']); ?>
		<div class="col-sm-4"><?= $this->Form->control('company_name', ['class'=>'form-control', 'label'=>false, 'required'=>false]); ?></div>
	</div>
	<div class="row form-group">
       <?php $fileCss = $contractor->company_logo!='' ? "display:none;" : ""; ?>
       <?= $this->Form->label('Company Logo', null, ['class'=>'col-sm-3']); ?><br />
       <div class="col-sm-9 uploadWraper">
       <?php echo $this->Form->control('company_logo', ['label'=>false, 'type'=>'hidden', 'class'=>'documentName']); ?>
       <?php echo $this->Form->file('uploadFile', ['label'=>false,'style'=>$fileCss]); ?>
       <div class="uploadResponse">
            <?php if($contractor->company_logo!='') { ?>
            <a href="<?= $uploaded_path.$contractor->company_logo ?>" class="uploadUrl" data-file="<?= $contractor->company_logo ?>" target="_Blank"><?= $contractor->company_logo ?></a>
            <?= $this->Html->link('<i class="fa fa-times-circle"></i>', ['controller'=>'Uploads', 'action' => 'deleteFile', $contractor->company_logo], ['escape'=>false, 'title' => 'Remove', 'class'=>'ajaxfileDelete btn btn-sm']);?>
            <?php } ?>
       </div>
       </div>
	</div>
    <div class="form-group row">
	    <?= $this->Form->label('Company TIN', null, ['class'=>'col-sm-3  col-form-label']); ?>
        <?php
        $tempTin = preg_replace("/[^0-9.]/", '', $contractor->company_tin);
        $formatedTin =  substr($tempTin,0,2)."-";
        $formatedTin .= substr($tempTin,2);
        $contractor->company_tin = $formatedTin;
        ?>
	    <div class="col-sm-4"><?= $this->Form->control('company_tin', ['id'=>'txtTIN', 'class'=>'form-control', 'label'=>false, 'required'=>false]); ?></div>
    </div>
	<div class="form-group row">
		<?= $this->Form->label('Addressline 1', null, ['class'=>'col-sm-3  col-form-label']); ?>
		<div class="col-sm-6"><?= $this->Form->control('addressline_1', ['class'=>'form-control', 'label'=>false, 'required'=>false]); ?></div>
	</div>
	<div class="form-group row">
		<?= $this->Form->label('Addressline 2', null, ['class'=>'col-sm-3  col-form-label']); ?>
		<div class="col-sm-6"><?= $this->Form->control('addressline_2', ['class'=>'form-control', 'label'=>false, 'required'=>false]); ?></div>
	</div>
	<div class="form-group row">
		<?= $this->Form->label('City', null, ['class'=>'col-sm-3  col-form-label']); ?>
		<div class="col-sm-4"><?= $this->Form->control('city', ['class'=>'form-control', 'label'=>false, 'required'=>false]); ?></div>
	</div>
	<div class="form-group row">
	<?= $this->Form->label('Country', null, ['class'=>'col-sm-3  col-form-label']); ?>
	<div class="col-sm-4"><?php echo $this->Form->control('country_id',['class'=>'form-control ajaxChange searchSelect', 'options' => $countries,'data-url'=>'/countries/getStates/true', 'data-responce'=>'.ajax-responce','label'=>false,'required' => false]); ?>
	</div>
	</div>
	<div class="form-group  row">
	<?= $this->Form->label('State', null, ['class'=>'col-sm-3  col-form-label']); ?>
	<div class="col-sm-4 ajax-responce">
	   <?php $state = [];
          if(empty($states)) {  
        	echo $this->Form->control('state_id', ['class'=>'form-control searchSelect', 'options' => $state, 'empty' => true,'label'=>false,'required' => false]); 
            }else{ 
            echo $this->Form->control('state_id', ['class'=>'form-control searchSelect', 'options' => $states,'empty' => true, 'label'=>false,'required' => false]); 
          } ?>
      <small id="countryHelp" class="form-text text-muted">States will be auto populated on country selection.</small>          	
      </div>
	</div>
	<div class="form-group row">
		<?= $this->Form->label('Zip', null, ['class'=>'col-sm-3  col-form-label']); ?>
		<div class="col-sm-2"><?= $this->Form->control('zip', ['class'=>'form-control', 'label'=>false, 'type'=>'text']); ?></div>
	</div>
	<div class="form-group row">
            <?= $this->Form->label('Opt-in for Employee Recruitment Service', null, ['class'=>'col-sm-3  col-form-label']); ?> 
            <div class="col-sm-9">       
            <?= $this->Form->control('emp_req',['label'=>false]); ?>
            </div> 
	</div>
	<div class="form-actions form-group">
		<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
	</div>
	<?= $this->Form->end() ?>
	</div>
</div>
</div>

<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong>Primary </strong> Contact Details
	</div>

	<div class="card-body card-block">
	<?= $this->Form->create($contractor) ?>
	<div class="form-group row">
		<?= $this->Form->label('First Name', null, ['class'=>'col-sm-3  col-form-label']); ?>
		<div class="col-sm-4"><?= $this->Form->control('pri_contact_fn', ['class'=>'form-control','label'=>false, 'required'=>false]); ?></div>
	</div>
	<div class="form-group row">
		<?= $this->Form->label('Last Name', null, ['class'=>'col-sm-3  col-form-label']); ?>
		<div class="col-sm-4"><?= $this->Form->control('pri_contact_ln', ['class'=>'form-control','label'=>false, 'required'=>false]); ?></div>
	</div>
    <div class="form-group row">
	    <?= $this->Form->label('Primary Contact Title', null, ['class'=>'col-sm-3  col-form-label']); ?>
	    <div class="col-sm-4"><?= $this->Form->control('pri_contact_title', ['class'=>'form-control','label'=>false, 'required'=>false]); ?></div>
    </div>
	<div class="form-group row">
		<?= $this->Form->label('Phone No', null, ['class'=>'col-sm-3  col-form-label']); ?>
		<div class="col-sm-4"><?= $this->Form->control('pri_contact_pn', ['class'=>'form-control','label'=>false, 'required'=>false,'id'=>'txtPhone']); ?></div>
	</div>
	<div class="form-actions form-group">
		<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
	</div>
	<?= $this->Form->end() ?>
	</div>
</div>
</div>

<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong>Other </strong> Info
	</div>

	<div class="card-body card-block">
	<div class="form-group">
		<label>Are you safety sensitive? </label><br />
		<strong><?= $contractor->is_safety_sensitive ? __('Yes') : __('No'); ?></strong>		
	</div>
	</div>
</div>
</div>

</div>
