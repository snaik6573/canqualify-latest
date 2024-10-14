<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Client[]|\Cake\Collection\CollectionInterface $clients
 */ 
?>
<div class="row clients">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Icon Change Report') ?></strong>
		<span class="pull-right"><?= $this->Html->link(__('Export to Excel'), ['controller' => 'OverallIcons', 'action' => 'iconchange_report/excel'],['class'=>'mr-2']) ?> </span>
		<span class="pull-right"><?= $this->Html->link(__('Export to CSV'), ['controller' => 'OverallIcons', 'action' => 'iconchange_report/csv'],['class'=>'mr-2']) ?>&nbsp;&nbsp;|&nbsp;&nbsp;</span>
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table" class="table table-striped table-bordered" data-order="[[ 4, &quot;desc&quot; ]]" >
	<thead>
	<tr>
		<th scope="col" width="7%"><?= h('From Icon') ?></th>
		<th scope="col" width="7%"><?= h('To Icon') ?></th>
		<th scope="col" width="26%"><?= h('Contractor / Supplier') ?></th>
		<th scope="col" width="30%"><?= h('Notes') ?></th>
		<th scope="col"><?= h('Generated On') ?></th>
		<th scope="col"><?= h('Type') ?></th>	
	</tr>
	</thead>
	<tbody>
	<?php 
	$icon_from_deault = '<span style="display:none;">0</span><i class="fa fa-circle color-0"></i>';

    foreach ($contList as $contractor):
    foreach ($contractor->overall_icons as $overallIcon): ?>
	<tr>
		<?php 
		$iconMsg ="";
		if(!empty($overallIcon)) {		
		if($overallIcon->review == 1 || $overallIcon->is_forced == 1 ){
			foreach($overallIcon->icons as $icn) { 
			if(!empty($icn->benchmark_type_id) && ($icn->icon == 1 || $icn->icon == 2)){ 
			$iconMsg .='<div class="col-sm-12">			
			  	 <label class="col-sm-10">'. $icn->benchmark_type["name"].' Status</label>				
				<div class="col-sm-2"><i class="fa fa-circle color-'.$icn->icon .'"></i></div>
				</div>';	
			}	}							
			}
		}

		$forced_by = 'System';
		$iconFromStatus = $overallIcon->icon_from!=null ? '<span style="display:none;">'.$overallIcon->icon_from.'</span><i class="fa fa-circle color-'.$overallIcon->icon_from.'"></i>' :  $icon_from_deault;
        $iconStatus = '<span style="display:none;">'.$overallIcon->icon.'</span><i class="fa fa-circle color-'.$overallIcon->icon.'"></i>';
		$notes = $overallIcon->notes;
		$created = $overallIcon->created;
		if($overallIcon->is_forced && isset($users[$overallIcon->created_by])) { 
			$forced_by = $users[$overallIcon->created_by]; 
		}

		?>
		<td class="text-center"><?= $iconFromStatus; ?></td>
		<?php if($overallIcon->client_id == 6) { ?>
		<td class="text-center"><a href="javascript:void(0);" data-html="true" title="" data-toggle="popover" data-content="<?= htmlentities($iconMsg); ?>" style="margin-left: 15px;"><?= $iconStatus; ?></a></td>
		<?php } else { ?>
		<td class="text-center"><?= $iconStatus; ?></td>
		<?php } ?>
		<td><?= $this->Html->link($contractor->company_name, ['controller'=>'Contractors', 'action'=>'dashboard', $contractor->id]); ?></td>
		<!-- <td><?= html_entity_decode($notes); ?></td> -->
		<td><?php  
			$notes = $overallIcon->notes;
			$string= strip_tags($notes);			
			if (strlen($string) > 30) {
			$trimstring = substr($string, 0,30).$this->Html->link(__('  Read More..'), ['controller'=>'OverallIcons', 'action'=>'iconNotes',$overallIcon->id], ['class'=>'ajaxmodal', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal', 'escape'=>false, 'title'=>'Payment']);
			} else {
			$trimstring = $string;
			}
			echo $trimstring;
			?>		
		</td>
		<td data-order="[[<?= !empty($overallIcon->created) ? date('Ymd', strtotime($overallIcon->created))  : '' ?>, &quot;asc&quot;]]"><?= h($created). ' - ' ?><span data-placement="top" title="<?= $forced_by ?>"><?= ($forced_by == "System") ? $forced_by : substr($forced_by,0,9)."..."; ?></span></td>
        <td><?php if($overallIcon->review){
            echo h('Review');
        }else if($overallIcon->is_forced) {
            echo  h('Forced Icon');
        }else{
            echo h('System');
        } ?></td>
	</tr>
	<?php
    endforeach;
    endforeach;
	/*foreach ($contList as $contractor): ?>
	<tr>
		<?php
		$iconFromStatus = '';
		$iconStatus = '';
		$notes = '';
		$created = '';
		$forced_by = 'System';
		$getIcon = $this->Safetyreport->getIcon($client_id, $contractor->id);
		if (!empty($getIcon)) {
			$iconFromStatus = $getIcon[0]->icon_from!='' ? '<span style="display:none;">'.$getIcon[0]->icon_from.'</span><i class="fa fa-circle color-'.$getIcon[0]->icon_from.'"></i>' : $iconFrom;
			$iconStatus = '<span style="display:none;">'.$getIcon[0]->icon.'</span><i class="fa fa-circle color-'.$getIcon[0]->icon.'"></i>';
			$notes = $getIcon[0]->notes;
			$created = $getIcon[0]->created;
			if($getIcon[0]->is_forced && isset($users[$getIcon[0]->created_by])) { 
				$forced_by = $users[$getIcon[0]->created_by]; 
			}
		}
		?>
		<td class="text-center"><?= $iconFromStatus; ?></td>
		<td class="text-center"><?= $iconStatus; ?></td>
		<td><?= $this->Html->link($contractor->company_name, ['controller'=>'Contractors', 'action'=>'dashboard', $contractor->id]); ?></td>
		<td><?= html_entity_decode($notes); ?></td>
		<td><?= h($created) . ' - '.$forced_by; ?></td>
		<!--<td><?= $forced_by; ?></td>-->
	</tr>
	<?php endforeach;*/ ?>
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
			<h5 class="modal-title" id="scrollmodalLabel"></h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		</div>
		<div class="modal-body">
		</div>
	</div>
	</div>
</div>
