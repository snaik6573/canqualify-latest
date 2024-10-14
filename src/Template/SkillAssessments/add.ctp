<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SkillAssessment $skillAssessment
 */
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
$users = array(SUPER_ADMIN,ADMIN,CONTRACTOR,CONTRACTOR_ADMIN,EMPLOYEE);
?>
<div class="row skillAssessment">
<div class="col-lg-12">
<div class="card">
    <div class="card-header">
        <strong>Add Skill Assessment Certificates</strong>
    </div>
    <div class="card-body card-block">
    <?= $this->Form->create($skillAssessment, array('type'=>'file')) ?>
        <div class="row appendDivClass">        
        <div class="col-sm-3">
            <div class="form-group">                    
                <?php echo $this->Form->control('skillAssessments.0.name', ['label'=>'Document Name','class'=>'form-control docName', 'required'=>'true']); ?>
            </div>
        </div>      
        <div class="col-sm-3">
            <div class="form-group uploadWraper">
            <?= $this->Form->label('Document', null, ['class'=>'col-form-label']); ?><br />
            <?php echo $this->Form->control('skillAssessments.0.document', ['label'=>false, 'type'=>'hidden', 'class'=>'documentName','data-assess'=>'skillAssessments']); ?>
            <?php echo $this->Form->file('skillAssessments.0.uploadFile', ['label'=>false, 'accept'=>'.images/*, .pdf,.xls, .xlsx, .doc', 'required'=>'true']); ?>
            <div class="uploadResponse"></div>
            </div>
        </div>          
        <div class="col-sm-2">
            <?= $this->Form->control('skillAssessments.0.training_date', ['type'=>'text','class'=>'form-control setDate docName','label'=>'Training date', 'placeholder'=>'Training date']) ?>
        </div>
        <div class="col-sm-2">
            <?= $this->Form->control('skillAssessments.0.expiration_date', ['type'=>'text', 'class'=>'form-control setDate docName','label'=>'Expiration date', 'placeholder'=>'Expiration date']) ?>
        </div>
        <div class="col-sm-2">
            <?= $this->Form->button('<em><i class="fa fa-plus-square"></i></em> Add More', ['type'=>'button', 'class'=>'addUploadBoxEmp btn btn-success', 'style'=>'margin:30px 0 0 0;', 'data-fieldname'=>'skillAssessments']); ?>
        </div>
        </div>      
        <div class="form-actions form-group">           
        <?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary']); ?>
        </div>
    <?= $this->Form->end() ?>
    </div>
</div>
</div>
<?php if(isset($skillAssessments) && !empty($skillAssessments)) { ?>
    <div class="col-lg-12">
    <div class="card">
    <div class="card-header"><strong>Contractor Skill Assessment Certificates</strong></div>
    <div class="card-body">
    <table id="bootstrap-data-table" class="table table-striped table-bordered"  data-order="[[ 4, &quot;desc&quot; ]]">
    <thead>
    <tr>
        <th scope="col"><?= h('name') ?></th>
        <th scope="col"><?= h('document') ?></th>       
        <th scope="col"><?= h('Training Date') ?></th>
        <th scope="col"><?= h('Expiration Date') ?></th>
        <th scope="col"><?= h('created') ?></th>
        <th scope="col" class="actions"><?= __('Actions') ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($skillAssessments as $skillAssessment): ?>
    <tr>
        <td><?= h($skillAssessment->name) ?></td>
        <td><a href="<?php echo $uploaded_path.'skill_assessments/'.$skillAssessment->document;?>" target="_Blank"><?= $skillAssessment->document ?></a></td>
        <td><?= h($skillAssessment->training_date) ?></td>
        <td><?= h($skillAssessment->expiration_date) ?></td>
        <td><?= h($skillAssessment->created) ?></td>    
        <td class="actions">
        <?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $skillAssessment->id],['escape'=>false, 'title' => 'View']) ?>
        <?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $skillAssessment->id],['escape'=>false, 'title' => 'Edit']) ?>
        <?php if (in_array($activeUser['role_id'], $users)) { ?>
        <?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $skillAssessment->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $skillAssessment->id)]) ?>
        <?php } ?>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
    </table>
    </div>
    </div>
    </div>
    <?php } ?>
</div>