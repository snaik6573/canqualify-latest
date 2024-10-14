<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmployeeCategory $employeeCategory
 */
?>
<div class="row employeeCategories">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= h($employeeCategory->name) ?>
	</div>
	<div class="card-body card-block">
	<table class="table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($employeeCategory->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($employeeCategory->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Parent') ?></th>
			  <td><?= $employeeCategory->employee_category_id !=0 ? $this->Html->link($employeeCategory->employee_category_id, ['action' => 'view', $employeeCategory->employee_category_id]) : '' ?></td></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Active') ?></th>
            <td><?= $employeeCategory->active ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= h($employeeCategory->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified By') ?></th>
            <td><?= h($employeeCategory->modified_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($employeeCategory->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($employeeCategory->modified) ?></td>
        </tr>
    </table>
	</div>
</div>
</div>
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= __('Description') ?>
	</div>
	<div class="card-body card-block">
		<?= $this->Text->autoParagraph(h($employeeCategory->description)); ?>
	</div>
</div>
</div>
</div>

<div class="row related">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<?= __('Related Employee Questions') ?>
	</div>
	<div class="card-body card-block">
	<?php if (!empty($employeeCategory->employee_questions)): ?>
	<table class="bootstrap-data-table-export table table-striped table-bordered">
		<thead>
		<tr>
			<th scope="col"><?= __('Id') ?></th>
			<th scope="col"><?= __('Question') ?></th>
			<th scope="col"><?= __('Active') ?></th>
			<th scope="col" class="actions"><?= __('Actions') ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($employeeCategory->employee_questions as $employeeQuestions): ?>
		<tr>
			<td><?= h($employeeQuestions->id) ?></td>
			<td><?= h($employeeQuestions->question) ?></td>
			<td><?= $employeeQuestions->active ? __('Yes') : __('No'); ?></td>
			<td class="actions">
			<?= $this->Html->link('<i class="fa fa-eye"></i>', ['controller' => 'EmployeeQuestions', 'action' => 'view', $employeeQuestions->id],['escape'=>false, 'title' => 'View']) ?>
			<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['controller' => 'EmployeeQuestions', 'action' => 'edit', $employeeQuestions->id],['escape'=>false, 'title' => 'Edit']) ?>
			<?php if($activeUser['role_id'] == SUPER_ADMIN ) { ?>
			<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['controller' => 'EmployeeQuestions', 'action' => 'delete', $employeeQuestions->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $employeeQuestions->id)]) ?>
			<?php } ?>
			</td>
		</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<?php endif; ?>
	</div>
</div>
</div>
</div>

<div class="row related">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<?= __('Sub Employee Categories') ?>
	</div>
	<div class="card-body card-block">
	<?php if (!empty($sub_cat)): ?>
	<table class="bootstrap-data-table-export table table-striped table-bordered">
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
            <?php foreach ($sub_cat as $employeeCategories): ?>
            <tr>
					<td><?= $this->Number->format($employeeCategories->id) ?></td>
					<td><?= h($employeeCategories->name) ?></td>
					<td><?= $employeeCategories->active ? __('Yes') : __('No'); ?></td>
					<td><?= $employeeCategories->employee_category_id !=0 ? $this->Html->link($employeeCategories->employee_category_id, ['action' => 'view', $employeeCategories->employee_category_id]) : '' ?></td>    
					<td>
						<?= $this->Form->create($employeeCategories,['class'=>'saveAjax', 'data-responce'=>'.alert-wrap']) ?>
						<?php echo $this->Form->control('employee_category_order', ['required'=>false, 'label'=>false, 'class'=>'form-control ajaxChange','value'=>$employeeCategories->employee_category_order]); ?>
						<?php echo $this->Form->control('id', ['required'=>false, 'label'=>false, 'type'=>'hidden','value'=>$employeeCategories->id]); ?>
						<?= $this->Form->end() ?>
					</td>						
                <td class="actions">
					<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $employeeCategories->id],['escape'=>false, 'title' => 'View']) ?>
					<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $employeeCategories->id],['escape'=>false, 'title' => 'Edit']) ?>
					<?php if($activeUser['role_id'] == SUPER_ADMIN ) { ?>
					<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $employeeCategories->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $employeeCategories->id)]) ?>
					<?php } ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>
</div>
</div>