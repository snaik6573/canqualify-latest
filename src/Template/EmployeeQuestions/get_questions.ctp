<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Question $question
 */
?>
<?= $this->Form->control('employee_question_id', ['class'=>'form-control searchSelect ajaxChange', 'options' => $questions, 'empty' => true, 'label'=>'Select Parent Question', 'data-url'=>'/employeeQuestions/getOptions', 'data-responce'=>'.ajax-responce']); ?>
