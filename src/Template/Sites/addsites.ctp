<div class="row clients">
<div class="col-lg-12">
<div class="card"> 
	<div class="card-header">
		<strong>Add Your</strong> Locations
	</div>
	<div class="setup"style="padding:10px;">	
	<div class="col-md-6">
			<?=  $this->Form->create($client, ['url'=>['action'=>'addLocation'],['class'=>'client_location']]);?>
		<div class="form-group">
			<?= $this->Form->control('account_type_id', ['options'=>$accountTypes, 'empty'=>false, 'class'=>'form-control', "onchange" => "this.form.submit()"]) ?>
		</div>		
	   <?= $this->Form->end() ?>
       <?php if($client['account_type_id']== 3){ ?>
		<div id="div_corporate" class="clearfix">

			<?= $this->Html->link('Add Region','#', ['class'=>'btn btn-primary btn-sm add_regions pull-right','style'=>'margin-bottom:10px;'])?>
			<?= $this->Form->create(null, ['url'=>['action'=>'addregion'],'id'=>'form_regions', 'style'=>'display:none;'])?>
			<div class="form-group">
				<?= $this->Form->control('name', ['class'=>'form-control','required'=>true]) ?>				
			</div>
			<div class="form-actions form-group">
				<?= $this->Form->control('client_id', ['type'=>'hidden', 'value'=>$activeUser['client_id']]) ?>				
				<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> <span>Save</span>', ['type'=>'submit', 'class'=>'btn btn-primary btn-sm']); ?>				
			</div>
			<?= $this->Form->end() ?>	
		</div>
		<?php } ?>
		<div id="div_sites" class="clearfix">
			<?= $this->Html->link('Add site','#', ['class'=>'btn btn-primary btn-sm add_sites pull-right','style'=>'margin-bottom:10px;']);?>
			<?php $collapseShow = 'collapse';
				if($showErrors){ $collapseShow ='collapse show'; }
		       	?>
		    <div id="form_sites" class="<?php echo $collapseShow ; ?>">
			<?=  $this->Form->create($site, ['id'=>'form_sites']);?>
			<div class="form-group">
				<?= $this->Form->control('name', ['class'=>'form-control', 'required'=>false, 'value'=>'']); ?>
			</div>
			<div class="form-group">
				<?= $this->Form->control('region_id', ['options'=>$regionslist, 'empty'=>true, 'class'=>'form-control']); ?>
			</div>
			<div class="form-group">
				<?= $this->Form->control('addressline_1', ['class'=>'form-control', 'required'=>false, 'value'=>'']); ?>
			</div>
			<div class="form-group">
				<?= $this->Form->control('addressline_2', ['class'=>'form-control', 'required'=>false, 'value'=>'']); ?>
			</div>
			<div class="form-group">
				<?= $this->Form->control('city', ['class'=>'form-control', 'required'=>false, 'value'=>'']); ?>
			</div>
			<div class="form-group">
			<?= $this->Form->label('Country'); ?>
			<div class="form-group">
			<?php  $otherOption = array('0' => "Other");
					$countries = $otherOption + $countries;
				   //$countries = array_merge($otherOption,$countries);
			    echo $this->Form->control('country_id',['class'=>'form-control ajaxChange otherCountrySelection searchSelect','id'=>'otherCountrySelection', 'options' =>$countries , 'empty' => 'Please select country', 'data-url'=>'/countries/getStates/false', 'data-responce'=>'.ajax-responce','label'=>false, 'required'=>false,'value'=>'','style'=>'width:500.5px;height:38;']); ?>
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
	        	     echo $this->Form->control('state_id', ['class'=>'form-control searchSelect', 'options' => $stateOptions, 'label'=>false,'required' => false,'style'=>'width:500.5px;height:38;']);
	             }else{ 
	                 echo $this->Form->control('state_id', ['class'=>'form-control searchSelect', 'options' => [], 'label'=>false, 'required' => false ,'style'=>'width:500.5px;height:38;']);
	            } ?>
	         <small id="countryHelp" class="form-text text-muted">States will be auto populated on country selection.</small>
			</div>
			<div class="form-group">
				<?= $this->Form->control('contact_phone', ['class'=>'form-control tags test','data-role'=>'tagsinput','placeholder'=>'(123)-456-7890','id'=>'txtPh','required'=>false]); ?>
			</div>
			<div class="form-group">
				<?= $this->Form->control('contact_email', ['class'=>'form-control tags ','data-role'=>'tagsinput','required'=>false]); ?>
			</div>
			<div class="form-group">
				<?= $this->Form->control('zip', ['class'=>'form-control', 'required'=>false, 'value'=>'']); ?>
			</div>
			<div class="form-actions form-group">
				<?= $this->Form->control('client_id', ['type'=>'hidden', 'value'=>$activeUser['client_id']]); ?>

				<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> <span>Save</span>', ['type'=>'submit', 'class'=>'btn btn-primary btn-sm']); ?>
			</div>
			<?= $this->Form->end() ?>	
		</div><!-- #div_sites -->
		</div>		
	</div>
	<div class="regions_tbl col-md-6">
	<?php
	if(isset($regions)) {
	foreach ($regions as $r) { ?>
	<div class="card">
		<div class="card-header clearfix">
			<strong>Region : </strong> <?= h($r->name) ?>
		</div>
		<div class="card-body card-block">
		<table class="table">
		  <tr>
			<th scope="col"><?= __('Name') ?></th>					
			<th scope="col"><?= __('City') ?></th>	
			<?php if($activeUser['role_id'] != ADMIN) { ?>
			<th scope="col" class="actions text-center"><?= __('Actions') ?></th>
			<?php } ?>
		  </tr>
		<?php foreach ($r->sites as $s): ?>
		<tr>				
			<td><?= h($s->name) ?></td>
			<td><?= h($s->city) ?></td>
			<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
			<td class="actions text-right">
				 <?= $this->Form->postLink(__('Delete'), ['controller'=>'Clients', 'action'=>'sitesdelete', $s->id], ['class'=>'btn btn-primary btn-sm ajaxDelete', 'confirm' => __('Are you sure you want to delete # {0}?', $s->id)]) ?>
			</td>
			<?php } ?>
		</tr>
		<?php endforeach; ?>
		</table>
		</div>
	</div>
	<?php 
	}
	}
	if(isset($sites)) { ?>
	<div class="card">
		<div class="card-header clearfix">
			<strong>Sites</strong>		
		</div>
		<div class="card-body card-block">
		<table class="table">
		  <tr>
			<th scope="col"><?= __('Name') ?></th>					
			<th scope="col"><?= __('City') ?></th>		
            <?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>			
			<th scope="col" class="actions text-center"><?= __('Actions') ?></th>
			<?php } ?>
		  </tr>
		<?php 	
		foreach ($sites as $s): ?>
		<tr>					
			<td><?= h($s->name) ?></td>
			<td><?= h($s->city) ?></td>
			<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
			<td class="actions text-right">			
	
            <?= $this->Form->postLink(__('Delete'), ['controller'=>'Clients', 'action'=>'sitesdelete', $s->id], ['class'=>'btn btn-primary btn-sm ajaxDelete', 'confirm' => __('Are you sure you want to delete # {0}?', $s->id)]) ?>
			</td>
			<?php } ?>
		</tr>
		<?php endforeach; ?>
		</table>
		</div>
	</div>
	<?php 
	}
	?>
	</div>
</div>
</div>
</div>
</div>