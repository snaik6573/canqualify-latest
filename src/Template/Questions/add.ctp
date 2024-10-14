<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Question $question
 */
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
?>
<div class="row questions">
<div class="col-lg-8">
<div class="card">
	<div class="card-header">
		<strong>Add New</strong> Question
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create($question, ['type' => 'file']) ?>
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
        <div class="row form-group">
            <?= $this->Form->label('Document', null, ['class'=>'col-sm-3']); ?><br />
            <?= $this->Form->control('document', ['type' => 'file', 'label'=>false ]);?>
            <!--<div class="col-sm-9 uploadWraper">
		   <?php //echo $this->Form->control('document', ['label'=>false, 'type'=>'hidden', 'class'=>'documentName']); ?>
		   <?php //echo $this->Form->file('uploadFile', ['label'=>false ,'accept'=>'.images/*, .pdf,.xls, .xlsx, .doc']); ?>
		   <div class="uploadResponse"></div>
		   </div>-->
        </div>
        <div class="form-group">
            <?php echo $this->Form->control('category_id', ['class'=>'form-control searchSelect ajaxChange', 'options' => $categories, 'empty' => true, 'data-url'=>'/questions/getQuestions', 'data-responce'=>'.ajax-questions']); ?>
		</div>
		<!--<div class="form-group">
			<?= $this->Form->control('client_id', ['class'=>'form-control', 'options' => $clients, 'empty' => true]) ?>
		</div>-->
		<div class="form-group">
			<?= $this->Form->control('client_based', ['class'=>'', 'label'=>'Is Client Based']) ?>
		</div>
        <hr />
		<div class="form-group">
			<?= $this->Form->control('ques_order', ['class'=>'form-control', 'label'=>'Sort Order']) ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('show_on_register_form', ['class'=>'']) ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('active', ['class'=>'', 'checked'=>'checked']) ?>
		</div>
        <hr />
        <b>For Dependent Questions :</b>
		<div class="form-group">
			<?= $this->Form->control('is_parent', ['class'=>'', 'label'=>'Is Parent Question']) ?>
		</div>
        <b>If Sub Question :</b>
		<div class="form-group ajax-questions">
		</div>
		<div class="form-group ajax-responce">
		</div>
		<div class="form-actions form-group">
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']) ?>
			<?= $this->Form->button('<em><i class="fa fa-ban"></i></em> Reset', ['type' => 'reset', 'class'=>'btn btn-danger btn-sm']) ?>
		</div>
	<?= $this->Form->end() ?>
	</div>
</div>
</div>
</div>