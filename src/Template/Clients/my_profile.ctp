<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
?>
<div class="row clients">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong>Login</strong> Details
	</div>

	<div class="card-body card-block">
	<?= $this->Form->create($clientUser) ?>
	<div class="form-group row">
		<?= $this->Form->label('Email', null, ['class'=>'col-sm-3  col-form-label']); ?>
		<div class="col-sm-5"><?php echo $this->Form->control('user.username', ['class'=>'form-control', 'label'=>false, 'required'=>false,'oninput'=>'this.value=this.value.toLowerCase()']); ?></div>
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
	<?= $this->Form->create($clientUser) ?>
	<?= $this->element('profile_upload', ["user" => $clientUser->user, "fieldname" => 'user.profile_photo']) ?>
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
	<?= $this->Form->create($clientUser) ?>
	<div class="form-group row">
		<?= $this->Form->label('Company Name', null, ['class'=>'col-sm-3  col-form-label']); ?>
		<div class="col-sm-4"><?= $this->Form->control('client.company_name', ['class'=>'form-control', 'label'=>false, 'required'=>false]); ?></div>
	</div>
	<div class="row form-group ">
        <?php $fileCss = $clientUser->client->company_logo!='' ? "display:none;" : ""; ?>
       <?= $this->Form->label('Company Logo', null, ['class'=>'col-sm-3']); ?><br />
       <div class="col-sm-9 uploadWraper">
       <?php echo $this->Form->control('client.company_logo', ['label'=>false, 'type'=>'hidden', 'class'=>'documentName']); ?>
       <?php echo $this->Form->file('client.uploadFile', ['label'=>false,'style'=>$fileCss]); ?>
       <div class="uploadResponse">
            <?php if($clientUser->client->company_logo!='') { ?>
            <a href="<?= $uploaded_path.$clientUser->client->company_logo ?>" class="uploadUrl" data-file="<?= $clientUser->client->company_logo ?>" target="_Blank"><?= $clientUser->client->company_logo ?></a>
            <?= $this->Html->link('<i class="fa fa-times-circle"></i>', ['controller'=>'Uploads', 'action' => 'deleteFile', $clientUser->client->company_logo], ['escape'=>false, 'title' => 'Remove', 'class'=>'ajaxfileDelete btn btn-sm']);?>
            <?php }  ?>
        </div>
       </div>
   </div>
	<div class="form-group row">
		<?= $this->Form->label('Addressline 1', null, ['class'=>'col-sm-3  col-form-label']); ?>
		<div class="col-sm-6"><?= $this->Form->control('client.addressline_1', ['class'=>'form-control', 'label'=>false, 'required'=>false]); ?></div>
	</div>
	<div class="form-group row">
		<?= $this->Form->label('Addressline 2', null, ['class'=>'col-sm-3  col-form-label']); ?>
		<div class="col-sm-6"><?= $this->Form->control('client.addressline_2', ['class'=>'form-control', 'label'=>false, 'required'=>false]); ?></div>
	</div>
	<div class="form-group row">
		<?= $this->Form->label('City', null, ['class'=>'col-sm-3  col-form-label']); ?>
		<div class="col-sm-4"><?= $this->Form->control('client.city', ['class'=>'form-control', 'label'=>false, 'required'=>false]); ?></div>
	</div>
	<div class="form-group row">
	<?= $this->Form->label('Country', null, ['class'=>'col-sm-3  col-form-label']); ?>
	<div class="col-sm-4"><?php echo $this->Form->control('client.country_id',['class'=>'form-control ajaxChange searchSelect', 'options' => $countries,'data-url'=>'/countries/getStates/true', 'data-responce'=>'.ajax-responce','label'=>false,'required' => false]); ?>
	</div>
	</div>
	<div class="form-group  row">
	<?= $this->Form->label('State', null, ['class'=>'col-sm-3  col-form-label']); ?>
	<div class="col-sm-4 ajax-responce">
	   <?php $state = [];
          if(empty($states)) {  
        	echo $this->Form->control('client.state_id', ['class'=>'form-control searchSelect', 'options' => $state, 'empty' => true,'label'=>false,'required' => false]); 
            }else{ 
            echo $this->Form->control('client.state_id', ['class'=>'form-control searchSelect', 'options' => $states,'empty' => true, 'label'=>false,'required' => false]); 
          } ?>
      <small id="countryHelp" class="form-text text-muted">States will be auto populated on country selection.</small>          	
      </div>
	</div>
	<div class="form-group row">
		<?= $this->Form->label('Zip', null, ['class'=>'col-sm-3  col-form-label']); ?>
		<div class="col-sm-2"><?= $this->Form->control('client.zip', ['class'=>'form-control', 'label'=>false, 'type'=>'text']); ?></div>
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
	<?= $this->Form->create($clientUser) ?>
	<div class="form-group row">
		<?= $this->Form->label('First Name', null, ['class'=>'col-sm-3  col-form-label']); ?>
		<div class="col-sm-4"><?= $this->Form->control('pri_contact_fn', ['class'=>'form-control','label'=>false, 'required'=>false]); ?></div>
	</div>
	<div class="form-group row">
		<?= $this->Form->label('Last Name', null, ['class'=>'col-sm-3  col-form-label']); ?>
		<div class="col-sm-4"><?= $this->Form->control('pri_contact_ln', ['class'=>'form-control','label'=>false, 'required'=>false]); ?></div>
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
		<strong>Your </strong> Services
	</div>

	<div class="card-body card-block">
	<?php if (!empty($clientUser->client->client_services)): ?>
	<table class="table table-responsive"><tr>
			<th scope="col"><?= __('Product') ?></th>
			<th scope="col"><?= __('Client Annual Membership') ?></th>
			<th scope="col"><?= __('Contractor Annual Membership') ?></th>			
		</tr>
		<?php foreach ($clientUser->client->client_services as $client_service): 
		// echo "<pre>"; print_r($client_service);
		?>
		<tr>
			<td><?= h($client_service->service->name) ?></td>
			<td>$0</td>
			<td>
                <?php
                    if(isset($clientUser->client->is_gc) && $clientUser->client->is_gc){
                        echo '$0';
                    }elseif(!empty($client_service->service->products)){
                        echo '$'.$client_service->service->products[0]->pricing;
                    }else{
                        echo '$0';
                    }
                ?>
            </td>
			<td></td>			
		</tr>
		<?php endforeach; ?>
	</table>
	<?php endif; ?>
	</div>
