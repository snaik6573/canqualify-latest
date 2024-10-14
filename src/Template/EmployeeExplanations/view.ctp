<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmployeeExplanation $employeeExplanation
 */
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
?>
<div class="row formsNDocs">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= h($employeeExplanation->name) ?></strong>
	</div>
	<div class="card-body card-block">
	<table class="table">
	<tr>
		<th scope="row"><?= __('Name') ?></th>
		<td><?= h($employeeExplanation->name) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Training Date') ?></th>
		<td><?= h($employeeExplanation->training_date) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Expiration Date') ?></th>
		<td><?= h($employeeExplanation->expiration_date) ?></td>
	</tr>
	<tr>
        <th scope="row"><?= __('Employee') ?></th>
        <td><?= $employeeExplanation->has('employee') ? $this->Html->link($employeeExplanation->employee->id, ['controller' => 'Employees', 'action' => 'view', $employeeExplanation->employee->id]) : '' ?></td>
    </tr>
	<tr>
		<th scope="row"><?= __('Id') ?></th>
        <td><?= $this->Number->format($employeeExplanation->id) ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Created By') ?></th>
        <td><?= $this->Number->format($employeeExplanation->created_by) ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Modified By') ?></th>
        <td><?= $this->Number->format($employeeExplanation->modified_by) ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Created') ?></th>
        <td><?= h($employeeExplanation->created) ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Modified') ?></th>
        <td><?= h($employeeExplanation->modified) ?></td>
    </tr>
	</table>
	</div>
</div>
</div>
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Document') ?></strong>
	</div>
	<div class="card-body card-block">
		<?= $this->Text->autoParagraph(h($employeeExplanation->document)); ?>
	</div>
</div>
</div>
</div>
