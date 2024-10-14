<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContractorSite $contractorSite
 */
?>
<?php if(!isset($ajaxtrue)) { ?>
<div class="row contractorSites">
<div class="col-lg-6">
<div class="card">
    <div class="card-header">
        <strong>Add Employee</strong> Site
    </div>
    <div class="card-body card-block">
    <?= $this->Form->create($employeeSite) ?>
    <div class="row form-group">    
    <div class="col-lg-12">
    <label for="site_id">Select Sites</label>
            <?= $this->Form->select('site_id', ['Select Sites' => $contractorSites], ['value' => $selectedSites, 'multiple' => true, 'class'=>'form-control selectwithcheckbox'] ); ?>
    </div>      
    </div>
    <div class="clearfix"></div>
    <div class="form-actions form-group">
       <?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
    </div>
    <?= $this->Form->end() ?>
    </div>
</div>
</div>



<div class="col-lg-12">
<div class="card">
    <div class="card-header">
        <strong>Your </strong>  Employees and Sites
    </div>
    <div class="card-body card-block">
    
    <table id="bootstrap-data-table" class="table table-striped table-bordered">
    <thead>
    <tr>
        <th scope="col"><?= __('Employee Name') ?></th>
        <!-- <th scope="col"><?= __('Region') ?></th> -->
        <th scope="col"><?= __('Site') ?></th>
    </tr>
    </thead>
    <tbody>
    <?php   
    foreach ($selectedSites as $csite):     
    if(!empty($csite->site)){
    ?>
    <tr>
        <td><?= h($csite['employee']['pri_contact_fn']." ".$csite['employee']['pri_contact_ln']) ?></td>
        <td><?= h($csite->site->name) ?></td>
    </tr>
    <?php  } endforeach; ?>
    </tbody>
    </table>
    
    </div>
</div>
</div>

</div><!-- .employeeSites -->
<?php } ?>