</div>
</div>

<!--<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong>Your </strong> Sites
	</div>

	<div class="card-body card-block">
	<?php if (!empty($client->sites)): ?>
	<table class="table">
		<tr>
			<th scope="col"><?= __('Id') ?></th>
			<th scope="col"><?= __('Site') ?></th>
			<th scope="col"><?= __('Region') ?></th>
			<th scope="col" class="actions"><?= __('Actions') ?></th>
		</tr>
		<?php
	//echo '<pre>';  print_r($client->sites); '</pre>';
		foreach ($client->sites as $site):?>
		<tr>
			<td><?= h($site->id) ?></td>
			<td><?= h($site->name) ?></td>
			<td><?= $site->has('region') ? h($site->region->name) : '' ?></td>
			<td class="actions">
			<?= $this->Html->link(__('View'), ['controller' => 'Sites','action' => 'view', $site->id]) ?>
			<?= $this->Html->link(__('Edit'), ['controller' => 'Sites','action' => 'edit', $site->id]) ?>
			<?php if($activeUser['role_id'] != ADMIN) { ?>
			<?= $this->Form->postLink(__('Delete'), ['controller' => 'Sites','action' => 'delete', $site->id], ['confirm' => __('Are you sure you want to delete # {0}?', $site->id)]) ?>
			<?php } ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
	<?php endif; ?>
	</div>
</div>
</div>-->
</div>
