<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContractorUser[]|\Cake\Collection\CollectionInterface $contractorUsers
 */
$users = array(SUPER_ADMIN,ADMIN,CONTRACTOR,CONTRACTOR_ADMIN);
?>
<div class="row contractorUsers">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Contractor Users') ?></strong>
		<?php if(in_array($activeUser['role_id'], $users)) { ?>
		<span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller' => 'ContractorUsers', 'action' => 'add'],['class'=>'btn btn-success btn-sm']) ?> </span>
	    <?php } ?>
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
	<thead>
	<tr>		
        <th scope="col"><?= h('Title') ?></th>        
		<th scope="col"><?= h('First Name') ?></th>
		<th scope="col"><?= h('Last Name') ?></th>
        <th scope="col"><?= h('Email') ?></th>
		<th scope="col"><?= h('Phone no') ?></th>	
        <th scope="col"><?= h('Is safety Contact') ?></th>	
   		<th scope="col" class="actions"><?= __('Actions') ?></th>
  	</tr>
	</thead>
	<tbody>	
		  <tr>
                <td><?= h($contractor->pri_contact_title) ?></td>
                <td><?= h($contractor->pri_contact_fn) ?></td>
                <td><?= h($contractor->pri_contact_ln) ?></td>
                <td><?= h($contractor->user->username) ?></td>
                <td><?= h($contractor->pri_contact_pn) ?></td>
                <td><?= h($contractor->is_safety_contact) ? __('Yes') : __('No'); ?></td>
                <td class="actions"></td>               
           </tr>
	<?php foreach ($contractorUsers as $contractorUser): ?>
            <tr>                
                <td><?= h($contractorUser->title) ?></td>               
                <td><?= h($contractorUser->pri_contact_fn) ?></td>
                <td><?= h($contractorUser->pri_contact_ln) ?></td>
                <td><?= h($contractorUser->user->username) ?></td>
                <td><?= h($contractorUser->pri_contact_pn) ?></td>  
                <td><?= h($contractorUser->is_safety_contact) ? __('Yes') : __('No'); ?></td>          
                <td class="actions">				
				<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $contractorUser->id],['escape'=>false, 'title' => 'View']) ?>
				<?php if(in_array($activeUser['role_id'], $users)) { ?>
				<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $contractorUser->id],['escape'=>false, 'title' => 'Edit']) ?>
				
				<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $contractorUser->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $contractorUser->id)]) ?>
                <?php } ?>  
                </td>
            </tr>
            <?php endforeach; ?>
	</tbody>
	</table>
	</div>	
</div>
</div>
</div>
