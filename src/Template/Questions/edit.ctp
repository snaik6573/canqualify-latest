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
	<div class="card-header clearfix">
		<strong>Edit</strong> Question
		<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
		<span class="pull-right"><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $question->id], ['class'=>'btn btn-danger btn-sm', 'confirm' => __('Are you sure you want to delete # {0}?', $question->id)]) ?></span>
		<?php } ?>
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
        <div class="form-group">
            <?php
            if(!empty($question->document)){
                echo $this->Form->label('Uploaded Document', null, ['class'=>'col-sm-3 pl-0']);
                echo $this->Form->control('old_document', ['value'=>$question->document, 'label'=>false, 'type'=>'hidden']);
            echo $this->Html->link($question->document, '/uploads/help_files/'.$question->document,array('download'=>$question->document, 'target' => '_blank'));

            }
            ?>
        </div>
        <div class="form-group">
            <?php
            echo $this->Form->label('Document', null, ['class'=>'col-sm-3 pl-0']);
            echo $this->Form->control('document', ['type' => 'file', 'label'=>false ]);
            ?>
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
			<?= $this->Form->control('question_id', ['class'=>'form-control searchSelect ajaxChange', 'options' => $questions, 'empty' => true, 'label'=>'Select Parent Question', 'data-url'=>'/questions/getOptions', 'data-responce'=>'.ajax-responce']) ?>
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
</div>
</div>
</div>
