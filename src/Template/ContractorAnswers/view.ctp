<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContractorAnswer $contractorAnswer
 */
use Cake\Core\Configure;
?>
<div class="row contractorAnswers">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= h($contractorAnswer->id) ?>
	</div>
	<div class="card-body card-block">
	<table class="table">
	<tr>
		<th scope="row"><?= __('Id') ?></th>
		<td><?= $this->Number->format($contractorAnswer->id) ?></td>
	</tr>
	<!--<tr>
		<th scope="row"><?= __('Contractor') ?></th>
		<td><?= $contractorAnswer->has('contractor') ? $this->Html->link($contractorAnswer->contractor->id, ['controller' => 'Contractors', 'action' => 'view', $contractorAnswer->contractor->id]) : '' ?></td>
	</tr>-->
	<tr>
		<th scope="row"><?= __('Year') ?></th>
		<td><?= h($contractorAnswer->year) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Created') ?></th>
		<td><?= h($contractorAnswer->created) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Modified') ?></th>
		<td><?= h($contractorAnswer->modified) ?></td>
	</tr>
	</table>
	</div>
</div>
</div>
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= __('Question') ?>
	</div>
	<div class="card-body card-block">
		<?= $contractorAnswer->has('question') ? h($contractorAnswer->question->question) : '' ?></td>
	</div>

	<div class="card-header">
		<?= __('Question Options') ?>
	</div>
	<div class="card-body card-block">
		<?= $contractorAnswer->has('question') ? $this->Text->autoParagraph(h($contractorAnswer->question->question_options)) : '' ?>
	</div>
</div>

<div class="card">
	<div class="card-header">
		<?= __('Answer') ?>
	</div>
	<div class="card-body card-block">
		<?php 
		$uploaded_path = Configure::read('uploaded_path');
		$question_type = $contractorAnswer->question->question_type->name;
		if($question_type == 'file') {
			$answers = explode(',',$contractorAnswer->answer);
			foreach($answers as $answer) {
				echo '<a href="'.$uploaded_path.$answer.'" target="_Blank">'.$answer.'</a>';
			}
		}
		elseif($question_type == 'select' || $question_type == 'checkbox') {
			$answers = explode(',',$contractorAnswer->answer);
			foreach($answers as $answer) {
				echo $this->Text->autoParagraph(h($answer));
			}
		}
		else {
			echo $this->Text->autoParagraph(h($contractorAnswer->answer));
		}?>
	</div>
</div>
</div>
</div>
