<?php
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
    if($question['client_based']) {
    foreach($question['client_employee_questions'] as $k => $v) {
       $val = isset($answer[$v->client_id]) ? $answer[$v->client_id] : '';       
       $filenmArr = array();
       $filenmArr[] = preg_replace('/\s/', '', $category->name);
       $filenmArr[] = $employee_id;
       $filenmArr[] = $question->id;
       $filenmHandle = implode('-', $filenmArr);       
       $fileCss = $val!='' ? "display:none;" : "";
       ?>
        <div class="col-sm-12 client_based_answers">
	    <div class="row">
	    <div class="col-sm-3 mb-2">
		<strong><?= h($v['client']['company_name']) ?></strong>
	    </div>
       <div class="col-sm-9 uploadWraper">
            <?php echo $this->Form->control('employee_answers.'.$key.'.'.$k.'.answer', ['value'=>$val, 'label'=>false, 'type'=>'hidden', 'class'=>'documentName']); ?>
            <?php echo $this->Form->file('employee_answers.'.$key.'.'.$k.'.uploadFile', ['label'=>false, 'accept' => '.images/*, .pdf,.xls, .xlsx', 'style'=> $fileCss]); ?>
            <div class="uploadResponse">
            <?php if($val!='') { ?>
            <a href="<?= $uploaded_path.$val ?>" class="uploadUrl" data-file="<?= $val ?>" target="_Blank"><?= $val ?></a>
            <?= $this->Html->link('<i class="fa fa-times-circle"></i>', ['controller'=>'Uploads', 'action' => 'deleteFile', $val], ['escape'=>false, 'title' => 'Remove', 'class'=>'ajaxfileDelete btn btn-sm']);?>
            <?php
            }
            ?>
            </div>
            <?= $this->Form->control('employee_answers.'.$key.'.'.$k.'.client_id', ['type'=>'hidden', 'value'=>$v->client_id]) ?>
            <?= $this->Form->control('employee_answers.'.$key.'.'.$k.'.filenmHandle', ['type'=>'hidden', 'value'=>$filenmHandle, 'class'=>'filenmHandle']); ?>
            <?= $this->Form->control('employee_answers.'.$key.'.'.$k.'.employee_question_id', ['type'=>'hidden', 'value'=>$v->employee_question_id]); ?>
       </div>
   <?php
   }?>
  </div>
  </div>	
<?php }
else {
    $val = $answer[0];
    $filenmArr = array();
    $filenmArr[] = preg_replace('/\s/', '', $category->name);
    $filenmArr[] = $employee_id;
    $filenmArr[] = $question->id;
    $filenmHandle = implode('-', $filenmArr);
	$fileCss = $val!='' ? "display:none;" : "";
    ?>
    <div class="col-sm-12 uploadWraper">
        <?php echo $this->Form->control('employee_answers.'.$key.'.answer', ['value'=>$val, 'label'=>false, 'type'=>'hidden', 'class'=>'documentName']); ?>
        <?php echo $this->Form->file('employee_answers.'.$key.'.uploadFile', ['label'=>false, 'accept' => '.images/*, .pdf,.xls, .xlsx', 'style'=> $fileCss]); ?>
        <div class="uploadResponse">
        <?php if($val!='') { ?>
        <a href="<?= $uploaded_path.$val ?>" class="uploadUrl" data-file="<?= $val ?>" target="_Blank"><?= $val ?></a>
        <?= $this->Html->link('<i class="fa fa-times-circle"></i>', ['controller'=>'Uploads', 'action' => 'deleteFile', $val], ['escape'=>false, 'title' => 'Remove', 'class'=>'ajaxfileDelete btn btn-sm']);?>
        <?php
        }
        ?>
        </div>
        <?= $this->Form->control('employee_answers.'.$key.'.filenmHandle', ['type'=>'hidden', 'value'=>$filenmHandle, 'class'=>'filenmHandle']); ?>
        <?= $this->Form->control('employee_answers.'.$key.'.employee_question_id', ['type'=>'hidden', 'value'=>$question->id]); ?>
    </div>
    <?php
}
?>
