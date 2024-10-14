<?php
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');

    !empty($question->training_answers) ? $val=$question->training_answers[0]->answer : $val='' ;
    $filenmArr = array();
    $filenmArr[] = preg_replace('/\s/', '', $training->name);
    $filenmArr[] = $activeUser['employee_id'];
    $filenmArr[] = $question->id;
    $filenmHandle = implode('-', $filenmArr);
    $fileCss = $val!='' ? "display:none;" : "";
    ?>
    <div class="col-sm-12 uploadWraper">
        <?php echo $this->Form->control('training_answers.'.$key.'.answer', ['value'=>$val, 'label'=>false, 'type'=>'hidden', 'class'=>'documentName']); ?>
        <?php echo $this->Form->file('training_answers.'.$key.'.uploadFile', ['label'=>false, 'accept' => '.images/*, .pdf,.xls, .xlsx', 'style'=> $fileCss]); ?>
        <div class="uploadResponse">
        <?php if($val!='') { ?>
        <a href="<?= $uploaded_path.$val ?>" class="uploadUrl" data-file="<?= $val ?>" target="_Blank"><?= $val ?></a>
        <?= $this->Html->link('<i class="fa fa-times-circle"></i>', ['controller'=>'Uploads', 'action' => 'deleteFile', $val], ['escape'=>false, 'title' => 'Remove', 'class'=>'ajaxfileDelete btn btn-sm']);?>
        <?php
        }
        ?>
        </div>
        <?= $this->Form->control('training_answers.'.$key.'.filenmHandle', ['type'=>'hidden', 'value'=>$filenmHandle, 'class'=>'filenmHandle']); ?>
        <?= $this->Form->control('training_answers.'.$key.'.training_questions_id', ['type'=>'hidden', 'value'=>$question->id]); ?>
    </div>
