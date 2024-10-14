<?php
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
?>
<div class="row leads">
<div class="col-lg-6">
<div class="card">
    <div class="card-header">
        <strong>Upload Contractor </strong> List

    </div>
    <div class="card-body card-block">
        <div class="alert alert-info" role="alert">
        <span>Please download the template for uploading preformatted supplier list.</span>
            <a href="<?= $uploaded_path ?>template_leads_upload.xlsx" target="_Blank"><button type="button" class="btn btn-primary"><i class="fa fa-cloud-download"></i> Click Here</button></a>
        </div>
        <?= $this->Form->create(null,['type' => 'file']); ?>
        <div class="form-group">
            <?= $this->Form->label('Upload File', null, ['form-label']); ?>
            <?= $this->Form->control('file', ['type' => 'file', 'label'=>false ]);?>
        </div>
        <?php if($this->User->isClient()){ }else{ ?>
        <div class="form-group">
        <?= $this->Form->control('client_id', ['options' => $clients, 'empty' => false, 'class'=>'form-control', 'id' => 'client_id', 'onchange' => 'this.form.submit()']); ?>
        </div>
        <?php } ?>
        <div class="form-group">
            <?= $this->Form->control('site_id', ['options' => $locations, 'empty' => true, 'label'=>'Select Location', 'class'=>'form-control']); ?>
        </div>
        <div class="form-group">
            <?=  $this->Form->button('Import',['class'=>'btn btn-success']); ?>
        </div>
            <?= $this->Form->end(); ?>
    </div>
</div>
</div>
</div>
<script>
    jQuery(document).ready(function(){
        jQuery("#client_id").change(function(){
            jQuery.ajax({
                headers: { 'X-CSRF-TOKEN': csrfToken },
                type: "POST",
                url: '/sites/getSitesList',
                async: true,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {


                }
            });
        });
    });
</script>
