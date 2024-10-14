<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Site $site
 */
?>
<div class="row sites">
<div class="col-lg-6">
<div class="card">
	<div class="card-header clearfix">
		<strong>Edit</strong> Site
		<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
		<span class="pull-right"><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $site->id], ['class'=>'btn btn-danger btn-sm', 'confirm' => __('Are you sure you want to delete # {0}?', $site->id)]) ?></span>
		<?php } ?>
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create($site) ?>
		<div class="form-group">
			<?php echo $this->Form->control('name', ['class'=>'form-control', 'required'=>false]); ?>
		</div>
		<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
		<div class="form-group">
			<?php echo $this->Form->control('client_id', ['options' => $clients, 'empty' => false, 'class'=>'form-control']); ?>
		</div>
		<?php } ?>
		<div class="form-group">
			<?php echo $this->Form->control('region_id', ['options' => $regions, 'empty' => true, 'class'=>'form-control']); ?>
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
			<?php echo $this->Form->control('contact_phone', ['class'=>'form-control tags ','type'=>'text','data-role'=>'tagsinput','placeholder'=>'(123)-456-7890','id'=>'txtPh']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('zip', ['class'=>'form-control', 'type'=>'text']); ?>
		</div>

        <h6>SHE Contact: </h6>
        <div class="form-group">
            <?php echo $this->Form->control('she_fname', ['class'=>'form-control', 'required'=>false, 'label' => 'First Name']); ?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->control('she_lname', ['class'=>'form-control', 'required'=>false, 'label' => 'Last Name']); ?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->control('she_title', ['class'=>'form-control', 'required'=>false, 'label' => 'Title']); ?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->control('she_phone', ['class'=>'form-control tags', 'type' =>'text','data-role'=>'tagsinput','placeholder'=>'(123)-456-7890', 'required'=>false, 'label' => 'Phone', 'class' => 'txtPh']); ?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->control('she_email', ['class'=>'form-control', 'required'=>false, 'label' => 'Email']); ?>
        </div>

        <h6>Facility Contact: </h6>
        <div class="form-group">
            <?php echo $this->Form->control('facility_fname', ['class'=>'form-control', 'required'=>false, 'label' => 'First Name']); ?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->control('facility_lname', ['class'=>'form-control', 'required'=>false, 'label' => 'Last Name']); ?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->control('facility_title', ['class'=>'form-control', 'required'=>false, 'label' => 'Title']); ?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->control('facility_phone', ['class'=>'form-control tags', 'type' =>'text','data-role'=>'tagsinput','placeholder'=>'(123)-456-7890', 'required'=>false, 'label' => 'Phone', 'class' => 'txtPh']); ?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->control('facility_email', ['class'=>'form-control', 'required'=>false, 'label' => 'Email']); ?>
        </div>

		<div class="form-actions form-group">
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
		</div>
	<?= $this->Form->end() ?>	
	</div>
</div>
</div>
</div>
