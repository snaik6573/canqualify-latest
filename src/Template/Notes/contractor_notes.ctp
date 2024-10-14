<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Note[]|\Cake\Collection\CollectionInterface $notes
 */
?>
<div class="row notes">
<div class="col-lg-12">
<div class="card">
	<div class="card-header clearfix">
		<strong class="pull-left card-title"><?= __('Notes') ?></strong>

		<?php if( in_array($activeUser['role_id'], array(SUPER_ADMIN, ADMIN, CLIENT, CLIENT_ADMIN, CR))) { ?>
		<span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller' => 'Notes', 'action' => 'add'],['class'=>'btn btn-success btn-sm']) ?> </span>
		<?php }
		if (!in_array($activeUser['role_id'], array(CLIENT, CLIENT_BASIC, CLIENT_VIEW, CLIENT_ADMIN))){
		    ?>
            <span class="pull-right"><?= $this->Html->link(__('Completed Follow Ups'), ['controller' => 'Notes', 'action' => 'ContractorNotes', 1],['class'=>'btn btn-default btn-sm']) ?></span>
        <?php
        } ?>
	</div>
	<div class="card-body">
	<table id="bootstrap-data-table" class="table table-striped table-bordered" data-order="[[ 2, &quot;desc&quot; ]]">
	<thead>
	<tr>
		<th scope="col"><?= h('Subject') ?></th>
		<th scope="col"><?= h('Note By') ?></th>
		<th scope="col"><?= h('Created') ?></th>
		<th scope="col" class="actions"><?= h('Actions') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($notes as $note): ?>
	<tr>
		<td><?= h($note->subject) ?></td>
		<td>
            <?php
                echo !empty($note->user->first_name) ? $note->user->first_name : "";
                echo !empty($note->user->last_name) ? " ".$note->user->last_name : "";
            ?>
            <?php if(!empty($note->user->client_user) && $note->user->client_user['client']) {
			echo '- '. $note->user->client_user->client->company_name;
		} elseif(!empty($note->user->customer_representative) && $note->user->has('customer_representative')) {
			echo '<b>- CR</b>';
		} else {
			if($note->role_id==SUPER_ADMIN || $note->role_id==ADMIN) { echo '- CanQualify'; }
		}
		$createdBy = "";
		if(isset($users[$note->created_by])) { 
			$createdBy = $users[$note->created_by]; 
		}
		?></td>
		<td><?= $note->created." "?><span data-placement="top" title="<?= $createdBy ?>"><?= ($createdBy == "System") ? $createdBy : substr($createdBy,0,9)."..."; ?></span></td>

		<!-- ?></td>
		<td><?= $note->created ?></td> -->
		<td class="actions">
		<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $note->id],['escape'=>false, 'title' => 'View']) ?>
		<?php 
		if($note->created_by == $activeUser['id'] || $activeUser['role_id'] == SUPER_ADMIN) { ?>
			<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $note->id],['escape'=>false, 'title' => 'Edit']) ?>
			<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $note->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $note->id)]) ?>
		<?php } ?>
		</td>
	</tr>
	<?php endforeach; ?>
    <?php foreach ($overallicon_notes as $overallicon_note):
        if(!empty($overallicon_note['notes'])) { ?>
	<tr>
		<td><?php
        if($overallicon_note->review) {
			echo '<b>Review For : </b>'.$overallicon_note->client->company_name;
		} else {
		    echo '<b>Force Icon : </b>'. $overallicon_note->client->company_name;
		}
		?>
        </td>
		<td>
            <?php
            echo !empty($overallicon_note->user->first_name) ? $overallicon_note->user->first_name : "";
            echo !empty($overallicon_note->user->last_name) ? " ".$overallicon_note->user->last_name : "";
            ?>

            <?php
        if($overallicon_note->review) {
			echo '-  CanQualify';
		} else {
		    echo '- '.$overallicon_note->client->company_name;
		}
		// $forced_by = "";
		// if(isset($users[$overallicon_note->created_by])) { 
		// 	$forced_by = $users[$overallicon_note->created_by]; 
		// }
		$createdBy = "";
		if(isset($users[$overallicon_note->created_by])) { 
			$createdBy = $users[$overallicon_note->created_by]; 
		}
		?></td>
		<!-- <td><?= $overallicon_note->created." "?><span data-placement="top" title="<?= $forced_by ?>"><?= ($forced_by == "System") ? $forced_by : substr($forced_by,0,9)."..."; ?></span></td> -->
		<td><?= $overallicon_note->created." "?><span data-placement="top" title="<?= $createdBy ?>"><?= ($createdBy == "System") ? $createdBy : substr($createdBy,0,9)."..."; ?></span></td>
		<td class="actions">
		<?= $this->Html->link('<i class="fa fa-eye"></i>', ['controller'=>'OverallIcons','action' => 'view', $overallicon_note->id],['escape'=>false, 'title' => 'View']) ?>
		<?php 
		if($overallicon_note->created_by == $activeUser['id'] || $activeUser['role_id'] == SUPER_ADMIN) { ?>           
			<?= $this->Html->link(__('<i class="fa fa-pencil"></i>'), ['controller'=>'OverallIcons','action' => 'edit', $overallicon_note->id,$overallicon_note->contractor_id],['class'=>'ajaxmodal', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal','escape'=>false]) ?> 			
		<?php }  ?>
		</td>
	</tr>
	<?php } endforeach; ?>
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
		<h5 class="modal-title">Force Change Icon Status</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="modal-body">
	</div>
</div>
</div>
</div>
