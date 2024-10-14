<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Client[]|\Cake\Collection\CollectionInterface $clients
 */ 
use Cake\Core\Configure;
$iconList = Configure::read('icons'); //, array('0'=>'Grey','1'=>'Red','2'=>'Yellow','3'=>'Green')
$users = array(CLIENT_VIEW, CLIENT_BASIC);
?>
<div class="row clients">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Subscription Expired Suppliers') ?></strong>		
		<span class="pull-right"><?= $this->Html->link(__('Export to Excel'), ['controller' => 'Contractors', 'action' => 'subscriptionsEndReport/0/excel/'.$site_index.'/'.$icon_index],['class'=>'mr-2']) ?> </span>
		<span class="pull-right"><?= $this->Html->link(__('Export to CSV'), ['controller' => 'Contractors', 'action' => 'subscriptionsEndReport/0/csv/'.$site_index.'/'.$icon_index],['class'=>'mr-2']) ?>&nbsp;&nbsp;|&nbsp;&nbsp;</span>

	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table" class="table table-striped table-bordered" data-order="[[ 1, &quot;asc&quot; ]]">
	<thead>
	<tr>
		<th scope="col"><?= h('Status') ?></th>
		<th scope="col"><?= h('Contractor Name') ?></th>
		<th scope="col"><?= h('Active') ?></th>
		<th scope="col"><?= h('Primary Contact') ?></th>
		<th scope="col"><?= h('Phone') ?></th>
		<th scope="col"><?= h('Email') ?></th>
		<th scope="col"><?= h('Safety') ?></th>
		<?php if($hasEmployeeQual) { ?>
			<th scope="col"><?= h('Employee Qual') ?></th>
		<?php } ?>
		<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
			<th scope="col"><?= h('Paid') ?></th>
		<?php } ?>
		<th scope="col"><?= h('Member Since') ?></th>
		<th scope="col"><?= h('Subscription End Date') ?></th>
		<?php // if (!in_array($activeUser['role_id'], $users)) { ?>
		<!-- <th scope="col" class="noExport"><?= h('Actions') ?></th> -->
		<?php //}?>
		<th scope="col"><?= h('Subscription') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php
	foreach ($contList as $contractor):
	//	if(empty($contractor['overall_icons']) || empty($contractor['contractor_sites'])) {
	/*if(empty($contractor['overall_icons'])) {
		continue;
	}*/
	if($icon_index!=null && empty($contractor['overall_icons'])) {
		continue;
	}
	if($site_index!=null && empty($contractor['contractor_sites'])) {
		continue;
	}
	if(isset($icon) && $contractor['overall_icons'][0]->icon != $icon) {
		continue;
	}
	?>
	<tr>
		<?php
		$iconStatus = ''; 
		/*$getIcon = $this->Safetyreport->getIcon($client_id, $contractor->id);
		if (!empty($getIcon)) {
			$iconStatus = '<span style="display:none;">'.$getIcon[0]->icon.' - '.$iconList[$getIcon[0]->icon].'</span><i class="fa fa-circle color-'.$getIcon[0]->icon.'"></i>';
		}*/
		if(!empty($contractor['overall_icons'])) {
			$iconStatus = '<span style="display:none;">'.$contractor['overall_icons'][0]->icon.' - '.$iconList[$contractor['overall_icons'][0]->icon].'</span><i class="fa fa-circle color-'.$contractor['overall_icons'][0]->icon.'"></i><span style="display:block">'.$iconList[$contractor['overall_icons'][0]->icon].'</span>';
		}
		?>
		<td class="text-center"><?= $iconStatus; ?></td>
		<td><?= $this->Html->link($contractor->company_name, ['controller' => 'Contractors','action' => 'dashboard', $contractor->id],['escape'=>false, 'title' => 'View']) ?></td>
		<td><?= h($contractor->user->active) == 1 ? 'Yes' : ''; ?></td>
		<td><?= h($contractor->pri_contact_fn.' '.$contractor->pri_contact_ln); ?></td>
		<td><?= h($contractor->pri_contact_pn) ?></td>
		<td><?= h($contractor->user->username); ?></td>
		<td class="text-center"><?= $this->Html->link(__('<i class="fa fa-eye"></i>'), ['controller'=>'ContractorAnswers', 'action'=>'safety_report/', 0, $contractor->id], ['class'=>'ajaxmodal', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal', 'escape'=>false, 'title'=>'Safety Report']) ?></td>
		<?php $services = $this->Category->getServices($contractor->id);
		 $sites = $this->User->getContractorSites($contractor->id);
	 	 $client = $this->User->getClients($contractor->id);
	 	$visible = false;
	 	if(in_array('EmployeeQual', $services)) {
	 	 if($activeUser['client_id']  == 3){
	 	  	if(in_array(7, $sites) && in_array(3, $client)){ 
						$visible = true;
					}else{
						$visible = false;
				}
			}else{
				$visible = true;
			}
		} ?>		
		<?php if($hasEmployeeQual) { ?>
		<td class="text-center">
		<?php if($visible){   ?>
		<?= $this->Html->link(__('<i class="fa fa-eye"></i>'), ['controller'=>'Employees', 'action'=>'index/', 0, $contractor->id], ['escape'=>false, 'title'=>'Employees']) ?>
		<?php }else{ ?>
			<?php echo "Not paid for this Service."; ?>
		<?php } ?>
		</td>
		<?php } ?>
		<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
		<td><?= $contractor->payment_status ? __('Yes') : __('No'); ?></td>
		<?php } ?>
		<td><?= !empty($contractor->payments) ? date('m/d/Y', strtotime($contractor->payments[0]->created))  : '' ?></td>
		<?php //if (!in_array($activeUser['role_id'], $users)) { ?>
		<?php //if($activeUser['role_id'] == SUPER_ADMIN) { 
		/*	echo $this->Form->postLink(__('Un-asign'), ['controller'=>'ContractorSites','action'=>'unasign', $contractor->id], ['class'=>'', 'confirm'=>__('Are you sure you want to un-asign # {0}?', $contractor->company_name)]).' | ';
		}
		if(isset($allowForceChange)) {
			echo $this->Html->link(__('Force Icon'), ['controller'=>'OverallIcons', 'action'=>'force-change', $client_id, $contractor->id], ['class'=>'ajaxmodal', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal2']); 
		}*/ ?>
		<td><?= !empty($contractor->subscription_date) ? date('m/d/Y', strtotime($contractor->subscription_date))  : '' ?></td>
		<td><?php echo "Expired"; ?></td>
		<?php //}?>
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	</div>
</div>
</div>
</div>


<div class="modal fade" id="scrollmodal" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-title">Safety Report</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="modal-body">
	</div>
</div>
</div>
</div>

<div class="modal fade" id="scrollmodal1" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-title">Review</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="modal-body">
	</div>
</div>
</div>
</div>

<div class="modal fade" id="scrollmodal2" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-title">Force Change Icon Status</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="modal-body">
	</div>
</div>
</div>
</div>
