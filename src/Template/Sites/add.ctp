<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Site $site
 */
?>
<div class="row sites">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<strong>Add New</strong> Site
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create($site) ?>
		<div class="form-group">
			<?php echo $this->Form->control('name', ['class'=>'form-control', 'required'=>false]); ?>
		</div>
		<?php if(in_array($activeUser['role_id'],array(SUPER_ADMIN, ADMIN))) { ?>
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
		<?= $this->Form->label('Country'); ?>
		<div class="form-group">
		<?php  $otherOption = array('0' => "Other");
			   $countries = array_merge($otherOption,$countries);
		    echo $this->Form->control('country_id',['class'=>'form-control ajaxChange otherCountrySelection searchSelect','id'=>'otherCountrySelection', 'options' =>$countries , 'empty' => 'Please select country', 'data-url'=>'/countries/getStates/false', 'data-responce'=>'.ajax-responce','label'=>false, 'required'=>false]); ?>
	    </div>
		</div>
		<div class="form-group userEnterCountry" style="display: none;">
		<?= $this->Form->control('country', ['type'=>'text', 'class'=>'form-control userEnterCountry','id'=>'userEnterCountry', 'placeholder'=>'Please enter your country']); ?> 
		</div>
		<div class="form-group userEnterCountry" style="display: none;">
		<?= $this->Form->control('state', ['type'=>'text', 'class'=>'form-control userEnterCountry','id'=>'userEnterCountry','placeholder'=>'Please enter your state']); ?>
		</div>
		<div class="form-group ajax-responce statelist">
        <?= $this->Form->label('State'); ?>
        <?php if(!empty($stateOptions)) { 
        	     echo $this->Form->control('state_id', ['class'=>'form-control searchSelect', 'options' => $stateOptions, 'label'=>false,'required' => false]);
             }else{ 
                 echo $this->Form->control('state_id', ['class'=>'form-control searchSelect', 'options' => [], 'label'=>false,'required' => false]);
            } ?>
        <small id="countryHelp" class="form-text text-muted">States will be auto populated on country selection.</small>
		</div>
		<div class="form-group">
				<?= $this->Form->control('contact_phone', ['class'=>'form-control tags ','data-role'=>'tagsinput','placeholder'=>'(123)-456-7890','id'=>'txtPh']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('zip', ['class'=>'form-control', 'type'=>'text']); ?>
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
