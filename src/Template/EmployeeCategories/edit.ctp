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
		<strong>Edit</strong> Employee Category
	</div>
	<div class="card-body card-block">
    <?= $this->Form->create($employeeCategory) ?>
		<div class="form-group">
			<?php echo $this->Form->control('name', ['class'=>'form-control', 'required'=>false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('description', ['class'=>'form-control', 'required'=>false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('active', ['class'=>'']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('employee_category_order', ['class'=>'form-control', 'required'=>false]); ?>
		</div>	
		<hr />
        <b>For Nested Categories :</b><br/>
        <b>If Parent Category :</b>
		<div class="form-group">
			<?php echo $this->Form->control('is_parent', ['label'=>'Is Parent Category']); ?>
		</div>
        <hr />
        <b>If Sub Category :</b>
		<div class="form-group">
			<?php echo $this->Form->control('employee_category_id', ['label'=>'Select Parent Category', 'class'=>'form-control', 'options' => $employeeCategories, 'empty' => true]); ?>
		</div>
		<div class="form-actions form-group">
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
		</div>
    <?= $this->Form->end() ?>
	</div>
</div>
</div>
</div>