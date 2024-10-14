<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmployeeSite $employeeSite
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Employee Site'), ['action' => 'edit', $employeeSite->id]) ?> </li>
		<?php if($activeUser['role_id'] != ADMIN) { ?>
        <li><?= $this->Form->postLink(__('Delete Employee Site'), ['action' => 'delete', $employeeSite->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employeeSite->id)]) ?> </li>
        <?php } ?>
		<li><?= $this->Html->link(__('List Employee Sites'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Employee Site'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Employees'), ['controller' => 'Employees', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Employee'), ['controller' => 'Employees', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sites'), ['controller' => 'Sites', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Site'), ['controller' => 'Sites', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="employeeSites view large-9 medium-8 columns content">
    <h3><?= h($employeeSite->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Employee') ?></th>
            <td><?= $employeeSite->has('employee') ? $this->Html->link($employeeSite->employee->id, ['controller' => 'Employees', 'action' => 'view', $employeeSite->employee->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Site') ?></th>
            <td><?= $employeeSite->has('site') ? $this->Html->link($employeeSite->site->name, ['controller' => 'Sites', 'action' => 'view', $employeeSite->site->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($employeeSite->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($employeeSite->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified By') ?></th>
            <td><?= $this->Number->format($employeeSite->modified_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($employeeSite->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($employeeSite->modified) ?></td>
        </tr>
    </table>
</div>
