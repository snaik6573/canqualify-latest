<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SkillAssessment $skillAssessment
 */
use Cake\Core\Configure;
 $uploaded_path = Configure::read('uploaded_path');
 $users = array(SUPER_ADMIN,ADMIN,CONTRACTOR,CONTRACTOR_ADMIN,EMPLOYEE);
?>
<div class="row notes">
<div class="col-sm-6 col-md-6 col-lg-6">
<div class="card">
    <div class="card-header clearfix">
        <strong>Edit</strong> Skill Assessment Certificate
        <?php if (in_array($activeUser['role_id'], $users)) { ?>
        <span class="pull-right"><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $skillAssessment->id], ['class'=>'btn btn-danger btn-sm','confirm' => __('Are you sure you want to delete # {0}?', $skillAssessment->id)] )?></span>
        <?php } ?>
    </div>
<div class="card-body card-block">  
    <?= $this->Form->create($skillAssessment) ?>
        <div class="form-group">
            <?php echo $this->Form->control('name', ['class'=>'form-control','required'=>'true']); ?>
        </div>
        <div class="row form-group">
        <?php       
        !empty($skillAssessment->document) ? $val=$skillAssessment->document : $val='' ;        
        ?>
        <?php $fileCss = $val!='' ? "display:none;" : ""; ?>
        <div class="col-sm-12 uploadWraper">
            <?php echo $this->Form->control('document', ['value'=>$val, 'label'=>false, 'type'=>'hidden', 'class'=>'documentName','required'=>'true']); ?>
            <?php echo $this->Form->file('uploadFile', ['label'=>false,'style'=>$fileCss, 'accept' => '.images/*, .pdf,.xls, .xlsx']); ?>
            <div class="uploadResponse">
            <?php if($val!='') { ?>
            <a href="<?= $uploaded_path.$val ?>" class="uploadUrl" data-file="<?= $val ?>" target="_Blank"><?= $val ?></a>
            <?= $this->Html->link('<i class="fa fa-times-circle"></i>', ['controller'=>'Uploads', 'action' => 'deleteFile', $val], ['escape'=>false, 'title' => 'Remove', 'class'=>'ajaxfileDelete btn btn-sm']);?>
            <?php
            }
            ?>
            </div>          
        </div>      
        </div>  
        <div class="row form-group">
        <div class="col-lg-6">
            <?php 
            $trainingDate = ''; 
            $expirationDate = '';
            if(isset($skillAssessment->training_date)){
            $trainingDate = date('Y/n/d', strtotime($skillAssessment->training_date)); 
            }
            if(isset($skillAssessment->expiration_date)){
            $expirationDate = date('Y/n/d', strtotime($skillAssessment->expiration_date)); 
            }

            ?>
            <?php echo $this->Form->control('training_date', ['value'=>$trainingDate,'type'=>'text', 'class'=>'form-control setDate','label'=>'Training date', 'placeholder'=>'Training date']) ?>
        </div>      
        <div class="col-lg-6">
            <?php echo $this->Form->control('expiration_date', ['value'=>$expirationDate,'type'=>'text', 'class'=>'form-control setDate','label'=>'Expiration date', 'placeholder'=>'Expiration date']) ?>
        </div>
        </div>
        <div class="form-actions form-group">
            <?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
        </div>
    <?= $this->Form->end() ?>   
</div>

    </div>
</div>
</div>
