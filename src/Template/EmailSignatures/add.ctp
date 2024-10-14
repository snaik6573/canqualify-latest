<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmailSignature $emailSignature
 */
?>
<div class="row emailSignatures">
    <div class="col-lg-12">
        <div class="card shadow  bg-white rounded">
            <div class="card-header clearfix">
                <strong>Email</strong> Signature 
            </div>
            <div class="card-body">
                <div id='inputs'>
                <?= $this->Form->create($emailSignature) ?>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <?= $this->Form->label('signature_name', 'Signature Name', ['class' => 'font-weight-bold']); ?>
                           <?= $this->Form->control('signature_name', ['class'=>'form-control', 'required'=>false,'label'=>false]); ?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <?= $this->Form->label('name', 'Name', ['class' => 'font-weight-bold']); ?>
                            <?= $this->Form->control('name', ['id'=>'sign-name','class'=>'form-control', 'required'=>false,'label'=>false]); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <?= $this->Form->label('title', 'Title', ['class' => 'font-weight-bold']); ?>
                            <?= $this->Form->control('title', ['id'=>'title','class'=>'form-control', 'required'=>false,'label'=>false]); ?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <?= $this->Form->label('company_name', 'Company', ['class' => 'font-weight-bold']); ?>
                            <?= $this->Form->control('company_name', ['id'=>'company_name','class'=>'form-control', 'required'=>false,'label'=>false]); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <?= $this->Form->label('phone', 'Phone', ['class' => 'font-weight-bold']); ?>
                            <?= $this->Form->control('phone', ['class'=>'form-control ','id'=>'txtPhone', 'required'=>false,'label'=>false]); ?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <?= $this->Form->label('mobile', 'Mobile', ['class' => 'font-weight-bold']); ?>
                            <?= $this->Form->control('mobile', ['id'=>'mobile','class'=>'form-control', 'required'=>false,'label'=>false]); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <?= $this->Form->label('website', 'Website', ['class' => 'font-weight-bold']); ?>
                            <?= $this->Form->control('website', ['id'=>'website','class'=>'form-control', 'required'=>false,'label'=>false]); ?>
                        </div>
                        <div class="form-group">
                            <?= $this->Form->label('template_id', 'Templates', ['class' => 'font-weight-bold']); ?>
                            <?= $this->Form->control('template_id',['options'=>$templates,'empty'=>true, 'id'=>"myselection" ,'class'=>'form-control form-select', 'required'=>false,'label'=>false]); ?>
                        </div>
                            <div class="card-body card-block">
                            
                            <?= $this->element('signature_photo', ["emailSignature" => $emailSignature, "fieldname" => 'profile_photo']) ?>
                            <div class="form-actions form-group">
                                <?= $this->Form->control('signature_name_photo', ['type'=>'hidden']); ?>
                            </div>
                           
                            </div>
                    </div>
                    <div class="col-lg-6">
                         <div class="form-group">
                            <?= $this->Form->label('signature_email', 'Email', ['class' => 'font-weight-bold']); ?>
                            <?= $this->Form->control('signature_email', ['id'=>'signature_email','class'=>'form-control', 'required'=>false,'label'=>false]); ?>
                        </div>
                        <div class="form-group">
                            <?= $this->Form->label('address', 'Address', ['class' => 'font-weight-bold']); ?>
                            <?= $this->Form->control('address', ['id'=>'address','type' => 'textarea', 'escape' => false,'class'=>'form-control', 'required'=>false,'label'=>false]); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->control('template', ['type'=>'hidden','class'=>'template-data']); ?>
                    <?= $this->Form->button('<em><i class=""></i></em> Generate Signature', ['type' => 'button', 'data-prepare', 'class'=>'btn btn-success btn-sm signatue-generate']); ?>
                    <?= $this->Form->button('<em><i class=""></i></em> Save', ['type' => 'Submit', 'data-prepare', 'class'=>'btn btn-success btn-sm signatue-save']); ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
        </div>
    </div>
</div>

        <div id="show1" class="myDiv">
           
            <?php echo $this->element('Signatures/classic'); ?>
        </div>
        <div id="show2" class="myDiv">
            
            <?php echo $this->element('Signatures/horizontal'); ?>
        </div>
        <div id="show3" class="myDiv">
         
            <?php echo $this->element('Signatures/wide'); ?>
        </div>
        <div id="show4" class="myDiv">
            
            <?php echo $this->element('Signatures/compact'); ?>
        </div>
  
