<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmployeeQuestion[]|\Cake\Collection\CollectionInterface $employeeQuestions
 */
?>
<div class="row employeeQuestions">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Employee Questions') ?></strong>
		<span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller' => 'EmployeeQuestions', 'action' => 'add'],['class'=>'btn btn-success btn-sm']) ?> </span>
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th scope="col"><?= h('Id') ?></th>
                <th scope="col"><?= h('Question') ?></th>
                <th scope="col"><?= h('Active') ?></th>
                <th scope="col"><?= h('Is Parent') ?></th>
                <th scope="col"><?= h('Category') ?></th>
                <th scope="col"><?= h('Order') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employeeQuestions as $employeeQuestion): ?>
            <tr>
                <td><?= $this->Number->format($employeeQuestion->id) ?></td>
                <td><?= h($employeeQuestion->question) ?></td>
                <td><?= $employeeQuestion->active ? __('Yes') : __('No'); ?></td>
                <td><?= $employeeQuestion->is_parent ? __('Yes') : __('No'); ?></td>
                <td><?= $employeeQuestion->has('employee_category') ? $this->Html->link($employeeQuestion->employee_category->name, ['controller' => 'EmployeeCategories', 'action' => 'view', $employeeQuestion->employee_category->id]) : '' ?></td>
                
                <td>
					<?= $this->Form->create($employeeQuestion,['class'=>'saveAjax', 'data-responce'=>'.alert-wrap']) ?>
					<?= $this->Form->control('ques_order', ['required'=>false, 'label'=>false, 'class'=>'form-control ajaxChangeOrder','value'=>$employeeQuestion->ques_order]); ?>
					<?= $this->Form->control('id', ['required'=>false, 'label'=>false, 'type'=>'hidden','value'=>$employeeQuestion->id]); ?>
					<?= $this->Form->end() ?>
                </td>
                <td class="actions">
					<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $employeeQuestion->id],['escape'=>false, 'title' => 'View']) ?>                    
					<?php if($employeeQuestion->created_by == $activeUser['id'] || $activeUser['role_id'] == SUPER_ADMIN || $activeUser['role_id'] == ADMIN) { ?>
					<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $employeeQuestion->id],['escape'=>false, 'title' => 'Edit']) ?>	
                    <?php if($activeUser['role_id'] != ADMIN) { ?>			
					<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $employeeQuestion->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $employeeQuestion->id)]) ?>
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