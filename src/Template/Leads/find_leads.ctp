<div class="row leads">
<div class="col-lg-6">
<div class="card">
    <div class="card-header">
        <strong>Upload Contractor </strong> List
    </div>
    <div class="card-body card-block">

      

        <?= $this->Form->create(null,['type' => 'file']); ?>
        
        <div class="form-group">
        <?= $this->Form->label('Upload File', null, ['col-form-label']); ?>
            <?= $this->Form->control('file1', ['type' => 'file', 'label'=>false ]);?>
        </div>

         <div class="form-group">
        <?= $this->Form->label('Upload File', null, ['col-form-label']); ?>
            <?= $this->Form->control('file2', ['type' => 'file', 'label'=>false ]);?>
        </div>

        <div class="form-group">
        <?=  $this->Form->button('Import',['class'=>'btn btn-success']); ?>
        </div>
        <?= $this->Form->end(); ?>
    </div>
</div>
</div>
</div>
<div class="row leads">
<div class="col-lg-12">
<div class="card">
    <div class="card-header">
        <strong class="card-title"><?= __('Already Exits Leads') ?></strong>      
         
    </div>
    <div class="card-body table-responsive">
    <table id="bootstrap-data-table-export" class="table table-striped table-bordered" >
    <thead>
    <tr>
        
        <th scope="col"><?= h('Contractor Name') ?></th>
       
    </tr>
    </thead>
    <tbody>
    <?php  
    foreach ($list2 as $list): ?>
    <tr><td><?= $list ?></td></tr>
   <?php endforeach; ?>
    </tbody>
    </table>
    </div>
</div>
</div>
</div>
