<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContractorAnswer $contractorAnswer
 */
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
?>
<?php if($is_locked==0 && $is_archived==0): ?>
<div class="row contractorAnswers">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong><?= h($category->name). ' - '.$year ?></strong> Add Answers
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create($contractorAnswer, array('type' => 'file')) ?>

	<?php foreach($questions as $key => $clientQuestion) : ?>
	<div class="form-group row">
		<div class="col-sm-12"><label class="form-control-label"><?= h($clientQuestion->question->question) ?></label>
		<p class="hint"><?= $clientQuestion->question->help ?></p>
		</div>
		<?= $this->element('Question_Type/'.$clientQuestion->question->question_type->name, ["key" => $key,"question" => $clientQuestion->question]) ?>
	</div>
	<hr/>
	<?php endforeach; ?>
	<?php $categories = $this->Category->getCategories($activeUser, $service_id); 
	 $getNextcat = $this->Category->getNextcat($categories, $category_id,$service_id,$year);	 
	?>
	<div class="form-actions form-group">
	<?php echo $this->Form->control('nextCat', ['type' => 'hidden', 'value' => $getNextcat]); ?>
	<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Save and Continue', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']) ?>
	</div>
	
	</div>
	<?= $this->Form->end() ?>
	</div>
</div>
</div>
</div>
<?php else: ?>
<div class="row contractorAnswers">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong><?= h($category->name). ' - '.$year ?></strong> Answers
	</div>
	<div class="card-body card-block">

	<?php foreach($questions as $key => $clientQuestion): ?>
	<div class="card">
		<div class="card-header">
			<?= $clientQuestion->has('question') ? h($clientQuestion->question->question) : '' ?></td>
		</div>
		<div class="card-body card-block">
			<?php
			$question_type = $clientQuestion->question->question_type->name;
			$contractor_answers = $clientQuestion->question->contractor_answers;			
			if($question_type == 'file') {
				foreach($contractor_answers as $answer) {
					$answer->answer = explode(',',$answer->answer);
					foreach($answer->answer as $answer) {
						echo '<a href="'.$uploaded_path.$answer.'" target="_Blank">'.$answer.'</a>';
					}
				}
			}
			elseif($question_type == 'select' || $question_type == 'checkbox') {
				foreach($contractor_answers as $answer) {
					$answer->answer = explode(',',$answer->answer);
					foreach($answer->answer as $answer) {
						echo $this->Text->autoParagraph(h($answer));
					}
				}
			}
			else {
				foreach($contractor_answers as $answer) {
					echo $this->Text->autoParagraph(h($answer->answer));
				}
			}
			?>
		</div>
	</div>
	<?php endforeach; ?>
	</div>
</div>
</div>
</div>
<?php endif; ?>
