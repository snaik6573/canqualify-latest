<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Question $question
 */
?>
<?= $this->Form->control('question_id', ['class'=>'form-control searchSelect ajaxChange', 'options' => $questions, 'empty' => true, 'label'=>'Select Parent Question', 'data-url'=>'/questions/getOptions', 'data-responce'=>'.ajax-responce']); ?>
