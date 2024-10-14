<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContractorUser $contractorUser
 */ 
?>
<?php if(isset($service_id )&&($cat_id) ){?>
<div class="row contractorUsers">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
	<?= __('If you have already added required Users, Please press Continue to proceed to the next Category.') ?>
	&emsp; <?= $this->Html->link('<em><i class="fa fa-dot-circle-o"></i></em> Continue', ['controller' => 'ContractorAnswers', 'action' => 'add-answers', $service_id, $cat_id],['class'=>'btn btn-primary btn-sm', 'escape'=>false, 'title' => 'Save and Continue']) ?>
	</div>
</div>
</div>
</div>

<div class="row contractorUsers">
<div class="col-lg-12">
<div class="card">

	<div class="card-header">
		<strong class="card-title"><?= __('Contractor Users') ?></strong>
		<span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller' => 'ContractorUsers', 'action' => 'add',$service_id, $cat_id],['class'=>'btn btn-success btn-sm addButton']) ?> </span>
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
	<thead>
	<tr>		
        <th scope="col"><?= h('Title') ?></th>        
		<th scope="col"><?= h('First Name') ?></th>
		<th scope="col"><?= h('Last Name') ?></th>
        <th scope="col"><?= h('Email') ?></th>
		<th scope="col"><?= h('Phone No') ?></th>	
        <th scope="col"><?= h('Is Safety Contact') ?></th>	
   		<th scope="col" class="actions"><?= __('Actions') ?></th>
  	</tr>
	</thead>
	<tbody>	
		  <tr>
                <td></td>                
                <td><?= h($contractor->pri_contact_fn) ?></td>
                <td><?= h($contractor->pri_contact_ln) ?></td>
                <td><?= h($contractor->user->username) ?></td>
                <td><?= h($contractor->pri_contact_pn) ?></td>
                <td><?= h($contractor->is_safety_contact) ? __('Yes') : __('No'); ?></td>
                <td class="actions"></td>               
           </tr>
	        <?php foreach ($contractorUsers as $contUser): ?>
            <tr>                
                <td><?= h($contUser->title) ?></td>               
                <td><?= h($contUser->pri_contact_fn) ?></td>
                <td><?= h($contUser->pri_contact_ln) ?></td>
                <td><?= h($contUser->user->username) ?></td>
                <td><?= h($contUser->pri_contact_pn) ?></td>  
                <td><?= h($contUser->is_safety_contact) ? __('Yes') : __('No'); ?></td>          
                <td class="actions">				
				<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $contUser->id,$service_id, $cat_id],['escape'=>false, 'title' => 'View','class'=>' ajaxmodal', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal_1', 'escape'=>false, 'title'=>'Contractor User Report']) ?>
				<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit',$contUser->id,$service_id, $cat_id],['escape'=>false, 'title' => 'Edit','class'=>' ajaxmodal', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal', 'escape'=>false, 'title'=>'Contractor User']) ?>			
				<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $contUser->id, $service_id, $cat_id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $contUser->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
	</tbody>
	</table>
	</div>
</div>
</div>
</div>
<?php } ?>
<div class="row contractorUsers " id="addNew">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<strong>Add New Contractor User </strong>
	</div>
	<div class="card-body card-block">
    <?= $this->Form->create($contractorUser) ?>
		<div class="form-group">
			<?php echo $this->Form->control('user.username', ['class'=>'form-control','label' => 'Email','required' => false,'oninput'=>'this.value=this.value.toLowerCase()']); ?>
		</div>
        <?php if(!$contractorUser->has('user')){ ?>
		<div class="form-group">
			<?php echo $this->Form->control('user.password', ['class'=>'form-control','required' => false, 'value'=> '']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('user.confirm_password', ['type'=>'password','class'=>'form-control','required' => false]); ?>
		</div>
        <?php } ?>
        <div class="form-group">
			<?= $this->Form->control('title', ['class'=>'form-control','label'=>'Title', 'required'=>false]); ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('pri_contact_fn', ['class'=>'form-control','label'=>'First Name', 'required'=>false]); ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('pri_contact_ln', ['class'=>'form-control','label'=>'Last Name', 'required'=>false]); ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('pri_contact_pn', ['id'=>'txtPhone', 'class'=>'form-control','label'=>'Phone No.', 'required'=>false, 'placeholder'=>'(123)-456-7890']); ?>
		</div>	
        <div class="form-group">
			<?php echo $this->Form->control('is_safety_contact', ['class'=>'', 'label'=>'Is Safety Contact']); ?>
		</div>	
		<div class="form-group">
			<?php echo $this->Form->control('user.role_id', ['value' => 8, 'type'=>'hidden']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('user.active', ['class'=>'']); ?>
		</div>        
        <div class="form-group">
			<?= $this->Form->control('user.under_configuration',['type'=>'hidden','default'=>false]); ?>
        </div>
		<div class="form-actions form-group">
            <?= $this->Form->button('Save', ['type' => 'submit', 'class'=>'btn btn-success btn-sm']) ?>
			<?php if(isset($service_id )&&($cat_id) ){?>
			<?= $this->Html->link('<em><i class="fa fa-dot-circle-o"></i></em> Continue', ['controller' => 'ContractorAnswers', 'action' => 'add-answers', $service_id, $cat_id],['class'=>'btn btn-primary btn-sm', 'escape'=>false, 'title' => 'Save and Continue']) ?>
			<?php } ?>
		</div>
    <?= $this->Form->end() ?>
	</div>
</div>
</div>
</div>

<div class="modal fade" id="scrollmodal" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="scrollmodalLabel"></h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		</div>
		<div class="modal-body">
		</div>
	</div>
	</div>
</div>
<div class="modal fade" id="scrollmodal_1" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="scrollmodalLabel"></h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		</div>
		<div class="modal-body">
		</div>
	</div>
	</div>
</div>