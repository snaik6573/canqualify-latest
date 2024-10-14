<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Question $question
 */
?>
<?= $this->Form->control('parent_option', ['class'=>'form-control', 'options' => $questionOptions, 'label'=>'Show On Following Option']) ?>
