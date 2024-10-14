<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Contractor[]|\Cake\Collection\CollectionInterface $contractors
 */
use Cake\Core\Configure;
?>
<div class="row contractors">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Contractors') ?></strong>
		<span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller'=>'Contractors', 'action'=>'add'],['class'=>'btn btn-success btn-sm']) ?> </span>
        <span class="pull-right"><?= $this->Html->link(__('Export to Excel'), ['controller' => 'Contractors', 'action' => 'index/excel'],['class'=>'mr-2']) ?> </span>
		<span class="pull-right"><?= $this->Html->link(__('Export to CSV'), ['controller' => 'Contractors', 'action' => 'index/csv'],['class'=>'mr-2']) ?> </span>
		<!--<span class="pull-right"><?= $this->Html->link(__('File Upload'), ['controller'=>'Contractors', 'action'=>'importUsers'], ['class'=>'btn btn-success btn-sm mr-2']) ?></span>-->
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table" class="table table-striped table-bordered" data-order="[[ 2, &quot;asc&quot; ]]">
	<thead>
	<tr>
		<th scope="col"><?= h('Contractor Name') ?></th>	
		<th scope="col"><?= h('No. of Clients') ?></th>
		<th scope="col"><?= h('Active') ?></th>
		<th scope="col"><?= h('Paid') ?></th>
		<th scope="col"><?= h('Waiting On') ?></th>		
		<th scope="col"><?= h('Data Submit') ?></th>
		<th scope="col"><?= h('Data Read') ?></th>
		<th scope="col"><?= h('Discount') ?></th>
		<!--<th scope="col"><?= h('Force Change') ?></th>-->
		<th scope="col"><?= h('Registration Date') ?></th>
		<th scope="col"><?= h('Payment Date') ?></th>
		<th scope="col"><?= h('Last Update') ?></th>
		<th scope="col" class="actions"><?= __('Actions') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php $addr = array(); ?>
	<?php foreach ($contractors as $contractor): 
    $getClients = $this->User->getClients($contractor->id);
    $clients = [];
    foreach ($getClients as $cid) {
    	if($cid != 4){
        $clients[] = $allClients[$cid];
        }
    }
	?>	
	<tr>
		<td><?= $this->Html->link($contractor->company_name, ['controller'=>'Contractors', 'action'=>'dashboard', $contractor->id]); ?></td>		
		<td><a href="#" data-placement="top" title="<?= implode(',', $clients) ?>"><?= count($clients); ?></a></td>
		<td>
            <span style="display:none;"><?= $contractor->user->active ? '1' : '0' ?></span>
			<?= $this->Form->create($contractor,['class'=>'saveAjax', 'data-responce'=>'.alert-wrap']) ?>
			<?php echo $this->Form->control('user.active', ['required'=>false, 'label'=>false, 'class'=>'ajaxClick']); ?>
			<?php echo $this->Form->control('user.username', ['type'=>'hidden']); ?>
			<?php echo $this->Form->control('user.id', ['type'=>'hidden']); ?>
			<?= $this->Form->end() ?>
		</td>
		<td><?php if($contractor->payment_status) {  if($clients){ echo  'Yes';  }else{ echo 'No'; } } ?>
		<?php //$contractor->payment_status ? __('Yes') : __('No'); ?></td>
		<!--<td>
            <span style="display:none;"><?= $contractor->payment_status ? '1' : '0' ?></span>
			<?= $this->Form->create($contractor,['class'=>'saveAjax', 'data-responce'=>'.alert-wrap']) ?>
			<?php echo $this->Form->control('payment_status', ['required'=>false, 'label'=>false, 'class'=>'ajaxClick']); ?>
			<?php echo $this->Form->control('user.username', ['type'=>'hidden']); ?>
			<?php echo $this->Form->control('user.id', ['type'=>'hidden']); ?>
			<?= $this->Form->end() ?>
		</td>-->
		<td><?= $contractor->waiting_on=='CanQualify' && $activeUser['role_id'] == SUPER_ADMIN ? $this->Html->link(__($contractor->waiting_on), ['controller'=>'OverallIcons', 'action'=>'force-change-admin', 0, $contractor->id, 1], []) : h($contractor->waiting_on); ?></td>
		<td><?= $contractor->data_submit ? 'Submitted' : ''; ?></td>
		<td><?= $contractor->data_submit ? $contractor->data_read ? 'Yes' : 'No' : ''; ?></td>
		<td><?= $this->Html->link('Generate Discount', ['controller'=>'PaymentDiscounts', 'action'=>'generate_discount', $contractor->id]); ?></td>

		<!--<td><?= $this->Html->link(__('Generate Discount'), ['controller'=>'PaymentDiscounts', 'action'=>'generate_discount',$contractor->id], ['class'=>'ajaxmodal pull-right', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal', 'escape'=>false, 'title'=>'Generate Discount']);?></td>-->
		<!--<td>
		<?php //echo isset($allowForceChange) ? $this->Html->link(__('Force Icon'), ['controller'=>'OverallIcons', 'action'=>'force-change-admin', 0, $contractor->id], []) : '' ?></td>-->
        <!--  <?php $myDate = date('Y/m/d', strtotime($contractor['created'])); ?>-->
        <td><?= date('Y/m/d', strtotime($contractor['created'])) ?></td>
		<td><?= !empty($contractor->payments) ? date('Y/m/d', strtotime($contractor->payments[0]->created))  : '' ?></td>		
        <td><?= date('Y/m/d', strtotime($contractor->modified )) ?></td>
		<td class="actions">
			<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action'=>'view', $contractor->id],['escape'=>false, 'title'=>'View']) ?>
			<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action'=>'edit', $contractor->id],['escape'=>false, 'title'=>'Edit']) ?>
			<?php $contractor->longitude==null && $contractor->latitude==null ? $locCls='noLocation' : $locCls='updateLocation'; ?>
			<?= $this->Html->link('<i class="fa fa-location-arrow"></i>', ['action'=>'update-location', $contractor->id],['escape'=>false, 'title'=>'Update Location', 'class'=>$locCls]) ?>
			<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
			<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action'=>'delete', $contractor->id], ['escape'=>false, 'title'=>'Delete', 'confirm'=>__('Are you sure you want to delete # {0}?', $contractor->id)]) ?>
			<?php } ?>
		</td>
	</tr>
	<?php
		$stateNm = $contractor->has('state') ? $contractor->state->name.' ' : '';
		$countryNm = $contractor->has('country') ? $contractor->country->name : '';

		$addrInfo[0] = $contractor->addressline_1.' '.$contractor->addressline_2.' '.$contractor->city.' '.$stateNm.$countryNm;
		$addrInfo[1] = $contractor->latitude;
		$addrInfo[2] = $contractor->longitude;
		$addrInfo[3] = $contractor->company_name;
		array_push($addr, $addrInfo);
	?>
	<?php endforeach; ?>
	</tbody>
	</table>
	</div>
</div>
</div>
<?php $show_map = Configure::read('show_map'); 
if($show_map == true) { 
?>
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Contractors Location') ?></strong>
	</div>
	<div class="card-body">
		<script>
			var contractor_markers = <?php echo json_encode($addr) ?>;
		</script>
		<div class="map" id="map" style="width: 100%;"></div>
	</div>
</div>
</div>
<?php } ?>
</div>

<div class="modal fade" id="scrollmodal" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="scrollmodalLabel"></h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		</div>
		<div class="modal-body">
		</div>
	</div>
	</div>
</div>
