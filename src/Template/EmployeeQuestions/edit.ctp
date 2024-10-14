<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmployeeQuestion $employeeQuestion
 */
?>
<div class="row employeeQuestions">
<div class="col-lg-8">
<div class="card">
	<div class="card-header">
		<strong>Edit</strong> Employee Question
	</div>
	<div class="card-body card-block">
	<div class="employeeQuestions form large-9 medium-8 columns content">
    <?= $this->Form->create($employeeQuestion) ?>
		<div class="form-group">
			<?= $this->Form->control('question', ['class'=>'form-control note', 'required' => false]) ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('question_type_id', ['class'=>'form-control', 'options' => $questionTypes, 'empty' => false]) ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('question_options', ['class'=>'form-control']) ?>
		</div>		
		<div class="form-group">
			<?= $this->Form->control('allow_multiselect', ['class'=>'']) ?>
            <div>Note : If Question Type is <b>select</b>, contractor can select multiple options.</div>
		</div>
		<div class="form-group">
			<?= $this->Form->control('allow_multiple_answers', ['class'=>'']) ?>
            <div>Note : If Question Type is <b>input</b>, contractor can add multiple answers.</div>
		</div>
		<div class="form-group">
			<?= $this->Form->control('correct_answer', ['class'=>'form-control']) ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('help', ['class'=>'form-control', 'class'=>'note']) ?>
		</div>
        <div class="form-group">
            <?php echo $this->Form->control('employee_category_id', ['class'=>'form-control searchSelect ajaxChange', 'options' => $employeeCategories, 'empty' => true, 'data-url'=>'/employeeQuestions/getQuestions', 'data-responce'=>'.ajax-questions']); ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('client_based', ['class'=>'', 'label'=>'Is Client Based']) ?>
		</div>
        <hr />
		<div class="form-group">
			<?= $this->Form->control('ques_order', ['class'=>'form-control', 'label'=>'Sort Order']) ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('active', ['class'=>'']) ?>
		</div>
        <hr />
        <b>For Dependent Questions :</b>
		<div class="form-group">
			<?= $this->Form->control('is_parent', ['class'=>'', 'label'=>'Is Parent Question']) ?>
		</div>
        <b>If Sub Question :</b>
		<div class="form-group ajax-questions">
            <?php if(!empty($questions)) { ?>
				<?= $this->Form->control('employee_question_id', ['class'=>'form-control searchSelect ajaxChange', 'options' => $questions, 'empty' => true, 'label'=>'Select Parent Question', 'data-url'=>'/employeeQuestions/getOptions', 'data-responce'=>'.ajax-responce']); ?>
            <?php } ?>
		</div>
		<div class="form-group ajax-responce">
            <?php if(!empty($questionOptions)) { ?>
        	<?= $this->Form->control('parent_option', ['class'=>'form-control', 'options' => $questionOptions, 'label'=>'Show On Following Option']) ?>
            <?php } ?>
		</div>
		<div class="form-actions form-group">
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']) ?>
		</div>
    <?= $this->Form->end() ?>
</div>
