<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmployeeQuestion $employeeQuestion
 */
?>
<div class="row employeeQuestions">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
	<?= h($employeeQuestion->id) ?>
	</div>
	<div class="card-body card-block">
	<table class="table">
        <tr>
            <th scope="row"><?= __('Question Type') ?></th>
            <td><?= $employeeQuestion->has('question_type') ? $this->Html->link($employeeQuestion->question_type->name, ['controller' => 'QuestionTypes', 'action' => 'view', $employeeQuestion->question_type->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Employee Category') ?></th>
            <td><?= $employeeQuestion->has('employee_category') ? $this->Html->link($employeeQuestion->employee_category->name, ['controller' => 'EmployeeCategories', 'action' => 'view', $employeeQuestion->employee_category->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Correct Answer') ?></th>
            <td><?= h($employeeQuestion->correct_answer) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Parent Option') ?></th>
            <td><?= h($employeeQuestion->parent_option) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($employeeQuestion->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ques Order') ?></th>
            <td><?= $this->Number->format($employeeQuestion->ques_order) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Employee Question Id') ?></th>
            <td><?= $this->Number->format($employeeQuestion->employee_question_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($employeeQuestion->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified By') ?></th>
            <td><?= $this->Number->format($employeeQuestion->modified_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($employeeQuestion->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($employeeQuestion->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Allow Multiselect') ?></th>
            <td><?= $employeeQuestion->allow_multiselect ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Allow Multiple Answers') ?></th>
            <td><?= $employeeQuestion->allow_multiple_answers ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Client Based') ?></th>
            <td><?= $employeeQuestion->client_based ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Parent') ?></th>
            <td><?= $employeeQuestion->is_parent ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Active') ?></th>
            <td><?= $employeeQuestion->active ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
	</div>
</div>
</div>
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
	<?= __('Question') ?>
	</div>
	<div class="card-body card-block">
	<?= $this->Text->autoParagraph(h($employeeQuestion->question)); ?>
	</div>

	<div class="card-header">
	<?= __('Question Options') ?>
	</div>
	<div class="card-body card-block">
	<?= $this->Text->autoParagraph(h($employeeQuestion->question_options)); ?>
	</div>

	<div class="card-header">
	<?= __('Help') ?>
	</div>
	<div class="card-body card-block">
	<?= $this->Text->autoParagraph(h($employeeQuestion->help)); ?>
	</div>
</div>
</div>
</div>

<div class="row related">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<?= __('Sub Employee Questions') ?>
	</div>
	<div class="card-body card-block">
	<?php if (!empty($subQuestions)): ?>
	<table class="bootstrap-data-table-export table table-striped table-bordered">
            <tr>
                <th scope="col"><?= h('id') ?></th>
                <th scope="col"><?= h('Question') ?></th>
                <th scope="col"><?= h('active') ?></th>
                <th scope="col"><?= h('Is Parent') ?></th>
                <th scope="col"><?= h('Category') ?></th>
                <th scope="col"><?= h('Order') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($subQuestions as $employeeQuestions): ?>
            <tr>
                <td><?= h($employeeQuestions->id) ?></td>
                <td><?= h($employeeQuestions->question) ?></td>
                <td><?= $employeeQuestions->active ? __('Yes') : __('No'); ?></td>
                <td><?= $employeeQuestions->is_parent ? __('Yes') : __('No'); ?></td>
                <td><?= $employeeQuestions->has('employee_category') ? $this->Html->link($employeeQuestions->employee_category->name, ['controller' => 'EmployeeCategories', 'action' => 'view', $employeeQuestions->employee_category->id]) : '' ?></td>
                <td><?= $this->Number->format($employeeQuestions->ques_order) ?></td>
                <td class="actions">
					<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $employeeQuestions->id],['escape'=>false, 'title' => 'View']) ?>
					<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $employeeQuestions->id],['escape'=>false, 'title' => 'Edit']) ?>
					<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
					<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $employeeQuestions->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $employeeQuestions->id)]) ?>
					<?php } ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
</div>
</div>