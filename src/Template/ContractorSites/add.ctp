<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContractorSite $contractorSite
 */

?>
<div class="row contractorSites">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<strong>Add Contractor</strong> Site
	</div>
	<div class="card-body card-block contractorSites" style="min-height:250px;">

	<?= $this->Form->create($contractorSite) ?>

	<div class="row form-group">	
	<div class="col-lg-12">
    <select multiple="multiple" class="form-control siteAddchk" name="site_id[]">
    <?php 
        foreach($clientSites as $key=>$val) {
            echo '<optgroup label="'.$key.'">';
            foreach($val as $ky=>$vl){
                $selected = '';
                //if(in_array($ky, $sites)) {$selected = 'selected="selected"';}
                echo '<option value="'.$ky.'" '.$selected.'>'.$vl.'</option>';
            }
            echo '</optgroup>';
        }
    ?>
    </select>
	</div>		
	</div>

	<div class="form-actions form-group">
		<?= $this->Form->control('contractor_id', ['type'=>'hidden', 'value' => $contractor_id]) ?>
		<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-success btn-sm']); ?>			
	</div>	
	<?= $this->Form->end() ?>
	</div>
</div>
</div>
</div>

<div class="row">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong>Your </strong>  Clients and Sites
	</div>
	<div class="card-body card-block">
	<?php if (!empty($contractorSites->contractor_sites)): ?>
	<table id="bootstrap-data-table" class="table table-striped table-bordered">
	<thead>
	<tr>
		<th scope="col"><?= __('Client Name') ?></th>
		<th scope="col"><?= __('Region') ?></th>
		<th scope="col"><?= __('Site') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php 	
	foreach ($contractorSites->contractor_sites as $csite): 	
	if(!empty($csite->site)){
	?>
	<tr>
		<td><?= h($csite->site->client->company_name) ?></td>
		<td><?= $csite->site->has('region') ? h($csite->site->region->name) : '' ?></td>			
		<td><?= h($csite->site->name) ?></td>
	</tr>
	<?php  } endforeach; ?>
	</tbody>
	</table>
	<?php endif; ?>
	</div>
</div>
</div>
</div><!-- .contractorSites -->