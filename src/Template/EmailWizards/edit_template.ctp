<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmailWizard $emailWizard
 */
?>
<div class="row">
<div class="col-lg-12">
<div class="card shadow  bg-white rounded">
    <div class="card-header">
        <strong>Edit Email</strong> Template
    </div>
     <div class="card-body">
            <?= $this->Form->create($emailTemplates) ?>
            <div class="form-group">
                <?= $this->Form->label('name', 'Template Name', ['class' => 'font-weight-bold']); ?>
                <?= $this->Form->control('name', ['class'=>'form-control', 'required'=>true,'label'=>false]); ?>
            </div>
            <div class="form-group">
                <?= $this->Form->label('template_content', 'Template', ['class' => 'font-weight-bold']); ?>
                <div id="toolbar">
                    <span class="ql-formats">
                        <select class="ql-header" defaultValue="">
                            <option value="1"></option>
                            <option value="2"></option>
                            <option value="3"></option>
                            <option value=""></option>
                        </select>
                        <select class="ql-font" defaultValue=""></select>
                        <select class="ql-size" defaultValue="">
                            <option value="small"></option>
                            <option value=""></option>
                            <option value="large"></option>
                            <option value="huge"></option>
                        </select>
                    </span>
                    <span class="ql-formats">
                        <button class="ql-bold"></button>
                        <button class="ql-italic"></button>
                        <button class="ql-underline"></button>
                        <button class="ql-strike"></button>
                        <button class="ql-blockquote"></button>
                    </span>
                    <span class="ql-formats">
                        <select class="ql-placeholder">
                            <option value="pri_contact_fname">Primary First Name</option>
                            <option value="pri_contact_lname">Primary Last Name</option>
                            <option value="supplier_name">Suppiler Name</option>
                            <option value="client_company_name">Client Company Name</option>
                        </select>
                    </span>
                </div>
                <div id="editor"></div>
            </div>
            <div class="form-group">
                <?= $this->Form->control('template_content', ['type'=>'hidden','class'=>'template-code','id'=>'template-content']); ?>
                  <?= $this->Form->control('quill_delta', ['type'=>'hidden','class'=>'template-code','id'=>'delta-code']); ?>
                <?= $this->Form->button('<em><i class=""></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-success btn-sm']); ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
</div>
</div>
</div>


