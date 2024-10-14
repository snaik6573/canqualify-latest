<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Contractor $contractor
 */
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
?>
<div class="row roles contractors">
<div class="col-lg-6">
<div class="card">
	<div class="card-header clearfix">
		<strong>Edit</strong> Contractor
		<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
		<span class="pull-right"><?= $this->Form->postLink(__('Delete'), ['action'=>'delete', $contractor->id], ['class'=>'btn btn-danger btn-sm', 'confirm'=>__('Are you sure you want to delete # {0}?', $contractor->id)]) ?></span>
		<?php } ?>
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create($contractor) ?>
		<div class="form-group">
			<?php echo $this->Form->control('user.username', ['class'=>'form-control','label'=>'Email','required'=>false,'oninput'=>'this.value=this.value.toLowerCase()']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('company_name', ['class'=>'form-control', 'required'=>false]); ?>
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
         <div class="form-group">
             <?php
             $tempTin = preg_replace("/[^0-9.]/", '', $contractor->company_tin);
             $formatedTin =  substr($tempTin,0,2)."-";
             $formatedTin .= substr($tempTin,2);
             $contractor->company_tin = $formatedTin;
             ?>
			<?php echo $this->Form->control('company_tin', ['id'=>'txtTIN','class'=>'form-control', 'label'=>'Company TIN', 'required' => false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('addressline_1', ['class'=>'form-control', 'required'=>false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('addressline_2', ['class'=>'form-control', 'required'=>false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('city', ['class'=>'form-control', 'required'=>false]); ?>
		</div>
		<div class="form-group">
		<?php echo $this->Form->control('country_id',['class'=>'form-control ajaxChange searchSelect', 'options' => $countries,'data-url'=>'/countries/getStates/false', 'data-responce'=>'.ajax-responce','required' => false]); ?>
		</div>
		<div class="form-group ajax-responce">
         <?php $state = [];
          if(empty($states)) {  
        	echo $this->Form->control('state_id', ['class'=>'form-control searchSelect', 'options' => $state, 'empty' => true,'label'=>'State','required' => false]); 
            }else{ 
            echo $this->Form->control('state_id', ['class'=>'form-control searchSelect', 'options' => $states,'empty' => true, 'label'=>'State','required' => false]); 
          } ?>
          <small id="countryHelp" class="form-text text-muted">States will be auto populated on country selection.</small>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('zip', ['class'=>'form-control', 'type'=>'text']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('pri_contact_fn', ['class'=>'form-control', 'label'=>'First Name', 'required'=>false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('pri_contact_ln', ['class'=>'form-control', 'label'=>'Last Name', 'required'=>false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('pri_contact_pn', ['class'=>'form-control', 'label'=>'Phone No.', 'required'=>false]); ?>
		</div>
        <div class="form-group">
			<?php echo $this->Form->control('is_safety_contact', ['class'=>'', 'label'=>'Is safety Contact']); ?>
		</div>
		<div class="form-group">
			<label>Are you safety sensitive? </label><br />
			<?php echo $this->Form->radio('is_safety_sensitive', ['No', 'Yes'], ['default'=>'0']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('user.active', ['required'=>false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('payment_status', ['required'=>false]); ?>
		</div>
		<!--<div class="form-group">
			<?php echo $this->Form->control('customer_representative_id', ['options'=>$customer_rep,'value'=> $contractor['customer_representative_id'], 'empty'=>true, 'class'=>'form-control', 'multiple'=>true]); ?>
		</div>-->
        <div class="form-group">
            <?php echo $this->Form->control('gc_client_id', ['options'=>$gc_clients,'value'=> ($contractor['gc_client_id'])?$contractor['gc_client_id']:'', 'empty'=>true, 'class'=>'form-control']); ?>
        </div>
		<div class="form-actions form-group">
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type'=>'submit', 'class'=>'btn btn-primary btn-sm']); ?>
		</div>
	<?= $this->Form->end() ?>
	</div>
</div>
</div>
</div>

