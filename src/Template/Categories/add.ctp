<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */
?>
<div class="row categories">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<strong>Add New</strong> Category
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create($category) ?>
		<div class="form-group">
			<?php echo $this->Form->control('name', ['class'=>'form-control', 'required'=>false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('description', ['class'=>'form-control']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('active', ['checked'=>'checked']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('service_id', ['class'=>'form-control', 'options' => $services, 'empty' => false]); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('year_based', ['class'=>'']); ?>
		</div>		
        <div class="form-group">
			<?php echo $this->Form->control('category_order', ['class'=>'form-control']); ?>
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
			<?php echo $this->Form->control('category_id', ['label'=>'Select Parent Category', 'class'=>'form-control parent-cat', 'options' => $categories, 'empty' => true]); ?>
		</div>
		<div class="form-group row from-to" style="display: none;">
			<div class="col-lg-6">
			<?php echo $this->Form->control('from_year', ['class'=>'form-control from-year','type'=>'text']); ?></div>
			<div class="col-lg-6">
			<?php echo $this->Form->control('to_year', ['class'=>'form-control to-year','type'=>'text']); ?></div>
		</div>
		<div class="form-actions form-group">
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
			<?= $this->Form->button('<em><i class="fa fa-ban"></i></em> Reset', ['type' => 'reset', 'class'=>'btn btn-danger btn-sm']); ?>
		</div>
	</div>
</div>
</div>
</div>