<?php
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');

$filenmArr = array();
//$filenmArr[] = preg_replace('/\s/', '', $category->name);
//if($year!='') { $filenmArr[] = $year; }
//$filenmArr[] = $contractor_id;
$filenmArr[] = $question->id;
$filenmHandle = implode('-', $filenmArr);

$fileCss = $answer!='' ? "display:none;" : "";
?>
<div class="col-sm-12 uploadWraper">
	<?php echo $this->Form->control('client_questions.'.$key.'.correct_answer', ['value'=>$answer, 'label'=>false, 'type'=>'hidden', 'class'=>'documentName']); ?>
	<?php echo $this->Form->file('client_questions.'.$key.'.uploadFile', ['label'=>false, 'accept' => '.images/*, .pdf,.xls, .xlsx', 'style'=> $fileCss]); ?>
	<div class="uploadResponse">
	<?php if($answer!='') { ?>
	<a href="<?= $uploaded_path.$answer ?>" class="uploadUrl" data-file="<?= $answer ?>" target="_Blank"><?= $answer ?></a>
	<?= $this->Html->link('<i class="fa fa-times-circle"></i>', ['controller'=>'Uploads', 'action' => 'deleteFile', $answer], ['escape'=>false, 'title' => 'Remove', 'class'=>'ajaxfileDelete btn btn-sm']);?>
	<?php
	}
	?>
	</div>
	<?= $this->Form->control('client_questions.'.$key.'.filenmHandle', ['type'=>'hidden', 'value'=>$filenmHandle, 'class'=>'filenmHandle']); ?>
	<?= $this->Form->control('client_questions.'.$key.'.question_id', ['type'=>'hidden', 'value'=>$question->id]); ?>
</div>
