<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmployeeCategory[]|\Cake\Collection\CollectionInterface $employeeCategories
 */
?>
<div class="row employeeCategories">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Employee Categories') ?></strong>
		<span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller' => 'EmployeeCategories', 'action' => 'add'],['class'=>'btn btn-success btn-sm']) ?> </span>
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
        <thead>
            <tr>
					<th scope="col"><?= h('Id') ?></th>
					<th scope="col"><?= h('Name') ?></th>
					<th scope="col"><?= h('Active') ?></th>
					<th scope="col"><?= h('Parent') ?></th>
					<th scope="col"><?= h('Order') ?></th>
					<th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employeeCategories as $employeeCategory): ?>
            <tr>
					<td><?= $this->Number->format($employeeCategory->id) ?></td>
					<td><?= h($employeeCategory->name) ?></td>
					<td><?= $employeeCategory->active ? __('Yes') : __('No'); ?></td>
					<td><?= $employeeCategory->employee_category_id !=0 ? $this->Html->link($employeeCategory->employee_category_id, ['action' => 'view', $employeeCategory->employee_category_id]) : '' ?></td>    
					<td>
						<?= $this->Form->create($employeeCategory,['class'=>'saveAjax', 'data-responce'=>'.alert-wrap']) ?>
						<?php echo $this->Form->control('employee_category_order', ['required'=>false, 'label'=>false, 'class'=>'form-control ajaxChangeOrder','value'=>$employeeCategory->employee_category_order]); ?>
						<?php echo $this->Form->control('id', ['required'=>false, 'label'=>false, 'type'=>'hidden','value'=>$employeeCategory->id]); ?>
						<?= $this->Form->end() ?>
					</td>						
                <td class="actions">
					<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $employeeCategory->id],['escape'=>false, 'title' => 'View']) ?>
					<?php if($employeeCategory->created_by == $activeUser['id'] || $activeUser['role_id'] == SUPER_ADMIN || $activeUser['role_id'] == ADMIN) { ?>
					<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $employeeCategory->id],['escape'=>false, 'title' => 'Edit']) ?>
					<?php if($activeUser['role_id'] != ADMIN) { ?>					
					<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $employeeCategory->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $employeeCategory->id)]) ?>
					<?php }} ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    	</div>
</div>
</div>
</div>